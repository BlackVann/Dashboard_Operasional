@include('template.header', ['title' => 'Halaman Gudang'])
<body>
 
@include('template.nav')
<div class="container">
@if ($status)
<br>
<h1>PT {{ $note->perusahaan }}</h1>
<h5>No Nota : {{ $note->no_nota }}</h5>


  <div class="row row-table">      
    <table class="table">
    <thead>
      <tr class="tr">
        <th scope="col">Barang</th>
        <th scope="col">Masuk</th>
    
   

      </tr>

      
      
      @foreach ($data as $item)
      <tr>
      <td scope="col">{{ $item['produk'] }}</td>
      <td scope="col">{{ $item['in'] }}</td>  
      </tr>
      @endforeach


    </thead>
   
  </table></div>
        <b>Catatan :</b> <br>
      {{ $note->catatan }}
@else
<h2>Data Tidak Ada</h2>
@endif
</div>

      @include('template.side_staff_gudang', ['history_in'=>"active"])     



                
        </div>

      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      
</body>
</html>