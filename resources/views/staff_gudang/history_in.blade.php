@include('template.header', ['title' => 'Halaman Gudang'])
<body>
 
@include('template.nav')
<div class="container">

  <form class="row g-3 align-items-center"  action="/gudang/history_in">

    
        
    <div class="col-5 col-md-5">
  <input type="text" list="daftar-produk" name="name"  class="form-control" placeholder="Produk" autocomplete="off">
    </div>
  
  <div class="col-5 col-md-5">
   <input type="text" name="datefilter" autocomplete="off" class="form-control" value="{{ \Carbon\Carbon::parse($datestart )->format('m/d/Y') ." - ". \Carbon\Carbon::parse($dateend )->format('m/d/Y')}}"> 
  </div>

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
        <th scope="col">Tanggal</th>
        <th scope="col">Barang</th>
        <th scope="col">Code</th>
        <th scope="col">Masuk</th>
      </tr>
      @if ($status)
      
      @foreach ($in as $item)
      <tr class="tr">
      <td >{{ \Carbon\Carbon::parse($item->time)->toDateString() }}</td>
      <td scope="col">{{ $item->produk }}</td>
      <td scope="col"><a class="black" href="{{config('app.url'). 'gudang/history_in/'.$item->code}}">{{ $item->code }}</a></td>
      <td scope="col">{{ $item->in }}</td>   
      </tr>
      @endforeach
      {{ $in->links() }}

      @else
      <tr>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
      </tr>
@endif
    </thead>
   
  </table></div></div>

      @include('template.side_staff_gudang', ['history_in'=>"active"])     



                
        </div>

      </div>
            <datalist id="daftar-produk">
        
        @foreach ($nama as $produk )
        <option value="{{ $produk['name'] }}">
        @endforeach
       </datalist>
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