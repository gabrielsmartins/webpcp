@extends('layouts.master')

@section('page', 'Recebimento Estoque - Material')

@section('title','Recebimento Estoque Material')


@section('breadcrumb')
<!-- Breadcrumb-->
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/recebimento/show')}}">Recebimentos de Material</a></li>
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
                <div class="card-header">
                    <h4>Novo Recebimento Material</h4>
                </div>

                <form class="form-horizontal" action="{{ action('RecebimentoMaterialController@store') }}" method="POST" accept-charset="UTF-8">


                    <div class="box-body">

                        <div class="form-group row">
                            <label for="responsavel" class="col-sm-1 control-label">Responsável:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" disabled="true" value="{{Session::get('usuarioLogado')}}"/>
                            </div>

                            <label for="descricao" class="col-sm-2 control-label">Data Recebimento:</label>
                            <div class="col-sm-2">
                                

                                <div class="input-group date">
                                    <input class="form-control pull-right" id="dataRetirada" type="text" name="dataRetirada" value="{{date('d/m/Y')}}">
                                    <div class="input-group-append" >
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Requisições em Aberto</h3>
                        </div>
                        <div class="row">
                            <div class="col-sm-1">
                                <label>Critério:</label>
                            </div>
                            <div class="col-sm-3">
                                <select id="field" class="form-control">
                                    <option value="0">ID</option>
                                    <option value="1">Item Nº</option>
                                    <option value="3">Descrição</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" id="myInput" onkeyup="pesquisar()" placeholder="Pesquisar..." class="form-control">
                            </div>
                        </div>
                        <div class="table-responsive" style="max-height:240px;">
                            <table class="table table-bordered table-striped" id="tabelaOrigem">
                                <thead>
                                    <tr>
                                        <th>ID Req</th>
                                        <th>Item Nº</th>
                                        <th>Data Emissão</th>
                                        <th>ID</th>
                                        <th>Cód. Interno</th>
                                        <th>Descrição</th>
                                        <th>Qntd Solic.</th>
                                        <th>Prazo</th>
                                        <th>Status</th>
                                        <th>Qntd Solic.</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requisicoes as $requisicao)
                                    @foreach($requisicao->getItens() as $item)
                                    <tr>
                                        <td><span id="req_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getRequisicao()->getId()}}</span></td>
                                        <td><span id="req_item_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getRequisicao()->getId()}}.{{ $loop->iteration }}</span></td>
                                        <td><span id="data_emissao_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getRequisicao()->getDataEmissao()->format('d/m/Y') }}</span></td>
                                        <td><span id="material_id_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getMaterial()->getId()}}</span></td>
                                        <td><span id="material_codigoInterno_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getMaterial()->getCodigoInterno()}}</span></td>
                                        <td><span id="material_descricao_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getMaterial()->getDescricao()}}</span></td>
                                        <td><span id="quantidade_solicitada_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getQuantidade()}}</span></td>
                                        <td><span id="prazo_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getRequisicao()->getPrazo()->format('d/m/Y')}}</span></td>
                                        <td><span id="status_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getRequisicao()->getStatus()}}</span></td>
                                        <td><input type="number"  id="quantidade_recebida_{{ $loop->parent->iteration }}.{{ $loop->iteration }}" max="{{$item->getQuantidade()}}" /></td>
                                        <td><button type="button" class="btn btn-primary fa fa-plus" onclick="adicionaItem({{ $loop->parent->iteration }}.{{ $loop->iteration }})"></button></td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>




                    <!-- /.box-header -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Itens Selecionados</h3>
                        </div>
                        <!-- form start -->




                        <div class="row">
                            <div class="table-responsive" style="max-height:240px;">
                                <table class="table table-bordered table-striped" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>ID Req</th>
                                            <th>Item Nº</th>
                                            <th>Data Emissão</th>
                                            <th>ID</th>
                                            <th>Cód. Interno</th>
                                            <th>Descrição</th>
                                            <th>Qntd Solic.</th>
                                            <th>Prazo</th>
                                            <th>Status</th>
                                            <th>Qntd Solic.</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabelaDestino">

                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="reset" class="btn btn-secondary pull-right fa fa-ban"> Cancelar</button>
                            <button type="submit" class="btn btn-primary pull-right fa fa-save"> Registrar</button>
                        </div>
                        <!-- /.box-footer -->
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
//Date picker
    $('#dataRetirada').datepicker({
    autoclose: true,
            format: 'dd/mm/yyyy',
            language: 'pt-BR'
    });</script>
<script type="text/javascript">
    function pesquisar() {
    // Declare variables
    var input, filter, table, tr, td, i, select, field;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("tabelaOrigem");
    tr = table.getElementsByTagName("tr");
    select = document.getElementById("field");
    field = parseInt(select.options[select.selectedIndex].value);
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[field];
    if (td) {
    if (td.innerHTML.toUpperCase().indexOf(filter) > - 1) {
    tr[i].style.display = "";
    } else {
    tr[i].style.display = "none";
    }
    }
    }
    }
</script>

<script type="text/javascript">
    function adicionaItem(id) {

    var req = document.getElementById("req_" + id).textContent;
    var req_item = document.getElementById("req_item_" + id).textContent;
    var data_emissao = document.getElementById("data_emissao_" + id).textContent;
    var materialId = document.getElementById("material_id_" + id).textContent;
    var materialCodigoInterno = document.getElementById("material_codigoInterno_" + id).textContent;
    var materialDescricao = document.getElementById("material_descricao_" + id).textContent;
    var quantidade_solicitada = document.getElementById("quantidade_solicitada_" + id).textContent;
    var prazo = document.getElementById("prazo_" + id).textContent;
    var status = document.getElementById("status_" + id).textContent;
    var quantidade_recebida = document.getElementById("quantidade_recebida_" + id).value;
    var row = "<tr id='row_" + id + "'>" +
            "<input type='hidden' value='" + req + ";" + req_item + ";" + quantidade_recebida + "' name='itens[]'/>" +
            "<td>" + req + "</td>" +
            "<td>" + req_item + "</td>" +
            "<td>" + data_emissao + "</td>" +
            "<td>" + materialId + "</td>" +
            "<td>" + materialCodigoInterno + "</td>" +
            "<td>" + materialDescricao + "</td>" +
            "<td>" + quantidade_solicitada + "</td>" +
            "<td>" + prazo + "</td>" +
            "<td>" + status + "</td>" +
            "<td><input type='number'  value='" + quantidade_recebida + "' disabled='true' /></td>" +
            "<td><button type='button' class='btn btn-secondary fa fa-remove' onclick='removeItem(" + id + ")'></button></td>" +
            "</tr>";
    $("#tabelaDestino").append(row);
    document.getElementById("quantidade_recebida_" + id).disabled = true;
    }

    function removeItem(id) {
    document.getElementById('row_' + id).remove();
    document.getElementById("quantidade_recebida_" + id).disabled = false;
    components--;
    }
</script>
@stop








