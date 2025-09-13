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
        @if ($status)
                  <form method="POST" action="/admin/request-edit">
            @csrf
      @method('PUT')
            <div id="req-list">
              <div class="req-item">
                <div class="row" id="row0">
                  <div class="col-6">
                    <label>Produk:</label>
                    <input type="text"  name="name" value="{{ $data->name }}" required class="form-control" readonly>
                  </div>
                   <input type="hidden"  name="code" value="{{ $data->code }}" required class="form-control" >
                  <div class="col-4">
                    <label>Jumlah:</label>
                <input type="number" name="amount_request" value="{{ $data->amount_request }}" required class="form-control"> 
                 <input type="hidden" name="request[0][location]" value="Toko A">
                  </div>
              
              </div>
            </div>
          
            <button type="submit" class="btn btn-dark">Ubah</button>
          </form>
          <form method="POST" action="/admin/request-edit">
          @csrf
            @method('DELETE')
           <input type="hidden" name="request[0][location]" value="Toko A">
          <input type="hidden" name="name" value="{{ $data->name }}">
          <input type="hidden" name="code" value="{{ $data->code }}">
           <button type="submit" class="btn btn-dark">Hapus</button>
          </form>
        @else
        <h1> Data Tidak Ada</h1>
        @endif



    </div>
      </div>



             </div>
           </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>