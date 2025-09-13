<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sell extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['produk', 'out', 'time', 'code','customer','total','price','sales','location'];

}
