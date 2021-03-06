<?php
//namespace vendor\Mailchimp;
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
use App\Models\SaveInclusion;
use App\Models\SaveProperty;
use App\Instagram\InstagramClass;
//use Mayoz\Instagram\Facades\Instagram;
//use Mayoz\Instagram\InstagramManager;
//use Mayoz\Instagram\InstagramServiceProvider;

//use Mailchimp;

class Home extends Controller
{
	protected $subscriptionHandler;

	public function __construct()
	{
		//$this->subscriptionHandler = new Mailchimp($this);
	}
	public function subscribe(request $request)
	{
		//dd($request->all());die;
		//$email['email'] = $_POST['email'];
		
		//return $this->subscriptionHandler->subscribe($request);
	}
	public function index(){
		$data['title'] = 'Home';
		if( Auth::check() ){
			$user = Auth::user();
			$userdata = User::getuserinfo($user->id);
			//$results = User::with('builders')->where($where_arr)->get();
			//$data['userdata'] = $userdata;
			$data['session'] = $userdata;
		}
		$header_state = Session::get('header_state');
		$headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
		$data['build_location'] = State::where(['state_name' => $headr_state])->get();
		
		//$results = Property::with('builder_detail','property_gallery')->where('featured','Yes')->limit(6)->get();
		$results = DB::table('property')
					->join('builder_details', 'property.user_id', '=', 'builder_details.builder_id')
					->join('users_locations', 'property.user_id', '=', 'users_locations.user_id')
					->join('states', 'users_locations.state_id', '=', 'states.id')
					->distinct('states.state_name')
					->where(array('property.featured'=>'Yes','states.state_name'=>$headr_state,'status'=>1,'builder_details.trash'=>'no','property.property_type'=>'1'))
					->select('property.*', 'states.state_name','builder_details.logo','builder_details.builder_id')
					->limit(6)
					->orderBy('property.featured_order')
					->get();
		$prop_withimg = array();
		if(count($results) > 0){
			$i=0;
			foreach($results as $val){
				$prop_withimg[$i]['property']['builder_id'] = $val->builder_id;
				$prop_withimg[$i]['property']['id'] = $val->id;
				$prop_withimg[$i]['property']['logo'] = $val->logo;
				$prop_withimg[$i]['property']['bedrooms'] = $val->bedrooms;
				$prop_withimg[$i]['property']['bathrooms'] = $val->bathrooms;
				$prop_withimg[$i]['property']['living'] = $val->living;
				$prop_withimg[$i]['property']['housesize'] = $val->housesize;
				$prop_withimg[$i]['property']['property_title'] = $val->property_title;
				$prop_withimg[$i]['property']['price'] = $val->price;
				$prop_withimg[$i]['property']['statename'] = $val->state_name;
				$images_prop = DB::table('property_gallery')->where(array('property_id'=>$val->id))->get();
				$prop_withimg[$i]['property']['gallery'] = $images_prop;
				$i++;
			}
		}
		$data['prop_arr'] = $prop_withimg;
		
		$builderdetail = DB::table('builder_details')
            ->join('users_locations', 'builder_details.builder_id', '=', 'users_locations.user_id')
            ->join('states', 'users_locations.state_id', '=', 'states.id')
            ->distinct('states.state_name')
			->where(array('builder_details.trash'=>'no'))
            ->select('builder_details.*', 'states.state_name')
            ->get();
        $prop_arr = array();
        $states = DB::table('states')->select('state_name')->distinct('states.state_name')->get();
		//$builderdetail = BuilderDetail::get();
		
		foreach($states as $val){
			$i=0;
			foreach($builderdetail as $propval){
				if($propval->state_name == $headr_state){
					if($propval->featured == 'Yes'){
						$prop_arr[$i] = $propval;
					}
				}
				$i++;
			}
		}
		//echo '<pre>'; print_r($builderdetail); echo '</pre>';
		//echo '<pre>'; print_r($prop_arr); echo '</pre>';die;
		$states = State::all();
			$states_arr = $states->toArray();
			$states = array();
			foreach($states_arr as $state_val) { 
				$states[$state_val['id']] = $state_val['loc_name'];
			}
		$data['states_arr'] = $states;
		$data['builderdetail']  = $prop_arr;
		Session::forget('reset_string');
		return view('home',$data);
	}
	//Function for showing login page
	public function login(){
		if (Auth::check()){
			$data['title'] = 'Home';
			$header_state = Session::get('header_state');
			$headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
			$data['build_location'] = State::where(['state_name' => $headr_state])->get();
			//$results = Property::with('builder_detail','property_gallery')->where('featured','Yes')->limit(6)->get();
		$results = DB::table('property')
					->join('builder_details', 'property.user_id', '=', 'builder_details.builder_id')
					->join('users_locations', 'property.user_id', '=', 'users_locations.user_id')
					->join('states', 'users_locations.state_id', '=', 'states.id')
					->distinct('states.state_name')
					->where(array('property.featured'=>'Yes','states.state_name'=>$headr_state,'status'=>1,'builder_details.trash'=>'no'))
					->select('property.*', 'states.state_name','builder_details.logo','builder_details.builder_id')
					->limit(6)
					->orderBy('property.featured_order')
					->get();
		$prop_withimg = array();
		if(count($results) > 0){
			$i=0;
			foreach($results as $val){
				$prop_withimg[$i]['property']['builder_id'] = $val->builder_id;
				$prop_withimg[$i]['property']['id'] = $val->id;
				$prop_withimg[$i]['property']['logo'] = $val->logo;
				$prop_withimg[$i]['property']['bedrooms'] = $val->bedrooms;
				$prop_withimg[$i]['property']['bathrooms'] = $val->bathrooms;
				$prop_withimg[$i]['property']['living'] = $val->living;
				$prop_withimg[$i]['property']['housesize'] = $val->housesize;
				$prop_withimg[$i]['property']['property_title'] = $val->property_title;
				$prop_withimg[$i]['property']['price'] = $val->price;
				$prop_withimg[$i]['property']['statename'] = $val->state_name;
				$images_prop = DB::table('property_gallery')->where(array('property_id'=>$val->id))->get();
				$prop_withimg[$i]['property']['gallery'] = $images_prop;
				$i++;
			}
		}
		$data['prop_arr'] = $prop_withimg;
		
		$builderdetail = DB::table('builder_details')
            ->join('users_locations', 'builder_details.builder_id', '=', 'users_locations.user_id')
            ->join('states', 'users_locations.state_id', '=', 'states.id')
            ->distinct('states.state_name')
			->where(array('builder_details.trash'=>'no'))
            ->select('builder_details.*', 'states.state_name')
            ->get();
        $prop_arr = array();
        $states = DB::table('states')->select('state_name')->distinct('states.state_name')->get();
		//$builderdetail = BuilderDetail::get();
		
		foreach($states as $val){
			$i=0;
			foreach($builderdetail as $propval){
				if($propval->state_name == $headr_state){
					if($propval->featured == 'Yes'){
						$prop_arr[$i] = $propval;
					}
				}
				$i++;
			}
		}
		//echo '<pre>'; print_r($builderdetail); echo '</pre>';
		//echo '<pre>'; print_r($prop_arr); echo '</pre>';die;
		$data['builderdetail']  = $prop_arr;
			return view('home',$data);
		}else{
			$data['title'] = 'Login';
			return view('login',$data);
		}
	}
	
