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
use App\UserDetail;
use App\State;
use App\UserLocation;
use App\Property;
use App\Models\PropertyDisplayHome;
use App\PropertyInclusion;


class BuilderController extends Controller
{

	public function get_builders()
	{
		$where_arr = array('user_type'=>'Builder');
		
		$results = User::with('builders')->where($where_arr)->get();
		//$results = User::where($where_arr)->builders;

		$data['builders_arr'] = $results->toArray();
		$data['title'] = "Builders";
		return view(AdminTemplate::view('pages.builders'), $data);
	}
	
	public function edit_builder($builder_id)
	{
		$results = BuilderDetail::where(['builder_id' => $builder_id])->first();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['builders_arr'] = $results->toArray();
		$states = State::all();
		$data['states_arr'] = $states->toArray();
		
		$user_location = UserLocation::where(['user_id' => $builder_id])->get();
		//$results = User::with('builders')->where($where_arr)->get();
		$loc_arr = $user_location->toArray();
		foreach($loc_arr as $loc_val)
		{
			$location_arr[]  = $loc_val['state_id'];
		}
		
		$data['location_arr'] = $location_arr;
	 $user = User::where(['id' => $builder_id])->first();
	 $data['user'] = $user;
	 $prop_query = Property::where(['user_id' => $builder_id])->get(array('id','property_title'));
		//$results = User::with('builders')->where($where_arr)->get();
	$prop_arr = $prop_query->toArray();
	 
	 $data['prop_arr'] = $prop_arr;
	 
	 $prop_dis_query = PropertyDisplayHome::where(['builder_id' => $builder_id])->get();
	 $property_display_hr = $prop_dis_query->toArray();
	 $data['property_display_hr'] = $property_display_hr;
	 
	  $prop_inc_query = PropertyInclusion::where(['builder_id' => $builder_id])->groupBy('property_id')->get();
	 $prop_inc_arr = $prop_inc_query->toArray();
	 $data['prop_inc_arr'] = $prop_inc_arr;

	 $data['builder_id'] = $builder_id;
		$data['title'] = "Edit Builder";
		
		return view(AdminTemplate::view('pages.edit_builder'), $data);
	}
	
