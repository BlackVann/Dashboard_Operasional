<div class="offcanvas offcanvas-start d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel" style="width: 280px;">
    <div class="offcanvas-header mb-3 ">
      <i class="bi bi-house"></i>
      <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Staff Gudang</h5>
      <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                
              <a href="{{config('app.url'). 'gudang/home'}}" class="nav-link {{$home}} text-white" >
                <i class="bi bi-house"></i>
                Home
              </a>
            </li>
            <li>
              <a href="{{config('app.url'). 'gudang/deliver'}}"    class="nav-link {{$deliver}} text-white" >
                <i class="bi bi-envelope-paper-fill"></i>
                Delivery
              </a>
            </li>
            <li>
              <a href="{{config('app.url'). 'gudang/sent/0'}}"    class="nav-link {{$sent}} text-white" >
                <i class="bi bi-truck"></i>
                Sent
              </a>
            </li>
            
          </ul>
    </div>
  </div>
