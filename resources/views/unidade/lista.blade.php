@extends('layouts.master')

@section('page', 'Unidade de Medida - Consulta')

@section('title','Consultar - Unidade de Medida')


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
                    <form method="get" action="{{ action('UnidadeMedidaController@pesquisarPorCriterio') }}" class="form-inline">
                        <div class="form-group">
                            <label for="inlineFormInput" class="sr-only">Pesquisar por:</label>
                            <select class="form-control input-sm" name="criterio">
                                <option value="id" @if(! empty($criterio)) {{ $criterio == 'id' ? 'selected' : '' }} @endif>ID</option>
                                <option value="descricao" @if(! empty($criterio)) {{  $criterio == 'descricao' ? 'selected' : '' }}@endif>Descrição</option>
                                <option value="sigla" @if(! empty($criterio)) {{  $criterio == 'sigla' ? 'selected' : '' }} @endif>Sigla</option>
                            </select>
                            <input class="form-control input-sm" placeholder=""  type="search" name="valor" @if(! empty($valor)) value=" {{ $valor }}" @endif>
                                   <button class="btn btn-primary fa fa-search" type="submit"></button>
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
                                <th>Sigla</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($unidades as $unidade)
                            <tr>
                                <td>{{$unidade->getId() }}</td>
                                <td>{{$unidade->getDescricao() }}</td>
                                <td>{{$unidade->getSigla()}}</td>
                                <td  style="width: 10px;">
                                    <a href="{{ URL::to('/unidade/edit/'.$unidade->getId()) }}"
                                       class="btn btn-primary"><i class="fa fa-edit fa-sm"></i>
                                    </a> 
                                </td>
                                <td style="width: 10px;">
                                    <button type="button"class="btn btn-danger" data-toggle="modal" data-target="#myModal{{$unidade->getId()}}"><i class="fa fa-remove fa-sm"></i></button>
                                </td>
                            </tr>

                            <!-- Modal -->
                        <div class="modal fade" id="myModal{{$unidade->getId()}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Atenção</h4>
                                    </div>
                                    <div class="modal-body">
                                        Deseja realmente excluir?
                                    </div>
                                    <form action="{{ action('UnidadeMedidaController@delete') }}" method="post">
                                        <div class="modal-footer">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="button" class="btn btn-save" data-dismiss="modal">Fechar</button>
                                            <input type="hidden" name="id" value="{{$unidade->getId() }}"/>
                                            <button type="submit" class="btn btn-cancel">Confirmar</button>
                                        </div>
                                    </form>

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
                    {{ $unidades->appends(['criterio'=>$criterio,'valor'=>$valor,'limit'=>$limit])->links() }}
                    @else
                    {{ $unidades->links() }}
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

@stop


@section('js')

@stop








