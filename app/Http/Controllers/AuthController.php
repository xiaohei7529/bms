<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use DateTimeImmutable;



class AuthController extends Controller
{
    // 用户登录并生成 JWT
    public function login(Request $request)
    {
        // return response()->json(get_success_api_response(200));
        // 从请求中获取凭据
        $credentials = $request->only(['email', 'password']);

        // 调试记录凭据
        Log::info('Credentials:', is_array($credentials) ? $credentials : ['value' => $credentials]);

        // 尝试认证
        if (!$token = JWTAuth::attempt($credentials)) {
            Log::info('Authentication failed', ['credentials' => $credentials]);
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        Log::info('Authentication succeeded', ['token' => $token]);

        // 成功认证后返回 Token
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
        
        $this->respondWithToken($token);
    }

    // 用户退出
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    // 刷新 Token
    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    // 获取用户信息
    public function profile()
    {
        
        // return response()->json(Auth::user());
        return response()->json(get_success_api_response(Auth::user()));
    }

    // 辅助方法：返回 Token 数据
    protected function respondWithToken($token)
    {
       
    }
}
