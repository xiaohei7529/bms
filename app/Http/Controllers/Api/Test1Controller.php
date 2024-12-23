<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Test1Controller extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function Login(Request $request)
    {
        
        var_dump(1);
        die();
        $input=$request->all();

        pd($input);
    }

    public function Test1(Request $request)
    {
        
        var_dump(1);
        die();
        $input = $request->all();
        
        var_dump(1);
        die();
        pd($input);
    }


}