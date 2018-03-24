<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>PCPWeb - @yield('page')</title>
        @include('common.import_css')
    </head>


  <body class="hold-transition skin-red sidebar-mini">

        <div class="wrapper">

            <!-- Main Header -->
            @include('common.header')

            <!-- Left side column. contains the logo and sidebar -->
            @include('common.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>@yield('title')</h1>
                </section>

                <!-- Main content -->
                <section class="content">
                     @section('content')
                    @show
                </section>
                
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- ./wrapper -->
         @include('common.import_js')
         
        @section('js')
         
        @show
    </body>
    </html>