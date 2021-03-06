@extends('layouts.master')

@section('page', 'Usuário - Cadastro')

@section('title','Cadastro')

@section('breadcrumb')
<!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/usuario/show')}}">Usuários</a></li>
            <li class="breadcrumb-item active">Cadastro</li>
          </ul>
        </div>
      </div>
@stop




@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>Novo Usuário</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ action('UsuarioController@store') }}" method="POST" accept-charset="UTF-8">


                        <div class="form-group row">
                            <label for="descricao" class="col-sm-1 control-label">Nome:</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="nome" placeholder="Nome" name="nome" required="required" value="{{old('nome')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="descricao" class="col-sm-1 control-label">Login:</label>

                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="login" placeholder="Login" name="login" required="required" value="{{old('login')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="setor" class="col-sm-1 control-label">Perfil:</label>

                            <div class="col-sm-3">
                                <select name="perfil" class="form-control">
                                    <option value="" disabled selected>Escolha um perfil:</option>
                                    @foreach($perfis as $perfil)
                                    <option value="{{$perfil->getId()}}" @if($perfil->getId() == old('perfil')) selected='true' @endif>{{$perfil->getDescricao()}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="descricao" class="col-sm-1 control-label">Senha:</label>

                            <div class="col-sm-3">
                                <input type="password" class="form-control" id="senha" placeholder="Senha" name="senha" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="descricao" class="col-sm-1 control-label">Confirmação Senha:</label>

                            <div class="col-sm-3">
                                <input type="password" class="form-control" id="confirmacao_senha" placeholder="Confirmação Senha" name="confirmacao_senha" required="required">
                            </div>
                        </div>

                        <div class="form-group">       
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="reset" class="btn btn-secondary pull-right fa fa-ban"> Cancelar</button>
                            <button type="submit" class="btn btn-primary pull-right fa fa-save"> Salvar</button>
                        </div>
                </div>



                </form>
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

</div>

@stop





