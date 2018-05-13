@extends('layouts.master')

@section('page', 'Unidade de Medida - Editar')

@section('title','Editar - Unidade de Medida')


@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>{{ $unidade->getDescricao()}} - {{ $unidade->getSigla()}}</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ action('UnidadeMedidaController@update') }}" method="POST" accept-charset="UTF-8">
                        <div class="form-group row">
                            <label class="col-sm-1 control-label">Descrição:</label>
                            <input type="hidden" name="id" value="{{ $unidade->getId()}}">
                            <div class="form-group col-sm-3">  
                            <input placeholder="Descrição" class="form-control" type="text" name="descricao" value="{{ $unidade->getDescricao()}}" required="true">
                            </div>
                        </div>
                        <div class="form-group row">       
                            <label class="col-sm-1 control-label">Sigla:</label>
                            <div class="form-group col-sm-1">  
                            <input placeholder="Sigla" class="form-control" type="text" name="sigla" value="{{ $unidade->getSigla()}}" required="true">
                            </div>
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









