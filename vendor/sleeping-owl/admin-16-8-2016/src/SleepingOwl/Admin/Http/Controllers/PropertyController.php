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
use App\Property;
use App\Inclusion;
use App\PropertyGallery;
use App\PropertyInclusion;
use App\PropertyFloorImage;
use App\Models\PropertyDisplayHome;
use App\Models\PropertyDisplayHomeOpenHour;
use DB;


class PropertyController extends Controller
{

	public function get_properties()
	{
	
		$where_arr = array('user_type'=>'Builder');
		
		$query = Property::with('builder_detail');
		//$results = User::where($where_arr)->builders;
		$main_regionchange = !empty($_REQUEST['main_regionchange']) ? $_REQUEST['main_regionchange']:"";
		if(!empty($_REQUEST['main_regionchange']))
			{
				$main_regionchange = $_REQUEST['main_regionchange'] ;
				$re = State::where('state_name', $main_regionchange)->get(array('id'));
	
				$state_arr = $re->toArray();
				$states = "";

				
				foreach($state_arr as $st_val)
				{  
					$states[] = $st_val['id'];

				}
			  $users = UserLocation::where('user_type','Builder')->wherein('state_id', $states)->groupBy('user_id')->get(array('user_id'));
				
				$users_arr = $users->toArray();

				$user_ar = "";
				foreach($users_arr as $user_val)
				{
					$user_ar[] = $user_val['user_id'];
				}
					///$userstring = "'" . implode("','", $user_ar) . "'";
					//$wherein.= "->whereIn(user_id,".$userstring.")";

				$query->whereIn('user_id',$user_ar); 
				
			}
		$page	=	"" ;
			$lastpage	=	"" ;
			$numrows  = "" ;
			$total_prop = $this->count_search_property($main_regionchange);
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
			
			$data['page'] = $page;
			$data['lastpage'] = $lastpage;
			$data['numrows'] = $numrows;
			$data['currentpage'] = $currentpage;
			$data['rows_per_page'] = $rows_per_page;
			$query->limit($rows_per_page);
			$query->offset($start);
			$query->orderBy('featured', 'desc');
			//echo  $query->getQuery()->toSql();
			$results = $query->get();
			$data['properties_arr'] = $results->toArray();
			/*  echo '<pre>';
			print_r($data['properties_arr']);  */
			
		 
			$data['total_prop'] = $total_prop;
		
		
		
		$data['title'] = "Properties";
		return view(AdminTemplate::view('pages.properties'), $data);
	}
	
	
	public function count_search_property($main_regionchange="")
	{
		$where_arr = array('user_type'=>'Builder');
		
		$query = Property::with('builder_detail');
		//$results = User::where($where_arr)->builders;
		
		if(!empty($main_regionchange))
			{
				$re = State::where('state_name', $main_regionchange)->get(array('id'));
	
				$state_arr = $re->toArray();
				$states = "";

				
				foreach($state_arr as $st_val)
				{  
					$states[] = $st_val['id'];

				}
			  $users = UserLocation::where('user_type','Builder')->wherein('state_id', $states)->groupBy('user_id')->get(array('user_id'));
				
				$users_arr = $users->toArray();

				$user_ar = "";
				foreach($users_arr as $user_val)
				{
					$user_ar[] = $user_val['user_id'];
				}
					///$userstring = "'" . implode("','", $user_ar) . "'";
					//$wherein.= "->whereIn(user_id,".$userstring.")";

				$query->whereIn('user_id',$user_ar); 
				return $query->count(); 
				
			} else {
			return $query->count(); 
			
			}
	}
	
	public function edit_property($prop_id)
	{
		$results = Property::where(['id' => $prop_id])->first();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['property_arr'] = $results->toArray();
		$where_arr = array('user_type'=>'Builder');
		
		$results = User::with('builders')->where($where_arr)->get();
		//$results = User::where($where_arr)->builders;

		$data['builders_arr'] = $results->toArray();
		
		$inc = Inclusion::where(['parent_id'=>'0'])->get();
		$data['inc_arr']  = $inc->toArray();
		
		$prop_inc  = PropertyInclusion::where(['property_id'=>$prop_id])->get();
		$data['prop_inc_arr']  = $prop_inc->toArray();
		
		$prop_floor_img  = PropertyFloorImage::where(['property_id'=>$prop_id])->get();
		$data['prop_flor_arr']  = $prop_floor_img->toArray();
		
		$display_homes  = PropertyDisplayHome::where(['property_id'=>$prop_id])->get();
		$data['display_homes_arr']  = $display_homes->toArray();
		
		$data['title'] = "Edit Property";
		
		return view(AdminTemplate::view('pages.edit_property'), $data);
	}
	
