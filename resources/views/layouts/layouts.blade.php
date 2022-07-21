<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCHOOL MANAGEMENT SYSTEM</title>
    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">
    <!-- Styles -->
    <link href="/dashboardAssets/assets/css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
    <link href="/dashboardAssets/assets/css/lib/chartist/chartist.min.css" rel="stylesheet">
    <link href="/dashboardAssets/assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="/dashboardAssets/assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="/dashboardAssets/assets/css/lib/data-table/buttons.bootstrap.min.css" rel="stylesheet" />
    <link href="/dashboardAssets/assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="/dashboardAssets/assets/css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="/dashboardAssets/assets/css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <link href="/dashboardAssets/assets/css/lib/weather-icons.css" rel="stylesheet" />
    <link href="/dashboardAssets/assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="/dashboardAssets/assets/css/lib/helper.css" rel="stylesheet">
    <link href="/dashboardAssets/assets/css/style.css" rel="stylesheet">
</head>

<body>

    <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">
                <ul>
                    @if (Auth::user()->role->name == \App\Models\Role::ADMINISTRATOR)
                    <div class="logo"><a href="{{route('getDashboardOverview')}}">
                        <span>Dashboard</span></a></div>
                        <li class="label">Main</li>
                        <li><a href="{{route('getDashboardOverview')}}"><i class="ti-home"></i> System Overview </a></li>
                        <li><a href="{{route('getAllCourses')}}"><i class="ti-calendar"></i> Courses</a></li>
                        <li><a href="{{route('getAllTeachers')}}"><i class="ti-email"></i> Teachers</a></li>
                        <li><a href="{{route('getAllClasses')}}"><i class="ti-user"></i> Classes</a></li>
                        <li><a href="{{route('getAllUsers')}}"><i class="ti-layout-grid2-alt"></i> Users</a></li>
                    @elseif(Auth::user()->role->name == \App\Models\Role::DIRECTOR_OF_STUDIES)
                    <li><a href="{{route('getDashboardOverview')}}"><i class="ti-home"></i> System Overview </a></li>
                        <li><a href="{{route('getAllCourses')}}"><i class="ti-calendar"></i> Courses</a></li>
                        <li><a href="{{route('getAllTeachers')}}"><i class="ti-email"></i> Teachers</a></li>
                        <li><a href="{{route('getAllClasses')}}"><i class="ti-user"></i> Classes</a></li>
                    @else  
                    <li></li>  
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <!-- /# sidebar -->

    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-left">
                        <div class="hamburger sidebar-toggle">
                            <span class="line"></span>
                            <span class="line"></span>
                            <span class="line"></span>
                        </div>
                    </div>
                    <div class="float-right">
                        <div class="dropdown dib">
                            <div class="header-icon" data-toggle="dropdown">
                                <span class="user-avatar">{{Auth::user()->names}}
                                    <i class="ti-angle-down f-s-10"></i>
                                </span>
                                <div class="drop-down dropdown-profile dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-content-body">
                                        <ul>
                                            <li>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="ti-power-off"></i>
                                                    <span>Logout</span>
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
             @yield('content')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer">
                            <p><script>document.write(new Date().getFullYear())</script> © Admin Board.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jquery vendor -->
    <script src="/dashboardAssets/assets/js/lib/jquery.min.js"></script>
    <script src="/dashboardAssets/assets/js/lib/jquery.nanoscroller.min.js"></script>
    <!-- nano scroller -->
    <script src="/dashboardAssets/assets/js/lib/menubar/sidebar.js"></script>
    <script src="/dashboardAssets/assets/js/lib/preloader/pace.min.js"></script>
    <!-- sidebar -->

    <script src="/dashboardAssets/assets/js/lib/bootstrap.min.js"></script>
    <script src="/dashboardAssets/assets/js/scripts.js"></script>
    <!-- bootstrap -->

    <script src="/dashboardAssets/assets/js/lib/calendar-2/moment.latest.min.js"></script>
    <script src="/dashboardAssets/assets/js/lib/calendar-2/pignose.calendar.min.js"></script>
    <script src="/dashboardAssets/assets/js/lib/calendar-2/pignose.init.js"></script>


    <script src="/dashboardAssets/assets/js/lib/weather/jquery.simpleWeather.min.js"></script>
    <script src="/dashboardAssets/assets/js/lib/weather/weather-init.js"></script>
    <script src="/dashboardAssets/assets/js/lib/circle-progress/circle-progress.min.js"></script>
    <script src="/dashboardAssets/assets/js/lib/circle-progress/circle-progress-init.js"></script>
    <script src="/dashboardAssets/assets/js/lib/chartist/chartist.min.js"></script>
    <script src="/dashboardAssets/assets/js/lib/sparklinechart/jquery.sparkline.min.js"></script>
    <script src="/dashboardAssets/assets/js/lib/sparklinechart/sparkline.init.js"></script>
    <script src="/dashboardAssets/assets/js/lib/owl-carousel/owl.carousel.min.js"></script>
    <script src="/dashboardAssets/assets/js/lib/owl-carousel/owl.carousel-init.js"></script>
    <!-- scripit init-->
    <script src="/dashboardAssets/assets/js/dashboard2.js"></script>
    <script src="/dashboardAssets/assets/js/lib/data-table/datatables.min.js"></script>
    <script src="/dashboardAssets/assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="/dashboardAssets/assets/js/lib/data-table/buttons.flash.min.js"></script>
    <script src="/dashboardAssets/assets/js/lib/data-table/jszip.min.js"></script>
    <script src="/dashboardAssets/assets/js/lib/data-table/pdfmake.min.js"></script>
    <script src="/dashboardAssets/assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="/dashboardAssets/assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="/dashboardAssets/assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="/dashboardAssets/assets/js/lib/data-table/datatables-init.js"></script>
</body>

</html>