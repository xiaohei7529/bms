<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Book\Book;


class BookController extends Controller
{
    protected $model;

    public function __construct()
    {
        parent::__construct();

        if (empty($this->model)) $this->model = new Book();
    }

    // 热门借阅
    public function hot(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $obj_list = $this->model->hot($input);
        return response()->json(get_success_api_response($obj_list));
    }

    // 热门收藏
    public function collect(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $obj_list = $this->model->collect($input);
        return response()->json(get_success_api_response($obj_list));
    }

    // 高分图书
    public function score(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $obj_list = $this->model->score($input);
        return response()->json(get_success_api_response($obj_list));
    }
    // 新书上架
    public function new(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $obj_list = $this->model->new($input);
        return response()->json(get_success_api_response($obj_list));
    }
    
    // 获取图书详情
    public function fetchBookDetails(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $res = $this->model->fetchBookDetails($input);
        return response()->json(get_success_api_response($res));
    }
}