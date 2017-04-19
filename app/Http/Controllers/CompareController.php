<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Input;
use Redirect;
use Session;
use Validator;
use App\User;
use App\UserDetail;
use App\State;
use App\BuilderDetail;
use App\UserLocation;
use App\Property;
use App\Inclusion;
use App\AddManagement;
use App\PropertyGallery;
use App\PropertyInclusion;
use App\PropertyFloorImage;
use App\Models\SaveProperty;
use App\Models\SaveInclusion;
use Auth;
use DB;
use Log;

class CompareController extends Controller
{
	public function index(){
		$query = Property::with('builder_detail','property_gallery');
		$header_state = "";
		 $header_state = Session::get('header_state');
		 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
		$data['build_location'] = State::where(['state_name' => $headr_state])->get();
		$users = UserLocation::where('user_type','Builder')->whereIn('state_id', function($query){
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

		$query->whereIn('user_id',$user_ar);
		//echo $query->getQuery()->toSql();
		$results = $query->get();
		$data['properties_arr'] = $results->toArray();
		$total_prop = Property::with('builder_detail')->count();
		$data['total_prop'] = $total_prop;
		
		
		
		$builder = BuilderDetail::all();
		$data['builder_arr'] = $builder->toArray();
		$data['max_price'] = Property::max('price');
		$data['min_price'] = Property::min('price');
		$data['min_block_width'] = Property::min('min_block_width');
		$data['max_block_width'] = Property::max('min_block_width');
		$data['min_block_length'] = Property::min('min_block_length');
		$data['max_block_length'] = Property::max('min_block_length');
		$data['min_house_size'] = Property::min('housesize');
		$data['max_house_size'] = Property::max('housesize');
		$data['builder_arr'] = $builder->toArray();
		$data['title'] = 'Search New Home Designs';
		return view('search-property',$data);
	}
	
	
	public function compare_property()
	{
		if(!empty($_REQUEST['propertyids'])) {
			$header_state = Session::get('header_state');
			$headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
			$compare_arr = explode(',',$_REQUEST['propertyids']);
			$query = Property::with('builder_detail','property_gallery','property_floor_plans','property_display_homes');
			$result = $query->whereIn('id',$compare_arr)->get();
			$query1 = Property::with('builder_detail','property_gallery','property_floor_plans');
			$query1->whereIn('id',$compare_arr);
			$query1->where('property_type','2');
			$prop_type_count = $query1->count();
			if($prop_type_count > 0)
			{
				$data['property_type'] = 'House-Lands';
			} else {
				$data['property_type'] = 'Houses';
			}
			$compare_prop_arr = $result->toArray();
			$data['property_arr'] = $compare_prop_arr;
			$saveincids = "";
			$user_ip =  request()->ip();
			$saveinc =  SaveInclusion::where(array('user_ip'=>$user_ip))->get(array('inclusion_id'));
			$saveincarr = $saveinc->toArray();
			foreach($saveincarr as $inc_val)
			{
				$saveincids[] = $inc_val['inclusion_id'];
			}

			$inc_arr =  Inclusion::whereIn('id',$saveincids)->get();
			$saveincarrs =  $inc_arr->toArray();
			$data['saveincarrs'] = $saveincarrs;
			$q = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and add_size='200' and status='Publish'")->limit(2);
			$ads_obj  = $q->get();
			$ads_arr = $ads_obj->toArray();
			$data['ads_arr'] = $ads_arr;

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
			$data['builderdetail']  = $prop_arr;
			$data['title'] = 'Compare New Home Designs';
			return view('compare-property',$data);
		}
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
	
	public function save_inclusion_html($user_ip,$compare_ids)
	{
		$inc_html = '';
		$saveincids = "";
		$saveinc =  SaveInclusion::where(array('user_ip'=>$user_ip))->get(array('inclusion_id'));
		$saveincarr = $saveinc->toArray();
		foreach($saveincarr as $inc_val)
		{
			$saveincids[] = $inc_val['inclusion_id'];
		}
		$inc_arr =  Inclusion::whereIn('id',$saveincids)->get();
		$saveincarrs =  $inc_arr->toArray();
	 	$inc_html.= '<div class="inclusion-table">
       				 	<h1>Your inclusions for comparison</h1>
           					<table cellpadding="0" cellspacing="0">';
           	 $saveprop_arr = array();
           	foreach($saveincarrs as $saveinc_val) {
            	
				//	$savepropids = SaveProperty::where(array('user_ip'=>$user_ip))->get(array('property_id'));
				//$saveprop_arr = $savepropids->toArray();
				$saveprop_arr = explode(',',$compare_ids);
				if(count($saveprop_arr) == '1') {
					$saveprop_arr = array_merge($saveprop_arr,array('2'=>'','3'=>'','4'=>''));
				}
				if(count($saveprop_arr) == '2') {
					$saveprop_arr = array_merge($saveprop_arr,array('3'=>'','4'=>''));
				}
				if(count($saveprop_arr) == '3') {
					$saveprop_arr = array_merge($saveprop_arr,array('4'=>''));
				}
			}
			$inc_html .= '<tr><th></th>';
           foreach($saveprop_arr as $save_prop) {
				if(!empty($save_prop)) {
					$arr_property =  DB::table('property')->where(array('id'=>$save_prop))->get();
					if (strlen($arr_property[0]->property_title) > 20) { $inc_html .= '<th>'.substr($arr_property[0]->property_title,0,20).'...</th>'; } else { $inc_html .= "<th>".$arr_property[0]->property_title."</th>";  }
				}
			}
			$inc_html .= '</tr>';

		   foreach($saveincarrs as $saveinc_val) {
		   		$inc_html.=    '<tr>
                    			<td><div class="cp-left tree_cp"><input type="checkbox" checked="checked" data-text-'.$saveinc_val['id'].'="checked" rel="'.$saveinc_val['id'].'" value="'.$saveinc_val['id'].'"  name="compare_inc" class="compare_inc" id="saved_inc_'.$saveinc_val['id'].'"><label for="saved_inc_'.$saveinc_val['id'].'"></label></div>'.$saveinc_val['title'].'</td>';
             	foreach($saveprop_arr as $save_prop) {
					if(!empty($save_prop)) {
                   	$arr =  DB::table('property_inclusion')
						            ->where(array('property_id'=>$save_prop,'inclusion_id'=>$saveinc_val['id']))
						            ->get();
			if(!empty($arr)){
		$inc_type = 	$arr[0]->inclusion_type;
		$inclusion_type = array('Not available'=>'1','Standard inclusion'=>'2','Available as upgrade'=>'3');
	if(in_array($inc_type,$inclusion_type)) {
	//$inc_key = key($inclusion_type);
	//$inc_key = array_search($inc_type, $inclusion_type); // $key =
	if($inc_type == '1')
	$inc_key = '<i class="fa fa-minus" data-toggle="tooltip" data-placement="top" title="Not available"></i>';
	if($inc_type == '2')
	$inc_key = '<i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Standard inclusion"></i>';
	if($inc_type == '3')
	$inc_key = '<img src="'.url().'/assets/img/dollar.png" data-toggle="tooltip" data-placement="top" title="Available as upgrade" />';
	
	 $inc_html.='<td>'.$inc_key.'</td>';
	 }
	 } else {
	  $inc_html.='<td><i class="fa fa-minus" data-toggle="tooltip" data-placement="top" title="Not available"></i></td>';
	 }
					  } else { $inc_html.='<td>&nbsp;</td>'; } }
                 $inc_html.= '</tr>';
			}
               
          $inc_html.=  '</table>
       </div>'; 
	   echo $inc_html;
	   
	}
	
	
	public function ajax_save_inclusion()
	{
		if($_REQUEST['text'] == 'unchecked') {
		$compare_ids = $_REQUEST['compare_ids'];
		 $inc_id = $_REQUEST['inc_id'];
		$user_ip =  request()->ip();
		$saveinc =  SaveInclusion::where(array('user_ip'=>$user_ip,'inclusion_id'=>$inc_id))->count();
		if($saveinc == 0)
		{
			$save_inc = new SaveInclusion ;
			$save_inc->user_ip  = $user_ip ;
			$save_inc->inclusion_id = $inc_id ;
			$save_inc->save(); 
			$savehtml = $this->save_inclusion_html($user_ip,$compare_ids);
			echo $savehtml;
		}
		
		}
		if($_REQUEST['text'] == 'checked') {
		$compare_ids = $_REQUEST['compare_ids'];
		 $inc_id = $_REQUEST['inc_id'];
		$user_ip =  request()->ip();
		SaveInclusion::where(array('user_ip'=>$user_ip,'inclusion_id'=>$inc_id))->delete();
		$saveinc =  SaveInclusion::where(array('user_ip'=>$user_ip,'inclusion_id'=>$inc_id))->count();
		if($saveinc == 0)
		{
			$savehtml = $this->save_inclusion_html($user_ip,$compare_ids);
			echo $savehtml;
		}
		
		}
		
	}
	
	public function get_parent_filter_inc1()
	{
		$inc = Inclusion::where(['parent_id'=>'0'])->get();
		$inc_arr = $inc->toArray();
/* 	  echo '<pre>';
		print_r($inc_arr);  */
		$filter = Inclusion::where('filter_inclusion' , 'Yes')->get();
		$filter_arr = $filter->toArray();
		/*  echo '<pre>';
		print_r($filter_arr);  */
		$filterd_arr = "";
		foreach($inc_arr as $inc_val)
		{	
			$i=0;
			foreach($filter_arr as $filter_val)
			{
				$parent_id =  $filter_val['parent_id'];
				$get_parent = Inclusion::where('id' , $parent_id)->get();
				$parent_arr  = $get_parent->toArray();
				$root_id = $parent_arr[0]['parent_id'];
				if($root_id == $inc_val['id'])
				{
					$filterd_arr[] = $inc_val['id'] ;
				}
				$i++;
			}
		}
		
		//$filterd_arr[$i]['id'] = $inc_val['id'];
		//$filterd_arr[$i]['title'] = $inc_val['title'];
		if(!empty($filterd_arr)) {
		$unique_arr = array_unique($filterd_arr);

		 $uniques = Inclusion::whereIn('id',$unique_arr)->get();
		$uniq_arr = $uniques->toArray();
		return $uniq_arr;
		
		} else {
			$uniq_arr ="";
			return $uniq_arr;
		}
		/* foreach($inc_arr as $inc_val) */
		
		
	}
	
	public function get_parent_filter_inc()
	{
		$inc = Inclusion::where(['parent_id'=>'0'])->get();
		$inc_arr = $inc->toArray();
/* 	  echo '<pre>';
		print_r($inc_arr);  */
		$filter = Inclusion::where('filter_inclusion' , 'Yes')->get();
		$filter_arr = $filter->toArray();
		/*  echo '<pre>';
		print_r($filter_arr);  */
		$filterd_arr = "";
		foreach($inc_arr as $inc_val)
		{	
			$i=0;
			foreach($filter_arr as $filter_val)
			{
				$parent_id =  $filter_val['parent_id'];
				$get_parent = Inclusion::where('id' , $parent_id)->get();
				$parent_arr  = $get_parent->toArray();
				$root_id = $parent_arr[0]['parent_id'];
				if($root_id == $inc_val['id'])
				{
					$filterd_arr[] = $inc_val['id'] ;
				}
				$i++;
			}
		}
		
		//$filterd_arr[$i]['id'] = $inc_val['id'];
		//$filterd_arr[$i]['title'] = $inc_val['title'];
		if(!empty($filterd_arr)) {
		$unique_arr = array_unique($filterd_arr);

		 $uniques = Inclusion::whereIn('id',$unique_arr)->get();
		$uniq_arr = $uniques->toArray();
		return $uniq_arr;
		
		} else {
			$uniq_arr ="";
			return $uniq_arr;
		}
		/* foreach($inc_arr as $inc_val) */
		
		
	}
	
	
	public function compare_saved_inclusions()
	{
		$user = Auth::user();
		$user_ip =  request()->ip();
		if($user){
			$userdata = User::getuserinfo($user->id);	
		
		$saveprop = SaveProperty::where(array('user_id'=>$user->id,'type'=>'Save'))->get();
		} else {
		$saveprop = SaveProperty::where(array('user_ip'=>$user_ip,'type'=>'Save'))->get();
			
		}
		$saveproparr = $saveprop->toArray();
		foreach($saveproparr as $saveprop_val)
		{
			$prop_arr[] = $saveprop_val['property_id'];
		}
		if(!empty($prop_arr))  {
		$save_props = Property::with('builder_detail','property_gallery');
		$save_props->whereIn('id',$prop_arr);
		$save_props->where('property_type','1');
		$data['total_save_home'] = $save_props->count();
		$home_query = $save_props->get();
		$data['properties_arr'] = $home_query->toArray();
		
		$save_props1 = Property::with('builder_detail','property_gallery');
		$save_props1->whereIn('id',$prop_arr);
		$save_props1->where('property_type','2');
		$data['total_save_home_land'] = $save_props1->count();
		$home_query1 = $save_props1->get();
		$data['saved_home_land_arr'] = $home_query1->toArray();

		}
		$inc = Inclusion::where('parent_id','0')->get();
		$data['inc_arr']  = $inc->toArray() ;
		$saveprop =  SaveProperty::where(array('user_ip'=>$user_ip,'type'=>'Save'))->get(array('property_id'));
		$saveproparr = $saveprop->toArray();
		$savepropids = "";
		foreach($saveproparr as $saveprop_val)
		{
			$savepropty_arr[] = $saveprop_val['property_id'];
		}
		if(!empty($savepropty_arr))
		{
			$savepropids = implode(',',$savepropty_arr);
		}
		$data['savepropids'] = $savepropids;
		
		$q = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and add_size='300' and status='Publish'")->limit(2);
		$ads_obj  = $q->get();
		$ads_arr = $ads_obj->toArray();
		$data['ads_arr'] = $ads_arr;
		
		$results = DB::table('testimonials')->where('featured','Yes')->orderByRaw('RAND()')->limit('1')->get();
		//$results = User::where($where_arr)->builders;

		$data['testimonials'] = $results;
		
		
		$data['title'] = 'Your favourite home designs';
		return view('compare-saved-inclusions',$data);
	}
	
	

	
	
	
}
