<div class="offcanvas offcanvas-start d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel" style="width: 280px;">
        <div class="offcanvas-header mb-3 ">
            <i class="bi bi-cart2"></i>
          <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">{{ auth()->user()->position }} {{ auth()->user()->location }}</h5>
          <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div >
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    
                  <a href="{{config('app.url'). 'sales/home'}}" class="nav-link {{$home?? ''}} text-white" >
                    <i class="bi bi-house"></i>
                    Home
                  </a>
                </li>
                <li>
                  <a href="{{config('app.url'). 'sales/sell'}}" class="nav-link {{$sell?? ''}} text-white">
                    <i class="bi bi-coin"></i>
                    Jual
                  </a>
                </li>
                <li>
                  <a href="{{config('app.url'). 'sales/history'}}" class="nav-link {{$history?? ''}} text-white">
                    <i class="bi bi-bag"></i>
                    History Penjualanan
                  </a>
                </li>
                
              </ul>
        </div>
      </div>