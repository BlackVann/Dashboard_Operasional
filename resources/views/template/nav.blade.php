<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop"><i class="bi bi-justify"></i></button>
        <span class="navbar-brand mb-0 h1 me-auto">{{ auth()->user()->name }} ({{ auth()->user()->position }})</span>
                    <div style="text-align: right;">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-light">
            <i class="bi bi-box-arrow-right"></i>
        </button>
    </form>
</div>       

    </div>
  </nav>