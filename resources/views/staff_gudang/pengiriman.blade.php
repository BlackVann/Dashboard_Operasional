@include('template.header', ['title' => 'Halaman Staff Gudang'])
<body style=" overflow: hidden;">
 
  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop"><i class="bi bi-justify"></i></button>
        <span class="navbar-brand mb-0 h1 me-auto">Heri (Staff Gudang)</span>

    </div>
  </nav>
  
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
<div class="container"><div class="row">
  @if($status=='history')
  
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Time</th>
        <th scope="col">Diterima</th>
        <th scope="col">Status</th>
      </tr>
    </thead>
    @foreach($data as $data)
  
    <tbody>
      <tr>
        <td>{{ $data->time_request }}</td>
        <td>{{ $data->received }}</td>
        @php $status=explode(',', $data->status) @endphp
        @if (count(array_filter($status, fn($item) => $item != 'done')) > 0)
        <td>Sedang dikirim {{ $data->deliver }}</td>
        @else
        <td>Sudah</td>
        @endif
        
      </tr>
   
    </tbody>
    @endforeach
  </table>

    
  @else
  <div class="row"> <div class="col "><span class="badge bg-dark">Kiriman : {{$data[0]['time_request']}}</span></div>  </div>

  <form method="POST" action="/gudang/sent/{{  $data[0]['time_request'] }}">
    @csrf
    @method('PUT')
    <div id="deliver-list">
      @foreach ($data as $data )
      <div class="deliver">
       
          <div class="row">
            <div class="col">
              <label>Nama:</label>
              <input type="text" name="deliver[{{ $loop->index }}][name]" value="{{ $data['name'] }}" readonly class="form-control">
            </div>
            <div class="col">
              <label>Jumlah:</label><input type="number" name="deliver[{{ $loop->index }}][jumlah]" value="{{ $data['amount_request'] - $data['amount_received'] }}"  class="form-control" required>
            </div>
          </div>
          <input type="hidden" value="{{ $loop->index }} " name="deliver[{{ $loop->index }}][id]">
        @endforeach
      </div>
    </div>
  <br>

    <button type="submit" class="btn btn-dark">Simpan</button>
  </form>
  @endif
</div></div> 
      @include('template.side_staff_gudang', ['home'=>'','sent'=>'active','deliver' =>""])     
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>