@extends('layouts.master')

@section('page', 'Operação - Editar')

@section('title','Editar - Operação')


@section('content')


<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>{{$operacao->getDescricao()}} - {{$operacao->getSetor()->getDescricao()}}</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ action('OperacaoController@update') }}" method="POST" accept-charset="UTF-8">
                        <div class="form-group row">
                            <label for="descricao" class="col-sm-1 control-label">Descrição:</label>
                            <input type="hidden" name="id" value="{{$operacao->getId()}}">
                            <div class="form-group col-sm-3">  
                                <input type="text" class="form-control" id="descricao" placeholder="Descrição" name="descricao" value="{{$operacao->getDescricao()}}" required="true">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descricao" class="col-sm-1 control-label">Instrução:</label>
                            <div class="form-group col-sm-6"> 
                                <textarea name="instrucao" placeholder="Instrução" class="form-control" required="true">{{$operacao->getInstrucao()}}</textarea>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="sigla" class="col-sm-1 control-label">Setor:</label>

                            <div class="form-group col-sm-3"> 
                                <select name="setor" class="form-control" required="true">
                                    <option value="" disabled selected>Escolha um setor</option>
                                    @foreach($setores as $setor)
                                    <option value="{{$setor->getId()}}" 
                                            @if ($operacao->getSetor()->getId() == $setor->getId())
                                            selected 
                                            @endif
                                            >{{$setor->getDescricao()}}</option>
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











