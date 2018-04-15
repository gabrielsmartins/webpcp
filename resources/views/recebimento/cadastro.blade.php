@extends('layouts.master')

@section('page', 'Recebimento Estoque - Material')

@section('title','Recebimento Estoque Material')


@section('content')

    <!-- /.box-header -->

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

    <table class="table table-fixed table-striped" id="tabelaOrigem">
        <thead>
            <tr>
                <th class="col-xs-1">ID Req</th>
                <th class="col-xs-1">Item Nº</th>
                <th class="col-xs-1">Data Emissão</th>
                <th class="col-xs-3">Descrição</th>
                <th class="col-xs-1">Qntd Solic.</th>
                <th class="col-xs-1">Prazo</th>
                <th class="col-xs-1">Status</th>
                <th class="col-xs-2">Qntd Solic.</th>
                <th class="col-xs-1">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requisicoes as $requisicao)
                @foreach($requisicao->getItens() as $item)
            <tr>
                <td class="col-xs-1"><span id="req_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getRequisicao()->getId()}}</span></td>
                <td class="col-xs-1"><span id="req_item_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getRequisicao()->getId()}}.{{ $loop->iteration }}</span></td>
                <td class="col-xs-1"><span id="data_emissao_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getRequisicao()->getDataEmissao()->format('d/m/Y') }}</span></td>
                <td class="col-xs-3"><span id="material_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getMaterial()->getDescricao()}}</span></td>
                <td class="col-xs-1"><span id="quantidade_solicitada_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getQuantidade()}}</span></td>
                <td class="col-xs-1"><span id="prazo_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getRequisicao()->getPrazo()->format('d/m/Y')}}</span></td>
                <td class="col-xs-1"><span id="status_{{ $loop->parent->iteration }}.{{ $loop->iteration }}">{{$item->getRequisicao()->getStatus()}}</span></td>
                <td class="col-xs-2"><input type="number"  id="quantidade_recebida_{{ $loop->parent->iteration }}.{{ $loop->iteration }}" /></td>
                <th class="col-xs-1"><button class="btn btn-cancel fa fa-plus" onclick="adicionaItem({{ $loop->parent->iteration }}.{{ $loop->iteration }})"></button></th>
            </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
  


    
    
     <div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Itens Selecionados</h3>
    </div>
       <!-- form start -->
    <form class="form-horizontal" action="{{ action('RecebimentoMaterialController@store') }}" method="POST" accept-charset="UTF-8">
        <div class="box-body">

            <div class="form-group row">
                <label for="responsavel" class="col-sm-1 control-label">Responsável:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" disabled="true" value="{{Session::get('usuarioLogado')}}"/>
                </div>
                <div class="col-sm-1">
                    <label for="descricao" class="col-sm-1 control-label">Data:</label>
                </div>
                <div class="col-sm-3">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input class="form-control pull-right" id="datepicker" type="text" name="dataRetirada" value="{{date('d/m/Y')}}">
                    </div>
                </div>
                </div>
            </div>
     
        
        
        <table class="table table-fixed table-striped" id="myTable">
        <thead>
            <tr>
                <th class="col-xs-1">ID Req</th>
                <th class="col-xs-1">Item Nº</th>
                <th class="col-xs-1">Data Emissão</th>
                <th class="col-xs-3">Descrição</th>
                <th class="col-xs-1">Qntd Solic.</th>
                <th class="col-xs-1">Prazo</th>
                <th class="col-xs-1">Status</th>
                <th class="col-xs-2">Qntd Solic.</th>
                <th class="col-xs-1">Ação</th>
            </tr>
        </thead>
        <tbody id="tabelaDestino">
           
        </tbody>
    </table>
        
        

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


    //Timepicker
    $('.timepicker').timepicker({
        showInputs: false
    });
</script>
    <script type="text/javascript">
function pesquisar() {
  // Declare variables
  var input, filter, table, tr, td, i,select,field;
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
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
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
      var material = document.getElementById("material_" + id).textContent;
      var quantidade_solicitada = document.getElementById("quantidade_solicitada_" + id).textContent;
      var prazo = document.getElementById("prazo_" + id).textContent;
      var status = document.getElementById("status_" + id).textContent;
      var quantidade_recebida = document.getElementById("quantidade_recebida_" + id).value;


 
      var row = "<tr id='row_"+id+"'>" +
                "<input type='hidden' value='"+req+";"+req_item+";"+quantidade_recebida+"' name='itens[]'/>" +
                "<td class='col-xs-1'>"+req+"</td>" +
                "<td class='col-xs-1'>"+req_item+"</td>" +
                "<td class='col-xs-1'>"+data_emissao+"</td>" +
                "<td class='col-xs-3'>"+material+"</td>" +
                "<td class='col-xs-1'>"+quantidade_solicitada+"</td>" +
                "<td class='col-xs-1'>"+prazo+"</td>" +
                "<td class='col-xs-1'>"+status+"</td>" +
                "<td class='col-xs-2'><input type='number'  value='"+quantidade_recebida+"' disabled='true' /></td>" +
                "<td class='col-xs-1'><button class='btn btn-cancel fa fa-remove' onclick='removeItem("+id+")'></button></td>"+
            "</tr>";
    
    $("#tabelaDestino").append(row);
     
        
                              
    }

    function removeItem(id) {
     document.getElementById('row_' + id ).remove();
     components--;
    }
</script>
    @stop

