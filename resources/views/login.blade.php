@include('template.header', ['title' => 'Halaman Staff Gudang'])
<body>
 <div style="height: 100vh">
        @if ($errors->any())
          <div class="alert alert-danger">
            <div>
              <ul>
                  @foreach ($errors->all() as $error)
                      <p>{{ $error }}</p>
                  @endforeach
              </ul>
            </div>
              
          </div>
        @endif
<div style="position: relative; top: 15%;">
  
  <h1 style="text-align: center">Login</h1>

    <form style="margin-left: auto; margin-right: auto; max-width: 50%; " action="/login" method="POST">
      @csrf
      <div class="mb-3">
        <label for="User" class="form-label">Name</label>
        <input type="text" class="form-control" id="User" name="name" required>
       
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
      </div>



    <button style="  display: block;
margin-left: auto;
margin-right: auto;" type="submit" class="btn btn-dark">Submit</button>
  </form>
</div>

 </div>

</body>
</html>