@extends('layouts.master')

@section('page', 'Usuário - Editar')

@section('title','Editar - Usuário')
 

@section('content')
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Editar</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{ action('UsuarioController@update') }}"
								method="POST" accept-charset="UTF-8">
              <div class="box-body">
                <div class="form-group row">
                  <label for="descricao" class="col-sm-1 control-label">Nome:</label>

                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="nome" placeholder="Nome" name="nome" required="required" value="{{$usuario->getNome()}}">
                  </div>
                </div>
                  <div class="form-group row">
                  <label for="descricao" class="col-sm-1 control-label">Login:</label>

                  <div class="col-sm-3">
                    <input type="text" class="form-control" id="login" placeholder="Login" name="login" required="required" value="{{$usuario->getLogin()}}">
                  </div>
                </div>
                  <div class="form-group row">
                <label for="setor" class="col-sm-1 control-label">Perfil:</label>

                <div class="col-sm-3">
                    <select name="perfil" class="form-control">
                        <option value="" disabled selected>Escolha um perfil:</option>
                        @foreach($perfis as $perfil)
                              <option value="{{$perfil->getId()}}"
                                       @if ($usuario->getPerfil()->getId() == $perfil->getId()) 
                                            selected 
                                            @endif
                                      >{{$perfil->getDescricao()}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                  <div class="form-group row">
                  <label for="descricao" class="col-sm-1 control-label">Senha:</label>

                  <div class="col-sm-3">
                      <input type="password" class="form-control" id="senha" placeholder="Senha" name="senha" required="required" value="{{$usuario->getSenha()}}">
                  </div>
                </div>
                  <div class="form-group row">
                  <label for="descricao" class="col-sm-1 control-label">Confirmação Senha:</label>

                  <div class="col-sm-3">
                      <input type="password" class="form-control" id="confirmacao_senha" placeholder="Confirmação Senha" name="confirmacao_senha" required="required" value="{{$usuario->getSenha()}}">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="reset" class="btn btn-cancel pull-right fa fa-ban"> Cancelar</button>
                <button type="submit" class="btn btn-save pull-right fa fa-save"> Salvar</button>
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
              <!-- /.box-footer -->
            </form>
          </div>
@stop


