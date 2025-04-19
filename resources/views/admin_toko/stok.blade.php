@include('template.header', ['title' => 'Halaman Admin'])
<body>
 
   <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
          <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop"><i class="bi bi-justify"></i></button>
            <span class="navbar-brand mb-0 h1 me-auto">Doni (Admin Toko)</span>

        </div>
      </nav>
      @include('template.side_admin_toko', ['home'=>'','request'=>'','history' =>"", 'stok'=>"active"])     

      <div class="container">

        <div class="row">

          @forelse ($stoks as $item)
          <h2>Stok Menipis</h2>
              <div>
                  <p>{{ $item->name }} - Sisa: {{ $item->amount }}</p>
              </div>
          
                </div>
               </div>
                
          @empty
              <h2>Stok Masih Banyak</h2>
          @endforelse 
          <br>   
          <h3>Total Stok</h3>
          @foreach ($stok as $item)
            
                  <p>{{ $item->name }} - Sisa: {{ $item->amount }}</p>
         
          @endforeach
                </div>
               </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>