<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @if (auth()->check())
            <li class="nav-item">
                <a class="nav-link " href={{route('dashboard.index')}}>
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->
        @endif

      <li class="nav-heading">Pages</li>
      @if (!auth()->check())
      <li class="nav-item">
        <a class="nav-link collapsed" href={{route('home.index')}}>
          <i class="bi bi-person"></i>
          <span>Home</span>
        </a>
      </li><!-- End Profile Page Nav -->
      @endif

      <li class="nav-item">
        <a class="nav-link collapsed" href={{route('catalog.index')}}>
          <i class="bi bi-person"></i>
          <span>Catalog</span>
        </a>
      </li><!-- End Profile Page Nav -->

      @if (auth()->check())
        @if(auth()->user()->role === 'Admin')
          <li class="nav-item">
            <a class="nav-link collapsed " href={{route('user.index')}}>
            <i class="bi bi-person"></i>
            <span>Management</span>
            </a>
          </li><!-- End Dashboard Nav -->
        @endif

        @if(auth()->user()->role === 'Pegawai' || auth()->user()->role === 'Mahasiswa')
          <li class="nav-item">
              <a class="nav-link collapsed " href={{route('loans.index')}}>
              <i class="bi bi-person"></i>
              <span>Loan</span>
              </a>
          </li><!-- End Dashboard Nav -->

          <li class="nav-item">
            <a class="nav-link collapsed " href={{route('fines.index')}}>
            <i class="bi bi-person"></i>
            <span>Fines</span>
            </a>
          </li><!-- End Dashboard Nav -->
        @endif
      @endif

    </ul>

  </aside><!-- End Sidebar-->