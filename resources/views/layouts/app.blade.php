<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" sizes="48x48" href="../images/fevicon.png">
        <title>TIRE RETREADING MANAGEMENT SYSTEM</title>

        <!-- Bootstrap -->
        <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- jQuery custom content scroller -->
        <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>

        <!-- Custom Theme Style -->
        <link href="../build/css/custom.min.css" rel="stylesheet">
        @yield('css')
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="{{url('home')}}" class="site_title"><span>TIRE RETREADING MANAGEMENT SYSTEM</span></a>
                        </div>

                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <img src="../images/user.png" alt="..." class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span>Welcome,</span>
                                <h2>{{ Auth::user()->name }}</h2>
                            </div>
                        </div>
                        <!-- /menu profile quick info -->

                        <br />

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <h3>MAIN NAVIGATION</h3>
                                <ul class="nav side-menu">
                                    <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="#">Dashboard</a></li>
                                        </ul>
                                    </li>
                                    @foreach (Auth::user()->user_permission as $per)
                                        @if($per->per_id == '1')
                                        <li><a href="{{url('view_users')}}"><i class="fa fa-user"></i> User Management</a></li>
                                        @elseif ($per->per_id == '5')
                                        <li><a href="{{url('view_customers')}}"><i class="fa fa-user"></i> Customer Management</a></li>
                                        @elseif ($per->per_id == '9')
                                        <li><a href="{{url('view_tyres')}}"><i class="fa fa-car"></i> Tyre Management</a></li>
                                        @elseif ($per->per_id == '19')
                                        <li><a href="{{url('view_prices')}}"><i class="fa fa-money"></i> Price Management</a></li>
                                        @elseif ($per->per_id == '23')
                                        <li><a href="{{url('view_grn')}}"><i class="fa fa-database"></i> GRN Management</a></li>
                                        @elseif ($per->per_id == '26')
                                        <li><a href="{{url('view_orders')}}"><i class="fa fa-cubes"></i> Order Management</a></li>
                                        @elseif ($per->per_id == '33')
                                        <li><a href="{{url('view_completeorders')}}"><i class="fa fa-cubes"></i>Complete Order Management</a></li>
                                        @elseif ($per->per_id == '36')
                                        <li><a href="{{url('view_payments')}}"><i class="fa fa-bank"></i> Payment Management</a></li>
                                        @elseif ($per->per_id == '40')
                                        <li><a><i class="fa fa-book"></i> Report <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                            <li><a href="{{route('invoice.index')}}">Invoice Summary Report</a></li>
                                            <li><a href="{{route('stock_report.index')}}">Stock Report</a></li>
                                            </ul>
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->
                        <div class="sidebar-footer hidden-small">
                            <a data-toggle="tooltip" data-placement="top" title="Settings">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Lock">
                                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                        <!-- /menu footer buttons -->
                    </div>
                </div>

                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>

                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="../images/user.png" alt="">{{ Auth::user()->name }}
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    @yield('content')
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        Developed by <a href="">DMCC</a>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>

        <!-- jQuery -->
        <script src="../vendors/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="../vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="../vendors/nprogress/nprogress.js"></script>
        <!-- jQuery custom content scroller -->
        <script src="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>

        <!-- Custom Theme Scripts -->
        <script src="../build/js/custom.min.js"></script>
        @yield('js')
    </body>
</html>