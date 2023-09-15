 <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>window.Laravel = { csrfToken: '{{csrf_token()}}' }</script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <title>Academe Access | Back Office</title>
        <link rel="icon" type="image/ico" href="{{ asset('assets/logo/ap-logo.png') }}" />
        @include('partials.css_files')

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
        @yield('page-styles')
    </head>

    <body>

        <script src="{{ asset('js/app.js') }}"></script>
        @include('partials.js_files')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js"></script>
        @yield('javascript')

        <header class="header navbar navbar-fixed-top custom-header" role="banner">
            <div class="container">
                <!-- Only visible on smartphones, menu toggle -->
                <ul class="nav navbar-nav">
                    <li class="nav-toggle"><a href="javascript:void(0);" title=""><i class="icon-reorder"></i></a></li>
                </ul>
                <!--/-->

                <!-- App Logo -->
                <a class="navbar-brand" href="#!">
                    <center><img src="{{ asset('assets/logo/academeportal_logo2018_White.png') }}" alt="logo" width="120px;" style="padding-right: 25px;"/></center>
                    {{-- <strong>Academe Portal</strong> --}}
                </a>
                <!--/-->

                <!-- Sidebar Toggler -->
                <a href="#" class="toggle-sidebar bs-tooltip" data-placement="bottom" data-original-title="Toggle navigation">
                    <i class="icon-reorder"></i>
                </a>
                <!--/-->

                <!-- Top Left Menu -->
                <ul class="nav navbar-nav navbar-left">
                    <li class="hidden-xs hidden-sm">
                        <a>{{ ucfirst(Auth::user()->fullname) }}</a>
                    </li>
                </ul>
                <!-- /Top Left Menu -->

                <!-- Top Right Menu -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- User Login Dropdown -->
                    <li class="dropdown user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="username">{{ ucfirst(Auth::user()->fullname) }}</span>
                            <i class="icon-caret-down small"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#!"><i class="icon-user"></i> My Profile</a></li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="icon-key"></i> Log Out
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                    <!-- /user login dropdown -->
                </ul>
                <!-- /Top Right Menu -->
            </div>
        </header>

        <div id="container">
            <div id="sidebar" class="sidebar-fixed">
                <div id="sidebar-content">
                    @if(Auth::user()->role_id == 1)
                        @include('partials.sidebar.superadmin')
                    @elseif(Auth::user()->role_id == 2)
                        @include('partials.sidebar.admin')
                    @else
                        @include('partials.sidebar.sidebar')
                    @endif
                </div>
                <div id="divider" class="resizeable"></div>
            </div>

            <div id="content" class="wrapper">
                <div id="app">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
