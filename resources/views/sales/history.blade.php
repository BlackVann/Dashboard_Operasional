@include('template.header', ['title' => 'Halaman Sales'])

<body>
 
@include('template.nav')
<div class="container">
  <form class="row g-3 align-items-center" action="/sales/history">

    
        <div class="col-6 col-md-3">
      <input type="text" id="inputproduk" class="form-control" placeholder="Produk" name="produk" autocomplete="off" list="daftar-produk">
    </div>
    <div class="col-6 col-md-3">
      <input type="text" id="inputname" class="form-control" placeholder="Customer" name="customer"autocomplete="off">
    </div>
  
  <div class="col-8 col-md-3">
      <input type="text" name="datefilter" autocomplete="off" class="form-control" value="{{ \Carbon\Carbon::parse($datestart )->format('m/d/Y') ." - ". \Carbon\Carbon::parse($dateend )->format('m/d/Y')}}"> 
  </div>
<input type="hidden" name="datestart" value={{ $datestart }}>
<input type="hidden" name="dateend" value={{ $dateend}}>

    <div class="col-2 col-md-3">
      <button style="margin:0" type="submit" class="btn btn-dark">Cari</button>
    </div>
  </form>
  
  <div class="row">

<table class="table">
  <thead>
    <tr class="tr">
      <th scope="col">Waktu</th>
      <th scope="col">Barang</th>
      <th scope="col">Customer</th>
      <th scope="col">Jumlah</th>
      <th scope="col">Harga</th>
      <th scope="col">Total</th>
    </tr>
  </thead>
  @if ($status)
  @foreach($history as $data)
     
  <tbody>
    <tr class="tr">
      <td>{{ $data['time'] }}</td>
      <td>{{ $data["produk"] }}</td>
      <td>{{ $data['customer'] }}</td>
      <td>{{ $data['out'] }}</td>
      <td>{{ number_format($data['price'], 0, ',', '.') }}</td>
      <td>{{ number_format($data['total'], 0, ',', '.') }}</td>
    </tr>
 
  </tbody>
   
  @endforeach
   <tbody>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td class="td">{{ $total }}</td>
    </tr>
 
  </tbody>
  {{ $history->links() }}
  @else
    <tbody>
<tr>
  <td>-</td>
  <td>-</td>
  <td>-</td>
  <td>-</td>
  <td>-</td>
  <td>-</td>
</tr>
     </tbody>

  @endif


</table>
            <datalist id="daftar-produk">
        
        @foreach ($nama as $produk )
        <option value="{{ $produk['name'] }}">
        @endforeach
       </datalist>

  </div>

</div>


      @include('template.side_sales', ['home'=>'','sell'=>'','history' =>"active"])     
      <script type="text/javascript">
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
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>