@extends('layouts.master')

@section('page', 'Material - Editar')

@section('title','Editar - Material')


@section('content')


<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>{{$material->getCodigoInterno()}} - {{$material->getDescricao()}}</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ action('MaterialController@update') }} "method="POST" accept-charset="UTF-8">


                        <div class="box-body">


                            <div class="box-header with-border">
                                <h3 class="box-title">Dados Básicos</h3>
                            </div>






                            <div class="form-group row">
                                <label for="descricao" class="col-sm-1 control-label">Código Interno:</label>

                                <div class="col-sm-2">
                                    <input class="form-control" type="hidden" name="id" value="{{$material->getId()}}">
                                    <input id="codigoInterno" class="form-control" type="text" name="codigoInterno" value="{{$material->getCodigoInterno()}}">
                                </div>


                                <label for="descricao" class="col-sm-1 control-label">Descrição:</label>
                                <div class="col-sm-6">
                                    <input id="descricao" class="form-control" type="text" name="descricao" value="{{$material->getDescricao()}}">
                                </div>
                            </div>




                            <div class="form-group row">
                                <label for="valorUnitario" class="col-sm-1 control-label">Valor Unitário:</label>

                                <div class="col-sm-3">
                                    <input id="valorUnitario" class="form-control" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" name="valorUnitario" value="{{$material->getValorUnitario()}}"> 
                                </div>

                                <div class="col-sm-6">
                                    <label for="ATIVO" class="radio-inline">
                                        <input name="situacao" type="radio" id="ATIVO" value="ATIVO" @if ($material->getSituacao() == 'ATIVO') checked @endif> Ativo
                                    </label>

                                    <label for="INATIVO" class="radio-inline">
                                        <input name="situacao" type="radio" id="INATIVO" VALUE="INATIVO" @if ($material->getSituacao() == 'INATIVO') checked @endif> Inativo
                                    </label>

                                    <label for="FORA_DE_LINHA" class="radio-inline">
                                        <input name="situacao" type="radio" id="FORA_DE_LINHA" VALUE="FORA_DE_LINHA" @if ($material->getSituacao() == 'FORA_DE_LINHA') checked @endif> Fora de Linha
                                    </label>

                                </div>
                            </div>






                            <div class="box-header with-border">
                                <h3 class="box-title">Dados Técnicos</h3>
                            </div>


                            <div class="form-group row">
                                <label for="unidadeMedida" class="col-sm-1 control-label">Unidade de Medida:</label>

                                <div class="col-sm-3">
                                    <select name="unidadeMedida" class="form-control">


                                        <option value="" disabled selected>Escolha uma unidade</option>

                                        @foreach($unidades as $unidade)
                                        <option value="{{$unidade->getId()}}"
                                                @if ($material->getUnidadeMedida()->getId() == $unidade->getId()) 
                                                selected 
                                                @endif

                                                >{{$unidade->getDescricao()}} - {{$unidade->getSigla()}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <label for="peso" class="col-sm-1 control-label">Peso (KG):</label>
                                <div class="col-sm-3">
                                    <input id="peso" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" name="peso" class="form-control" value="{{$material->getPeso()}}"> 
                                </div>

                            </div>


                            <div class="form-group row">
                                <label for="comprimento" class="col-sm-1 control-label">Comprimento (mm):</label>
                                <div class="col-sm-2">
                                    <input id="comprimento" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" name="comprimento" class="form-control" value="{{$material->getComprimento()}}"> 
                                </div>


                                <label for="comprimento" class="col-sm-1 control-label">Largura (mm):</label>
                                <div class="col-sm-2">
                                    <input id="largura" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" name="largura" class="form-control" value="{{$material->getLargura()}}"> 
                                </div>


                                <label for="altura" class="col-sm-1 control-label">Altura (mm):</label>
                                <div class="col-sm-2">
                                    <input id="altura" type="number" pattern="[0-9]+([\.,][0-9]+)?"
                                           step="0.01" name="altura" class="form-control" value="{{$material->getAltura()}}"> 
                                </div>

                            </div>







                            <div class="box-header with-border">
                                <h3 class="box-title">Dados Estoque</h3>
                            </div>


                            <div class="form-group row">
                                <label for="quantidadeEstoque" class="col-sm-1 control-label">Quantidade Estoque :</label>
                                <div class="col-sm-2">
                                    <input id="quantidadeEstoque" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" name="quantidadeEstoque" class="form-control"  value="{{$material->getQuantidadeEstoque()}}"> 

                                </div>

                                <label for="quantidadeMinima" class="col-sm-1 control-label">Quantidade Mínima :</label>
                                <div class="col-sm-2">
                                    <input id="quantidadeMinima" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" name="quantidadeMinima" class="form-control"  value="{{$material->getQuantidadeMinima()}}"> 

                                </div>

                                <label for="leadtime" class="col-sm-1 control-label">Lead Time (D) :</label>
                                <div class="col-sm-2">
                                    <input id="leadtime" type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" name="leadTime" class="form-control" value="{{$material->getLeadTime()}}"> 

                                </div>
                            </div>





                            <!-- /.box-body -->
                        </div>




                        <div class="form-group">       
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="reset" class="btn btn-secondary pull-right fa fa-ban"> Cancelar</button>
                            <button type="submit" class="btn btn-primary pull-right fa fa-save"> Salvar</button>
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







