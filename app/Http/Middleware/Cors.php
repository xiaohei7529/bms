<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type:application/json'); // 允许x-requested-with请求头
        header('Access-Control-Allow-Headers:x-requested-with'); // 允许x-requested-with请求头
        header('Access-Control-Allow-Headers:Authorization'); // 允许x-requested-with请求头
        header('Access-Control-Allow-Methods:GET, POST, PATCH, PUT, OPTIONS'); // 允许option，get，post请求
        header('Access-Control-Max-Age:86400'); // 允许访问的有效期
        $response = $next($request);
        return $response;
    }
}
