<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>PCPWEB-Autenticação</title>
        @include('common.import_css')
    </head>


    <body>
        <div class="page login-page bg-dark">
            <div class="container">
                <div class="form-outer text-center d-flex align-items-center">
                    <div class="form-inner">
                        <div class="logo text-uppercase"><span>PCP</span><strong class="text-primary">WEB</strong></div>
                        <p>Sistema para Planejamento e Controle de Produção</p>
                        <form action="{{ action('UsuarioController@login') }}" method="post" class="text-left form-validate">
                            <div class="form-group-material">
                                <input id="login-username" type="text" name="login" required data-msg="Please enter your username" class="input-material">
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
                </div>


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


        </div>
    </body>
    <!-- JavaScript files-->
    @include('common.import_js')
    <!-- Main File-->


    @section('js')
    <!-- Main File-->
    
    <script src="{{ asset('dashboard/js/front.js') }}"></script>
    @stop

</html>


































