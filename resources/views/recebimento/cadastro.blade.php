@extends('layouts.master')

@section('page', 'Recebimento Estoque - Material')

@section('title','Recebimento Estoque Material')


@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Registrar</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal" action="{{ action('RecebimentoMaterialController@store') }}"
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
                <div class="col-sm-3">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control pull-right" id="datepicker" type="text" name="dataRetirada" value="{{date('d/m/Y')}}">
                    </div>
                </div>
            </div>



             <div class="form-group row">
                        <label class="col-sm-1 control-label">Produto:</label>
                        <div class="col-sm-6">
                            <select class="js-data-example-ajax" id="busca_material" name="material.id"
                                    style="width: 100%">
                                <option value="" disabled selected>Escolha um Produto</option>

                                @foreach($requisicoes as $requisicao)
                                <option value="{{$material->getId()}}">{{$material->getId()}} - {{$material->getDescricao()}} - {{$material->getSituacao()}} - Qntd ({{$material->getQuantidadeEstoque()}})</option>
                                @endforeach


                            </select>
                        </div>
                       <label class="col-sm-1 control-label">Quantidade:</label>
                        <div class="col-sm-1">
                            <input id="quantidadeProdutoAdd" type="number"  pattern="[0-9]+([\.,][0-9]+)?" step="0.01" class="form-control">
                        </div>


                        <div class="col-sm-1">
                            <button type="button" class="btn btn-cancel fa fa-plus" id="btnAddProduto" ></button>
                        </div>
                    </div>

        
        <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Lista de Produtos da Retirada</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th style="width: 20px">ID</th>
                                        <th>Descrição</th>
                                        <th style="width: 50px">Quantidade</th>
                                        <th style="width: 50px">Alterar</th>
                                        <th style="width: 50px">Remover</th>
                                    </tr>
                                </thead>
                                <tbody id="tabela_materiais">


                                </tbody>

                            </table>
                        </div>
                    </div>
        </div>
        
            <!-- /.box-body -->
        <div class="box-footer">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="reset" class="btn btn-cancel pull-right fa fa-ban"> Cancelar</button>
            <button type="submit" class="btn btn-save pull-right fa fa-save"> Salvar</button>
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
        <!-- /.box-footer -->
    </form>

@stop


@section('js')
<script type="text/javascript">
//Date picker
    $('#datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        language: 'pt-BR'
    });


    //Timepicker
    $('.timepicker').timepicker({
        showInputs: false
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
  
        $("#busca_material").select2({
            placeholder: "Selecione um Produto",
            minimumInputLength: 1
        });
    });
</script>


<script type="text/javascript">
var components = 0;
var btnAddProduto = document.querySelector("#btnAddProduto");
var CSRF_TOKEN = "{{ csrf_token() }}";


btnAddProduto.addEventListener("click",function (event){
    event.preventDefault();
   
    $.ajax({
    url: "{{url('retirada/search_produto')}}",
    type: 'POST',
    data: {_token: CSRF_TOKEN,
           tipo: 'material',
           id: $("#busca_material").val()},
    dataType: 'JSON',
    success: function (data) {
         var quantidade = $("#quantidadeProdutoAdd").val();
         console.log(data);
        adicionaProduto(data,quantidade);
    },
     error: function(e) {
    console.log(e.responseText);
    }
  });     
});


 function adicionaProduto(data,quantidade) {
        components++;
        $('#tabela_materiais').append("<tr id='comp_"+ components +"'>" +
                                       "<input type='hidden' name='item[]' value='" + data.id +";"+ quantidade+"'/>"+
                                       "<td>" + components + "</td>" +
                                        "<td>" + data.id + "</td>" +
                                        "<td>" + data.descricao + "</td>" +
                                        "<td>" + quantidade + "</td>" +
                                        "<td><button type='button' class='btn btn-save fa fa-edit'></button></td>" +
                                        "<td><button type='button' class='btn btn-cancel fa fa-remove' onclick='removeMaterial(" + components + ")'></button></td>" +
                                      "</tr>");
                              
    }

    function removeMaterial(id) {
     document.getElementById('comp_' + id ).remove();
     components--;
    }
</script>
@stop
