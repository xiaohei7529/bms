<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\User;
use Illuminate\Support\Facades\Validator;



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
            'name'=>$user->name,
            'username'=>$user->name,
            'email'=>$user->email,
            'registerDate'=>$user->created_at,
            'last_login_time'=>time(),
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>3600,
            'is_superman'=>$user->is_superman,
        ];

        return response()->json(get_success_api_response($userInfo));
    }

    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    // 用户注册
    public function userRegistration(Request $request)
    {
        $input = $request->all();
     
        $this->validator($request->all())->validate();

        User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']), // 密码加密
        ]);

        return response()->json(get_success_api_response(200));
    }

    // 用户退出
    public function userLogout(Request $request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        Auth::logout();
        return response()->json(get_success_api_response(200));
    }

}