<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stok_toko extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $fillable = [
        'name',
        'amount',
        'price','toko','location'

        
    ];
    public  function jumlahstok($name,$stok){
        $ready=stok_toko::where('name', $name)->first();
       if( $stok <= $ready->amount ){
        return true;
       }
       else{
        return false;
       }
}
public function stokakhir($name,$location){
   $stok= stok_toko::where('name',$name)->where('location',$location)->first();
   return $stok->amount;
}
public function kurangistok($name,$jumlah){
    $stok=stok_toko::where('name', $name)->first();
    $stok->amount -= $jumlah;
    $stok->save();
}
public function harga($name){
    $stok=stok_toko::where('name', $name)->first();
    return $stok->price;
}

}