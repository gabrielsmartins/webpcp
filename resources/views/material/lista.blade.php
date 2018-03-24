@extends('layouts.master')

@section('page', 'Material - Consulta')

@section('title','Consultar - Material')


@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Data Table With Full Features</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6">
                        <label>Pesquisar por: </label>
                        <form method="post" action="{{ action('MaterialController@pesquisarPorCriterio') }}">
                          <select class="form-control input-sm" name="criterio">
                            <option value="id">ID</option>
                            <option value="descricao">Descrição</option>
                            <option value="codigoInterno">Código Interno</option>
                        </select>
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                             <input class="form-control input-sm" placeholder=""  type="search" name="valor">
                             <button class="btn btn-save fa fa-search" type="submit"></button>
                        </form>   
                </div>
                <div class="col-sm-6">
                    <div class="pull-right">
                        <label>Exibir </label>
                        <select name="example1_length" aria-controls="example1" class="form-control input-sm">
                                <option value="10">10</option><option value="25">25</option>
                                <option value="50">50</option><option value="100">100</option>
                        </select> 
                        <label>Registros</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="data-table-simple" rowspan="1" colspan="1" style="width: 50px;" aria-sort="ascending" aria-label="Name: activate to sort column descending">ID</th>
                                <th class="sorting_asc" tabindex="0" aria-controls="data-table-simple" rowspan="1" colspan="1" style="width: 350px;" aria-sort="ascending" aria-label="Name: activate to sort column descending">Descrição</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table-simple" rowspan="1" colspan="1" style="width: 150px;" aria-label="Position: activate to sort column ascending">Codigo Interno</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table-simple" rowspan="1" colspan="1" style="width: 150px;" aria-label="Office: activate to sort column ascending">U.M</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table-simple" rowspan="1" colspan="1" style="width: 150px;" aria-label="Office: activate to sort column ascending">Qntd Estoque</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table-simple" rowspan="1" colspan="1" style="width: 150px;" aria-label="Office: activate to sort column ascending">Qntd Mínima</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table-simple" rowspan="1" colspan="1" style="width: 150px;" aria-label="Office: activate to sort column ascending">Valor Unit (R$)</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table-simple" rowspan="1" colspan="1" style="width: 150px;" aria-label="Office: activate to sort column ascending">Peso (KG)</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table-simple" rowspan="1" colspan="1" style="width: 150px;" aria-label="Office: activate to sort column ascending">Comp (mm)</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table-simple" rowspan="1" colspan="1" style="width: 150px;" aria-label="Office: activate to sort column ascending">Larg (mm)</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table-simple" rowspan="1" colspan="1" style="width: 150px;" aria-label="Office: activate to sort column ascending">Alt (mm)</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table-simple" rowspan="1" colspan="1" style="width: 150px;" aria-label="Office: activate to sort column ascending">Status</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table-simple" rowspan="1" colspan="1" style="width: 150px;" aria-label="Office: activate to sort column ascending">Editar</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table-simple" rowspan="1" colspan="1" style="width: 150px;" aria-label="Office: activate to sort column ascending">Excluir</th>
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
                                <td><span class="badge bg-green">{{$material->getSituacao()}}</span></td>
                                @elseif ($material->getSituacao() == 'INATIVO')
                                <td><span class="badge bg-gray">{{$material->getSituacao()}}</span></td>
                                @else
                                <td><span class="badge bg-yellow">{{$material->getSituacao()}}</span></td>
                                @endif



                                <td>
                                    <a href="{{ URL::to('/material/edit/'.$material->getId()) }}"
                                       class="btn btn-save"><i class="fa fa-edit"></i>
                                    </a> 
                                </td>
                                <td>

                                    <form action="<c:url value='/materiais/${material.id}'/>" method="post">
                                        <button type="submit"class="btn btn-cancel"><i class="fa fa-remove"></i></button>
                                    </form>

                                </td>
                            </tr>

                            @endforeach


   

                        </tbody>
                        <tfoot>
                            <tr>
                                <th rowspan="1" colspan="1"><strong>ID</strong></th>
                                <th rowspan="1" colspan="1"><strong>Descrição</strong></th>
                                <th rowspan="1" colspan="1"><strong>Codigo Interno</strong></th>
                                <th rowspan="1" colspan="1"><strong>Unidade</strong></th>
                                <th rowspan="1" colspan="1"><strong>Qntd Estoque</strong></th>
                                <th rowspan="1" colspan="1"><strong>Qntd Mínima</strong></th>
                                <th rowspan="1" colspan="1"><strong>Valor Unit (R$)</strong></th>
                                <th rowspan="1" colspan="1"><strong>Peso (KG)</strong></th>
                                <th rowspan="1" colspan="1"><strong>Comp (mm)</strong></th>
                                <th rowspan="1" colspan="1"><strong>Larg (mm)</strong></th>
                                <th rowspan="1" colspan="1"><strong>Alt (mm)</strong></th>
                                <th rowspan="1" colspan="1"><strong>Status</strong></th>
                                <th rowspan="1" colspan="1"><strong>Editar</strong></th>
                                <th rowspan="1" colspan="1"><strong>Editar</strong></th>
                            </tr>
                        </tfoot>
                    </table></div></div><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example1_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div></div>
    </div>
    <!-- /.box-body -->
</div>
@stop


