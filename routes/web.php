<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::view('/users', 'users.showAll')->name('users.all');

Route::view('/game', 'game.show')->name('game.show');

Route::get('/start_game',  function () {
    $exitCode = Artisan::call('game:execute');
    return 'ejecutando';
});

Route::get('/chat', 'ChatController@show')->name('chat.show');
Route::post('/chat/message', 'ChatController@store')->name('chat.store');
Route::post('/chat/saludo/{user}', 'ChatController@saludo')->name('chat.saludo');