	//Function for showing builder login page
	public function builderlogin(){
		if (Auth::check()){
			$data['title'] = 'Home';
			$header_state = Session::get('header_state');
			$headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
			$data['build_location'] = State::where(['state_name' => $headr_state])->get();
					$results = DB::table('property')
					->join('builder_details', 'property.user_id', '=', 'builder_details.builder_id')
					->join('users_locations', 'property.user_id', '=', 'users_locations.user_id')
					->join('states', 'users_locations.state_id', '=', 'states.id')
					->distinct('states.state_name')
					->where(array('property.featured'=>'Yes','states.state_name'=>$headr_state,'status'=>1,'builder_details.trash'=>'no'))
					->select('property.*', 'states.state_name','builder_details.logo','builder_details.builder_id')
					->limit(6)
					->orderBy('property.featured_order')
					->get();
		$prop_withimg = array();
		if(count($results) > 0){
			$i=0;
			foreach($results as $val){
				$prop_withimg[$i]['property']['builder_id'] = $val->builder_id;
				$prop_withimg[$i]['property']['id'] = $val->id;
				$prop_withimg[$i]['property']['logo'] = $val->logo;
				$prop_withimg[$i]['property']['bedrooms'] = $val->bedrooms;
				$prop_withimg[$i]['property']['bathrooms'] = $val->bathrooms;
				$prop_withimg[$i]['property']['living'] = $val->living;
				$prop_withimg[$i]['property']['housesize'] = $val->housesize;
				$prop_withimg[$i]['property']['property_title'] = $val->property_title;
				$prop_withimg[$i]['property']['price'] = $val->price;
				$prop_withimg[$i]['property']['statename'] = $val->state_name;
				$images_prop = DB::table('property_gallery')->where(array('property_id'=>$val->id))->get();
				$prop_withimg[$i]['property']['gallery'] = $images_prop;
				$i++;
			}
		}
		$data['prop_arr'] = $prop_withimg;
		
		$builderdetail = DB::table('builder_details')
            ->join('users_locations', 'builder_details.builder_id', '=', 'users_locations.user_id')
            ->join('states', 'users_locations.state_id', '=', 'states.id')
            ->distinct('states.state_name')
			->where(array('builder_details.trash'=>'no'))
            ->select('builder_details.*', 'states.state_name')
            ->get();
        $prop_arr = array();
        $states = DB::table('states')->select('state_name')->distinct('states.state_name')->get();
		//$builderdetail = BuilderDetail::get();
		
		foreach($states as $val){
			$i=0;
			foreach($builderdetail as $propval){
				if($propval->state_name == $headr_state){
					if($propval->featured == 'Yes'){
						$prop_arr[$i] = $propval;
					}
				}
				$i++;
			}
		}
		//echo '<pre>'; print_r($builderdetail); echo '</pre>';
		//echo '<pre>'; print_r($prop_arr); echo '</pre>';die;
		$data['builderdetail']  = $prop_arr;
			return view('home',$data);
		}else{
			$data['title'] = 'Builder Login';
			return view('builder_managment.builderlogin',$data);
		}
	}
	//Function for user login
	public function login_user(){
		
			$formFields = Input::all('formData');
    //parse_str($inputData, $formFields);  
    $userData = array(
      'email'      => $formFields['email'],
      'password'     =>  $formFields['password'],
    );
   $rules = array(
			'email'    => 'required|email', // make sure the email is an actual email
			'password' => 'required|alphaNum|min:6', // password can only be alphanumeric and has to be greater than 3 characters
		);

    $validator = Validator::make($userData,$rules);
    if($validator->fails())
        return Response::json(array(
            'fail' => true,
            'errors' => $validator->getMessageBag()->toArray()
        ));

		else{
		
		$data=array(
				'email'=>$formFields['email'],
				'password'=>$formFields['password'],
				'status'=>'Active',
			);
			if(Auth::attempt($data)){
				\Session::flash('success', 'You are Logged in !!!');
				 return Response::json(array(
          'success' => true
        ));
			}
			else{
				//\Session::flash('error', 'Invalid UserName and Password');
				 return Response::json(array(
          'regfail' => true
          
        ));
			}
		

			}
		
		
		
	}
	
