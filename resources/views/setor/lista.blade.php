@extends('layouts.master')

@section('page', 'Setor - Consulta')

@section('title','Consultar - Setor')


@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Setor</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6">
                        <label>Pesquisar por: </label>
                        <form method="post" action="{{ action('SetorController@pesquisarPorCriterio') }}">
                          <select class="form-control input-sm" name="criterio">
                            <option value="id">ID</option>
                            <option value="descricao">Descrição</option>
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
                                <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 297.45px;" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">ID</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 362.1px;" aria-label="Browser: activate to sort column ascending">Descrição</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 257.083px;">Editar</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 257.083px;">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($setores as $setor)
                            <tr>
                                <td>{{$setor->getId() }}</td>
                                <td>{{$setor->getDescricao() }}</td>
                                <td>
                                    <a href="{{ URL::to('/setor/edit/'.$setor->getId()) }}"
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
                                <th rowspan="1" colspan="1">Editar</th>
                                <th rowspan="1" colspan="1">Excluir</th>
                            </tr>
                        </tfoot>
                    </table></div></div><div class="row"><div class="col-sm-5"><div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers" id="example1_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="example1_previous"><a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li><li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li><li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a></li></ul></div></div></div></div>
    </div>
    <!-- /.box-body -->
</div>
@stop


