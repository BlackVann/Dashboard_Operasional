@include('template.header', ['title' => 'Halaman Admin'])
<body>
 
   <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop"><i class="bi bi-justify"></i></button>
            <span class="navbar-brand mb-0 h1 me-auto">Doni (Admin Toko)</span>

        </div>
      </nav>
<div class="container">
  <div class="row">      
    <table class="table">
    <thead>
      <tr>
        <th scope="col">Barang</th>
        <th scope="col">Di pesan</th>
        <th scope="col">Di terima</th>
        <th scope="col">Waktu dikirik terakhir</th>
      </tr>
    </thead>
    @foreach($history as $data)
  
    <tbody>
      <tr>
        <td>{{ $data['name'] }}</td>
        <td>{{ $data["amount_request"] }}</td>
        <td>{{ $data['amount_received'] }}</td>
        <td>{{ $data['time_accepted'] }}</td>
  
        
      </tr>
   
    </tbody>
    @endforeach
  </table></div></div>

      @include('template.side_admin_toko', ['home'=>'','request'=>'','history' =>"active", 'stok'=>""])     



                
        </div>

      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>