	//Function for user login
	public function builder_login(){
		$input = Input::all();
		//dd($input);
		$rules = array(
			'username'    => 'required',
			'password' => 'required|alphaNum|min:6', // password can only be alphanumeric and has to be greater than 3 characters
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				echo 'validation_error';
		}
		else{
			$data=array(
				'username'=>$_POST['username'],
				'password'=>$_POST['password'],
				'status'=>'Active',
			);
			if(Auth::attempt($data)){
				\Session::flash('success', 'You are Logged in !!!');
				return 'success';
			}
			else{
				echo 'error_usernamepass';
			}
		}
		//return view('login',$data);
	}
	//Function for showing register page
	public function register(){
		if (Auth::check()){
			$data['title'] = 'Home';
			$header_state = Session::get('header_state');
			$headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
			$data['build_location'] = State::where(['state_name' => $headr_state])->get();
			return view('home',$data);
		}else{
			$states = State::all();
			$data['title'] = 'Register';
			$states_arr = $states->toArray();
			$states = array();
			foreach($states_arr as $state_val) { 
				$states[$state_val['id']] = $state_val['loc_name'];
			}
			$data['states_arr'] = $states;
			//echo '1<pre>'; print_r($data); echo '</pre>';die;
			return view('register',$data);
		}
	}
	
