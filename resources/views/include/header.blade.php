<header id="header" class="header">
    <div class="top-left">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{url('/'.Auth::user()->level)}}">HALAMAN ADMINISTRATOR</a>
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        </div>
    </div>
    <div class="top-right">
        <div class="header-menu">

            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle" src="{{asset('images/admin.jpg')}}" alt="User Avatar">
                </a>

                <div class="user-menu dropdown-menu">

                    <a class="nav-link" href="{{url(Auth::user()->level.'/password/ubah')}}"><i class="fa fa-angle-double-right"></i> Ganti Password</a>
                    <a class="nav-link" href="{{url('logout')}}"><i class="fa fa-angle-double-right"></i> Logout</a>
                </div>
            </div>

        </div>
    </div>
</header>