<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\stok_toko;
use Carbon\Carbon;
use App\Models\Catatan;
use App\Models\History_Out_Gudang;
use App\Models\History_Gudang;
use App\Models\History_In_Gudang;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Stok_Gudang;
use App\Models\request as RequestModel;

class Gudang extends Controller
{
        public$end;
    public $start;
        public function __construct()
    {        
    $this->end=Carbon::now()->endOfMonth()->format('Y-m-d');
    $this->start=Carbon::now()->startOfMonth()->format('Y-m-d');
    }
    public function home(){
        return view('staff_gudang.home');
    }
    public function gudang(){//halaman gudang untuk melihat pengiriman yang harus dilakukan
        $data = RequestModel::where('amount_status', '!=', 'done')->where('deliver_status','-=',1)->get();
        $grup=$data->groupBy('code');
       
        return view('staff_gudang.deliver',['data'=> $grup]);
    }

    public function pengiriman(Request $request,$code=null ){//time diambil dari route

        $data='';
        $status='';
        if($code){
        $data = RequestModel::where('code', $code)->where('amount_status','!=', 'done')->where('deliver_status','!=',1)->get()->toArray();//mencari berdasarkan parameter time
        }
        if(empty($data)){ 
            $data = RequestModel::query();
             $status='history';//jika data $cek tidak ditemukan $data menampilkan semua data( history )
                    if($request->filled('status')){    
          
                
                    if($request->status =="done"|| $request->status =="belum"){
                         $data=$data->where('amount_status', $request->status)->where( 'deliver_status', 0);
                    }
                    else{ $data=$data->where('deliver_status', $request->status);}
                }
            $data = $data->select(
                'time_request',
                     DB::raw("GROUP_CONCAT(CONCAT(name, ' x ', amount_request) SEPARATOR ', ') as request"),
                DB::raw("GROUP_CONCAT(CONCAT( name, ' x ', amount_received) SEPARATOR ', ') as received"),
                DB::raw("GROUP_CONCAT(CONCAT( name, ' x ', amount_deliver) SEPARATOR ', ') as deliver"),
                DB::raw("GROUP_CONCAT(deliver_status) as status_deliver"),
                DB::raw("GROUP_CONCAT(amount_status) as status"),
                DB::raw("GROUP_CONCAT(name) as name"),
                
            );
            if ($request->filled('datestart') && $request->filled("dateend")){
            $data=$data->whereBetween('time_request',[Carbon::parse($request->datestart)->startOfDay() , Carbon::parse($request->dateend)->endOfDay()])->groupBy('time_request')->get();
        }
        else{
            $data=$data->groupBy('time_request')->where("amount_status",'like',  '%'.'belum'. '%')->get();
        }

        }

        if(empty($data)){
            $status=false;
        }
          return view('staff_gudang.pengiriman',['data'=>$data,'status'=>$status]);
            }



