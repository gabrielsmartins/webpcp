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

Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');

Route::get('home', 'MainController@home');



Route::get('unidade/form', 'UnidadeMedidaController@form');
Route::post('unidade/store', 'UnidadeMedidaController@store');
Route::post('unidade/update', 'UnidadeMedidaController@update');
Route::get('unidade/show', 'UnidadeMedidaController@show');
Route::get('unidade/edit/{id}', 'UnidadeMedidaController@edit');
Route::post('unidade/pesquisa', 'UnidadeMedidaController@pesquisarPorCriterio');


Route::get('setor/form', 'SetorController@form');
Route::post('setor/store', 'SetorController@store');
Route::post('setor/update', 'SetorController@update');
Route::get('setor/show', 'SetorController@show');
Route::get('setor/edit/{id}', 'SetorController@edit');
Route::post('setor/pesquisa', 'SetorController@pesquisarPorCriterio');


Route::get('recurso/form', 'RecursoController@form');
Route::post('recurso/store', 'RecursoController@store');
Route::post('recurso/update', 'RecursoController@update');
Route::get('recurso/show', 'RecursoController@show');
Route::get('recurso/edit/{id}', 'RecursoController@edit');


Route::get('operacao/form', 'OperacaoController@form');
Route::post('operacao/store', 'OperacaoController@store');
Route::post('operacao/update', 'OperacaoController@update');
Route::get('operacao/show', 'OperacaoController@show');
Route::get('operacao/edit/{id}', 'OperacaoController@edit');


Route::get('material/form', 'MaterialController@form');
Route::post('material/store', 'MaterialController@store');
Route::post('material/update', 'MaterialController@update');
Route::get('material/show', 'MaterialController@show');
Route::get('material/edit/{id}', 'MaterialController@edit');
Route::post('material/pesquisa', 'MaterialController@pesquisarPorCriterio');


Route::get('produto/form', 'ProdutoController@form');
Route::post('produto/store', 'ProdutoController@store');
Route::post('produto/update', 'ProdutoController@update');
Route::get('produto/show', 'ProdutoController@show');
Route::get('produto/edit/{id}', 'ProdutoController@edit');
Route::post('produto/search_comp', 'ProdutoController@searchComponente');
Route::post('produto/search_oper', 'ProdutoController@searchOperacao');


