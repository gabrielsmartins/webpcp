<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>PCPWEB-Autenticação</title>
        @include('common.import_css')
    </head>


    

<body class="bg-dark vertical-center">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
             
                <div class="row">
                    <div class="col-md-6 mx-auto">

                        <!-- form card login -->
                        <div class="card rounded-0">
                            <div class="card-header text-center">
                                <div class="logo text-uppercase text-center mb-4"><span>PCP</span><strong class="text-primary">WEB</strong></div>
                                <h3 class="mb-0">Autenticão de Usuário</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ action('UsuarioController@login') }}"  class="text-left form-validate"  role="form" autocomplete="off" id="formLogin" novalidate="" method="POST">
                                    <div class="form-group-material">
                                        <input id="login-username" type="text" name="login" required data-msg="Please enter your username" class="input-material" value="{{ old('login')}}">
                                <label for="login-username" class="label-material">Username</label>
                                    </div>
                                    <div class="form-group-material">
                                         <input id="login-password" type="password" name="senha" required data-msg="Please enter your password" class="input-material">
                                <label for="login-password" class="label-material">Password</label>
                                    </div>
                                   <div class="form-group text-center">
                                <div class="form-group text-center">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                                </form>
                            </div>
                            <!--/card-block-->
                        </div>
                        <!-- /form card login -->

                    </div>


                </div>
                <!--/row-->

            </div>
            <!--/col-->
        </div>
        <!--/row-->


        @if (session('success'))
        <div class="alert alert-success" role="alert"> 
            {{ session('success') }}
        </div>
        @endif


        @if (session('error'))
        <div class="alert alert-danger" role="alert"> 
            {{ session('error') }}
        </div>
        @endif
    </div>
    <!--/container-->
</body>


    <!-- JavaScript files-->
    @include('common.import_js')
    <!-- Main File-->


    @section('js')
    <!-- Main File-->

    <script src="{{ asset('dashboard/js/front.js') }}"></script>
    @stop

</html>































