@extends('layouts.master')

@section('page', 'Recurso - Consulta')

@section('title','Consultar - Recurso')


@section('content')



<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4>Basic Table</h4>
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



                <div class="card-body">
                   <form method="get" action="{{ action('RecursoController@pesquisarPorCriterio') }}">
                        <div class="form-group">
                            <label for="inlineFormInput" class="sr-only">Pesquisar por:</label>
                             <select class="form-control input-sm" name="criterio">
                            <option value="id" @if(! empty($criterio)) {{ $criterio == 'id' ? 'selected' : '' }} @endif>ID</option>
                            <option value="descricao" @if(! empty($criterio)) {{  $criterio == 'descricao' ? 'selected' : '' }}@endif>Descrição</option>
                            <option value="setor" @if(! empty($criterio)) {{  $criterio == 'setor' ? 'selected' : '' }}@endif>Setor</option>
                        </select>
                        <input class="form-control input-sm" placeholder=""  type="search" name="valor" @if(! empty($valor)) value=" {{ $valor }}" @endif>
                               <button class="btn btn-save fa fa-search" type="submit"></button>
                            <div class="form-group pull-right">
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




            </div>




            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descrição</th>
                                <th>Setor</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>

                           @foreach ($recursos as $recurso)
                            <tr>
                                <td>{{$recurso->getId() }}</td>
                                <td>{{$recurso->getDescricao() }}</td>
                                <td>{{$recurso->getSetor()->getDescricao()}}</td>
                                <td  style="width: 10px;">
                                    <a href="{{ URL::to('/recurso/edit/'.$recurso->getId()) }}"
                                       class="btn btn-primary"><i class="fa fa-edit fa-sm"></i>
                                    </a> 
                                </td>
                                <td  style="width: 10px;">
                                    <button type="button"class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$recurso->getId()}}"><i class="fa fa-remove fa-sm"></i></button>
                                </td>
                            </tr>

                            <!-- Modal -->
                         <div class="modal fade" id="myModal{{$recurso->getId()}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Atenção</h4>
                                    </div>
                                    <div class="modal-body">
                                        Deseja realmente excluir?
                                    </div>
                                   
                                        <div class="modal-footer">
                                            <form action="{{ action('RecursoController@delete') }}" method="post">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="button" class="btn btn-save" data-dismiss="modal">Fechar</button>
                                            <input type="hidden" name="id" value="{{$recurso->getId() }}"/>
                                            <button type="submit" class="btn btn-cancel">Confirmar</button>
                                               </form>
                                        </div>
                                 

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
                    {{ $recursos->appends(['criterio'=>$criterio,'valor'=>$valor,'limit'=>$limit])->links() }}
                    @else
                    {{ $recursos->links() }}
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

@stop


@section('js')

@stop