	public function edit_property_inclusion($prop_id,$builder_id)
	{

		$where_arr = array('user_type'=>'Builder','id'=>$builder_id);
		
		$results = User::with('builders')->where($where_arr)->first();
		//$results = User::where($where_arr)->builders;

		$data['builder_arr'] = $results->toArray();
		
		$inc = Inclusion::where(['parent_id'=>'0'])->get();
		$data['inc_arr']  = $inc->toArray();
		
		$prop_inc  = PropertyInclusion::where(['property_id'=>$prop_id])->get();
		$data['prop_inc_arr']  = $prop_inc->toArray();
		$prop_query = Property::where(['user_id' => $builder_id])->get(array('id','property_title'));
		//$results = User::with('builders')->where($where_arr)->get();
		$prop_arr = $prop_query->toArray();
		$data['prop_arr'] = $prop_arr;
		$data['prop_id']  = $prop_id;
		$data['builder_id']  = $builder_id;
		$data['title'] = "Edit Inclusion";
		
		return view(AdminTemplate::view('pages.edit_property_inclusion'), $data);

	}
	public function add_property_inclusion($builder_id)
	{
		$prop_query = Property::where(['user_id' => $builder_id])->get(array('id','property_title'));
		//$results = User::with('builders')->where($where_arr)->get();
		$prop_arr = $prop_query->toArray();
		$where_arr = array('user_type'=>'Builder','id'=>$builder_id);
		
		$results = User::with('builders')->where($where_arr)->first();
		//$results = User::where($where_arr)->builders;

		$data['builder_arr'] = $results->toArray();
		
		$inc = Inclusion::where(['parent_id'=>'0'])->get();
		$data['inc_arr']  = $inc->toArray();
		
		//$prop_inc  = PropertyInclusion::where(['property_id'=>$prop_id])->get();
		//$data['prop_inc_arr']  = $prop_inc->toArray();
		$data['prop_arr'] = $prop_arr;
		//$data['prop_id']  = $prop_id;
		$data['builder_id']  = $builder_id;
		$data['title'] = "Add Inclusion";
		
		return view(AdminTemplate::view('pages.edit_property_inclusion'), $data);
	}
	
