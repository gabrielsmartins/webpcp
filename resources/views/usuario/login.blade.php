<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PCPWEB-Autenticação</title>
    @include('common.import_css')
</head>
<body class="hold-transition login-page">

    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>PCP</b>Web</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Autentique-se para entrar</p>
            <form action="{{ action('UsuarioController@login') }}" method="post">
                <div class="form-group has-feedback ">
                    <input type="text" name="login" class="form-control" value="" placeholder="Login">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                    </div>
                <div class="form-group has-feedback ">
                    <input type="password" name="senha" class="form-control"
                           placeholder="Senha">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    </div>
                <div class="row">
                    <div class="col-xs-8">
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                         <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <br><br>
        
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
        
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->

 @include('common.import_js')
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    
</body>
</html>





























