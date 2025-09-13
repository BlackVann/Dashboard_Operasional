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
        @else
        
        @endif
          <form method="POST" action="/admin/request">
            @csrf
     
            <div id="req-list">
              <div class="req-item">
                <div class="row" id="row0">
                  <div class="col-6">
                    <label>Produk:</label>
                    <input type="text" list="daftar-produk" name="request[0][nama]" required class="form-control" autocomplete="off">
                  </div>
                  <div class="col-4">
                    <label>Jumlah:</label>
                <input type="number" name="request[0][jumlah]" required class="form-control"> 
                  </div>
                <input type="hidden" name="request[0][location]" value="Toko A">
                  <div class="col-2"><button type="button" class="btn-close" aria-label="Close" onclick="hapus(0)"></button></div>
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