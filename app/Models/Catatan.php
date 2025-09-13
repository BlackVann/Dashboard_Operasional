<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['code','perusahaan','catatan','no_nota'];
}
