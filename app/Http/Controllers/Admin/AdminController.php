<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class AdminController extends Controller
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
        if (empty($this->model)) $this->model = new Admin();
    }

    // 用户登录
    public function userLogin(Request $request)
    {

        $input = $request->all();
        trim_strings($input);

        //第一步 参数检测
        if (empty($input['email'])) TEA('700', 'email');
        if (empty($input['password'])) TEA('700', 'password');

        // if (password_verify($input['password'], $user->password)) {
        //     echo '密码正确';
        // } else {
        //     echo '密码错误';
        // }

        // 从请求中获取凭据
        $credentials = $request->only(['email', 'password']);

        // 调试记录凭据
        Log::info('Credentials:', is_array($credentials) ? $credentials : ['value' => $credentials]);

        // 尝试认证
        if (!$token = JWTAuth::attempt($credentials)) {
            Log::info('Authentication failed', ['credentials' => $credentials]);
            TEA('400','邮箱&密码错误');
        }
        
        $user = DB::table('users')->where('email', $input['email'])->first();
        $userInfo = [
            'id'=>$user->id,
            'username'=>$user->name,
            'last_login_time'=>time(),
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>3600,
        ];

        return response()->json(get_success_api_response($userInfo));
    }

    
    // 用户注册
    public function userRegistration(Request $request)
    {

        $input = $request->all();
        trim_strings($input);
        $this->model->userRegistration($input);
        return response()->json(get_success_api_response(200));
    }


}