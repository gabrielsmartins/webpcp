@extends('layouts.master')

@section('page', 'Ordem de Produção')

@section('title','Ordem de Produção')


@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>Ordem de Produção Nº {{$ordem->getId()}}</h4>
                </div>
                <div id="loader"></div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ action('OrdemProducaoController@cancel') }}"
                          method="POST" accept-charset="UTF-8">
                        <div class="box-body">
                            <input type="hidden" value="{{$ordem->getId()}}" name="id"/>
                            <div class="form-group row">
                                <label for="responsavel" class="col-sm-1 control-label"><strong>Responsável:</strong></label>
                                <div class="col-sm-3">
                                    <label class="control-label">{{Session::get('usuarioLogado')}}</label>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="descricao" class="col-sm-1 control-label"><strong>Data Emissão:</strong></label>
                                <div class="col-sm-1">
                                    <label class="control-label">{{$ordem->getDataEmissao()->format('d/m/Y')}}</label>
                                </div>


                                <label class="col-sm-1 control-label"><strong>Prazo:</strong></label>
                                <div class="col-sm-1">
                                    <label class="control-label">{{$ordem->getPrazo()->format('d/m/Y')}}</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-1 control-label"><strong>Produto:</strong></label>
                                <div class="col-sm-6">
                                    <label class="control-label">{{$ordem->getProduto()->getDescricao()}}</label>
                                </div>

                                <label class="col-sm-1 control-label"><strong>Quantidade:</strong></label>
                                <div class="col-sm-1">
                                    <label class="control-label">{{$ordem->getQuantidade()}}</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-1 control-label"><strong>Status:</strong></label>
                                <div class="col-sm-6">

                                    @switch($ordem->getStatus())
                                    @case('EMITIDA')
                                    <span class="badge badge-secondary">{{$ordem->getStatus()}}</span>
                                    @break

                                    @case('INICIADA')
                                    <span class="badge badge-warning">{{$ordem->getStatus()}}</span>
                                    @break


                                    @case('ENCERRADA')
                                    <span class="badge badge-success">{{$ordem->getStatus()}}</span>
                                    @break

                                    @case('CANCELADA')
                                    <span class="badge badge-danger">{{$ordem->getStatus()}}</span>
                                    @break

                                    @default
                                    <span class="badge badge-info">{{$ordem->getStatus()}}</span>
                                    @endswitch


                                </div>
                            </div>


                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Estrutura</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th style="width: 20px">ID</th>
                                                    <th>Código Interno</th>
                                                    <th>Descrição</th>
                                                    <th>Situação</th>
                                                    <th>Quantidade Estoque</th>
                                                    <th>Quantidade Unitária</th>
                                                    <th>Quantidade Solicitada</th>
                                                    <th>Quantidade Total</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach($ordem->getProduto()->getItens() as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{$item->getProduto()->getId()}}</td>
                                                    <td>{{$item->getProduto()->getCodigoInterno()}}</td>
                                                    <td>{{$item->getProduto()->getDescricao()}}</td>
                                                    <td>{{$item->getProduto()->getSituacao()}}</td>
                                                    <td>{{$item->getProduto()->getQuantidadeEstoque()}}</td>
                                                    <td>{{$item->getQuantidade()}}</td>
                                                    <td>{{$ordem->getQuantidade()}}</td>
                                                    <td>{{$item->getQuantidade()*$ordem->getQuantidade()}}</td>
                                                    <td>{{$item->getProduto()->getSituacao()}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Programação</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th style="width: 20px">Prog</th>
                                                    <th>Descrição</th>
                                                    <th>Setor</th>
                                                    <th>Recurso</th>
                                                    <th style="width: 150px">Tempo Setup</th>
                                                    <th style="width: 150px">Tempo Produção</th>
                                                    <th style="width: 150px">Tempo Finalização</th>
                                                    <th style="width: 50px">Qntd</th>
                                                    <th style="width: 150px">Tempo Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach($ordem->getProgramacoes() as $programacao)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{$programacao->getOrdemProducao()->getId()}}.{{ $programacao->getSequencia() }}</td>
                                                    <td>{{$programacao->getRoteiro()->getOperacao()->getDescricao()}}</td>
                                                    <td>{{$programacao->getRoteiro()->getOperacao()->getSetor()->getDescricao()}}</td>
                                                    <td>{{$programacao->getRecurso()->getDescricao()}}</td>
                                                    <td>{{$programacao->getRoteiro()->getTempoSetup()}}</td>
                                                    <td>{{$programacao->getRoteiro()->getTempoProducao()}}</td>
                                                    <td>{{$programacao->getRoteiro()->getTempoFinalizacao()}}</td>
                                                    <td>{{$programacao->getOrdemProducao()->getQuantidade()}}</td>
                                                    <td>{{$programacao->getTempoTotal()}}</td>
                                                </tr>
                                                @endforeach

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>






                        </div>

                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            @if ($ordem->getStatus() == 'EMITIDA')
                            <button type="submit" class="btn btn-primary pull-right fa fa-remove"> Cancelar</button>
                            @else
                            <button type="submit" class="btn btn-primary pull-right fa fa-remove" disabled="true"> Cancelar</button>
                            @endif
                        </div>








                        <!-- /.box-footer -->
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
</div>

@stop





