<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok_Gudang extends Model
{
    use HasFactory;
     public $timestamps = false; 
    protected $fillable = [
        'name',
        'amount',

    ];
        public  function jumlahstok($name,$stok){
        $ready=Stok_Gudang::where('name', $name)->first();
       if( $stok <= $ready->amount ){
        return true;
       }
       else{
        return false;
       }}
    public function stokakhir($name){
   $stok= Stok_Gudang::where('name',$name )->first();
   return $stok->amount;
}
public function tambah($name,$jumlah){
    $stok=Stok_Gudang::where('name', $name)->first();
    $stok->amount += $jumlah;
    $stok->save();
}
public function kurangistok($name,$jumlah){
    $stok=Stok_Gudang::where('name', $name)->first();
    $stok->amount -= $jumlah;
    $stok->save();
}
}
