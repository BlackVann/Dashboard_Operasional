@include('template.header', ['title' => 'Halaman Staff Gudang'])
<body>
 
  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop"><i class="bi bi-justify"></i></button>
        <span class="navbar-brand mb-0 h1 me-auto">Heri (Staff Gudang)</span>

    </div>
  </nav>
  
  <div class="container">
    <div class="row">
      @foreach ($data as $tanggal => $items)
      @php
      $modalId = 'modal-' . str_replace([' ', ':'], '-', $tanggal);
  @endphp
      <div class="col-3"><!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
          {{$tanggal}}
        </button>
        
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
        </div></div>
        @endforeach
    </div>
  </div>
      @include('template.side_staff_gudang', ['deliver'=>'active','sent'=>'','home' =>"" ])     
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>