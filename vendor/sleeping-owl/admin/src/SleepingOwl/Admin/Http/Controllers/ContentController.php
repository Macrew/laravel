<?php namespace SleepingOwl\Admin\Http\Controllers;

use AdminTemplate;
use App;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Input;
use Redirect;
use Request;
use Session;
use Validator;
use SleepingOwl\Admin\Interfaces\FormInterface;
use SleepingOwl\Admin\Repository\BaseRepository;
use App\PageContent;
use App\AddManagement;
use App\Category;
use App\BlogCategory;
use DB;


class ContentController extends Controller
{

	public function get_pages()
	{
		$where_arr = array('content_type'=>'Page');
		
		$results = PageContent::where($where_arr)->get();
		//$results = User::where($where_arr)->builders;

		$data['pages_arr'] = $results->toArray();
		$data['title'] = "Pages";
		return view(AdminTemplate::view('pages.pagescontent'), $data);
	}
	
	public function create_ads(){
		$data['title'] = 'Create Ad';
		//$data['property'] = Property::getproprtybyuser($user_id);
		return view(AdminTemplate::view('pages.edit_ads'), $data);
	}
	
	public function save_ads(){
		$input = Input::all();
		//dd($input);
		$rules = array(
			'headline'    => 'required',
			/* 'add_text' => 'required', */
			'add_size' => 'required',
			'start_date' => 'required',
			'end_date' => 'required'
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/ads/create')
				->withErrors($validator) // send back all errors to the login form
				->withInput(); // send back the input so that we can repopulate the form
		}
		else{
				$data = AddManagement::create_add($input);
				//echo '<pre>';print_r($data);die('asdf');
				if($data == 'Failure'){
					return Redirect::to('admin/ads/create')->withInput()->with('message', 'Not able to save information, please try again.');
				}else{
				
					\Session::flash('save_message', 'Add has been saved.');
					return redirect("admin/ads");
				}
			
		}
	}
	
	public function edit_ads($id){
		$data['title'] = 'Edit Ads';
		$add = AddManagement::getaddbyid($id);
		$data['content_arr'] = $add;
		return view(AdminTemplate::view('pages.edit_ads'), $data);
	}
	
	public function update_ads($id){
		$input = Input::all();
		//dd($input);
		$rules = array(
			'headline'    => 'required',
			/* 'add_text' => 'required', */
			'add_size' => 'required',
			'start_date' => 'required',
			'end_date' => 'required'
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/ads/edit/'.$id)
				->withErrors($validator) // send back all errors to the login form
				->withInput(); // send back the input so that we can repopulate the form
		}
		else{
			$add = AddManagement::where(['id'=> $id])->first();
			$fileName='';
			if(!empty(Input::file('image'))) {
			  if (Input::file('image')->isValid()) {
				  $destinationPath = 'uploads/add_management'; // upload path
				  $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
				  $fileName = rand(11111,99999).'.'.$extension; // renameing image
				  Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
				  $add->image = $fileName;
				}
			}

			$add_text = !empty($_POST['add_text'])?$_POST['add_text']:"";	
			 $start_date = date("Y-m-d",strtotime($_POST['start_date']));
			 $end_date = date("Y-m-d",strtotime($_POST['end_date']));
			$add->headline		= $_POST['headline'];
			$add->add_text		= $add_text;
			$add->add_size 		= $_POST['add_size'];
			$add->start_date 	= $start_date;
			$add->end_date		= $end_date;
			$add->save();
			Session::flash('update_message', 'Add has been saved.');
			return redirect("admin/ads/edit/".$id);			
		}
	}
	
		public function delete_ads($id){
		$add  = AddManagement::where('id', $id)->get();
		$admgmt = 	$add->toArray();
		if(!empty($admgmt[0]['image']))  {
		$img = $admgmt[0]['image'];
		$upload_path = '/uploads/add_management/';
		unlink(base_path().$upload_path.$img);
		}
		$img_id =  $admgmt[0]['id'];
		$add_image = AddManagement::find($img_id);    
		$add_image->delete();
		
		Session::flash('delete_message', 'Ads & its content has been deleted successfully.');
		return redirect()->back();
	}
	
