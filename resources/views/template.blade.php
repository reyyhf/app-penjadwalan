<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Penjadwalan</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/core.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/components.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/colors.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="{{ asset('assets/js/plugins/loaders/pace.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/core/libraries/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/core/libraries/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/loaders/blockui.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="{{ asset('assets/js/core/app.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/notifications/bootbox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@2.8.2/dist/alpine.min.js"></script>
    <!-- Theme JS files -->
</head>

<body class="navbar-top">

    {{-- Main Navbar --}}
    <div class="navbar navbar-default navbar-fixed-top header-highlight">
        <div class="navbar-header">
            <a class="navbar-brand" href="">
                <!-- <img src="assets/images/logo_light.png" alt=""> -->
            </a>

            <ul class="nav navbar-nav visible-xs-block">
                <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
            </ul>
        </div>

        <div class="navbar-collapse collapse" id="navbar-mobile">
            <ul class="nav navbar-nav">
                <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <img src="assets/images/placeholder.jpg" alt="">
                        <span style="text-overflow: ellipsis;">{{ Auth::user()->email }}</span>
                        <i class="caret"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
                        @if (Route::has('password.request'))
                            <li><a href="{{ route('password.request') }}" data-idubahpass="" data-toggle="modal"
                                    data-target="#modal_update_pasword"><i class="icon-cog5"></i> Ubah Password</a></li>
                        @endif
                        <li><a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();"><i
                                    class="icon-switch2"></i> Logout</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    {{-- END Main Navbar --}}

    {{-- Page Container --}}
    <div class="page-container">

        {{-- Page Content --}}
        <div class="page-content">

            {{-- Main Sidebar --}}
            <div class="sidebar sidebar-main">
                <div class="sidebar-content">

                    <!-- Main navigation -->
                    <div class="sidebar-category sidebar-category-visible">
                        <div class="category-content no-padding">
                            <ul class="navigation navigation-main navigation-accordion">

                                <li><a href="{{ route('home') }}"><i class="icon-home4"></i> <span>Home Menu</span></a>
                                </li>

                                <!-- Data Master -->
                                <li class="navigation-header"><span>Data Master</span> <i class="icon-menu"
                                        title="Data Master"></i></li>

                                <li class="site-menu-item {{ request()->is('users*') ? 'active' : '' }}">
                                    <a href="{{ route('users.index') }}">
                                        <i class="fa fa-users"></i>
                                        <span>Pengguna</span>
                                    </a>
                                </li>

                                <li class="site-menu-item {{ request()->is('teachers*') ? 'active' : '' }}">
                                    <a href="{{ route('teachers.index') }}">
                                        <i class="fa fa-graduation-cap"></i>
                                        <span>Guru</span>
                                    </a>
                                </li>

                                <li class="site-menu-item {{ request()->is('category-lessons*') ? 'active' : '' }}">
                                    <a href="{{ route('category_lessons.index') }}">
                                        <i class="fa fa-file-text"></i>
                                        <span>Kategori Pelajaran</span>
                                    </a>
                                </li>

                                <li class="site-menu-item {{ request()->is('classrooms*') ? 'active' : '' }}">
                                    <a href="{{ route('classrooms.index') }}">
                                        <i class="fa fa-building"></i>
                                        <span>Kelas</span>
                                    </a>
                                </li>

                                <li class="site-menu-item {{ request()->is('curriculum-lessons*') ? 'active' : '' }}">
                                    <a href="{{ route('curriculum_lessons.index') }}">
                                        <i class="fa fa-book"></i>
                                        <span>Struktur Kurrikulum</span>
                                    </a>
                                </li>
                                <!-- Data Master -->
                                <!-- Data Penjadwalan -->
                                <li class="navigation-header"><span>Penjadwalan</span> <i class="icon-menu"
                                        title="Data Penjadwalan"></i></li>
                                <li class="site-menu-item {{ request()->is('lesson-hours*') ? 'active' : '' }}">
                                    <a href="{{ route('lesson_hours.index') }}">
                                        <i class="fa fa-calendar"></i>
                                        <span>Jadwal Mata Pelajaran</span>
                                    </a>
                                </li>
                                <li><a href="{{ route('subject-scheduling.index') }}"><i class="fa fa-calendar"></i>
                                        <span>Penjadwalan Mata Pelajaran</span></a></li>
                                <li><a href="{{ route('tabu-search.index') }}"><i class="fa fa-flask"></i>
                                        <span>Metode Tabu Search</span></a></li>
                                <li><a href="{{ route('days.index') }}"><i class="fa fa-calendar" aria-hidden="true"></i>
                                        <span>Hari</span></a></li>
                                <li><a href="{{ route('constraints.index') }}"><i class="fa fa-cogs" aria-hidden="true"></i>
                                        <span>Constraint</span></a></li>
                                <!-- Data Penjadwalan -->

                                <!-- Laporan -->
                                <li class="navigation-header"><span>Laporan</span> <i class="fa fa-bar-chart"
                                        title="Laporan"></i></li>

                                <li><a href="{{ route('jadwal-pelajaran.index') }}"><i class="fa fa-bar-chart"></i>
                                <span>Lap. Jadwal Pelajaran</span></a></li>
                                <li><a href="{{ route('rincian-beban-mengajar.index') }}"><i class="fa fa-bar-chart"></i>
                                <span>Lap. Rincian Beban Mengajar</span></a></li>
                                <!-- Laporan -->

                            </ul>
                        </div>
                    </div>
                    <!-- /main navigation -->

                </div>
            </div>
            {{-- END Main Sidebar --}}

            {{-- Main Content --}}
            <div class="content-wrapper">

                @yield('content')
            </div>
            {{-- Main Content --}}

        </div>
        {{-- END Page Content --}}

    </div>
    {{-- END Page Container --}}
    @yield('js')
</body>

</html>
