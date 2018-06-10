@extends('layouts.master')

@section('page', 'Recebimento de Material - Visualizar')


@section('breadcrumb')
<!-- Breadcrumb-->
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/retirada/show')}}">Recebimento de Material</a></li>
            <li class="breadcrumb-item active">Visualizar</li>
        </ul>
    </div>
</div>
@stop


@section('title','Recebimento de Material')


@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="box box-info">


                    <div class="card-header d-flex align-items-center">
                        <h4>Recebimento de Material Nº {{$recebimento->getId()}}</h4>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->

                    <div class="card-body">
                        <form class="form-horizontal">
                            <div class="box-body">


                                <div class="form-group row">
                                    <label for="responsavel" class="col-sm-1 control-label"><strong>Responsável:</strong></label>
                                    <div class="col-sm-3">
                                        <label for="responsavel" class="col-sm-6 control-label">{{$recebimento->getResponsavel()->getNome()}}</label>
                                    </div>
                                </div>




                                <div class="form-group row">
                                    <label for="descricao" class="col-sm-1 control-label"><strong>Data Retirada:</strong></label>
                                    <div class="col-sm-1">
                                        <label class="control-label">{{$recebimento->getData()->format('d/m/Y')}}</label>
                                    </div>
                                </div>




                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">Lista de Materiais do Recebimento</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body no-padding">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th style="width: 20px">ID</th>
                                                        <th style="width: 20px">Nº Req.</th>
                                                        <th>Descrição</th>
                                                        <th style="width: 50px">Quantidade</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($recebimento->getItens() as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{$item->getItemRequisicao()->getRequisicao()->getId()}}</td>
                                                        <td>{{$item->getItemRequisicao()->getMaterial()->getId()}}</td>
                                                        <td>{{$item->getItemRequisicao()->getMaterial()->getDescricao()}}</td>
                                                        <td>{{$item->getQuantidade()}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@stop