	public function update_builder($builder_id, Request $request)
	{
			$input = Input::all();
	//dd($input);
		$rules = array(
		'builder_location' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/builder/create')
				->withErrors($validator); // send back all errors to the login form
		} else {
		 $builders = BuilderDetail::where(['builder_id' => $builder_id])->first();
		/*  echo '<pre>';
		 print_r($builders);
		 die;   */
		 
		 if(!empty(Input::file('builder_logo'))) {
		  if (Input::file('builder_logo')->isValid()) {
		  $destinationPath = 'uploads/builder_logo'; // upload path
		  $extension = Input::file('builder_logo')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'.'.$extension; // renameing image
		  Input::file('builder_logo')->move($destinationPath, $fileName); // uploading file to given path
		  $builders->logo = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		 $user = User::where(['id' => $builder_id])->first();
		$user->status = $_POST['status'];
			$user->save();
		 $builders->firstname = $_POST['firstname'];
		 $builders->lastname = $_POST['lastname'];
		 $builders->address = $_POST['address'];
		 $builders->company_name = $_POST['company_name'];
		 $builders->phn_no = $_POST['phn_no'];
		 $builders->builder_desc = $_POST['builder_desc'];
		 $builders->industry_awards = $_POST['industry_awards'];
		 $builders->established = $_POST['established'];
		 $builders->annual_home_builds = $_POST['annual_home_builds'];
		 $builders->price_range = $_POST['price_range'];
		 $builders->stuctured_gurantee = $_POST['stuctured_gurantee'];
		 $builders->free_maintaince_period = $_POST['free_maintaince_period'];
		 if(!empty($_POST['housing_industry'])) {
		 $housing_industry = $_POST['housing_industry'];
		 } else {
		 $housing_industry = 'No' ;
		 }
		  if(!empty($_POST['master_builders'])) {
		 $master_builders = $_POST['master_builders'];
		 } else {
		 $master_builders = 'No' ;
		 }
		 $builders->housing_industry = $housing_industry;
		 
		 $builders->master_builders = $master_builders;
		 
		/*  echo '<pre>';
		 print_r($builders);
		 die; */

         $builders->save();
		 $user_type = 'Builder';
		 $where_arr = array('user_type'=>'Builder','user_id'=>$builder_id);
		 UserLocation::where($where_arr)->delete();
		 $builder_location  = $_POST['builder_location'];
		$user_location = new UserLocation ;
		foreach($builder_location as $val) {
		$user_location = new UserLocation ;
		$user_location->user_id = $builder_id;
		$user_location->user_type = $user_type;
		$user_location->state_id = $val;
		$user_location->save();
		}
		Session::flash('update_message', 'Builder detail has been updated');

		return redirect()->back();
		
		}
	}
	
	
	public function create_builder()
	{
		$data['title'] = "Create Builder";
		$states = State::all();
		$data['states_arr'] = $states->toArray();
		return view(AdminTemplate::view('pages.edit_builder'), $data);
	}
	
	public function add_builder()
	{
	
		/* echo '<pre>';
		print_r($_POST['builder_location']);
		die; */
		$input = Input::all();
	//dd($input);
		$rules = array(
		'email'    => 'required|email|unique:users', // make sure the email is an actual email
		'username'    => 'required|unique:users', // make sure the username is an actual username
		'password' => 'required|alphaNum|min:6', // password can only be alphanumeric and has to be greater than 3 characters
		'builder_location' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/builder/create')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		}
		else {
		
		$user_type = 'Builder';
		$user = new User;
		$user->email = $_POST['email'];
		$user->username = $_POST['username'];
		$user->password = bcrypt($_POST['password']);
		$user->user_type = $user_type;
		$user->status = $_POST['status'];
		if($user->save())
		{
		
		$builder_id	 =	$user->id;
		$builder = new BuilderDetail;
	
		 if(!empty(Input::file('builder_logo'))) {
		  if (Input::file('builder_logo')->isValid()) {
		  $destinationPath = 'uploads/builder_logo'; // upload path
		  $extension = Input::file('builder_logo')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'.'.$extension; // renameing image
		  Input::file('builder_logo')->move($destinationPath, $fileName); // uploading file to given path
		  $builder->logo = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		$builder->builder_id = $builder_id;	
		 $builder->firstname = $_POST['firstname'];
		 $builder->lastname = $_POST['lastname'];
		 $builder->address = $_POST['address'];
		 $builder->company_name = $_POST['company_name'];
		 $builder->phn_no = $_POST['phn_no'];
		 $builder->builder_desc = $_POST['builder_desc'];
		 $builder->industry_awards = $_POST['industry_awards'];
		 $builder->established = $_POST['established'];
		 $builder->annual_home_builds = $_POST['annual_home_builds'];
		 $builder->price_range = $_POST['price_range'];
		 $builder->stuctured_gurantee = $_POST['stuctured_gurantee'];
		 $builder->free_maintaince_period = $_POST['free_maintaince_period'];
		 if(!empty($_POST['housing_industry'])) {
		 $housing_industry = $_POST['housing_industry'];
		 } else {
		 $housing_industry = 'No' ;
		 }
		  if(!empty($_POST['master_builders'])) {
		 $master_builders = $_POST['master_builders'];
		 } else {
		 $master_builders = 'No' ;
		 }
		 $builder->housing_industry = $housing_industry;
		 
		 $builder->master_builders = $master_builders;


        $builder->save();
		
		 $user_type = 'Builder';
		 $builder_location  = $_POST['builder_location'];
		$user_location = new UserLocation ;
		foreach($builder_location as $val) {
		$user_location = new UserLocation ;
		$user_location->user_id = $builder_id;
		$user_location->user_type = $user_type;
		$user_location->state_id = $val;
		$user_location->save();
		}
		
		Session::flash('save_message', 'Builder detail has been saved');

		return redirect()->back();
		
		}
		
		}
	}
	
	public function delete_builder($builder_id)
	{
		$user = User::find($builder_id);    
		if($user->delete())
		{
			$user = BuilderDetail::find($builder_id);  
			BuilderDetail::where('builder_id', $builder_id)->delete();
			UserLocation::where('user_id', $builder_id)->delete();
			Session::flash('delete_message', 'Builder detail has been deleted');
			return redirect()->back();
		}
	}
	
	
	public function featured_builder($builder_id){
		$builders = BuilderDetail::where(['builder_id' => $builder_id])->first();
		//$results = User::with('builders')->where($where_arr)->get();
		$builders_arr = $builders->toArray();
		$featured = '';
		if($builders_arr['featured'] == 'No'){
			$featured = 'Yes';
		}else{
			$featured = 'No';
		}
		$builders->featured = $featured;
		if($builders->save()){
			Session::flash('delete_message', 'Builder has been changed to featured.');
			return redirect()->back();
		}else{
			Session::flash('delete_message', 'Currently not able change builder to featured. Please try again.');
			return redirect()->back();
		}
	}
	
	public function get_users()
	{
		$where_arr = array('user_type'=>'User');
		
		$results = User::with('users')->where($where_arr)->get();
		//$results = User::where($where_arr)->builders;

		$data['users_arr'] = $results->toArray();
		$data['title'] = "Users";
		return view(AdminTemplate::view('pages.users'), $data);
	}
	
	public function edit_user($user_id)
	{
		$results = UserDetail::where(['user_id' => $user_id])->first();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['users_arr'] = $results->toArray();
		$states = State::all();
		$data['states_arr'] = $states->toArray();
		
		$user_location = UserLocation::where(['user_id' => $user_id])->get();
		//$results = User::with('builders')->where($where_arr)->get();
		$loc_arr = $user_location->toArray();
		$location_arr="";
		foreach($loc_arr as $loc_val)
		{
			$location_arr[]  = $loc_val['state_id'];
		}
		
		$data['location_arr'] = $location_arr;
		$user = User::where(['id' => $user_id])->first();
		$data['user'] = $user;
		$data['title'] = "Edit User";
		
		return view(AdminTemplate::view('pages.edit_user'), $data);
	}
	
	public function update_user($user_id, Request $request)
	{
			$input = Input::all();
	//dd($input);
		$rules = array(
		'firstname' => 'required' ,
		'lastname' => 'required' ,
		'phone' => 'required' ,
		'address' => 'required' ,
		'builder_location' => 'required' 
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/user/create')
				->withErrors($validator); // send back all errors to the login form
		} else {
		 $users = UserDetail::where(['user_id' => $user_id])->first();

		 $user = User::where(['id' => $user_id])->first();
		$user->status = $_POST['status'];
			$user->save();
		 $users->firstname = $_POST['firstname'];
		 $users->lastname = $_POST['lastname'];
		 $users->address = $_POST['address'];
		 $users->phone = $_POST['phone'];

         $users->save();	
		  $user_type = 'Builder';
		 $where_arr = array('user_type'=>'User','user_id'=>$user_id);
		 UserLocation::where($where_arr)->delete();
		 $builder_location  = $_POST['builder_location'];
		$user_location = new UserLocation ;
		foreach($builder_location as $val) {
		$user_location = new UserLocation ;
		$user_location->user_id = $user_id;
		$user_location->user_type = $user_type;
		$user_location->state_id = $val;
		$user_location->save();
		}

		Session::flash('update_message', 'user detail has been updated');

		return redirect()->back();
		
		}
	}
	
	public function create_user()
	{
		$data['title'] = "Create User";
		$states = State::all();
		$data['states_arr'] = $states->toArray();
		return view(AdminTemplate::view('pages.edit_user'), $data);
	}
	
	public function add_user()
	{
	
		/* echo '<pre>';
		print_r($_POST['builder_location']);
		die; */
		$input = Input::all();
	//dd($input);
		$rules = array(
		'email'    => 'required|email|unique:users', // make sure the email is an actual email
		'username'    => 'required|unique:users', // make sure the username is an actual username
		'password' => 'required|alphaNum|min:6', // password can only be alphanumeric and has to be greater than 3 characters
		'firstname' => 'required' ,
		'lastname' => 'required' ,
		'phone' => 'required' ,
		'address' => 'required' ,
		'builder_location' => 'required' 
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/user/create')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		}
		else {
		
		$user_type = 'User';
		$user = new User;
		$user->email = $_POST['email'];
		$user->username = $_POST['username'];
		$user->password = bcrypt($_POST['password']);
		$user->user_type = $user_type;
		$user->status = $_POST['status'];
		if($user->save())
		{
		
		$user_id	 =	$user->id;
		$user = new UserDetail;
	
	
		
		$user->user_id = $user_id;	
		$user->firstname = $_POST['firstname'];
		 $user->lastname = $_POST['lastname'];
		 $user->address = $_POST['address'];
		 $user->phone = $_POST['phone'];
         $user->save();
		  $builder_location  = $_POST['builder_location'];
		$user_location = new UserLocation ;
		foreach($builder_location as $val) {
		$user_location = new UserLocation ;
		$user_location->user_id = $user_id;
		$user_location->user_type = $user_type;
		$user_location->state_id = $val;
		$user_location->save();
		}
		 

		Session::flash('save_message', 'User detail has been saved');

		return redirect()->back();
		
		}
		
		}
	}
	
	public function delete_user($user_id)
	{
		$user = User::find($user_id);    
		if($user->delete())
		{
			$user = UserDetail::find($user_id);  
			UserDetail::where('user_id', $user_id)->delete();
			UserLocation::where('user_id', $user_id)->delete();
			Session::flash('delete_message', 'User detail has been deleted');
			return redirect()->back();
		}
	}
	

} 
