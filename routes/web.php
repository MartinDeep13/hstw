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
    return view('base');
});

Route::get('/login', function ()
{
   return view('login');
});

Route::get('/baseadmin', function ()
{
   return view('baseAdministrador');
});

Route::get('/prueba', function ()
{
   return view('prueba');
});


// Esta no hacerle caso es la vista que habia creado
Route::get('/basedani', function ()
{
   return view('baseAdministradorcopia');
});