@extends('layouts.master')

@section('page', 'Ordem de Produção')

@section('title','Ordem de Produção')


@section('breadcrumb')
<!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/ordem/show')}}">Ordens de Produção</a></li>
            <li class="breadcrumb-item active">Cadastro</li>
          </ul>
        </div>
      </div>
@stop




@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>Nova Ordem de Produção</h4>
                </div>
                <div id="loader"></div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ action('OrdemProducaoController@store') }}"
                          method="POST" accept-charset="UTF-8">
                        <div class="box-body">

                            <div class="form-group row">
                                <label for="responsavel" class="col-sm-1 control-label">Responsável:</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" disabled="true" value="{{Session::get('usuarioLogado')}}"/>
                                </div>
                            </div>
                            
                            
                            <div class="form-group row">


                                <label for="descricao" class="col-sm-1 control-label">Data Emissão:</label>

                                <div class="col-sm-2">
                                    <div class="input-group date">
                                        <input class="form-control pull-right" id="dataEmissao" type="text" name="dataEmissao" value="{{date('d/m/Y')}}" disabled="true">
                                        <div class="input-group-append" >
                                             <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                            

                                <label for="descricao" class="col-sm-1 control-label">Prazo:</label>

                                <div class="col-sm-2">
                                    <div class="input-group date">
                                        <input class="form-control pull-right" id="prazo" type="text" name="prazo">
                                        <div class="input-group-append" >
                                             <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>



                            </div>




                            <div class="form-group row">
                                <label class="col-sm-1 control-label">Produto:</label>
                                <div class="col-sm-6">
                                    <select  class="select2" id="busca_produto" name="produto" style="width: 100%" required="true">
                                        <option value="" disabled selected>Escolha um Produto</option>

                                        @foreach($produtos as $produto)
                                        <option value="{{$produto->getId()}}">{{$produto->getId()}} - {{$produto->getCodigoInterno()}} - {{$produto->getDescricao()}} - {{$produto->getSituacao()}} - Qntd ({{$produto->getQuantidadeEstoque()}})</option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-1 control-label">Quantidade:</label>
                                <div class="col-sm-1">
                                    <input id="quantidade" name="quantidade" type="number"  pattern="[0-9]+([\.,][0-9]+)?" step="0.01" class="form-control" required="true">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-primary" id="btnImportarRoteiro">Importar Roteiro</button>
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
                                            <tbody id="tabela_estrutura">


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
                                                    <th style="width: 20px">ID</th>
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
                                            <tbody id="tabela_roteiro">


                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="reset" class="btn btn-secondary pull-right fa fa-ban"> Cancelar</button>
                            <button type="submit" class="btn btn-primary pull-right fa fa-save"> Emitir</button>
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


@section('js')



<script type="text/javascript">
    $(document).ready(function () {

        $("#busca_produto").select2({
            placeholder: "Selecione um Produto",
            allowClear: true
        });

        $(".select2").select2({
            allowClear: true
        });
        
         $('#prazo').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        language: 'pt-BR'
    });
    
    $('#dataEmissao').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        language: 'pt-BR'
    });

    });
</script>


