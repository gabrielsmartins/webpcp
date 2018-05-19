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
                <div class="card-body">
                    <form class="form-horizontal" action="{{ action('ApontamentoController@find') }} "method="GET" accept-charset="UTF-8">


                        <div class="form-group row">
                            <label for="descricao" class="col-sm-2 control-label">Ordem de Produção:</label>

                            <div class="col-md-3">
                                <input type="text" class="form-control" id="descricao" placeholder="Nº Ordem de Produção" name="ordem" required="true">
                            </div>

                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary pull-right fa fa-search"> Pesquisar</button>
                            </div>

                        </div>
                    </form>
                </div>


                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>OP</th>
                                <th>Prog</th>
                                <th>Produto</th>
                                <th>Operação</th>
                                <th>Setor</th>
                                <th>Recurso</th>
                                <th>Tempo Total Previsto</th>
                                <th>Data Emissão</th>
                                <th>Prazo</th>
                                <th>Status</th>
                                <th>Qntd Solic.</th>
                                <th>Qntd Rlz.</th>
                                <th colspan="2">Ação</th>
                            </tr>
                        </thead>
                        <tbody id="tabela_programacao">

                        </tbody>
                    </table>
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







