@include('template.header', ['title' => 'Halaman Staff Gudang'])
<body>
 
@include('template.nav')
            <div class="container">

        <div class="row">
  <div class="col-10"><h3>Total Stok</h3></div>
          <div class="col-2" style="text-align: end"><a href="stok/add"><button type="button" class="btn btn-dark">+</button></a></div>
          
          <table class="table" >
  <thead>
    <tr>
      <th scope="col">Produk</th>
      <th scope="col">Stok</th>
      <th scope="col"></th>
    </tr>
  </thead>

          @foreach ($stok as $item)
          @if ($item->amount <= 100)
                     <tbody>
           <td class="table-danger">{{ $item->name }}</td>    
           <td class="table-danger">{{ $item->amount }}</td>
            <td class="table-danger"><a style="display: inline-block;"  href={{config('app.url'). 'gudang/stok/'.$item->name}}><button type="button" class="btn btn-danger history-stock"><i class="bi bi-eye "></i></button></a>          
            <form style="display: inline-block;" method="POST" action="/gudang/stok">
          @csrf
            @method('DELETE')
          <input type="hidden" name="name" value="{{ $item->name }}">
      
           <button type="submit" class="btn btn-danger same"><i class="bi bi-trash"></i></button>
          </form></td>            </tbody> 
          @else
                               <tbody>
           <td >{{ $item->name }}</td>    
           <td >{{ $item->amount }}</td>
          <td ><a style="display: inline-block;"  href={{config('app.url'). 'gudang/stok/'.$item->name}}><button type="button" class="btn btn-dark history-stock"><i class="bi bi-eye "></i></button></a>          
            <form style="display: inline-block;" method="POST" action="/gudang/stok">
          @csrf
            @method('DELETE')
          <input type="hidden" name="name" value="{{ $item->name }}">
      
           <button type="submit" class="btn btn-dark same"><i class="bi bi-trash"></i></button>
          </form></td>
            </tbody> 
          @endif

          @endforeach

    <tr>

     

    </tr>
   
  </tbody>
</table>
{{ $stok->links() }}
                </div>
               </div>
      @include('template.side_staff_gudang', [ 'stok'=>"active"])     
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      <script>
    @session('alert')
        alert("{{ $value }}");
    @endsession
</script>
</body>
</html>