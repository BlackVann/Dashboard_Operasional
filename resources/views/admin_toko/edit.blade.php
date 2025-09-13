@include('template.header', ['title' => 'Halaman Admin'])
<body>
 
@include('template.nav')
      @include('template.side_admin_toko', ['stok'=>"active"])     

      <div class="container">
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
         @if ($status)
                  <form method="POST" action="/admin/edit_harga">
            @csrf
      @method('PUT')
            <div id="req-list">
              <div class="req-item">
                <div class="row" id="row0">
                  <div class="col-6">
                    <label>Produk:</label>
                    <input type="text"  value="{{ $data->name }}" name="nama" required class="form-control" readonly>
               
                    <label>Harga:</label>
                <input type="number" name="harga" value="{{ $data->price }}" required class="form-control"> 

                  </div>
              
              </div>
            </div>
          
            <button type="submit" class="btn btn-dark">Ubah</button>
          </form>
        
        @else
        <h1>Data Tidak Ada</h1>
        @endif
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>