	//Function for register user
	public function register_user1(){
	
		/*echo '<pre>';
		print_r($_POST);
		die;*/
		$input = Input::all();
		//dd($input);
		$rules = array(
			'email'    => 'required|email|unique:users',
			'password' => 'required|alphaNum|min:6', // password can only be alphanumeric and has to be greater than 3 characters
			'firstname' => 'required',
			'lastname' => 'required',
			'user_location' => 'required',
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('/register')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		}
		else{
				$data = User::registerUser($input);
				if($data == 'Success'){
					\Mail::send('emails.register',
						array(
							'username' => $_POST['email'],
							'password' => $_POST['password']
						), function($message)
					{
						$message->from('admin@icomparebuilders.com');
						$message->to($_POST['email'], 'Admin')->subject('icompareBuilders - Thanks you for registering.');
					});
					\Session::flash('success', 'User detail has been saved. Please login to use your account.');
					return redirect('login');
				}else if($data == 'Failure'){
					return Redirect::to('/register')->withInput(Input::except('password'))->with('message', 'Login Failed');;
				}
			}
	}
	
	public function register_user(){
	
		$inputData = Input::get('formData');
    parse_str($inputData, $formFields);  
    $userData = array(
      'email'      => $formFields['email'],
      'password'     =>  $formFields['password'],
      'firstname'  =>  $formFields['firstname'],
      'lastname' =>  $formFields['lastname'],
      'user_location' =>  $formFields['user_location'],
    );
    $rules = array(
			'email'    => 'required|email|unique:users',
			'password' => 'required|alphaNum|min:6', // password can only be alphanumeric and has to be greater than 3 characters
			'firstname' => 'required',
			'lastname' => 'required',
			'user_location' => 'required',
		);
    $validator = Validator::make($userData,$rules);
    if($validator->fails())
        return Response::json(array(
            'fail' => true,
            'errors' => $validator->getMessageBag()->toArray()
        ));

		else{
				$data = User::registerUser($formFields);
				$email_data = array('username'=>$formFields['email'],'password' => $formFields['password']);
				if($data == 'Success'){
					\Mail::send('emails.register',
						$email_data, function($message)  use ($email_data) 
					{
						$message->from('admin@icomparebuilders.com');
						$message->to($email_data['username'], 'Admin')->subject('icompareBuilders - Thanks you for registering.');
					});
					
					 return Response::json(array(
          'success' => true,
          'email' => $userData['email'],
        ));
			} else if($data == 'Failure'){
					 return Response::json(array(
          'regfail' => true,
          'email' => $userData['email'],
        ));
				}
			}
	}
	
	
	    
	
	//Function for logout user
	public function logout(){
		$user_ip =  request()->ip();
		SaveProperty::where(array('user_ip'=>$user_ip,'type'=>'Save'))->delete();
		SaveInclusion::where(array('user_ip'=>$user_ip))->delete();
		/* \$oauth = new \Hybrid_Auth(base_path().'/app/config/fb_Auth.php');
		$oauth->logoutAllProviders(); */
		 $user = Auth::user();
		if($user)
		{
			$userdata = App\User::getuserinfonew($user->id);	
		}

		if(!empty($userdata->login_type)) {
		if($userdata->login_type == 'Facebook') {
			$base_url = url()."/vendor/hybridauth/hybridauth/hybridauth/";
			$config= array(
			"base_url" => $base_url,
			"providers" => array (
			"Facebook" => array (
			"enabled" => true,
			"keys" => array ( "id" => "1717789908460439", "secret" => "3d973c1e21f8e44a25601a2095090fd5" ),
			"scope" => "public_profile,email", // optional
			"display" => "popup", // optional
				  
			)
			)
			);
			$oauth = new \Hybrid_Auth($config); 
			$oauth->logoutAllProviders();
			}
		} 
		Session::flush();
		Auth::logout();
        return redirect('/');
	}
	
