@extends('layouts.master')

@section('page', 'Dashboard')

@section('title','Bem - Vindo')


@section('content')


<section class="dashboard-counts section-padding">
    <div class="container-fluid">
        <div class="row">
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="icon-padnote"></i></div>
                    <div class="name"><strong class="text-uppercase">Ordens de Produção Concluídas</strong><span>Last 7 days</span>
                        <div class="count-number">25</div>
                    </div>
                </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="icon-padnote"></i></div>
                    <div class="name"><strong class="text-uppercase">Ordens de Produção Abertas</strong><span>Last 5 days</span>
                        <div class="count-number">400</div>
                    </div>
                </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="icon-padnote"></i></div>
                    <div class="name"><strong class="text-uppercase">Ordens de Produção Iniciadas</strong><span>Last 2 months</span>
                        <div class="count-number">342</div>
                    </div>
                </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="icon-padnote"></i></div>
                    <div class="name"><strong class="text-uppercase">Requisições de Material Concluídas</strong><span>Last 2 days</span>
                        <div class="count-number">123</div>
                    </div>
                </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="icon-padnote"></i></div>
                    <div class="name"><strong class="text-uppercase">Requisições de Material Abertas</strong><span>Last 3 months</span>
                        <div class="count-number">92</div>
                    </div>
                </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="icon-padnote"></i></div>
                    <div class="name"><strong class="text-uppercase">Requisições de Material Iniciadas</strong><span>Last 7 days</span>
                        <div class="count-number">70</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<section class="dashboard-counts section-padding">


    <div class="container-fluid">

        <div class="col-lg-12">
            <div class="card-body">

                <div class="row">
                    <div class="card-header d-flex align-items-center">
                        <h4>Ordens de Produção</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="card-body">
                        <div class="col-md-12">
                            <form method="get" action="{{('MainController@pesquisarPorCriterio') }}" class="form-inline">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label><strong>Status: </strong></label>
                                        <select class="form-control input-sm" name="criterio">
                                            <option value="EMITIDA">Emitida</option>
                                            <option value="INICIADA">Iniciada</option>
                                            <option value="ENCERRADA">Encerrada</option>
                                            <option value="ENCERRADA">Concluída</option>
                                        </select>
                                        <button class="btn btn-primary fa fa-search" type="submit"></button>
                                    </div>
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
                                        <label><strong>Registros</strong></label>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>




                </div>




                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nº</th>
                                        <th>Produto</th>
                                        <th>Quantidade</th>
                                        <th>Responsável</th>
                                        <th>Data Emissão</th>
                                        <th>Prazo</th>
                                        <th>Status</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($ordens as $ordem)
                                    <tr>
                                        <td>{{$ordem->getId()}}</td>
                                        <td>{{$ordem->getProduto()->getDescricao()}}</td>
                                        <td>{{$ordem->getQuantidade()}}</td>
                                        <td>{{$ordem->getResponsavel()->getNome()}}</td>
                                        <td>{{$ordem->getDataEmissao()->format('d/m/Y') }}</td>
                                        <td>{{$ordem->getPrazo()->format('d/m/Y')}}</td>


                                        @switch($ordem->getStatus())
                                        @case('EMITIDA')
                                        <td>
                                            <span class="badge badge-secondary">{{$ordem->getStatus()}}</span>
                                        </td>

                                        @break

                                        @case('INICIADA')
                                        <td>
                                            <span class="badge badge-warning">{{$ordem->getStatus()}}</span>
                                        </td>

                                        @break


                                        @case('ENCERRADA')
                                        <td>
                                            <span class="badge badge-success">{{$ordem->getStatus()}}</span>
                                        </td>

                                        @break

                                        @case('CANCELADA')
                                        <td>
                                            <span class="badge badge-danger">{{$ordem->getStatus()}}</span>
                                        </td>

                                        @break

                                        @default
                                        <td>
                                            <span class="badge badge-info">{{$ordem->getStatus()}}</span>
                                        </td>

                                        @endswitch



                                        <td  style="width: 10px;">
                                            <a href="{{ URL::to('/ordem/edit/'.$ordem->getId()) }}"
                                               class="btn btn-primary"><i class="fa fa-search-plus fa-sm"></i>
                                            </a> 
                                        </td>
                                    </tr>
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
                        {{ $ordens->appends(['ordens'=>$criterio,'valor'=>$valor,'limit'=>$limit])->links() }}
                        @else
                        {{ $ordens->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>






@stop


