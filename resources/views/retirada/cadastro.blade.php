@extends('layouts.master')

@section('page', 'Retirada Estoque Produto')

@section('title','Retirada Estoque Produto')


@section('breadcrumb')
<!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/retirada/show')}}">Retiradas</a></li>
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
                    <h4>Nova Retirada de Estoque</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ action('RetiradaProdutoController@store') }}"
                          method="POST" accept-charset="UTF-8">
                        <div class="box-body">

                            <div class="form-group row">
                                <label for="responsavel" class="col-sm-1 control-label">Responsável:</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" disabled="true" value="{{Session::get('usuarioLogado')}}"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="descricao" class="col-sm-1 control-label">Data:</label>
                                <div class="col-sm-2">
                                    <div class="input-group date">
                                        <input class="form-control pull-right" id="datepicker" type="text" name="dataRetirada" value="{{date('d/m/Y')}}">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-sm-1 control-label">Produto:</label>
                                <div class="col-sm-6">
                                    <select class="js-data-example-ajax select2" id="busca_material" name="material.id"
                                            style="width: 100%">
                                        <option value="" disabled selected>Escolha um Produto</option>

                                        @foreach($produtos as $produto)
                                        <option value="{{$produto->getId()}}">{{$produto->getId()}} - {{$produto->getDescricao()}} - {{$produto->getSituacao()}} - Qntd ({{$produto->getQuantidadeEstoque()}})</option>
                                        @endforeach


                                    </select>
                                </div>
                                <label class="col-sm-1 control-label">Quantidade:</label>
                                <div class="col-sm-1">
                                    <input id="quantidadeProdutoAdd" type="number"  pattern="[0-9]+([\.,][0-9]+)?" step="0.01" class="form-control">
                                </div>


                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-primary fa fa-plus" id="btnAddProduto" ></button>
                                </div>
                            </div>


                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Lista de Produtos da Retirada</h3>
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
                                                <th style="width: 50px">Quantidade</th>
                                                <th style="width: 50px">Remover</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabela_materiais">


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
                            <button type="submit" class="btn btn-primary pull-right fa fa-save"> Registrar</button>
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
//Date picker
    $('#datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        language: 'pt-BR'
    });


  
</script>

<script type="text/javascript">
    $(document).ready(function () {

        $("#busca_material").select2({
            placeholder: "Selecione um Produto",
            minimumInputLength: 1
        });
        
        
        $(".select2").select2({
            allowClear: true
        });
    });
</script>


<script type="text/javascript">
    var components = 0;
    var btnAddProduto = document.querySelector("#btnAddProduto");
    var CSRF_TOKEN = "{{ csrf_token() }}";


    btnAddProduto.addEventListener("click", function (event) {
        event.preventDefault();

        $.ajax({
            url: "{{url('retirada/search_produto')}}",
            type: 'POST',
            beforeSend: function () {
                HoldOn.open({
                    theme: 'sk-rect',
                    message: "<h4>Carregando... Aguarde</h4>"
                });
            },
            data: {_token: CSRF_TOKEN,
                tipo: 'material',
                id: $("#busca_material").val()},
            dataType: 'JSON',
            success: function (data) {
                var quantidade = $("#quantidadeProdutoAdd").val();
                console.log(data);
                adicionaProduto(data, quantidade);
                HoldOn.close();
            },
            error: function (e) {
                console.log(e.responseText);
                HoldOn.close();
            }
        });
    });


    function adicionaProduto(data, quantidade) {
        components++;
        $('#tabela_materiais').append("<tr id='comp_" + components + "'>" +
                "<input type='hidden' name='item[]' value='" + data.id + ";" + quantidade + "'/>" +
                "<td>" + components + "</td>" +
                "<td>" + data.id + "</td>" +
                "<td>" + data.descricao + "</td>" +
                "<td>" + quantidade + "</td>" +
                "<td><button type='button' class='btn btn-secondary fa fa-remove' onclick='removeMaterial(" + components + ")'></button></td>" +
                "</tr>");

    }

    function removeMaterial(id) {
        document.getElementById('comp_' + id).remove();
        components--;
    }
</script>
@stop





