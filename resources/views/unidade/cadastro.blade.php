@extends('layouts.master')

@section('page', 'Unidade de Medida - Cadastro')

@section('title','Cadastro')

@section('breadcrumb')
<!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/unidade/show')}}">Unidades</a></li>
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
                    <h4>Nova Unidade de Medida</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ action('UnidadeMedidaController@store') }}" method="POST" accept-charset="UTF-8">
                        <div class="form-group row">
                            <label class="col-sm-1 control-label">Descrição:</label>
                             <div class="form-group col-sm-3">  
                            <input placeholder="Descrição" class="form-control" type="text" name="descricao" required="true">
                             </div>
                        </div>
                        <div class="form-group row">       
                            <label class="col-sm-1 control-label">Sigla:</label>
                             <div class="form-group col-sm-1">  
                                 <input placeholder="Sigla" class="form-control" name="sigla" type="text" required="true">
                             </div>
                        </div>
                          <div class="box-footer">       
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