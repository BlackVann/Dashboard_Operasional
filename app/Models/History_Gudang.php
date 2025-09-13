<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History_Gudang extends Model
{
    use HasFactory;
    public $timestamps=false;
    
      protected $fillable = ['produk', 'date', 'code', 'in','out','last_item'];
}
