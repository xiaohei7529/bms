<?php

namespace App\Http\Models\Book;

use App\Http\Models\Base;
use Illuminate\Support\Facades\DB;


class Book extends Base
{

    public function getBookList($input)
    {

        $where = [];

        $builder = DB::table('book as a1')
            ->leftJoin('category as a2','a1.category_id','=','a2.id')
            ->select('a1.*','a2.name as category_name')
            ->where($where);

        $obj_list = $builder->get();

        return $obj_list;
    }

    public function getBookAuditList($input)
    {
        $where = [];

        $where[] = ['a1.audit_atatus','=',0];

        $builder = DB::table('borrow_record as a1')
            ->leftJoin('book as a2','a1.book_id','=','a2.id')
            ->leftJoin('category as a3','a2.category_id','=','a3.id')
            ->leftJoin('users as a4','a1.user_id','=','a4.id')
            ->select('a1.*','a2.title as book_name','a2.author as book_author','a3.name as category_name','a4.name as user_name')
            ->where($where);

        $obj_list = $builder->get();

        return $obj_list;
    }

    public function bookAudit($input)
    {
        
    }

}