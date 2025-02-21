<?php

namespace App\Http\Models;

class Base
{

    public function get_image_url($image_path)
    {
        if(empty($image_path)) return '';

        $pageURL ='http://'.$_SERVER['HTTP_HOST'].'/storage/';

        return $pageURL.$image_path;
    }
    
}