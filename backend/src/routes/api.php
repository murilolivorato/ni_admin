<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => ['auth:user_admin']] , function() {
    // INFORMAÇÃO
    Route::post('/admin/info' ,                                        [ 'uses'        => 'App\Http\Controllers\AdminAuthController@info' ]);

    // FUNCIONÁRIOS
    Route::post('admin/funcionario/store'                 , ['uses' => 'App\Http\Controllers\Admin\FuncionarioController@store']);
    Route::post('admin/funcionario/update/{id}'           , ['uses' => 'App\Http\Controllers\Admin\FuncionarioController@update']);
    Route::get('admin/funcionario/load-display'           , ['uses' => 'App\Http\Controllers\Admin\FuncionarioController@load_display']);
    Route::post('admin/funcionario/destroy'               , ['uses' => 'App\Http\Controllers\Admin\FuncionarioController@destroy']);
    Route::post('admin/funcionario/load-form/{id}'        , ['uses' => 'App\Http\Controllers\Admin\FuncionarioController@loadForm']);
    // MOVIMENTAÇÃO
    Route::post('admin/movimentacao/store'                 , ['uses' => 'App\Http\Controllers\Admin\MovimentacaoController@store']);

});

Route::post('/admin/post-login',  [ 'uses'        => 'App\Http\Controllers\AdminAuthController@postLogin']);
