@include('template.header', ['title' => 'Halaman Pengirim'])
<body>
 
@include('template.nav')
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-4 home">
            <img class="profile" src={{asset("/picture/profile.png")}}>
          </div>
          <div class="col-12 col-lg-8 home  ">
<table class="identitas">
  <tr>
    <td><h4>Nama</h4></td>
    <td><h4>:</h4></td>
    <td><h4>{{ auth()->user()->name }}</h4></td>
  </tr>

  <tr>
    <td><h4>Jabatan</h4></td>
    <td><h4>:</h4></td>
    <td><h4>{{ auth()->user()->position }}</h4></td>
  </tr>
</table>

        </div>
      </div>
      
      </div>
      @include('template.side_pengiriman', ['home'=>'active'])     
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>