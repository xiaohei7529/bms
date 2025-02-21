<?php

namespace App\Http\Models\Book;

use App\Http\Models\Base;
use Illuminate\Support\Facades\DB;

class Book extends Base 
{

    // 热门借阅
    public function hot($input)
    {
        $builder = DB::table('book_borrow_record')
            ->leftJoin('book', 'book.id', '=', 'book_borrow_record.book_id')
            ->leftJoin('book_image', 'book.image_id', '=', 'book_image.id')
            ->select('book.*', DB::raw('COUNT(book_borrow_record.id) as borrow_count'),'book_image.image_path')
            ->where('book.is_delete', 0);

        $obj_list = $builder->groupBy('book.id')->orderBy('borrow_count', 'desc')->limit(10)->get();

        foreach($obj_list as $item){
            $item->image_url = $this->get_image_url($item->image_path);
        }
        return $obj_list;
    }

    // 热门收藏
    public function collect($input)
    {
        $builder = DB::table('book_favorite')
            ->leftJoin('book', 'book.id', '=', 'book_favorite.book_id')
            ->leftJoin('book_image', 'book.image_id', '=', 'book_image.id')
            ->select('book.*', DB::raw('COUNT(book_favorite.id) as favorite_count'),'book_image.image_path')
            ->where('book.is_delete', 0);

        $obj_list = $builder->groupBy('book.id')->orderBy('favorite_count', 'desc')->limit(10)->get();

        foreach($obj_list as $item){
            $item->image_url = $this->get_image_url($item->image_path);
        }

        return $obj_list;
    }

    // 高分图书
    public function score($input)
    {
        $res = DB::table('book')->where('status',1)->orderBy('score','desc')->limit(10)->get();
        return $res;
    }

    // 新书上架
    public function new($input)
    {
        $builder = DB::table('book')
            ->leftJoin('book_image', 'book.image_id', '=', 'book_image.id')
            ->select('book.*', 'book_image.image_path')
            ->where('status', 1);

        $obj_list = $builder->orderBy('create_time', 'desc')->limit(10)->get();
        
        foreach($obj_list as $item){
            $item->image_url = $this->get_image_url($item->image_path);
        }
        return $obj_list;
    }

}