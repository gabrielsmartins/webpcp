@extends('layouts.master')

@section('page', 'Dashboard')

@section('title','Bem - Vindo')


@section('content')

<section class="dashboard-counts section-padding">
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="card-body">
                <div class="row">
                    <div class="card-header d-flex align-items-center">
                        <h4>Dashboard</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="card-body">

                        <form method="get" action="{{ action('MainController@home') }}" class="form-inline">
                            <div class="col-md-10">
                                <div class="form-group row">
                                    <div class="card-header d-flex align-items-center">
                                        <h5>Escolha o período desejado:</h5>
                                    </div>
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
                                    <button class="btn btn-primary fa fa-search" type="submit"></button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <div  class="row">
                    <div class="col-md-6">
                        <canvas id="ordemProducaoChart"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="apontamentoChart"></canvas>
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
                            <form method="get" action="{{action('MainController@pesquisarPorCriterio') }}" class="form-inline">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <div class="card-header d-flex align-items-center">
                                            <h5>Pesquisar por Status:</h5>
                                        </div>
                                        <select class="form-control input-sm" name="criterio">
                                            <option>Todas</option>
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


@section('js')


<script type="text/javascript">
    exibirGraficoApontamentos();
    exibirGraficoProducaoPorSetor();
    
    function exibirGraficoApontamentos(){
    var apontamentos = {!! $apontamentos !!}
    ;
    var labelApontamentos = [];
    var data = [];
    var colors = [];
    console.log(apontamentos);
    var producao = 0;
    var descarte = 0;
    var manutencao=0;
    var parada=0;
    for (var i = 0; i < apontamentos.length; i++) {
    switch (apontamentos[i].tipo) {
    case "PRODUCAO":
            producao++;
    break;
    case "DESCARTE":
            descarte++;
    break;
    case "MANUTENCAO":
            manutencao++;
    break;
    case "PARADA":
            parada++;
    break;
    }
    }

    if (producao > 0) {
    labelApontamentos.push("PRODUCAO");
    data.push(producao);
    colors.push('rgba(153, 153, 153, 0.55)');
    }

    if (descarte > 0) {
    labelApontamentos.push("DESCARTE");
    data.push(descarte);
    colors.push('rgba(255, 0, 0, 0.55)');
    }

    if (manutencao > 0) {
    labelApontamentos.push("MANUTENCAO");
    data.push(manutencao);
    colors.push('rgba(204, 255, 0, 0.55)');
    }

    if (parada > 0) {
    labelApontamentos.push("PARADA");
    data.push(parada);
    colors.push('rgba(255, 153, 0, 0.55)');
    }


console.log(labelApontamentos);

    var ctx = document.getElementById("apontamentoChart").getContext('2d');
    var apontamentoChart = new Chart(ctx, {
    type: 'doughnut',
            data: {
            labels: labelApontamentos,
                    datasets: [{
                    label: labelApontamentos,
                            data: data,
                            backgroundColor: colors,
                            borderColor: colors,
                            borderWidth: 1
                    }]
            },
            options: {
            title: {
            display: true,
                    text: 'Apontamentos'
            },
            responsive: true,
                    legend: {
                    display: true,
                            position: 'bottom'
                    },
                    scales: {
                    yAxes: [{
                    display: false
                    }]
                    },
                    layout: {
                    padding: {
                    left: 50,
                            right: 0,
                            top: 0,
                            bottom: 0
                    }
                    }
            }
    });
    }



    function exibirGraficoProducaoPorSetor(){
    var apontamentos = {!! $producao !!}
    ;
    var lookup = {};
    var labelSetores = [];
    var producao = [];
    var descarte = [];
    var colors = [];
    console.log(apontamentos);
    for (var apontamento, i = 0; apontamento = apontamentos[i++]; ) {
    var setor = apontamento.setor;
    if (!(setor in lookup)) {
    lookup[setor] = 1;
    labelSetores.push(setor);
    }
    }

    console.log(labelSetores);
   
   for(var i=0;i < labelSetores.length; i++){
       var existeProducao=false;
       var existeDescarte=false;
       
        for(var j=0; j < apontamentos.length; j++){
                 if(apontamentos[j].tipo == 'PRODUCAO' && labelSetores[i]  == apontamentos[j].setor){
                   var valor = apontamentos[j].quantidade == null ? 0 : apontamentos[j].quantidade ;
                  producao.push(valor);
                  existeProducao = true;
              }
          }
          
          if(!existeProducao){
              producao.push(0);
            }
          
          
              
           for(var j=0; j < apontamentos.length; j++){
                 if(apontamentos[j].tipo == 'DESCARTE' && labelSetores[i]  == apontamentos[j].setor){
                   var valor = apontamentos[j].quantidade == null ? 0 : apontamentos[j].quantidade ;
                  descarte.push(valor);
                  existeProducao = true;
              }
          }
          
          if(!existeDescarte){
              descarte.push(0);
            }
              
              
                
       }
  
   
   

          
   
   
   console.log(producao);
    console.log(descarte);
   
    for (var i = 0; i < apontamentos.length; i++) {
       apontamentos[i].setor;
    }



    var ctx = document.getElementById("ordemProducaoChart").getContext('2d');
    var ordemProducaoChart = new Chart(ctx, {
    type: 'bar',
            data: {
            labels: labelSetores,
                    datasets: [{
                    label: '(#) Pecas Produzidas',
                            backgroundColor: 'rgba(153, 153, 153, 0.55)',
                            borderColor: 'rgba(153, 153, 153, 1)',
                            borderWidth: 1,
                            data: producao
                    },
                    {
                    label: '(#) Pecas Descartadas',
                            backgroundColor: 'rgba(255, 0, 0, 0.55)',
                            borderColor: 'rgba(255,0,0,1)',
                            borderWidth: 1,
                            data: descarte
                    }],
            },
            options: {
            title: {
            display: true,
                    text: 'Producao e Descarte por Setor'
            },
            responsive: true,
                    legend: {
                    display: true,
                            position: 'bottom'
                    },
                    scales: {
                    yAxes: [{
                    ticks: {
                    beginAtZero: true
                    }
                    }]
                    }
            }
    });
    }
</script>


<script type="text/javascript">

    $(function () {
    $("#datetimepicker_ini").datetimepicker({
    format: 'DD/MM/YYYY',
            locale: 'pt-br'
    });
    $("#datetimepicker_fim").datetimepicker({
    format: 'DD/MM/YYYY',
            locale: 'pt-br'
    });
    });

</script>

@stop



