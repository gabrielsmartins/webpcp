@extends('layouts.master')

@section('page', 'Operação - Editar')

@section('title','Editar - Operação')


@section('content')


<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Cadastro</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal" action="{{ action('OperacaoController@update') }}" method="POST" accept-charset="UTF-8">
        <div class="box-body">
            <div class="form-group row">
                <label for="descricao" class="col-sm-1 control-label">Descrição:</label>
                  <input type="hidden" name="id" value="{{$operacao->getId()}}">
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="descricao" placeholder="Descrição" name="descricao" value="{{$operacao->getDescricao()}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="descricao" class="col-sm-1 control-label">Instrução:</label>
                <div class="col-sm-6">
                    <textarea name="instrucao" placeholder="Instrução" class="form-control">{{$operacao->getInstrucao()}}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="sigla" class="col-sm-1 control-label">Setor:</label>

                <div class="col-sm-3">
                    <select name="setor" class="form-control">
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
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="reset" class="btn btn-cancel pull-right fa fa-ban"> Cancelar</button>
            <button type="submit" class="btn btn-save pull-right fa fa-save"> Salvar</button>
        </div>
        <!-- /.box-footer -->

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

    </form>
</div>

@stop


