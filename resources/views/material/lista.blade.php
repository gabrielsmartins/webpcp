@extends('layouts.master')

@section('page', 'Material - Consulta')

@section('title','Consultar - Material')


@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Material</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <form method="get" action="{{ action('MaterialController@pesquisarPorCriterio') }}">
                    <div class="col-sm-6">
                        <label>Pesquisar por: </label>

                        <select class="form-control input-sm" name="criterio">
                            <option value="id" @if(! empty($criterio)) {{ $criterio == 'id' ? 'selected' : '' }} @endif>ID</option>
                            <option value="descricao" @if(! empty($criterio)) {{  $criterio == 'descricao' ? 'selected' : '' }}@endif>Descrição</option>
                            <option value="codigoInterno" @if(! empty($criterio)) {{  $criterio == 'codigoInterno' ? 'selected' : '' }}@endif>Código Interno</option>
                        </select>
                        <input class="form-control input-sm" placeholder=""  type="search" name="valor" @if(! empty($valor)) value=" {{ $valor }}" @endif>
                               <button class="btn btn-save fa fa-search" type="submit"></button>
                    </div>
                    <div class="col-sm-6">
                        <div class="pull-right">
                            <label>Exibir </label>
                            <select name="limit" aria-controls="example1" class="form-control input-sm" >
                                <option value="10" @if(! empty($limit)) {{ $limit == 10 ? 'selected' : '' }} @endif>10</option>
                                <option value="25" @if(! empty($limit))  {{ $limit == 25 ? 'selected' : '' }} @endif>25</option>
                                <option value="50" @if(! empty($limit))  {{ $limit == 50 ? 'selected' : '' }} @endif>50</option>
                                <option value="100" @if(! empty($limit))  {{ $limit == 100 ? 'selected' : '' }} @endif>100</option>
                            </select> 
                            <label>Registros</label>
                        </div>
                    </div>

                </form> 
            </div>

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
                <div class="col-sm-12">
                    <div class="table-responsive">
                    <table class="table table-bordered table-stripe">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc"  rowspan="1" colspan="1" >ID</th>
                                <th class="sorting"  rowspan="1" colspan="1" >Descrição</th>
                                <th class="sorting"  rowspan="1" colspan="1" >Código Interno</th>
                                <th class="sorting"  rowspan="1" colspan="1" >U.M</th>
                                <th class="sorting"  rowspan="1" colspan="1" >Qntd Estq.</th>
                                <th class="sorting"  rowspan="1" colspan="1" >Qntd Min.</th>
                                <th class="sorting"  rowspan="1" colspan="1" >Valor Unit.</th>
                                <th class="sorting"  rowspan="1" colspan="1" >Peso</th>
                                <th class="sorting"  rowspan="1" colspan="1" >Comp.</th>
                                <th class="sorting"  rowspan="1" colspan="1" >Larg.</th>
                                <th class="sorting"  rowspan="1" colspan="1" >Alt.</th>
                                <th class="sorting"  rowspan="1" colspan="1" >Status.</th>
                                <th class="sorting"  rowspan="1" colspan="2" style="width: 10px;">Ação</th>
                            </tr>
                        </thead>
                        <tbody>

                          @foreach($materiais as $material)
                            <tr>
                                <td>{{$material->getId()}}</td>
                                <td>{{$material->getDescricao()}}</td>
                                <td>{{$material->getCodigoInterno()}}</td>
                                <td>{{$material->getUnidadeMedida()->getSigla()}}</td>
                                <td>{{$material->getQuantidadeEstoque()}}</td>
                                <td>{{$material->getQuantidadeMinima()}}</td>
                                <td>{{$material->getValorUnitario()}}</td>
                                <td>{{$material->getPeso()}}</td>
                                <td>{{$material->getComprimento()}}</td>
                                <td>{{$material->getLargura()}}</td>
                                <td>{{$material->getAltura()}}</td>

                                @if ($material->getSituacao() == 'ATIVO')
                                <td><span class="badge bg-green">{{str_replace('_',' ',$material->getSituacao())}}</span></td>
                                @elseif ($material->getSituacao() == 'INATIVO')
                                <td><span class="badge bg-gray">{{str_replace('_',' ',$material->getSituacao())}}</span></td>
                                @else
                                <td><span class="badge bg-yellow">{{str_replace('_',' ',$material->getSituacao())}}</span></td>
                                @endif

                                <td  style="width: 10px;">
                                    <a href="{{ URL::to('/material/edit/'.$material->getId()) }}"
                                       class="btn btn-save"><i class="fa fa-edit fa-sm"></i>
                                    </a> 
                                </td>
                                <td  style="width: 10px;">
                                    <button type="button"class="btn btn-cancel" data-toggle="modal" data-target="#myModal{{$material->getId()}}"><i class="fa fa-remove fa-sm"></i></button>
                                </td>
                            </tr>

                            <!-- Modal -->
                        <div class="modal fade" id="myModal{{$material->getId()}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Atenção</h4>
                                    </div>
                                    <div class="modal-body">
                                        Deseja realmente excluir?
                                    </div>
                                   
                                        <div class="modal-footer">
                                            <form action="{{ action('MaterialController@delete') }}" method="post">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="button" class="btn btn-save" data-dismiss="modal">Fechar</button>
                                            <input type="hidden" name="id" value="{{$material->getId() }}"/>
                                            <button type="submit" class="btn btn-cancel">Confirmar</button>
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
                    {{ $materiais->appends(['criterio'=>$criterio,'valor'=>$valor,'limit'=>$limit])->links() }}
                    @else
                    {{ $materiais->links() }}
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
@stop


@section('js')

@stop
