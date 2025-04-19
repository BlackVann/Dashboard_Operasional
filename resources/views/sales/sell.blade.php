@include('template.header', ['title' => 'Halaman Sales'])
<body>
 
   <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop"><i class="bi bi-justify"></i></button>
            <span class="navbar-brand mb-0 h1 me-auto">Roy Simajuntak (Sales)</span>

        </div>
      </nav>
      @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                 <p>{{ $error }}</p>
              @endforeach
          </ul>
      </div>

  @endif
      @include('template.side_sales', ['home'=>'','sell'=>'active','history' =>""])     
    <div class="container">
      <div class="row">
      
        
        <form method="POST" action="/sales/sell">
          @csrf
          <div id="form-list">
             
            <div class="form-item">
              <div class="row">
                <div class="col">
                  <label>Produk:</label>
              <input type="text" list="daftar-produk" name="produk[0][nama]" required class="form-control">
                </div>
                <div class="col">
                  <label>Jumlah:</label>
                  <input type="number" name="produk[0][jumlah]" required class="form-control">
                </div>
                <div class="col">
                  <label>Customer:</label>
          <input type="text" name="produk[0][customer]" required class="form-control">
                </div>
              </div>
              

              <input type="hidden" name="produk[0][id]" value="1">
              
            </div>
          </div>
        
          <button type="button" onclick="tambahProduk()" class="btn btn-dark">+ Produk</button>
          <button type="submit" class="btn btn-dark">Simpan</button>
        </form>


<datalist id="daftar-produk">
 @foreach ($nama as $produk )
 <option value="{{ $produk['name'] }}">
 @endforeach
</datalist>
      </div>
    </div>
   <script src="{{ asset('add.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>