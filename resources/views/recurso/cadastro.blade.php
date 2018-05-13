@extends('layouts.master')

@section('page', 'Recurso - Cadastro')

@section('title','Cadastro')


@section('content')


<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>Novo Recurso</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ action('RecursoController@store') }} "method="POST" accept-charset="UTF-8">


                        <div class="form-group row">
                            <label for="descricao" class="col-sm-1 control-label">Descrição:</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" id="descricao" placeholder="Descrição" name="descricao" required="true">
                            </div>


                        </div>
                        <div class="form-group row">
                            <label for="setor" class="col-sm-1 control-label">Setor:</label>

                            <div class="col-md-3">
                                <select name="setor" class="form-control" required="true">
                                    <option value="" disabled selected>Escolha um setor</option>
                                    @foreach($setores as $setor)
                                    <option value="{{$setor->getId()}}">{{$setor->getDescricao()}}</option>
                                    @endforeach
                                </select>
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







