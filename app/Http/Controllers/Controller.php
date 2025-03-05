<?php

namespace App\Http\Controllers;

// use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
// use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 构造方法,由于父类未定义构造方法,所以不需要执行parent::__construct()
     */
    public function __construct()
    {
        $this->middleware(['cors']);
        // $this->middleware(['api_jwt_auth']);
    }

    /**
     * 统一获取分页时候的响应信息
     * @param $input
     * @return array
     * @author  sam.shan   <sam.shan@ruis-ims.cn>
     */
    public function getPagingResponse($input)
    {
        return [
            'page_size' => $input['page_size'],
            'page_index' => $input['page_no'],
            'total_records' => isset($input['total_records']) ? $input['total_records'] : 0,
        ];
    }

}
