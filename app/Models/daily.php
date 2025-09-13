<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class daily extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name','count'];

}
