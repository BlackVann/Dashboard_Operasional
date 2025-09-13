@include('template.header', ['title' => 'Halaman Gudang'])
<body>
 
@include('template.nav')
      @include('template.side_staff_gudang', ['stok'=>"active"])     

      <div class="container">

        <div class="row">
  @if ($status)
    <h3>{{ $produk }}</h3>
      <form class="row g-3 align-items-center"  action="/gudang/stok/{{ $produk }}">

    
        

  
  <div class="col-5 col-md-5">
      <input type="text" name="datefilter" autocomplete="off" class="form-control" value="{{ \Carbon\Carbon::parse($datestart )->format('m/d/Y') ." - ". \Carbon\Carbon::parse($dateend )->format('m/d/Y')}}"> 
  </div>

<input type="hidden" name="datestart" value={{ $datestart }}>
<input type="hidden" name="dateend" value={{ $dateend}}>


    <div class="col-2 col-md-2">
      <button style="margin:0" type="submit" class="btn btn-dark">Cari</button>
    </div>
  </form>
          <table class="table" >
  <thead>
    <tr class="tr" style="text-align: center">
      <th scope="col">Tanggal</th>
      <th scope="col">Code</th>
      <th scope="col">Masuk</th>
      <th scope="col">Keluar</th>
      <th scope="col">Stok Akhir</th> 
    </tr>
  </thead>

          @foreach ($stok as $item)

          <tbody class="tr" style="text-align: center">

              <td >{{ \Carbon\Carbon::parse($item->date)->format("Y/m/d") }}</td>  
         
           @if (substr($item->code,0,2) == "IN" )
           <td ><a class="black" href={{config('app.url'). 'admin/history_in/'.$item->code}}>{{ $item->code }}</a></td> 
          @elseif(substr($item->code,0,2) == "OT" )
        <td >   <a class="black" href={{config('app.url'). 'admin/history_out/'.$item->code}}>{{ $item->code }}</a></td>
            @elseif($item->code='awal')
            <td>Stok Awal</td>
            @else
            <td>-</td>
          @endif  
           
           <td >{{ $item->in }}</td>
           <td >{{ $item->out }}</td>
           <td >{{ $item->last_item }}</td>
       
            </tbody> 

          @endforeach

    <tr>

     

    </tr>
   
  </tbody>
</table> 
@if ($pagination)
 {{ $stok->links() }}
@endif

  @else
        <h3>{{ $produk }} Tidak Ada</h3>  
  @endif
          

                </div>
               </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
      </script>
      <script>$(function() {

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
 

});</script>
</body>
</html>