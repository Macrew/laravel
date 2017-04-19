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
use App\AddManagement;
use Auth;
use DB;
use Mail;
use Response;


class addController extends Controller
{
	public function index(){
		$user = Auth::user();
		$user_id = $user->id;
		$data['title'] = 'Add Management';
		$data['adds'] = AddManagement::getaddbyuser($user_id);
		return view('add_management.add_management',$data);
	}
	
	public function createadd(){
		$data['title'] = 'Create Add';
		//$data['property'] = Property::getproprtybyuser($user_id);
		return view('add_management.create_add',$data);
	}
	
	public function postadd(){
		$input = Input::all();
		//dd($input);
		$rules = array(
			'headline'    => 'required',
			'add_text' => 'required',
			'add_size' => 'required',
			'start_date' => 'required',
			'end_date' => 'required'
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('addmanagement/createadd')
				->withErrors($validator) // send back all errors to the login form
				->withInput(); // send back the input so that we can repopulate the form
		}
		else{
				$data = AddManagement::create_add($input);
				//echo '<pre>';print_r($data);die('asdf');
				if($data == 'Failure'){
					return Redirect::to('addmanagement/createadd')->withInput()->with('message', 'Not able to save information, please try again.');
				}else{
					\Session::flash('success', 'Add has been saved.');
					return redirect("addmanagement");
				}
			
		}
	}
	
	public function editadd($id){
		$data['title'] = 'Edit Property';
		$add = AddManagement::getaddbyid($id);
		$data['add'] = $add;
		return view('add_management.editadd',$data);
	}
	
	public function editaddpost($id){
		$input = Input::all();
		//dd($input);
		$rules = array(
			'headline'    => 'required',
			'add_text' => 'required',
			'add_size' => 'required',
			'start_date' => 'required',
			'end_date' => 'required'
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('addmanagement/createadd')
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
			$start = date_create($_POST['start_date']);
			$start_date = date_format($start,"Y-m-d");
			$end = date_create($_POST['end_date']);
			$end_date = date_format($end,"Y-m-d");
			$add->headline		= $_POST['headline'];
			$add->add_text		= $_POST['add_text'];
			$add->add_size 		= $_POST['add_size'];
			$add->start_date 	= $start_date;
			$add->end_date		= $end_date;
			$add->save();
			Session::flash('success', 'Add has been saved.');
			return redirect("/addmanagement/editadd/$id");			
		}
	}
	
	public function deleteadd($id){
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
		
		Session::flash('success', 'Ads & its content has been deleted successfully.');
		return redirect()->back();
	}
	
}
