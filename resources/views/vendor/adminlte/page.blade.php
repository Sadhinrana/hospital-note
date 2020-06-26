@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">

{{--                            <li class="dropdown user user-menu">--}}
{{--                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">--}}

{{--                                      <i class="fa fa-bell">--}}
{{--                                          @if (auth()->user()->unreadNotifications->count())--}}
{{--                                             <span class="badge badge-light">--}}
{{--                                                {{auth()->user()->unreadNotifications->count()}}--}}
{{--                                              </span>--}}
{{--                                          @endif--}}

{{--                                      </i>--}}

{{--                                    </a>--}}
{{--                                    <ul class="dropdown-menu">--}}
{{--                                      <!-- User image -->--}}
{{--                                            <h4 class="text-center">Notifications</h4>--}}

{{--                                      <!-- Menu Footer-->--}}

{{--                                      <li class="user-body">--}}
{{--                                           <a href="{{route('markAsRead')}}" class="btn btn-sm btn-info">Mark all as Read</a><br>--}}

{{--                                            @foreach (auth()->user()->unreadNotifications as $notification)--}}
{{--                                                <a href="#" class="bg-warning">--}}
{{--                                                    {{$notification->data['data']}}</a>--}}
{{--                                            @endforeach--}}
{{--                                            <hr>--}}
{{--                                            @foreach (auth()->user()->readNotifications as $notification)--}}
{{--                                                <a href="#">{{$notification->data['data']}}</a>--}}
{{--                                            @endforeach--}}

{{--                                          </li>--}}
{{--                                    </ul>--}}
{{--                                  </li>--}}


                         <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                  <img src="{{asset('img/user.png')}}" class="user-image" alt="User Image">
                                  <span class="hidden-xs">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</span>
                                </a>
                                <ul class="dropdown-menu">
                                  <!-- User image -->
                                  <li class="user-header">
                                    <img src="{{asset('img/user.png')}}" class="img-circle" alt="User Image">

                                    <p>
                                      {{auth()->user()->role->name ?? 'No Department'}}
                                      <small>Member since {{date('F jS, Y', strtotime(auth()->user()->created_at))}}</small>
                                    </p>
                                  </li>

                                  <!-- Menu Footer-->
                                  <li class="user-body">
                                    <div class="pull-left">
                                        <a href="{{route('users.my_profile')}}" class="btn btn-default btn-flat">My Profile</a>
                                    </div>
                                    <div class="pull-right" class="btn btn-default btn-flat">
                                      {{-- <a href="#" class="btn btn-default btn-flat">Sign out</a> --}}
                                      @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))

                                    <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                            <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                        </a>
                                    @else
                                        <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        >
                                            <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                        </a>
                                        <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;" class="btn btn-default btn-flat">
                                            @if(config('adminlte.logout_method'))
                                                {{ method_field(config('adminlte.logout_method')) }}
                                            @endif
                                            {{ csrf_field() }}
                                        </form>
                                    @endif
                                    </div>
                                  </li>
                                  {{-- <li class="user-footer">
                                        <div class="row">
                                            <h4 class="text-center">Notifications</h4><hr>
                                          <div class="col-xs-4 text-center">
                                            <a href="#" class="btn btn-info btn-sm">Mark As Read</a>
                                          </div>
                                          <div class="col-xs-4 text-center">
                                            <a href="#">Unread</a>
                                          </div>
                                          <div class="col-xs-4 text-center">
                                            <a href="#">Read</a>
                                          </div>
                                        </div>
                                        <!-- /.row -->
                                      </li> --}}
                                </ul>
                              </li>


                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">
                @include('inc.messages')
                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
@stop


@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
