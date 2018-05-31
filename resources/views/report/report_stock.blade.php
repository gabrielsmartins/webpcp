@extends('layouts.master')

@section('page', 'Relatório - Estoque')

@section('title','Relatório de Estoque')



@section('breadcrumb')
<!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item active">Relatórios</li>
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
                    <h4>Pesquisa</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ action('ReportController@stock') }}" method="GET" accept-charset="UTF-8">
                        
                         <div class="form-group row">       
                            <label class="col-sm-1 control-label"><strong>Pesquisar por:</strong></label>
                            <div class="form-group col-sm-2"> 
                                <select class="form-control" name="criterio">
                                    <option value="id">ID</option>
                                    <option value="codigoInterno">Código Interno</option>
                                    <option value="descricao">Descrição</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6"> 
                                <input placeholder="Critério" class="form-control" name="valor" type="text">
                            </div>

                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-1 control-label"><strong>Tipo:</strong></label>
                            <div class="form-group col-sm-3">  
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo" value="Produto" checked="true">
                                    <label class="form-check-label">Produto</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo"  value="Material">
                                    <label class="form-check-label">Material</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-1 control-label"><strong>Situação:</strong></label>
                            <div class="form-group col-sm-2">  
                                <select class="form-control" name="situacao">
                                    <option value="ATIVO">Ativo</option>
                                    <option value="INATIVO">Inativo</option>
                                    <option value="FORA_DE_LINHA">Fora de Linha</option>
                                    <option>Todos</option>
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="form-group row">
                            <label class="col-sm-1 control-label"><strong>Formato:</strong></label>
                            <div class="form-group col-sm-1">  
                                <select class="form-control" name="formato">
                                    <option value="html">HTML</option>
                                    <option value="pdf">PDF</option>
                                    <option value="xlsx">XLSX</option>
                                    <option value="docx">DOCX</option>
                                    <option VALUE="csv" selected="true">CSV</option>
                                     <option VALUE="xml">XML</option>
                                </select>
                            </div>
                        </div>

                       
                        <div class="box-footer">       
                            <button type="submit" class="btn btn-primary pull-right fa fa-print"> Gerar</button>
                        </div>
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