<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Book\Upload;
use Illuminate\Support\Facades\Storage;


class UploadController extends ApiController
{
    protected $model;

    protected $allowed_extensions = ["png", "jpg", "jpeg", "gif"];

    protected $prohibited_extensions = ['php', 'sh'];

    public function __construct()
    {
        parent::__construct();

        if (empty($this->model)) $this->model = new Upload();

    }

    public function uploadFile(Request $request)
    {
        $input = $request->all();
        trim_strings($request);
        $data = [];
        $data['extension'] = $input['file']->getClientOriginalExtension();//文件后缀
        //判断文件是否带有 被禁止的后缀
        if (!$data['extension'] || in_array(strtolower($data['extension']), $this->prohibited_extensions)) TEA('1101');//不被允许的文件
        // 设置自定义文件名称
        $extension = bin2hex(random_bytes(16)).'.'.$data['extension'];
        $data['image_path'] = Storage::disk('public')->putFileAs('/drawing' . DIRECTORY_SEPARATOR . date('Y-m-d'), $input['file'],$extension);
        if (empty($data['image_path'])) TEA('7028');//上传失败
        return response()->json(get_success_api_response(['image_path' => $data['image_path']]));
    }


}