	//Function for forgotpassword
	public function forgotpassword(){
		if (Auth::check()){
			$data['title'] = 'Home';
			$header_state = Session::get('header_state');
			$headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
			$data['build_location'] = State::where(['state_name' => $headr_state])->get();
					$results = DB::table('property')
					->join('builder_details', 'property.user_id', '=', 'builder_details.builder_id')
					->join('users_locations', 'property.user_id', '=', 'users_locations.user_id')
					->join('states', 'users_locations.state_id', '=', 'states.id')
					->distinct('states.state_name')
					->where(array('property.featured'=>'Yes','states.state_name'=>$headr_state,'status'=>1,'builder_details.trash'=>'no'))
					->select('property.*', 'states.state_name','builder_details.logo','builder_details.builder_id')
					->limit(6)
					->orderBy('property.featured_order')
					->get();
		$prop_withimg = array();
		if(count($results) > 0){
			$i=0;
			foreach($results as $val){
				$prop_withimg[$i]['property']['builder_id'] = $val->builder_id;
				$prop_withimg[$i]['property']['id'] = $val->id;
				$prop_withimg[$i]['property']['logo'] = $val->logo;
				$prop_withimg[$i]['property']['bedrooms'] = $val->bedrooms;
				$prop_withimg[$i]['property']['bathrooms'] = $val->bathrooms;
				$prop_withimg[$i]['property']['living'] = $val->living;
				$prop_withimg[$i]['property']['housesize'] = $val->housesize;
				$prop_withimg[$i]['property']['property_title'] = $val->property_title;
				$prop_withimg[$i]['property']['price'] = $val->price;
				$prop_withimg[$i]['property']['statename'] = $val->state_name;
				$images_prop = DB::table('property_gallery')->where(array('property_id'=>$val->id))->get();
				$prop_withimg[$i]['property']['gallery'] = $images_prop;
				$i++;
			}
		}
		$data['prop_arr'] = $prop_withimg;
		
		$builderdetail = DB::table('builder_details')
            ->join('users_locations', 'builder_details.builder_id', '=', 'users_locations.user_id')
            ->join('states', 'users_locations.state_id', '=', 'states.id')
            ->distinct('states.state_name')
			->where(array('builder_details.trash'=>'no'))
            ->select('builder_details.*', 'states.state_name')
            ->get();
        $prop_arr = array();
        $states = DB::table('states')->select('state_name')->distinct('states.state_name')->get();
		//$builderdetail = BuilderDetail::get();
		
		foreach($states as $val){
			$i=0;
			foreach($builderdetail as $propval){
				if($propval->state_name == $headr_state){
					if($propval->featured == 'Yes'){
						$prop_arr[$i] = $propval;
					}
				}
				$i++;
			}
		}
		//echo '<pre>'; print_r($builderdetail); echo '</pre>';
		//echo '<pre>'; print_r($prop_arr); echo '</pre>';die;
		$data['builderdetail']  = $prop_arr;
			return view('home',$data);
		}else{
			$data['title'] = 'Forgot Password';
			return view('forgotpassword',$data);
		}
	}
	
