<?php

namespace App\Http\Controllers;
use App\Models\sell;
use App\Models\history_stok;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\stok_toko;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class Sales extends Controller
{

    public $user;
    public function __construct()
    {
 
       $this->middleware(function ($request, $next) {
            $this->user = auth()->user(); 
            return $next($request);
        });
        
    }
    public function sales(){//home

        return view('sales.sales',["total"=> number_format(sell::where('location',$this->user->location)->whereMonth('time', Carbon::now()->month)->sum('total'), 0, ',', '.')]);
    }
    public function sell(){//halaman penjualanan
        return view('sales.sell',['nama'=> stok_toko::where('location',$this->user->location)->select('name')->where('amount', '>', 0 )->get()]);
    }
 
public function history(Request $request){
    $end=Carbon::now()->endOfMonth()->format('Y-m-d');
    $start=Carbon::now()->startOfMonth()->format('Y-m-d');
    $status=true;
    $nama=stok_toko::where('location',$this->user->location)->select('name')->get()->toArray();                     
    $data = new sell(); 
    if (empty($request->all()))
    {
        $history=sell::where('location',$this->user->location)->whereBetween('time', [Carbon::now()->startOfMonth()->format('Y/m/d'),Carbon::now()->endOfMonth()->format('Y/m/d')])->paginate(10);
        if ($history->isEmpty())
        {
            $status = false;
        }
         $total= number_format($history->sum("total"), 0, ',', '.');
     return view('sales.history',['history'=>$history,'total'=>$total,"status"=>$status,'nama'=>$nama,"dateend"=>$end,"datestart"=>$start]);

    }
    
    $dataAwal = $data->where('location',$this->user->location)->orderBy('time', 'asc')->first();
    $dataTerakhir = $data->where('location',$this->user->location)->orderBy('time', 'desc')->first();
    $history = $data->where('location',$this->user->location)->orderBy('time',"desc");
    if ($request->filled('produk')) {
         $history= $history->where('produk', 'like',  '%'.$request->produk. '%');
    }

    if ($request->filled('customer')) {
       $history= $history->where('customer', 'like',  '%'.$request->customer. '%');
    }
    if ($request->filled('datestart') && $request->filled("dateend")){
        $end=Carbon::parse($request->dateend);
        $start=Carbon::parse($request->datestart); 
          if( $request->datestart > $dataTerakhir->time || $request->dateend < $dataAwal->time){
        return view ('sales.history',['status'=>false,"dateend"=>$end,"datestart"=>$start,"nama"=>$nama,""]);
               }
     $history= $history->whereBetween('time',[Carbon::parse($request->datestart)->startOfDay() , Carbon::parse($request->dateend)->endOfDay()]);
} 
$history=$history->paginate(10);
$total= number_format($history->sum("total"), 0, ',', '.');   
    if($history->isEmpty()){
        $status=false;
    }

 return view('sales.history',['history'=>$history,'total'=>$total,"status"=>$status,'nama'=>$nama,"dateend"=>$end,"datestart"=>$start]);
}
    public function sells(Request $request){//validasi untuk menambahkan data ke history sales dan mengurangi stok toko
        $stok_toko= new stok_toko();
        $name = stok_toko::where('location',$this->user->location)->where('amount', '>', 0)->pluck('name')->toArray(); 
      $request->validate([ 'produk.*.nama' => [Rule::in($name)],'produk.*.jumlah'=>'numeric|min:1'], [
        'produk.*.nama.in' => 'Produk tidak terdaftar',
        'produk.*.jumlah.min' => 'Jumlah tidak boleh 0'
    ]);
      $data=$request->all();
      $id=0;
        foreach ($data['produk'] as $item) {
           
            if( $stok_toko->jumlahstok($item['nama'],$item['jumlah'])){
$id= $item['id'];
            history_stok::create([
                'produk'=> $item['nama'],
                'date'=> Carbon::now('Asia/Jakarta'),
                 'code'=> "OT".Carbon::now('Asia/Jakarta')->format('YmdHis'),
                 'out'=> $item['jumlah'],
                 'in'=> 0,
                 'last_item'=> $stok_toko->stokakhir($item['nama'],$this->user->location)-$item['jumlah'],
                 'location'=>$this->user->location
            ]);
            sell::create([//memasukan data ke history sales
                'produk' => $item['nama'],
                'out' => $item['jumlah'],
                'code'=> "OT".Carbon::now('Asia/Jakarta')->format('YmdHis'),
                'time' => Carbon::now('Asia/Jakarta'),
                'customer'=> $item['customer'],
                'price'=> $stok_toko->harga($item['nama']),
                'total'=> $stok_toko->harga($item['nama']) *$item['jumlah'],
                'sales'=>$this->user->name,
                'location'=>$this->user->location
            ]);
            $stok_toko->kurangistok($item['nama'],$item['jumlah']);//kurangi stok toko
            
    }else{
        return redirect()->back()->withErrors(['stok habis' => 'Stok tidak cukup, inputan ke '.$id +1 . ' dan setelahnya dibatalkan']);
    }}return redirect('sales/history');
}}
