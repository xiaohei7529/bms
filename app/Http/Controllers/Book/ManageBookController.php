<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Book\ManageBook;


class ManageBookController extends ApiController
{
    protected $model;

    public function __construct()
    {
        parent::__construct();

        if (empty($this->model)) $this->model = new ManageBook();

    }

    // 图书列表
    public function getBookList(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $obj_list = $this->model->getBookList($input);
        
        $paging = $this->getPagingResponse($input);
        return response()->json(get_success_api_response($obj_list,$paging));
    }

    public function bookStore(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $this->model->bookStore($input);
        
        return response()->json(get_success_api_response(200));
    }

    // 图书审批列表
    public function getBookAuditList(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $obj_list = $this->model->getBookAuditList($input);
        $paging = $this->getPagingResponse($input);
        return response()->json(get_success_api_response($obj_list,$paging));
    }

    // 图书分类列表
    public function getBookCategoryList(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $obj_list = $this->model->getBookCategoryList($input);
        return response()->json(get_success_api_response($obj_list));
    }

    // 图书审核&拒绝
    public function bookAudit(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        $this->model->bookAudit($input);
        return response()->json(get_success_api_response(200));
    }

    

}