	public function forgotpasswordpost(Request $request){
		$input = Input::all();
		//dd($input);
		$rules = array(
			'email'    => 'required|email'
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('/forgotpassword')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		}
		else{
			$user = DB::table('users')->where('email', $_POST['email'])->first();
			if(count($user) >0){
				$response = Password::sendResetLink($request->only('email'), function($mailer){ $mailer->subject('Reset Password'); });
				

				switch ($response)
				{
					case PasswordBroker::RESET_LINK_SENT:
						if($user->user_type=='Builder'){
							\Session::flash('success', 'Your password has been reset successfully!');
							return redirect('/');
						}else{
							\Session::flash('success', 'Your password has been reset successfully!');
							return redirect('/');
						}

					case PasswordBroker::INVALID_USER:
						return redirect()->back()->withErrors(['message' => trans($response)]);
				}
			}else{
				\Session::flash('error', 'Entered email does not exists.');
				return Redirect::to('/forgotpassword')->withInput();
			}
		}
	}
	public function password_reset($token){
		$user = DB::table('password_resets')->where('token', $token)->first();
		if(count($user) >0){
			$data['title'] = 'Reset Password';
			$data['token'] = $token;
			return view('resetpassword',$data);
		}else{
				return Redirect::to('/forgotpassword')->withInput()->with('message', 'Token mismatch. Please try again');;
		}
		
	}
	
	public function savereset_password($token){
		$formFields = Input::all('formData');
		$userData = array(
		  'password'     =>  $formFields['password']
		);
		$rules = array(
			'password' => 'required|alphaNum|min:6', // password can only be alphanumeric and has to be greater than 3 characters
		);
		$validator = Validator::make($userData,$rules);
		if($validator->fails()){
			//Redirect::back()
			return Redirect::back()
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password'));
		}else{
			$user = DB::table('password_resets')->where('token', $token)->first();
			$userdata = DB::table('users')->where('email', $user->email)->first();
			DB::table('users')->where('email', $user->email)->update(['password' => bcrypt($_POST['password'])]);
			DB::table('password_resets')->where('token', $token)->delete();
			if($userdata->user_type=='Builder'){
				\Session::flash('success', 'Password has been reset. Please login to use your account.');
				return redirect('builderlogin');
			}else{
				\Session::flash('success', 'Password has been reset. Please login to use your account.');
				return redirect('login');
			}

		}
	}
	
	public function getLoginFacebook($auth=NULL)
	{
		if($auth=='auth') {
		try {
		\Hybrid_Endpoint::process();
		} catch (Exception $e) {
		return Redirect::to("fbAuth");
		}
		return;
		}
		$base_url = env('FACEBOOK_REDIRECT_URI');
		$config= array(
		"base_url" => $base_url,
		"providers" => array (
		"Facebook" => array (
		"enabled" => true,
		"keys" => array ( "id" => env('FACEBOOK_KEY'), "secret" => env('FACEBOOK_SECRET') ),
		"scope" => "public_profile,email", // optional
		"display" => "popup", // optional
			  
		)
		)
		);
		$oauth=new \Hybrid_Auth($config);
		$provider=$oauth->authenticate("Facebook");
		$profile=$provider->getUserProfile();
		//var_dump($profile);
		//echo "FirstName:".$profile->firstName."<br>";
		//echo "Email:".$profile->email;
		$email = $profile->email;
		
		/* Check If user exist then login		*/
		
		$user  = User::where('email',$email);
		if($user->count() == 1)
		{
			$user = 	$user->first();		
			Auth::login($user);
			$logged_user_data = Auth::user();
					if($logged_user_data){
						\Session::flash('success', 'You are Logged in with Facebook!!!');
						return redirect('/');
					}
					else{
						Session::flash('error', 'Invalid Login');
						return redirect('/');
					}
			} else {
			
			/* Check If user not exist then register then login 		*/
			$firstname = !empty($profile->firstName)?$profile->firstName:"";
			$lastname = !empty($profile->lastName)?$profile->lastName:"";
			$email = !empty($profile->email)?$profile->email:"";
			$phone = !empty($profile->phone)?$profile->phone:"";
			$login_type = "Facebook";
			
			$user_data = array('email'=>$email,'firstname'=>$firstname,'lastname'=>$lastname,'email'=>$email,'phone'=>$phone,'login_type'=>$login_type);
			
			$data = User::register_facebook_user($user_data);
				if($data == 'Success'){
				
				$user  = User::where('email',$email);
				$user = 	$user->first();		
				Auth::login($user);
				$logged_user_data = Auth::user();
				if($logged_user_data){
					\Session::flash('success', 'You are Logged in with Facebook!!!');
					return redirect('/');
				}
				else{
					Session::flash('error', 'Invalid Login');
					return redirect('/');
				}

				}else if($data == 'Failure'){
					//return Redirect::to('/register')->withInput(Input::except('password'))->with('message', 'Login Failed');;
				} 
	
		}

	}

