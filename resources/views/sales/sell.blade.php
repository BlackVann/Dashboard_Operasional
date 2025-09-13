@include('template.header', ['title' => 'Halaman Sales'])
<body>
 
@include('template.nav')
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
              <div class="row" id="row0">
                <div class="col-11">
                  <div class="row">
                    <div class="col-8">
                      <label>Produk:</label>
                  <input type="text" list="daftar-produk" name="produk[0][nama]" required class="form-control">
                    </div>
                    <div class="col-4 ">
                      <label>Jumlah:</label>
                      <input type="number" name="produk[0][jumlah]" required class="form-control">
                    </div>
                    <div class="col-12">
                      <label>Customer:</label>
              <input type="text" name="produk[0][customer]" required class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-1">
                  <div class="row">
                    <div class="col-2 col-sm-1 "><button type="button" class="btn-close" aria-label="Close" onclick="hapus(0)"></button></div>
                  </div>
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