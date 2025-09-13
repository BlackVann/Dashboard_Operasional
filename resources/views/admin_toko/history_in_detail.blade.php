@include('template.header', ['title' => 'Halaman Admin'])
<body>
 
@include('template.nav')
<div class="container">
@if ($status)
<br>
<h1>Barang Dikirim</h1>
<h5>{{ $data[0]['time'] }}</h5>
<h6>{{"OT". \Carbon\Carbon::parse($data[0]['time'])->format('YmdHis')}}</h6>

  <div class="row row-table">      
    <table class="table">
    <thead>
      <tr class="tr">
        <th scope="col">Barang</th>
        <th scope="col">Jumlah</th>
    
   

      </tr>
      @if ($status)
      
      
      @foreach ($data as $item)
   
      <td scope="col">{{ $item['produk'] }}</td>
      <td scope="col">{{ $item['in'] }}</td>  
      </tr>
      @endforeach
            @else
      <tr><td>-</td>
      <td>-</td></tr>
@endif
    </thead>
   
  </table></div>
@else
<h2>Data Tidak Ada</h2>
@endif
</div>

      @include('template.side_admin_toko', ['history_in'=>"active"])     



                
        </div>

      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      
</body>
</html>