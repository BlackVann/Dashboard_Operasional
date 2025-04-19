<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\stok_toko;
use App\Models\request as RequestModel;
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
   public function pengiriman($time){
      $data = RequestModel::where('time_request',$time)->get();
      $names = collect($data)->pluck('name')->all();
      $tambahstok = stok_toko::whereIn('name', $names)->get()->keyBy('name');
      $status='belum';
      if(!empty($data)){
         foreach ($data as $item){
            if($item->amount_request== $item->amount_received + $item->amount_deliver)$status='done';
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
      }
      return redirect()->back();
   }
}
