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
use App\CategoryDetail;


class categoryController extends Controller
{

	public function get_partner()
	{
		$where_arr = array('user_type'=>'partner');
		
		$results = User::with('partners')->where($where_arr)->get();
		//$results = User::where($where_arr)->builders;

		$data['brokers_arr'] = $results->toArray();
		$data['title'] = "Category Partner";
		return view(AdminTemplate::view('pages.category'), $data);
	}
	
	public function edit_parnter($partner_id)
	{
		$results = CategoryDetail::where(['partner_id' => $partner_id])->first();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['partner_arr'] = $results->toArray();
		$states = State::all();
		$data['states_arr'] = $states->toArray();
		
		$user_location = UserLocation::where(['user_id' => $partner_id])->get();
		//$results = User::with('builders')->where($where_arr)->get();
		$loc_arr = $user_location->toArray();
		$location_arr = [];
		foreach($loc_arr as $loc_val)
		{
			$location_arr[]  = $loc_val['state_id'];
		}
		$data['location_arr'] = $location_arr;
		$data['title'] = "Edit Category partner";
		
		return view(AdminTemplate::view('pages.edit_category_partner'), $data);
	}
	
	public function update_parnter($partner_id, Request $request)
	{
			$input = Input::all();
	//dd($input);
		$rules = array(
		'partner_location' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/partner/edit/'.$partner_id)
				->withErrors($validator); // send back all errors to the login form
		} else {
		 $partner = CategoryDetail::where(['partner_id' => $partner_id])->first();
		/*  echo '<pre>';
		 print_r($builders);
		 die;   */
		 
		 if(!empty(Input::file('partner_logo'))) {
		  if (Input::file('partner_logo')->isValid()) {
		  $destinationPath = 'uploads/partner_logo'; // upload path
		  $extension = Input::file('partner_logo')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'.'.$extension; // renameing image
		  Input::file('partner_logo')->move($destinationPath, $fileName); // uploading file to given path
		  $partner->logo = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
			
		 $partner->firstname = $_POST['firstname'];
		 $partner->lastname = $_POST['lastname'];
		 $partner->address = $_POST['address'];
		 $partner->company_name = $_POST['company_name'];
		 $partner->phn_no = $_POST['phn_no'];
		 $partner->partner_desc = $_POST['partner_desc'];
		 $partner->link = $_POST['link'];
		 $partner->established = $_POST['established'];



         $partner->save();
		 $user_type = 'partner';
		 $where_arr = array('user_type'=>$user_type,'user_id'=>$partner_id);
		 UserLocation::where($where_arr)->delete();
		 $partner_location  = $_POST['partner_location'];
		$user_location = new UserLocation ;
		foreach($partner_location as $val) {
		$user_location = new UserLocation ;
		$user_location->user_id = $partner_id;
		$user_location->user_type = $user_type;
		$user_location->state_id = $val;
		$user_location->save();
		}
		Session::flash('update_message', 'Partner detail has been updated');

		return redirect()->back();
		
		}
	}
	
	
	public function create_partner()
	{
		$data['title'] = "Create Partner";
		$states = State::all();
		$data['states_arr'] = $states->toArray();
		return view(AdminTemplate::view('pages.edit_category_partner'), $data);
	}
	
	public function add_parnter()
	{
	
		/* echo '<pre>';
		print_r($_POST['builder_location']);
		die; */
		$input = Input::all();
	//dd($input);
		$rules = array(
		'email'    => 'required|email|unique:users', // make sure the email is an actual email
		//'password' => 'required|alphaNum|min:6', // password can only be alphanumeric and has to be greater than 3 characters
		'partner_location' => 'required', // password can only be alphanumeric and has to be greater than 3 characters
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/category_partner/create_partner')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		}
		else {
		
		$user_type = 'partner';
		$user = new User;
		$user->email = $_POST['email'];
		//$user->password = bcrypt($_POST['password']);
		$user->user_type = $user_type;
		if($user->save())
		{
		
		$partner_id	 =	$user->id;
		$partner = new CategoryDetail;
	
		 if(!empty(Input::file('partner_logo'))) {
		  if (Input::file('partner_logo')->isValid()) {
			  $destinationPath = 'uploads/partner_logo'; // upload path
			  $extension = Input::file('partner_logo')->getClientOriginalExtension(); // getting image extension
			  $fileName = rand(11111,99999).'.'.$extension; // renameing image
			  Input::file('partner_logo')->move($destinationPath, $fileName); // uploading file to given path
			  $partner->logo = $fileName;
			  // sending back with message
			 // Session::flash('success', 'Upload successfully'); 
			  //return Redirect::to('upload');
			}
		}
		
		$partner->partner_id = $partner_id;	
		$partner->firstname = $_POST['firstname'];
		$partner->lastname = $_POST['lastname'];
		$partner->address = $_POST['address'];
		$partner->company_name = $_POST['company_name'];
		$partner->phn_no = $_POST['phn_no'];
		$partner->partner_desc = $_POST['partner_desc'];
		$partner->link = $_POST['link'];
		$partner->established = $_POST['established'];

        $partner->save();

		$partner_location  = $_POST['partner_location'];
		$user_location = new UserLocation ;
		foreach($partner_location as $val) {
			$user_location = new UserLocation ;
			$user_location->user_id = $partner_id;
			$user_location->user_type = $user_type;
			$user_location->state_id = $val;
			$user_location->save();
		}
		
		Session::flash('save_message', 'Partner detail has been saved');

		return redirect()->back();
		
		}
		
		}
	}
	
	public function delete_partner($partner_id)
	{
		$user = User::find($partner_id);    
		if($user->delete())
		{
			CategoryDetail::where('partner_id', $partner_id)->delete();
			UserLocation::where('user_id', $partner_id)->delete();
			Session::flash('delete_message', 'Partner Detail has been deleted');
			return redirect()->back();
		}
	}
	

} 