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

// Route::get('/', function () {
//     return view('welcome');
// });

$router->get('/',function(){
    return view('welcome');
});

// Route::get('/api/test/test1', function () {
    
//     var_dump(1);
//     die();
// });

include_once(__DIR__.'/api.php');
include_once(__DIR__.'/test.php');