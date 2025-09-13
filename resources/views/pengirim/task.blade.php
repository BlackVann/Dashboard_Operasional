@include('template.header', ['title' => 'Halaman Pengirim'])
<body>
 
@include('template.nav')
      
      <div class="container">
        <div class="row">
          
          @foreach ($data as $tanggal => $items)
          @php
   
          $modalId = 'modal-' . str_replace([' ', ':'], '-', $tanggal);
        @endphp
            <div class="col-12 col-md-4 d-flex justify-content-center mt-3">
              <div class="card" style="width: 18rem; height: 100px;">
                  <div class="card-body">
                      <h6 style="margin-bottom: 10px" class="card-title text-center">{{ preg_replace('/[^A-Za-z0-9]/', '', $tanggal) }}</h6>
  
                      <div style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);" >
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                          Kirim
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
                        Produk {{ $item['name'] }} | Jumlah  {{ $item['amount_deliver'] }} <br>
                    </li>
                @endforeach
                  </div>
                  <div class="modal-footer">
                    <form method="POST" action="/pengirim/sent/{{  $tanggal }}">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="location" value="{{ $items[0]['location'] }}" >
                    <button type="submit" class="btn btn-dark">Kirim</a></button>
                  </form>
                  </div>
                </div>
              </div>
            </div></div>
            @endforeach
        
        </div>
      </div>


      @include('template.side_pengiriman', ['home'=>'
      ','task' =>"active"])     
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>