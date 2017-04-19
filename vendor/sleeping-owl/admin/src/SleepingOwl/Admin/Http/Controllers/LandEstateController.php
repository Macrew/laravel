<?php namespace SleepingOwl\Admin\Http\Controllers;

use AdminTemplate;
use App;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Input;
use Redirect;
use Request;
use Session;
use Validator;
use SleepingOwl\Admin\Interfaces\FormInterface;
use SleepingOwl\Admin\Repository\BaseRepository;
use App\User;
use App\BuilderDetail;
use App\State;
use App\UserLocation;
use App\LandEstateDetail;
use App\Models\LandEstate;
use App\Models\DisplayLand;
use App\LandGallery;
use App\Models\DisplayLandOpenHour;
use DB;


class LandEstateController extends Controller
{

	public function get_landestates()
	{
		$where_arr = array('user_type'=>'LandEstate');
		
		$results = User::with('landestates')->where($where_arr)->get();
		//$results = User::where($where_arr)->builders;

		$data['landestates_arr'] = $results->toArray();
		$data['title'] = "Land Estates";
		return view(AdminTemplate::view('pages.landestates'), $data);
	}
	
	public function get_land()
	{
		$results = LandEstate::all();
		$data['landestates_arr'] = $results->toArray();
		$data['title'] = "Lands";
		return view(AdminTemplate::view('pages.land'), $data);
	}
	
	public function edit_landestate($landestate_id)
	{
		$results = LandEstateDetail::where(['landestate_id' => $landestate_id])->first();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['landestate_arr'] = $results->toArray();
		$states = State::all();
		$data['states_arr'] = $states->toArray();
		
		$user_location = UserLocation::where(['user_id' => $landestate_id])->get();
		//$results = User::with('builders')->where($where_arr)->get();
		$loc_arr = $user_location->toArray();
		foreach($loc_arr as $loc_val)
		{
			$location_arr[]  = $loc_val['state_id'];
		}
		
		$data['location_arr'] = $location_arr;
		$display_lands  = DisplayLand::where(['land_id'=>$landestate_id])->get();
		$data['land_arr']  = $display_lands->toArray();
		
		$prop_floor_img  = LandGallery::where(['landestate_id'=>$landestate_id])->get();
		$data['land_images_arr']  = $prop_floor_img->toArray();
		
		$data['title'] = "Edit land Estate";
		
		return view(AdminTemplate::view('pages.edit_landestate'), $data);
	}
	
	public function delete_land_images($img_id)
	{
		
		//die;
		$gallery_image = LandGallery::find($img_id);
		$img = $gallery_image->image;
		$upload_path = '/uploads/land_images/';
        unlink(base_path().$upload_path.$img);
		if($gallery_image->delete())
		{
			Session::flash('delete_message', 'Gallery image has been deleted');
			return redirect()->back();
		}
	}
	
	public function import_gallery_images()
	{
		$lands  = LandEstateDetail::all();
		$land_arr  = $lands->toArray();
		foreach($land_arr as $val)
		{
			$land = new LandGallery();
			$land->landestate_id = $val['landestate_id'];
			$land->image = $val['land_image'];
			$land->save();
		}
	}
	
	
	
