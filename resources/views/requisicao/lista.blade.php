@extends('layouts.master')

@section('page', 'Requisição de Material - Consulta')

@section('title','Consultar - Requisição de Material')


@section('breadcrumb')
<!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item active">Requisições de Material</li>
          </ul>
        </div>
      </div>
@stop



@section('content')

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4>Requisições de Material</h4>
        </div>
        <div class="card-body">


            @if (session('success'))
            <br>
            <div class="alert alert-success" role="alert"> 
                {{ session('success') }}
            </div>
            <br>
            @endif


            @if (session('error'))
            <br>
            <div class="alert alert-danger" role="alert"> 
                {{ session('error') }}
            </div>
            <br>
            @endif



            <div class="row">



                <div class="card-body">
                    <div class="col-md-12">
                        <form method="get" action="{{action('RequisicaoMaterialController@pesquisarPorCriterio') }}" class="form-inline">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="inlineFormInput" class="sr-only">Pesquisar por:</label>
                                    <select class="form-control input-sm" name="criterio">
                                        <option value="id" @if(! empty($criterio)) {{ $criterio == 'id' ? 'selected' : '' }} @endif>ID</option>
                                        <option value="data" @if(! empty($criterio)) {{  $criterio == 'descricao' ? 'selected' : '' }}@endif>Data</option>
                                        <option value="status" @if(! empty($criterio)) {{  $criterio == 'sigla' ? 'selected' : '' }} @endif>Status</option>
                                    </select>
                                    <input class="form-control input-sm" placeholder=""  type="search" name="valor" @if(! empty($valor)) value=" {{ $valor }}" @endif>
                                           <button class="btn btn-primary fa fa-search" type="submit"></button>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group pull-right">
                                    <label><strong>Exibir:</strong></label>
                                    <select name="limit" aria-controls="example1" class="form-control input-sm" >
                                        <option value="10" @if(! empty($limit)) {{ $limit == 10 ? 'selected' : '' }} @endif>10</option>
                                        <option value="25" @if(! empty($limit))  {{ $limit == 25 ? 'selected' : '' }} @endif>25</option>
                                        <option value="50" @if(! empty($limit))  {{ $limit == 50 ? 'selected' : '' }} @endif>50</option>
                                        <option value="100" @if(! empty($limit))  {{ $limit == 100 ? 'selected' : '' }} @endif>100</option>
                                    </select> 
                                    <label><strong>Registros</strong></label>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>




            </div>




            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Responsável</th>
                                    <th>Data Emissão</th>
                                    <th>Prazo</th>
                                    <th>Status</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($requisicoes as $requisicao)
       
                                <tr>
                                    <td>{{$requisicao->getId()}}</td>
                                    <td>{{$requisicao->getResponsavel()->getNome()}}</td>
                                    <td>{{$requisicao->getDataEmissao()->format('d/m/Y') }}</td>
                                    <td>{{$requisicao->getPrazo()->format('d/m/Y')}}</td>


                                    @switch($requisicao->getStatus())
                                    @case('EMITIDA')
                                    <td>
                                        <span class="badge badge-secondary">{{$requisicao->getStatus()}}</span>
                                    </td>

                                    @break

                                    @case('CONCLUIDA PARCIAL')
                                    <td>
                                        <span class="badge badge-warning">{{$requisicao->getStatus()}}</span>
                                    </td>

                                    @break


                                    @case('CONCLUIDA TOTAL')
                                    <td>
                                        <span class="badge badge-success">{{$requisicao->getStatus()}}</span>
                                    </td>

                                    @break

                                    @case('CANCELADA')
                                    <td>
                                        <span class="badge badge-danger">{{$requisicao->getStatus()}}</span>
                                    </td>

                                    @break

                                    @default
                                    <td>
                                        <span class="badge badge-info">{{$requisicao->getStatus()}}</span>
                                    </td>

                                    @endswitch

                                    <td  style="width: 10px;">
                                        <a href="{{ URL::to('/requisicao/edit/'.$requisicao->getId()) }}"
                                           class="btn btn-primary"><i class="fa fa-search-plus fa-sm"></i>
                                        </a> 
                                    </td>
                                </tr>



                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-5">

                </div>
                <div class="col-sm-7">
                    @if(! empty($criterio))
                    {{ $requisicoes->appends(['requisicoes'=>$criterio,'valor'=>$valor,'limit'=>$limit])->links() }}
                    @else
                    {{ $requisicoes->links() }}
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@stop











