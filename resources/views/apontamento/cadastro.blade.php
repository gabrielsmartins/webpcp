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



                    <div class="row">
                        <div class="col-md-2">
                            <label class="control-label"><strong>Ordem de Produção:</strong></label>
                        </div>
                        <div class="col-md-1">
                            <input type="text" id="ordem" class="form-control"/>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-success fa fa-search" id="btnPesquisarOrdemProducao"> Pesquisar</button>
                        </div>

                    </div>


                    <div class='row' id="ordemProducao">

                    </div>

                    <div class='row' id="produtoID">

                    </div>


                    <div class='row' id="produtoCodigoInterno">

                    </div>


                    <div class='row' id="produtoDescricao">

                    </div>


                    <div class='row' id="quantidade">

                    </div>

                    <div class='row' id="dataEmissao">

                    </div>

                    <div class='row' id="prazo">

                    </div>

                    <div class='row' id="responsavel">

                    </div>

                    <div class='row' id="status">

                    </div>

                </div>



                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Prog</th>
                                <th>Operação</th>
                                <th>Setor</th>
                                <th>Recurso</th>
                                <th>Tipo</th>
                                <th>Qntd Produzida</th>
                                <th>Qntd Apontamento</th>
                                <th>Data Início</th>
                                <th>Data Fim</th>
                                <th>Ação</th>
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



@section('js')
<script type="text/javascript">

    var btnPesquisarOrdemProducao = document.querySelector("#btnPesquisarOrdemProducao");
    var CSRF_TOKEN = "{{ csrf_token() }}";

    btnPesquisarOrdemProducao.addEventListener("click", function (event) {
        event.preventDefault();
        var op = $("#ordem").val();

        $.ajax({
            url: "{{url('apontamento/find')}}",
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                id: op},
            dataType: 'JSON',
            beforeSend: function () {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: "<h4>Carregando... Aguarde</h4>"
                });
            },
            success: function (data) {
                console.log(data);
                preencheTabela(data);
                HoldOn.close();
            },
            error: function (e) {
                console.log(e.responseText);
                HoldOn.close();
            }
        });


    });


    function preencheTabela(data) {
        $('#tabela_programacao').html("");
        $('#produtoID').html("");
        $('#produtoCodigoInterno').html("");
        $('#produtoDescricao').html("");
        $('#quantidade').html("");
        $('#dataEmissao').html("");
        $('#prazo').html("");
        $('#responsavel').html("");
        $('#status').html("");
        for (var i = 0; i < data.length; i++) {
            $('#ordemProducao').html("<div class='col-md-2'><label class='control-label'><strong>Nº:</strong></label></div><div class='col-md-1'><label>" + data[i].ordemProducao + "</label></div>");
            $('#produtoID').html("<div class='col-md-2'><label class='control-label'><strong>ID Produto:</strong></label></div><div class='col-md-1'><label>" + data[i].produtoID + "</label></div>");
            $('#produtoCodigoInterno').html("<div class='col-md-2'><label class='control-label'><strong>Código Interno:</strong></label></div><div class='col-md-1'><label>" + data[i].produtoCodigoInterno + "</label></div>");
            $('#produtoDescricao').html("<div class='col-md-2'><label class='control-label'><strong>Descrição:</strong></label></div><div class='col-md-6'><label>" + data[i].produtoDescricao + "</label></div>");
            $('#quantidade').html("<div class='col-md-2'><label class='control-label'><strong>Quantidade Solicitada:</strong></label></div><div class='col-md-1'><label>" + data[i].ordemQuantidade + "</label></div>");
            $('#dataEmissao').html("<div class='col-md-2'><label class='control-label'><strong>Data Emissão:</strong></label></div><div class='col-md-1'><label>" + data[i].ordemDataEmissao + "</label></div>");
            $('#prazo').html("<div class='col-md-2'><label class='control-label'><strong>Prazo:</strong></label></div><div class='col-md-1'><label>" + data[i].ordemPrazo + "</label></div>");
            $('#responsavel').html("<div class='col-md-2'><label class='control-label'><strong>Responsável:</strong></label></div><div class='col-md-3'><label>" + data[i].ordemResponsavel + "</label></div>");
            $('#status').html("<div class='col-md-2'><label class='control-label'><strong>Status:</strong></label></div><div class='col-md-3'><label>" + data[i].ordemStatus + "</label></div>");
            $('#tabela_programacao').append("<tr>" +
                    "<td>" + data[i].sequencia + "</td>" +
                    "<td>" + data[i].operacaoID + " - " + data[i].operacaoDesricao + "</td>" +
                    "<td>" + data[i].setorID + " - " + data[i].operacaoDesricao + "</td>" +
                    "<td>" + data[i].recursoID + " - " + data[i].recursoDescricao + "</td>" +
                    "<td><select class='form-control'><option value='PRODUCAO'>PRODUÇÃO</option><option value='MANUTENCAO'>MANUTENÇÃO</option><option value='PARADA'>PARADA</option><option value='DESCARTE'>DESCARTE</option></select></td>" +
                    "<td style='width:150px'>" + data[i].quantidadeProduzida + "</td>" +
                    "<td style='width:150px'><input type='number' name='quantidade' class='form-control'/></td>" +
                    "<td><input type='text' name='dataInicio'/></td>" +
                    "<td><input type='text' name='dataFim'/></td>" +
                    "<td><button type='submit' class='btn btn-success'>Registrar</button></td>" +
                    "</tr>");
        }
    }

</script>

@stop



