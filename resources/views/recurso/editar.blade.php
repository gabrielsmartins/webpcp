@extends('layouts.master')

@section('page', 'Recurso - Editar')

@section('title','Editar - Recurso')


@section('content')



<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>{{$recurso->getDescricao()}} - {{$recurso->getSetor()->getDescricao()}}</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ action('RecursoController@update') }}" method="POST" accept-charset="UTF-8">
                        <div class="form-group">
                            <label for="descricao" class="col-sm-1 control-label">Descrição:</label>
                            <input type="hidden" name="id" value="{{$recurso->getId()}}">
                            <input type="text" class="form-control" id="descricao" placeholder="Descrição" name="descricao" value="{{$recurso->getDescricao()}}">
                        </div>
                        <div class="form-group">
                            <label for="sigla" class="col-sm-1 control-label">Setor:</label>
                            <select name="setor" class="form-control">
                                <option value="" disabled selected>Escolha um setor</option>
                                @foreach($setores as $setor)
                                <option value="{{$setor->getId()}}" 
                                        @if ($recurso->getSetor()->getId() == $setor->getId())
                                        selected 
                                        @endif
                                        >{{$setor->getDescricao()}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group">       
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input value="Salvar" class="btn btn-primary" type="submit">
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




