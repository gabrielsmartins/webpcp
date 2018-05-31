@extends('layouts.master')

@section('page', 'Requisição Material - Emitir')


@section('breadcrumb')
<!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/requisicao/show')}}">Requisições de Material</a></li>
            <li class="breadcrumb-item active">Editar</li>
          </ul>
        </div>
      </div>
@stop


@section('title','Requisição Material')


@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Requisição de Material Nº {{$requisicao->getId()}}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ action('RequisicaoMaterialController@cancel') }}"
                      method="POST" accept-charset="UTF-8">
                    <div class="box-body">
                        <input type="hidden" name="id" value="{{$requisicao->getId()}}"/>
                        <div class="form-group row">
                            <label for="responsavel" class="col-sm-1 control-label"><strong>Responsável:</strong></label>
                            <div class="col-sm-3">
                                <label for="responsavel" class="col-sm-6 control-label">{{Session::get('usuarioLogado')}}</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="responsavel" class="col-sm-1 control-label"><strong>Data Emissão:</strong></label>
                            <div class="col-sm-2">
                                <label for="responsavel" class="col-sm-1 control-label">{{$requisicao->getDataEmissao()->format('d/m/Y')}}</label>
                            </div>


                            <label for="descricao" class="col-sm-1 control-label"><strong>Prazo:</strong></label>
                            <div class="col-sm-2">
                                <label for="responsavel" class="col-sm-1 control-label">{{$requisicao->getPrazo()->format('d/m/Y')}}</label>
                            </div>
                        </div>
                        
                        
                        
                          <div class="form-group row">
                                <label class="col-sm-1 control-label"><strong>Status:</strong></label>
                                <div class="col-sm-6">

                                    @switch($requisicao->getStatus())
                                    @case('EMITIDA')
                                    <span class="badge badge-secondary">{{$requisicao->getStatus()}}</span>
                                    @break

                                    @case('CONCLUIDA PARCIAL')
                                    <span class="badge badge-warning">{{$requisicao->getStatus()}}</span>
                                    @break


                                    @case('CONCLUIDA TOTAL')
                                    <span class="badge badge-success">{{$requisicao->getStatus()}}</span>
                                    @break

                                    @case('CANCELADA')
                                    <span class="badge badge-danger">{{$requisicao->getStatus()}}</span>
                                    @break

                                    @default
                                    <span class="badge badge-info">{{$requisicao->getStatus()}}</span>
                                    @endswitch


                                </div>
                            </div>


                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Lista de Materiais da Requisição</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th style="width: 20px">ID</th>
                                                <th>Descrição</th>
                                                <th style="width: 50px">Quantidade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($requisicao->getItens() as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{$item->getMaterial()->getId()}}</td>
                                                <td>{{$item->getMaterial()->getDescricao()}}</td>
                                                <td>{{$item->getQuantidade()}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.box-body -->
                   <div class="box-footer">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            @if ($requisicao->getStatus() == 'EMITIDA')
                            <button type="submit" class="btn btn-primary pull-right fa fa-remove"> Cancelar</button>
                            @else
                            <button type="submit" class="btn btn-primary pull-right fa fa-remove" disabled="true"> Cancelar</button>
                            @endif
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
        </div>
    </div>
</div>
@stop



