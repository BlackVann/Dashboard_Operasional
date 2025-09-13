@include('template.header', ['title' => 'Halaman Admin'])
<body>
 
@include('template.nav')
<div class="container">

  <form class="row g-3 align-items-center"  action="/admin/history">

    
        
    <div class="col-6 col-md-6">
 <select class="form-select form-select" name="status">
  <option value="" disabled selected hidden>Pilih Status</option>
  <option value="done">Sudah</option>
  <option value="1">Sedang dikirim</option>
    <option value="belum">Belum dikirim</option>
</select>
    </div>
  
  <div class="col-4 col-md-4">
      <input type="text" name="datefilter" autocomplete="off" class="form-control" value="{{ \Carbon\Carbon::parse($datestart )->format('m/d/Y') ." - ". \Carbon\Carbon::parse($dateend )->format('m/d/Y')}}">  </div>

<input type="hidden" name="datestart" value={{ $datestart }}>
<input type="hidden" name="dateend" value={{ $dateend}}>

    <div class="col-2 col-md-2">
      <button style="margin:0" type="submit" class="btn btn-dark">Cari</button>
    </div>
  </form>
  <div class="row">      
    <table class="table">
    <thead>
      <tr class="tr">
        <th scope="col">Request</th>
        <th scope="col">Barang</th>
        <th scope="col">Dipesan</th>
        <th scope="col">Diterima</th>
        <th scope="col">Status</th>
        <th></th>
      </tr>
    </thead>
    @if ($status)
        @foreach($history as $data)
  
    <tbody>
      <tr class="tr">
        <td>{{ $data->time_request}}</td>
        <td>{{ $data->name }}</td>
        <td>{{ $data->amount_request }}</td>
        <td>{{ $data->amount_received }}</td>
        <td> @if ($data->amount_status =="done" &&  $data->deliver_status === 0) 
        Selesai
        @elseif($data->amount_status =="belum" && $data->deliver_status === 0 )
        Belum Dikirim
        @else 
        Sedang Dikirim
        @endif  </td>
        <td> 
          @if ($data->edit)
          <button type="button" style="padding: revert" class="btn btn-dark"><a style="color: white" href="{{config('app.url'). 'admin/request-edit/'. $data->name.'/'.$data->code}}"><i  class="bi bi-pen"></i></a></button>
          @else
<button type="button"
    onclick="alert('{{ $data->time_accepted ? 'Terakhir Dikirim '.$data->time_accepted : 'Belum Pernah Dikirim' }}')"
    style="padding: revert" class="btn btn-dark">
    <i class="bi bi-calendar3"></i>
</button>

          @endif
        </td>
         

      
   
    </tbody>
    @endforeach
    @else
    <tbody>
      <td>-</td>
      <td>-</td>
      <td>-</td>
      <td>-</td>
      <td>-</td>
    </tbody>
    @endif

  </table></div>
{{ $history->links() }}
</div>

      @include('template.side_admin_toko', ['history' =>"active"])     



                
        </div>

      </div>
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