	public function ajax_store_land_images()
	{
		$input = Input::all();
		$prop = $input['landestateid'];

	  $rules = array(
            'file' => 'image|max:3000',
        );
 
        $validation = Validator::make($input, $rules);
 
        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }

 
        $destinationPath = 'uploads/land_images'; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $fileName = rand(11111, 99999) . '-landgallery-'.$prop.'.' . $extension; // renameing image
        $upload_success = Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
		
 
        if ($upload_success) {
		$propgallery = new LandGallery;
		$propgallery->landestate_id = $prop;
		$propgallery->image = $fileName;
		$propgallery->save();
			echo 'File is uploaded successfully.';
        } else {
           echo 'Failed';
        }  
	}
	
	public function edit_land($landestate_id)
	{
		$results = LandEstate::where(['id' => $landestate_id])->first();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['landestate_arr'] = $results->toArray();
		
		$where_arr = array('user_type'=>'LandEstate');
		
		$results = User::with('landestates')->where($where_arr)->get();
		//$results = User::where($where_arr)->builders;

		$data['landestates_arr'] = $results->toArray();
		$data['title'] = "Edit land";
		
		$display_lands  = DisplayLand::where(['land_id'=>$landestate_id])->get();
		$data['land_arr']  = $display_lands->toArray();
		
		return view(AdminTemplate::view('pages.edit_land'), $data);
	}
	
	public function edit_display_land($land_id)
	{
		$results = DisplayLand::with('open_hours')->where(['id' => $land_id])->get();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['display_land_arr'] = $results->toArray();
		$data['title'] = "Edit Display Land";
		$data['land_id'] = $land_id;
		return view(AdminTemplate::view('pages.edit_display_land'), $data);
	}
	
	
	public function update_display_land($display_land_id)
	{
		$dis_land = DisplayLand::where('id',$display_land_id)->first();
		$display_lands = $dis_land->toArray();
		$land_id = $display_lands['land_id'];
		$input = Input::all();
		//dd($input);
		$rules = array(
		'display_village_title' => 'required',
		'display_location' => 'required',
		'wstart_time' => 'required', 
		'wend_time' => 'required', 
		'sastart_time' => 'required', 
		'saend_time' => 'required', 
		'sunstart_time' => 'required', 
		'sunend_time' => 'required', 
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);
		$validator->after(function($validator)
		{
			$check = $this->vldte_dsply_hmes_adres($_POST['display_location']);
			if ($check['status']=='false')
			{
				$validator->errors()->add('display_location', $check['msg']);
			}
		});
		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/land/display-land/edit/'.$display_land_id)
				->withErrors($validator) // send back all errors to the login form
				->withInput();
		} else {
		$lat = Session::get('lat');
		$lng = Session::get('lng');	
		$display_lands = DisplayLand::where('id',$display_land_id)->first();
		$display_land_arr = $display_lands->toArray();
		
		 $display_lands->display_village_title = $_POST['display_village_title'];
		  $display_lands->geo_lat = $lat;
		$display_lands->geo_lng = $lng;
		 $address =  preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $_POST['display_location']);
		 $display_lands->display_location = $address;

         $display_lands->save();
		 $display_lands_id = $display_land_id;
		 if(!empty($_POST['wstart_time']) && !empty($_POST['wend_time'])) {
			$open_hours = DisplayLandOpenHour::where(array('display_land_id'=>$display_lands_id,'day'=>'Weekdays'))->first() ;
			$open_hours->start_time = $_POST['wstart_time'];
			$open_hours->end_time  = $_POST['wend_time'];
			$open_hours->save();
			}
			
		if(!empty($_POST['sastart_time']) && !empty($_POST['saend_time'])) {
			$open_hours = DisplayLandOpenHour::where(array('display_land_id'=>$display_lands_id,'day'=>'Saturdays'))->first() ;
			$open_hours->start_time = $_POST['sastart_time'];
			$open_hours->end_time  = $_POST['saend_time'];
			$open_hours->save();
			}	
		if(!empty($_POST['sunstart_time']) && !empty($_POST['sunend_time'])) {
			$open_hours = DisplayLandOpenHour::where(array('display_land_id'=>$display_lands_id,'day'=>'Sundays'))->first() ;
			$open_hours->start_time = $_POST['sunstart_time'];
			$open_hours->end_time  = $_POST['sunend_time'];
			$open_hours->save();
			}	
			
		Session::flash('update_message', 'Property Detail has been updated');

		return Redirect::to('admin/landestate/edit/'.$land_id);
		
		}
	
	}
	
	public function delete_display_land($display_land_id)
	{
		$display_land = DisplayLand::where('id',$display_land_id)->delete();
		$display_land = DisplayLandOpenHour::where('display_land_id',$display_land_id)->delete();
		Session::flash('delete_message', 'Display Land has been deleted');

		return redirect()->back();
	}
	
	public function update_long()
	{
		$dis_home = DisplayLand::all();
		$display_home_arr = $dis_home->toArray();
		foreach($display_home_arr as $val)
		{
			$address = $val['display_location'];
			$id = $val['id'];
			$data = $this->vldte_dsply_hmes_adres($address);
			$lat = $data['lat'];
			$lng = $data['lng'];
			DB::table('display_land')
            ->where('id', $id)
            ->update(['geo_lat' => $lat,'geo_lng'=>$lng]);
		}
	}
	
	
	public function update_landestate($landestate_id, Request $request)
	{
			$input = Input::all();
	//dd($input);
		$rules = array(
		'land_location' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/landestate/edit/'.$landestate_id)
				->withErrors($validator); // send back all errors to the login form
		} else {
		 $landestate = LandEstateDetail::where(['landestate_id' => $landestate_id])->first();
		/*  echo '<pre>';
		 print_r($builders);
		 die;   */
		 
		 if(!empty(Input::file('landestate_logo'))) {
		  if (Input::file('landestate_logo')->isValid()) {
		  $destinationPath = 'uploads/landestate_logo'; // upload path
		  $extension = Input::file('landestate_logo')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'.'.$extension; // renameing image
		  Input::file('landestate_logo')->move($destinationPath, $fileName); // uploading file to given path
		  $landestate->logo = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		 if(!empty(Input::file('landestate_image'))) {
		  if (Input::file('landestate_image')->isValid()) {
		  $destinationPath = 'uploads/land_images'; // upload path
		  $extension = Input::file('landestate_image')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'.'.$extension; // renameing image
		  Input::file('landestate_image')->move($destinationPath, $fileName); // uploading file to given path
		  $landestate->land_image = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		 if(!empty(Input::file('master_plan'))) {
		  if (Input::file('master_plan')->isValid()) {
		  $destinationPath = 'uploads/land_master_plan'; // upload path
		  $extension = Input::file('master_plan')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'.'.$extension; // renameing image
		  Input::file('master_plan')->move($destinationPath, $fileName); // uploading file to given path
		  $landestate->master_plan = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
			
		 $landestate->firstname = $_POST['firstname'];
		 $landestate->lastname = $_POST['lastname'];
		$address =  preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $_POST['address']);
		 $landestate->address = $address;
		 $landestate->company_name = $_POST['company_name'];
		 $landestate->phn_no = $_POST['phn_no'];
		 $landestate->land_desc = $_POST['land_desc'];
		 $landestate->established = $_POST['established'];
		 $landestate->price_range = $_POST['price_range'];


         $landestate->save();
		 $user_type = 'LandEstate';
		 $where_arr = array('user_type'=>$user_type,'user_id'=>$landestate_id);
		 UserLocation::where($where_arr)->delete();
		 $land_location  = $_POST['land_location'];
		$user_location = new UserLocation ;
		foreach($land_location as $val) {
		$user_location = new UserLocation ;
		$user_location->user_id = $landestate_id;
		$user_location->user_type = $user_type;
		$user_location->state_id = $val;
		$user_location->save();
		}
		Session::flash('update_message', 'LandEstate detail has been updated');

		return redirect()->back();
		
		}
	}
	
	public function update_land($landestate_id, Request $request)
	{
			$input = Input::all();
	//dd($input);
		$rules = array(
		'title'    => 'required', // make sure the email is an actual email
		//'password' => 'required|alphaNum|min:6', // password can only be alphanumeric and has to be greater than 3 characters
		'land_desc' => 'required', // password can only be alphanumeric and has to be greater than 3 characters
		'user_id' => 'required', 
		'total_size' => 'required',
		'completion_date' => 'required', 
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/land/edit/'.$landestate_id)
				->withErrors($validator); // send back all errors to the login form
		} else {
		 $landestate = LandEstate::where(['id' => $landestate_id])->first();
		/*  echo '<pre>';
		 print_r($builders);
		 die;   */
		 
		 if(!empty(Input::file('landestate_image'))) {
		  if (Input::file('land_images')->isValid()) {
		  $destinationPath = 'uploads/land_images'; // upload path
		  $extension = Input::file('land_images')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'.'.$extension; // renameing image
		  Input::file('land_images')->move($destinationPath, $fileName); // uploading file to given path
		  $landestate->logo = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
			
		 $landestate->title = $_POST['title'];
		 $landestate->description = $_POST['land_desc'];
		 $landestate->total_size = $_POST['total_size'];
		 $landestate->completion_date = $_POST['completion_date'];
		 $landestate->user_id = $_POST['user_id'];

         $landestate->save();
		
		Session::flash('update_message', 'Lands has been updated');

		return redirect()->back();
		
		
		}
	}
	
	
	public function create_landestate()
	{
		$data['title'] = "Create Land Estate";
		$states = State::all();
		$data['states_arr'] = $states->toArray();
		return view(AdminTemplate::view('pages.edit_landestate'), $data);
	}
	
	public function create_land()
	{
		$where_arr = array('user_type'=>'LandEstate');
		
		$results = User::with('landestates')->where($where_arr)->get();
		//$results = User::where($where_arr)->builders;

		$data['landestates_arr'] = $results->toArray();
		$data['title'] = "Create Land";
		return view(AdminTemplate::view('pages.edit_land'), $data);
	}
	
	public function add_land()
	{
	
		/* echo '<pre>';
		print_r($_POST['builder_location']);
		die; */
		$input = Input::all();
	//dd($input);
		$rules = array(
		'title'    => 'required', 
		'land_desc' => 'required', 
		'user_id' => 'required', 
		'total_size' => 'required',
		'completion_date' => 'required', 
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/land/create')
				->withErrors($validator) // send back all errors to the login form
				->withInput(); // send back the input (not the password) so that we can repopulate the form
		}
		else {

		$landestate = new LandEstate;
	
		 if(!empty(Input::file('landestate_image'))) {
		  if (Input::file('landestate_image')->isValid()) {
		  $destinationPath = 'uploads/land_images'; // upload path
		  $extension = Input::file('landestate_image')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'.'.$extension; // renameing image
		  Input::file('landestate_image')->move($destinationPath, $fileName); // uploading file to given path
		  $landestate->image = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		 $landestate->title = $_POST['title'];
		 $landestate->description = $_POST['land_desc'];
		 $landestate->total_size = $_POST['total_size'];
		 $landestate->user_id = $_POST['user_id'];
		 $landestate->completion_date = $_POST['completion_date'];
        $landestate->save();

		
		Session::flash('save_message', 'Land has been saved');

		return redirect()->back();
		

		
		}
	}
	
	
	
	public function add_landestate()
	{
	
		/* echo '<pre>';
		print_r($_POST['builder_location']);
		die; */
		$input = Input::all();
	//dd($input);
		$rules = array(
		'email'    => 'required|email|unique:users', // make sure the email is an actual email
		'land_location' => 'required', // password can only be alphanumeric and has to be greater than 3 characters
		'address' => 'required',
		'company_name' => 'required',
		'price_range' => 'required',
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/landestate/create')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		}
		else {
		
		$user_type = 'LandEstate';
		$user = new User;
		$user->email = $_POST['email'];
		//$user->password = bcrypt($_POST['password']);
		$user->user_type = $user_type;
		if($user->save())
		{
		
		$landestate_id	 =	$user->id;
		$landestate = new LandEstateDetail;
	
		 if(!empty(Input::file('landestate_logo'))) {
		  if (Input::file('landestate_logo')->isValid()) {
		  $destinationPath = 'uploads/landestate_logo'; // upload path
		  $extension = Input::file('landestate_logo')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'.'.$extension; // renameing image
		  Input::file('landestate_logo')->move($destinationPath, $fileName); // uploading file to given path
		  $landestate->logo = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
	
	
		 if(!empty(Input::file('landestate_image'))) {
		  if (Input::file('landestate_image')->isValid()) {
		  $destinationPath = 'uploads/land_images'; // upload path
		  $extension = Input::file('landestate_image')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'.'.$extension; // renameing image
		  Input::file('landestate_image')->move($destinationPath, $fileName); // uploading file to given path
		  $landestate->land_image = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		 if(!empty(Input::file('master_plan'))) {
		  if (Input::file('master_plan')->isValid()) {
		  $destinationPath = 'uploads/land_master_plan'; // upload path
		  $extension = Input::file('master_plan')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'.'.$extension; // renameing image
		  Input::file('master_plan')->move($destinationPath, $fileName); // uploading file to given path
		  $landestate->master_plan = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		
		$landestate->landestate_id = $landestate_id;	
		 $landestate->firstname = $_POST['firstname'];
		 $landestate->lastname = $_POST['lastname'];
		 $landestate->address = $_POST['address'];
		 $landestate->company_name = $_POST['company_name'];
		 $landestate->phn_no = $_POST['phn_no'];
		 $landestate->land_desc = $_POST['land_desc'];
		 $landestate->established = $_POST['established'];
		 $landestate->price_range = $_POST['price_range'];

        $landestate->save();

		 $land_location  = $_POST['land_location'];
		$user_location = new UserLocation ;
		foreach($land_location as $val) {
		$user_location = new UserLocation ;
		$user_location->user_id = $landestate_id;
		$user_location->user_type = $user_type;
		$user_location->state_id = $val;
		$user_location->save();
		}
		
		Session::flash('save_message', 'LandEstate detail has been saved');

		return redirect()->back();
		
		}
		
		}
	}
	
	public function delete_landestate($landest_id)
	{
		$user = User::find($landest_id);    
		if($user->delete())
		{
			LandEstateDetail::where('landestate_id', $landest_id)->delete();
			UserLocation::where('user_id', $landest_id)->delete();
			Session::flash('delete_message', 'LandEstate detail has been deleted');
			return redirect()->back();
		}
	}
	
	public function delete_land($landest_id)
	{
		$land = LandEstate::find($landest_id);    
		if($land->delete())
		{
			Session::flash('delete_message', 'Land detail has been deleted');
			return redirect()->back();
		}
	}
	
	public function save_display_land($land_id)
	{
		$input = Input::all();
		//dd($input);
		$rules = array(
		'display_village_title' => 'required',
		'display_location' => 'required',
		'wstart_time' => 'required', 
		'wend_time' => 'required', 
		'sastart_time' => 'required', 
		'saend_time' => 'required', 
		'sunstart_time' => 'required', 
		'sunend_time' => 'required', 
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);
		$validator->after(function($validator)
		{
			$check = $this->vldte_dsply_hmes_adres($_POST['display_location']);
			if ($check['status']=='false')
			{
				$validator->errors()->add('display_location', $check['msg']);
			}
		});
		
		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/landestate/edit/'.$land_id)
				->withErrors($validator) // send back all errors to the login form
				->withInput();
		} else {
		
		$lat = Session::get('lat');
		$lng = Session::get('lng');
		$lands = new DisplayLand;
			
		 $lands->display_village_title = $_POST['display_village_title'];
		 $lands->display_location = $_POST['display_location'];
		 $lands->land_id = $land_id;
		 $lands->geo_lng = $lng;
		 $lands->geo_lat = $lat;

         $lands->save();
		 $display_land_id = $lands->id ;
		 if(!empty($_POST['wstart_time']) && !empty($_POST['wend_time'])) {
			$display_land = new DisplayLandOpenHour ;
			$display_land->start_time = $_POST['wstart_time'];
			$display_land->end_time  = $_POST['wend_time'];
			$display_land->day  = 'Weekdays' ;
			$display_land->display_land_id  = $display_land_id;
			$display_land->save();
			}
			
		if(!empty($_POST['sastart_time']) && !empty($_POST['saend_time'])) {
			$display_land = new DisplayLandOpenHour ;
			$display_land->start_time = $_POST['saend_time'];
			$display_land->end_time  = $_POST['saend_time'];
			$display_land->day  = 'Saturdays ' ;
			$display_land->display_land_id  = $display_land_id;
			$display_land->save();
			}	
		if(!empty($_POST['sunstart_time']) && !empty($_POST['sunend_time'])) {
			$display_land = new DisplayLandOpenHour ;
			$display_land->start_time = $_POST['sunstart_time'];
			$display_land->end_time  = $_POST['sunend_time'];
			$display_land->day  = 'Sundays ' ;
			$display_land->display_land_id  = $display_land_id;
			$display_land->save();
			}	
			
		Session::flash('update_message', 'Land Detail has been updated');

		return redirect()->back();
		
		}
	
	}
	
	
	public function vldte_dsply_hmes_adres($address)
	{
		$data = array();
	 	$coordinates = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&key=AIzaSyCXVlHprV9_AorKioNKD2DaTVuT30ks4jE&sensor=false');
		$coordinates = json_decode($coordinates); 
		if($coordinates->status == 'OK')
		{
			$data['lng'] =  $coordinates->results[0]->geometry->location->lng;
			$data['lat'] =  $coordinates->results[0]->geometry->location->lat;
			Session::put('lng', $data['lng']);
			Session::put('lat', $data['lat']);
			$data['status'] = 'true';
			$data['msg'] = $coordinates->status;
		} else if($coordinates->status == 'ZERO_RESULTS') {
			$data['lng'] =  "";
			$data['lat'] =  "";
			$data['status'] = 'false';
			$data['msg'] = 'Geocode was successful but returned no results';
		}
		else if($coordinates->status == 'OVER_QUERY_LIMIT') {
			$data['lng'] =  "";
			$data['lat'] =  "";
			$data['status'] = 'false';
			$data['msg'] = 'You are over your quota.';
		}
		else if($coordinates->status == 'REQUEST_DENIED') {
			$data['lng'] =  "";
			$data['lat'] =  "";
			$data['status'] = 'false';
			$data['msg'] = 'Your request was denied.';
		}
		else if($coordinates->status == 'INVALID_REQUEST') {
			$data['lng'] =  "";
			$data['lat'] =  "";
			$data['status'] = 'false';
			$data['msg'] = 'Rhe query (address, components or latlng) is missing.';
		}
		else if($coordinates->status == 'UNKNOWN_ERROR') {
			$data['lng'] =  "";
			$data['lat'] =  "";
			$data['status'] = 'false';
			$data['msg'] = 'The request could not be processed due to a server error. The request may succeed if you try again.';
		}
		return $data;
	}
	
	public function manage_display_land_location()
	{
		$data['title'] = "Manage Land Location";
		$headr_state = 'VIC';
		$data['build_location'] = State::where(['state_name' => $headr_state])->get();
		return view(AdminTemplate::view('pages.manage_display_land_location'), $data);
	}
	
	public function change_state_new_ajax()
	{
		//Session::set('header_state',$_REQUEST['state']);
		$states = State::where(['state_name' => $_REQUEST['state']])->get();
		$states_arr = $states->toArray();
		if(count($states_arr) > 0){
			return $states_arr;
		}else{
			return 'no-state';
		}

		die;
	}
	
	public function ajax_filter_map_lands()
	{
	
		if(!empty($_REQUEST['land_estate_location'])) {
		//$query = LandEstateDetail;
		if(!empty($_REQUEST['land_estate_location']) && $_REQUEST['land_estate_location'] != "Land Location")
		{
			$loc_name = $_REQUEST['land_estate_location'];
			$states = State::where('id', $loc_name)->get(array('id'));
			$users = UserLocation::wherein('state_id', $states)->groupBy('user_id')->get(array('user_id'));
			$users_arr = $users->toArray();
			$user_ar = "";
			foreach($users_arr as $user_val)
			{
				$user_ar[] = $user_val['user_id'];
			}
			///$userstring = "'" . implode("','", $user_ar) . "'";
			//$wherein.= "->whereIn(user_id,".$userstring.")";
			$query = LandEstateDetail::whereIn('landestate_id',$user_ar);
		} else {
			 $header_state = "";
				 $header_state = Session::get('header_state');
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
				 $users = UserLocation::where('user_type','LandEstate')->whereIn('state_id', function($query){
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
					$query->select('id')
					->from('states')
					->where('state_name', $headr_state);
				})->groupBy('user_id')->get(array('user_id'));
				
				$users_arr = $users->toArray();
				$user_ar = "";
				foreach($users_arr as $user_val)
				{
					$user_ar[] = $user_val['user_id'];
				}
					///$userstring = "'" . implode("','", $user_ar) . "'";
					//$wherein.= "->whereIn(user_id,".$userstring.")";

				$query = LandEstateDetail::whereIn('landestate_id',$user_ar);
			
			}
	
		
		$results = $query->get();
		$prop = $results->toArray();
		
		
		if(!empty($prop)) {
		$landids="";
		foreach($prop as $prop_val)
		{
			$landids[] = $prop_val['landestate_id'];
		}
		} else {
		$landids="";	
		}
		/* echo '<pre>';
		print_r($landids); */
		
		//echo "'".implode("','",$landids)."'";
		
		$prop_display_home = DisplayLand::with('open_hours')->whereIn('land_id',$landids);
		$total_display_home = $prop_display_home->count();
		
		$prop_count = $query->count();
		$page	=	"" ;
		$lastpage	=	"" ;
		$numrows  = "" ;
		
		$total_prop = $prop_count;
			if(isset($_REQUEST['page']))
			{
				$page = $_REQUEST['page'];
			}
			else
			{
				$page	=	1 ;
			}
			
			$numrows	=	$total_prop ;
			$rows_per_page	=	10;
	
			// Calculate number of $lastpage
			$lastpage = ceil($numrows/$rows_per_page);

			// validate/limit requested $pageno
			$page = (int)$page;
			if ($page > $lastpage) {
				$page = $lastpage;
			}
			if ($page < 1) {
					$page = 1;
				}
	$currentpage = !empty($page) ? (integer)$page : 1;
			 $start = ($page - 1) * $rows_per_page;
			 $end = $start + $rows_per_page -1;
			
			if($end > $numrows - 1){
				$end = $numrows - 1;
			}
		/* $prop_display_home->limit($rows_per_page);
		$prop_display_home->offset($start);	 */
		$prop_display_home->orderBy('id','desc');
		//echo $prop_display_home->getQuery->toSql();
		$display_home_arrs = $prop_display_home->get();
		$display_home_arr = $display_home_arrs->toArray();
		$i=0;
		
		foreach($display_home_arr as $display_value)
		{
			$land_eastates = LandEstateDetail::where('landestate_id',$display_value['land_id'])->first();
			$land_logo_arr = $land_eastates->toArray();
			$image = !empty($land_logo_arr['logo'])?$land_logo_arr['logo']:"";
				$display_value = array_merge( $display_value, array( "image" => $image,'landestate_id'=>$land_logo_arr['id'] ) );
			$display_arr[$i] = $display_value;
			$i++;	
		}
		if(!empty($display_arr)) {
		$display_arr = array_merge($display_arr,array('total_display_lands'=>$total_display_home));
		} else {
		$display_arr = array(array(),array('total_display_lands'=>'0'));
		}
		echo json_encode($display_arr);
		}
	}
	
	
	public function update_land_location()
	{
		$id = $_REQUEST['rel'];
		$adress = $_REQUEST['adress'];
		$lat = $_REQUEST['lat'];
		$lng = $_REQUEST['lng'];
		$display_lands = DisplayLand::where('id',$id)->first();
		$display_land_arr = $display_lands->toArray();
		if(!empty($display_land_arr)) {
		$display_lands->display_location = $adress;
		$display_lands->geo_lat = $lat;
		$display_lands->geo_lng = $lng;
		if($display_lands->save())
		{
			echo 'Display Land location has been updated.';
		}
		else {
			echo 'Request can\'t be processed';
		} 
		
		} else {
		echo 'Request can\'t be processed';
		}
	}
	
	
	

} 