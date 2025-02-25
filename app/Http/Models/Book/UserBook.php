<?php

namespace App\Http\Models\Book;

use App\Http\Models\Base;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class UserBook extends Base
{

    public function getUser()
    {
        
        $user = Auth::user();
        pd($user->name);

    }

    // 获取收藏图书列表
    public function getFavoriteBookList(&$input)
    {
        $user_id = Auth::user()->id;
        $builder = DB::table('book_favorite as a1')
            ->leftJoin('book as a2','a1.book_id','=','a2.id')
            ->leftJoin('book_image as a3','a2.image_id','=','a3.id')
            ->leftJoin('book_category as a4','a2.category_id','=','a4.id')
            ->select('a1.book_id','a1.ctime as favorite_time','a2.title','a2.author','a4.name as category_name','a3.image_name','a3.image_path')
            ->where('a1.user_id',$user_id);
        
        $input['total_records'] = $builder->count();
        $builder->offset(($input['page_no'] - 1) * $input['page_size'])->limit($input['page_size']);
        $obj_list = $builder->get();

        foreach ($obj_list as $item) {
            $item->image_url = $this->get_image_url($item->image_path);
        }

        return $obj_list;
    }

    // 移除收藏图书
    public function removeFavorite($input)
    {
        $user_id = Auth::user()->id;
        // DB::table('book_favorite')->where('user_id',$user_id)->where('book_id',$input['book_id'])->delete();
    }

    /************************************************************************借阅图书**************************************************************************************************** */

    // 获取借阅图书列表
    public function getBorrowedBooksList(&$input)
    {
        $user_id = Auth::user()->id;
        $builder = DB::table('book_borrow_record as a1')
            ->leftJoin('book as a2','a1.book_id','=','a2.id')
            ->leftJoin('book_image as a3','a2.image_id','=','a3.id')
            ->leftJoin('book_category as a4','a2.category_id','=','a4.id')
            ->select('a1.book_id','a1.borrow_date','a1.return_date','a1.borrow_status','a2.title','a2.author','a4.name as category_name','a3.image_name','a3.image_path')
            ->where([
                ['a1.user_id',$user_id],
                // ['a1.borrow_status',1],
            ]);
        
        $input['total_records'] = $builder->count();
        $builder->offset(($input['page_no'] - 1) * $input['page_size'])->limit($input['page_size']);
        $obj_list = $builder->get();

        foreach ($obj_list as $item) {
            $item->image_url = $this->get_image_url($item->image_path);
        }

        return $obj_list;

    }

    /************************************************************************待归还图书**************************************************************************************************** */

    // 获取待归还图书列表
    public function getPendingReturnBooksList($input)
    {
        $user_id = Auth::user()->id;
        $builder = DB::table('book_borrow_record as a1')
            ->leftJoin('book as a2','a1.book_id','=','a2.id')
            ->leftJoin('book_image as a3','a2.image_id','=','a3.id')
            ->leftJoin('book_category as a4','a2.category_id','=','a4.id')
            ->select('a1.book_id','a1.borrow_date','a1.return_date','a1.borrow_status','a2.title','a2.author','a4.name as category_name','a3.image_name','a3.image_path')
            ->where([
                ['a1.user_id',$user_id],
                ['a1.borrow_status',0],
            ]);
        
        $input['total_records'] = $builder->count();
        $builder->offset(($input['page_no'] - 1) * $input['page_size'])->limit($input['page_size']);
        $obj_list = $builder->get();

        foreach ($obj_list as $item) {
            $item->image_url = $this->get_image_url($item->image_path);
        }

        return $obj_list;

    }


    // 归还图书
    public function returnBook($input)
    {
        $user_id = Auth::user()->id;
        // DB::table('book_borrow_record')->where('user_id',$user_id)->where('book_id',$input['book_id'])->update(['borrow_status'=>1]);
    }


}