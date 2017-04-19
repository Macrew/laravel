<?php


namespace App\Http\Controllers;
use App;
use Password;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Input;
use Redirect;
use Session;
use Validator;
use App\User;
use App\UserDetail;
use App\State;
use Auth;
use DB;
use Mail;
use Response;

use App\Property;
use App\Inclusion;
use App\PropertyGallery;
use App\AddManagement;
use App\PropertyInclusion;
use App\PropertyFloorImage;
use App\BuilderDetail;
use App\PageContent;

class contentController extends Controller{

	public function aboutus(){
		$data['title'] = 'About us';
		$about = PageContent::where(['slug'=>'about-us'])->get();
		$data['about'] = $about->toArray();
		return view('content.aboutus',$data);
	}
	
	public function ourstory(){
		$data['title'] = 'Our Story';
		$about = PageContent::where(['slug'=>'our-story'])->get();
		$data['about'] = $about->toArray();
		return view('content.aboutus',$data);
	}
	
	public function help(){
		$data['title'] = 'Help';
		$about = PageContent::where(['slug'=>'help'])->get();
		$data['about'] = $about->toArray();
		return view('content.help',$data);
	}
	
	public function contactus(){
		$data['title'] = 'Contact Us';
		$about = PageContent::where(['slug'=>'contact-us'])->get();
		$data['contact'] = $about->toArray();
		return view('content.contactus',$data);
	}
	
	public function whyicompare(){
		$data['title'] = 'Why Icompare builders';
		$about = PageContent::where(['slug'=>'why-icomparebuilders'])->get();
		$data['about'] = $about->toArray();
		return view('content.aboutus',$data);
	}
	
	public function termsconditions(){
		$data['title'] = 'Terms  & Conditions';
		$about = PageContent::where(['slug'=>'terms-and-conditions'])->get();
		$data['terms'] = $about->toArray();
		return view('content.termscondition',$data);
	}
	
	public function privacypolicy(){
		$data['title'] = 'Privacy Policy';
		$about = PageContent::where(['slug'=>'privacy-policy'])->get();
		$data['terms'] = $about->toArray();
		return view('content.privacy_policy',$data);
	}
	
	public function testimonials(){
		$data['title'] = 'Testimonials';
		$results = DB::table('testimonials')->get();
		$data['testimonials'] = $results;
		$q = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and add_size='300' and status='Publish'")->limit(2);
		$ads_obj  = $q->get();
		$ads_arr = $ads_obj->toArray();
		$data['ads_arr'] = $ads_arr;
		return view('content.testimonials',$data);
	}
	
	public function blog(){
		$data['title'] = 'Blog';
		$blog = DB::table('content')
		 ->join('blog_categories', 'content.id', '=', 'blog_categories.blog_id')
		 ->join('categories', 'blog_categories.category_id', '=', 'categories.id')
		 ->select('content.*','categories.slug as cat_slug','categories.category_title')
		 ->groupby('content.id')
		 ->orderby('content.id','DESC')->paginate(6);
		$results = DB::table('categories')->get();
		$data['blog'] = $blog;
		$data['categories'] = $results;
		return view('content.blog',$data);
	}
	
	public function blogbycategory($slug){
		$data['title'] = $slug;
		$blog = DB::table('content')
		 ->join('blog_categories', 'content.id', '=', 'blog_categories.blog_id')
		 ->join('categories', 'blog_categories.category_id', '=', 'categories.id')
		 ->where(array('categories.slug'=>$slug))
		 ->select('content.*','categories.slug as cat_slug','categories.category_title')
		 ->orderby('content.id','DESC')->paginate(6);
		$results = DB::table('categories')->get();
		$data['blog'] = $blog;
		$data['categories'] = $results;
		return view('content.blog',$data);
	}
	
	public function detailblog($catslug,$blogslug){
		$blog = DB::table('content')
		 ->join('blog_categories', 'content.id', '=', 'blog_categories.blog_id')
		 ->join('categories', 'blog_categories.category_id', '=', 'categories.id')
		 ->where(array('content.slug'=>$blogslug))
		 ->select('content.*','categories.slug as cat_slug','categories.category_title')
		 ->first();
		 $blog_id =  $blog->id;
		 $blog_cat = DB::table('blog_categories')
		 ->where(array('blog_id'=>$blog_id))
		 ->select('*')
		 ->get();
		$cat_ids = "";
		 foreach($blog_cat as $cat_val) {
			$cat_ids[] = $cat_val->category_id;
		 }

		  $related_ids = DB::table('blog_categories')
		 ->where('blog_id','!=',$blog_id)
		 ->whereIn('category_id',$cat_ids)
		 ->select('*')
		 ->limit('3')
		 ->get();
		$blog_ids="";
		 foreach($related_ids as $related_val) {
			$blog_ids[] = $related_val->blog_id;
		 }

			/*  echo '<pre>';
		 print_r($blog_ids); */
		 
		 $related_content =  DB::table('content')
		 //->join('blog_categories', 'content.id', '=', 'blog_categories.blog_id')
		 //->join('categories', 'blog_categories.category_id', '=', 'categories.id')
		 ->select('*')
		 ->whereIn('content.id',$blog_ids)
		 ->get();
		 
		 /* echo '<pre>';
		 print_r($related_content);  */
		 
		 
		$results = DB::table('categories')->get();
		$data['categories'] = $results;
		$data['blog'] = $blog;
		$data['title'] = $blog->title;
		$data['cat_slug'] = $catslug;
		$data['related_content'] = $related_content;
		return view('content.blog-detail',$data);

	}
	
	public function builder_enquiry()
	{
		$data['title'] = 'New House Plans & Designs - iComparebuilders';
		return view('content.builder-enquiry',$data);
	}
	
	
}
