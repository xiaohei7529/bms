<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Book\Book;


class BookController extends ApiController
{
    protected $model;

    public function __construct()
    {
        parent::__construct();

        if (empty($this->model)) $this->model = new Book();

    }

    // 图书列表
    public function getBookList(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $obj_list = $this->model->getBookList($input);
        return response()->json(get_success_api_response($obj_list));
    }

    public function getBookAuditList(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $obj_list = $this->model->getBookAuditList($input);
        return response()->json(get_success_api_response($obj_list));
    }

    public function bookAudit(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $this->model->bookAudit($input);
        return response()->json(get_success_api_response(200));
    }

    

}