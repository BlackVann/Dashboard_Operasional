@include('template.header', ['title' => 'Halaman Staff Gudang'])
<body style=" overflow: hidden;">
 
@include('template.nav')
  
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
  
<form class="row g-3 align-items-center" method="POST" action="/gudang/sent/0">
    @csrf
    
        
    <div class="col-6 col-md-6">
 <select class="form-select form-select" name="status">
  <option value="" disabled selected hidden>Pilih Status</option>
  <option value="done">Sudah</option>
  <option value="1">Sedang dikirim</option>
    <option value="belum">Belum dikirim</option>
</select>
    </div>
  
  <div class="col-4 col-md-4">
    <input type="text" name="datefilter" autocomplete="off" placeholder="Waktu" class="form-control"/>
  </div>

<input type="hidden" name="datestart" value="">
<input type="hidden" name="dateend" value="">

    <div class="col-2 col-md-2">
      <button style="margin:0" type="submit" class="btn btn-dark">Cari</button>
    </div>
  </form>
  
  
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Time</th>
        <th scope="col">Request</th>
        <th scope="col">Diterima</th>
        <th scope="col">Status</th>
      </tr>
    </thead>
        @foreach($data as $data)
    @php 
  $request = explode(',', $data->request);
  $status_deliver = explode(',', $data->status_deliver);
    $status = explode(',', $data->status);
  $name=explode(",",$data->name);
  $deliver=explode(",",$data->deliver);

@endphp
<tbody>
      <tr>
        <td>{{ $data->time_request }}</td>
        <td>{{ $data->received }}</td>
         <td>
        

        @foreach ($request as $request)
        {{ $request }}
        @if (!$loop->last), @endif
        @endforeach
         </td>
<td>
       @foreach ($status as $status)
          @if ($status == 'done')
          Sudah
        
          @elseif ($status != 'done'&& $status_deliver[ $loop->iteration-1]==0)
          Belum dikirim
        @else
        Sedang dikirim {{ $deliver[$loop->iteration-1] }}
        @endif
         @if (!$loop->last), @endif
       @endforeach
        <td>
      
        
      </tr>
   
    </tbody>
    @endforeach</table>

    
  @else
  <div class="row"> 
    <div class="col ">
    <span class="badge bg-dark">Kiriman : {{$data[0]['time_request']}}</span></div>
  </div>
  <div class="col">
      <span class="badge bg-dark">Request : {{$data[0]['location']}}</span></div>
  </div>
  


  <form method="POST" action="/gudang/sent/{{ preg_replace('/[^A-Za-z0-9]/', '', $data[0]['code'])  }}">
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
             <input type="hidden" name="deliver[{{ $loop->index }}][location]" value="{{ $data['location'] }}" readonly class="form-control">
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
      @include('template.side_staff_gudang', ['sent'=>'active'])     
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      <script >
$(function() {

  $('input[name="datefilter"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });

  $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
    $('input[name="datestart"]').val(picker.startDate.format('YYYY-MM-DD'));
        $('input[name="dateend"]').val(picker.endDate.format('YYYY-MM-DD'));
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
      
  });
 

});
</script>
</body>
</html>