@extends('layouts.master')

@section('page', 'Produto - Consulta')

@section('title','Consultar - Produto')


@section('breadcrumb')
<!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item active">Produtos</li>
          </ul>
        </div>
      </div>
@stop



@section('content')


<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4>Produtos</h4>
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
                     <form method="get" action="{{ action('ProdutoController@pesquisarPorCriterio') }}" class="form-inline">
                         <div class="col-md-10">
                        <div class="form-group">
                            <label for="inlineFormInput" class="sr-only">Pesquisar por:</label>
                             <select class="form-control input-sm" name="criterio">
                            <option value="id" @if(! empty($criterio)) {{ $criterio == 'id' ? 'selected' : '' }} @endif>ID</option>
                            <option value="descricao" @if(! empty($criterio)) {{  $criterio == 'descricao' ? 'selected' : '' }}@endif>Descrição</option>
                            <option value="codigoInterno" @if(! empty($criterio)) {{  $criterio == 'codigoInterno' ? 'selected' : '' }}@endif>Código Interno</option>
                        </select>
                        <input class="form-control input-sm" placeholder=""  type="search" name="valor" @if(! empty($valor)) value=" {{ $valor }}" @endif>
                               <button class="btn btn-success fa fa-search" type="submit"></button>
                        </div>
                         </div>
                         <div class="col-md-2">
                            <div class="form-group pull-right">
                                <label><strong>Exibir:</strong> </label>
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
                                <th>Descrição</th>
                                <th>Código Interno</th>
                                <th>U.M</th>
                                <th>Qntd Estq.</th>
                                <th>Qntd Min.</th>
                                <th>Valor Unit.</th>
                                <th>Peso</th>
                                <th>Comp.</th>
                                <th>Larg.</th>
                                <th>Alt.</th>
                                <th>Status.</th>
                                <th colspan="2">Ação</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($produtos as $produto)
                            <tr>
                                <td>{{$produto->getId()}}</td>
                                <td>{{$produto->getDescricao()}}</td>
                                <td>{{$produto->getCodigoInterno()}}</td>
                                <td>{{$produto->getUnidadeMedida()->getSigla()}}</td>
                                <td>{{$produto->getQuantidadeEstoque()}}</td>
                                <td>{{$produto->getQuantidadeMinima()}}</td>
                                <td>{{$produto->getValorUnitario()}}</td>
                                <td>{{$produto->getPeso()}}</td>
                                <td>{{$produto->getComprimento()}}</td>
                                <td>{{$produto->getLargura()}}</td>
                                <td>{{$produto->getAltura()}}</td>

                                @if ($produto->getSituacao() == 'ATIVO')
                                <td><span class="badge bg-green">{{str_replace('_',' ',$produto->getSituacao())}}</span></td>
                                @elseif ($produto->getSituacao() == 'INATIVO')
                                <td><span class="badge bg-gray">{{str_replace('_',' ',$produto->getSituacao())}}</span></td>
                                @else
                                <td><span class="badge bg-yellow">{{str_replace('_',' ',$produto->getSituacao())}}</span></td>
                                @endif

                                <td  style="width: 10px;">
                                    <a href="{{ URL::to('/produto/edit/'.$produto->getId()) }}"
                                       class="btn btn-success"><i class="fa fa-edit fa-sm"></i>
                                    </a> 
                                </td>
                                <td  style="width: 10px;">
                                    <button type="button"class="btn btn-secondary" data-toggle="modal" data-target="#myModal{{$produto->getId()}}"><i class="fa fa-remove fa-sm"></i></button>
                                </td>
                            </tr>

                            <!-- Modal -->
                          <div class="modal fade" id="myModal{{$produto->getId()}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                         <h4 class="modal-title" id="myModalLabel">Atenção</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        Deseja realmente excluir?
                                    </div>
                                   
                                        <div class="modal-footer">
                                            <form action="{{ action('ProdutoController@delete') }}" method="post">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                            <input type="hidden" name="id" value="{{$produto->getId() }}"/>
                                            <button type="submit" class="btn btn-success">Confirmar</button>
                                               </form>
                                        </div>
                                 

                                </div>
                            </div>
                        </div>

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
                    {{ $produtos->appends(['criterio'=>$criterio,'valor'=>$valor,'limit'=>$limit])->links() }}
                    @else
                    {{ $produtos->links() }}
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>
@stop


@section('js')

@stop










