<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\stok_toko;
use App\Models\request as RequestModel;
class Gudang extends Controller
{
    public function home(){
        return view('staff_gudang.home');
    }
    public function gudang(){//halaman gudang untuk melihat pengiriman yang harus dilakukan
        $data = RequestModel::where('amount_status', '!=', 'done')->where('deliver_status','-=',1)->get();
        $grup=$data->groupBy('time_request');
       
        return view('staff_gudang.deliver',['data'=> $grup]);
    }

    public function pengiriman($time){//time diambil dari route
        $data='';
        $status='';
        $cek = RequestModel::where('time_request', $time)->where('amount_status','!=', 'done')->where('deliver_status','!=',1)->get()->toArray();//mencari berdasarkan parameter time
        
        if(empty($cek)){  $status='history';//jika data $cek tidak ditemukan $data menampilkan semua data( history )
            $data = RequestModel::select(
                'time_request',
                DB::raw("GROUP_CONCAT(CONCAT('(', name, ' x ', amount_received, ')') SEPARATOR ', ') as received"),
                DB::raw("GROUP_CONCAT(CONCAT('(', name, ' x ', amount_deliver, ')') SEPARATOR ', ') as deliver"),
                DB::raw("GROUP_CONCAT(amount_status) as status")
            )->groupBy('time_request')->get();
        }
        else{
            $data=$cek; //jika ditemukan $data berisi data pada $cek
        }
        return view('staff_gudang.pengiriman',['data'=>$data,'status'=>$status]);
    }

    public function ubah_pengiriman($time, Request $request){//melakukan update
        $request->validate(['deliver.*.jumlah'=>'numeric|min:0'],[//validasi terlebih dahulu
            'deliver.*.jumlah.min' => 'Jumlah tidak boleh 0']);
            $data = RequestModel::where('time_request', $time)->where('amount_status', '!=', 'done')->where('deliver_status','!=',1)->get();
            
            $json = json_decode($data, true); 

            $amount_request = array_column($json, 'amount_request');
            $amount_received= array_column($json, 'amount_received');
            $amount_deliver= array_column($json, 'amount_deliver');
         $jumlah_kirim=$request->deliver;   
         $id=0;
         $nama='';
         $max=0;
         $sent=0;
        
         foreach($jumlah_kirim as $item){
            if($item['jumlah']> $amount_request[$item['id']]- $amount_received[$item['id']] + $amount_deliver[$item['id']] ){//validasi sebelum dikirm
                $id = $item['id'] +1;
                $nama = $item['name'];
                $max=$item['jumlah'];
                $sent=$amount_request[$item['id']] - $amount_received[$item['id']] ;
                break;
            }
            }
            $kapasitas='Pesanan yang diperlukan '. $sent  . ' dikirim '. $max  ;//pesan
            
        if($id!=0){ return redirect()->back()->withErrors(['exceeds demand' => 'Pengiriman '. $nama .' pada baris ke '.$id  . ' melebihi pesanan. '. $kapasitas  ]);}
        else{//jika validasi berhasil
         $req = $request->all();
         $deliveries = $req['deliver'];
         $names = collect($deliveries)->pluck('name')->all();
         $tambahstok = stok_toko::whereIn('name', $names)->get()->keyBy('name');
         $produkList = RequestModel::where('time_request', $time)->whereIn('name', $names)->get()->keyBy('name');// membuat array dapat diakses dengan name dimana awalnya [{data...},{data...}] sekarang menjadi { name:{},name:{}}
         foreach ($deliveries as $item) {
            
                $produk = $produkList[$item['name']];
                $produk->amount_deliver = $item['jumlah'];
                $produk->deliver_status= 1;
                
                $tambah=$tambahstok[$item['name']];
                $produk->save();
                $tambah->save();

        }
        return redirect()->back();
        
    }

    }
}
