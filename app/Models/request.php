<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class request extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name','code', 'amount_request', 'amount_received', 'time_request','time_received','amount_status','deliver_status','amount_deliver','location','edit'];

    public function data_deliver($time){//data untuk driver
        $data = request::where('time_request', $time)
             ->where('deliver_status',0)->get();
        $grup=$data->groupBy('time_request');
        return $grup;
    }

    public function set_deliver_status($time){///pindahkan nanti ke controller method put
        $data= request::where('time_request', $time)->where('ammount_status','!=','done');
        $data->deliver_status = 0;
        $data->save();
    }
    public function data_gudang(){
        $data= request::where('ammount_status','!=','done')->where('deliver_status','-=',1)->get();
        $grup=$data->groupBy('time_request');
    }
}
