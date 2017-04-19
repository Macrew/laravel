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
use App\State;
use App\UserLocation;
use App\BrokerDetail;


class BrokerController extends Controller
{

	public function get_brokers()
	{
		$where_arr = array('user_type'=>'Broker');
		
		$results = User::with('brokers')->where($where_arr)->get();
		//$results = User::where($where_arr)->builders;

		$data['brokers_arr'] = $results->toArray();
		$data['title'] = "Mortgage Brokers";
		return view(AdminTemplate::view('pages.brokers'), $data);
	}
	
	public function edit_broker($broker_id)
	{
		$results = BrokerDetail::where(['broker_id' => $broker_id])->first();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['landestate_arr'] = $results->toArray();
		$states = State::all();
		$data['states_arr'] = $states->toArray();
		
		$user_location = UserLocation::where(['user_id' => $broker_id])->get();
		//$results = User::with('builders')->where($where_arr)->get();
		$loc_arr = $user_location->toArray();
		foreach($loc_arr as $loc_val)
		{
			$location_arr[]  = $loc_val['state_id'];
		}
		
		$data['location_arr'] = $location_arr;
		$data['title'] = "Edit land Estate";
		
		return view(AdminTemplate::view('pages.edit_broker'), $data);
	}
	
	public function update_broker($broker_id, Request $request)
	{
			$input = Input::all();
	//dd($input);
		$rules = array(
		'broker_location' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/broker/edit/'.$broker_id)
				->withErrors($validator); // send back all errors to the login form
		} else {
		 $broker = BrokerDetail::where(['broker_id' => $broker_id])->first();
		/*  echo '<pre>';
		 print_r($builders);
		 die;   */
		 
		 if(!empty(Input::file('broker_logo'))) {
		  if (Input::file('broker_logo')->isValid()) {
		  $destinationPath = 'uploads/broker_logo'; // upload path
		  $extension = Input::file('broker_logo')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'.'.$extension; // renameing image
		  Input::file('broker_logo')->move($destinationPath, $fileName); // uploading file to given path
		  $broker->logo = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
			
		 $broker->firstname = $_POST['firstname'];
		 $broker->lastname = $_POST['lastname'];
		 $broker->address = $_POST['address'];
		 $broker->company_name = $_POST['company_name'];
		 $broker->phn_no = $_POST['phn_no'];
		 $broker->broker_desc = $_POST['broker_desc'];
		 $broker->established = $_POST['established'];



         $broker->save();
		 $user_type = 'Broker';
		 $where_arr = array('user_type'=>$user_type,'user_id'=>$broker_id);
		 UserLocation::where($where_arr)->delete();
		 $broker_location  = $_POST['broker_location'];
		$user_location = new UserLocation ;
		foreach($broker_location as $val) {
		$user_location = new UserLocation ;
		$user_location->user_id = $broker_id;
		$user_location->user_type = $user_type;
		$user_location->state_id = $val;
		$user_location->save();
		}
		Session::flash('update_message', 'Broker detail has been updated');

		return redirect()->back();
		
		}
	}
	
	
	public function create_broker()
	{
		$data['title'] = "Create broker";
		$states = State::all();
		$data['states_arr'] = $states->toArray();
		return view(AdminTemplate::view('pages.edit_broker'), $data);
	}
	
	public function add_broker()
	{
	
		/* echo '<pre>';
		print_r($_POST['builder_location']);
		die; */
		$input = Input::all();
	//dd($input);
		$rules = array(
		'email'    => 'required|email|unique:users', // make sure the email is an actual email
		//'password' => 'required|alphaNum|min:6', // password can only be alphanumeric and has to be greater than 3 characters
		'broker_location' => 'required', // password can only be alphanumeric and has to be greater than 3 characters
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/broker/create')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		}
		else {
		
		$user_type = 'Broker';
		$user = new User;
		$user->email = $_POST['email'];
		//$user->password = bcrypt($_POST['password']);
		$user->user_type = $user_type;
		if($user->save())
		{
		
		$broker_id	 =	$user->id;
		$broker = new BrokerDetail;
	
		 if(!empty(Input::file('broker_logo'))) {
		  if (Input::file('broker_logo')->isValid()) {
		  $destinationPath = 'uploads/broker_logo'; // upload path
		  $extension = Input::file('broker_logo')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'.'.$extension; // renameing image
		  Input::file('broker_logo')->move($destinationPath, $fileName); // uploading file to given path
		  $broker->logo = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		$broker->broker_id = $broker_id;	
		 $broker->firstname = $_POST['firstname'];
		 $broker->lastname = $_POST['lastname'];
		 $broker->address = $_POST['address'];
		 $broker->company_name = $_POST['company_name'];
		 $broker->phn_no = $_POST['phn_no'];
		 $broker->broker_desc = $_POST['broker_desc'];
		 $broker->established = $_POST['established'];

        $broker->save();

		 $broker_location  = $_POST['broker_location'];
		$user_location = new UserLocation ;
		foreach($broker_location as $val) {
		$user_location = new UserLocation ;
		$user_location->user_id = $broker_id;
		$user_location->user_type = $user_type;
		$user_location->state_id = $val;
		$user_location->save();
		}
		
		Session::flash('save_message', 'Broker detail has been saved');

		return redirect()->back();
		
		}
		
		}
	}
	
	public function delete_broker($broker_id)
	{
		$user = User::find($broker_id);    
		if($user->delete())
		{
			BrokerDetail::where('broker_id', $broker_id)->delete();
			UserLocation::where('user_id', $broker_id)->delete();
			Session::flash('delete_message', 'Broker Detail has been deleted');
			return redirect()->back();
		}
	}
	

} 