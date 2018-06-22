@extends('layouts.master')

@section('page', 'Usuário - Consulta')

@section('title','Consultar - Usuário')


@section('breadcrumb')
<!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item active">Usuários</li>
          </ul>
        </div>
      </div>
@stop



@section('content')


<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4>Usuários</h4>
        </div>
        <div class="card-body">


            @if (session('success'))
            <br>
            <div class="alert alert-success" role="alert"> 
                {{ session('success') }}
            </div>
            <br>
            @endif


            @if (session('error'))
            <br>
            <div class="alert alert-danger" role="alert"> 
                {{ session('error') }}
            </div>
            <br>
            @endif




            <div class="row">
                <div class="col-md-12">
                <div class="card-body">
                    <form method="get" action="{{ action('UsuarioController@pesquisarPorCriterio') }}" class="form-inline">
                        <div class="form-group col-md-10">
                            <label for="inlineFormInput" class="sr-only">Pesquisar por:</label>
                            <select class="form-control input-sm" name="criterio">
                                <option value="id" @if(! empty($criterio)) {{ $criterio == 'id' ? 'selected' : '' }} @endif>ID</option>
                                <option value="nome" @if(! empty($criterio)) {{  $criterio == 'nome' ? 'selected' : '' }}@endif>Nome</option>
                                <option value="login" @if(! empty($criterio)) {{  $criterio == 'login' ? 'selected' : '' }}@endif>Login</option>
                                <option value="perfil" @if(! empty($criterio)) {{  $criterio == 'perfil' ? 'selected' : '' }} @endif>Perfil</option>
                            </select>
                            <input class="form-control" placeholder=""  type="search" name="valor" @if(! empty($valor)) value=" {{ $valor }}" @endif>
                                   <button class="btn btn-primary fa fa-search" type="submit"></button>
                        </div>


                        <div class="col-md-2">
                        <div class="form-group pull-right">
                                <label><strong>Exibir:</strong></label>
                                <select name="limit" aria-controls="example1" class="form-control input-sm" >
                                    <option value="10" @if(! empty($limit)) {{ $limit == 10 ? 'selected' : '' }} @endif>10</option>
                                    <option value="25" @if(! empty($limit))  {{ $limit == 25 ? 'selected' : '' }} @endif>25</option>
                                    <option value="50" @if(! empty($limit))  {{ $limit == 50 ? 'selected' : '' }} @endif>50</option>
                                    <option value="100" @if(! empty($limit))  {{ $limit == 100 ? 'selected' : '' }} @endif>100</option>
                                </select> 
                                <label class="text-right"><strong>Registros</strong></label>
                        </div>
                        </div>

                    </form>
                </div>
                </div>
            </div>





            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Login</th>
                                    <th>Perfil</th>
                                    <th>Ativo</th>
                                    <th colspan="2">Ação</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($usuarios as $usuario)
                                <tr>
                                    <td>{{$usuario->getId() }}</td>
                                    <td>{{$usuario->getNome() }}</td>
                                    <td>{{$usuario->getLogin()}}</td>
                                    <td>{{$usuario->getPerfil()->getDescricao()}}</td>
                                    <td>{{$usuario->getAtivo()? 'Sim':'Não'}}</td>
                                    <td  style="width: 10px;">
                                        <a href="{{ URL::to('/usuario/edit/'.$usuario->getId()) }}"
                                           class="btn btn-primary"><i class="fa fa-edit fa-sm"></i>
                                        </a> 
                                    </td>
                                    <td  style="width: 50px;">
                                        @if ($usuario->getAtivo())
                                        <button type="button"class="btn btn-secondary" data-toggle="modal" data-target="#myModal{{$usuario->getId()}}"><i class="fa fa-ban fa-sm"></i></button>
                                        @else
                                        <button type="button"class="btn btn-secondary" data-toggle="modal" data-target="#myModal{{$usuario->getId()}}"><i class="fa fa-check fa-sm"></i></button>
                                        @endif


                                    </td>
                                </tr>

                                <!-- Modal -->
                            <div class="modal fade" id="myModal{{$usuario->getId()}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Atenção</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                                        </div>
                                        <div class="modal-body">
                                            @if ($usuario->getAtivo())

                                            Deseja realmente desativar este usuário?

                                            @else
                                            Deseja realmente ativar este usuário?
                                            @endif
                                        </div>
                                        @if ($usuario->getAtivo())
                                        <form action="{{ action('UsuarioController@disable') }}" method="post">
                                            <div class="modal-footer">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                <input type="hidden" name="id" value="{{$usuario->getId() }}"/>
                                                <button type="submit" class="btn btn-primary">Confirmar</button>
                                            </div>
                                        </form>

                                        @else
                                        <form action="{{ action('UsuarioController@enable') }}" method="post">
                                            <div class="modal-footer">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="button" class="btn btn-save" data-dismiss="modal">Fechar</button>
                                                <input type="hidden" name="id" value="{{$usuario->getId() }}"/>
                                                <button type="submit" class="btn btn-cancel">Confirmar</button>
                                            </div>
                                        </form>
                                        @endif



                                    </div>
                                </div>
                            </div>

                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-5">

                </div>
                <div class="col-sm-7">
                    @if(! empty($criterio))
                    {{ $usuarios->appends(['criterio'=>$criterio,'valor'=>$valor,'limit'=>$limit])->links() }}
                    @else
                    {{ $usuarios->links() }}
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

@stop


@section('js')

@stop








