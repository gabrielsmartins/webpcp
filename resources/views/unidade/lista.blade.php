@extends('layouts.master')

@section('page', 'Unidade de Medida - Consulta')

@section('title','Consultar - Unidade de Medida')


@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Unidade de Medida</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                 <form method="get" action="{{ action('UnidadeMedidaController@pesquisarPorCriterio') }}">
                <div class="col-sm-6">
                        <label>Pesquisar por: </label>
                       
                          <select class="form-control input-sm" name="criterio">
                            <option value="id" @if(! empty($criterio)) {{ $criterio == 'id' ? 'selected' : '' }} @endif>ID</option>
                            <option value="descricao" @if(! empty($criterio)) {{  $criterio == 'descricao' ? 'selected' : '' }}@endif>Descrição</option>
                            <option value="sigla" @if(! empty($criterio)) {{  $criterio == 'sigla' ? 'selected' : '' }} @endif>Sigla</option>
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
            
            
            
         
            
            
            
            <div class="row">
                <div class="col-sm-12">
                    <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 297.45px;" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">ID</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 362.1px;" aria-label="Browser: activate to sort column ascending">Descrição</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 322.167px;" aria-label="Platform(s): activate to sort column ascending">Sigla</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 257.083px;">Editar</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 257.083px;">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($unidades as $unidade)
                            <tr>
                                <td>{{$unidade->getId() }}</td>
                                <td>{{$unidade->getDescricao() }}</td>
                                <td>{{$unidade->getSigla()}}</td>
                                <td>
                                    <a href="{{ URL::to('/unidade/edit/'.$unidade->getId()) }}"
                                       class="btn btn-save"><i class="fa fa-edit"></i>
                                    </a> 
                                </td>
                                <td>
                                    <form action="<c:url value='/unidades/${unidade.id}'/>" method="post">
                                        <button type="submit"class="btn btn-cancel"><i class="fa fa-remove"></i></button>
                                    </form>
                                </td>
                            </tr>

                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th rowspan="1" colspan="1">ID</th>
                                <th rowspan="1" colspan="1">Descrição</th>
                                <th rowspan="1" colspan="1">Sigla</th>
                                <th rowspan="1" colspan="1">Editar</th>
                                <th rowspan="1" colspan="1">Excluir</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                      
                </div>
                <div class="col-sm-7">
                    @if(! empty($criterio))
                     {{ $unidades->appends(['criterio'=>$criterio,'valor'=>$valor,'limit'=>$limit])->links() }}
                    @else
                    {{ $unidades->links() }}
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
@stop


