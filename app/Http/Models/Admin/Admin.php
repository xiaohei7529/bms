<?php

namespace App\Http\Models\Admin;

use App\Http\Models\Base;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class Admin extends Base
{

    public function userLogin($input)
    {
        //第一步 参数检测
        if(empty($input['name'])) TEA('700','name');
        if(empty($input['password'])) TEA('700','password');

        
        $user = DB::table('users')->where('name',$input['name'])->first();

        if(md5($input['password']) != $user->password) TEA(400,'密码错误');

        $user->token = JWTAuth::fromUser($user);
    

        return $user;
    }


    
    public function userRegistration(){}
}