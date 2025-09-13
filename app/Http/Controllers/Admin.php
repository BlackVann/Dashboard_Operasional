<?php

namespace App\Http\Controllers;
use App\Models\daily;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\stok_toko;
use App\Models\request as RequestModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\sell;
use App\Models\Stok_Gudang;
use App\Models\history_in;
use App\Models\history_stok;


use function PHPUnit\Framework\isEmpty;

class Admin extends Controller

{   public $jumlah;
    public $user;
    public$end;
    public $start;
    public $accept;
    public function __construct()
    {
        
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user(); 
            return $next($request);

        });
        
               $this->end=Carbon::now()->endOfMonth()->format('Y-m-d');
    $this->start=Carbon::now()->startOfMonth()->format('Y-m-d');
    }
    public function home(){//home
        
        return view ('admin_toko.home');
    }
    public function edit($name,$code)
    {
        $data=RequestModel::where('code',$code)->where('location',$this->user->location)->where('name',$name)->where('edit',true)->first();
        if (empty($data)){
             return view ('admin_toko.request-edit',['status'=>false]);
        }
   
        return view ('admin_toko.request-edit',["data"=>$data, 'status'=>true]);
        
    }
    public function edit1(Request $request){
        $data=RequestModel::where('code', $request->code)->where('location',$this->user->location)->where('name',$request->name)->where('edit', true)->first();
        if(empty($data)){
            return redirect()->action([Admin::class,'history']);
        }
        $data->amount_request= $request->amount_request;
        $data->save();
    return redirect()->action([Admin::class,'history']);
    }
    public function edit_harga1(Request $request){
    $name = stok_toko::select('name')->where('location',$this->user->location)->get()->pluck('name')->toArray();

$request->validate([ 'nama' => [Rule::in($name)],'harga'=>'numeric|min:1'], [
    'nama.in' => 'Produk tidak tersedia',
    'harga.min' => 'Harga tidak boleh 0'
]);
    $edit=stok_toko::where('location',$this->user->location)->where('name', $request->nama)->first();
    $edit->price = $request->harga;
    $edit->save();
    return redirect()->action([Admin::class,'stok']);
    }
    public function edit2(Request $request){
        $data=RequestModel::where('location',$this->user->location)->where('code', $request->code)->where('name',$request->name)->where('edit', true)->first();
        if(empty($data)){
            return redirect()->action([Admin::class,'history']);
        }
        $data->delete();
        return redirect()->action([Admin::class,'history']);
    }
    public function history_in(Request $request)
    {
        $nama=stok_toko::where('location',$this->user->location)->select('name')->get()->toArray();
        $status = true;
         $end=$this->end;
       $start=$this->start;
        if (empty($request->all()))
        {
            $in=history_in::where('location',$this->user->location)->whereBetween('time', [Carbon::now()->startOfMonth()->format('Y/m/d'),Carbon::now()->endOfMonth()->format('Y/m/d')])->paginate(10);
            if ($in->isEmpty())
            {
            $status = false;
            }
            return view ('admin_toko.history_in',["in"=>$in, "nama"=>$nama,'status'=>$status,"dateend"=>$end,"datestart"=>$start]);
        }
        else
        {
            $nama=stok_toko::where('location',$this->user->location)->select('name')->get()->toArray();
            $history= new history_in();
            $dataAwal = $history->where('location',$this->user->location)->orderBy('time', 'asc');
            $dataTerakhir = $history->where('location',$this->user->location)->orderBy('time', 'desc');
            if ($request->filled('name'))
            {
                $history = $history->where('location',$this->user->location)->where('produk', 'like',  '%'.$request->name. '%');
                $dataAwal = $dataAwal->where('produk', 'like',  '%'.$request->name. '%');
                $dataTerakhir = $dataTerakhir->where('produk', 'like',  '%'.$request->name. '%');
            }
            $dataTerakhir=$dataTerakhir->first();
            $dataAwal= $dataAwal->first();
            if ($request->filled('datestart') && $request->filled("dateend"))
            {  
                $end=Carbon::parse($request->dateend);
        $start=Carbon::parse($request->datestart); 
               if( $request->datestart > $dataTerakhir->time || $request->dateend < $dataAwal->time)
                {
                    return view ('admin_toko.history_in',["nama"=>$nama, 'status'=>false,"dateend"=>$end,"datestart"=>$start]);
                }     
                $history=$history->where('location',$this->user->location)->whereBetween('time',[Carbon::parse($request->datestart)->startOfDay() , Carbon::parse($request->dateend)->endOfDay()]);
            }
            $history=$history->where('location',$this->user->location)->orderBy('time','desc')->paginate(10)->appends([
                      'name' => $request->name,
                      'datestart' => $request->datestart,
                      'dateend' => $request->dateend
                  ]);; ; 
            if($history->isEmpty())
            {
                $status=false;
            }           
            return view('admin_toko.history_in',['in'=>$history,"nama"=>$nama, "status"=>$status,"dateend"=>$end,"datestart"=>$start]);
        }

    }

    public function history_out(Request $request)
    {
        $nama=stok_toko::where('location',$this->user->location)->select('name')->get()->toArray();
        $status = true;
                 $end=$this->end;
       $start=$this->start;
        if (empty($request->all()))
        {
        $out=sell::where('location',$this->user->location)->whereBetween('time', [Carbon::now()->startOfMonth()->format('Y/m/d'),Carbon::now()->endOfMonth()->format('Y/m/d')])->paginate(10);
        if ($out->isEmpty())
            {
                $status = false;
            }
        return view ('admin_toko.history_out',["out"=>$out,"nama"=>$nama, 'status'=>$status,"dateend"=>$end,"datestart"=>$start]);
        }
        else
        {
            $nama=stok_toko::where('location',$this->user->location)->select('name')->get()->toArray();
        $history= new sell();
        $dataAwal = $history->where('location',$this->user->location)->orderBy('time', 'asc');
        $dataTerakhir = $history->where('location',$this->user->location)->orderBy('time', 'desc');
          if ($request->filled('name')){
             
             $history = $history->where('produk', 'like',  '%'.$request->name. '%');
             $dataAwal = $dataAwal->where('produk', 'like',  '%'.$request->name. '%');
              $dataTerakhir = $dataTerakhir->where('produk', 'like',  '%'.$request->name. '%');
         };
        $dataTerakhir=$dataTerakhir->first();
        $dataAwal= $dataAwal->first();
            if ($request->filled('datestart') && $request->filled("dateend")){
                  $end=Carbon::parse($request->dateend);
        $start=Carbon::parse($request->datestart); 
               if( $request->datestart > $dataTerakhir->time || $request->dateend < $dataAwal->time){
        return view ('admin_toko.history_out',["nama"=>$nama, 'status'=>false,"dateend"=>$end,"datestart"=>$start]);
               }
                 
            $history=$history->where('location',$this->user->location)->whereBetween('time',[Carbon::parse($request->datestart)->startOfDay() , Carbon::parse($request->dateend)->endOfDay()]);
        }
       
       
        $history=$history->where('location',$this->user->location)->orderBy('time','desc')->paginate(10)->appends([
                      'name' => $request->name,
                      'datestart' => $request->datestart,
                      'dateend' => $request->dateend
                  ]);; 
              if($history->isEmpty()){
        $status=false;
    }
        return view('admin_toko.history_out',['out'=>$history,"nama"=>$nama,'status'=>$status,"dateend"=>$end,"datestart"=>$start]);
        }
       
    }

    public function history_out_detail($code){
    $out = new sell();
    $status = true;
    $data=$out->where('location',$this->user->location)->where('code',$code)->get()->toArray();
    if(empty($data)) $status = false;
    return view('admin_toko.history_out_detail',['data'=>$data,'status'=>$status]);
                                                            }
    public function history_in_detail($code){
    $in = new history_in();
    $status = true;
    $data=$in->where('location',$this->user->location)->where('code',$code)->get()->toArray();
if(empty($data)) $status = false;
return view('admin_toko.history_in_detail',['data'=>$data,'status'=>$status]);
}

    public function history(Request $request){//hubungan antara gudang dan pengirim
        //halaman history default
        $history=RequestModel::where('location',$this->user->location)->orderBy('time_request','desc');
         $status=true;
       $end=$this->end;
       $start=$this->start;
        
        if (empty($request->all())) {
    return view('admin_toko.history',['history'=>$history-> where("amount_status", "belum")->paginate(10), 'status'=> true,"dateend"=>$end,"datestart"=>$start]);
}
    if ($request->filled('datestart') && $request->filled("dateend")){
        $end=Carbon::parse($request->dateend);
        $start=Carbon::parse($request->datestart);
            $history=$history->whereBetween('time_request',[Carbon::parse($request->datestart)->startOfDay() , Carbon::parse($request->dateend)->endOfDay()]);
            
        }
        if(!empty($request->status)){    
                    if($request->status =="done"|| $request->status =="belum"){
                         $history=$history->where('amount_status', $request->status)->where( 'deliver_status', 0);
                    }
                    else{ $history=$history->where('deliver_status', $request->status);}
                }
        $history=$history->paginate(10) // jumlah data per halaman
                  ->appends([
                      'status' => $request->status,
                      'datestart' => $request->datestart,
                      'dateend' => $request->dateend
                  ]);
          if($history->isEmpty()){
            $status=false;
          }

        return view('admin_toko.history',['history'=>$history, 'status'=> $status,"dateend"=>$end,"datestart"=>$start]);
    }
    public function stok(){//menampilkan semufa jumlah stok dan stok yang menipis
        $stok_toko=new stok_toko();
     
        $stok=$stok_toko->where('location',$this->user->location)->orderBy("amount")->paginate(10);
        return view('admin_toko.stok',['stok' => $stok]);
    }

    public function stok_detail(Request $request,$produk){//menampilkan semufa jumlah stok dan stok yang menipis
    $stok_detail=new history_stok();
    $paginate=false;
    $status=true;
    
            if (history_stok::where('location',$this->user->location)->where("produk",$produk)->get()->isEmpty()){            
                 return view('admin_toko.stok_detail',['status'=>false, "produk"=>$produk,"pagination"=>$paginate,"dateend"=>$this->end,"datestart"=>$this->start]);
             }
         if (empty($request->all())) {
        $stok=$stok_detail->where('location',$this->user->location)->where("produk",$produk)->whereBetween('date', [Carbon::now()->startOfMonth()->format('Y/m/d'),Carbon::now()->endOfMonth()->format('Y/m/d')])->get();
        if ($stok->isEmpty()){
            $last=history_stok::where('location',$this->user->location)->where('produk',$produk)->orderBy('date', 'desc')->first();
            $stok=collect([(object)[
     
        "date" => Carbon::now()->startOfMonth()->startOfDay(),
        "code" => "-",
        "in" => "-",
        "out" => "-",
        "last_item" => $last['last_item'] ?? 0
    
]]);
        }
        return view('admin_toko.stok_detail',['stok' => $stok, 'status'=>$status, "produk"=>$produk,  "pagination"=>$paginate, "dateend"=>$this->end,"datestart"=>$this->start]);}
        else
            {
            $dataAwal = history_stok::where('location',$this->user->location)->where('produk',$produk)->orderBy('date', 'asc')->first();
            $dataTerakhir = history_stok::where('location',$this->user->location)->where('produk', $produk)->orderBy('date', 'desc')->first();
            $stok=history_stok::where('location',$this->user->location)->where("produk",$produk)
                ->whereBetween('date', [Carbon::parse($request->datestart)->startOfDay() , Carbon::parse($request->dateend)->endOfDay()])
                ->paginate(10)->appends([ 
                'datestart' => $request->datestart,
                'dateend' => $request->dateend
                  ]);;

if(!$stok->isEmpty() ){
    $stok=$stok;  
    $paginate = true; 
}
elseif( $request->datestart > $dataTerakhir->date ){
    $stok=collect([
    (object) ['date' => Carbon::parse($request->dateend)->format('Y-m-d H:i:s'),"code" => "-","in" => "-","out" => "-","last_item" =>$dataTerakhir->last_item ]]);
}
    elseif($request->dateend < $dataAwal->date){ 
    $stok=collect([
    (object) ['date' => Carbon::parse($request->dateend)->format('Y-m-d H:i:s'),"code" => "-","in" => "-","out" => "-","last_item" => 0]]);  }
    else{
        $stok=history_stok::where("produk",$produk)->orderBy('date', 'desc')->where('date',"<", $request->dateend)->first();
         $stok=
    collect([
    (object) ['date' => Carbon::parse($request->dateend)->format('Y-m-d H:i:s'),"code" => "-","in" => "-","out" => "-","last_item" => $stok->last_item]]);
    }
    return view('admin_toko.stok_detail',['stok' => $stok, 'status'=>true, "produk"=>$produk,"pagination"=>$paginate,"dateend"=>$request->dateend,"datestart"=>$request->datestart]);
        }
    }
    public function request(){//
        $gudang = Stok_Gudang::pluck('name')->toArray();
        $nama=stok_toko::where('location',$this->user->location)->select('name')->whereIn('name', $gudang)->get()->toArray();
        return view('admin_toko.request',['nama'=>$nama ]);
    }
    public function add_request(Request $request){//menambahkan data ke tabel request dan validasi
$name = stok_toko::where('location',$this->user->location)->select('name')->get()->pluck('name')->toArray();
$gudang = Stok_Gudang::select('name')->get()->pluck('name')->toArray();
$request->validate([ 'request.*.nama' => [Rule::in($name)],Rule::in($gudang),'request.*.jumlah'=>'numeric|min:1'], [
    'request.*.nama.in' => 'Produk tidak tersedia',
    'request.*.jumlah.min' => 'Jumlah tidak boleh 0'
]);
$data=$request->all();
$arr=[];


foreach ($data['request'] as $item) {
$status=true;
    foreach ($arr as $key => $value){//cek jika ada request yang sama diinput 2 kali tambahkan ke request sebelummnya
        if ($value["nama"] == $item["nama"]) {
            $arr[$key]["jumlah"]+= $item["jumlah"];
            $status = false;
        break;
        } 
}
if ($status){// jika request tidak ditemukan sama akan ditambahkan ke item baru
    $arr[]=$item;
}

}
foreach ($arr as $item) {
    RequestModel::create([
        'name' => $item['nama'],
        'amount_request' => $item['jumlah'],
        'amount_received' =>0,
        'time_request' => Carbon::now('Asia/Jakarta'),
         'code'=> Carbon::now('Asia/Jakarta')->format('YmdHis'),
        'amount_status'=> "belum",
        'deliver_status'=> 0,
        'location'=>$this->user->location,
        'amount_deliver'=>0,
        
        'edit'=>true
        
    ]);
   
}


 return redirect()->action([Admin::class,'history']);

 }
 public function edit_harga($name){
   $stok= stok_toko::where('location',$this->user->location)->where('name',$name)->first();
         if (empty($stok)){
             return view ('admin_toko.edit',['status'=>false]);
        }
   return view('admin_toko.edit',['data'=>$stok,'status'=>true]);
 }
 public function add(){
    $gudang = stok_toko::where('location',$this->user->location)->pluck('name')->toArray();
        $nama=Stok_Gudang::select('name')->whereNotIn('name', $gudang)->get()->toArray();

    return view('admin_toko.add',['name'=>$nama]);
 }
 public function add1(Request $request){
    $toko = stok_toko::where('location',$this->user->location)->pluck('name')->toArray();
     $gudang = Stok_Gudang::pluck('name')->toArray();

    $rules = [
        'produk.*.nama' => ['required', Rule::notIn($toko),Rule::in($gudang)],
        'produk.*.jumlah' => ['required', 'numeric', 'min:1']
        
    ];

    $messages = [

        'produk.*.jumlah.numeric' => 'Jumlah harus berupa angka',
        'produk.*.jumlah.min'     => 'Jumlah tidak boleh 0',
        
        'produk.*.nama.not_in'   => 'Nama Tidak Boleh Sama Dengan Stok Sekarang',
        'produk.*.nama.in'       => 'Nama Produk Tidak Dikenal',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        
        return redirect()->back()
                         ->withErrors($validator)
                         ->withInput();
    }
    
$data=$request->all();
$arr=[];


foreach ($data['produk'] as $item) {
$status=true;
    foreach ($arr as $key => $value){//cek jika ada request yang sama diinput 2 kali tambahkan ke request sebelummnya
        if ($value["nama"] == $item["nama"]) {
            $arr[$key]["jumlah"]+= $item["jumlah"];
            $status = false;
        break;
        } 
}
if ($status){// jika request tidak ditemukan sama akan ditambahkan ke item baru
    $arr[]=$item;
}
foreach ($arr as $item) {
    stok_toko::create([
        'name'=> $item['nama'],
        'amount'=> $item['jumlah'],
        'price'=> $item['harga'],
        'location'=>$this->user->location
    ]);
      history_stok::create([
                'produk'=> $item['nama'],
                'date'=> Carbon::now('Asia/Jakarta'),
                 'last_item'=> $item['jumlah'],
                'in' =>$item['jumlah'],
                 'out'=>0,
                'code'=>'awal',
            'location'=>$this->user->location]);
                   

}

}

return redirect()->action([Admin::class,'stok']);
    }

public function delete(Request $request){
    $cek=Stok_Gudang::where('name',$request->name)->first();
    
     if(!$cek){
        return redirect()->back()->with('alert', 'Data Tidak ditemukan');
     }
     if(!$cek->amount == 0){
         return redirect()->back()->with('alert',  "Stok Harus 0");
     }
     $cek->delete();
      return redirect()->back()->with('alert',  $request->name.  ' Sudah Di Hapus');
}    
    
}
