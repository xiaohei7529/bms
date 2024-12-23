<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class FengController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function fengtest1(Request $request)
    {
        $input = $request->all();
        trim_strings($input);

        return response()->json(get_success_api_response(200));
    }

    public function Login(Request $request)
    {
        
    }
    
}