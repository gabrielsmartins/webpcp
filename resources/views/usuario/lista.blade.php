@extends('layouts.master')

@section('page', 'Usuário - Consulta')

@section('title','Consultar - Usuário')


@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Usuário</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <form method="get" action="{{ action('UsuarioController@pesquisarPorCriterio') }}">
                    <div class="col-sm-6">
                        <label>Pesquisar por: </label>

                        <select class="form-control input-sm" name="criterio">
                            <option value="id" @if(! empty($criterio)) {{ $criterio == 'id' ? 'selected' : '' }} @endif>ID</option>
                            <option value="nome" @if(! empty($criterio)) {{  $criterio == 'nome' ? 'selected' : '' }}@endif>Nome</option>
                            <option value="login" @if(! empty($criterio)) {{  $criterio == 'login' ? 'selected' : '' }}@endif>Login</option>
                            <option value="perfil" @if(! empty($criterio)) {{  $criterio == 'perfil' ? 'selected' : '' }} @endif>Perfil</option>
                        </select>
                        <input class="form-control input-sm" placeholder=""  type="search" name="valor" @if(! empty($valor)) value=" {{ $valor }}" @endif>
                               <button class="btn btn-save fa fa-search" type="submit"></button>
                    </div>
                    <div class="col-sm-6">
                        <div class="pull-right">
                            <label>Exibir </label>
                            <select name="limit" aria-controls="example1" class="form-control input-sm" >
                                <option value="10" @if(! empty($limit)) {{ $limit == 10 ? 'selected' : '' }} @endif>10</option>
                                <option value="25" @if(! empty($limit))  {{ $limit == 25 ? 'selected' : '' }} @endif>25</option>
                                <option value="50" @if(! empty($limit))  {{ $limit == 50 ? 'selected' : '' }} @endif>50</option>
                                <option value="100" @if(! empty($limit))  {{ $limit == 100 ? 'selected' : '' }} @endif>100</option>
                            </select> 
                            <label>Registros</label>
                        </div>
                    </div>

                </form> 
            </div>

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
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc"  rowspan="1" colspan="1" >ID</th>
                                <th class="sorting"  rowspan="1" colspan="1" >Nome</th>
                                <th class="sorting"  rowspan="1" colspan="1">Login</th>
                                <th class="sorting"  rowspan="1" colspan="1">Perfil</th>
                                <th class="sorting"  rowspan="1" colspan="1">Ativo</th>
                                <th class="sorting"  rowspan="1" colspan="2" style="width: 10px;">Ação</th>
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
                                       class="btn btn-save"><i class="fa fa-edit fa-sm"></i>
                                    </a> 
                                </td>
                                <td  style="width: 10px;">
                                    @if ($usuario->getAtivo())
                                       <button type="button"class="btn btn-cancel" data-toggle="modal" data-target="#myModal{{$usuario->getId()}}"><i class="fa fa-ban fa-sm"></i></button>
                                    @else
                                       <button type="button"class="btn btn-cancel" data-toggle="modal" data-target="#myModal{{$usuario->getId()}}"><i class="fa fa-check fa-sm"></i></button>
                                    @endif
                                    
                                   
                                </td>
                            </tr>

                            <!-- Modal -->
                        <div class="modal fade" id="myModal{{$usuario->getId()}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Atenção</h4>
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
                                            <button type="button" class="btn btn-save" data-dismiss="modal">Fechar</button>
                                            <input type="hidden" name="id" value="{{$usuario->getId() }}"/>
                                            <button type="submit" class="btn btn-cancel">Confirmar</button>
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
    <!-- /.box-body -->
</div>
@stop


@section('js')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@stop