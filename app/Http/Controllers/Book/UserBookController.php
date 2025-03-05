<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Models\Book\UserBook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;


class UserBookController extends ApiController
{
    protected $model;

    public function __construct()
    {
        parent::__construct();

        if (empty($this->model)) $this->model = new UserBook();
    }

    public function getUser(Request $request)
    {
        return response()->json(get_success_api_response(Auth::user()));
    }

    // 借阅图书
    public function borrowBook(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $this->model->borrowBook($input);
        // $is_lock = Redis::setnx($input['book_id'].'_borrow',1); //设置锁
        // if(!$is_lock){
        //     TEPA('图书借阅失败，请稍后再试');
        // }
        // Redis::expire($input['book_id'].'_borrow', 180); //添加锁的过期时间
        // Redis::del($input['book_id'].'_borrow'); //删除锁
        return response()->json(get_success_api_response(200));
    }
    
    // 获取收藏图书列表
    public function getFavoriteBookList(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $res = $this->model->getFavoriteBookList($input);
        $paging = $this->getPagingResponse($input);
        return response()->json(get_success_api_response($res,$paging));
    }

    // 移除收藏图书
    public function removeFavorite(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $this->model->removeFavorite($input);
        return response()->json(get_success_api_response(200));
    }

/************************************************************************借阅图书**************************************************************************************************** */

    // 获取借阅图书列表
    public function getBorrowedBooksList(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $res = $this->model->getBorrowedBooksList($input);
        $paging = $this->getPagingResponse($input);
        return response()->json(get_success_api_response($res,$paging));
    }


/************************************************************************待归还图书**************************************************************************************************** */

    // 获取待归还图书列表
    public function getPendingReturnBooksList(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $res = $this->model->getPendingReturnBooksList($input);
        $paging = $this->getPagingResponse($input);
        return response()->json(get_success_api_response($res,$paging));
    }
    
    // 获取待归还图书列表
    public function returnBook(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $this->model->returnBook($input);
        return response()->json(get_success_api_response(200));
    }
}