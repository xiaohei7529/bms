<?php

namespace App\Http\Controllers;//定义命名空间

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
   /**
     * 控制器连接M层的实例
     * @var
     */
   protected $model;

    /**
     * 构造方法,由于父类未定义构造方法,所以不需要执行parent::__construct()
     */
   public function __construct()
   {
      $this->middleware(['cors']);
      $this->middleware(['api_jwt_auth']);
   }
    
}