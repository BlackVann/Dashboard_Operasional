@include('template.header', ['title' => 'Halaman Admin'])
<body>
 
@include('template.nav')
<div class="container">
  <div class="row"> 
@if ($status)
<h5>{{ $data[0]['time'] }}</h5>
<h6>{{"OT". \Carbon\Carbon::parse($data[0]['time'])->format('YmdHis')}}</h6>

       
    <table class="table">
    <thead>
      <tr class="tr">
        <th scope="col">Barang</th>
        <th scope="col">Jumlah</th>
    
        <th scope="col">Price</th>
        <th scope="col">Total</th>
        <th scope="col">Customer</th>
      </tr>
      @foreach ($data as $item)
   
      <td scope="col">{{ $item['produk'] }}</td>
      <td scope="col">{{ $item['out'] }}</td> 
      <td scope="col">{{ $item['price'] }}</td>
      <td scope="col">{{ $item['out'] *$item['price'] }}</td>  
      <td scope="col">{{ $item['customer'] }}</td>      
      </tr>
      @endforeach
    </thead>
   
  </table>
@else
<h1>Data Tidak Ada</h1>
@endif

</div>
</div>

      @include('template.side_admin_toko', ['history_out'=>"active"])     



                
        </div>

      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      
</body>
</html>