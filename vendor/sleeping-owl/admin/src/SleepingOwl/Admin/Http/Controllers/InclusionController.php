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
use DB;
use SleepingOwl\Admin\Interfaces\FormInterface;
use SleepingOwl\Admin\Repository\BaseRepository;
use App\User;
use App\State;
use App\Inclusion;

class InclusionController extends Controller
{

	public function get_inclusions()
	{
		//$where_arr = array('user_type'=>'Builder');
		$inclusions = Inclusion::all();
	
		$data['inclusions_arr'] = $inclusions->toArray();
		$inc = Inclusion::where(['parent_id'=>'0'])->get();
		$data['inc_arr']  = $inc->toArray();
		
		$inc = Inclusion::where(['filter_inclusion'=>'Yes'])->get();
		$data['filter_inc_arr']  = $inc->toArray();
		
		$data['title'] = "Inclusions";
		return view(AdminTemplate::view('pages.inclusions'), $data);
	}
	
	public function edit_inclusion($inc_id)
	{
		$results = Inclusion::find($inc_id);
		//$results = User::with('builders')->where($where_arr)->get();
		$data['inc_arr'] = $results->toArray();
		$inclusions = Inclusion::where('parent_id','0')->get();
		$data['inclusions_arr'] = $inclusions->toArray();
		$data['title'] = "Edit Inclusion";

		return view(AdminTemplate::view('pages.edit_inclusion'), $data);
	}
	
	public function update_inclusion($inc_id, Request $request)
	{
		$input = Input::all();
	//dd($input);
		$rules = array(
		'title'    => 'required', // make sure the email is an actual email
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/inclusion/edit/'.$inc_id)
				->withErrors($validator); // send back all errors to the login form
		} else {
		
		$inclusion = Inclusion::find($inc_id);
		$title =  preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $_POST['title']);
		 $inclusion->parent_id = $_POST['parent_id'];
		 $inclusion->title = $title;
         $inclusion->save();

		Session::flash('update_message', 'Inclusion has been updated.');

		return redirect()->back();
		
		}
	}
	
	
	public function create_inclusion()
	{
		$data['title'] = "Create Inclusion";
		$inclusions = Inclusion::where('parent_id','0')->get();
		$data['inclusions_arr'] = $inclusions->toArray();
		
		
		
		return view(AdminTemplate::view('pages.edit_inclusion'), $data);
	}
	
	public function category_tree1($catid)
	{
		$inclusions_arr = DB::table('inclusions')
                    ->where('parent_id', $catid)
                    ->get();

	//$result = $conn->query($sql);

	foreach($inclusions_arr as $cat_val){
	$inc_html = "";

	$i = 0;
	if ($i == 0) echo '<ul>';
	if(!empty($cat_val->title)) {
	 echo '<li>' . $cat_val->title;
	 } else {
	 $cat_arr = DB::table('inclusions')
                    ->where('id', $cat_val->id)
                    ->get();
	  echo '<li>' . $cat_arr[0]->title;
	 }
	 $this->category_tree1($cat_val->id);
	 echo '</li>';
	$i++;
	 if ($i > 0) echo '</ul>';
	}
	
	}
	
	public function add_inclusion()
	{

		$input = Input::all();
	//dd($input);
		$rules = array(
		'title'    => 'required', // make sure the email is an actual email
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/inclusion/create')
				->withErrors($validator); // send back all errors to the login form
		}
		else {
		
		$inc = new Inclusion;
		$inc->title = $_POST['title'];
		$inc->parent_id = $_POST['parent_id'];
	

        $inc->save();
		
		Session::flash('save_message', 'Inclusion has been saved.');

		return redirect()->back();
		
		}
		
		
	}
	
	public function delete_inclusion($inc_id)
	{
		$inc = Inclusion::find($inc_id);    
		if($inc->delete())
		{
			Session::flash('delete_message', 'Inclusion has been deleted.');
			return redirect()->back();
		}
	}
	
	public function update_filter_inclusion1()
	{
		$input = Input::all();
		//dd($input);
		//PropertyInclusion::where('property_id', $propid)->delete();
		$affected = DB::table('inclusions')->where('filter_inclusion' , 'Yes')->update(array('filter_inclusion' =>'No'));
		$inc = Inclusion::where(['parent_id'=>'0'])->get();
		$inc_arr  = $inc->toArray();
		foreach($inc_arr as $inc_val)
		{
			$inc1 = Inclusion::where(['parent_id'=>$inc_val['id']])->get();
			$inc_arr1  = $inc1->toArray();
			foreach($inc_arr1 as $inc1_val)
			{
				$inc2 = Inclusion::where(['parent_id'=>$inc1_val['id']])->get();
				$inc_arr2  = $inc2->toArray();
				foreach($inc_arr2 as $inc2_val)
				{
					if(!empty($input['inc_filter_'.$inc2_val['id']]))
					{
						$inc_id = $inc2_val['id'];
						$filter_inc_val =  $input['inc_filter_'.$inc2_val['id']];
						$inclusion = Inclusion::find($inc_id);
						
						$inclusion->filter_inclusion = $filter_inc_val;
						$inclusion->save();
					}
				}
			}
		
		}
		Session::flash('update_message', 'Property Filter Inclusion has been updated');

		return redirect()->back();
	}
	
	public function update_filter_inclusion()
	{
		$input = Input::all();
		//dd($input);
		//PropertyInclusion::where('property_id', $propid)->delete();
		$affected = DB::table('inclusions')->where('filter_inclusion' , 'Yes')->update(array('filter_inclusion' =>'No'));
		$inc = Inclusion::where(['parent_id'=>'0'])->get();
		$inc_arr  = $inc->toArray();
		foreach($inc_arr as $inc_val)
		{
			$inc1 = Inclusion::where(['parent_id'=>$inc_val['id']])->get();
			$inc_arr1  = $inc1->toArray();
			foreach($inc_arr1 as $inc1_val)
			{
				if(!empty($input['inc_filter_'.$inc1_val['id']])) {
				$inc_id = $inc1_val['id'];
				$filter_inc_val =  $input['inc_filter_'.$inc1_val['id']];
				$inclusion = Inclusion::find($inc_id);
						
				$inclusion->filter_inclusion = $filter_inc_val;
				$inclusion->save();
				}
			}
		
		}
		Session::flash('update_message', 'Property Filter Inclusion has been updated');

		return redirect()->back();
	}
	

} 