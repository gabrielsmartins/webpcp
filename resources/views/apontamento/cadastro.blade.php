@extends('layouts.master')

@section('page', 'Apontamento - Registro')

@section('title','Apontamento')


@section('content')


<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>Novo Apontamento</h4>
                </div>
                <form class="form-horizontal" action="{{ action('ApontamentoController@store') }}" method="POST" accept-charset="UTF-8">
                    <div class="card-body">

                        <div class="form-group row">
                            <label class="control-label col-md-2"><strong>Nª Ordem de Produção: </strong></label>
                            <input type="text" name="op" class="form-control col-md-1" value="{{$programacao->getOrdemProducao()->getId()}}" readonly="true"/>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-2"><strong>Sequência: </strong></label>
                            <input type="text" name="seq" class="form-control col-md-1" value="{{$programacao->getSequencia()}}" readonly="true"/>
                            <label class="control-label col-md-2"><strong>Quantidade Solicitada:</strong></label>
                            <input type="number" class="form-control col-md-1" value="{{$programacao->getOrdemProducao()->getQuantidade()}}" readonly="true"/>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-2"><strong>Produto:</strong></label>
                            <input type="text" class="form-control col-md-6" value="{{$programacao->getOrdemProducao()->getProduto()->getId()}} - {{$programacao->getOrdemProducao()->getProduto()->getDescricao()}} - ({{$programacao->getOrdemProducao()->getProduto()->getCodigoInterno()}})" readonly="true"/>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-2"><strong>Setor:</strong></label>
                            <input type="text" class="form-control col-md-3" value="{{$programacao->getRoteiro()->getOperacao()->getSetor()->getId()}} - {{$programacao->getRoteiro()->getOperacao()->getSetor()->getDescricao()}}" readonly="true"/>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-2"><strong>Operação:</strong></label>
                            <input type="text" class="form-control col-md-3" value="{{$programacao->getRoteiro()->getOperacao()->getId()}} - {{$programacao->getRoteiro()->getOperacao()->getDescricao()}}" readonly="true"/>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-2"><strong>Instrução:</strong></label>
                            <textarea class="form-control col-md-6" readonly="true">{{$programacao->getRoteiro()->getOperacao()->getDescricao()}}</textarea>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-2"><strong>Recurso:</strong></label>
                            <input type="text" class="form-control col-md-3" value="{{$programacao->getRecurso()->getId()}} - {{$programacao->getRecurso()->getDescricao()}}" readonly="true"/>
                        </div>





                        <div class="form-group row">
                            <label class="control-label col-md-2"><strong>Data Emissão:</strong></label>
                            <div class="col-md-2">
                                <div class="input-group date"  data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" value="{{$programacao->getOrdemProducao()->getDataEmissao()->format('d/m/Y')}}" readonly="true"/>
                                    <div class="input-group-append" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>


                            <label class="control-label col-md-2"><strong>Prazo:</strong></label>
                            <div class="col-md-2">
                                <div class="input-group date" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" value="{{$programacao->getOrdemProducao()->getPrazo()->format('d/m/Y')}}" readonly="true"/>
                                    <div class="input-group-append" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label class="control-label col-md-2"><strong>Responsável:</strong></label>
                            <input type="text" class="form-control col-md-3" value="{{$programacao->getOrdemProducao()->getResponsavel()->getNome()}}" readonly="true"/>
                        </div>




                        <div class="form-group row">
                            <label class="control-label col-md-2"><strong>Status:</strong></label>
                            <label class="control-label col-md-1"> 
                                @switch($programacao->getOrdemProducao()->getStatus())
                                @case('EMITIDA')
                                <span class="badge badge-secondary">{{$programacao->getOrdemProducao()->getStatus()}}</span>
                                @break

                                @case('INICIADA')
                                <span class="badge badge-warning">{{$programacao->getOrdemProducao()->getStatus()}}</span>
                                @break


                                @case('ENCERRADA')
                                <span class="badge badge-success">{{$programacao->getOrdemProducao()->getStatus()}}</span>
                                @break

                                @case('CANCELADA')
                                <span class="badge badge-danger">{{$programacao->getOrdemProducao()->getStatus()}}</span>
                                @break

                                @default
                                <span class="badge badge-info">{{$programacao->getOrdemProducao()->getStatus()}}</span>
                                @endswitch
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-2"><strong>Quantidade:</strong></label>
                            <div class="control-label col-md-2">
                                <input type="number" class="form-control" name="quantidade"/>
                            </div>

                            <label class="control-label col-md-2"><strong>Tipo:</strong></label>
                            <div class="control-label col-md-2">
                                <select name="tipo" class="form-control">
                                    <option value="PRODUCAO">PRODUÇÃO</option>
                                    <option value="MANUTENCAO">MANUTENÇÃO</option>
                                    <option value="PARADA">PARADA</option>
                                    <option value="DESCARTE">DESCARTE</option>
                                </select>
                            </div>
                        </div>




                        <div class="form-group row">
                            <label class="control-label col-md-2"><strong>Data Início:</strong></label>
                            <div class="col-md-2">
                                <div class="input-group date" id="datetimepicker_ini" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker_ini" name="dataInicio"/>
                                    <div class="input-group-append" data-target="#datetimepicker_ini" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>

                            <label class="control-label col-md-2"><strong>Data Fim:</strong></label>
                            <div class="col-md-2">
                                <div class="input-group date" id="datetimepicker_fim" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker_fim" name="dataFim"/>
                                    <div class="input-group-append" data-target="#datetimepicker_fim" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="reset" class="btn btn-secondary pull-right fa fa-ban"> Cancelar</button>
                        <button type="submit" class="btn btn-primary pull-right fa fa-save"> Registrar</button>
                    </div>

                </form>






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


@section('js')

<script type="text/javascript">

    $(function () {
        $("#datetimepicker_ini").datetimepicker({
            format: 'DD/MM/YYYY HH:mm:ss',
            locale: 'pt-br'
        });

        $("#datetimepicker_fim").datetimepicker({
            format: 'DD/MM/YYYY HH:mm:ss',
            locale: 'pt-br'
        });
    });

</script>

@stop







