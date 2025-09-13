@include('template.header', ['title' => 'Halaman Gudang'])
<body>
 
@include('template.nav')
<div class="container">
@if ($status)

<h5>{{ $data[0]['time'] }}</h5>
<h6>{{"OT". \Carbon\Carbon::parse($data[0]['time'])->format('YmdHis')}}</h6>

  <div class="row">      
    <table class="table">
    <thead>
      <tr class="tr">
        
        <th scope="col">Barang</th>
        <th scope="col">Jumlah</th>
        <th scope="col">Toko</th>
      </tr>
      @foreach ($data as $item)
   
      <td scope="col">{{ $item['produk'] }}</td>
      <td scope="col">{{ $item['out'] }}</td> 
      <td scope="col">{{ $item['toko'] }}</td>
     
      </tr>
      @endforeach
    </thead>
   
  </table></div>
@else
<h1>Data Tidak Ada</h1>
@endif
</div>

      @include('template.side_staff_gudang', ['history_out'=>"active"])     



                
        </div>

      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      
</body>
</html>