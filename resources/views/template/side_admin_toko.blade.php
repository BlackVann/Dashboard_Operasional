<div class="offcanvas offcanvas-start d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel" style="width: 280px;">
        <div class="offcanvas-header mb-3 ">
          <i class="bi bi-calculator-fill"></i>
          <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Admin Toko</h5>
          <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    
                  <a href="{{config('app.url'). 'admin/home'}}" class="nav-link {{$home}} text-white" >
                    <i class="bi bi-house"></i>
                    Home
                  </a>
                </li>
                <li>
          
                  <a href="{{config('app.url'). 'admin/stok'}}" class="nav-link {{$stok}} text-white">
                    <i class="bi bi-box-seam-fill"></i>
                    Stok
                  </a>
                </li>
                <li>
                  <a href="{{config('app.url'). 'admin/history'}}"    class="nav-link {{$history}} text-white" >
                    <i class="bi bi-clock-history"></i>
                    History Sent
                  </a>
                </li>
                <li>
                  <a href="{{config('app.url'). 'admin/request'}}"    class="nav-link {{$request}} text-white" >
                    <i class="bi bi-chat-left-text-fill"></i>
                    Request
                  </a>
                </li>
                
              </ul>
        </div>
      </div>
