@include('template.header', ['title' => 'Halaman Sales'])
<body>
 
   <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop"><i class="bi bi-justify"></i></button>
            <span class="navbar-brand mb-0 h1 me-auto">Roy Simajuntak (Sales)</span>

        </div>
      </nav>
<div class="container">
  <div class="row">

    <table class="table">
      <thead>
        <tr>
          <th scope="col">Waktu</th>
          <th scope="col">Barang</th>
          <th scope="col">Customer</th>
          <th scope="col">Jumlah</th>
          <th scope="col">Harga</th>
          <th scope="col">Total</th>
        </tr>
      </thead>
      @foreach($history as $data)
    
      <tbody>
        <tr>
          <td>{{ $data['time'] }}</td>
          <td>{{ $data["name"] }}</td>
          <td>{{ $data['customer'] }}</td>
          <td>{{ $data['amount'] }}</td>
          <td>{{ $data['price'] }}</td>
          <td>{{ number_format($data['total'], 0, ',', '.') }}</td>
        </tr>
     
      </tbody>
      @endforeach
      <tbody>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>{{ $total }}</td>
        </tr>
     
      </tbody>
    </table>
  </div>
</div>


      @include('template.side_sales', ['home'=>'','sell'=>'','history' =>"active"])     
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>