<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Service\SqlParserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class FengController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function fengtest1(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        // TEPA(111);

        // pd(date('Y-m-d H:i:s'));
        return response()->json(get_success_api_response(200));
    }

    public function Login(Request $request)
    {
        
    }

    public function parse(Request $request)
    {
        $input = $request->all();
        trim_strings($input);
        // pd($input);

        $url = 'http://127.0.0.1:8088/api/er-diagram/parse';           
        $headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json");
        $result = $this->http($url,'POST',json_encode($input),$headerArray);
        

        return response()->json(get_success_api_response(json_decode($result,true)));


        $result = (new SqlParserService())->parseSql($input['sql']);
        pd($result);
        $a = '[
    {
        "tableName": "`book_favorite`",
        "columns": [
            {
                "name": "`id`",
                "type": "int",
                "nullable": false,
                "comment": "`id`"
            },
            {
                "name": "`user_id`",
                "type": "int",
                "nullable": false,
                "comment": "用户id"
            },
            {
                "name": "`book_id`",
                "type": "int",
                "nullable": false,
                "comment": "图书id"
            },
            {
                "name": "`ctime`",
                "type": "datetime",
                "nullable": true,
                "comment": "收藏时间"
            }
        ],
        "primaryKeys": [],
        "foreignKeys": [],
        "comment": "收藏记录表"
    }
]
';
        return response()->json(get_success_api_response(json_decode($a,true)));
    }
    
}
