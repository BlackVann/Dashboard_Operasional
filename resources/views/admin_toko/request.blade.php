@include('template.header', ['title' => 'Halaman Admin'])
<body>
 
   <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop"><i class="bi bi-justify"></i></button>
            <span class="navbar-brand mb-0 h1 me-auto">Doni (Admin Toko)</span>

        </div>
      </nav>
      
      @include('template.side_admin_toko', ['home'=>'','request'=>'active','history' =>"", 'stok'=>""])     
      <div class="container">
        <div class="row">
        
  
          <form method="POST" action="/admin/request">
            @csrf
     
            <div id="req-list">
              <div class="req-item">
                <div class="row">
                  <div class="col">
                    <label>Produk:</label>
                    <input type="text" list="daftar-produk" name="request[0][nama]" required class="form-control">
                  </div>
                  <div class="col">
                    <label>Jumlah:</label>
                <input type="number" name="request[0][jumlah]" required class="form-control">
                  </div>
                </div>
              </div>
            </div>
          
            <button type="button" onclick="reqProduk()" class="btn btn-dark">+ Produk</button>
            <button type="submit" class="btn btn-dark">Request</button>
          </form>


    </div>
      </div>


      <datalist id="daftar-produk">
        
        @foreach ($nama as $produk )
        <option value="{{ $produk['name'] }}">
        @endforeach
       </datalist>
             </div>
           </div>
          <script src="{{ asset('req.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>