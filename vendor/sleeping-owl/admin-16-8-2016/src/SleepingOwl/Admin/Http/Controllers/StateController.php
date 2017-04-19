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

class StateController extends Controller
{

	public function get_states()
	{
		//$where_arr = array('user_type'=>'Builder');
		$states = State::all();

		$data['states_arr'] = $states->toArray();
		$data['title'] = "States";
		return view(AdminTemplate::view('pages.states'), $data);
	}
	
	public function edit_state($state_id)
	{
		$results = State::find($state_id);
		//$results = User::with('builders')->where($where_arr)->get();
		$data['states_arr'] = $results->toArray();
		$data['title'] = "Edit State";

		return view(AdminTemplate::view('pages.edit_state'), $data);
	}
	
	public function update_state($state_id, Request $request)
	{
		$input = Input::all();
	//dd($input);
		$rules = array(
		'loc_name'    => 'required', // make sure the email is an actual email
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/state/edit/'.$state_id)
				->withErrors($validator); // send back all errors to the login form
		} else {
		
		$states = State::find($state_id);
			
		 $states->state_name = $_POST['state_name'];
		 $states->loc_name = $_POST['loc_name'];
         $states->save();

		Session::flash('update_message', 'State has been updated');

		return redirect()->back();
		
		}
	}
	
	
	public function create_state()
	{
		$data['title'] = "Create State";
		return view(AdminTemplate::view('pages.edit_state'), $data);
	}
	
	public function add_state()
	{
	 $messsages = array(
        'loc_name.required'=>'The location name field is required.',
    );
		$input = Input::all();
	//dd($input);
		$rules = array(
		'loc_name'    => 'required', // make sure the email is an actual email
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules , $messsages);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/state/create')
				->withErrors($validator); // send back all errors to the login form
		}
		else {
		
		$state = new State;
		$state->state_name = $_POST['state_name'];
		$state->loc_name = $_POST['loc_name'];
	

        $state->save();
		
		Session::flash('save_message', 'State has been saved');

		return redirect()->back();
		
		}
		
		
	}
	
	public function delete_state($state_id)
	{
		$state = State::find($state_id);    
		if($state->delete())
		{
			Session::flash('delete_message', 'State has been deleted');
			return redirect()->back();
		}
	}
	

} 