<script type="text/javascript">
    var components = 0;
    var btnImportarRoteiro = document.querySelector("#btnImportarRoteiro");
    var CSRF_TOKEN = "{{ csrf_token() }}";


    btnImportarRoteiro.addEventListener("click", function (event) {
        event.preventDefault();

        $.ajax({
            url: "{{url('ordem/importar_roteiro')}}",
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                id: $("#busca_produto").val()},
            dataType: 'JSON',
            beforeSend: function () {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: "<h4>Carregando... Aguarde</h4>"
                });
            },
            success: function (data) {
                var quantidade = $("#quantidade").val();
                console.log(data);
                adicionaRoteiro(data, quantidade);
                HoldOn.close();
            },
            error: function (e) {
                console.log(e.responseText);
                HoldOn.close();
            }
        });



        $.ajax({
            url: "{{url('ordem/importar_estrutura')}}",
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                id: $("#busca_produto").val()},
            dataType: 'JSON',
            beforeSend: function () {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: "<h4>Carregando... Aguarde</h4>"
                });
            },
            success: function (data) {
                var quantidade = $("#quantidade").val();
                console.log(data);
                exibeEstrutura(data, quantidade);
                HoldOn.close();
            },
            error: function (e) {
                console.log(e.responseText);
                HoldOn.close();
            }
        });



    });


    function adicionaRoteiro(data, quantidade) {
        components = 0;
        $('#tabela_roteiro').html("");
        for (var i = 0; i < data.length; i++) {
            components++;
            var total = calculaTempoTotal(data[i].tempoSetup, data[i].tempoProducao, data[i].tempoFinalizacao, quantidade);
            $('#tabela_roteiro').append("<tr id='prog_" + components + "'>" +
                    "<input type='hidden' name='operacao[]' value='" + data[i].operacaoID + "'/>" +
                    "<td>" + components + "</td>" +
                    "<td>" + data[i].operacaoID + "</td>" +
                    "<td>" + data[i].operacao + "</td>" +
                    "<td>" + data[i].setor + "</td>" +
                    "<td><select name='recurso[]' class='form-control' id='rec_" + data[i].setorID + "'></select></td>" +
                    "<td>" + data[i].tempoSetup + "</td>" +
                    "<td>" + data[i].tempoProducao + "</td>" +
                    "<td>" + data[i].tempoFinalizacao + "</td>" +
                    "<td>" + quantidade + "</td>" +
                    "<td>" + total + "</td>" +
                    "</tr>");

            carregaRecursos(data[i].setorID);
        }
    }


    function exibeEstrutura(data, quantidade) {
        components = 0;
        $('#tabela_estrutura').html("");
        for (var i = 0; i < data.length; i++) {
            components++;
            var status = (data[i].quantidade * quantidade) <= data[i].quantidadeEstoque ? "<span class='text-success'>Disponível</span>" : "<span class='text-danger'>Indisponível</span>";
            $('#tabela_estrutura').append("<tr>" +
                    "<td>" + components + "</td>" +
                    "<td>" + data[i].id + "</td>" +
                    "<td>" + data[i].codigo + "</td>" +
                    "<td>" + data[i].componente + "</td>" +
                    "<td>" + data[i].situacao + "</td>" +
                    "<td>" + data[i].quantidadeEstoque + "</td>" +
                    "<td>" + data[i].quantidade + "</td>" +
                    "<td>" + quantidade + "</td>" +
                    "<td>" + (data[i].quantidade * quantidade) + "</td>" +
                    "<td>" + status + "</td>" +
                    "</tr>");
        }
    }


    function carregaRecursos(setorID) {
        $.ajax({
            url: "{{url('ordem/carrega_recursos')}}",
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                id: setorID},
            dataType: 'JSON',
            beforeSend: function () {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: "<h4>Carregando... Aguarde</h4>"
                });
            },
            success: function (data) {
                console.log(data);
                var options = "";
                for (var j = 0; j < data.length; j++) {
                    options += "<option value='" + data[j].id + "'>" + data[j].id + "-" + data[j].descricao + "</option>";
                }

                $('#rec_' + setorID).append(options);
                HoldOn.close();
            },
            error: function (e) {
                console.log(e.responseText);
                HoldOn.close();
            }
        });
    }





    function calculaTempoTotal(tempoSetup, tempoProducao, tempoFinalizacao, quantidade) {
        var hour = 0;
        var minute = 0;
        var second = 0;

        var splitTime1 = tempoSetup.split(':');
        var splitTime2 = tempoProducao.split(':');
        var splitTime3 = tempoFinalizacao.split(':');

        hour = (parseInt(splitTime1[0]) + (parseInt(splitTime2[0]) * quantidade) + parseInt(splitTime3[0]));
        minute = (parseInt(splitTime1[1]) + (parseInt(splitTime2[1]) * quantidade) + parseInt(splitTime3[1]));
        hour = parseInt(hour + minute / 60);
        minute = minute % 60;
        second = (parseInt(splitTime1[2]) + (parseInt(splitTime2[2]) * quantidade) + parseInt(splitTime3[2]));
        minute = parseInt(minute + second / 60);
        second = parseInt(second % 60);
        return hour + ":" + minute + ":" + second;

    }


</script>







@stop





