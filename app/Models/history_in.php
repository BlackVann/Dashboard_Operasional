<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class history_in extends Model
{
    use HasFactory;
        public $timestamps = false;
    protected $fillable = ['produk', 'in', 'code', 'time','location'];
}

