@extends('layouts.master')

@section('page', 'Unidade de Medida - Cadastro')

@section('title','Cadastro')


@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>Nova Unidade de Medida</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ action('UnidadeMedidaController@store') }}" method="POST" accept-charset="UTF-8">
                        <div class="form-group">
                            <label>Descrição:</label>
                            <input placeholder="Descrição" class="form-control" type="text" name="descricao">
                        </div>
                        <div class="form-group">       
                            <label>Sigla:</label>
                            <input placeholder="Sigla" class="form-control" name="sigla" type="text">
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