    public function ubah_pengiriman($code, Request $request){//melakukan update dimana update terjadi di halaman pengirim
        $request->validate(['deliver.*.jumlah'=>'numeric|min:0'],[//validasi terlebih dahulu
            'deliver.*.jumlah.min' => 'Jumlah tidak boleh 0']);
            $data = RequestModel::where('code', $code)->where('amount_status', '!=', 'done')->where('deliver_status','!=',1)->get();
            
            $json = json_decode($data, true); 

            $amount_request = array_column($json, 'amount_request');
            $amount_received= array_column($json, 'amount_received');
            $amount_deliver= array_column($json, 'amount_deliver');
         $jumlah_kirim=$request->deliver;   
         $id=0;
         $nama='';
         $max=0;
         $sent=0;
         $cek=new Stok_Gudang();
        foreach($jumlah_kirim as $item){

            if(!$cek->jumlahstok($item['name'],$item['jumlah'])){
                 return redirect()->back()->withErrors(['stok habis' => 'Stok '. $item['name'] .' tidak cukup']);
            }
        }
         foreach($jumlah_kirim as $item){
            if($item['jumlah']> $amount_request[$item['id']]- $amount_received[$item['id']] + $amount_deliver[$item['id']] ){//validasi sebelum dikirm
                $id = $item['id'] +1;
                $nama = $item['name'];
                $max=$item['jumlah'];
                $sent=$amount_request[$item['id']] - $amount_received[$item['id']] ;
                break;
            }
            }
            $kapasitas='Pesanan yang diperlukan '. $sent  . ' dikirim '. $max  ;//pesan
            
        if($id!=0){ return redirect()->back()->withErrors(['exceeds demand' => 'Pengiriman '. $nama .' pada baris ke '.$id  . ' melebihi pesanan. '. $kapasitas  ]);}
        else{//jika validasi berhasil
         $req = $request->all();
         $deliveries = $req['deliver'];
         $names = collect($deliveries)->pluck('name')->all();
         $tambahstok = stok_toko::whereIn('name', $names)->get()->keyBy('name');
         $produkList = RequestModel::where('code', $code)->whereIn('name', $names)->get()->keyBy('name');// membuat array dapat diakses dengan name dimana awalnya [{data...},{data...}] sekarang menjadi { name:{},name:{}}
         foreach ($deliveries as $item) {
        History_Out_Gudang::create([
        'produk'=>$item['name'],
        'out'=>$item['jumlah'],
        'toko'=>$item['location'],
        'code'=> "OUT".Carbon::now('Asia/Jakarta')->format('YmdHis'),
        'time'=> Carbon::now('Asia/Jakarta')->format('YmdHis'),
        ]);
         History_Gudang::create([
                'produk'=> $item['name'],
                'date'=> Carbon::now('Asia/Jakarta'),
                 'code'=> "OT".Carbon::now('Asia/Jakarta')->format('YmdHis'),
                 'in'=> 0,
                 'out'=>$item['jumlah'],
                 'last_item'=> $cek->stokakhir($item['name'])-$item['jumlah']
         ]);
                $cek->kurangistok($item['name'],$item['jumlah']);
                $produk = $produkList[$item['name']];
                $produk->amount_deliver = $item['jumlah'];
                $produk->deliver_status= 1;
                $produk->edit = false;
                $tambah=$tambahstok[$item['name']];
                $produk->save();
                $tambah->save();
                

        }
        return redirect()->back();
        
    }

    }
    public function stok(){
         $stok_toko=new Stok_Gudang();
     
        $stok=$stok_toko->orderBy("amount")->paginate(10);
        return view('staff_gudang.stok', ['stok'=>$stok]);
    }
        public function add(){
   
        return view('staff_gudang.add');
    }
    public function add1(Request $request){
    $names = Stok_Gudang::pluck('name')->toArray();

    $rules = [
        'produk.*.nama' => ['required', Rule::NotIn($names)],
        'produk.*.jumlah' => ['required', 'numeric', 'min:1']
        
    ];

    $messages = [

        'produk.*.jumlah.numeric' => 'Jumlah harus berupa angka',
        'produk.*.jumlah.min'     => 'Jumlah tidak boleh 0',
        'produk.*.nama'     => 'Nama Tidak Boleh Sama'
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

}
foreach ($arr as $item) {
    Stok_Gudang::create([
        'name'=> $item['nama'],
        'amount'=> $item['jumlah']
    ]);
    History_Gudang::create([
        'produk'=>$item['nama'],
        'in'=> $item['jumlah'],
        'date'=> Carbon::now('Asia/Jakarta'),
        'last_item'=>$item['jumlah'],
        'in' =>$item['jumlah'],
        'out'=>0,
        'code'=>"awal"
        
    ]);
}
 return redirect()->action([Gudang::class,'stok']);
    }
    public function history_out_detail($code){
    $out = new History_Out_Gudang();
    $status = true;
    $data=$out->where('code',$code)->get()->toArray();
    if(empty($data)) $status = false;
    return view('staff_gudang.history_out_detail',['data'=>$data,'status'=>$status]);
                                                            }
public function stok_in(){
    $gudang=Stok_Gudang::select('name')->pluck('name')->toArray();
    return view('staff_gudang.stok_in',["name"=>$gudang]);
}
public function stok_in1(Request $request){
     $gudang = Stok_Gudang::pluck('name')->toArray();
    $stok_gudang=new Stok_Gudang();
    $rules = [
        'produk.*.nama' => ['required',Rule::in($gudang)],
        'produk.*.jumlah' => ['required', 'numeric', 'min:1'],
        'perusahaan'=>['required'],
        'nota'=>['required']
    ];

    $messages = [

        'produk.*.jumlah.numeric' => 'Jumlah harus berupa angka',
        'produk.*.jumlah.min'     => 'Jumlah tidak boleh 0',
        'produk.*.nama.in'       => 'Nama Produk Tidak Terdaftar',
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
}}
foreach ($arr as $item){

        History_In_Gudang::create([
               'produk'=> $item['nama'],  
               'time'=> Carbon::now('Asia/Jakarta'),
               'code'=> "IN".Carbon::now('Asia/Jakarta')->format('YmdHis'),
               'in'=> $item['jumlah']]);
             

        History_Gudang::create([
                'produk'=> $item['nama'],
                'date'=> Carbon::now('Asia/Jakarta'),
                 'code'=> "IN".Carbon::now('Asia/Jakarta')->format('YmdHis'),
                 'in'=> $item['jumlah'],
                 'out'=>0,
                 'last_item'=> $stok_gudang->stokakhir($item['nama'])+$item['jumlah']
            ]);
            $stok_gudang->tambah($item['nama'],$item['jumlah']);
            }