	public function update_property($prop_id, Request $request)
	{
		$input = Input::all();
		//dd($input);
		$rules = array(
		'property_title' => 'required',
		'description' => 'required',
		'bedrooms' => 'required|numeric', 
		'cars' => 'required|numeric', 
		'stories' => 'required|numeric', 
		'living' => 'required|numeric', 
		'price' => 'required|numeric', 
		'min_block_width' => 'required|numeric', 
		'min_block_length' => 'required|numeric', 
		'housesize' => 'required|numeric', 
		'user_id' => 'required' 
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/property/edit/'.$prop_id)
				->withErrors($validator); // send back all errors to the login form
		} else {
		 $properties = Property::where(['id' => $prop_id])->first();
		/*  echo '<pre>';
		 print_r($builders);
		 die;   */
		 
		 if(!empty(Input::file('brochure'))) {
		  if (Input::file('brochure')->isValid()) {
		  $destinationPath = 'uploads/brochure'; // upload path
		  $extension = Input::file('brochure')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'-simp'.'.'.$extension; // renameing image
		  Input::file('brochure')->move($destinationPath, $fileName); // uploading file to given path
		  $properties->brochure = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		
		 if(!empty(Input::file('promotional_brochure'))) {
		  if (Input::file('promotional_brochure')->isValid()) {
		  $destinationPath = 'uploads/brochure'; // upload path
		  $extension = Input::file('promotional_brochure')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'-prom'.'.'.$extension; // renameing image
		  Input::file('promotional_brochure')->move($destinationPath, $fileName); // uploading file to given path
		  $properties->promotional_brochure = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
			
		 $properties->property_title = $_POST['property_title'];
		 $properties->description = $_POST['description'];
		 $properties->bedrooms = $_POST['bedrooms'];
		 $properties->cars = $_POST['cars'];
		 $properties->housesize = $_POST['housesize'];
		 $properties->bathrooms = $_POST['bathrooms'];
		 $properties->stories = $_POST['stories'];
		 $properties->min_block_width = $_POST['min_block_width'];
		 $properties->min_block_length = $_POST['min_block_length'];
		 $properties->living = $_POST['living'];
		 $properties->price = $_POST['price'];
		 if(!empty($_POST['alfresco'])) {
		 $alfresco = $_POST['alfresco'];
		 } else {
		 $alfresco = 'No' ;
		 }
		  if(!empty($_POST['dual_occ'])) {
		 $dual_occ = $_POST['dual_occ'];
		 } else {
		 $dual_occ = 'No' ;
		 }
		 $properties->alfresco = $alfresco;
		 
		 $properties->dual_occ = $dual_occ;
		 $properties->user_id = $_POST['user_id'];
		 
		/*  echo '<pre>';
		 print_r($builders);
		 die; */

         $properties->save();

		Session::flash('update_message', 'Property Detail has been updated');

		return redirect()->back();
		
		}
	}
	
	
	public function create_property()
	{
		$data['title'] = "Create Property";
		$properties = Property::all();
		$data['property_arr'] = $properties->toArray();
		
		$where_arr = array('user_type'=>'Builder');
		$results = User::with('builders')->where($where_arr)->get();
		//$results = User::where($where_arr)->builders;
		
		$data['builders_arr'] = $results->toArray();
		return view(AdminTemplate::view('pages.edit_property'), $data);
	}
	
	public function add_property(Request $request)
	{
	
			$input = Input::all();
	//dd($input);
		$rules = array(
		'property_title' => 'required',
		'description' => 'required',
		'bedrooms' => 'required|numeric', 
		'cars' => 'required|numeric', 
		'stories' => 'required|numeric', 
		'living' => 'required|numeric', 
		'price' => 'required|numeric', 
		'min_block_width' => 'required|numeric', 
		'min_block_length' => 'required|numeric', 
		'housesize' => 'required|numeric', 
		'user_id' => 'required' 
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/property/create')
				->withErrors($validator) // send back all errors to the login form
				->withInput();
		} else {
		 $properties = new Property;
		/*  echo '<pre>';
		 print_r($builders);
		 die;   */
		 
		 if(!empty(Input::file('brochure'))) {
		  if (Input::file('brochure')->isValid()) {
		  $destinationPath = 'uploads/brochure'; // upload path
		  $extension = Input::file('brochure')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'-simp'.'.'.$extension; // renameing image
		  Input::file('brochure')->move($destinationPath, $fileName); // uploading file to given path
		  $properties->brochure = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
		
		 if(!empty(Input::file('promotional_brochure'))) {
		  if (Input::file('promotional_brochure')->isValid()) {
		  $destinationPath = 'uploads/brochure'; // upload path
		  $extension = Input::file('promotional_brochure')->getClientOriginalExtension(); // getting image extension
		  $fileName = rand(11111,99999).'-prom'.'.'.$extension; // renameing image
		  Input::file('promotional_brochure')->move($destinationPath, $fileName); // uploading file to given path
		  $properties->promotional_brochure = $fileName;
		  // sending back with message
		 // Session::flash('success', 'Upload successfully'); 
		  //return Redirect::to('upload');
		}
		}
		
			
		 $properties->property_title = $_POST['property_title'];
		 $properties->description = $_POST['description'];
		 $properties->bedrooms = $_POST['bedrooms'];
		 $properties->cars = $_POST['cars'];
		 $properties->housesize = $_POST['housesize'];
		 $properties->bathrooms = $_POST['bathrooms'];
		 $properties->stories = $_POST['stories'];
		 $properties->min_block_width = $_POST['min_block_width'];
		 $properties->min_block_length = $_POST['min_block_length'];
		 $properties->living = $_POST['living'];
		 $properties->price = $_POST['price'];
		 if(!empty($_POST['alfresco'])) {
		 $alfresco = $_POST['alfresco'];
		 } else {
		 $alfresco = 'No' ;
		 }
		  if(!empty($_POST['dual_occ'])) {
		 $dual_occ = $_POST['dual_occ'];
		 } else {
		 $dual_occ = 'No' ;
		 }
		 $properties->alfresco = $alfresco;
		 
		 $properties->dual_occ = $dual_occ;
		 $properties->user_id = $_POST['user_id'];

		/*  echo '<pre>';
		 print_r($builders);
		 die; */

         $properties->save();
		 $lastInsertedId= $properties->id;
		Session::flash('save_message', 'Property Detail has been added');

		return Redirect::to('admin/property/edit/'.$lastInsertedId);
		
		}
	}
	
	public function delete_property($prop_id)
	{
		$propdel = Property::find($prop_id);    
		if($propdel->delete())
		{
			PropertyInclusion::where('property_id', $prop_id)->delete();
			$propfgallery  = PropertyFloorImage::where('property_id', $prop_id)->get();
			$propfgall_arr = 	$propfgallery->toArray();
			foreach($propfgall_arr as $img_val)
			{
				$img = $img_val['image'];
				$upload_path = '/uploads/property_floor/';
				unlink(base_path().$upload_path.$img);
				$img_id =  $img_val['id'];
				$fgallery_image = PropertyFloorImage::find($img_id);    
				$fgallery_image->delete();
			}
			
			$propgallery  = PropertyGallery::where('property_id', $prop_id)->get();
			$propgall_arr = 	$propgallery->toArray();
			foreach($propgall_arr as $img_val)
			{
				$img = $img_val['image'];
				$upload_path = '/uploads/property_gallery/';
				unlink(base_path().$upload_path.$img);
				$img_id =  $img_val['id'];
				$gallery_image = PropertyGallery::find($img_id);    
				$gallery_image->delete();
			}

			Session::flash('delete_message', 'Property & its content has been deleted');
			return redirect()->back();
		}
	}
	
	public function get_galleries()
	{
		
		$results = Property::with('property_gallery')->get();
		//$results = User::where($where_arr)->builders;

		$data['gallery_arr'] = $results->toArray();
		/* $data['title'] = "Builders";
		return view(AdminTemplate::view('pages.builders'), $data);
		$properties = Property::all();
 */
		//$data['properties_arr'] = $properties->toArray();
		$data['title'] = "Property Photo Gallery";
		return view(AdminTemplate::view('pages.property_photo_gallery'), $data);
	}
	
	
	public function create_gallery()
	{
		$data['title'] = "Create Gallery";
		
		$where_arr = array('user_type'=>'Builder');
		
		$results = User::with('builders')->where($where_arr)->get();
		//$results = User::where($where_arr)->builders;

		$data['builders_arr'] = $results->toArray();
		
		return view(AdminTemplate::view('pages.edit_property_gallery'), $data);
	}
	
	public function ajax_get_builder_properties()
	{
		$builder_id = $_POST['builder'];
		$results = Property::where(['user_id' => $builder_id])->get();
		$prop_arr = $results->toArray();
		$prop_html = "";
		$prop_html.= '<div class="form-group"><label>Select Property</label>';
		$prop_html.= '<select name="property_id" class="property_id"><option value="0">None</option>';
		foreach($prop_arr as $prop_val)
		{
			$prop_html.= '<option value="'.$prop_val['id'].'">'.$prop_val['property_title'].'</option>';
		}
		$prop_html.= '</select>';
		$prop_html.= '</div>';
		echo $prop_html;
	}
	
	public function ajax_save_property_images()
	{
		$input = Input::all();
		$prop = Session::get('propid');

	  $rules = array(
            'file' => 'image|max:3000',
        );
 
        $validation = Validator::make($input, $rules);
 
        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }

 
        $destinationPath = 'uploads/property_gallery'; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $fileName = rand(11111, 99999) . '-gallery-'.$prop.'.' . $extension; // renameing image
        $upload_success = Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
		
 
        if ($upload_success) {
		$propgallery = new PropertyGallery;
		$propgallery->property_id = $prop;
		$propgallery->image = $fileName;
		$propgallery->save();
			echo 'File is uploaded successfully.';
        } else {
           echo 'Failed';
        }  
	}
	
	public function ajax_save_prop_florplansimg()
	{
		$input = Input::all();
		$prop = Session::get('propid');

	  $rules = array(
            'file' => 'image|max:3000',
        );
 
        $validation = Validator::make($input, $rules);
 
        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }

 
        $destinationPath = 'uploads/property_gallery'; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $fileName = rand(11111, 99999) . '-gallery-'.$prop.'.' . $extension; // renameing image
        $upload_success = Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
		
 
        if ($upload_success) {
		$propgallery = new PropertyGallery;
		$propgallery->property_id = $prop;
		$propgallery->image = $fileName;
		$propgallery->save();
			echo 'File is uploaded successfully.';
        } else {
           echo 'Failed';
        }  
	}
	
	
	public function ajax_set_propertyid()
	{
		//echo $_POST['prop'];
		 Session::put('propid', $_POST['prop']);
		//echo  Session::get('propid');
	}
	
	public function edit_gallery($prop_id)
	{
		$results = Property::with('property_gallery')->where(['id' => $prop_id])->get();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['prop_arr'] = $results->toArray();
		$data['title'] = "Edit Photo gallery";
		$data['id'] = $prop_id;
		return view(AdminTemplate::view('pages.edit_property_gallery'), $data);
	}
	
	public function delete_gallery_image($img_id)
	{
		
		//die;
		$gallery_image = PropertyGallery::find($img_id);
		$img = $gallery_image->image;
		$upload_path = '/uploads/property_gallery/';
        unlink(base_path().$upload_path.$img);
		if($gallery_image->delete())
		{
			Session::flash('delete_message', 'Gallery image has been deleted');
			return redirect()->back();
		}
	}
	

	public function ajax_update_gallery_images()
	{
		$input = Input::all();
		
		//$prop = Session::get('propid');
		$prop = $_POST['propid'];

	  $rules = array(
            'file' => 'image|max:3000',
        );
 
        $validation = Validator::make($input, $rules);
 
        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }

 
        $destinationPath = 'uploads/property_gallery'; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $fileName = rand(11111, 99999) . '-gallery-'.$prop.'.' . $extension; // renameing image
        $upload_success = Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
		
 
        if ($upload_success) {
		$propgallery = new PropertyGallery;
		$propgallery->property_id = $prop;
		$propgallery->image = $fileName;
		$propgallery->save();
			echo 'File is uploaded successfully.';
        } else {
           echo 'Failed';
        }  
	}
	
	
	public function ajax_update_floor_images()
	{
		$input = Input::all();
		
		//$prop = Session::get('propid');
		$prop = $_POST['propid'];

	  $rules = array(
            'file' => 'image|max:3000',
        );
 
        $validation = Validator::make($input, $rules);
 
        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }

 
        $destinationPath = 'uploads/property_floor'; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $fileName = rand(11111, 99999) . '-floor-'.$prop.'.' . $extension; // renameing image
        $upload_success = Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
		
 
        if ($upload_success) {
		$propfloorimg = new PropertyFloorImage;
		$propfloorimg->property_id = $prop;
		$propfloorimg->image = $fileName;
		$propfloorimg->save();
			echo 'File is uploaded successfully.';
        } else {
           echo 'Failed';
        }  
	}
	
	
	public function add_more_images($propid)
	{
		$data['propid'] = $propid;
		$data['title'] = 'Edit Gallery';
		return view(AdminTemplate::view('pages.edit_property_gallery'), $data);
	}
	
	public function get_prop($propid)
	{
		echo $propid;
	}
	
	public function update_inclusion($propid,$builder_id)
	{
		$input = Input::all();
		//dd($input);
		PropertyInclusion::where('property_id', $propid)->delete();
		$inc = Inclusion::where(['parent_id'=>'0'])->get();
		$inc_arr  = $inc->toArray();
		foreach($inc_arr as $inc_val)
		{
			$inc1 = Inclusion::where(['parent_id'=>$inc_val['id']])->get();
			$inc_arr1  = $inc1->toArray();
			foreach($inc_arr1 as $inc1_val)
			{
					if(!empty($input['inc_'.$inc1_val['id']]) && !empty($input['inc_type_'.$inc1_val['id']]))
					{
						echo $input['inc_'.$inc1_val['id']];
						$prop_inc = new PropertyInclusion ;
						$prop_inc->property_id = $propid;
						$prop_inc->inclusion_id = $input['inc_'.$inc1_val['id']];
						$prop_inc->builder_id = $builder_id;
						$prop_inc->inclusion_type = $input['inc_type_'.$inc1_val['id']];
						$prop_inc->save();
					}
				
			}
		
		}

		Session::flash('update_message', 'Property Inclusion has been updated');

		return redirect()->back();
		
	}
	
	public function add_inclusion($builder_id)
	{

	$input = Input::all();
		//dd($input);
		$rules = array(
		'property_ids' => 'required'
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);
		if(!empty($_POST['property_ids'])) {
		$validator->after(function($validator)
		{
			$check = $this->validate_prop_inclusion($_POST['property_ids']);
			if ($check['status']=='false')
			{
				$validator->errors()->add('inc_st', 'You have already added inclusions of these properties');
			}
		});
		}

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('admin/property/add-property-inclusion/'.$builder_id)
				->withErrors($validator) // send back all errors to the login form
				->withInput();
		} else {
		
		$property_ids = $_REQUEST['property_ids'];
		foreach($property_ids as $prop_val) {
		$inc = Inclusion::where(['parent_id'=>'0'])->get();
		$inc_arr  = $inc->toArray();
		foreach($inc_arr as $inc_val)
		{
			$inc1 = Inclusion::where(['parent_id'=>$inc_val['id']])->get();
			$inc_arr1  = $inc1->toArray();
			foreach($inc_arr1 as $inc1_val)
			{
					if(!empty($input['inc_'.$inc1_val['id']]) && !empty($input['inc_type_'.$inc1_val['id']]))
					{
						echo $input['inc_'.$inc1_val['id']];
						$prop_inc = new PropertyInclusion ;
						$prop_inc->property_id = $prop_val;
						$prop_inc->inclusion_id = $input['inc_'.$inc1_val['id']];
						$prop_inc->builder_id = $builder_id;
						$prop_inc->inclusion_type = $input['inc_type_'.$inc1_val['id']];
						$prop_inc->save();
					}
				
			}
		
		}
		
		}

		Session::flash('update_message', 'Property Inclusion has been updated');

		return redirect()->back();
		
		}

	}
	
	public function remove_inclusion($prop_id,$home_id)
	{
		if(PropertyInclusion::where(array('property_id'=>$propid,'builder_id'=>$home_id))->delete()) {
		Session::flash('delete_message', 'Property Inclusion has been deleted');
			return redirect()->back();
		}
	}
	
	
	
	public function delete_floor_plans_img($img_id)
	{
		
		//die;
		$gallery_image = PropertyFloorImage::find($img_id);    
		$img = $gallery_image->image;
		$upload_path = '/uploads/property_floor/';
        unlink(base_path().$upload_path.$img);
		if($gallery_image->delete())
		{
			Session::flash('delete_message', 'Floor Plans image has been deleted');
			return redirect()->back();
		}
	}
	
	public function view_property($prop_id)
	{
		$results = Property::with('builder_detail','property_gallery','property_floor_plans','property_inclusions')->where(['id' => $prop_id])->get();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['prop_arr'] = $results->toArray();
		$inc = Inclusion::where(['parent_id'=>'0'])->get();
		$data['inc_arr']  = $inc->toArray();
		$data['title'] = 'View Property';
		return view(AdminTemplate::view('pages.view_property'), $data);
	}
	
	
	public function featured_property($prop_id){
		$properties = Property::where(['id' => $prop_id])->first();
		//$results = User::with('builders')->where($where_arr)->get();
		$properties_arr = $properties->toArray();
		$featured = '';
		if($properties_arr['featured'] == 'No'){
			$featured = 'Yes';
		}else{
			$featured = 'No';
		}
		$properties->featured = $featured;
		if($properties->save()){
			Session::flash('delete_message', 'Property has been changed to featured.');
			return redirect()->back();
		}else{
			Session::flash('delete_message', 'Currently not able change Property to featured. Please try again.');
			return redirect()->back();
		}
	}
	
	public function save_display_home($builder_id)
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
		'property_ids' => 'required', 
	);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);
		//$position_arr = array();
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
				return Redirect::to('admin/builder/edit/'.$builder_id)
				->withErrors($validator) // send back all errors to the login form
				->withInput();
		} else {
		
		$property_ids = $_REQUEST['property_ids'];
	foreach($property_ids as $prop_val) {
		$properties = new PropertyDisplayHome;
			$lat = Session::get('lat');
			$lng = Session::get('lng');
		 $properties->display_village_title = $_POST['display_village_title'];
		 $properties->display_location = $_POST['display_location'];
		 $properties->property_id = $prop_val;
		 $properties->builder_id = $builder_id;
		 $properties->geo_lng = $lng;
		 $properties->geo_lat = $lat;

         $properties->save();
		 $display_home_id = $properties->id ;
		 if(!empty($_POST['wstart_time']) && !empty($_POST['wend_time'])) {
			$display_home = new PropertyDisplayHomeOpenHour ;
			$display_home->start_time = $_POST['wstart_time'];
			$display_home->end_time  = $_POST['wend_time'];
			$display_home->day  = 'Weekdays' ;
			$display_home->display_home_id  = $display_home_id;
			$display_home->save();
			}
			
		if(!empty($_POST['sastart_time']) && !empty($_POST['saend_time'])) {
			$display_home = new PropertyDisplayHomeOpenHour ;
			$display_home->start_time = $_POST['saend_time'];
			$display_home->end_time  = $_POST['saend_time'];
			$display_home->day  = 'Saturdays ' ;
			$display_home->display_home_id  = $display_home_id;
			$display_home->save();
			}	
		if(!empty($_POST['sunstart_time']) && !empty($_POST['sunend_time'])) {
			$display_home = new PropertyDisplayHomeOpenHour ;
			$display_home->start_time = $_POST['sunstart_time'];
			$display_home->end_time  = $_POST['sunend_time'];
			$display_home->day  = 'Sundays ' ;
			$display_home->display_home_id  = $display_home_id;
			$display_home->save();
			}	
			
		}
			
		Session::flash('update_message', 'Property Display homes has been updated');

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
	
	public function validate_prop_inclusion($propids)
	{
		$data = array();
		$prop = PropertyInclusion::whereIn('property_id',$propids);
		$count = $prop->count();
		if($count == 0)
		{
			$data['status'] = 'true';
		} else {
		
			$data['status'] = 'false';
		}
		
		return $data;
	}
	
	
	public function delete_display_home($display_home_id)
	{
		$prop_display_home = PropertyDisplayHome::where('id',$display_home_id)->delete();
		$prop_display_home = PropertyDisplayHomeOpenHour::where('display_home_id',$display_home_id)->delete();
		Session::flash('delete_message', 'property display has been deleted');

		return redirect()->back();
	}
	
	public function edit_display_home($home_id,$builder_id)
	{
		$results = PropertyDisplayHome::with('open_hours')->where(['id' => $home_id])->get();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['prop_display_home_arr'] = $results->toArray();
		$data['title'] = "Edit Display Home";
		$data['prop_id'] = $home_id;
		$results = BuilderDetail::where(['builder_id' => $builder_id])->first();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['builder_arr'] = $results->toArray();
		$prop_query = Property::where(['user_id' => $builder_id])->get(array('id','property_title'));
		//$results = User::with('builders')->where($where_arr)->get();
		$prop_arr = $prop_query->toArray();
	 
		$data['prop_arr'] = $prop_arr;
		$data['builder_id'] = $builder_id;
		
		return view(AdminTemplate::view('pages.edit_display_home'), $data);
	}
	
	public function update_display_home($home_id)
	{
		$dis_home = PropertyDisplayHome::where('id',$home_id)->first();
		$display_homes = $dis_home->toArray();
		$property_id = $display_homes['property_id'];
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
				return Redirect::to('admin/property/display-home/edit/'.$home_id)
				->withErrors($validator) // send back all errors to the login form
				->withInput();
		} else {
		$property_ids = $_REQUEST['property_ids'];
		$builder_id = $_REQUEST['builder_id'];
		$display_homes = PropertyDisplayHome::where('id',$home_id)->first();
		$display_home_arr = $display_homes->toArray();
		$lat = Session::get('lat');
		$lng = Session::get('lng');	
		 $display_homes->display_village_title = $_POST['display_village_title'];
		  $display_homes->property_id = $property_ids;
		  $display_homes->display_location = $_POST['display_location'];
		 $display_homes->builder_id = $builder_id;
		 $display_homes->geo_lat = $lat;
		$display_homes->geo_lng = $lng;
         $display_homes->save();
		 $display_home_id = $home_id;
		 if(!empty($_POST['wstart_time']) && !empty($_POST['wend_time'])) {
			$open_hours = PropertyDisplayHomeOpenHour::where(array('display_home_id'=>$display_home_id,'day'=>'Weekdays'))->first() ;
			$open_hours->start_time = $_POST['wstart_time'];
			$open_hours->end_time  = $_POST['wend_time'];
			$open_hours->save();
			}
			
		if(!empty($_POST['sastart_time']) && !empty($_POST['saend_time'])) {
			$open_hours = PropertyDisplayHomeOpenHour::where(array('display_home_id'=>$display_home_id,'day'=>'Saturdays'))->first() ;
			$open_hours->start_time = $_POST['sastart_time'];
			$open_hours->end_time  = $_POST['saend_time'];
			$open_hours->save();
			}	
		if(!empty($_POST['sunstart_time']) && !empty($_POST['sunend_time'])) {
			$open_hours = PropertyDisplayHomeOpenHour::where(array('display_home_id'=>$display_home_id,'day'=>'Sundays'))->first() ;
			$open_hours->start_time = $_POST['sunstart_time'];
			$open_hours->end_time  = $_POST['sunend_time'];
			$open_hours->save();
			}	
			
		Session::flash('update_message', 'Property Detail has been updated');

		return Redirect::to('admin/builder/edit/'.$builder_id);
		//return Redirect::to('admin/property/display-home/edit/'.$property_id);
		
		}
	
	}
	
	
	public function create_display_home($builder_id)
	{
		$data['title'] = "Display Homes";
		$data['builder_id'] = $builder_id;
	 $prop_query = Property::where(['user_id' => $builder_id])->get(array('id','property_title'));
		//$results = User::with('builders')->where($where_arr)->get();
	$prop_arr = $prop_query->toArray();
	 
	 $data['prop_arr'] = $prop_arr;
	 
	 $results = BuilderDetail::where(['builder_id' => $builder_id])->first();
		//$results = User::with('builders')->where($where_arr)->get();
		$data['builder_arr'] = $results->toArray();

	 
		return view(AdminTemplate::view('pages.edit_display_home'), $data);
	}
	
	
	
	public function update_long()
	{
		$dis_home = PropertyDisplayHome::all();
		$display_home_arr = $dis_home->toArray();
		foreach($display_home_arr as $val)
		{
			$address = $val['display_location'];
			$id = $val['id'];
			$data = $this->vldte_dsply_hmes_adres($address);
			$lat = $data['lat'];
			$lng = $data['lng'];
			DB::table('property_display_homes')
            ->where('id', $id)
            ->update(['geo_lat' => $lat,'geo_lng'=>$lng]);
		}
	}
	

	public function change_order(){ 
		$input = Input::all();
		//dd($input);
		DB::table('property')
            ->where('id', $_POST['pid'])
            ->update(['featured_order' => $_POST['order']]);
        return Redirect::to('admin/properties');
	}
	
	public function sort_properties()
	{
		$where_arr = array('user_type'=>'Builder');
		
		$results = Property::with('builder_detail')->where('featured','Yes')->orderBy('featured_order','Asc')->get();
		//$results = User::where($where_arr)->builders;

		$data['properties_arr'] = $results->toArray();
		/* $data['title'] = "Builders";
		return view(AdminTemplate::view('pages.builders'), $data);
		$properties = Property::all();
 */
		//$data['properties_arr'] = $properties->toArray();
		$data['title'] = "Sort Properties";
		return view(AdminTemplate::view('pages.sort_properties'), $data);
	}
	
	public function update_sort_properties()
	{
		$sort_arr = $_REQUEST['item'];
		if(!empty($sort_arr))
		{
			$i = 1;
			foreach($sort_arr as $sort_val) {
				DB::table('property')
            ->where('id', $sort_val)
            ->update(['featured_order' => $i]);
			$i++;
			}
			echo '<p style="color:#66A266">Sort Order has been changed</p>';
		} else {
			echo '<p style="color:#66A266">Invalid Data.Try Again</p>';
		}
	}
	
	public function activate_properties($id){
		$uri = Request::path();
		$url = explode('/',$uri);
		DB::table('property')
            ->where('id', $id)
            ->update(['status' => $url[4]]);
        return Redirect::to('admin/properties');
	}
	
	//srotable gallery

	public function sort_gallery($prop_id)
	{
		$results = PropertyGallery::where(['property_id' => $prop_id])->orderBy('gallery_order', 'Asc')->get();
		//$results = User::with('builders')->where($where_arr)->get();
		//echo '<pre>';print_r($results->toArray());echo '</pre>';die;
		$data['prop_arr'] = $results->toArray();
		$data['title'] = "Sort Photo gallery";
		$data['id'] = $prop_id;
		
		return view(AdminTemplate::view('pages.edit_property_gallery_order'), $data);
	}

	public function update_sort_gallery()
	{
		$sort_arr = $_REQUEST['item'];
		if(!empty($sort_arr))
		{
			$i = 1;
			foreach($sort_arr as $sort_val) {
				DB::table('property_gallery')
            ->where('id', $sort_val)
            ->update(['gallery_order' => $i]);
			$i++;
			}
			echo '<p style="color:#66A266">Sort Order has been changed</p>';
		} else {
			echo '<p style="color:#66A266">Invalid Data.Try Again</p>';
		}
	}

} 
