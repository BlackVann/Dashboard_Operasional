@include('template.header', ['title' => 'Halaman Gudang'])
<body>
 
@include('template.nav')
    
      @include('template.side_staff_gudang', ['in'=>'active'])     
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
          <form method="POST" action="/gudang/in">
            @csrf
     
            <div id="form-list">
              <div class="form-item">
                <div class="row" id="row0">
                  <div class="col-12">
                    <label>Perusahaan:</label>
                    <input type="text"  name="perusahaan" required class="form-control">
                  </div>
                  <div class="col-12">
                    <label>No Nota</label>
                <input type="text" name="nota" required class="form-control">  
              </div>
              <div class="col-6">
                    <label>Produk:</label>
                <input type="text" list="daftar-produk" name="produk[0][nama]" required class="form-control" autocomplete="off">  
              </div>                  
              <div class="col-5">
                    <label>Jumlah:</label>
                <input type="text" name="produk[0][jumlah]" required class="form-control">  
              </div>
               <div class="col-1"><button style="margin-top:2rem " type="button" class="btn-close" aria-label="Close" onclick="hapus(0)"></button></div>
              
              

            </div>
          
              </div>
            </div>
               <button type="button" onclick="tambahStokGudang()" class="btn btn-dark">+ Produk</button>
            <div class="col-12">
                <label>Catatan:</label>
                 <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="catatan"></textarea>
              </div>
            <button type="submit" class="btn btn-dark">Tambah</button>
          </form>


 <datalist id="daftar-produk">
        
        @foreach ($name as $produk )
        <option value="{{ $produk}}">
        @endforeach
       </datalist>
        </div>
      </div>
             </div>
           </div>
       <script src="{{ asset('add_stok.js') }}"></script> 
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>