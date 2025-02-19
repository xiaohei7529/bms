<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Book\UserBook;
use Illuminate\Support\Facades\Auth;


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
}