	public function getLoginInstagram()
	{

		//require app_path().'/instagram/instagram.class.php';

	 $instagram = new InstagramClass(array(
		'apiKey'      => env('INSTAGRAM_KEY'),
		'apiSecret'   => env('INSTAGRAM_SECRET'),
		'apiCallback' => env('INSTAGRAM_REDIRECT_URI'),
	  ));
	 
	if(isset($_GET['code'])) {
		$code = $_GET['code'];
		$data = $instagram->getOAuthToken($code);
		if(!empty($data->user))
		{
			$username = $data->user->username;
			$full_name = $data->user->full_name;
			$user  = User::where('username',$username);
			if($user->count() == 1)
			{
			$user = 	$user->first();		
			Auth::login($user);
			$logged_user_data = Auth::user();
					if($logged_user_data){
						\Session::flash('success', 'You are Logged in with Facebook!!!');
						return redirect('/');
					}
					else{
						Session::flash('error', 'Invalid Login');
						return redirect('/');
					}
			} else {
			
			/* Check If user not exist then register then login 		*/
			$full_name = !empty($full_name)?$full_name:"";
			$username = !empty($username)?$username:"";
			$login_type = "Instagram";
			
			$user_data = array('firstname'=>$full_name,'username'=>$username ,'login_type'=>$login_type);
			
			$data = User::register_instagram_user($user_data);
				if($data == 'Success'){
				
				$user  = User::where('username',$username);
				$user = 	$user->first();		
				Auth::login($user);
				$logged_user_data = Auth::user();
				if($logged_user_data){
					\Session::flash('success', 'You are Logged in with Instagram!!!');
					return redirect('/');
				}
				else{
					Session::flash('error', 'Invalid Login');
					return redirect('/');
				}

				}else if($data == 'Failure'){
					//return Redirect::to('/register')->withInput(Input::except('password'))->with('message', 'Login Failed');;
				} 
	
		}
			
			
		}
	 
	}
	else
	{
		$loginUrl   = $instagram->getLoginUrl();
		echo "<a class=\"button\" href=\"$loginUrl\">Sign in with Instagram</a>";
	}

	}
	
	public function get_user_current_location()
	{
		//$ip = $_SERVER['REMOTE_ADDR'];
		$ip = '120.21.102.49';
		$key = env('GeoLocation_Key');
		$location_data = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$ip"));
		
		if(!empty($location_data)) {
		$state = $location_data['geoplugin_regionName'];
		//$main_states = array('QLD'=>'Queensland' ,'VIC'=>'Victoria','NSW'=>'New South Wales','WA'=>'Western Australia','TAS'=>'Tasmania','NT'=>'Northern Territory','ACT'=>'Australian Capital Territory','SA'=>'South Australia');
		//$main_states = array('QLD'=>'Queensland' ,'VIC'=>'Victoria','NSW'=>'New South Wales','WA'=>'Western Australia');
		$main_states = array('VIC'=>'Victoria');
		$main_text = array_search($state, $main_states);
		if(!empty($main_text)) {
			Session::set('header_state',$main_text);
			} else {
			$default_state = 'VIC';
			Session::set('header_state',$default_state);
			}
			
		}
		echo Session::get('header_state');
	}

	
}
