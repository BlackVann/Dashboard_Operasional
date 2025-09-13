<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\history_in;
use App\Models\stok_toko;
use App\Models\history_stok;
use App\Models\request as RequestModel;
use App\Models\daily;
class Pengirim extends Controller
{  
   public function home(){

    return view('pengirim.home');
   }
   public function task(){
      $data = RequestModel::where('deliver_status','=',1)->get();
      $grup=$data->groupBy('time_request');
    return view('pengirim.task', ['data'=>$grup]);
   }
   public function pengiriman(Request $request,$time){
      $stok_toko= new stok_toko();
      $data = RequestModel::where('time_request',$time)->get();
      $names = collect($data)->pluck('name')->all();
      $tambahstok = stok_toko::whereIn('name', $names)->get()->keyBy('name');
      $status='belum';
      if(!empty($data)){
         foreach ($data as $item){
            if($item->amount_request== $item->amount_received + $item->amount_deliver)$status='done';
            history_stok::create([
                'produk'=> $item->name,
                'date'=> Carbon::now('Asia/Jakarta'),
                 'code'=> "IN".Carbon::now('Asia/Jakarta')->format('YmdHis'),
                 'in'=> $item->amount_deliver,
                 'out'=>0,
                 'last_item'=> $stok_toko->stokakhir($item->name,$request->location)+$item->amount_deliver,
                 'location'=>$request->location
            ]);
            history_in::create([
               'produk'=> $item->name,  
               'time'=> Carbon::now('Asia/Jakarta'),
               'code'=> "IN".Carbon::now('Asia/Jakarta')->format('YmdHis'),
               'in'=> $item->amount_deliver,
               'location'=>$request->location]    );

            $item->amount_status=$status;
            $item->amount_received += $item->amount_deliver;
            $item->deliver_status=0;
            $item->time_accepted=Carbon::now('Asia/Jakarta');
           
           $tambah=$tambahstok[$item->name];
           $tambah->amount += $item->amount_deliver;
           $item->amount_deliver=0;
           $tambah->save();
           $item->save();

      }
      $accept= daily::where("name","accept")->first();
      $accept->count+=1;
      $accept->save();

      return redirect()->back();
   }
}}
