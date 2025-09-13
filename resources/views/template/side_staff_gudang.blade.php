<div class="offcanvas offcanvas-start d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel" style="width: 280px;">
    <div class="offcanvas-header mb-3 ">
      <i class="bi bi-house"></i>
      <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">{{ auth()->user()->position }} </h5>
      <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div >
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                
              <a href="{{config('app.url'). 'gudang/home'}}" class="nav-link {{$home?? ''}} text-white" >
                <i class="bi bi-house"></i>
                Home
              </a>
            </li>
            <li>
            <a href="{{config('app.url'). 'gudang/stok'}}"    class="nav-link {{$stok ?? ''}} text-white" >
                <i class="bi bi-box-seam-fill"></i>
                Stok
              </a>
            </li>
                        <li>
              <a href="{{config('app.url'). 'gudang/in'}}"    class="nav-link {{$in?? ''}} text-white" >
                <i class="bi bi-calendar-check-fill"></i>
                Stok Masuk
              </a>
            </li>
            <li>
              <a href="{{config('app.url'). 'gudang/deliver'}}"    class="nav-link {{$pengiriman?? ''}} text-white" >
                <i class="bi bi-envelope-paper-fill"></i>
                Pengiriman
              </a>
            </li>
            <li>
              <a href="{{config('app.url'). 'gudang/sent/0'}}"    class="nav-link {{$sent ?? ''}} text-white" >
                <i class="bi bi-truck"></i>
                Kirim
              </a>
            </li>
             <a href="{{config('app.url'). 'gudang/history_in'}}"    class="nav-link {{$history_in?? ''}} text-white" >
                <i class="bi bi-box-arrow-left"></i>
                    History Masuk
                  </a>
                </li>
                                                <li>
                  <a href="{{config('app.url'). 'gudang/history_out'}}"    class="nav-link {{$history_out ?? ''}} text-white" >
               <i class="bi bi-box-arrow-right"></i>
                History Keluar
                  </a>
                </li>
            <li>
              
            
          </ul>
    </div>
  </div>
