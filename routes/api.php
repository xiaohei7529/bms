<?php

// use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

$router->get('api/auth/userLogin','Admin\AdminController@userLogin');//登录
$router->post('api/auth/userLogin','Admin\AdminController@userLogin');//登录



$router->post('api/login','AuthController@login');//登录
$router->get('api/login','AuthController@login');//登录


$router->get('api/logout','AuthController@logout');//登录
$router->get('api/profile','AuthController@profile');//登录
$router->get('api/refresh','AuthController@refresh');//登录







/**
 * 图书管理
 */

 $router->get('api/book/bookList','Book\BookController@getBookList'); 
 $router->get('api/book/getBookAuditList','Book\BookController@getBookAuditList'); 
 $router->post('api/book/bookAudit','Book\BookController@bookAudit'); 
