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

Route::get('/', function () {
    if(\App\User::count() == 0){
        return \Illuminate\Support\Facades\Redirect::to('register');
    } else {
        return view('welcome');
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('usuario', 'UsuarioController');
Route::resource('administrador', 'AdministradorController');
Route::resource('gestor', 'GestorController');
Route::resource('paciente', 'PacienteController');
Route::resource('motorista', 'MotoristaController');
Route::resource('carro', 'CarroController');
Route::resource('prestador', 'PrestadorController');
Route::resource('procedimento', 'ProcedimentoController');
Route::resource('vaga', 'VagaController');
Route::get('agendamento/{id}', 'AgendamentoController@index');
Route::get('agendamento/create/{id}', 'AgendamentoController@create');
Route::post('agendamento/{id}', 'AgendamentoController@store');
Route::delete('agendamento/{id}', 'AgendamentoController@destroy');