	public function edit_page($page_id)
	{
		$results = PageContent::where(['id' => $page_id])->first();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['content_arr'] = $results->toArray();
		
		$where_arr = array('content_type'=>'Page');
		
		$results1 = PageContent::where($where_arr)->get();
		//$results = User::where($where_arr)->builders;

		$data['pages_arr'] = $results1->toArray();

		$data['title'] = "Edit Page Content";
		
		return view(AdminTemplate::view('pages.edit_page'), $data);
	}
	
	public function update_page($page_id, Request $request)
	{
			$input = Input::all();
	//dd($input);
			$rules = array(
		'title' => 'required' 

	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/blog/edit/'.$page_id)
				->withErrors($validator); // send back all errors to the login form
		} else {
		 $page = PageContent::where(['id' => $page_id])->first();

		
		$slug = Str::slug($_POST['title'], '-');
		$content_type = 'Page';
		$page->title = $_POST['title'];
		$page->slug = $slug;
		$page->description = $_POST['description'];
		$page->parent_id = $_POST['parent_id'];
		//$user->password = bcrypt($_POST['password']);
		$page->content_type = $content_type;
		$page->meta_keywords = $_POST['meta_keywords'];
		$page->meta_description = $_POST['meta_description'];
		 if(!empty(Input::file('featured_image'))) {
		  if (Input::file('featured_image')->isValid()) {
		  $destinationPath = 'uploads/featured_images'; // upload path
		  $extension = Input::file('featured_image')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'-page'.'.'.$extension; // renameing image
		  Input::file('featured_image')->move($destinationPath, $fileName); // uploading file to given path
		  $page->featured_image = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		if($page->save())
		{
			Session::flash('update_message', 'Page Content has been updated');

			return redirect()->back();
		}
		
		
		
		
		}
	}
	
	
	public function create_page()
	{
		$where_arr = array('content_type'=>'Page');
		
		$results = PageContent::where($where_arr)->get();
		//$results = User::where($where_arr)->builders;

		$data['pages_arr'] = $results->toArray();
		$data['title'] = "Create page";
		return view(AdminTemplate::view('pages.edit_page'), $data);
	}
	
	public function add_page()
	{
		
	
		/* echo '<pre>';
		print_r($_POST['builder_location']);
		die; */
		$input = Input::all();
	//dd($input);
		$rules = array(
		'title' => 'required' 

	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/page/create')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		}
		else {
		
		$slug = Str::slug($_POST['title'], '-');
		$content_type = 'Page';
		$page = new PageContent;
		$page->title = $_POST['title'];
		$page->slug = $slug;
		$page->description = $_POST['description'];
		$page->parent_id = $_POST['parent_id'];
		//$user->password = bcrypt($_POST['password']);
		$page->content_type = $content_type;
		$page->meta_keywords = $_POST['meta_keywords'];
		$page->meta_description = $_POST['meta_description'];
		 if(!empty(Input::file('featured_image'))) {
		  if (Input::file('featured_image')->isValid()) {
		  $destinationPath = 'uploads/featured_images'; // upload path
		  $extension = Input::file('featured_image')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'-page'.'.'.$extension; // renameing image
		  Input::file('featured_image')->move($destinationPath, $fileName); // uploading file to given path
		  $page->featured_image = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		if($page->save())
		{
			Session::flash('save_message', 'Page Content has been saved');
			return redirect()->back();
		}
		
		}
	}
	
	public function delete_page($page_id)
	{
		$page = PageContent::find($page_id);    
		if($page->delete())
		{
			Session::flash('delete_message', 'Page Content has been deleted');
			return redirect()->back();
		}
	}
	
	public function get_categories()
	{
		$results = Category::all();
		//$results = User::where($where_arr)->builders;

		$data['categories_arr'] = $results->toArray();
		$data['title'] = "Categories";
		return view(AdminTemplate::view('pages.categories'), $data);
	}
	
	
	public function edit_category($cat_id)
	{
		$results = Category::where(['id' => $cat_id])->first();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['category_arr'] = $results->toArray();
		$data['title'] = "Edit Category";
		
		return view(AdminTemplate::view('pages.edit_category'), $data);
	}
	
	public function update_category($cat_id, Request $request)
	{
			$input = Input::all();
	//dd($input);
			$rules = array(
				'category_title' => 'required' 

			);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/broker/edit/'.$broker_id)
				->withErrors($validator); // send back all errors to the login form
		} else {
		 $cat = Category::where(['id' => $cat_id])->first();

		
		$slug = Str::slug($_POST['category_title'], '-');
		$cat->category_title = $_POST['category_title'];
		$cat->slug = $slug;
		$cat->description = $_POST['description'];
		 if(!empty(Input::file('featured_image'))) {
		  if (Input::file('featured_image')->isValid()) {
		  $destinationPath = 'uploads/featured_images'; // upload path
		  $extension = Input::file('featured_image')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'-cat'.'.'.$extension; // renameing image
		  Input::file('featured_image')->move($destinationPath, $fileName); // uploading file to given path
		  $cat->featured_image = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		if($cat->save())
		{
			Session::flash('update_message', 'Category has been updated');

			return redirect()->back();
		}
		
		
		
		
		}
	}
	
	
	public function create_category()
	{
		$data['title'] = "Create Category";
		return view(AdminTemplate::view('pages.edit_category'), $data);
	}
	
	public function add_category()
	{
		
	
		/* echo '<pre>';
		print_r($_POST['builder_location']);
		die; */
		$input = Input::all();
	//dd($input);
		$rules = array(
		'category_title' => 'required|unique:categories' 

	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/category/create')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		}
		else {
		
		$slug = Str::slug($_POST['category_title'], '-');
		$cat = new Category;
		$cat->category_title = $_POST['category_title'];
		$cat->slug = $slug;
		$cat->description = $_POST['description'];
		 if(!empty(Input::file('featured_image'))) {
		  if (Input::file('featured_image')->isValid()) {
		  $destinationPath = 'uploads/featured_images'; // upload path
		  $extension = Input::file('featured_image')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'-cat'.'.'.$extension; // renameing image
		  Input::file('featured_image')->move($destinationPath, $fileName); // uploading file to given path
		  $cat->featured_image = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		if($cat->save())
		{
			Session::flash('save_message', 'Category has been saved');
			return redirect()->back();
		}
		
		}
	}
	
	public function delete_category($cat_id)
	{
		$cat = Category::find($cat_id);    
		if($cat->delete())
		{
			Session::flash('delete_message', 'Category Content has been deleted');
			return redirect()->back();
		}
	}
	
	public function get_blogs()
	{
		$where_arr = array('content_type'=>'Blog');
		
		$results = PageContent::where($where_arr)->get();
		//$results = User::where($where_arr)->builders;

		$data['blogs_arr'] = $results->toArray();
		$data['title'] = "Blogs";
		return view(AdminTemplate::view('pages.blogs'), $data);
	}
	
	public function edit_blog($blog_id)
	{
		$results = PageContent::where(['id' => $blog_id])->first();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['content_arr'] = $results->toArray();
		
		$where_arr = array('content_type'=>'Blog');
		
		$results1 = PageContent::where($where_arr)->get();
		//$results = User::where($where_arr)->builders;

		$data['blog_arr'] = $results1->toArray();
		
		$results = Category::all();
		//$results = User::where($where_arr)->builders;

		$data['category_arr'] = $results->toArray();
		
		$blog_cats = BlogCategory::where(['blog_id' => $blog_id])->get();
		//$results = User::with('builders')->where($where_arr)->get();
		$blogcats_arr = $blog_cats->toArray();
		$cat_arr = array();
		foreach($blogcats_arr as $blog_val)
		{
			$cat_arr[]  = $blog_val['category_id'];
		}
		
		$data['cat_arr'] = $cat_arr;

		$data['title'] = "Edit Blog";
		
		return view(AdminTemplate::view('pages.edit_blog'), $data);
	}
	
	public function update_blog($blog_id, Request $request)
	{
			$input = Input::all();
	//dd($input);
			$rules = array(
			'title' => 'required' 

		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/blog/edit/'.$blog_id)
				->withErrors($validator); // send back all errors to the login form
		} else {
		 $blog = PageContent::where(['id' => $blog_id])->first();

		
		$slug = Str::slug($_POST['title'], '-');
		$val_slug = PageContent::where(array('slug'=>$slug))->get();
		if(count($val_slug) > 0){
			$val = uniqid();
			 $vals = substr($val,-3);
			 $slug = Str::slug($_POST['title'].$vals, '-');

		}
		$content_type = 'Blog';
		$blog->title = $_POST['title'];
		$blog->slug = $slug;
		$blog->description = $_POST['description'];
		//$user->password = bcrypt($_POST['password']);
		$blog->content_type = $content_type;
		$blog->meta_keywords = $_POST['meta_keywords'];
		$blog->meta_description = $_POST['meta_description'];
		 if(!empty(Input::file('featured_image'))) {
		  if (Input::file('featured_image')->isValid()) {
		  $destinationPath = 'uploads/featured_images'; // upload path
		  $extension = Input::file('featured_image')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'-blog'.'.'.$extension; // renameing image
		  Input::file('featured_image')->move($destinationPath, $fileName); // uploading file to given path
		  $blog->featured_image = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		if($blog->save())
		{
		 $where_arr = array('blog_id'=>$blog_id);
		 BlogCategory::where($where_arr)->delete();
		$categoryids  = $_POST['category_id'];
		foreach($categoryids as $val) {
		$blogcat = new BlogCategory ;
		$blogcat->blog_id = $blog_id;
		$blogcat->category_id = $val;
		$blogcat->save();
		}
		
			Session::flash('update_message', 'Blog content has been updated');

			return redirect()->back();
		}
		
		
		
		
		}
	}
	
	
	public function create_blog()
	{
		$where_arr = array('content_type'=>'Blog');
		
		$results = PageContent::where($where_arr)->get();
		//$results = User::where($where_arr)->builders;

		$data['blogs_arr'] = $results->toArray();
		
		$results = Category::all();
		//$results = User::where($where_arr)->builders;

		$data['category_arr'] = $results->toArray();
		
		$data['title'] = "Create blog";
		return view(AdminTemplate::view('pages.edit_blog'), $data);
	}
	
	public function add_blog()
	{
		
	
		/*  echo '<pre>';
		print_r($_POST['category_id']);
		die;  */
		$input = Input::all();
	//dd($input);
		$rules = array(
			'title' => 'required',
			'category_id' => 'required'

		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/blog/create')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		}
		else {
		
		$slug = Str::slug($_POST['title'], '-');
		$val_slug = PageContent::where(array('slug'=>$slug))->get();
		if(count($val_slug) > 0){
			$val = uniqid();
			$vals = substr($val,-3);
			$slug = Str::slug($_POST['title'].$vals, '-');
		}
		$content_type = 'Blog';
		$blog = new PageContent;
		$blog->title = $_POST['title'];
		$blog->slug = $slug;
		$blog->description = $_POST['description'];
		//$user->password = bcrypt($_POST['password']);
		$blog->content_type = $content_type;
		$blog->meta_keywords = $_POST['meta_keywords'];
		$blog->meta_description = $_POST['meta_description'];
		 if(!empty(Input::file('featured_image'))) {
		  if (Input::file('featured_image')->isValid()) {
		  $destinationPath = 'uploads/featured_images'; // upload path
		  $extension = Input::file('featured_image')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'-blog'.'.'.$extension; // renameing image
		  Input::file('featured_image')->move($destinationPath, $fileName); // uploading file to given path
		  $blog->featured_image = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		if($blog->save())
		{
			$blog_id = $blog->id;
		$categoryids  = $_POST['category_id'];
		foreach($categoryids as $val) {
		$blogcat = new BlogCategory ;
		$blogcat->blog_id = $blog_id;
		$blogcat->category_id = $val;
		$blogcat->save();
		}
		Session::flash('save_message', 'Blog content has been saved');
		return redirect()->back();
		
		}
		
		
		}
	}
	
	public function delete_blog($blog_id)
	{
		$blog = PageContent::find($blog_id);    
		if($blog->delete())
		{
			Session::flash('delete_message', 'Blog Content has been deleted');
			return redirect()->back();
		}
	}
	
	public function testimonials(){
		$results = DB::table('testimonials')->get();
		//$results = User::where($where_arr)->builders;

		$data['testimonials'] = $results;
		$data['title'] = "Testimonials";
		return view(AdminTemplate::view('pages.testimonials'), $data);
	}
	
	public function create_testimonials(){
		$data['title'] = "Create Testimonials";
		return view(AdminTemplate::view('pages.create_testimonials'), $data);
	}
	
	public function posttestimonials(){
		$input = Input::all();
		$rules = array(
			'created_by' => 'required',
			'state_company' => 'required',
			'description' => 'required',
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/testimonials/create')
				->withErrors($validator) // send back all errors to the login form
				->withInput(); // send back the input (not the password) so that we can repopulate the form
		}
		else {
			$insert = DB::table('testimonials')->insert(
				['created_by' => $_POST['created_by'], 'state_company' => $_POST['state_company'],'description' => $_POST['description'] ]
			);
			if($insert){
				Session::flash('save_message', 'Testimonial has been saved');
				return redirect("admin/testimonials");
			}else{
				Session::flash('error_message', 'Not able to save testimonial, please try again.');
				return Redirect::to('admin/testimonials/create')->withInput();
			}
		}
	}
	
	public function edit_testimonials($id){
		$results = DB::table('testimonials')->where(array('id' => $id))->get();
		//$results = User::where($where_arr)->builders;

		$data['testimonials'] = $results;
		$data['title'] = "Testimonials";
		return view(AdminTemplate::view('pages.edit_testimonials'), $data);
	}
	
	public function edit_post_testimonials($id){
		$input = Input::all();
		$rules = array(
			'created_by' => 'required',
			'state_company' => 'required',
			'description' => 'required',
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to("admin/testimonials/edit/$id")
				->withErrors($validator) // send back all errors to the login form
				->withInput(); // send back the input (not the password) so that we can repopulate the form
		}
		else {
			$insert = DB::table('testimonials')->where('id', $id)->update(
				['created_by' => $_POST['created_by'], 'state_company' => $_POST['state_company'],'description' => $_POST['description'] ]
			);
			if($insert){
				Session::flash('save_message', 'Testimonial has been saved');
				return redirect("admin/testimonials/edit/$id");
			}else{
				Session::flash('error_message', 'Not able to save testimonial, please try again.');
				return Redirect::to("admin/testimonials/edit/$id")->withInput();
			}
		}
	}
	
	public function delete_testimonials($id){
		if($id){
			$delete = DB::table('testimonials')->where('id', $id)->delete();
			if($delete){
				Session::flash('save_message', 'Testimonial has been deleted successfully.');
				return redirect("admin/testimonials");
			}else{
				Session::flash('error_message', 'Not able to Delete testimonial, please try again.');
				return redirect("admin/testimonials");
			}
		}
	}
	
	public function get_ads(){
		$data['title'] = 'Ads';
		$ads_obj  = AddManagement::all();
		$results  = $ads_obj->toArray();
		$data['ads_arr'] = $results;
		return view(AdminTemplate::view('pages.ads'), $data);
	}
	
	public function change_ads_status($ad_id,$ad_status)
	{
		$ads  = AddManagement::find($ad_id);
		$status = "";
		if($ad_status == 'Unpublish') {
		$status = "Publish";
		$ads->status = $status ;
		} 
		if($ad_status == 'Publish') {
		$status = "Unpublish";
		$ads->status = $status;
		}
		$ads->save();
		Session::flash('update_message', 'Ads has been '.$status.'ed successfully.');
		return redirect("admin/ads");
		
	}
	
	public function featured_testimonial($id,$status)
	{
		if($status == 'Yes') {
		$changed='No';
		$insert = DB::table('testimonials')->where('id', $id)->update(
				['featured' => $changed ]
			);
		}
		if($status == 'No') {
		$changed='Yes';
		$insert = DB::table('testimonials')->where('id', $id)->update(
				['featured' => $changed ]
			);
		}
		Session::flash('update_message', 'testimonial featured status has been changed successfully.');
		return redirect("admin/testimonials");
		
	}
	
	

} 
