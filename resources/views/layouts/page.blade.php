@extends('layouts.app')

<!-- @section('body_class', 'hold-transition skin-yellow sidebar-mini') -->

@section('body')
    <div class="wrapper flex flex_w">

        <!-- Main Header -->
        <header class="main-header flex flex_jc-sb">
            <!-- Logo -->
            <div class="header-logo flex">
                <a href="/dashboard" class="header-logo__link">2UP</a>
            </div>

            <!-- Header Navbar -->
            <div class="navbar-custom-menu">
                <a href="#">
                    <i class="fa fa-fw fa-power-off"></i> Log Out
                </a>
            </div>  
        </header>

        @include('partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">           

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>

        </div><!-- /.content-wrapper -->
        

    </div><!-- ./wrapper -->
    
@stop