    Catatan::create([
      'code'=> "IN".Carbon::now('Asia/Jakarta')->format('YmdHis'),
      'perusahaan'=>$request->perusahaan,
      'catatan'=>$request->catatan,
      'no_nota'=>$request->nota
    ]); 
    return redirect()->action([Gudang::class,'stok']);
    }
    public function history_in(Request $request)
    {         $end=$this->end;
       $start=$this->start;
        $nama=Stok_Gudang::select('name')->get()->toArray();
        $status = true;
        if (empty($request->all()))
        {
            $in=History_In_Gudang::whereBetween('time', [Carbon::now()->startOfMonth()->format('Y/m/d'),Carbon::now()->endOfMonth()->format('Y/m/d')])->paginate(10);
            if ($in->isEmpty())
            {
            $status = false;
            }
            return view ('staff_gudang.history_in',["in"=>$in, "nama"=>$nama,'status'=>$status,"dateend"=>$end,"datestart"=>$start]);
        }
        else
        {
            $nama=Stok_Gudang::select('name')->get()->toArray();
            $history= new History_In_Gudang();
            $dataAwal = $history->orderBy('time', 'asc');
            $dataTerakhir = $history->orderBy('time', 'desc');
            if ($request->filled('name'))
            {
                $history = $history->where('produk', 'like',  '%'.$request->name. '%');
                $dataAwal = $dataAwal->where('produk', 'like',  '%'.$request->name. '%');
                $dataTerakhir = $dataTerakhir->where('produk', 'like',  '%'.$request->name. '%');
            }
            $dataTerakhir=$dataTerakhir->first();
            $dataAwal= $dataAwal->first();
            if ($request->filled('datestart') && $request->filled("dateend"))
            {               $end=Carbon::parse($request->dateend);
        $start=Carbon::parse($request->datestart); 
               if( $request->datestart > $dataTerakhir->time || $request->dateend < $dataAwal->time)
                {
                    return view ('staff_gudang.history_in',["nama"=>$nama, 'status'=>false,"dateend"=>$end,"datestart"=>$start]);
                }     
                $history=$history->whereBetween('time',[Carbon::parse($request->datestart)->startOfDay() , Carbon::parse($request->dateend)->endOfDay()]);
            }
            $history=$history->orderBy('time','desc')->paginate(10)->appends([
                      'name' => $request->name,
                      'datestart' => $request->datestart,
                      'dateend' => $request->dateend
                  ]);; ; 
            if($history->isEmpty())
            {
                $status=false;
            }           
            return view('staff_gudang.history_in',['in'=>$history,"nama"=>$nama, "status"=>$status,"dateend"=>$end,"datestart"=>$start]);
        }

    }
        public function history_out(Request $request)
    {
                 $end=$this->end;
       $start=$this->start;
        $nama=stok_toko::select('name')->get()->toArray();
        $status = true;
        if (empty($request->all()))
        {
        $out=History_Out_Gudang::whereBetween('time', [Carbon::now()->startOfMonth()->format('Y/m/d'),Carbon::now()->endOfMonth()->format('Y/m/d')])->paginate(10);
        if ($out->isEmpty())
            {
                $status = false;
            }
        return view ('staff_gudang.history_out',["out"=>$out,"nama"=>$nama, 'status'=>$status,"dateend"=>$end,"datestart"=>$start]);
        }
        else
        {
            $nama=stok_toko::select('name')->get()->toArray();
        $history= new History_Out_Gudang();
        $dataAwal = $history->orderBy('time', 'asc');
        $dataTerakhir = $history->orderBy('time', 'desc');
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
        return view ('staff_gudang.history_out',["nama"=>$nama, 'status'=>false,"dateend"=>$end,"datestart"=>$start]);
               }
                 
            $history=$history->whereBetween('time',[Carbon::parse($request->datestart)->startOfDay() , Carbon::parse($request->dateend)->endOfDay()]);
        }
       
       
        $history=$history->orderBy('time','desc')->paginate(10)->appends([
                      'name' => $request->name,
                      'datestart' => $request->datestart,
                      'dateend' => $request->dateend
                  ]);; 
              if($history->isEmpty()){
        $status=false;
    }
        return view('staff_gudang.history_out',['out'=>$history,"nama"=>$nama,'status'=>$status,"dateend"=>$end,"datestart"=>$start]);
        }
       
    }
    public function stok_detail(Request $request,$produk){//menampilkan semufa jumlah stok dan stok yang menipis
    $stok_detail=new History_Gudang();
    $paginate=false;
     $status=true;
         $end=$this->end;
       $start=$this->start;
            if (History_Gudang::where("produk",$produk)->get()->isEmpty()){
             return view('staff_gudang.stok_detail',['status'=>false, "produk"=>$produk,"pagination"=>$paginate]);
        }
         if (empty($request->all())) {
        $stok=$stok_detail->where("produk",$produk)->whereBetween('date', [Carbon::now()->startOfMonth()->format('Y/m/d'),Carbon::now()->endOfMonth()->format('Y/m/d')])->get();
        if ($stok->isEmpty()){
            $last=History_Gudang::where('produk',$produk)->orderBy('date', 'desc')->first();
            $stok=collect([(object)[
     
        "date" => Carbon::now()->startOfMonth()->startOfDay(),
        "code" => "-",
        "in" => "-",
        "out" => "-",
        "last_item" => $last['last_item']
    
]]);
        }
        return view('staff_gudang.stok_detail',['stok' => $stok, 'status'=>$status, "produk"=>$produk,  "pagination"=>$paginate,"dateend"=>$end,"datestart"=>$start]);}
        else
            {
            $end=Carbon::parse($request->dateend);
        $start=Carbon::parse($request->datestart); 
            $dataAwal = History_Gudang::where('produk',$produk)->orderBy('date', 'asc')->first();
            $dataTerakhir = History_Gudang::where('produk', $produk)->orderBy('date', 'desc')->first();
            $stok=History_Gudang::where("produk",$produk)
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
        $stok=History_Gudang::where("produk",$produk)->orderBy('date', 'desc')->where('date',"<", $request->dateend)->first();
         $stok=
    collect([
    (object) ['date' => Carbon::parse($request->dateend)->format('Y-m-d H:i:s'),"code" => "-","in" => "-","out" => "-","last_item" => $stok->last_item]]);
    }
    return view('staff_gudang.stok_detail',['stok' => $stok, 'status'=>true, "produk"=>$produk,"pagination"=>$paginate,"dateend"=>$end,"datestart"=>$start]);
        }
    }
      public function history_in_detail($code){
    $in = new History_In_Gudang();
    $status = true;
    $data=$in->where('code',$code)->get()->toArray();
    $note=Catatan::where('code',$code)->get()->first();
if(empty($data)) $status = false;
return view('staff_gudang.history_in_detail',['data'=>$data,'status'=>$status,'note'=>$note]);
}
public function delete(Request $request){
    $cek=stok_toko::where('name',$request->name)->first();
    
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

