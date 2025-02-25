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
$router->post('api/auth/userRegister','Admin\AdminController@userRegistration');//注册



$router->post('api/login','AuthController@login');//登录
$router->get('api/login','AuthController@login');//登录


$router->get('api/logout','AuthController@logout'); // 登录
$router->get('api/profile','AuthController@profile'); // 退出
$router->get('api/refresh','AuthController@refresh'); // 刷新 Token


/**
 * 上传
 */
 $router->post('api/uploadFile','Book\UploadController@uploadFile'); 


/**
 * 后台图书管理
 */

 // 图书数据
 $router->get('api/manageBook/bookList','Book\ManageBookController@getBookList');
 $router->post('api/manageBook/bookStore','Book\ManageBookController@bookStore');
 $router->post('api/manageBook/bookUpdate','Book\ManageBookController@bookUpdate');
 $router->post('api/manageBook/bookDelete','Book\ManageBookController@bookDelete');


 // 分类数据
 $router->get('api/manageBook/getBookCategoryList','Book\ManageBookController@getBookCategoryList');
 

 // 待审核数据
 $router->get('api/manageBook/getBookAuditList','Book\ManageBookController@getBookAuditList');
 $router->post('api/manageBook/bookAudit','Book\ManageBookController@bookAudit');

 /**
  * 前台主页数据
  */
  // 热门借阅
  $router->get('api/book/hot','Book\BookController@hot');
  // 热门收藏
  $router->get('api/book/collect','Book\BookController@collect');
  // 高分图书
  $router->get('api/book/score','Book\BookController@score');
  // 新书上架
  $router->get('api/book/new','Book\BookController@new');


  /**
   * 用户图书
   */
  $router->get('api/userBook/getUser','Book\UserBookController@getUser');

  // 收藏图书
  $router->get('api/userBook/getFavoriteBookList','Book\UserBookController@getFavoriteBookList');
  // 移除收藏图书
  $router->post('api/userBook/removeFavorite','Book\UserBookController@removeFavorite');


  // 借阅图书
  $router->get('api/userBook/getBorrowedBooksList','Book\UserBookController@getBorrowedBooksList');



  // 待归还图书
  $router->get('api/userBook/getPendingReturnBooksList','Book\UserBookController@getPendingReturnBooksList');
  // 归还图书
  $router->post('api/userBook/returnBook','Book\UserBookController@returnBook');