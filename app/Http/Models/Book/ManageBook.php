<?php

namespace App\Http\Models\Book;

use App\Http\Models\Base;
use Illuminate\Support\Facades\DB;


class ManageBook extends Base
{

    public function getBookList(&$input)
    {

        $where = [];

        if(isset($input['title']) && !empty($input['title'])) $where[] = ['a1.title','like','%'.$input['title'].'%'];

        $builder = DB::table('book as a1')
            ->leftJoin('book_category as a2','a1.category_id','=','a2.id')
            ->leftJoin('book_image as a3','a1.image_id','=','a3.id')
            ->select('a1.*','a2.name as category_name','a3.image_name','a3.image_path')
            ->where($where);

        $input['total_records'] = $builder->count();
        $builder->offset(($input['page_no'] - 1) * $input['page_size'])->limit($input['page_size']);

        $obj_list = $builder->get();

        $pageURL ='http://'.$_SERVER['HTTP_HOST'].'/storage/';

        foreach($obj_list as $item){
            $item->image_url = $item->image_id > 0 ? $pageURL.$item->image_path : '';
        }

        return $obj_list;
    }

    public function bookStore($input)
    {
        pd($input);
    }

    public function bookUpdate($input)
    {
        $update_date = [
            'title'=>$input['title'],
            'author'=>$input['author'],
            'category_id'=>$input['category_id'],
            'isbn'=>$input['isbn'],
            'stock'=>$input['stock'],
            'description'=>$input['description'],
            'image_id'=>$input['image_id'],
        ];
        DB::table('book')->where('id',$input['id'])->update($update_date);
    }

    public function bookDelete($input)
    {

    }

    /**********************************************************************************************************/
    public function getBookAuditList(&$input)
    {
        $where = [];

        $where[] = ['a1.audit_atatus','=',0];

        $builder = DB::table('book_borrow_record as a1')
            ->leftJoin('book as a2','a1.book_id','=','a2.id')
            ->leftJoin('book_category as a3','a2.category_id','=','a3.id')
            ->leftJoin('users as a4','a1.user_id','=','a4.id')
            ->select('a1.*','a2.title as book_name','a2.author as book_author','a3.name as category_name','a4.name as user_name')
            ->where($where);

        $input['total_records'] = $builder->count();
        $builder->offset(($input['page_no'] - 1) * $input['page_size'])->limit($input['page_size']);
        
        $obj_list = $builder->get();

        return $obj_list;
    }

    public function bookAudit($input)
    {
        
    }


    /**********************************************************************************************************/  
    
    public function getBookCategoryList($input)
    {
        $where = [];

        $builder = DB::table('book_category')
            ->where($where);

        $obj_list = $builder->get();

        return $obj_list;
    }


}