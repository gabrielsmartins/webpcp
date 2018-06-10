<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">
        <title>PCPWeb - @yield('page')</title>
        @include('common.import_css')
    </head>

    <body>
        <!-- Sidebar -->
        @include('common.sidebar')

        <div class="page">

            <!-- Main Header -->
            @include('common.header')


            <!-- Breacrumb -->
            @section('breadcrumb')

            @show


            <section>
                
                @section('content')
                @show


            </section>



            <!-- Footer -->
            @include('common.footer')
        </div>
        <!-- ./wrapper -->
        @include('common.import_js')

        @section('js')

        @show
    </body>
</html>