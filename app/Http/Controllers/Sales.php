<?php

namespace App\Http\Controllers;
use App\Models\sell;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\stok_toko;
use Illuminate\Http\Request;
use Carbon\Carbon;
class Sales extends Controller
{
    public function sales(){//home
        return view('sales.sales');
    }
    public function sell(){//halaman penjualanan
        return view('sales.sell',['nama'=> stok_toko::select('name')->where('amount', '>', 0 )->get()]);
    }
    public function history(){
        $history=sell::all()->toArray();
        $jumlah=sell::sum('price');
        $total=number_format($jumlah, 0, ',', '.');
        return view('sales.history',['history'=>$history,'total'=>$total]);
    }
    public function sells(Request $request){//validasi untuk menambahkan data ke history sales dan mengurangi stok toko
        $stok_toko= new stok_toko();
        $name = stok_toko::where('amount', '>', 0)->pluck('name')->toArray(); 
      $request->validate([ 'produk.*.nama' => [Rule::in($name)],'produk.*.jumlah'=>'numeric|min:1'], [
        'produk.*.nama.in' => 'Produk tidak terdaftar',
        'produk.*.jumlah.min' => 'Jumlah tidak boleh 0'
    ]);
      $data=$request->all();
      $id=0;
        foreach ($data['produk'] as $item) {
           
            if( $stok_toko->jumlahstok($item['nama'],$item['jumlah'])){
$id= $item['id'];
            sell::create([//memasukan data ke history sales
                'name' => $item['nama'],
                'amount' => $item['jumlah'],
                'time' => Carbon::now('Asia/Jakarta'),
                'customer'=> $item['customer'],
                'price'=> $stok_toko->harga($item['nama']),
                'total'=> $stok_toko->harga($item['nama']) *$item['jumlah']
            ]);
            $stok_toko->kurangistok($item['nama'],$item['jumlah']);//kurangi stok toko
            
    }else{
        return redirect()->back()->withErrors(['stok habis' => 'Stok tidak cukup, inputan ke '.$id +1 . ' dan setelahnya dibatalkan']);
    }}return redirect('sales/history');
}}
