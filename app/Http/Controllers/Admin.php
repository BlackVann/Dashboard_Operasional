<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\stok_toko;
use App\Models\request as RequestModel;
use Carbon\Carbon;
class Admin extends Controller
{
    public function home(){//pemberitahuan stok menipis
        
        
        return view ('admin_toko.home');
    }
    public function history(){//hubungan antara gudang dan pengirim
        $history=RequestModel::get()->toArray();
        return view('admin_toko.history',['history'=>$history]);
    }
    public function stok(){//menampilkan semua jumlah stok
        $stok_toko=new stok_toko();
        $stok_menipis = $stok_toko->where('amount', '<', 5)->get();
        $stok=$stok_toko->get();
        return view('admin_toko.stok',['stok' => $stok,'stoks'=>$stok_menipis]);
    }
    public function request(){//
        $nama=stok_toko::select('name')->get()->toArray();
        return view('admin_toko.request',['nama'=>$nama ]);
    }
public function add_request(Request $request){//menambahkan data ke tabel request dan validasi


$name = stok_toko::select('name')->get()->pluck('name')->toArray();
$request->validate([ 'request.*.nama' => [Rule::in($name)],'request.*.jumlah'=>'numeric|min:1'], [
    'request.*.nama.in' => 'Produk tidak terdaftar',
    'request.*.jumlah.min' => 'Jumlah tidak boleh 0'
]);
$data=$request->all();
foreach ($data['request'] as $item) {
    RequestModel::create([
        'name' => $item['nama'],
        'amount_request' => $item['jumlah'],
        'amount_received' =>0,
        'time_request' => Carbon::now('Asia/Jakarta'),
        'amount_status'=> "belum",
        'deliver_status'=> 0,
        'amount_deliver'=>0
    ]);
    
}

  return redirect()->back();  }
    
}
