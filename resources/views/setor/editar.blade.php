@extends('layouts.master')

@section('page', 'Setor - Editar')

@section('title','Editar - Setor')
 

@section('content')
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Cadastro</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{ action('SetorController@update') }}" method="POST" accept-charset="UTF-8">
              <div class="box-body">
                <div class="form-group row">
                    <input type="hidden" name="id" value="{{ $setor->getId()}}">
                  <label for="descricao" class="col-sm-1 control-label">Descrição:</label>

                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="descricao" placeholder="Descrição" name="descricao" required="required" value="{{ $setor->getDescricao()}}">
                  </div>
                </div>
              </div>
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


