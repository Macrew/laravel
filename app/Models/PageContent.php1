<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class PageContent extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	 public $timestamps = false;
    protected $table = 'content';

    //
    
    public static function categoryandslug($blogid){
		$cat = DB::table('blog_categories')
				->join('categories', 'categories.id', '=', 'blog_categories.category_id')
				->where(array('blog_categories.blog_id'=>$blogid))
				->get();
		return $cat;
	}
}
