<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class BlogCategory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	 public $timestamps = false;
    protected $table = 'blog_categories';

    //
	
	public static function get_related_blog_cats($blog_id)
	{
		 $blog_cat =  DB::table('blog_categories')
		 ->select('*')
		 ->where('blog_categories.blog_id',$blog_id)
		 ->get();
		 /* echo '<pre>';
		 print_r($blog_cat); */
		 if(!empty($blog_cat)) {
			foreach($blog_cat as $blog_val) {
				$cat_ids[] = $blog_val->category_id;
			}
			
		$cat_arr =  DB::table('categories')
		 ->select('*')
		 ->whereIn('categories.id',$cat_ids)
		 ->get();
		  /* echo '<pre>';
		 print_r($cat_arr); */
		 $html="";
		 foreach($cat_arr as $cat_val)
		 {
			$html[]= '<a href="'.url().'/blog/'.$cat_val->slug.'">'.$cat_val->category_title.'</a>';
		 }
		 $string = "";
		 if(!empty($html)) {
			$string = implode(',',$html);
			return $string;
		 } else {
			return $string;
		 }
		 
		 }
		 
		 
	}
	
	public static function get_related_blog_catid($blog_id)
	{
		 $blog_cat =  DB::table('blog_categories')
		 ->select('*')
		 ->where('blog_categories.blog_id',$blog_id)
		 ->first();
		 $cat_id = $blog_cat->category_id;
		  $cat_arr =  DB::table('categories')
		 ->select('*')
		 ->where('categories.id',$cat_id)
		 ->first();
		 return $cat_arr;
		 
		 
	}
	
}
