<div class="offcanvas offcanvas-start d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel" style="width: 280px;">
        <div class="offcanvas-header mb-3 ">
          <i class="bi bi-car-front-fill"></i>
          <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">{{ auth()->user()->position }} </h5>
          <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div >
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    
                  <a href="{{config('app.url'). 'pengirim/home'}}" class="nav-link {{$home?? ''}} text-white" >
                    <i class="bi bi-house"></i>
                    Home
                  </a>
                </li>
                <li>
                  <a href="{{config(key: 'app.url'). 'pengirim/task'}}"    class="nav-link {{$task?? ''}} text-white" >
                    <i class="bi bi-box-seam-fill"></i>
                    Pengiriman
                  </a>
                </li>
                
              </ul>
        </div>
      </div>
