@extends('layouts.master')

@section('page', 'Ordem de Produção')

@section('title','Ordem de Produção')


@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>Nova Ordem de Produção</h4>
                </div>
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
                                <label for="descricao" class="col-sm-1 control-label">Prazo:</label>
                                <div class="col-sm-3">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input class="form-control pull-right" id="datepicker" type="text" name="prazo" value="{{date('d/m/Y')}}">
                                    </div>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-sm-1 control-label">Produto:</label>
                                <div class="col-sm-6">
                                    <select  class="select2" id="busca_produto" name="produto.id">
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
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-primary" id="btnImportarRoteiro" >Importar Roteiro</button>
                                </div>
                            </div>


                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Programação</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <table class="table table-striped repeater">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th style="width: 20px">ID</th>
                                                <th>Descrição</th>
                                                <th style="width: 150px">Tempo Setup</th>
                                                <th style="width: 150px">Tempo Produção</th>
                                                <th style="width: 150px">Tempo Finalização</th>
                                                <th style="width: 50px">Remover</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabela_materiais">
                                            <tr data-repeater-list="group-a">
                                                <td data-repeater-item>1</td>
                                                <td data-repeater-item>1</td>
                                                <td data-repeater-item>
                                                    <select class="select2" name="param">
                                                        <option value="AK">
                                                            Alaska
                                                        </option>
                                                        <option value="HI">
                                                            Hawaii
                                                        </option>
                                                        <option value="CA">
                                                            California
                                                        </option>
                                                    </select></td>
                                                <td data-repeater-item><input type="text"/></td>
                                                <td data-repeater-item><input type="text"/></td>
                                                <td data-repeater-item><input type="text"/></td>
                                                <td data-repeater-item><input data-repeater-delete type="button" value="Delete"/></td>
                                                <td data-repeater-item><input data-repeater-create type="button" id="repeater-button" value="Add"/></td>
                                            </tr>

                                        </tbody>

                                    </table>
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
                    
                    
               <form class="repeater">
    <div data-repeater-list="group-a">
      <div data-repeater-item>
        <input type="text" name="text-input" value="A"/>
        <input data-repeater-delete type="button" value="Delete"/>
      </div>
      <div data-repeater-item>
        <input type="text" name="text-input" value="B"/>
        //select input with class select-2
        <select class="select2" name="param">
            <option value="AK">
            Alaska
            </option>
            <option value="HI">
            Hawaii
            </option>
            <option value="CA">
            California
            </option>
        </select>
        <input data-repeater-delete type="button" value="Delete"/>
      </div>
    </div>
    <input data-repeater-create type="button" id="repeater-button" value="Add"/>
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

        $("#busca_produto").select2({
            placeholder: "Selecione um Produto",
            allowClear: true
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
            data: {_token: CSRF_TOKEN,
                tipo: 'material',
                id: $("#busca_material").val()},
            dataType: 'JSON',
            success: function (data) {
                var quantidade = $("#quantidadeProdutoAdd").val();
                console.log(data);
                adicionaProduto(data, quantidade);
            },
            error: function (e) {
                console.log(e.responseText);
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
                "<td><button type='button' class='btn btn-primary fa fa-edit'></button></td>" +
                "<td><button type='button' class='btn btn-secondary fa fa-remove' onclick='removeMaterial(" + components + ")'></button></td>" +
                "</tr>");

    }

    function removeMaterial(id) {
        document.getElementById('comp_' + id).remove();
        components--;
    }
</script>


<script type="text/javascript">

    $("#repeater-button").click(function () {
        
        alert("xx");
        setTimeout(function () {

            $(".select2").select2({
                placeholder: "Select a state",
                allowClear: true
            });

        }, 100);
    });

</script>


                  

@stop





