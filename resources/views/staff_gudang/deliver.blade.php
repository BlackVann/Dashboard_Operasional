@include('template.header', ['title' => 'Halaman Staff Gudang'])
<body>
 
  @include('template.nav')
  
  <div class="container">
    <div class="row">
      @foreach ($data as $tanggal => $items)
      @php
      $modalId = 'modal-' . str_replace([' ', ':'], '-', $tanggal);
  @endphp
    
   <div class="col-12">
  <div class="bg-dark text-white p-2 d-flex justify-content-between align-items-center mt-3">

  <i>{{ $tanggal }}</i>


  <div class="d-flex gap-4 align-items-center">
    <i class="bi bi-eye" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}"></i>
    <button type="button" class="btn btn-light">
      <a style="color:black; text-decoration: none;" href="{{ config('app.url') . 'gudang/sent/' . $tanggal }}">Kirim</a>
    </button>
  </div>
</div>
  
  </div>     

  
  


        <!-- Modal -->
        <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{$tanggal}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                @foreach ($items as $item)
                <li>
                    Produk {{ $item['name'] }} | Jumlah {{ $item['amount_request'] - $item['amount_received'] }} <br>
                </li>
            @endforeach
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary"><a style="color: white; text-decoration: none;" href="{{ config('app.url') . 'gudang/sent/' . $tanggal }}">Kirim</a></button>
              </div>
            </div>
          </div>
        </div>
        @endforeach
    </div>
  </div>
      @include('template.side_staff_gudang', ['pengiriman'=>'active'])     
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>