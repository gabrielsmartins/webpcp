@extends('layouts.master')

@section('page', 'Usuário - Cadastro')

@section('title','Cadastro')


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
                                <input type="text" class="form-control" id="nome" placeholder="Nome" name="nome" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="descricao" class="col-sm-1 control-label">Login:</label>

                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="login" placeholder="Login" name="login" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="setor" class="col-sm-1 control-label">Perfil:</label>

                            <div class="col-sm-3">
                                <select name="perfil" class="form-control">
                                    <option value="" disabled selected>Escolha um perfil:</option>
                                    @foreach($perfis as $perfil)
                                    <option value="{{$perfil->getId()}}">{{$perfil->getDescricao()}}</option>
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
                    <input value="Salvar" class="btn btn-primary" type="submit">
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





