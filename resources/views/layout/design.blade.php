<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CPRMIS v3</title>

    <link href="{{asset ('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{asset ('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{asset ('css/animate.css') }}" rel="stylesheet">
    <link href="{{asset ('css/style.css') }}" rel="stylesheet">

</head>

<body class="">

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold">Hirely</span>
                            </a>

                        </div>
                        <!-- <div class="logo-element">
                            IN+
                        </div> -->
                    </li>
                    <li>
                    <li>
                        <a href="{{ url('/admin/users') }}"><i class="fa fa-users"></i> <span class="nav-label">Users</span> <span class="fa arrow"></span></a>
                    </li>

                    <li>
                        <a href="{{ url('/admin/listings') }}"><i class="fa fa-list"></i> <span class="nav-label">Listings</span> <span class="fa arrow"></span></a>
                    </li>

                    <li>
                        <a href="{{ url('/admin/comments') }}"><i class="fa fa-comment"></i> <span class="nav-label">Comments</span> <span class="fa arrow"></span></a>
                    </li>

                    </li>



                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

                    </div>
                    <ul class="nav navbar-top-links navbar-right">


                        <li>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>

                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                            @method('POST') <!-- Ensure POST method is used for logout -->
                        </form>

                    </ul>

                </nav>
            </div>

            @yield('content')

            <div class="footer">

            </div>

        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{asset ('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{asset ('js/popper.min.js') }}"></script>
    <script src="{{asset ('js/bootstrap.js') }}"></script>
    <script src="{{asset ('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{asset ('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{asset ('js/inspinia.js') }}"></script>
    <script src="{{asset ('js/plugins/pace/pace.min.js') }}"></script>


</body>

</html>