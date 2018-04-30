<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'MainController@index');


Route::get('usuario/form', 'UsuarioController@form');
Route::post('usuario/store', 'UsuarioController@store');
Route::post('usuario/update', 'UsuarioController@update');
Route::get('usuario/show', 'UsuarioController@show');
Route::get('usuario/edit/{id}', 'UsuarioController@edit');
Route::post('usuario/disable', 'UsuarioController@disable');
Route::post('usuario/enable', 'UsuarioController@enable');
Route::get('usuario/pesquisa', 'UsuarioController@pesquisarPorCriterio');
Route::post('login', 'UsuarioController@login');
Route::get('logout', 'UsuarioController@logout');

Route::get('home', 'MainController@home');



Route::get('unidade/form', 'UnidadeMedidaController@form');
Route::post('unidade/store', 'UnidadeMedidaController@store');
Route::post('unidade/update', 'UnidadeMedidaController@update');
Route::get('unidade/show', 'UnidadeMedidaController@show');
Route::get('unidade/edit/{id}', 'UnidadeMedidaController@edit');
Route::post('unidade/delete', 'UnidadeMedidaController@delete');
Route::get('unidade/pesquisa', 'UnidadeMedidaController@pesquisarPorCriterio');


Route::get('setor/form', 'SetorController@form');
Route::post('setor/store', 'SetorController@store');
Route::post('setor/update', 'SetorController@update');
Route::get('setor/show', 'SetorController@show');
Route::get('setor/edit/{id}', 'SetorController@edit');
Route::post('setor/delete', 'SetorController@delete');
Route::get('setor/pesquisa', 'SetorController@pesquisarPorCriterio');


Route::get('recurso/form', 'RecursoController@form');
Route::post('recurso/store', 'RecursoController@store');
Route::post('recurso/update', 'RecursoController@update');
Route::get('recurso/show', 'RecursoController@show');
Route::get('recurso/edit/{id}', 'RecursoController@edit');
Route::post('recurso/delete', 'RecursoController@delete');
Route::get('recurso/pesquisa', 'RecursoController@pesquisarPorCriterio');


Route::get('operacao/form', 'OperacaoController@form');
Route::post('operacao/store', 'OperacaoController@store');
Route::post('operacao/update', 'OperacaoController@update');
Route::get('operacao/show', 'OperacaoController@show');
Route::get('operacao/edit/{id}', 'OperacaoController@edit');
Route::post('operacao/delete', 'OperacaoController@delete');
Route::get('operacao/pesquisa', 'OperacaoController@pesquisarPorCriterio');



Route::get('material/form', 'MaterialController@form');
Route::post('material/store', 'MaterialController@store');
Route::post('material/update', 'MaterialController@update');
Route::get('material/show', 'MaterialController@show');
Route::get('material/edit/{id}', 'MaterialController@edit');
Route::post('material/delete', 'MaterialController@delete');
Route::get('material/pesquisa', 'MaterialController@pesquisarPorCriterio');


Route::get('produto/form', 'ProdutoController@form');
Route::post('produto/store', 'ProdutoController@store');
Route::post('produto/update', 'ProdutoController@update');
Route::get('produto/show', 'ProdutoController@show');
Route::get('produto/edit/{id}', 'ProdutoController@edit');
Route::post('produto/delete', 'ProdutoController@delete');
Route::get('produto/pesquisa', 'ProdutoController@pesquisarPorCriterio');
Route::post('produto/search_comp', 'ProdutoController@searchComponente');
Route::post('produto/search_oper', 'ProdutoController@searchOperacao');


Route::get('requisicao/form', 'RequisicaoMaterialController@form');
Route::post('requisicao/store', 'RequisicaoMaterialController@store');
Route::post('requisicao/cancel', 'RequisicaoMaterialController@cancel');
Route::get('requisicao/show', 'RequisicaoMaterialController@show');
Route::get('requisicao/edit/{id}', 'RequisicaoMaterialController@edit');
Route::post('requisicao/search_material', 'RequisicaoMaterialController@searchMaterial');
Route::get('requisicao/pesquisa', 'RequisicaoMaterialController@pesquisarPorCriterio');



Route::get('retirada/form', 'RetiradaProdutoController@form');
Route::post('retirada/store', 'RetiradaProdutoController@store');
Route::post('retirada/cancel', 'RetiradaProdutoController@cancel');
Route::get('retirada/show', 'RetiradaProdutoController@show');
Route::get('retirada/edit/{id}', 'RetiradaProdutoController@edit');
Route::post('retirada/search_produto', 'RetiradaProdutoController@searchProduto');
Route::get('retirada/pesquisa', 'RetiradaProdutoController@pesquisarPorCriterio');


Route::get('recebimento/form', 'RecebimentoMaterialController@form');
Route::post('recebimento/store', 'RecebimentoMaterialController@store');
Route::post('recebimento/cancel', 'RecebimentoMaterialController@cancel');
Route::get('recebimento/show', 'RecebimentoMaterialController@show');
Route::get('recebimento/edit/{id}', 'RecebimentoMaterialController@edit');
Route::post('recebimento/search_produto', 'RecebimentoMaterialController@searchMaterial');
Route::get('recebimento/pesquisa', 'RecebimentoMaterialController@pesquisarPorCriterio');


Route::get('ordem/form', 'OrdemProducaoController@form');
Route::post('ordem/store', 'OrdemProducaoController@store');
Route::post('ordem/cancel', 'OrdemProducaoController@cancel');
Route::get('ordem/show', 'OrdemProducaoController@show');
Route::get('ordem/edit/{id}', 'OrdemProducaoController@edit');

