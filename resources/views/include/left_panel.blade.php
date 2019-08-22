<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="dasboard">
                    <a href="{{url('/'.Auth::user()->level)}}"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                </li>
                <li class="menu-title">Pengolahan Data</li><!-- /.menu-title -->
                <li class="menu-item-has-children dropdown jadwal">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <i class="menu-icon fa fa-calendar"></i>Jadwal Mata Kuliah</a>
                    <ul class="sub-menu children dropdown-menu ">
                        <li><i class="fa fa-angle-double-right"></i><a href="{{url('admin/jadwal/daftar')}}">Daftar</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown pindah">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-calendar-check-o"></i>Jadwal Pindah MK</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-angle-double-right"></i><a href="{{url('admin/pindah/jadwal/daftar')}}">Daftar</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown informasi">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bullhorn"></i>Pengumuman</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-angle-double-right"></i><a href="{{url('admin/informasi/daftar')}}">Daftar</a></li>
                    </ul>
                </li>
                @if(Auth::user()->isLevel('admin'))  
                    <li class="menu-title">Data Master</li><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown mk">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-book"></i>Mata Kuliah</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-angle-double-right"></i><a href="{{url('admin/mk/daftar')}}">Daftar</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown dosen">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-address-book-o"></i>Dosen</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-angle-double-right"></i><a href="{{url('admin/dosen/daftar')}}">Daftar</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown kelas">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-sign-in"></i>Kelas</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-angle-double-right"></i><a href="{{url('admin/kelas/daftar')}}">Daftar</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown semester">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-line-chart"></i>Tahun Ajaran</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-angle-double-right"></i><a href="{{url('admin/semester/daftar')}}">Daftar</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
    <!-- /#left-panel -->