@include('template.header', ['title' => 'Halaman Admin'])
<body>
 
@include('template.nav')
    
      @include('template.side_admin_toko', ['request'=>'active'])     
      <div class="container">
        <div class="row">
        
          @if ($errors->any())
          <div class="alert alert-danger row">
            <div>
              <ul>
                  @foreach ($errors->all() as $error)
                      <p>{{ $error }}</p>
                  @endforeach
              </ul>
            </div>
              
          </div>
       
        
        @endif
          <form method="POST" action="/admin/stok/add">
            @csrf
     
            <div id="form-list">
              <div class="form-item">
                <div class="row" id="row0">
                  <div class="col-4">
                    <label>Produk:</label>
                    <input type="text" list="daftar-produk" name="produk[0][nama]" required class="form-control" autocomplete="off">
                  </div>
                  <div class="col-3">
                    <label>Stok Awal:</label>
                <input type="number" name="produk[0][jumlah]" required class="form-control"> 
                  </div>
                <div class="col-3">
                    <label>Harga:</label>
                <input type="number" name="produk[0][harga]" required class="form-control"> 
                  </div>
                  <div class="col-2"><button type="button" class="btn-close" aria-label="Close" onclick="hapus(0)"></button></div>
                </div>
              </div>
            </div>
          
            <button type="button" onclick="tambahProduk1()" class="btn btn-dark">+ Produk</button>
            <button type="submit" class="btn btn-dark">Tambah</button>
          </form>


    </div>
      </div>


             </div>
           </div>
           
       <datalist id="daftar-produk">
        
        @foreach ($name as $produk )
        <option value="{{ $produk['name'] }}">
        @endforeach
       </datalist>
          <script src="{{ asset('add_stok.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>