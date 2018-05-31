@extends('layouts.master')

@section('page', 'Produto - Editar')

@section('title','Editar - Produto')


@section('breadcrumb')
<!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/produto/show')}}">Produtos</a></li>
            <li class="breadcrumb-item active">Editar</li>
          </ul>
        </div>
      </div>
@stop


@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <form class="form-horizontal" action="{{ action('ProdutoController@update') }}" method="POST" accept-charset="UTF-8">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$produto->getCodigoInterno()}}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Cadastro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Estrutura</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Roteiro</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">


                        <!-- CADASTRO -->

                        <div class="box-body">


                            <div class="box-header with-border">
                                <h3 class="box-title">Dados Básicos</h3>
                            </div>




                            <input id="id" class="form-control" type="hidden"
                                   name="id" value="{{$produto->getId()}}">

                            <div class="form-group row">
                                <label for="descricao" class="col-sm-1 control-label">Código Interno:</label>

                                <div class="col-sm-2">
                                    <input id="codigoInterno" class="form-control" type="text"
                                           name="codigoInterno" value="{{$produto->getCodigoInterno()}}">
                                </div>


                                <label for="descricao" class="col-sm-1 control-label">Descrição:</label>
                                <div class="col-sm-6">
                                    <input id="descricao" class="form-control" type="text"
                                           name="descricao" value="{{$produto->getDescricao()}}" required="true">
                                </div>
                            </div>




                            <div class="form-group row">
                                <label for="valorUnitario" class="col-sm-1 control-label">Valor
                                    Unitário:</label>

                                <div class="col-sm-3">
                                    <input id="valorUnitario" class="form-control" type="number"
                                           pattern="[0-9]+([\.,][0-9]+)?" step="0.01"
                                           name="valorUnitario" value="{{$produto->getValorUnitario()}}" required="true">
                                </div>

                                <div class="col-sm-6">
                                    <label for="ATIVO" class="radio-inline">
                                        <input name="situacao" type="radio" id="ATIVO" value="ATIVO" @if ($produto->getSituacao() == 'ATIVO') checked @endif> Ativo
                                    </label>

                                    <label for="INATIVO" class="radio-inline">
                                        <input name="situacao" type="radio" id="INATIVO" VALUE="INATIVO" @if ($produto->getSituacao() == 'INATIVO') checked @endif> Inativo
                                    </label>

                                    <label for="FORA_DE_LINHA" class="radio-inline">
                                        <input name="situacao" type="radio" id="FORA_DE_LINHA" VALUE="FORA_DE_LINHA" @if ($produto->getSituacao() == 'FORA_DE_LINHA') checked @endif> Fora de Linha
                                    </label>

                                </div>
                            </div>






                            <div class="box-header with-border">
                                <h3 class="box-title">Dados Técnicos</h3>
                            </div>


                            <div class="form-group row">
                                <label for="unidadeMedida" class="col-sm-1 control-label">Unidade
                                    de Medida:</label>

                                <div class="col-sm-3">
                                    <select name="unidadeMedida" class="form-control" required="true">


                                        <option value="" disabled selected>Escolha uma unidade</option>

                                        @foreach($unidades as $unidade)
                                        <option value="{{$unidade->getId()}}"
                                                @if ($produto->getUnidadeMedida()->getId() == $unidade->getId()) 
                                                selected 
                                                @endif

                                                >{{$unidade->getDescricao()}} - {{$unidade->getSigla()}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <label for="peso" class="col-sm-1 control-label">Peso
                                    (KG):</label>
                                <div class="col-sm-3">
                                    <input id="peso" type="number"
                                           pattern="[0-9]+([\.,][0-9]+)?" step="0.01"
                                           name="peso" class="form-control" value="{{$produto->getPeso()}}">
                                </div>

                            </div>


                            <div class="form-group row">
                                <label for="comprimento" class="col-sm-1 control-label">Comprimento
                                    (mm):</label>
                                <div class="col-sm-2">
                                    <input id="comprimento" type="number"
                                           pattern="[0-9]+([\.,][0-9]+)?" step="0.01"
                                           name="comprimento" class="form-control" value="{{$produto->getComprimento()}}">
                                </div>


                                <label for="largura" class="col-sm-1 control-label">Largura
                                    (mm):</label>
                                <div class="col-sm-2">
                                    <input id="largura" type="number"
                                           pattern="[0-9]+([\.,][0-9]+)?" step="0.01"
                                           name="largura" class="form-control" value="{{$produto->getLargura()}}">
                                </div>


                                <label for="altura" class="col-sm-1 control-label">Altura
                                    (mm):</label>
                                <div class="col-sm-2">
                                    <input id="altura" type="number"
                                           pattern="[0-9]+([\.,][0-9]+)?" step="0.01"
                                           name="altura" class="form-control" value="{{$produto->getAltura()}}">
                                </div>

                            </div>







                            <div class="box-header with-border">
                                <h3 class="box-title">Dados Estoque</h3>
                            </div>


                            <div class="form-group row">
                                <label for="quantidadeEstoque" class="col-sm-1 control-label">Quantidade
                                    Estoque :</label>
                                <div class="col-sm-2">
                                    <input id="quantidadeEstoque" type="number"
                                           pattern="[0-9]+([\.,][0-9]+)?" step="0.01"
                                           name="quantidadeEstoque" class="form-control" value="{{$produto->getQuantidadeEstoque()}}">

                                </div>

                                <label for="quantidadeMinima" class="col-sm-1 control-label">Quantidade
                                    Mínima :</label>
                                <div class="col-sm-2">
                                    <input id="quantidadeMinima" type="number"
                                           pattern="[0-9]+([\.,][0-9]+)?" step="0.01"
                                           name="quantidadeMinima" class="form-control" value="{{$produto->getQuantidadeMinima()}}">

                                </div>

                                <label for="leadtime" class="col-sm-1 control-label">Lead
                                    Time (D) :</label>
                                <div class="col-sm-2">
                                    <input id="leadtime" type="number"
                                           pattern="[0-9]+([\.,][0-9]+)?" step="0.01"
                                           name="leadTime" class="form-control" value="{{$produto->getLeadTime()}}">

                                </div>
                            </div>





                            <!-- /.box-body -->
                        </div>




                        <!-- FIM CADASTRO -->




                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">


                        <!--  ESTRUTURA  -->
                        <div class="form-group row">
                            <label class="col-sm-1 control-label">Produto:</label>
                            <div class="col-sm-6">
                                <select class="js-data-example-ajax select2" id="busca_produto" name="produto.id"
                                        style="width: 100%">
                                    <option value="" disabled selected>Escolha um Produto</option>
                                    @foreach($produtos as $produto)
                                    <option value="{{$produto->getId()}}">{{$produto->getId()}} - {{$produto->getDescricao()}} - {{$produto->getSituacao()}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-sm-1">
                                <input id="quantidadeProdutoAdd" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" class="form-control">
                            </div>


                            <div class="col-sm-1">
                                <button type="button" class="btn btn-primary fa fa-plus" id="btnAddProduto"></button>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-sm-1 control-label">Material:</label>
                            <div class="col-sm-6">
                                <select class="js-data-example-ajax select2" id="busca_material" name="material.id"
                                        style="width: 100%">
                                    <option value="" disabled selected>Escolha um Material</option>

                                    @foreach($materiais as $material)
                                    <option value="{{$material->getId()}}">{{$material->getId()}} - {{$material->getDescricao()}} - {{$material->getSituacao()}}</option>
                                    @endforeach


                                </select>
                            </div>

                            <div class="col-sm-1">
                                <input id="quantidadeMaterialAdd" type="number"  pattern="[0-9]+([\.,][0-9]+)?" step="0.01" class="form-control">
                            </div>


                            <div class="col-sm-1">
                                <button type="button" class="btn btn-primary fa fa-plus" id="btnAddMaterial" ></button>
                            </div>
                        </div>



                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Lista de Materiais/Produtos</h3>
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
                                            <th>Tipo</th>
                                            <th style="width: 50px">Quantidade</th>
                                            <th style="width: 50px">Alterar</th>
                                            <th style="width: 50px">Remover</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabela_materiais">


                                        @foreach($produto->getItens() as $item)


                                        @if($item->getComponente() instanceof App\Entities\Material)
                                        @php
                                        $tipo = 'material'
                                        @endphp
                                        @else
                                        @php
                                        $tipo = 'produto'
                                        @endphp
                                        @endif


                                        <tr id='comp_'>
                                    <input type='hidden' name='item[]' value="{{$item->getComponente()->getId()}};{{$item->getQuantidade()}};{{$tipo}}"/>
                                    <td> {{ $loop->iteration }}</td>
                                    <td>{{$item->getComponente()->getId()}}</td>
                                    <td>{{$item->getComponente()->getDescricao()}}</td>
                                    <td>{{$tipo}}</td>
                                    <td><input type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" class="form-control" value="{{$item->getQuantidade()}}"></td>


                                    <td><button type='button' class='btn btn-primary fa fa-edit'></button></td>
                                    <td><button type='button' class='btn btn-secondary fa fa-remove' onclick='removeComponente(" + components + ")'></button></td>
                                    </tr>
                                    @endforeach


                                    </tbody>

                                </table>
                                </div>
                            </div>
                        </div>

                        <!--  FIM ESTRUTURA  -->


                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">


                        <!-- ROTEIRO -->

                        <div class="form-group row">
                            <label class="col-sm-1 control-label">Operação:</label>
                            <div class="col-sm-3">
                                <select class="js-data-example-ajax select2" id="busca_operacao"
                                        style="width: 100%" name="roteiro.operacao.id">
                                    <option value="" disabled selected>Escolha uma operação</option>

                                    @foreach($operacoes as $operacao)
                                    <option value="{{$operacao->getId()}}">{{$operacao->getId()}} - {{$operacao->getDescricao()}} - {{$operacao->getSetor()->getDescricao()}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-1 control-label">Tempo Setup:</label>
                            <div class="col-sm-1">
                                <input class="form-control" type="text" id="tempoSetup" name="tempoSetup" step="1" id="tempo_setup">
                            </div>
                            <label class="col-sm-1 control-label">Tempo Produção:</label>
                            <div class="col-sm-1">
                                <input class="form-control" type="text" id="tempoProducao" name="tempoProducao" step="1" id="tempo_setup">
                            </div>
                            <label class="col-sm-1 control-label">Tempo Finalização:</label>
                            <div class="col-sm-1">
                                <input class="form-control" type="text" id="tempoFinalizacao" name="tempoFinalizacao" step="1" id="tempo_setup">
                            </div>
                            <div class="col-sm-1">
                                <button type="button" class="btn btn-primary fa fa-plus" id="btnAddOperacao"></button>
                            </div>
                        </div>


                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Operações</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th style="width: 20px">ID</th>
                                            <th style="width: 200px">Descrição</th>
                                            <th style="width: 150px">Setor</th>
                                            <th style="width: 100px">Tempo Setup</th>
                                            <th style="width: 100px">Tempo Produção</th>
                                            <th style="width: 100px">Tempo Finalização</th>
                                            <th style="width: 50px">Alterar</th>
                                            <th style="width: 50px">Remover</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabela_operacoes">

                                        @foreach($produto->getRoteiros() as $roteiro)
                                        <tr id="{{'oper_'. $roteiro->getSequencia()}}">
                                    <input type='hidden' name='operacao[]' value="{{$roteiro->getOperacao()->getId()}};{{$roteiro->getTempoSetup()}};{{$roteiro->getTempoProducao()}};{{$roteiro->getTempoFinalizacao()}}"/>
                                    <td> {{$roteiro->getSequencia()}} </td>
                                    <td> {{$roteiro->getOperacao()->getId()}} </td>
                                    <td> {{$roteiro->getOperacao()->getDescricao()}} </td>
                                    <td> {{$roteiro->getOperacao()->getSetor()->getDescricao()}} </td>
                                    <td>{{$roteiro->getTempoSetup()}} </td>
                                    <td> {{$roteiro->getTempoProducao()}} </td>
                                    <td> {{$roteiro->getTempoFinalizacao()}} </td>
                                    <td><button type='button' class='btn btn-primary fa fa-edit'></button></td>
                                    <td><button type='button' class='btn btn-secondary fa fa-remove' onclick='removeOperacao(" {{$roteiro->getSequencia()}}")'></button></td>
                                    </tr>
                                    @endforeach

                                    </tbody>

                                </table>
                                </div>
                            </div>
                        </div>

                        <!-- FIM ROTEIRO -->

                    </div>
                </div>





                <div class="box-footer">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="reset" class="btn btn-secondary pull-right fa fa-ban"> Cancelar</button>
                    <button type="submit" class="btn btn-primary pull-right fa fa-save"> Salvar</button>
                </div>
            </form>
        </div>
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
<!-- /.box-footer -->




@stop


@section('js')
<script type="text/javascript">
    $(document).ready(function () {

    $('#tempoSetup').mask('00:00:00');
    $('#tempoProducao').mask('00:00:00');
    $('#tempoFinalizacao').mask('00:00:00');
    $("#busca_operacao").select2({
    placeholder: "Selecione uma Operação",
            minimumInputLength: 1
    });
    $("#busca_produto").select2({
    placeholder: "Selecione um Produto",
            minimumInputLength: 1
    });
    $("#busca_material").select2({
    placeholder: "Selecione um Material",
            minimumInputLength: 1
    });
    
    
    $(".select2").select2({
    allowClear: true
    });
    
    
    });</script>

<script type="text/javascript">
    var components = 0;
    var btnAddMaterial = document.querySelector("#btnAddMaterial");
    var btAddProduto = document.querySelector("#btnAddProduto");
    var CSRF_TOKEN = "{{ csrf_token() }}";
    btnAddMaterial.addEventListener("click", function (event){
    event.preventDefault();
    $.ajax({
    url: "{{url('produto/search_comp')}}",
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                    tipo: 'material',
                    id: $("#busca_material").val()},
            dataType: 'JSON',
            success: function (data) {
            var quantidade = $("#quantidadeMaterialAdd").val();
            adicionaComponente(data, quantidade, 'material');
            },
            error: function(e) {
            console.log(e.responseText);
            }
    });
    });
    btnAddProduto.addEventListener("click", function (event){
    event.preventDefault();
    $.ajax({
    url: "{{url('produto/search_comp')}}",
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                    tipo: 'produto',
                    id: $("#busca_produto").val()},
            dataType: 'JSON',
            success: function (data) {
            var quantidade = $("#quantidadeProdutoAdd").val();
            adicionaComponente(data, quantidade, 'produto');
            },
            error: function(e) {
            console.log(e.responseText);
            }
    });
    });
    function adicionaComponente(data, quantidade, tipo) {
    components++;
    $('#tabela_materiais').append("<tr id='comp_" + components + "'>" +
            "<input type='hidden' name='item[]' value='" + data.id + ";" + quantidade + ";" + tipo + "'/>" +
            "<td>" + components + "</td>" +
            "<td>" + data.id + "</td>" +
            "<td>" + data.descricao + "</td>" +
            "<td>" + tipo + "</td>" +
            "<td><input type='number' value=" + quantidade + "/></td>" +
            "<td><button type='button' class='btn btn-primary fa fa-edit'></button></td>" +
            "<td><button type='button' class='btn btn-secondary fa fa-remove' onclick='removeComponente(" + components + ")'></button></td>" +
            "</tr>");
    }

    function removeComponente(id) {
    document.getElementById('comp_' + id).remove();
    components--;
    }
</script>





<script type="text/javascript">
    var operacoes = 0;
    var btnAddOperacao = document.querySelector("#btnAddOperacao");
    var CSRF_TOKEN = "{{ csrf_token() }}";
    btnAddOperacao.addEventListener("click", function (event){
    event.preventDefault();
    $.ajax({
    url: "{{url('produto/search_oper')}}",
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                    id: $("#busca_operacao").val()},
            dataType: 'JSON',
            success: function (data) {
            var tempoSetup = $("#tempoSetup").val();
            var tempoProducao = $("#tempoProducao").val();
            var tempoFinalizacao = $("#tempoFinalizacao").val();
            adicionaOperacao(data, tempoSetup, tempoProducao, tempoFinalizacao);
            },
            error: function(e) {
            console.log(e.responseText);
            }
    });
    });
    function adicionaOperacao(data, tempoSetup, tempoProducao, tempoFinalizacao) {
    operacoes++;
    $('#tabela_operacoes').append("<tr id='oper_" + operacoes + "'>" +
            "<input type='hidden' name='operacao[]' value='" + data.id + ";" + tempoSetup + ";" + tempoProducao + ";" + tempoFinalizacao + "'/>" +
            "<td>" + operacoes + "</td>" +
            "<td>" + data.id + "</td>" +
            "<td>" + data.descricao + "</td>" +
            "<td>" + data.setor + "</td>" +
            "<td>" + tempoSetup + "</td>" +
            "<td>" + tempoProducao + "</td>" +
            "<td>" + tempoFinalizacao + "</td>" +
            "<td><button type='button' class='btn btn-primary fa fa-edit'></button></td>" +
            "<td><button type='button' class='btn btn-secondary fa fa-remove' onclick='removeOperacao(" + operacoes + ")'></button></td>" +
            "</tr>");
    }

    function removeOperacao(id) {
    document.getElementById('oper_' + id).remove();
    operacoes--;
    }
</script>
@stop












