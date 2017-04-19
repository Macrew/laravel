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
use App\Models\SaveInclusion;
use App\Models\SaveProperty;
use App\Models\PropertyDisplayHome;
use App\Models\PropertyDisplayHomeOpenHour;
use Auth;
use DB;
use Log;
use Route;

class PropertyController extends Controller
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
		$query->orderBy('featured', 'Desc');
		$query->where('status',1);
		//echo $query->getQuery()->toSql();die;
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
	
	public function change_state($state)
	{
		Session::set('header_state',$state);
		return Redirect::to('/');
	}

	public function change_state_ajax()
	{
		Session::set('header_state',$_REQUEST['state']);
		$states = State::where(['state_name' => $_REQUEST['state']])->get();
		$states_arr = $states->toArray();
		if(count($states_arr) > 0){
			return $states_arr;
		}else{
			return 'no-state';
		}

		die;
	}
	
	public function change_state_new_ajax()
	{
		Session::set('header_state',$_REQUEST['state']);
		$states = State::where(['state_name' => $_REQUEST['state']])->get();
		$states_arr = $states->toArray();
		if(count($states_arr) > 0){
			return $states_arr;
		}else{
			return 'no-state';
		}

		die;
	}
	
	public function count_save_property()
	{
		$count_property = SaveProperty::count_saved_property();
		echo $count_property;
	}
	
	public function save_property()
	{
		if($_REQUEST['save_text'] == 'Compare') {
		 $prop_id = $_REQUEST['prop_id'];
		$user_ip =  request()->ip();
		$saveprop =  SaveProperty::where(array('user_ip'=>$user_ip,'property_id'=>$prop_id,'type'=>'Compare'))->count();
		if($saveprop == 0)
		{
			$save_prop = new SaveProperty ;
			$save_prop->user_ip  = $user_ip ;
			$save_prop->property_id = $prop_id ;
			$save_prop->type = 'Compare' ;
			$save_prop->save(); 
			$savehtml = $this->save_property_html($user_ip);
			echo $savehtml;
		}
		
		}
		if($_REQUEST['save_text'] == 'Compared') {
		 $prop_id = $_REQUEST['prop_id'];
		$user_ip =  request()->ip();
		SaveProperty::where(array('user_ip'=>$user_ip,'property_id'=>$prop_id,'type'=>'Compare'))->delete();
		$saveprop =  SaveProperty::where(array('user_ip'=>$user_ip,'property_id'=>$prop_id,'type'=>'Compare'))->count();
		if($saveprop == 0)
		{
			$savehtml = $this->save_property_html($user_ip);
			echo $savehtml;
		}
		
		}
		
		
	}
	
	
	public function save_property_new()
	{
	
		$user = Auth::user();
		$user_ip =  request()->ip();
		 $prop_id = $_REQUEST['prop_id'];
		if($user){
			$userdata = App\User::getuserinfo($user->id);	

				if($_REQUEST['save_text'] == 'Save') {
		 $prop_id = $_REQUEST['prop_id'];
		$user_ip =  request()->ip();
	
		$saveprop =  SaveProperty::where(array('user_id'=>$user->id,'property_id'=>$prop_id,'type'=>'Save'))->count();
		if($saveprop == 0)
		{
			$save_prop = new SaveProperty ;
			$save_prop->user_id  = $user->id ;
			$save_prop->property_id = $prop_id ;
			$save_prop->type = 'Save' ;
			$save_prop->save(); 
			$proptyobj = Property::with('builder_detail','property_gallery')->where('id',$prop_id)->get();
			$prop_arr = $proptyobj->toArray();
			$data = array();
			$data['prop_data'] = $prop_arr;
			$data['status'] = 'Saved';
			//$prop_arr = array_merge( $prop_arr, array('LoginSavedStatus'=>'Yes') );
			$prop_arr['LoginSavedStatus'] = 'Yes';
			echo json_encode($prop_arr);
		}
		
		}
		if($_REQUEST['save_text'] == 'Saved') {
		 $prop_id = $_REQUEST['prop_id'];
		$user_ip =  request()->ip();
		SaveProperty::where(array('user_id'=>$user->id,'property_id'=>$prop_id,'type'=>'Save'))->delete();
		$saveprop =  SaveProperty::where(array('user_id'=>$user->id,'property_id'=>$prop_id,'type'=>'Save'))->count();
		if($saveprop == 0)
		{
			$proptyobj = Property::with('builder_detail','property_gallery')->where('id',$prop_id)->get();
			$prop_arr = $proptyobj->toArray();
			$data = array();
			$data['prop_data'] = $prop_arr;
			$data['status'] = 'NotSaved';
			//$prop_arr = array_merge( $prop_arr, array('LoginSavedStatus'=>'Yes') );
			$prop_arr['LoginSavedStatus'] = 'Yes';
			echo json_encode($prop_arr);
		}
		
		}
			
			
			
		}  else {
		// without login user can save 3 homes
		$saveprop =  SaveProperty::where(array('user_ip'=>$user_ip,'type'=>'Save'))->get(array('property_id'));
		$saved_prop_arr = $saveprop->toArray();
		$prop_arr = "";
		foreach($saved_prop_arr as $saveprop_val)
		{
			$prop_arr[] = $saveprop_val['property_id'];
		}
		$save_props = Property::with('builder_detail','property_gallery');
		$save_props->whereIn('id',$prop_arr);
		$save_props->where('property_type','1');
		$saved_home  = $save_props->count();
		
		$save_props1 = Property::with('builder_detail','property_gallery');
		$save_props1->whereIn('id',$prop_arr);
		$save_props1->where('property_type','2');
		$total_save_home_land = $save_props1->count();
		$prop_id = $_REQUEST['prop_id'];
		$check_prop_type = Property::where('id',$prop_id)->get();
		$prop_type_arr = $check_prop_type->toArray();
		$prop_type = $prop_type_arr['0']['property_type'];
		if($saved_home < 3 && $prop_type == '1') {
				if($_REQUEST['save_text'] == 'Save') {
		$user_ip =  request()->ip();
	
		$saveprop =  SaveProperty::where(array('user_ip'=>$user_ip,'property_id'=>$prop_id,'type'=>'Save'))->count();
		if($saveprop == 0)
		{
			$save_prop = new SaveProperty ;
			$save_prop->user_ip  = $user_ip ;
			$save_prop->property_id = $prop_id ;
			$save_prop->type = 'Save' ;
			$save_prop->save(); 
			$proptyobj = Property::with('builder_detail','property_gallery')->where('id',$prop_id)->get();
			$prop_arr = $proptyobj->toArray();
			$data = array();
			$data['prop_data'] = $prop_arr;
			//$prop_arr = array_merge( $prop_arr, array('LoginSavedStatus'=>'Yes') );
			$prop_arr['LoginSavedStatus'] = 'Yes';
			echo json_encode($prop_arr);
		}
		
		}
		}
		
		else if($total_save_home_land < 3 && $prop_type == '2') {
				if($_REQUEST['save_text'] == 'Save') {
		$user_ip =  request()->ip();
	
		$saveprop =  SaveProperty::where(array('user_ip'=>$user_ip,'property_id'=>$prop_id,'type'=>'Save'))->count();
		if($saveprop == 0)
		{
			$save_prop = new SaveProperty ;
			$save_prop->user_ip  = $user_ip ;
			$save_prop->property_id = $prop_id ;
			$save_prop->type = 'Save' ;
			$save_prop->save(); 
			$proptyobj = Property::with('builder_detail','property_gallery')->where('id',$prop_id)->get();
			$prop_arr = $proptyobj->toArray();
			$data = array();
			$data['prop_data'] = $prop_arr;
			//$prop_arr = array_merge( $prop_arr, array('LoginSavedStatus'=>'Yes') );
			$prop_arr['LoginSavedStatus'] = 'Yes';
			echo json_encode($prop_arr);
		}
		
		}
		} 
		else {
			$prop_data = array('LoginSavedStatus'=>'No');
			echo json_encode($prop_data);
		
		
		}
		if($_REQUEST['save_text'] == 'Saved') {
		 $prop_id = $_REQUEST['prop_id'];
		$user_ip =  request()->ip();
		SaveProperty::where(array('user_ip'=>$user_ip,'property_id'=>$prop_id,'type'=>'Save'))->delete();
		$saveprop =  SaveProperty::where(array('user_ip'=>$user_ip,'property_id'=>$prop_id,'type'=>'Save'))->count();
		if($saveprop == 0)
		{
			$proptyobj = Property::with('builder_detail','property_gallery')->where('id',$prop_id)->get();
			$prop_arr = $proptyobj->toArray();
			$data = array();
			$data['prop_data'] = $prop_arr;
			$data['status'] = 'NotSaved';
			$prop_arr['LoginSavedStatus'] = 'Yes';
			echo json_encode($prop_arr);
		}
		
		}
		
		
		}
	
		
		
	}
	
	
	public function save_property_html($user_ip)
	{
		$save_prop = SaveProperty::where(array('user_ip'=>$user_ip,'type'=>'Compare'))->get(array('property_id'));
		$save_prop_arr = $save_prop->toArray();
		 if(!empty($save_prop_arr))
		{
			$prop_arr = "";
			foreach($save_prop_arr as $save_prop_val)
			{
				$prop_arr[] = $save_prop_val['property_id'];
			}
		} else{
		$prop_arr = "";
		}
		 $url = url();
		$urlz = str_replace('http://www.', '', $url);
		$currentAction = Route::currentRouteAction();
		list($controller, $method) = explode('@', $currentAction);
		$controller = preg_replace('/.*\\\/', '', $controller);
		$method = preg_replace('/.*\\\/', '', $method);
		$count_homes = Property::with('builder_detail','property_gallery');
		$count_homes->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
		$count_homes->whereIn('id',$prop_arr);
		$count_homes->where('property_type','1');
		$total_homes = $count_homes->count();
		
		$count_lands = Property::with('builder_detail','property_gallery');
		$count_lands->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
		$count_lands->whereIn('id',$prop_arr);
		$count_lands->where('property_type','2');
		$total_lands = $count_lands->count();
		
		$saveprop_count = SaveProperty::where(array('user_ip'=>$user_ip,'type'=>'Compare'))->count();
		$html = '';
		$html.=	'<div class="compare-pop';
		if($controller != 'HomeController' && $method != 'index') { $html.= ' inner_ajax_content'; }
		
		$html.= '  main-pop-up" style="display:none;">' ;
		
		
   $html.= '<div class="cp-head">
   <div class="cp-row">
   <ul>
   <li id="house-div" class="comp-active"><a href="javascript:void(0)">House</a></li>
   <li id="house-land-div" ><a href="javascript:void(0)">House & Land</a></li>
   </ul>
   </div>
   <div class="cp-row" id="house-head">
        <h2><i class="fa fa-bar-chart"></i> '.$total_homes.' Compared Homes</h2>
        <p><a href="">View all saved homes</a></p>
	</div>
	<div class="cp-row" id="house-land-head" style="display:none;">
        <h2><i class="fa fa-bar-chart"></i> '.$total_lands.' Compared Homes</h2>
        <p><a href="">View all saved homes</a></p>
	</div>	
        <div class="clr"></div>
    </div>
	';
	

	$proptyobj = Property::with('builder_detail','property_gallery');
	$proptyobj->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
	$proptyobj->whereIn('id',$prop_arr);
	$proptyobj->where('property_type','1');
	$prop_house = $proptyobj->get();
	$propty_arr = $prop_house->toArray();
	if(!empty($propty_arr)) {
	$html.=	'<div class="cp-inner" id="inner-house">';
	$i=1;
	$propids = "";
	foreach($propty_arr as $prop_val)
	{
			$html.= '
			
				<div class="cp-box">
					<p class="cp-cross"><i class="fa fa-times delsaveprop"  rel="'.$prop_val['id'].'"></i></p>
					<div class="cp-left">';
					if($i <= 4)
					{
					$propids[] = $prop_val['id'];
				$html.=	'<input type="checkbox" checked=checked id="savecheck_'.$prop_val['id'].'" name="savecheck" value="'.$prop_val['id'].'" />' ;
				} else {
				
				$html.=	'<input type="checkbox" id="savecheck_'.$prop_val['id'].'" name="savecheck" value="'.$prop_val['id'].'" />' ;
				}
				$html.=		'<label for="savecheck_'.$prop_val['id'].'" ></label></div>
					<div class="cp-right">
						<div class="cp-r-top">';

$rand_key = "";
					if(!empty($prop_val['property_gallery'])) {
				  $rand_key = array_rand($prop_val['property_gallery'], 1); 
				 $prop_image =  	$prop_val['property_gallery'][$rand_key]['image'];
				
                  $html.= '<a href="'.url().'/propertydetail/'. $prop_val['id'].'"><img src="'.url().'/public/timthumb.php?src=/uploads/property_gallery/'.$prop_image.'&h=100&w=145&q=1000" alt=""></a>';
				  
				    }
					else {
					 $html.= '<a href="'.url().'/propertydetail/'. $prop_val['id'].'"><img src="'.url().'/assets/img/no-image.jpg" alt=""></a>';
					}

						  $html.=  '<a href="'.url().'/propertydetail/'. $prop_val['id'].'"><h3>'.$prop_val['property_title'].'</h3></a> 
						   <p>From $ '.number_format($prop_val['price'],2).'</p>
						</div>
						<div class="cp-r-btm">
							<span><img src="'.url().'/assets/img/bed.png" alt="bed"> '.$prop_val['bedrooms'].'</span>
							<span><img src="'.url().'/assets/img/bath.png" alt="bathroom"> '.$prop_val['bathrooms'].'</span>
							<span><img src="'.url().'/assets/img/sofa.png" alt="sofa"> '.$prop_val['living'].'</span>
							<span><img src="'.url().'/assets/img/size.png" alt="size"> '.$prop_val['housesize'].'</span>
						</div>
						<div class="cp-r-blogo">
				<a href="'.url().'/builder-detail/'.$prop_val['builder_detail']['builder_id'].'" ><img src="'.url().'/uploads/builder_logo/'.$prop_val['builder_detail']['logo'].'"/></a> 
				</div> 
					</div>
					<div class="clr"></div>
				</div>';
	$i++;
		}
		if(!empty($propids)){
			$propid = implode(',',$propids);
		} else {
		$propid="";
		}
		$html.= '</div>
		
		
<div class="cp-footer" id="house_footer">
		<input type="hidden" value="'.url().'/compare?propertyids='.$propid.'" id="compare_url">
        <input type="submit" value="Compare" class="button1 compare">
        <div class="clr"></div>
    </div>
		'; 
	} else {
	$html.=	'<div class="cp-inner" id="inner-house">';
		$html.= '<p style="text-align:center;">Save some homes to get started!</p>';
		$html.=	'</div>';
	}
	
	$proptyobj1 = Property::with('builder_detail','property_gallery');
	$proptyobj1->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
	$proptyobj1->whereIn('id',$prop_arr);
	$proptyobj1->where('property_type','2');
	$prop_house_land = $proptyobj1->get();
	$housepropty_arr = $prop_house_land->toArray();
	
	if(!empty($housepropty_arr)) {
	$html.=  '<div class="cp-inner" id="inner-house-land" style="display:none;">';
	$i=1;
	$propids = "";
	foreach($housepropty_arr as $prop_val)
	{
			$html.= '
			
				<div class="cp-box">
					<p class="cp-cross"><i class="fa fa-times delsaveprop"  rel="'.$prop_val['id'].'"></i></p>
					<div class="cp-left">';
					if($i <= 4)
					{
					$propids[] = $prop_val['id'];
				$html.=	'<input type="checkbox" checked=checked id="savehousecheck_'.$prop_val['id'].'" name="savehousecheck" value="'.$prop_val['id'].'" />' ;
				} else {
				
				$html.=	'<input type="checkbox" id="savehousecheck_'.$prop_val['id'].'" name="savehousecheck" value="'.$prop_val['id'].'" />' ;
				}
				$html.=		'<label for="savehousecheck_'.$prop_val['id'].'" ></label></div>
					<div class="cp-right">
						<div class="cp-r-top">';

$rand_key = "";
					if(!empty($prop_val['property_gallery'])) {
				  $rand_key = array_rand($prop_val['property_gallery'], 1); 
				 $prop_image =  	$prop_val['property_gallery'][$rand_key]['image'];
				 
			
                  $html.= '<a href="'.url().'/propertydetail/'. $prop_val['id'].'"><img src="'.url().'/public/timthumb.php?src=/uploads/property_gallery/'.$prop_image.'&h=100&w=145&q=1000" alt=""></a>';
				  
				    } else {
					 $html.= '<a href="'.url().'/propertydetail/'. $prop_val['id'].'"><img src="'.url().'/assets/img/no-image.jpg" alt=""></a>';
					}

						  $html.=  '<a href="'.url().'/propertydetail/'. $prop_val['id'].'"><h3>'.$prop_val['property_title'].'</h3></a> 
						   <p>From $ '.number_format($prop_val['price'],2).'</p>
						</div>
						<div class="cp-r-btm">
							<span><img src="'.url().'/assets/img/bed.png" alt="bed"> '.$prop_val['bedrooms'].'</span>
							<span><img src="'.url().'/assets/img/bath.png" alt="bathroom"> '.$prop_val['bathrooms'].'</span>
							<span><img src="'.url().'/assets/img/sofa.png" alt="sofa"> '.$prop_val['living'].'</span>
							<span><img src="'.url().'/assets/img/size.png" alt="size"> '.$prop_val['housesize'].'</span>
						</div>
						<div class="cp-r-blogo">
				<a href="'.url().'/builder-detail/'.$prop_val['builder_detail']['builder_id'].'" ><img src="'.url().'/uploads/builder_logo/'.$prop_val['builder_detail']['logo'].'"/></a> 
				</div> 
					</div>
					<div class="clr"></div>
				</div>';
	$i++;
		}
		if(!empty($propids)){
			$propid = implode(',',$propids);
		} else {
		$propid="";
		}
		$html.= '</div><div class="cp-footer" id="house_land_footer" style="display:none;">
		<input type="hidden" value="'.url().'/compare?propertyids='.$propid.'" id="compare_house_url">
        <input type="submit" value="Compare" class="button1 compare-house">
        <div class="clr"></div>
    </div>
		'; 
	} else {
	$html.=  '<div class="cp-inner" id="inner-house-land" style="display:none;">';
		$html.= '<p style="text-align:center;">Save some homes to get started!</p>';
		$html.=  '</div>';
	}
	$html.= '</div>';
		return $html;
  
	}
	
	public function delete_save_property()
	{
		if(!empty($_REQUEST['save_prop']))
		{
			$user_ip =  request()->ip();
			$prop_id = $_REQUEST['save_prop'];
			SaveProperty::where(array('property_id'=>$prop_id,'user_ip'=>$user_ip,'type'=>'Compare'))->delete();
			$savehtml = $this->save_property_html($user_ip);
			echo $savehtml;
		}
	}
	
	public function reset_site()
	{
		$user_ip =  request()->ip();
		SaveProperty::where(array('user_ip'=>$user_ip))->delete();
		SaveInclusion::where(array('user_ip'=>$user_ip))->delete();
		return Redirect::to('/');
	}
	
	
	public function search_property()
	{
		/*  echo '<pre>';
		print_r($_REQUEST);  */
		//die;
		if(!empty($_REQUEST['property_type']) || !empty($_REQUEST['bedrooms']) || !empty($_REQUEST['bathrooms']) || !empty($_REQUEST['min_price']) || !empty($_REQUEST['max_price']) || !empty($_REQUEST['search_region']) || !empty($_REQUEST['builder']) || !empty($_REQUEST['page']) || !empty($_REQUEST['main_regionchange']))
		{
			//echo 'test';
			//die;
			/*if(isset($_REQUEST['property_type'])){}
			$querystring = '?property_type='.$_REQUEST['property_type'].'&submit='.$_REQUEST['submit'].'&bedrooms='.$_REQUEST['bedrooms'].'&bathrooms='.$_REQUEST['bathrooms'].'&min_price='.$_REQUEST['min_price'].'&max_price='.$_REQUEST['max_price'].'&search_region='.$_REQUEST['search_region'];
			if(!empty($_REQUEST['builder'])){
				$querystring .= '&builder='.$_REQUEST['builder'];
			}else if(!empty($_REQUEST['page'])){
				$querystring .= '&page'.$_REQUEST['page'];
			}
			
			//echo $querystring;
			$data['querystring'] = $querystring;*/
			 $query = Property::with('builder_detail','property_gallery');
				$query->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
			
			/*  if(!empty($_REQUEST['search_region']))
			{
				$header_state = "";
				 $header_state = Session::get('header_state');
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
				$search_region = $_REQUEST['search_region'] ;
				$states = State::whereRaw("state_name LIKE '%$search_region%' || loc_name LIKE '%$search_region%'");
				//echo $states->getQuery()->toSql();
				
				$re = $states->get();
	
				$state_arr = $re->toArray();
				$states = "";

				
				foreach($state_arr as $st_val)
				{  
					if($st_val['state_name'] == $headr_state)
					{
						$states[] = $st_val['id'];
					}
				}
				
	
				if(!empty($states)) {
			  $users = UserLocation::where('user_type','Builder')->whereIn('state_id', $states)->groupBy('user_id')->get(array('user_id'));
				
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
			}
			else {
				$query = Property::with('builder_detail','property_gallery');
			 $header_state = "";
				 $header_state = Session::get('header_state');
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
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
			
			} */
			$search_region = "";$property_type="";$bedrooms="";$bathrooms="";$min_price="";$max_price="";
			$search_region = !empty($_REQUEST['search_region']) ? $_REQUEST['search_region'] : "";
			$main_regionchange = !empty($_REQUEST['main_regionchange']) ? $_REQUEST['main_regionchange'] : "";
			$property_type = !empty($_REQUEST['property_type']) ? $_REQUEST['property_type'] : "";
			$bedrooms = !empty($_REQUEST['bedrooms']) ? $_REQUEST['bedrooms'] : "";
			$bathroom = !empty($_REQUEST['bathrooms']) ? $_REQUEST['bathrooms'] : "";
			$builder = !empty($_REQUEST['builder']) ? $_REQUEST['builder'] : "";
			$min_price = !empty($_REQUEST['min_price']) ? $_REQUEST['min_price'] : "";
			$max_price = !empty($_REQUEST['max_price']) ? $_REQUEST['max_price'] : "";
			if(!empty($_REQUEST['search_region']) && $_REQUEST['search_region'] != "build-region")
			{

				$search_region = $_REQUEST['search_region'] ;

			  $users = UserLocation::where('user_type','Builder')->where('state_id', $search_region)->groupBy('user_id')->get(array('user_id'));
				
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
			else if(!empty($_REQUEST['main_regionchange']))
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
			else {
				$query = Property::with('builder_detail','property_gallery');
				$query->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
			 $header_state = "";
				 $header_state = Session::get('header_state');
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
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
			
			} 
			
			
			
			if(!empty($_REQUEST['property_type']) && $_REQUEST['property_type'] == 'Single-Storey')
			{
				$query->where('stories','1');	
			}
			if(!empty($_REQUEST['property_type']) && $_REQUEST['property_type'] == 'Double-Storey')
			{
				$query->where('stories','2');	
			}
			if(!empty($_REQUEST['property_type']) && $_REQUEST['property_type'] == 'Homes-With-Alfrescos')
			{
				$query->where('alfresco','Yes');	
			}
			if(!empty($_REQUEST['property_type']) && $_REQUEST['property_type'] == 'Dual-occupancy-Homes')
			{
				$query->where('dual_occ','Yes');	
			}
			if(!empty($_REQUEST['property_type']) && $_REQUEST['property_type'] == 'Custom-Designs')
			{
				$query->where('property_type','3');	
			}

			
			if(!empty($_REQUEST['bedrooms']) && $_REQUEST['bedrooms'] != 'Bedrooms')
			{
				$bedroom = $_REQUEST['bedrooms'];
				if($bedroom == '1') 
				{
					$query->where('bedrooms' , $bedroom);
				}
				if($bedroom == '1plus') 
				{
					$bedroom = '1' ;
					$query->where('bedrooms' , '>=' , $bedroom);
				}
				if($bedroom == '2') 
				{
					$query->where('bedrooms' , $bedroom);
				}
				if($bedroom == '2plus') 
				{
					$bedroom = '2' ;
					$query->where('bedrooms' , '>=' , $bedroom);
				}
				if($bedroom == '3') 
				{
					$query->where('bedrooms' , $bedroom);
				}
				if($bedroom == '3plus') 
				{
					$bedroom = '3' ;
					$query->where('bedrooms' , '>=' , $bedroom);
				}
				if($bedroom == '4') 
				{
					$query->where('bedrooms' , $bedroom);
				}
				if($bedroom == '4plus') 
				{
					$bedroom = '4' ;
					$query->where('bedrooms' , '>=' , $bedroom);
				}
				if($bedroom == '5') 
				{
					$query->where('bedrooms' , $bedroom);
				}
				if($bedroom == '5plus') 
				{
					$bedroom = '5' ;
					$query->where('bedrooms' , $bedroom);
				}
					//$where.= whereIn('user_id',$user_ar)->get();
			}
			if(!empty($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] != 'Bathrooms')
			{
				$bathroom = $_REQUEST['bathrooms'];
				if($bathroom == '1') 
				{
					$query->where('bathrooms' , $bathroom);
				}
				if($bathroom == '1plus') 
				{
					$bathroom = '1' ;
					$query->where('bathrooms' , '>=' , $bathroom);
				}
				if($bathroom == '2') 
				{
					$query->where('bathrooms' , $bathroom);
				}
				if($bathroom == '2plus') 
				{
					$bathroom = '2' ;
					$query->where('bathrooms' , '>=' , $bathroom);
				}
				if($bathroom == '3') 
				{
					$query->where('bathrooms' , $bathroom);
				}
				if($bathroom == '3plus') 
				{
					$bathroom = '3' ;
					$query->where('bathrooms' , '>=' , $bathroom);
				}
				if($bathroom == '4') 
				{
					$query->where('bathrooms' , $bathroom);
				}
				if($bathroom == '4plus') 
				{
					$bathroom = '4' ;
					$query->where('bathrooms' , '>=' , $bathroom);
				}
				if($bathroom == '5') 
				{
					$query->where('bathrooms' , $bathroom);
				}
				if($bathroom == '5plus') 
				{
					$bathroom = '5' ;
					$query->where('bathrooms' , $bathroom);
				}
					
					
			}
			
			if(!empty($_REQUEST['min_price']) && $_REQUEST['min_price'] !=  "min-price"   &&  !empty($_REQUEST['max_price']) && $_REQUEST['max_price'] != "max-price")
			{
				  $min_price = str_replace(',' , '' , $_REQUEST['min_price']);
				  $max_price = str_replace(',' , '' , $_REQUEST['max_price']);
				 $query->whereBetween('price', [$min_price, $max_price]);
			}
			
			if(!empty($_REQUEST['builder']))
			{
				 $builder = $_REQUEST['builder'];
				 $query->where('user_id' , $builder);	
			}
		
			$query->orderBy('featured', 'desc')->orderBy('featured_order', 'asc');
			$query->where('property.status',1);
			$query->where('property_type','1');
			$query->Orwhere('property_type','3');
			$page	=	"" ;
			$lastpage	=	"" ;
			$numrows  = "" ;
			$total_prop = $this->count_search_property($property_type,$bedrooms,$bathroom,$min_price,$max_price,$search_region,$builder,$main_regionchange);
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
			//$query->where('builder_details.trash' , 'no');	
			//echo  $query->getQuery()->toSql();
			$results = $query->get();
			$data['properties_arr'] = $results->toArray();
			/*   echo '<pre>';
			print_r($data['properties_arr']);  
			die; */
			$header_state = "";
			$header_state = Session::get('header_state');
			 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
			$data['build_location'] = State::where(['state_name' => $headr_state])->get();
		 
			$data['total_prop'] = $total_prop;
				
			
			 $main_regionchange = $headr_state ;
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

			$bquery = BuilderDetail::whereIn('builder_id',$user_ar);
			$builder  = $bquery->where('trash','no')->get();
			$data['builder_arr'] = $builder->toArray();
			
			//$inc = Inclusion::where(['parent_id'=>'0'])->get();
			$inc = Inclusion::where('parent_id','0')->get();
			$data['inc_arr']  = $inc->toArray() ;
			$data['max_price'] = Property::max('price');
			$data['min_price'] = Property::min('price');
			$data['min_block_width'] = Property::min('min_block_width');
			$data['max_block_width'] = Property::max('min_block_width');
			$data['min_block_length'] = Property::min('min_block_length');
			$data['max_block_length'] = Property::max('min_block_length');
			$data['min_house_size'] = Property::min('housesize');
			$data['max_house_size'] = Property::max('housesize');
			$data['builder_arr'] = $builder->toArray();
			/* $inc = Inclusion::where(['filter_inclusion'=>'Yes'])->get();
			$data['filter_inc_arr']  = $inc->toArray(); */
/* 			$q = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and add_size='200' and status='Publish'")->limit(1);
			//echo  $q->getQuery()->toSql();
			$ads_obj  = $q->get();
			$ads_arr = $ads_obj->toArray();
			$data['ads_arr'] = $ads_arr; */
			
			$q1 = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and  add_size<='100' and status='Publish'")->limit(1);
			// $q->getQuery()->toSql();
			$ads_obj1  = $q1->get();
			$ads_arr1 = $ads_obj1->toArray();
			$data['search_verticle_ads'] = $ads_arr1;
			
			$q2 = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and  (add_size<='400' and add_size > '300') and status='Publish'")->limit(1);
			// $q->getQuery()->toSql();
			$ads_obj2  = $q2->get();
			$ads_arr2 = $ads_obj2->toArray();
			$data['search_horizontal_ads'] = $ads_arr2;
			$results = DB::table('testimonials')->where('featured','Yes')->orderByRaw('RAND()')->limit('1')->get();
			//$results = User::where($where_arr)->builders;

			$data['testimonials'] = $results;
			$builderdetail = DB::table('builder_details')
            ->join('users_locations', 'builder_details.builder_id', '=', 'users_locations.user_id')
            ->join('states', 'users_locations.state_id', '=', 'states.id')
            ->distinct('states.state_name')
			->where(array('builder_details.trash'=>'no','states.trash'=>'no'))
            ->select('builder_details.*', 'states.state_name')
			->orderBy(DB::raw('RAND()'))
			->limit('10')
            ->get();

			$data['builder_detail_arr'] = $builderdetail;
			$data['title'] = 'Search New Home Designs';
			return view('search-property',$data);
			
		} else {
		 $query = Property::with('builder_detail','property_gallery');
				$query->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
			$query->orderBy('featured', 'desc')->orderBy('featured_order', 'asc');
			$query->where('property.status',1);
			$query->where('property_type','1');
			$query->Orwhere('property_type','3');
			$page	=	"" ;
			$lastpage	=	"" ;
			$numrows  = "" ;
			$property_type="";$bedrooms="";$bathroom="";$min_price="";$max_price="";$search_region="";$builder="";$main_regionchange="";
			$total_prop = $this->count_search_property($property_type,$bedrooms,$bathroom,$min_price,$max_price,$search_region,$builder,$main_regionchange);
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
			//$query->where('builder_details.trash' , 'no');	
			//echo  $query->getQuery()->toSql();
			$results = $query->get();
			$data['properties_arr'] = $results->toArray();
			/*  echo '<pre>';
			print_r($data['properties_arr']);  */
			$header_state = "";
			$header_state = Session::get('header_state');
			$headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
			$data['build_location'] = State::where(['state_name' => $headr_state])->get();
		 
			$data['total_prop'] = $total_prop;
			$builder = BuilderDetail::where('trash','no')->get();
			$data['builder_arr'] = $builder->toArray();
			//$inc = Inclusion::where(['parent_id'=>'0'])->get();
			$inc = Inclusion::where('parent_id','0')->get();
			$data['inc_arr']  = $inc->toArray() ;
			$data['max_price'] = Property::max('price');
			$data['min_price'] = Property::min('price');
			$data['min_block_width'] = Property::min('min_block_width');
			$data['max_block_width'] = Property::max('min_block_width');
			$data['min_block_length'] = Property::min('min_block_length');
			$data['max_block_length'] = Property::max('min_block_length');
			$data['min_house_size'] = Property::min('housesize');
			$data['max_house_size'] = Property::max('housesize');
			$data['builder_arr'] = $builder->toArray();
			
			/* $q = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and add_size='200' and status='Publish'")->limit(1);
			//echo  $q->getQuery()->toSql();
			$ads_obj  = $q->get();
			$ads_arr = $ads_obj->toArray();
			$data['ads_arr'] = $ads_arr; */
			
			$q1 = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and  add_size<='100' and status='Publish'")->limit(1);
			//$q->getQuery()->toSql();
			$ads_obj1  = $q1->get();
			$ads_arr1 = $ads_obj1->toArray();
			$data['search_verticle_ads'] = $ads_arr1;
			
			$q2 = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and  (add_size<='400' and add_size > '300') and status='Publish'")->limit(1);
			 //$q->getQuery()->toSql();
			$ads_obj2  = $q2->get();
			$ads_arr2 = $ads_obj2->toArray();
			$data['search_horizontal_ads'] = $ads_arr2;
			
			$results = DB::table('testimonials')->where('featured','Yes')->orderByRaw('RAND()')->limit('1')->get();
			//$results = User::where($where_arr)->builders;

			$data['testimonials'] = $results;
			
			$builderdetail = DB::table('builder_details')
            ->join('users_locations', 'builder_details.builder_id', '=', 'users_locations.user_id')
            ->join('states', 'users_locations.state_id', '=', 'states.id')
            ->distinct('states.state_name')
			->where(array('builder_details.trash'=>'no','states.trash'=>'no'))
            ->select('builder_details.*', 'states.state_name')
			->orderBy(DB::raw('RAND()'))
			->limit('10')
            ->get();

			$data['builder_detail_arr'] = $builderdetail;
			//$ads_arr = $ads->toArray();
			//$data['ads_arr'] = $ads_arr;
			/* $inc = Inclusion::where(['filter_inclusion'=>'Yes'])->get();
			$data['filter_inc_arr']  = $inc->toArray(); */
					
			$data['title'] = 'Search New Home Designs';
			$data['querystring'] = $_REQUEST;
			return view('search-property',$data);
		
		}
	}
	
	public function count_search_property($prop_type="",$beds="",$baths="",$min_price="",$max_price="",$search_region="",$builder="",$main_regionchange="")
	{

		if(!empty($prop_type) || !empty($beds) || !empty($baths) || !empty($min_price) || !empty($max_price) || !empty($search_region) || !empty($builder))
		{
			 $query = Property::with('builder_detail','property_gallery');
			 $query->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
			//echo  $_REQUEST['search_region'];
			  if(!empty($_REQUEST['search_region']) && $_REQUEST['search_region'] != "build-region")
			{
	
				$search_region = $_REQUEST['search_region'] ;

			  $users = UserLocation::where('user_type','Builder')->where('state_id', $search_region)->groupBy('user_id')->get(array('user_id'));
				
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
			else if(!empty($_REQUEST['main_regionchange']))
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
			else {
				$query = Property::with('builder_detail','property_gallery');
				$query->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
			 $header_state = "";
				 $header_state = Session::get('header_state');
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
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
			
			}
			
			
			
			
			if(!empty($_REQUEST['property_type']) && $_REQUEST['property_type'] == 'Single-Storey')
			{
				$query->where('stories','1');	
			}
			if(!empty($_REQUEST['property_type']) && $_REQUEST['property_type'] == 'Double-Storey')
			{
				$query->where('stories','2');	
			}
			if(!empty($_REQUEST['property_type']) && $_REQUEST['property_type'] == 'Homes-With-Alfrescos')
			{
				$query->where('alfresco','Yes');	
			}
			if(!empty($_REQUEST['property_type']) && $_REQUEST['property_type'] == 'Dual-occupancy-Homes')
			{
				$query->where('dual_occ','Yes');	
			}
			if(!empty($_REQUEST['property_type']) && $_REQUEST['property_type'] == 'Custom-Designs')
			{
				$query->where('property_type','3');	
			}
			if(!empty($_REQUEST['bedrooms']) && $_REQUEST['bedrooms'] != 'Bedrooms')
			{
			$bedroom = $_REQUEST['bedrooms'];
			if($bedroom == '1') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '1plus') 
			{
				$bedroom = '1' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '2') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '2plus') 
			{
				$bedroom = '2' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '3') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '3plus') 
			{
				$bedroom = '3' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '4') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '4plus') 
			{
				$bedroom = '4' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '5') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '5plus') 
			{
				$bedroom = '5' ;
				$query->where('bedrooms' , $bedroom);
			}
				//$where.= whereIn('user_id',$user_ar)->get();
		}
		if(!empty($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] != 'Bathrooms')
		{
			$bathroom = $_REQUEST['bathrooms'];
			if($bathroom == '1') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '1plus') 
			{
				$bathroom = '1' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '2') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '2plus') 
			{
				$bathroom = '2' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '3') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '3plus') 
			{
				$bathroom = '3' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '4') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '4plus') 
			{
				$bathroom = '4' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '5') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '5plus') 
			{
				$bathroom = '5' ;
				$query->where('bathrooms' , $bathroom);
			}
				
				
		}
		
		if(!empty($_REQUEST['min_price']) && $_REQUEST['min_price'] !=  "min-price"   &&  !empty($_REQUEST['max_price']) && $_REQUEST['max_price'] != "max-price")
		{
			  $min_price = str_replace(',' , '' , $_REQUEST['min_price']);
			  $max_price = str_replace(',' , '' , $_REQUEST['max_price']);
			 $query->whereBetween('price', [$min_price, $max_price]);
		}
		
		if(!empty($_REQUEST['builder']))
		{
			 $builder = $_REQUEST['builder'];
			 $query->where('user_id' , $builder);	
		}
			
			$query->orderBy('featured', 'desc');
			$query->where('status',1);
			$query->where('property_type','1');
			$query->Orwhere('property_type','3');
			//echo $query->getQuery()->toSql();
			$total_prop =  $query->count();
			return $total_prop; 
			
		} else {
			 $query = Property::with('builder_detail','property_gallery');
			 $query->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
			$query->where('status',1);
			$query->where('property_type','1');
			$query->Orwhere('property_type','3');
			//echo $query->getQuery()->toSql();
			$total_prop =  $query->count();
			return $total_prop; 
		}
	}
	
	
	public function get_property_html($prop_data,$page,$lastpage,$numrows,$currentpage,$rows_per_page)
	{

	 /* 	echo '<pre>';
		print_r($properties_arr);  */
				$html= '';
		if(!empty($prop_data)) {
		 $html.='<div id="ajaxloader"></div>';
		foreach($prop_data as $prop_val) {
	
	    $html.= '<div class="featured-box search-featured-box">
                <div class="featured-image">
                    <div class="featured-strip">
                        <div class="featured-strip-box"><a href="javascript:void(0);" class="open_quicklook"   data-target=".quick-look-modal" data-id = "'.$prop_val['id'].'"><img src="'.url().'/assets/images/featured-strip-icon1.png" alt="featured" /><span>View</span></a></div>
                        <div class="featured-strip-box"><a class="open_enquirybox" value="Enquire to Builders"  data-target=".bs-example-modal-lg" data-id = "'.$prop_val['id'].'"  href="javascript:void(0);" data-toggle="modal"><img src="'.url().'/assets/images/featured-strip-icon2.png" alt="featured" /><span>Enquire</span></a></div>
                                               <div class="featured-strip-box">';
						$check_save_prop =  App\Models\SaveProperty::check_save_prop($prop_val['id']) ; 
						$html.= '<a href="javascript:void(0);" rel="'.$prop_val['id'].'" class="save_property" >';
						if($check_save_prop != '0') { 
						
						$html.= '<img src="'.url().'/assets/images/featured-strip-icon-blue.png" alt="featured" id="compare_src_'.$prop_val['id'].'" />';
						 } else { 
						$html.= '<img src="'.url().'/assets/images/featured-strip-icon3.png" id="compare_src_'.$prop_val['id'].'" alt="featured" />';
						}
					$html.=	'<span id="save_text_'.$prop_val['id'].'">Compare</span></a>
						<input type="hidden" value="' ;
						if($check_save_prop != '0') { $html.= 'Compared' ; } else { $html.= 'Compare' ; } $html.= 'id="comp_text_'.$prop_val['id'].'"/> 
						</div>
                        <div class="featured-strip-box"></div>
                    </div>
					 <div class="model_img">';
					
					
					if(!empty($prop_val['property_gallery'])) {
						foreach($prop_val['property_gallery'] as $prop_img) {
						
							$html.= '<a href="'.url().'/propertydetail/'.$prop_val['id'].'"><img class="img-full" src="'.url().'/public/timthumb.php?src=/uploads/property_gallery/'.$prop_img['image'].'&h=400&w=700&q=100" class="gal_img" /></a>';
						}
					
					} else {
					
					$html.= '<a href="'.url().'/propertydetail/'.$prop_val['id'].'"><img src="'.url().'/assets/img/no-image.jpg" class="img-full" /></a>';
					}
					
					
								
				$html.= '</div>
                </div>
                <div class="featured-box-btm">
                    <ul>
                        <li><span class="features"><a href=""><img src="'.url().'/assets/images/bed-icon.png" alt="Beds" /></a></span><p><span>'.$prop_val['bedrooms'].'</span> Beds</p></li>
                        <li><span class="features"><a href=""><img src="'.url().'/assets/images/bath-icon.png" alt="Beds" /></a></span><p><span>'.$prop_val['bathrooms'].'</span> Bath</p></li>
                        <li><span class="features"><a href=""><img src="'.url().'/assets/images/living-icon.png" alt="Beds" /></a></span><p><span>'.$prop_val['living'].'</span> Living</p></li>
                        <li><span class="features"><a href=""><img src="'.url().'/assets/images/area-icon.png" alt="Beds" /></a></span><p><span>'.$prop_val['housesize'].'</span> Sq</p></li>
                    </ul>
                    <div class="featured-price">
					<h4>'.$prop_val['property_title'].'</h4>
                        <p>From $'.number_format($prop_val['price'],2).'</p>
						<img src="'.url().'/uploads/builder_logo/'.$prop_val['builder_detail']['logo'].'" class="featured-logo" alt="image"/>
                    </div>
                    
                    <h5>';
					
					if(!empty($prop_val['description'])) {  $string = strip_tags($prop_val['description']);

if (strlen($string) > 115) {

    // truncate string
    $stringCut = substr($string, 0, 115);

    // make sure it ends in a word so assassinate doesn't become ass...
    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
}
$html.= $string; ; } 
$html.= '</h5>
                </div>
            </div>';
	
	
	
          
                            	
		}

$ptemp = url().'/property/search-property?';
		 $pages = '';

$pages.='<div class="clr"></div> <ul class="pagination">';
//echo $whereStr;
	if ($currentpage != 1) 
{ //GOING BACK FROM PAGE 1 SHOULD NOT BET ALLOWED
 $previous_page = $currentpage - 1;
 //$previous = '<a href="'.$ptemp.'?pageno='.$previous_page.'"> </a> '; 
$previous = '&lt;Previous' ;
 $pages.= "<li><a  href=\"javascript:void(0)\"  class=\"pagi\" rel=".$previous_page." >" . $previous . "</a>\n</li>";    
}

$adjacents = 2;
/* $a=1;
foreach($properties_arr as $prop_values) 
{
  if ($a == $currentpage) 
  $pages .= '<li><a href="#" class="active">'. $a .'</a></li>';
  else 
 $pages .= '<li><a href="'.$ptemp.'page='.$a.$whereStr1.'">'. $a .'</a></li>';
 $a++;
} */

   $pmin = ($currentpage > $adjacents) ? ($currentpage - $adjacents) : 1;
     $pmax = ($currentpage < ($lastpage - $adjacents)) ? ($currentpage + $adjacents) : $lastpage;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $currentpage) {
            $pages.= "<li  class=\"active\"><a href='#'>" . $i . "</a></li>\n";
        } elseif ($i == 1) {
            $pages.= "<li><a  href=\"javascript:void(0)\"  class=\"pagi\" rel=".$i.">" . $i . "</a>\n</li>";
        } else {
            $pages.= "<li><a  href=\"javascript:void(0)\"  class=\"pagi\" rel=".$i." >" . $i . "</a>\n</li>";
        }
    }
	
	
    

//$pages = substr($pages,0,-1); //REMOVING THE LAST COMMA (,)

if($currentpage != $lastpage) 
{

 //GOING AHEAD OF LAST PAGE SHOULD NOT BE ALLOWED
 $next_page = $currentpage + 1;
 $next = 'Next&gt;';
$pages.= "<li><a  href=\"javascript:void(0)\"  class=\"pagi\" rel=".$next_page." >" . $next . "</a>\n</li>";
}
$pages.='</ul>';
$html.=  $pages ; //PAGINATION LINKS

		} else {
				$html.= '<div id="ajaxloader"></div><h2>No results</h2><br/><p>
There are no products matching your search criteria. Try making your filters less specific.</p>';

			}
			
			
		
		return $html ;
	}
	
	public function ajax_filter_properties()
	{
		if(!empty($_REQUEST['build_location'])  || !empty($_REQUEST['bedroom']) || !empty($_REQUEST['bathrooms']) || !empty($_REQUEST['living_spaces']) || !empty($_REQUEST['car_spaces']) || !empty($_REQUEST['floor_count']) || !empty($_REQUEST['alfresco']) || !empty($_REQUEST['duplex']) || !empty($_REQUEST['builder']) || !empty($_REQUEST['min_price_val']) || !empty($_REQUEST['max_price_val'])  || !empty($_REQUEST['sort_prop'])  || !empty($_REQUEST['page'])) {
		$query = Property::with('builder_detail','property_gallery');
		$query->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
		if(!empty($_REQUEST['build_location']) && $_REQUEST['build_location'] != "Build Location")
		{
			$loc_id = $_REQUEST['build_location'];
			$users = UserLocation::where('state_id', $loc_id)->groupBy('user_id')->get(array('user_id'));
			$users_arr = $users->toArray();
			$user_ar = "";
			foreach($users_arr as $user_val)
			{
				$user_ar[] = $user_val['user_id'];
			}
			///$userstring = "'" . implode("','", $user_ar) . "'";
			//$wherein.= "->whereIn(user_id,".$userstring.")";
			
			$query->whereIn('user_id',$user_ar);
			
			//$results = Property::with('builder_detail','property_gallery')->$where ;
			//$prop = $results->toArray();
		}
		else {
			 $header_state = "";
				 $header_state = Session::get('header_state');
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
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
			
			} 
		
		if(!empty($_REQUEST['bedroom']) && $_REQUEST['bedroom'] != 'Bedrooms')
		{
			$bedroom = $_REQUEST['bedroom'];
			if($bedroom == '1') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '1plus') 
			{
				$bedroom = '1' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '2') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '2plus') 
			{
				$bedroom = '2' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '3') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '3plus') 
			{
				$bedroom = '3' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '4') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '4plus') 
			{
				$bedroom = '4' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '5') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '5plus') 
			{
				$bedroom = '5' ;
				$query->where('bedrooms' , $bedroom);
			}
				//$where.= whereIn('user_id',$user_ar)->get();
		}
		if(!empty($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] != 'Bathrooms')
		{
			$bathroom = $_REQUEST['bathrooms'];
			if($bathroom == '1') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '1plus') 
			{
				$bathroom = '1' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '2') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '2plus') 
			{
				$bathroom = '2' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '3') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '3plus') 
			{
				$bathroom = '3' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '4') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '4plus') 
			{
				$bathroom = '4' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '5') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '5plus') 
			{
				$bathroom = '5' ;
				$query->where('bathrooms' , $bathroom);
			}
				
				
		}
		if(!empty($_REQUEST['living_spaces']) && $_REQUEST['living_spaces'] != 'Living Spaces')
		{
			 $living_spaces = $_REQUEST['living_spaces'];
			if($living_spaces == '1') 
			{
				$query->where('living' , $living_spaces);
			}
			if($living_spaces == '1plus') 
			{
				$living_spaces = '1' ;
				$query->where('living' , '>=' , $living_spaces);
			}
			if($living_spaces == '2') 
			{
				$query->where('living' , $living_spaces);
			}
			if($living_spaces == '2plus') 
			{
				$living_spaces = '2' ;
				$query->where('living' , '>=' , $living_spaces);
			}
			if($living_spaces == '3') 
			{
				$query->where('living' , $living_spaces);
			}
			if($living_spaces == '3plus') 
			{
				$living_spaces = '3' ;
				$query->where('living' , '>=' , $living_spaces);
			}
			if($living_spaces == '4') 
			{
				$query->where('living' , $living_spaces);
			}
			if($living_spaces == '4plus') 
			{
				$living_spaces = '4' ;
				$query->where('living' , '>=' , $living_spaces);
			}
	
		}
		
		if(!empty($_REQUEST['car_spaces']) && $_REQUEST['car_spaces'] != 'Car Spaces')
		{
			 $car_spaces = $_REQUEST['car_spaces'];
			if($car_spaces == '1') 
			{
				$query->where('cars' , $car_spaces);
			}
			if($car_spaces == '1plus') 
			{
				$car_spaces = '1' ;
				$query->where('cars' , '>=' , $car_spaces);
			}
			if($car_spaces == '2') 
			{
				$query->where('cars' , $car_spaces);
			}
			if($car_spaces == '2plus') 
			{
				$car_spaces = '2' ;
				$query->where('cars' , '>=' , $car_spaces);
			}
			if($car_spaces == '3') 
			{
				$query->where('cars' , $car_spaces);
			}
			if($car_spaces == '3plus') 
			{
				$car_spaces = '3' ;
				$query->where('cars' , '>=' , $car_spaces);
			}
		}
		
		if(!empty($_REQUEST['floor_count']) && $_REQUEST['floor_count'] != 'Stories')
		{
			 $floor_count = $_REQUEST['floor_count'];
			$query->where('stories' , $floor_count);	
		}
		
		if(!empty($_REQUEST['alfresco']) && $_REQUEST['alfresco'] != 'Alfresco')
		{
			 $alfresco = $_REQUEST['alfresco'];
			$query->where('alfresco' , $alfresco);	
		}
		if(!empty($_REQUEST['duplex']) && $_REQUEST['duplex'] != 'duplex')
		{
			 $duplex = $_REQUEST['duplex'];
			 $query->where('dual_occ' , $duplex);	
		}
		if(!empty($_REQUEST['builder']) && $_REQUEST['builder'] != 'Specific Builder')
		{
			 $builder = $_REQUEST['builder'];
			 $query->where('user_id' , $builder);	
		}
		
		if(!empty($_REQUEST['min_price_val']) && !empty($_REQUEST['max_price_val']))
		{
			  $min_price = str_replace(',' , '' , $_REQUEST['min_price_val']);
			  $max_price = str_replace(',' , '' , $_REQUEST['max_price_val']);
			 $query->whereBetween('price', [$min_price, $max_price]);
		}
		
		if(!empty($_REQUEST['min_block_width']) && !empty($_REQUEST['max_block_width']))
		{
			  $min_block_width = $_REQUEST['min_block_width'];
			  $max_block_width = $_REQUEST['max_block_width'];
			 $query->whereBetween('min_block_width', [$min_block_width, $max_block_width]);
		}
		
		if(!empty($_REQUEST['min_block_length']) && !empty($_REQUEST['max_block_length']))
		{
			  $min_block_length = $_REQUEST['min_block_length'];
			  $max_block_length = $_REQUEST['max_block_length'];
			 $query->whereBetween('min_block_length', [$min_block_length, $max_block_length]);
		}
		
		if(!empty($_REQUEST['min_house_size']) && !empty($_REQUEST['max_house_size']))
		{
			  $min_house_size = $_REQUEST['min_house_size'];
			  $max_house_size = $_REQUEST['max_house_size'];
			 $query->whereBetween('housesize', [$min_house_size, $max_house_size]);
		}
		
		if(!empty($_REQUEST['sort_prop']) && $_REQUEST['sort_prop'] != 'Select')
		{
			if($_REQUEST['sort_prop'] == 'base_price:asc')
			{
				$query->orderBy('price', 'ASC');
			}
			if($_REQUEST['sort_prop'] == 'base_price:desc')
			{
				$query->orderBy('price', 'DESC');
			}
			if($_REQUEST['sort_prop'] == 'model_name:asc')
			{
				$query->orderBy('property_title', 'ASC');
			}
			if($_REQUEST['sort_prop'] == 'model_name:desc')
			{
				$query->orderBy('property_title', 'DESC');
			}
			if($_REQUEST['sort_prop'] == 'builder_name:asc')
			{

				$builders = BuilderDetail::orderBy('company_name','asc')->get(array('builder_id'));
				$builders_arr = $builders->toArray();
				$builder = "";
				$builderids = "";
				if(!empty($builders_arr)) {
				foreach($builders_arr as $builder_val)
				{
					$builder[] = $builder_val['builder_id'];
				}
				$builderids = implode(',', $builder);
				if(!empty($builderids)) {
				$query->orderByRaw(DB::raw("FIELD(user_id, $builderids)"));
				}
				}
			
			}
			if($_REQUEST['sort_prop'] == 'builder_name:desc')
			{
				$builders = BuilderDetail::orderBy('company_name','desc')->get(array('builder_id'));
				$builders_arr = $builders->toArray();
				$builder = "";
				$builderids = "";
				if(!empty($builders_arr)) {
				foreach($builders_arr as $builder_val)
				{
					$builder[] = $builder_val['builder_id'];
				}
				$builderids = implode(',', $builder);
				if(!empty($builderids)) {
				$query->orderByRaw(DB::raw("FIELD(user_id, $builderids)"));
				}
				}
				
			} 
			
		}
		
			if(!empty($_REQUEST['incids']))
			{
				$incids_arr = explode(',',$_REQUEST['incids']);
				$prop_inc   =   PropertyInclusion::whereIn('inclusion_id',$incids_arr)->groupBy('property_id')->get(array('property_id'));
				$propids_arr = $prop_inc->toArray();
				$propidsarr = "";
				if(!empty($propids_arr)) {
				foreach($propids_arr as $propid_val)
				{
					$propidsarr[] = $propid_val['property_id'];
				}
				$query->whereIn('id',$propidsarr);
				}
				
			}
		$query->orderBy('featured', 'Desc');
		$query->where('status',1);
		$query->where('property_type','1');
	    $query->Orwhere('property_type','3');
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
			
			$data['page'] = $page;
			$data['lastpage'] = $lastpage;
			$data['numrows'] = $numrows;
			$data['currentpage'] = $currentpage;
			$query->limit($rows_per_page);
			$query->offset($start);
			
		  $query->getQuery()->toSql();
	//	$query->limit(10);
		$results = $query->get();
		$prop = $results->toArray();
	/* 	echo '<pre>';
		print_r($prop); */

		$html = $this->get_property_html($prop,$page,$lastpage,$numrows,$currentpage,$rows_per_page);
		echo $html ;
		/* echo '<pre>';
		print_r($prop); */

		}
	}
	
	public function ajax_filter_count_properties()
	{
		if(!empty($_REQUEST['build_location'])  || !empty($_REQUEST['bedroom']) || !empty($_REQUEST['bathrooms']) || !empty($_REQUEST['living_spaces']) || !empty($_REQUEST['car_spaces']) || !empty($_REQUEST['floor_count']) || !empty($_REQUEST['alfresco']) || !empty($_REQUEST['duplex']) || !empty($_REQUEST['builder']) || !empty($_REQUEST['min_price_val']) || !empty($_REQUEST['max_price_val'])) {
		$query = Property::with('builder_detail','property_gallery');
		$query->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
		if(!empty($_REQUEST['build_location']) && $_REQUEST['build_location'] != "Build Location")
		{
			$loc_id = $_REQUEST['build_location'];
			$users = UserLocation::where('state_id', $loc_id)->groupBy('user_id')->get(array('user_id'));
			$users_arr = $users->toArray();
			$user_ar = "";
			foreach($users_arr as $user_val)
			{
				$user_ar[] = $user_val['user_id'];
			}
			
			
			///$userstring = "'" . implode("','", $user_ar) . "'";
			//$wherein.= "->whereIn(user_id,".$userstring.")";
			$query->whereIn('user_id',$user_ar);
			
			//$results = Property::with('builder_detail','property_gallery')->$where ;
			//$prop = $results->toArray();
		} else {
				$query = Property::with('builder_detail','property_gallery');
				$query->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
			 $header_state = "";
				 $header_state = Session::get('header_state');
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
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
			
			}
		
		if(!empty($_REQUEST['bedroom']) && $_REQUEST['bedroom'] != 'Bedrooms')
		{
			$bedroom = $_REQUEST['bedroom'];
			if($bedroom == '1') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '1plus') 
			{
				$bedroom = '1' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '2') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '2plus') 
			{
				$bedroom = '2' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '3') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '3plus') 
			{
				$bedroom = '3' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '4') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '4plus') 
			{
				$bedroom = '4' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '5') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '5plus') 
			{
				$bedroom = '5' ;
				$query->where('bedrooms' , $bedroom);
			}
				//$where.= whereIn('user_id',$user_ar)->get();
		}
		if(!empty($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] != 'Bathrooms')
		{
			 $bathroom = $_REQUEST['bathrooms'];
			if($bathroom == '1') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '1plus') 
			{
				$bathroom = '1' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '2') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '2plus') 
			{
				$bathroom = '2' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '3') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '3plus') 
			{
				$bathroom = '3' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '4') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '4plus') 
			{
				$bathroom = '4' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '5') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '5plus') 
			{
				$bathroom = '5' ;
				$query->where('bathrooms' , $bathroom);
			}
				
				
		}
		if(!empty($_REQUEST['living_spaces']) && $_REQUEST['living_spaces'] != 'Living Spaces')
		{
			 $living_spaces = $_REQUEST['living_spaces'];
			if($living_spaces == '1') 
			{
				$query->where('living' , $living_spaces);
			}
			if($living_spaces == '1plus') 
			{
				$living_spaces = '1' ;
				$query->where('living' , '>=' , $living_spaces);
			}
			if($living_spaces == '2') 
			{
				$query->where('living' , $living_spaces);
			}
			if($living_spaces == '2plus') 
			{
				$living_spaces = '2' ;
				$query->where('living' , '>=' , $living_spaces);
			}
			if($living_spaces == '3') 
			{
				$query->where('living' , $living_spaces);
			}
			if($living_spaces == '3plus') 
			{
				$living_spaces = '3' ;
				$query->where('living' , '>=' , $bathroom);
			}
			if($living_spaces == '4') 
			{
				$query->where('living' , $bathroom);
			}
			if($living_spaces == '4plus') 
			{
				$living_spaces = '4' ;
				$query->where('living' , '>=' , $living_spaces);
			}
	
		}
		
		if(!empty($_REQUEST['car_spaces']) && $_REQUEST['car_spaces'] != 'Car Spaces')
		{
			 $car_spaces = $_REQUEST['car_spaces'];
			if($car_spaces == '1') 
			{
				$query->where('cars' , $car_spaces);
			}
			if($car_spaces == '1plus') 
			{
				$car_spaces = '1' ;
				$query->where('cars' , '>=' , $car_spaces);
			}
			if($car_spaces == '2') 
			{
				$query->where('cars' , $car_spaces);
			}
			if($car_spaces == '2plus') 
			{
				$car_spaces = '2' ;
				$query->where('cars' , '>=' , $car_spaces);
			}
			if($car_spaces == '3') 
			{
				$query->where('cars' , $car_spaces);
			}
			if($car_spaces == '3plus') 
			{
				$car_spaces = '3' ;
				$query->where('cars' , '>=' , $car_spaces);
			}

		}
		
		if(!empty($_REQUEST['floor_count']) && $_REQUEST['floor_count'] != 'Stories')
		{
			 $floor_count = $_REQUEST['floor_count'];
			$query->where('stories' , $floor_count);	
		}
		
		if(!empty($_REQUEST['alfresco']) && $_REQUEST['alfresco'] != 'Alfresco')
		{
			 $alfresco = $_REQUEST['alfresco'];
			$query->where('alfresco' , $alfresco);	
		}
		if(!empty($_REQUEST['duplex']) && $_REQUEST['duplex'] != 'duplex')
		{
			 $duplex = $_REQUEST['duplex'];
			 $query->where('dual_occ' , $duplex);	
		}
		
		if(!empty($_REQUEST['builder']) && $_REQUEST['builder'] != 'Specific Builder')
		{
			 $builder = $_REQUEST['builder'];
			 $query->where('user_id' , $builder);	
		}
		if(!empty($_REQUEST['min_price_val']) && !empty($_REQUEST['max_price_val']))
		{
			  $min_price = str_replace(',' , '' , $_REQUEST['min_price_val']);
			  $max_price = str_replace(',' , '' , $_REQUEST['max_price_val']);
			 $query->whereBetween('price', [$min_price, $max_price]);
		}
		if(!empty($_REQUEST['min_block_width']) && !empty($_REQUEST['max_block_width']))
		{
			  $min_block_width = $_REQUEST['min_block_width'];
			  $max_block_width = $_REQUEST['max_block_width'];
			 $query->whereBetween('min_block_width', [$min_block_width, $max_block_width]);
		}
		if(!empty($_REQUEST['min_block_length']) && !empty($_REQUEST['max_block_length']))
		{
			  $min_block_length = $_REQUEST['min_block_length'];
			  $max_block_length = $_REQUEST['max_block_length'];
			 $query->whereBetween('min_block_length', [$min_block_length, $max_block_length]);
		}
		if(!empty($_REQUEST['min_house_size']) && !empty($_REQUEST['max_house_size']))
		{
			  $min_house_size = $_REQUEST['min_house_size'];
			  $max_house_size = $_REQUEST['max_house_size'];
			 $query->whereBetween('housesize', [$min_house_size, $max_house_size]);
		}
		
		if(!empty($_REQUEST['sort_prop']) && $_REQUEST['sort_prop'] != 'Select')
		{
			if($_REQUEST['sort_prop'] == 'base_price:asc')
			{
				$query->orderBy('price', 'ASC');
			}
			if($_REQUEST['sort_prop'] == 'base_price:desc')
			{
				$query->orderBy('price', 'DESC');
			}
			if($_REQUEST['sort_prop'] == 'model_name:asc')
			{
				$query->orderBy('property_title', 'ASC');
			}
			if($_REQUEST['sort_prop'] == 'model_name:desc')
			{
				$query->orderBy('property_title', 'DESC');
			}
		if($_REQUEST['sort_prop'] == 'builder_name:asc')
			{

				$builders = BuilderDetail::orderBy('company_name','asc')->get(array('builder_id'));
				$builders_arr = $builders->toArray();
				$builder = "";
				$builderids = "";
				if(!empty($builders_arr)) {
				foreach($builders_arr as $builder_val)
				{
					$builder[] = $builder_val['builder_id'];
				}
				$builderids = implode(',', $builder);
				if(!empty($builderids)) {
				$query->orderByRaw(DB::raw("FIELD(user_id, $builderids)"));
				}
				}
			
			}
			if($_REQUEST['sort_prop'] == 'builder_name:desc')
			{
				$builders = BuilderDetail::orderBy('company_name','desc')->get(array('builder_id'));
				$builders_arr = $builders->toArray();
				$builder = "";
				$builderids = "";
				if(!empty($builders_arr)) {
				foreach($builders_arr as $builder_val)
				{
					$builder[] = $builder_val['builder_id'];
				}
				$builderids = implode(',', $builder);
				if(!empty($builderids)) {
				$query->orderByRaw(DB::raw("FIELD(user_id, $builderids)"));
				}
				}
				
			} 
			
			
		}
		
		if(!empty($_REQUEST['incids']))
			{
				$incids_arr = explode(',',$_REQUEST['incids']);
				$prop_inc   =   PropertyInclusion::whereIn('inclusion_id',$incids_arr)->groupBy('property_id')->get(array('property_id'));
				$propids_arr = $prop_inc->toArray();
				$propidsarr = "";
				if(!empty($propids_arr)) {
				foreach($propids_arr as $propid_val)
				{
					$propidsarr[] = $propid_val['property_id'];
				}
				$query->whereIn('id',$propidsarr);
				}
				
			}
		
		$query->orderBy('featured', 'Desc');
		$query->where('status',1);
		$query->where('property_type','1');
		$query->Orwhere('property_type','3');
		//echo $query->getQuery()->toSql();
		$prop_count = $query->count();
		echo $prop_count;
		}
	
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
	
	public function propertydetail($prop_id){
	
		$results = Property::with('builder_detail','property_gallery','property_floor_plans','property_inclusions','property_display_homes')->where(['id' => $prop_id])->get();
		$gallery = PropertyGallery::where(['property_id' => $prop_id])->orderBy('gallery_order', 'Asc')->get();
		$data['prop_arr'] = $results->toArray();
		$user_id = $data['prop_arr'][0]['user_id'];
		$house_land_query = Property::where(array('property_type'=>'2','user_id'=>$user_id))->orderByRaw("RAND()")->limit('5')->get(array('id','house_land_address','property_title'));
		$data['house_land_arr'] = $house_land_query->toArray();
		$data['gallery_images'] = $gallery->toArray();
		$inc = Inclusion::where(['parent_id'=>'0'])->get();
		//$data['inc_arr']  = $inc->toArray();
		$data['title'] = 'Property Details';
		$data['prop_id'] = $prop_id;
		//$inc_arr = $this->get_parent_filter_inc();
		$data['inc_arr']  = $inc->toArray();
		$q = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and add_size='300' and status='Publish'")->limit(2);
		$ads_obj  = $q->get();
		$ads_arr = $ads_obj->toArray();
		$data['ads_arr'] = $ads_arr;
		$user_ip =  request()->ip();
		$date = date('Y-m-d');
		$prop_view_count = DB::table('property_view_report')->where(array('property_id'=>$prop_id,'user_ip'=>$user_ip,'created_at'=>$date))->count();
		if($prop_view_count == 0){
		DB::table('property_view_report')->insert(
		['property_id' => $prop_id, 'user_id' => $user_id,'user_ip'=>$user_ip,'created_at'=>$date,'updated_at'=>$date]
		);
		}
		return view('propertydetail', $data);
	}
	
	public function contact_builder()
	{
		if(!empty($_REQUEST['property_ids'])) {
		$ids = explode(',',$_REQUEST['property_ids']);
		$results = Property::with('builder_detail','property_gallery')->whereIn('id',$ids)->get();
		$property_arr = $results->toArray();
		$data['property_arr'] = $property_arr;
		$data['property_ids'] = $_REQUEST['property_ids'];
		$q = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and add_size='300' and status='Publish'")->limit(2);
		$ads_obj  = $q->get();
		$ads_arr = $ads_obj->toArray();
		$data['ads_arr'] = $ads_arr;
		$data['title'] = 'Make an enquiry to your selected builders';
		return view('contact-builder', $data);
		}
	}
	
	public function delete_saved_property($prop_id)
	{
		$user_ip =  request()->ip();
		SaveProperty::where(array('user_ip'=>$user_ip,'property_id'=>$prop_id))->delete();
		return Redirect::to('favourites/filter');
	}
	
	public function enquire_builder($property_ids)
	{

		$property_id = explode(',',$property_ids);
		if(!empty($property_id)) {
		$propertobj = Property::with('builder_detail','property_gallery')->whereIn('id',$property_id)->get();
		$prop_arr =	$propertobj->toArray();
		$user_ip =  request()->ip();
		$saveinclusion = SaveInclusion::where('user_ip',$user_ip)->get();
		$saved_inc_arr = $saveinclusion->toArray();
		$inc_ids="";
		$inc_arr ="";
		if(!empty($saved_inc_arr)) {
		foreach($saved_inc_arr  as $save_inc_value) {
			$inc_ids[] = $save_inc_value['inclusion_id'];
		}
		$results = Inclusion::whereIn('id',$inc_ids)->get();
		$inc_arr = $results->toArray();
		
		}
		$input = Input::all();
		//print_r($input);die;
		//dd($input);
		$rules = array(
			'email'    => 'required|email',
			'first_name' => 'required',
			'last_name' => 'required',
			'phone' => 'required',
			'state' => 'required',
			//'language' => 'required',
			'home_status' => 'required',
			'own_land' => 'required',
			'secured_finance' => 'required',
			'contact_time' => 'required',
			'agree' => 'required'
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				echo 'validation_error';
		}
		else{
		$input = Input::all();
		 $status = 'false';
		 $data1 = array();
		foreach($prop_arr as $prop_val) {
			$builder_email = "";
			$email = "";
			$property_title = "";
			$builder_id = $prop_val['builder_detail']['builder_id'];
			$user_obj = User::where('id',$builder_id)->get();
			$user_arr = $user_obj->toArray();
			$email = $user_arr[0]['email'];
			$secured_opt = !empty($input['secured_option1']) ? 'Want to contact Mortgage Broker to see if they can find you a more competitive deal.' : "";
			$secured_opt = !empty($input['secured_option2']) ? 'Want to contact Mortgage Broker about your home loan needs.' : "";
			$secured_opt = !empty($input['secured_option3']) ? 'Want to contact Mortgage Broker about your home loan needs.' : "";
			
			DB::table('enquiry_details')->insert(['enquired_by' => $input['email'],'builder_id' => $builder_id,'property_id' => $prop_val['id'],'first_name' => $input['first_name'],'last_name' => $input['last_name'],'phone' => $input['phone'],'state' => $input['state'],'home_status' => $input['home_status'],'own_land' => $input['own_land'],'secured_finance' => $input['secured_finance'],'secured_option'=>$secured_opt,'message' => $input['message'],'contact_time' => $input['contact_time']]);

			$data = array();
			$data['email'] = $email;
			$data['from']  = $_POST['email'];
			$data['property_type'] = $prop_val['property_type'];
			$data['property_title'] = $prop_val['property_title'];
			$data1['property_title'] = $prop_val['property_title'];
			$sendmail = \Mail::send('emails.enquire-builder',
			array('inc_arr' => $inc_arr,'property_arr'=>$prop_arr,'user_inputs'=>$input), function($message) use($data)
			{
				$property_title = $data['property_title'];
				if($data['property_type']=='1') {
					$subject = 'icompareBuilders - '.$property_title.' User Enquiry';
				}
				if($data['property_type']=='2') {
					$subject = 'icompareBuilders - House & Lands '.$property_title.' User Enquiry';
				}
				$email = $data['email'];
				//$email = 'palka.k@macrew.net';
				$from = $data['from'];
				//$email = "palka.k@macrew.net";
				$message->from($from);
				$message->to($email)->subject($subject);
			});
			$status = 'true';
		}
		if($status == 'true')
		{
			$data1['email'] = $input['email'];
			$sendmail1 = \Mail::send('emails.reply-enquire-builder',
		 	array('inc_arr' => $inc_arr,'property_arr'=>$prop_arr,'user_inputs'=>$input), function($message) use($data1)
			{
				$property_title = $data1['property_title'];
				//$email = $data['email'];
				$email = $data1['email'];
				$from = "info@icompareBuilders.com.au";
				$message->from($from);
				$message->to($email)->subject('icompareBuilders - Enquiry Confirmation');
			});
			
			//Session::flash('success', 'Your query sent to builder. You will be contacted soon.');
			echo 'success';
		}
		
		}
		
		}
		else {
		
		//Session::flash('failed', 'Please save some homes');
		echo 'failed_savesomehomes';
		}
		exit;
	}
	
	public function send_feedback()
	{
			$data = array();
			$data['toemail'] = 'nfo@icomparebuilders.com.au';
			$data['from']  = 'info@icomparebuilders.au';
			$input = Input::all();	
			$sendmail = \Mail::send('emails.feedback',
			array('user_inputs'=>$input), function($message) use($data)
			{
				$email = $data['toemail'];
				//$email = 'palka.k@macrew.net';
				$from = $data['from'];
				//$email = "palka.k@macrew.net";
				$message->from($from);
				$message->to($email)->subject('icompareBuilders - User FeedBack');
			});

			echo 'success';

		exit;
	}
	
	public function message_notify()
	{
		$data['title'] = 'New Home Designs- Search & compare Homes from top builders';
		return view('messages',$data);
	}
	
	public function propertydetailmail($id){
		$input = Input::all();
		//dd($input);
		$rules = array(
			'to'    => 'required|email',
			'from' => 'required|email',
			'subject' => 'required',
			'note' => 'required',
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('/propertydetail/'.$id.'')
				->withErrors($validator) // send back all errors to the login form
				->withInput(); // send back the input (not the password) so that we can repopulate the form
		}
		else{
			$sendmail = \Mail::send('emails.shareproperty',
			array(
				'subject' => $_POST['subject'],
				'note' => $_POST['note'],
				'from' => $_POST['from'],
				'link' => url().'/propertydetail/'.$id
			), function($message)
			{
				$message->from($_POST['from']);
				$message->to($_POST['to'])->subject($_POST['subject']);
			});
			\Session::flash('success', 'Mail has been sent to your friend.');
			return redirect()->back();
		}
	}
	
	public function delete_property()
	{
		if(!empty($_REQUEST['property_ids'])) {
			$property_ids = "";
			$prop_id = $_REQUEST['id'];
			$property_ids = $_REQUEST['property_ids'];
			$compare_ids_arr = explode(',',$property_ids);
		$reset_arr = array_diff($compare_ids_arr, array($prop_id));

		}
		$reset_string = implode(',',$reset_arr);

		return Redirect::to('property/contact?property_ids='.$reset_string);
		
	}
	
	public function delete_ajax_property()
	{
		//echo $_REQUEST['id'];
		//echo $_REQUEST['property_ids'];
		if(!empty($_REQUEST['property_ids'])) {
			$property_ids = "";
			$prop_id = $_REQUEST['id'];
			$property_ids = $_REQUEST['property_ids'];
			$compare_ids_arr = explode(',',$property_ids);
		$reset_arr = array_diff($compare_ids_arr, array($prop_id));

		}
		$reset_string = implode(',',$reset_arr);
		$results = Property::with('builder_detail','property_gallery')->whereIn('id',$reset_arr)->get();
		$property_arr = $results->toArray();
		$data=array();
		$html='';
		 $html.=  '<div class="compare-pop"> 
                    <div class="cp-inner">';
					
					
					if(!empty($property_arr)) {
					$count =  count($property_arr);  
					foreach($property_arr as $prop_val) {
	
               $html.=         '<div class="cp-box">
                            <h2>'.$prop_val['builder_detail']['company_name'].'</h2>
                            <p class="cp-cross">';
							
							 if($count > 1) {
					$html.= '<a href="javascript:void(0);" class="remove" data-id="'.$prop_val['id'].'" data-property_ids="'.$reset_string.'"><i class="fa fa-times"></i></a>';
					  } 
					
				$html.=	'</p>
                            <div class="cp-right">
                                <div class="cp-r-top">';
                                   
					$rand_key = "";
					if(!empty($prop_val['property_gallery'])) {
				  $rand_key = array_rand($prop_val['property_gallery'], 1); 
				 $prop_image =  	$prop_val['property_gallery'][$rand_key]['image'];

                 $html.=  '<a href="'.url().'/propertydetail/'.$prop_val['id'].'" ><img src="'.url().'/uploads/property_gallery/'.$prop_image.'" alt=""></a>';
				    } else {
				
				$html.=  '<a href="'.url().'/propertydetail/'.$prop_val['id'].'"><img src="'.url().'/assets/img/no-image.jpg" /></a>';
				}
                               $html.=    '<h3><a href="'.url().'/propertydetail/'.$prop_val['id'].'">'.$prop_val['property_title'].'</a></h3>
                                   <p>From $'.number_format($prop_val['price'],2).'<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="" data-original-title="The price or price range shown here is indicative only and will vary depending on the final inclusions, location of the build, the house façade and other customisations selected."></i></p>
                                </div>
                            </div>
                            <div class="clr"></div>
                        </div>';
					} } 
                   $html.=   '</div>
                </div>';
						$data['html'] = $html;
						$data['reset_string']=$reset_string;
						echo json_encode($data);
			//echo $html;	
	}
	
	public function load_enquire_form()
	{
		if(!empty($_REQUEST['property_ids'])) {
			$ids = explode(',',$_REQUEST['property_ids']);
			$results = Property::with('builder_detail','property_gallery')->whereIn('id',$ids)->get();
			$property_arr = $results->toArray();
			$data['property_arr'] = $property_arr;
			$data['property_ids'] = $_REQUEST['property_ids'];
			$q = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and add_size='300' and status='Publish'")->limit(2);
			$ads_obj  = $q->get();
			$ads_arr = $ads_obj->toArray();
			$user = Auth::user();
			if($user){
				$user_email = $user->email;
				$user_type = $user->user_type;
				$userdata = App\User::getnewuserinfo($user->id,$user_type);	
				$firstname = $userdata->firstname;
				$lastname = $userdata->lastname;
			if($user_type == 'User') {
				$phone = $userdata->phone;
			} else if($user_type == 'Builder' || $user_type == 'LandEstate'){
				$phone = $userdata->phn_no;
			}	
			$users = UserLocation::where('user_id',$user->id)->get(array('state_id'));
			$users_arr = $users->toArray();
			$states = State::where('id',$users_arr[0]['state_id'])->get();
			$state_arr = $states->toArray();
			$loc_name = $state_arr[0]['state_name'];



			} else {
				$loc_name = "";
				$user_email = "";
				$firstname = "";
				$lastname = "";
				$phone = "";
			}
				$html = '';
				$html.= '
				<div id="list-loading-message" class="map-list-loader-container loading" style="display:none">
				<div id="loader" class="map-list-loader">
				<span class="zsg-loading-spinner"><img src="'.url().'/assets/img/facebook-loader.gif"></span></div>
				</div>
				<div class="modal-dialog modal-lg enquire-form">
				<div class="modal-content compare_popupmains">
				<div class="modal-header enquire-modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
				<h4 class="modal-title">Enquire Now</h4>
				</div>
				<div class="modal-header enquire-header">
				We\'ll send the enquiry direct to your chosen builders, who will be in contact for a friendly and no-obligation chat.
				<span id = "message_error" style="color:#9C0E0E;"></span>
				<span id = "message_success" style="color:#71B238;"></span>
				</div>
				<div class="en-main">
				<div class="en-right">
				<div class="builder-form">
				<form action="'.url().'/property/enquire_builder/'.$_REQUEST['property_ids'].'" method="post" id = "enquire_forms">
				<input type="hidden" name="_token" value="'.csrf_token().'">
				<input type="text" placeholder="First name" name="first_name" value="'.$firstname.'" required>
				<input type="text" placeholder="Last name" value="'.$lastname.'" name="last_name" required>
				<input type="text" placeholder="Phone (include area code if not mobile)"  value="'.$phone.'" name="phone" required>
				<input type="email" placeholder="Email" value="'.$user_email.'" name="email" required>
				<select name="state"  required>
				<option value="">State</option>';
			if($loc_name == 'ACT') {
				$html.='<option value="ACT" selected="selected">ACT</option>';
			} else {
				$html.='<option value="ACT">ACT</option>';
			}
			if($loc_name == 'NSW') {
				$html.='<option value="NSW" selected="selected">NSW</option>';
			} else {
				$html.='<option value="NSW">NSW</option>';
			}

			if($loc_name == 'NT') {
				$html.='<option value="NT" selected="selected">NT</option>';
			} else {
				$html.='<option value="NT">NT</option>';
			}
			if($loc_name == 'QLD') {
				$html.='<option value="QLD" selected="selected">QLD</option>';
			} else {
				$html.='<option value="QLD">QLD</option>';
			}
			if($loc_name == 'SA') {
				$html.='<option value="SA" selected="selected">SA</option>';
			} else {
				$html.='<option value="SA">SA</option>';
			}
			if($loc_name == 'TAS') {
				$html.='<option value="TAS" selected="selected">TAS</option>';
			} else {
				$html.='<option value="TAS">TAS</option>';
			}
			if(!empty($loc_name)) {
				if($loc_name == 'VIC') {
					$html.='<option value="VIC" selected="selected">VIC</option>';
				} else {
					$html.='<option value="VIC">VIC</option>';
				}
			} else {
				$html.='<option value="VIC" selected="selected">VIC</option>';
			}
			if($loc_name == 'WA') {
				$html.='<option value="WA" selected="selected">WA</option>';
			} else {
				$html.='<option value="WA">WA</option>';
			}


			$html.= '</select>
			<select name="home_status">
			<option selected="selected" value="">Your home ownership status?</option>
			<option value="own">Own my own home</option>
			<option value="renting">Renting currently</option>
			<option value="recently_sold">Recently sold home</option>
			<option value="investing">Investing</option>
			<option value="own_land">Own land and plan to build</option>
			<option value="upgrading">Previously built planning to upgrade</option>
			</select>

			<select name="own_land" required>
			<option selected="selected" value="">Do you own land for building?</option>
			<option value="yes">Yes</option>
			<option value="no">No</option>
			<option value="found">Found but not yet acquired</option>
			</select>

			<select name="secured_finance" id="secured_finance" required>
			<option selected="selected" value="">Have you secured finance?</option>
			<option value="yes">Yes</option><option value="no">No</option>
			<option value="awaiting-approval">Awaiting approval</option>
			</select>

			<div class="enquire_finance" style="display:none;" id="yes-secured"><p>Would you like an <img width="150"  src="'.url().'/assets/img/iCompareLoans.png" alt="Aussie Home Loans logo">
			Mortgage Broker to see if they can find you a more competitive deal?</p>
			<div class="y_no"><input type="radio" name="secured_option1" value="yes" >Yes
			<input type="radio" name="secured_option1" value="no" >No
			</div>
			</div>

			<div class="enquire_finance" style="display:none;" id="no-secured"><p>Would you like an <img width="150"  src="'.url().'/assets/img/iCompareLoans.png" alt="Aussie Home Loans logo">
			Mortgage Broker to contact you about your home loan needs?</p>
			<div class="y_no"><input type="radio" name="secured_option2" value="yes" >Yes
			<input type="radio" name="secured_option2" value="no" >No
			</div>
			</div>

			<div class="enquire_finance" style="display:none;" id="await-secured"><p>Would you like an <img width="150"  src="'.url().'/assets/img/iCompareLoans.png" alt="Aussie Home Loans logo">
			Mortgage Broker to contact you about your home loan needs?</p>
			<div class="y_no"><input type="radio" name="secured_option3" value="Yes" >Yes
			<input type="radio" name="secured_option3" value="No" >No
			</div>
			</div>

			<textarea placeholder="Add and optional message" name="message" rows="5" cols="15"></textarea>
			<select name="contact_time">
			<option selected="selected" value="">Best contact time</option>
			<option value="morning">Morning</option>
			<option value="afternoon">Afternoon</option>
			<option value="evening">Evening</option>
			<option value="weekends_only">Weekends Only</option>
			<option value="anytime">Anytime</option>
			</select>
			<p class="cp-left agree">
			<input type="checkbox" name="agree" id="agree" value="1" checked="checked"/>
			<label for="agree">
			</label>
			<span>I have read and agree to the iCompareBuilders Website<a href="http://www.icompareloans.com.au/" target="_blank"> Terms &amp; Conditions</a>,
			<a href="http://www.icompareloans.com.au/" target="_blank">Privacy Policy</a>
			</span>
			</p>   
			<input type="submit" value="Send Enquiry to Builder" class="button1">
			</form>
			</div>
			</div>
			<div class="en-left">
			<h1>Selected homes</h1>
			<div id="selected-homes">
			<div class="compare-pop"> 
			<div class="cp-inner">';


			if(!empty($property_arr)) {
				$count =  count($property_arr);  
				foreach($property_arr as $prop_val) {

					$html.=         '<div class="cp-box">
					<h2>'.$prop_val['builder_detail']['company_name'].'</h2>
					<p class="cp-cross">';

					if($count > 1) {
						$html.= '<a href="javascript:void(0);" class="remove" data-id="'.$prop_val['id'].'" data-property_ids="'.$_REQUEST['property_ids'].'"><i class="fa fa-times"></i></a>';
					} 

					$html.=	'</p>
					<div class="cp-right">
					<div class="cp-r-top">';
					   
					$rand_key = "";
					if(!empty($prop_val['property_gallery'])) {
						$rand_key = array_rand($prop_val['property_gallery'], 1); 
						$prop_image =  	$prop_val['property_gallery'][$rand_key]['image'];

						$html.=  '<a href="'.url().'/propertydetail/'.$prop_val['id'].'" ><img src="'.url().'/uploads/property_gallery/'.$prop_image.'" alt=""></a>';
					} else {
						$html.=  '<a href="'.url().'/propertydetail/'.$prop_val['id'].'" ><img src="'.url().'/assets/img/no-image.jpg" /></a>';

					}
					$html.=    '<h3><a href="'.url().'/propertydetail/'.$prop_val['id'].'">'.$prop_val['property_title'].'</a></h3>
					   <p>From $'.number_format($prop_val['price'],2).'<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="" data-original-title="The price or price range shown here is indicative only and will vary depending on the final inclusions, location of the build, the house façade and other customisations selected."></i></p>
					</div>
					</div>
					<div class="clr"></div>
					</div>';
				}
			} 
			$html.=   '</div>
			</div></div>';
			if(!empty($ads_arr)) { 
				$html.= '<div class="add_model"><!--add section!-->';
				foreach($ads_arr as $ads_val) { 
					$html.= '<h3>Get your Free Building Guide when you Enquire</h3>
					<div class="add_photo"><!--<div class="add_text"><h4>$<span>20</span> Voucher</h4></div> <div class="voucher-offer__plus"><span>plus</span></div>--> <img src="'.url().'/uploads/add_management/'.$ads_val['image'].'" /></div>
					<p>Our independent home building guide with expert tips to save you time and money</p>';
				}  
				$html.= '
				</div>';
			}
			$html.= '</div>
			<div class="clr"></div>
			</div>
			</div>
			</div>';
			echo $html;

			}
  
	}
	
	
	public function display_villages($prop_id)
	{
		$prop = Property::with('property_gallery')->where('id',$prop_id)->get();
		$prop_arra = $prop->toArray();
		$prop_title = $prop_arra[0]['property_title'];
		if(!empty($prop_arra[0]['property_gallery'])) {
		$prop_image = $prop_arra[0]['property_gallery'][0]['image'];
		} else {
		$prop_image="";
		}
		$prop_display_home = PropertyDisplayHome::with('open_hours')->where('property_id',$prop_id);
		$total_display_home = $prop_display_home->count();
		$display_home_arrs = $prop_display_home->get();
		$display_home_arr = $display_home_arrs->toArray();
		//$display_village_title = $display_home_arr[0]['display_village_title'];
		//$display_location = $display_home_arr[0]['display_location'];
		//die;
		

		$data['title'] = 'Display Villages - icomparebuilders';
		$data['display_home_arr'] = $display_home_arr;
		$data['total_display_home'] = $total_display_home;
		$data['prop_title'] = $prop_title;
		$data['prop_image'] = $prop_image;
		$data['prop_id'] = $prop_id;
		return view('display-villages', $data);

	}
	
	public function book_appointment_html()
	{
		if(!empty($_REQUEST['display_village'])) {
		$display_village = $_REQUEST['display_village'];
		$prop_display_home = PropertyDisplayHome::with('open_hours')->where('id',$display_village)->get();
		$display_home_arr = $prop_display_home->toArray();
		/* echo '<pre>';
		print_r($display_home_arr); */
		
		$prop_id  = $display_home_arr[0]['property_id'];
		$village_title  = $display_home_arr[0]['display_village_title'];
		$display_location  = $display_home_arr[0]['display_location'];
		$display_home_id  = $display_home_arr[0]['id'];
		$prop = Property::with('property_gallery','builder_detail')->where('id',$prop_id)->get();
		$prop_arr = $prop->toArray();
		$title  = $prop_arr[0]['property_title'];
		$builder  = $prop_arr[0]['builder_detail']['company_name'];
		if(!empty($prop_arr[0]['property_gallery'])) {
		$image  = '/uploads/property_gallery/'.$prop_arr[0]['property_gallery'][0]['image'];
		} else {
		$image = '/assets/img/no-image.jpg';
		
		}
		$related_home_arr = Property::get_related_display_home($village_title,$display_location,$prop_id);
		//echo '<pre>';
		//print_r($related_home_arr);
		//die;
		$user = Auth::user();
		if($user){
		$user_email = $user->email;
		$user_type = $user->user_type;
		$userdata = App\User::getnewuserinfo($user->id,$user_type);	
				$firstname = $userdata->firstname;
				$lastname = $userdata->lastname;
				if($user_type == 'User') {
				$phone = $userdata->phone;
				} else if($user_type == 'Builder' || $user_type == 'LandEstate'){
				$phone = $userdata->phn_no;
				}
				
		} else {
				$user_email = "";
				$firstname = "";
				$lastname = "";
				$phone = "";
		}
		$html = "";
		$html.= '<div class="appoint">
	
	
		<div id="select-home">
		<h3>Book Appointment</h3>
		<p>Get priority Service and visit a display home.</p>
		<div class="display_book_appoint">
		<div class="book_appiont"><ul>
		<li><a href="javascript:void(0)" class="appoint-home book_appiont_active">Select Homes</a></li>
		<li><a href="javascript:void(0)" >Date/Time</a></li>
		<li><a href="javascript:void(0)" >Your Details</a></li>
		</ul></div>
		<div class="appoint_body">
		<div class="cp-box">
            
            <div class="cp-left">
				
			<input type="checkbox" checked="checked" name="display_village_check" value="'.$display_home_id.'" id="display_v_'.$display_home_id.'">
						<label for="display_v_'.$display_home_id.'">
			</label></div>
            <div class="cp-right">
                <div class="cp-r-top">
				                   <a href="'.url().'/propertydetail/'.$prop_id.'">
								   <img alt="" src="'.url().$image.'">
								   </a>
				                      <a href="'.url().'/propertydetail/'.$prop_id.'"><h3>'.$title.'</h3></a>
                   <p>'.$builder.'</p>
                </div>
            </div>
            <div class="clr"></div>
        </div>
		
		<div class="related-villages">';
		if(!empty($related_home_arr)) { 
		$html.='<p>Also at this village</p>';
		foreach($related_home_arr as $related_val) {
		if(!empty($related_val['property_gallery'][0]['image'])) {
		$image  = '/uploads/property_gallery/'.$related_val['property_gallery'][0]['image'];
		} else {
		$image = '/assets/img/no-image.jpg';
		
		}
		
		$html.= '<div class="cp-box">
            
            <div class="cp-left">
				
			<input type="checkbox"  name="display_village_check" value="'.$related_val['id'].'" id="display_v_'.$related_val['id'].'">
						<label for="display_v_'.$related_val['id'].'">
			</label></div>
            <div class="cp-right">
                <div class="cp-r-top">
				                   <a href="'.url().'/propertydetail/'.$related_val['id'].'"><img alt="" src="'.url().$image.'"></a>
				                      <h3><a href="'.url().'/propertydetail/'.$related_val['id'].'">'.$related_val['property_title'].'</h3></a>
                   <p>'.$related_val['builder_detail']['company_name'].'</p>
                </div>
            </div>
            <div class="clr"></div>
        </div>';
		} }
	
		$html.= '</div>
		
		</div>
		<input type="hidden" name="display_home_ids1" id="display_home_ids1" value="'.$display_home_id.'" />
		</div>
		<div class="appoint_button"><input type="button" class="button1 appoint_home_next" value="Next"></div>
		</div>';
	
		
		$html.='
	
		<div class="appoint-date-div" style="display:none;">
		<input type="hidden" name="display_home_ids" id="display_home_ids" value="'.$display_home_id.'" />
		<div class="display_book_appoint">
		<div class="book_appiont"><ul>
		<li><a href="javascript:void(0)" class="appoint-home book_appiont_active">Select Homes</a></li>
		<li><a href="javascript:void(0)" class="appoint-date book_appiont_active">Date/Time</a></li>
		<li><a href="javascript:void(0)" >Your Details</a></li>
		</ul></div>
		<div class="select-date">
		<input type="hidden" name="display_home_id" id="display_home_id" value="'.$display_home_id.'" />
			<label>Appointment date</label>
			<input type="text" name="date" id="date" value="Select Date"/>';
	
			
	$html.='		
			<label>Appointment time</label>
			<select name="appoint-time" id="appoint-time" disabled>
			<option value="Select Time">Select Time</option>
			</select>
			
		</div>
		</div>
		<div class="appoint_button"><input type="button" class="button1 appoint_date_next" value="Next"/></div>
		</div>
		<div class="detail" style="display:none;">
		<div class="book_appiont"><ul>
		<li><a href="javascript:void(0)" class="appoint-home book_appiont_active">Select Homes</a></li>
		<li><a href="javascript:void(0)" class="appoint-date book_appiont_active">Date/Time</a></li>
		<li><a href="javascript:void(0)" class="appoint-details book_appiont_active">Your Details</a></li>
		</ul></div>
		
		<div class="select-detail">
		<input type="hidden" name="display_home_id" id="display_home_id" value="'.$display_home_id.'" />
		<input type="hidden" name="new_display_home" id="new_display_home" value="" />
		<input type="hidden" name="new_date" id="new_date" value="" />
		<input type="hidden" name="new_time" id="new_time" value="" />
			<input type="text" name="firstname" id="firstname_pro" value="'.$firstname.'" placeholder="First name" />
			<input type="text" name="lastname" id="lastname_pro" value="'.$lastname.'" placeholder="Last name"/>
			<input type="email" name="email" id="email_pro" value="'.$user_email.'" placeholder="Email" />
			<input type="text" name="phn_no" id="phn_no_pro" value="'.$phone.'" placeholder="Phone (include area code if not mobile)"/>
			<p class="cp-left book_agree"><input type="checkbox" name="" id="book_appoint_terms" value="1" checked="checked"> <label for="book_appoint_terms">
			</label>By using this form, I agree to the icomparebuilders <a href="'.url().'/terms-and-conditions">terms & conditions</a>, <a href="'.url().'/privacy-policy">privacy policy</a></p>
			
		</div>
		<div class="appoint_button"><input type="button" class="button1 appoint_detail_next" value="Next"/></div>
		
		
		</div>
		
		
		<div class="complete" style="display:none;">
		
		<div class="complete-div">
			<h3>Booking Complete</h3>
			<p>The builder will be in touch with you soon.</p>
		</div>

		</div>
		
		
		
		</div>';
		
		echo $html;
		
		
		}
		
	}
	
	public function get_time_dropdown()
	{
		
		 $selected_day  = $_REQUEST['selected_day'].'s';
		 $display_home_ids_arr  = explode(',',$_REQUEST['display_home_id']);
		 $display_home_id = $display_home_ids_arr[0];
		if($selected_day == 'Saturdays' || $selected_day == 'Sundays') {
		$open_hour  = PropertyDisplayHomeOpenHour::where(array('display_home_id'=>$display_home_id,'day'=>$selected_day));
		} else {
		$selected_day = 'Weekdays';
			$open_hour  = PropertyDisplayHomeOpenHour::where(array('display_home_id'=>$display_home_id,'day'=>$selected_day));
		}
		// $open_hour->getQuery()->toSql();
		$hr = $open_hour->get();
		$open_hour_arr = $hr->toArray();
	//$open_hour_arr = $open_hour->toArray();
		 $startTime = $open_hour_arr[0]['start_time'];
		 $end_time = $open_hour_arr[0]['end_time'];
		$html="";	
		$ts1 = strtotime($startTime);
$ts2 = strtotime($end_time);
$diff = abs($ts1 - $ts2) / 3600;
$diff=$diff*2;
	$timestamp1 = strtotime("$startTime");
	$next_time1 = date('h:i A', $timestamp1);
$html.='<option value="'. $next_time1.'">'.$next_time1.'</option>';
for($loop=1;$loop<=$diff;$loop++)
{
	$event_length = 30*$loop;
	$timestamp = strtotime("$startTime");
	$etime = strtotime("+$event_length minutes", $timestamp);
	$next_time = date('h:i A', $etime);
	$html.='<option value="'.$next_time.'">';
	$html.= $next_time;
	$html.='</option>';
} 
	
echo $html;
		
	}
	
	public function send_appointment_detail()
	{
		$home_ids = explode(',',$_REQUEST['homeid']);
		$home_id = $home_ids[0];
		$display_home = PropertyDisplayHome::where('id',$home_id)->get();
		$display_home_arr =	$display_home->toArray();
		$home_arr = $display_home_arr[0];
		$display_home_prop_arr = array();
		$display_home_prop_arr[0] = $home_arr['property_id'];
		if(count($home_ids) > 1) {
		/* echo '<pre>';
		print_r($display_home_prop_arr); */
		unset($home_ids[0]);
		/* echo '<pre>';
		print_r($home_ids); */
		$tt = array_merge($display_home_prop_arr,$home_ids);
		$prop_ids = "";
		foreach($tt as $val)
		{
			$prop_ids[] = $val;
		}
		} else {
			$prop_ids = array();
			$prop_ids[0] = $display_home_prop_arr[0];
		}
		
		/* echo '<pre>';
		print_r($prop_ids); */
		$user_email = $_REQUEST['email'];
		$propertobj = Property::with('builder_detail','property_gallery')->whereIn('id',$prop_ids)->get();
		$prop_arr =	$propertobj->toArray();
		foreach($prop_arr as $prop_val) {
		$appoint_detail =  array();
		$appoint_detail['detail'] = $_REQUEST;
			//$data1['email'] = 'palka.k@macrew.net';
			$builder_id  = $prop_val['builder_detail']['builder_id'];
			$user_obj = User::where('id',$builder_id)->get();
		$user_arr = $user_obj->toArray();
		$email = $user_arr[0]['email'];
		$data1 = array();
		$data1['email'] = $email;
			//$data1['email'] = 'palka.k@macrew.net';
			$data1['builder'] = $prop_val['builder_detail']['company_name'];
			$data1['from'] = $user_email;
			$sendmail1 = \Mail::send('emails.appointmentdetail',
		 array('property_arr'=>$prop_val,'appoint_detail'=>$appoint_detail,'display_homes'=>$home_arr,'builder'=>$data1['builder']), function($message) use($data1)
			{
				//$email = $data['email'];
				$email = $data1['email'];
				//$email = 'palka.k@macrew.net';
				$from = $data1['from'];
				$message->from($from);
				$message->to($email)->subject('icompareBuilders - Display Villages Appointment Detail');
			}); 
			}
		echo 'success';
		
		
	}
	
	
	public function update_display_homes()
	{
		$display_home = PropertyDisplayHome::all();
		$display_home_arr =	$display_home->toArray();
		foreach($display_home_arr as $val)
		{
			$results = DB::table('property')->where('id',$val['property_id'])->get();
			if(!empty($results)) {
			$builder_id = $results[0]->user_id;
			DB::table('property_display_homes')->where('id',$val['id'])->update(['builder_id' => $builder_id]);
			}

			
		}
	}
	
	public function update_inclusion()
	{
		$display_home = PropertyInclusion::limit(1000)->offset(23575)->get();
		$display_home_arr =	$display_home->toArray();
		foreach($display_home_arr as $val)
		{
			$results = DB::table('property')->where('id',$val['property_id'])->get();
			if(!empty($results)) {
			$builder_id = $results[0]->user_id;
			DB::table('property_inclusion')->where('id',$val['id'])->update(['builder_id' => $builder_id]);
			}

			
		}
	}
	
	public function change_builder_state()
	{
		$state = $_REQUEST['state'];
		Session::set('header_state',$state);
		echo 'success';
	}
	
	public function load_rating_form()
	{
		$rate_status = $_REQUEST['rate_status'];
		
		$html="";
		 $html.= '
		  	<div id="list-loading-message" class="map-list-loader-container loading" style="display:none">
    <div id="loader" class="map-list-loader">
    <span class="zsg-loading-spinner"><img src="'.url().'/assets/img/facebook-loader.gif"></span></div>
   </div>
		  <div class="modal-dialog modal-lg enquire-form">
      <div class="modal-content">
        <div class="modal-header enquire-modal-header rate_header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
          <h4 class="modal-title">Do you have any feedback?</h4>
        </div>
		  <span id = "message_error" style="color:#9C0E0E;"></span>
          <span id = "message_success" style="color:#71B238;"></span>
		<div class="en-main">
        <div class="builder-form rate-form">
		 <form action="'.url().'/property/send_feedback" method="post" id = "enquire_forms1">
		 <input type="hidden" name="rate_status" value="'.$rate_status.' Star" id="rate_status" />
		 <a href="javascript:void(0)" class="rate-status">'.$rate_status.'</a>
		 <div class="form-col">
				<label for="Did we resolve your online enquiry today?">Did we resolve your online enquiry today?</label>
				<select name="online_enquiry"  class="form-control"><option value=""> Choose your answer</option>
								<option value="Yes"> Yes </option>
								<option value="No, I will need to call"> No, I will need to call </option>
								<option value="No I will go direct to a display village"> No I will go direct to a display village </option>
								<option value="No but I will not call or visit a display village"> No but I will not call or visit a display village </option>
								<option value="Too early to tell"> Too early to tell </option></select>
		</div>
		 <div class="form-col">
				<label for="What had the biggest impact on your score? ">What had the biggest impact on your score? </label>
				<select name="biggest_impact" id="biggest_impact" class="form-control"><option value="select impact"> Choose your answer</option>
								<option value="Website Content"> Website Content </option>
								<option value="Navigation and Performance"> Navigation and Performance </option>
								<option value="Support"> Support </option>
								<option value="My Account"> My Account </option>
								<option value="Access to Builders Information"> Access to Builders Information </option>
								<option value="Other"> Other </option></select>
		</div>
		 <textarea placeholder="Add and optional message" name="message" rows="5" cols="15" required></textarea>
		 <input type="submit" value="Yes,Send" class="button1 rate_button">
		 <a href="javascript:void(0)" class="thnku">No,Thank You!</a>
		 </form>
		</div>
		</div>
		
		</div>
		</div>
		
		'; 
		echo $html;
		
	}
	
	public function load_floor_plan()
	{
		$property_ids = $_REQUEST['property_ids'];
		$query = PropertyFloorImage::where('property_id',$property_ids);
		if($query->count() > 0)
		{
			$floorimg = $query->get();
			$floor_arr = $floorimg->toArray();
			$img = url().'/uploads/property_floor/'.$floor_arr[0]['image'];
		} else {
			$img = "";
		}

		$html="";
		 $html.= '
		  <div class="modal-dialog modal-lg enquire-form">
      <div class="modal-content">
        <div class="modal-header enquire-modal-header rate_header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
          <h4 class="modal-title">Floor Plan</h4>
        </div>
		<div class="en-main">
        <div class="builder-form rate-form floor_popup">';
		
		if(!empty($img)) {
	$html.='	
		<img src="'.$img.'" />';
		} else {
			
			$html.= '<h2>No Floor Plan </h2>';
			
		}
	$html.=	
		'</div>
		</div>
		
		</div>
		</div>
		
		'; 
		echo $html;
		
	}
	
	
	/* House and lands */
	
	public function house_lands()
	{

		if(!empty($_REQUEST['property_type']) || !empty($_REQUEST['bedrooms']) || !empty($_REQUEST['bathrooms']) || !empty($_REQUEST['min_price']) || !empty($_REQUEST['max_price']) || !empty($_REQUEST['search_region']) || !empty($_REQUEST['builder']) || !empty($_REQUEST['page']) || !empty($_REQUEST['main_regionchange']))
		{

			 $query = Property::with('builder_detail','property_gallery');
				$query->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
			
			$search_region = "";$property_type="";$bedrooms="";$bathrooms="";$min_price="";$max_price="";
			$search_region = !empty($_REQUEST['search_region']) ? $_REQUEST['search_region'] : "";
			$main_regionchange = !empty($_REQUEST['main_regionchange']) ? $_REQUEST['main_regionchange'] : "";
			$property_type = !empty($_REQUEST['property_type']) ? $_REQUEST['property_type'] : "";
			$bedrooms = !empty($_REQUEST['bedrooms']) ? $_REQUEST['bedrooms'] : "";
			$bathroom = !empty($_REQUEST['bathrooms']) ? $_REQUEST['bathrooms'] : "";
			$builder = !empty($_REQUEST['builder']) ? $_REQUEST['builder'] : "";
			$min_price = !empty($_REQUEST['min_price']) ? $_REQUEST['min_price'] : "";
			$max_price = !empty($_REQUEST['max_price']) ? $_REQUEST['max_price'] : "";
			 if(!empty($_REQUEST['search_region']) && $_REQUEST['search_region'] != "build-region")
			{

				$search_region = $_REQUEST['search_region'] ;

			  $users = UserLocation::where('user_type','Builder')->where('state_id', $search_region)->groupBy('user_id')->get(array('user_id'));
				
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
			else if(!empty($_REQUEST['main_regionchange']))
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
			else {
				$query = Property::with('builder_detail','property_gallery');
				$query->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
			 $header_state = "";
				 $header_state = Session::get('header_state');
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
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
			
			} 
			
			
			
			if(!empty($_REQUEST['property_type']) && $_REQUEST['property_type'] == 'Single-Storey')
			{
				$query->where('stories','1');	
			}
			if(!empty($_REQUEST['property_type']) && $_REQUEST['property_type'] == 'Double-Storey')
			{
				$query->where('stories','2');	
			}
			if(!empty($_REQUEST['property_type']) && $_REQUEST['property_type'] == 'Homes-With-Alfrescos')
			{
				$query->where('alfresco','Yes');	
			}
			if(!empty($_REQUEST['property_type']) && $_REQUEST['property_type'] == 'Dual-occupancy-Homes')
			{
				$query->where('dual_occ','Yes');	
			}
			if(!empty($_REQUEST['property_type']) && $_REQUEST['property_type'] == 'Custom-Designs')
			{
				$query->where('property_type','3');	
			}

			
			if(!empty($_REQUEST['bedrooms']) && $_REQUEST['bedrooms'] != 'Bedrooms')
			{
				$bedroom = $_REQUEST['bedrooms'];
				if($bedroom == '1') 
				{
					$query->where('bedrooms' , $bedroom);
				}
				if($bedroom == '1plus') 
				{
					$bedroom = '1' ;
					$query->where('bedrooms' , '>=' , $bedroom);
				}
				if($bedroom == '2') 
				{
					$query->where('bedrooms' , $bedroom);
				}
				if($bedroom == '2plus') 
				{
					$bedroom = '2' ;
					$query->where('bedrooms' , '>=' , $bedroom);
				}
				if($bedroom == '3') 
				{
					$query->where('bedrooms' , $bedroom);
				}
				if($bedroom == '3plus') 
				{
					$bedroom = '3' ;
					$query->where('bedrooms' , '>=' , $bedroom);
				}
				if($bedroom == '4') 
				{
					$query->where('bedrooms' , $bedroom);
				}
				if($bedroom == '4plus') 
				{
					$bedroom = '4' ;
					$query->where('bedrooms' , '>=' , $bedroom);
				}
				if($bedroom == '5') 
				{
					$query->where('bedrooms' , $bedroom);
				}
				if($bedroom == '5plus') 
				{
					$bedroom = '5' ;
					$query->where('bedrooms' , $bedroom);
				}
					//$where.= whereIn('user_id',$user_ar)->get();
			}
			if(!empty($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] != 'Bathrooms')
			{
				$bathroom = $_REQUEST['bathrooms'];
				if($bathroom == '1') 
				{
					$query->where('bathrooms' , $bathroom);
				}
				if($bathroom == '1plus') 
				{
					$bathroom = '1' ;
					$query->where('bathrooms' , '>=' , $bathroom);
				}
				if($bathroom == '2') 
				{
					$query->where('bathrooms' , $bathroom);
				}
				if($bathroom == '2plus') 
				{
					$bathroom = '2' ;
					$query->where('bathrooms' , '>=' , $bathroom);
				}
				if($bathroom == '3') 
				{
					$query->where('bathrooms' , $bathroom);
				}
				if($bathroom == '3plus') 
				{
					$bathroom = '3' ;
					$query->where('bathrooms' , '>=' , $bathroom);
				}
				if($bathroom == '4') 
				{
					$query->where('bathrooms' , $bathroom);
				}
				if($bathroom == '4plus') 
				{
					$bathroom = '4' ;
					$query->where('bathrooms' , '>=' , $bathroom);
				}
				if($bathroom == '5') 
				{
					$query->where('bathrooms' , $bathroom);
				}
				if($bathroom == '5plus') 
				{
					$bathroom = '5' ;
					$query->where('bathrooms' , $bathroom);
				}
					
					
			}
			
			if(!empty($_REQUEST['min_price']) && $_REQUEST['min_price'] !=  "min-price"   &&  !empty($_REQUEST['max_price']) && $_REQUEST['max_price'] != "max-price")
			{
				  $min_price = str_replace(',' , '' , $_REQUEST['min_price']);
				  $max_price = str_replace(',' , '' , $_REQUEST['max_price']);
				 $query->whereBetween('price', [$min_price, $max_price]);
			}
			
			if(!empty($_REQUEST['builder']))
			{
				 $builder = $_REQUEST['builder'];
				 $query->where('user_id' , $builder);	
			}
		
			$query->orderBy('featured', 'desc')->orderBy('featured_order', 'asc');
			$query->where('property.status',1);
			$query->where('property_type', "2");
			$page	=	"" ;
			$lastpage	=	"" ;
			$numrows  = "" ;
			$total_prop = $query->count();
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
			//$query->where('builder_details.trash' , 'no');	
			//echo  $query->getQuery()->toSql();
			//die;
			$results = $query->get();
			$data['properties_arr'] = $results->toArray();
			/*   echo '<pre>';
			print_r($data['properties_arr']);  
			die; */
			$header_state = "";
			$header_state = Session::get('header_state');
			 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
			$data['build_location'] = State::where(['state_name' => $headr_state])->get();
		 
			$data['total_prop'] = $total_prop;
				
			
			 $main_regionchange = $headr_state ;
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

			$bquery = BuilderDetail::whereIn('builder_id',$user_ar);
			$builder  = $bquery->where('trash','no')->get();
			$data['builder_arr'] = $builder->toArray();
			
			//$inc = Inclusion::where(['parent_id'=>'0'])->get();
			$inc = Inclusion::where('parent_id','0')->get();
			$data['inc_arr']  = $inc->toArray() ;
			$data['max_price'] = Property::max('price');
			$data['min_price'] = Property::min('price');
			$data['min_block_width'] = Property::min('min_block_width');
			$data['max_block_width'] = Property::max('min_block_width');
			$data['min_block_length'] = Property::min('min_block_length');
			$data['max_block_length'] = Property::max('min_block_length');
			$data['min_house_size'] = Property::min('housesize');
			$data['max_house_size'] = Property::max('housesize');
			$data['builder_arr'] = $builder->toArray();
			/* $inc = Inclusion::where(['filter_inclusion'=>'Yes'])->get();
			$data['filter_inc_arr']  = $inc->toArray(); */
			/* $q = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and add_size='200' and status='Publish'")->limit(2);
			//echo  $q->getQuery()->toSql();
			$ads_obj  = $q->get();
			$ads_arr = $ads_obj->toArray();
			$data['ads_arr'] = $ads_arr; */
			$results = DB::table('testimonials')->where('featured','Yes')->orderByRaw('RAND()')->limit('1')->get();
			//$results = User::where($where_arr)->builders;

			$data['testimonials'] = $results;
			$data['title'] = 'Search New House & Land Packages';
			return view('house-and-lands',$data);
			
		} else {
	
		$query = Property::with('builder_detail','property_gallery');
			$query->orderBy('featured', 'desc')->orderBy('featured_order', 'asc');
			$query->where('status',1);
			$query->where('property_type', "2");
			$query->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
			 $header_state = "";
				 $header_state = Session::get('header_state');
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
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
			
			$page	=	"" ;
			$lastpage	=	"" ;
			$numrows  = "" ;
			$property_type="";$bedrooms="";$bathroom="";$min_price="";$max_price="";$search_region="";$builder="";$main_regionchange="";
			$total_prop = $query->count();
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
			//echo  $query->getQuery()->toSql();
			$results = $query->get();
			$data['properties_arr'] = $results->toArray();
			/*  echo '<pre>';
			print_r($data['properties_arr']);  */
			$header_state = "";
			$header_state = Session::get('header_state');
			$headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
			$data['build_location'] = State::where(['state_name' => $headr_state])->get();
		 
			$data['total_prop'] = $total_prop;
			$builder = BuilderDetail::all();
			$data['builder_arr'] = $builder->toArray();
			//$inc = Inclusion::where(['parent_id'=>'0'])->get();
			$inc = Inclusion::where('parent_id','0')->get();
			$data['inc_arr']  = $inc->toArray() ;
			$data['max_price'] = Property::max('price');
			$data['min_price'] = Property::min('price');
			$data['min_block_width'] = Property::min('min_block_width');
			$data['max_block_width'] = Property::max('min_block_width');
			$data['min_block_length'] = Property::min('min_block_length');
			$data['max_block_length'] = Property::max('min_block_length');
			$data['min_house_size'] = Property::min('housesize');
			$data['max_house_size'] = Property::max('housesize');
			$data['builder_arr'] = $builder->toArray();
			
			/* $q = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and add_size='200' and status='Publish'")->limit(2);
			//echo  $q->getQuery()->toSql();
			$ads_obj  = $q->get();
			$ads_arr = $ads_obj->toArray();
			$data['ads_arr'] = $ads_arr; */
			
			$results = DB::table('testimonials')->where('featured','Yes')->orderByRaw('RAND()')->limit('1')->get();
			//$results = User::where($where_arr)->builders;

			$data['testimonials'] = $results;
			
			$builderdetail = DB::table('builder_details')
            ->join('users_locations', 'builder_details.builder_id', '=', 'users_locations.user_id')
            ->join('states', 'users_locations.state_id', '=', 'states.id')
            ->distinct('states.state_name')
			->where(array('builder_details.trash'=>'no','states.trash'=>'no'))
            ->select('builder_details.*', 'states.state_name')
			->orderBy(DB::raw('RAND()'))
			->limit('10')
            ->get();

			$data['builder_detail_arr'] = $builderdetail;
			
			//$ads_arr = $ads->toArray();
			//$data['ads_arr'] = $ads_arr;
			/* $inc = Inclusion::where(['filter_inclusion'=>'Yes'])->get();
			$data['filter_inc_arr']  = $inc->toArray(); */
					
			$data['title'] = 'Search New House & Land Packages';
			$data['querystring'] = $_REQUEST;
			return view('house-and-lands',$data);
			
			}
	}
	
	public function ajax_filter_house_land()
	{
		if(!empty($_REQUEST['build_location'])  || !empty($_REQUEST['bedroom']) || !empty($_REQUEST['bathrooms']) || !empty($_REQUEST['living_spaces']) || !empty($_REQUEST['car_spaces']) || !empty($_REQUEST['floor_count']) || !empty($_REQUEST['alfresco']) || !empty($_REQUEST['duplex']) || !empty($_REQUEST['builder']) || !empty($_REQUEST['min_price_val']) || !empty($_REQUEST['max_price_val'])  || !empty($_REQUEST['sort_prop'])  ||  !empty($_REQUEST['min_hland_size']) || !empty($_REQUEST['max_hland_size']) || !empty($_REQUEST['page'])) {
		$query = Property::with('builder_detail','property_gallery');
		$query->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
		if(!empty($_REQUEST['build_location']) && $_REQUEST['build_location'] != "Build Location")
		{
			$loc_id = $_REQUEST['build_location'];
			$users = UserLocation::where('state_id', $loc_id)->groupBy('user_id')->get(array('user_id'));
			$users_arr = $users->toArray();
			$user_ar = "";
			foreach($users_arr as $user_val)
			{
				$user_ar[] = $user_val['user_id'];
			}
			///$userstring = "'" . implode("','", $user_ar) . "'";
			//$wherein.= "->whereIn(user_id,".$userstring.")";
			
			$query->whereIn('user_id',$user_ar);
			
			//$results = Property::with('builder_detail','property_gallery')->$where ;
			//$prop = $results->toArray();
		}
		else {
			 $header_state = "";
				 $header_state = Session::get('header_state');
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
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
					// $userstring = "'" . implode("','", $user_ar) . "'";
					//$wherein.= "->whereIn(user_id,".$userstring.")";
			
				$query->whereIn('user_id',$user_ar);
			
			} 
		
		if(!empty($_REQUEST['bedroom']) && $_REQUEST['bedroom'] != 'Bedrooms')
		{
			$bedroom = $_REQUEST['bedroom'];
			if($bedroom == '1') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '1plus') 
			{
				$bedroom = '1' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '2') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '2plus') 
			{
				$bedroom = '2' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '3') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '3plus') 
			{
				$bedroom = '3' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '4') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '4plus') 
			{
				$bedroom = '4' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '5') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '5plus') 
			{
				$bedroom = '5' ;
				$query->where('bedrooms' , $bedroom);
			}
				//$where.= whereIn('user_id',$user_ar)->get();
		}
		if(!empty($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] != 'Bathrooms')
		{
			$bathroom = $_REQUEST['bathrooms'];
			if($bathroom == '1') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '1plus') 
			{
				$bathroom = '1' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '2') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '2plus') 
			{
				$bathroom = '2' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '3') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '3plus') 
			{
				$bathroom = '3' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '4') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '4plus') 
			{
				$bathroom = '4' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '5') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '5plus') 
			{
				$bathroom = '5' ;
				$query->where('bathrooms' , $bathroom);
			}
				
				
		}
		if(!empty($_REQUEST['living_spaces']) && $_REQUEST['living_spaces'] != 'Living Spaces')
		{
			 $living_spaces = $_REQUEST['living_spaces'];
			if($living_spaces == '1') 
			{
				$query->where('living' , $living_spaces);
			}
			if($living_spaces == '1plus') 
			{
				$living_spaces = '1' ;
				$query->where('living' , '>=' , $living_spaces);
			}
			if($living_spaces == '2') 
			{
				$query->where('living' , $living_spaces);
			}
			if($living_spaces == '2plus') 
			{
				$living_spaces = '2' ;
				$query->where('living' , '>=' , $living_spaces);
			}
			if($living_spaces == '3') 
			{
				$query->where('living' , $living_spaces);
			}
			if($living_spaces == '3plus') 
			{
				$living_spaces = '3' ;
				$query->where('living' , '>=' , $living_spaces);
			}
			if($living_spaces == '4') 
			{
				$query->where('living' , $living_spaces);
			}
			if($living_spaces == '4plus') 
			{
				$living_spaces = '4' ;
				$query->where('living' , '>=' , $living_spaces);
			}
	
		}
		
		if(!empty($_REQUEST['car_spaces']) && $_REQUEST['car_spaces'] != 'Car Spaces')
		{
			 $car_spaces = $_REQUEST['car_spaces'];
			if($car_spaces == '1') 
			{
				$query->where('cars' , $car_spaces);
			}
			if($car_spaces == '1plus') 
			{
				$car_spaces = '1' ;
				$query->where('cars' , '>=' , $car_spaces);
			}
			if($car_spaces == '2') 
			{
				$query->where('cars' , $car_spaces);
			}
			if($car_spaces == '2plus') 
			{
				$car_spaces = '2' ;
				$query->where('cars' , '>=' , $car_spaces);
			}
			if($car_spaces == '3') 
			{
				$query->where('cars' , $car_spaces);
			}
			if($car_spaces == '3plus') 
			{
				$car_spaces = '3' ;
				$query->where('cars' , '>=' , $car_spaces);
			}
		}
		
		if(!empty($_REQUEST['floor_count']) && $_REQUEST['floor_count'] != 'Stories')
		{
			 $floor_count = $_REQUEST['floor_count'];
			$query->where('stories' , $floor_count);	
		}
		
		if(!empty($_REQUEST['alfresco']) && $_REQUEST['alfresco'] != 'Alfresco')
		{
			 $alfresco = $_REQUEST['alfresco'];
			$query->where('alfresco' , $alfresco);	
		}
		if(!empty($_REQUEST['duplex']) && $_REQUEST['duplex'] != 'duplex')
		{
			 $duplex = $_REQUEST['duplex'];
			 $query->where('dual_occ' , $duplex);	
		}
		if(!empty($_REQUEST['builder']) && $_REQUEST['builder'] != 'Specific Builder')
		{
			 $builder = $_REQUEST['builder'];
			 $query->where('user_id' , $builder);	
		}
		
		if(!empty($_REQUEST['min_price_val']) && !empty($_REQUEST['max_price_val']))
		{
			  $min_price = str_replace(',' , '' , $_REQUEST['min_price_val']);
			  $max_price = str_replace(',' , '' , $_REQUEST['max_price_val']);
			 $query->whereBetween('price', [$min_price, $max_price]);
		}
		
		if(!empty($_REQUEST['min_hland_size']) && !empty($_REQUEST['max_hland_size']))
		{
			  $min_hland_size = str_replace(',' , '' , $_REQUEST['min_hland_size']);
			  $max_hland_size = str_replace(',' , '' , $_REQUEST['max_hland_size']);
			 $query->whereBetween('land_size', [$min_hland_size, $max_hland_size]);
		}
		
		
		if(!empty($_REQUEST['min_block_width']) && !empty($_REQUEST['max_block_width']))
		{
			  $min_block_width = $_REQUEST['min_block_width'];
			  $max_block_width = $_REQUEST['max_block_width'];
			 $query->whereBetween('min_block_width', [$min_block_width, $max_block_width]);
		}
		
		if(!empty($_REQUEST['min_block_length']) && !empty($_REQUEST['max_block_length']))
		{
			  $min_block_length = $_REQUEST['min_block_length'];
			  $max_block_length = $_REQUEST['max_block_length'];
			 $query->whereBetween('min_block_length', [$min_block_length, $max_block_length]);
		}
		
		if(!empty($_REQUEST['min_house_size']) && !empty($_REQUEST['max_house_size']))
		{
			  $min_house_size = $_REQUEST['min_house_size'];
			  $max_house_size = $_REQUEST['max_house_size'];
			 $query->whereBetween('housesize', [$min_house_size, $max_house_size]);
		}
		
		if(!empty($_REQUEST['sort_prop']) && $_REQUEST['sort_prop'] != 'Select')
		{
			if($_REQUEST['sort_prop'] == 'base_price:asc')
			{
				$query->orderBy('price', 'ASC');
			}
			if($_REQUEST['sort_prop'] == 'base_price:desc')
			{
				$query->orderBy('price', 'DESC');
			}
			if($_REQUEST['sort_prop'] == 'model_name:asc')
			{
				$query->orderBy('property_title', 'ASC');
			}
			if($_REQUEST['sort_prop'] == 'model_name:desc')
			{
				$query->orderBy('property_title', 'DESC');
			}
			if($_REQUEST['sort_prop'] == 'builder_name:asc')
			{

				$builders = BuilderDetail::orderBy('company_name','asc')->get(array('builder_id'));
				$builders_arr = $builders->toArray();
				$builder = "";
				$builderids = "";
				if(!empty($builders_arr)) {
				foreach($builders_arr as $builder_val)
				{
					$builder[] = $builder_val['builder_id'];
				}
				$builderids = implode(',', $builder);
				if(!empty($builderids)) {
				$query->orderByRaw(DB::raw("FIELD(user_id, $builderids)"));
				}
				}
			
			}
			if($_REQUEST['sort_prop'] == 'builder_name:desc')
			{
				$builders = BuilderDetail::orderBy('company_name','desc')->get(array('builder_id'));
				$builders_arr = $builders->toArray();
				$builder = "";
				$builderids = "";
				if(!empty($builders_arr)) {
				foreach($builders_arr as $builder_val)
				{
					$builder[] = $builder_val['builder_id'];
				}
				$builderids = implode(',', $builder);
				if(!empty($builderids)) {
				$query->orderByRaw(DB::raw("FIELD(user_id, $builderids)"));
				}
				}
				
			} 
			
		}
		
			if(!empty($_REQUEST['incids']))
			{
				$incids_arr = explode(',',$_REQUEST['incids']);
				$prop_inc   =   PropertyInclusion::whereIn('inclusion_id',$incids_arr)->groupBy('property_id')->get(array('property_id'));
				$propids_arr = $prop_inc->toArray();
				$propidsarr = "";
				if(!empty($propids_arr)) {
				foreach($propids_arr as $propid_val)
				{
					$propidsarr[] = $propid_val['property_id'];
				}
				$query->whereIn('id',$propidsarr);
				}
				
			}
		$query->orderBy('featured', 'desc')->orderBy('featured_order', 'asc');
		$query->where('status',1);
		$query->where('property_type', "2");
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
			
			$data['page'] = $page;
			$data['lastpage'] = $lastpage;
			$data['numrows'] = $numrows;
			$data['currentpage'] = $currentpage;
			$query->limit($rows_per_page);
			$query->offset($start);
			
		// echo $query->getQuery()->toSql();
	//	$query->limit(10);
		$results = $query->get();
		$prop = $results->toArray();
	/* 	echo '<pre>';
		print_r($prop); */

		$html = $this->get_house_land_html($prop,$page,$lastpage,$numrows,$currentpage,$rows_per_page);
		echo $html ;
		/* echo '<pre>';
		print_r($prop); */

		}
	}
	
	public function ajax_filter_count_house_land()
	{
		if(!empty($_REQUEST['build_location'])  || !empty($_REQUEST['bedroom']) || !empty($_REQUEST['bathrooms']) || !empty($_REQUEST['living_spaces']) || !empty($_REQUEST['car_spaces']) || !empty($_REQUEST['floor_count']) || !empty($_REQUEST['alfresco']) || !empty($_REQUEST['duplex']) || !empty($_REQUEST['builder']) || !empty($_REQUEST['min_hland_size']) || !empty($_REQUEST['max_hland_size']) || !empty($_REQUEST['min_price_val']) || !empty($_REQUEST['max_price_val']) ) {
		$query = Property::with('builder_detail','property_gallery');
		$query->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
		if(!empty($_REQUEST['build_location']) && $_REQUEST['build_location'] != "Build Location")
		{
			$loc_id = $_REQUEST['build_location'];
			$users = UserLocation::where('state_id', $loc_id)->groupBy('user_id')->get(array('user_id'));
			$users_arr = $users->toArray();
			$user_ar = "";
			foreach($users_arr as $user_val)
			{
				$user_ar[] = $user_val['user_id'];
			}
			
			
			///$userstring = "'" . implode("','", $user_ar) . "'";
			//$wherein.= "->whereIn(user_id,".$userstring.")";
			$query->whereIn('user_id',$user_ar);
			
			//$results = Property::with('builder_detail','property_gallery')->$where ;
			//$prop = $results->toArray();
		} else {
				$query = Property::with('builder_detail','property_gallery');
				$query->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
			 $header_state = "";
				 $header_state = Session::get('header_state');
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
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
			
			}
		
		if(!empty($_REQUEST['bedroom']) && $_REQUEST['bedroom'] != 'Bedrooms')
		{
			$bedroom = $_REQUEST['bedroom'];
			if($bedroom == '1') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '1plus') 
			{
				$bedroom = '1' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '2') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '2plus') 
			{
				$bedroom = '2' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '3') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '3plus') 
			{
				$bedroom = '3' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '4') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '4plus') 
			{
				$bedroom = '4' ;
				$query->where('bedrooms' , '>=' , $bedroom);
			}
			if($bedroom == '5') 
			{
				$query->where('bedrooms' , $bedroom);
			}
			if($bedroom == '5plus') 
			{
				$bedroom = '5' ;
				$query->where('bedrooms' , $bedroom);
			}
				//$where.= whereIn('user_id',$user_ar)->get();
		}
		if(!empty($_REQUEST['bathrooms']) && $_REQUEST['bathrooms'] != 'Bathrooms')
		{
			 $bathroom = $_REQUEST['bathrooms'];
			if($bathroom == '1') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '1plus') 
			{
				$bathroom = '1' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '2') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '2plus') 
			{
				$bathroom = '2' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '3') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '3plus') 
			{
				$bathroom = '3' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '4') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '4plus') 
			{
				$bathroom = '4' ;
				$query->where('bathrooms' , '>=' , $bathroom);
			}
			if($bathroom == '5') 
			{
				$query->where('bathrooms' , $bathroom);
			}
			if($bathroom == '5plus') 
			{
				$bathroom = '5' ;
				$query->where('bathrooms' , $bathroom);
			}
				
				
		}
		if(!empty($_REQUEST['living_spaces']) && $_REQUEST['living_spaces'] != 'Living Spaces')
		{
			 $living_spaces = $_REQUEST['living_spaces'];
			if($living_spaces == '1') 
			{
				$query->where('living' , $living_spaces);
			}
			if($living_spaces == '1plus') 
			{
				$living_spaces = '1' ;
				$query->where('living' , '>=' , $living_spaces);
			}
			if($living_spaces == '2') 
			{
				$query->where('living' , $living_spaces);
			}
			if($living_spaces == '2plus') 
			{
				$living_spaces = '2' ;
				$query->where('living' , '>=' , $living_spaces);
			}
			if($living_spaces == '3') 
			{
				$query->where('living' , $living_spaces);
			}
			if($living_spaces == '3plus') 
			{
				$living_spaces = '3' ;
				$query->where('living' , '>=' , $bathroom);
			}
			if($living_spaces == '4') 
			{
				$query->where('living' , $bathroom);
			}
			if($living_spaces == '4plus') 
			{
				$living_spaces = '4' ;
				$query->where('living' , '>=' , $living_spaces);
			}
	
		}
		
		if(!empty($_REQUEST['car_spaces']) && $_REQUEST['car_spaces'] != 'Car Spaces')
		{
			 $car_spaces = $_REQUEST['car_spaces'];
			if($car_spaces == '1') 
			{
				$query->where('cars' , $car_spaces);
			}
			if($car_spaces == '1plus') 
			{
				$car_spaces = '1' ;
				$query->where('cars' , '>=' , $car_spaces);
			}
			if($car_spaces == '2') 
			{
				$query->where('cars' , $car_spaces);
			}
			if($car_spaces == '2plus') 
			{
				$car_spaces = '2' ;
				$query->where('cars' , '>=' , $car_spaces);
			}
			if($car_spaces == '3') 
			{
				$query->where('cars' , $car_spaces);
			}
			if($car_spaces == '3plus') 
			{
				$car_spaces = '3' ;
				$query->where('cars' , '>=' , $car_spaces);
			}

		}
		
		if(!empty($_REQUEST['floor_count']) && $_REQUEST['floor_count'] != 'Stories')
		{
			 $floor_count = $_REQUEST['floor_count'];
			$query->where('stories' , $floor_count);	
		}
		
		if(!empty($_REQUEST['alfresco']) && $_REQUEST['alfresco'] != 'Alfresco')
		{
			 $alfresco = $_REQUEST['alfresco'];
			$query->where('alfresco' , $alfresco);	
		}
		if(!empty($_REQUEST['duplex']) && $_REQUEST['duplex'] != 'duplex')
		{
			 $duplex = $_REQUEST['duplex'];
			 $query->where('dual_occ' , $duplex);	
		}
		
		if(!empty($_REQUEST['builder']) && $_REQUEST['builder'] != 'Specific Builder')
		{
			 $builder = $_REQUEST['builder'];
			 $query->where('user_id' , $builder);	
		}
		if(!empty($_REQUEST['min_price_val']) && !empty($_REQUEST['max_price_val']))
		{
			  $min_price = str_replace(',' , '' , $_REQUEST['min_price_val']);
			  $max_price = str_replace(',' , '' , $_REQUEST['max_price_val']);
			 $query->whereBetween('price', [$min_price, $max_price]);
		}
		if(!empty($_REQUEST['min_hland_size']) && !empty($_REQUEST['max_hland_size']))
		{
			  $min_hland_size = str_replace(',' , '' , $_REQUEST['min_hland_size']);
			  $max_hland_size = str_replace(',' , '' , $_REQUEST['max_hland_size']);
			 $query->whereBetween('land_size', [$min_hland_size, $max_hland_size]);
		}
		if(!empty($_REQUEST['min_block_width']) && !empty($_REQUEST['max_block_width']))
		{
			  $min_block_width = $_REQUEST['min_block_width'];
			  $max_block_width = $_REQUEST['max_block_width'];
			 $query->whereBetween('min_block_width', [$min_block_width, $max_block_width]);
		}
		if(!empty($_REQUEST['min_block_length']) && !empty($_REQUEST['max_block_length']))
		{
			  $min_block_length = $_REQUEST['min_block_length'];
			  $max_block_length = $_REQUEST['max_block_length'];
			 $query->whereBetween('min_block_length', [$min_block_length, $max_block_length]);
		}
		if(!empty($_REQUEST['min_house_size']) && !empty($_REQUEST['max_house_size']))
		{
			  $min_house_size = $_REQUEST['min_house_size'];
			  $max_house_size = $_REQUEST['max_house_size'];
			 $query->whereBetween('housesize', [$min_house_size, $max_house_size]);
		}
		
		if(!empty($_REQUEST['sort_prop']) && $_REQUEST['sort_prop'] != 'Select')
		{
			if($_REQUEST['sort_prop'] == 'base_price:asc')
			{
				$query->orderBy('price', 'ASC');
			}
			if($_REQUEST['sort_prop'] == 'base_price:desc')
			{
				$query->orderBy('price', 'DESC');
			}
			if($_REQUEST['sort_prop'] == 'model_name:asc')
			{
				$query->orderBy('property_title', 'ASC');
			}
			if($_REQUEST['sort_prop'] == 'model_name:desc')
			{
				$query->orderBy('property_title', 'DESC');
			}
		if($_REQUEST['sort_prop'] == 'builder_name:asc')
			{

				$builders = BuilderDetail::orderBy('company_name','asc')->get(array('builder_id'));
				$builders_arr = $builders->toArray();
				$builder = "";
				$builderids = "";
				if(!empty($builders_arr)) {
				foreach($builders_arr as $builder_val)
				{
					$builder[] = $builder_val['builder_id'];
				}
				$builderids = implode(',', $builder);
				if(!empty($builderids)) {
				$query->orderByRaw(DB::raw("FIELD(user_id, $builderids)"));
				}
				}
			
			}
			if($_REQUEST['sort_prop'] == 'builder_name:desc')
			{
				$builders = BuilderDetail::orderBy('company_name','desc')->get(array('builder_id'));
				$builders_arr = $builders->toArray();
				$builder = "";
				$builderids = "";
				if(!empty($builders_arr)) {
				foreach($builders_arr as $builder_val)
				{
					$builder[] = $builder_val['builder_id'];
				}
				$builderids = implode(',', $builder);
				if(!empty($builderids)) {
				$query->orderByRaw(DB::raw("FIELD(user_id, $builderids)"));
				}
				}
				
			} 
			
			
		}
		
		if(!empty($_REQUEST['incids']))
			{
				$incids_arr = explode(',',$_REQUEST['incids']);
				$prop_inc   =   PropertyInclusion::whereIn('inclusion_id',$incids_arr)->groupBy('property_id')->get(array('property_id'));
				$propids_arr = $prop_inc->toArray();
				$propidsarr = "";
				if(!empty($propids_arr)) {
				foreach($propids_arr as $propid_val)
				{
					$propidsarr[] = $propid_val['property_id'];
				}
				$query->whereIn('id',$propidsarr);
				}
				
			}
		
		$query->orderBy('featured', 'Desc');
		$query->where('status',1);
		$query->where('property_type', "2");
		$prop_count = $query->count();
		echo $prop_count;
		}
	
	}
	
	public function get_house_land_html($prop_data,$page,$lastpage,$numrows,$currentpage,$rows_per_page)
	{
			
			$html= '';
		if(!empty($prop_data)) {
		 $html.='<div id="ajaxloader"></div>';
		foreach($prop_data as $prop_val) {
	
	    $html.= '<div class="featured-box search-featured-box">
                <div class="featured-image">
                    <div class="featured-strip">
                        <div class="featured-strip-box"><a href="javascript:void(0);" class="open_quicklook"   data-target=".quick-look-modal" data-id = "'.$prop_val['id'].'"><img src="'.url().'/assets/images/featured-strip-icon1.png" alt="featured" /><span>View</span></a></div>
                        <div class="featured-strip-box"><a class="open_enquirybox" value="Enquire to Builders"  data-target=".bs-example-modal-lg" data-id = "'.$prop_val['id'].'"  href="javascript:void(0);" data-toggle="modal"><img src="'.url().'/assets/images/featured-strip-icon2.png" alt="featured" /><span>Enquire</span></a></div>
                                               <div class="featured-strip-box">';
						$check_save_prop =  App\Models\SaveProperty::check_save_prop($prop_val['id']) ; 
						$html.= '<a href="javascript:void(0);" rel="'.$prop_val['id'].'" class="save_property" >';
						if($check_save_prop != '0') { 
						
						$html.= '<img src="'.url().'/assets/images/featured-strip-icon-blue.png" alt="featured" id="compare_src_'.$prop_val['id'].'" />';
						 } else { 
						$html.= '<img src="'.url().'/assets/images/featured-strip-icon3.png" id="compare_src_'.$prop_val['id'].'" alt="featured" />';
						}
					$html.=	'<span id="save_text_'.$prop_val['id'].'">Compare</span></a>
						<input type="hidden" value="' ;
						if($check_save_prop != '0') { $html.= 'Compared' ; } else { $html.= 'Compare' ; } $html.= 'id="comp_text_'.$prop_val['id'].'"/> 
						</div>
                        <div class="featured-strip-box"></div>
                    </div>
					 <div class="model_img">';
					
					
					if(!empty($prop_val['property_gallery'])) {
						foreach($prop_val['property_gallery'] as $prop_img) {
						
							$html.= '<a href="'.url().'/propertydetail/'.$prop_val['id'].'"><img class="img-full" src="'.url().'/public/timthumb.php?src=/uploads/property_gallery/'.$prop_img['image'].'&h=400&w=700&q=100" class="gal_img" /></a>';
						}
					
					} else {
					
					$html.= '<a href="'.url().'/propertydetail/'.$prop_val['id'].'"><img src="'.url().'/assets/img/no-image.jpg" class="img-full" /></a>';
					}
					
					
								
				$html.= '</div>
                </div>
                <div class="featured-box-btm">
                    <ul>
                        <li><span class="features"><a href=""><img src="'.url().'/assets/images/bed-icon.png" alt="Beds" /></a></span><p><span>'.$prop_val['bedrooms'].'</span> Beds</p></li>
                        <li><span class="features"><a href=""><img src="'.url().'/assets/images/bath-icon.png" alt="Beds" /></a></span><p><span>'.$prop_val['bathrooms'].'</span> Bath</p></li>
                        <li><span class="features"><a href=""><img src="'.url().'/assets/images/living-icon.png" alt="Beds" /></a></span><p><span>'.$prop_val['living'].'</span> Living</p></li>
                        <li><span class="features"><a href=""><img src="'.url().'/assets/images/area-icon.png" alt="Beds" /></a></span><p><span>'.$prop_val['housesize'].'</span> Sq</p></li>
                    </ul>
                    <div class="featured-price">
					<h4>'.$prop_val['property_title'].'</h4>
                        <p>From $'.number_format($prop_val['price'],2).'</p>
						<img src="'.url().'/uploads/builder_logo/'.$prop_val['builder_detail']['logo'].'" class="featured-logo" alt="image"/>
                    </div>
                    
                    <h5>';
					
					if(!empty($prop_val['description'])) {  $string = strip_tags($prop_val['description']);

if (strlen($string) > 115) {

    // truncate string
    $stringCut = substr($string, 0, 115);

    // make sure it ends in a word so assassinate doesn't become ass...
    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
}
$html.= $string; ; } 
$html.= '</h5>
                </div>
            </div>';
	
	
	
          
                            	
		}

$ptemp = url().'/house-and-lands?';
		 $pages = '';

$pages.='<div class="clr"></div><ul class="pagination">';
//echo $whereStr;
	if ($currentpage != 1) 
{ //GOING BACK FROM PAGE 1 SHOULD NOT BET ALLOWED
 $previous_page = $currentpage - 1;
 //$previous = '<a href="'.$ptemp.'?pageno='.$previous_page.'"> </a> '; 
$previous = '&lt;Previous' ;
 $pages.= "<li><a  href=\"javascript:void(0)\"  class=\"pagi\" rel=".$previous_page." >" . $previous . "</a>\n</li>";    
}

$adjacents = 2;
/* $a=1;
foreach($properties_arr as $prop_values) 
{
  if ($a == $currentpage) 
  $pages .= '<li><a href="#" class="active">'. $a .'</a></li>';
  else 
 $pages .= '<li><a href="'.$ptemp.'page='.$a.$whereStr1.'">'. $a .'</a></li>';
 $a++;
} */

   $pmin = ($currentpage > $adjacents) ? ($currentpage - $adjacents) : 1;
     $pmax = ($currentpage < ($lastpage - $adjacents)) ? ($currentpage + $adjacents) : $lastpage;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $currentpage) {
            $pages.= "<li  class=\"active\"><a href='#'>" . $i . "</a></li>\n";
        } elseif ($i == 1) {
            $pages.= "<li><a  href=\"javascript:void(0)\"  class=\"pagi\" rel=".$i.">" . $i . "</a>\n</li>";
        } else {
            $pages.= "<li><a  href=\"javascript:void(0)\"  class=\"pagi\" rel=".$i." >" . $i . "</a>\n</li>";
        }
    }
	
	
    

//$pages = substr($pages,0,-1); //REMOVING THE LAST COMMA (,)

if($currentpage != $lastpage) 
{

 //GOING AHEAD OF LAST PAGE SHOULD NOT BE ALLOWED
 $next_page = $currentpage + 1;
 $next = 'Next&gt;';
$pages.= "<li><a  href=\"javascript:void(0)\"  class=\"pagi\" rel=".$next_page." >" . $next . "</a>\n</li>";
}
$pages.='</ul>';
$html.=  $pages ; //PAGINATION LINKS

		} else {
				$html.= '<div id="ajaxloader"></div><h2>No results</h2><br/><p>
There are no products matching your search criteria. Try making your filters less specific.</p>';

			}
			
			
		
		return $html ;
	}
	
	public function load_property_quick_look()
	{
		if(!empty($_REQUEST['property_ids'])) {
		$prop_id = $_REQUEST['property_ids'] ;
		$results = Property::with('builder_detail','property_gallery','property_floor_plans','property_inclusions','property_display_homes')->where(['id' => $prop_id])->get();
		$gallery = PropertyGallery::where(['property_id' => $prop_id])->orderBy('gallery_order', 'Asc')->get();
		$prop_arr = $results->toArray();
		$gallery_images = $gallery->toArray();;
		$inc = Inclusion::where(['parent_id'=>'0'])->get();
		//$data['inc_arr']  = $inc->toArray();
		$data['title'] = 'Property Details';
		$data['prop_id'] = $prop_id;
		//$inc_arr = $this->get_parent_filter_inc();
		$data['inc_arr']  = $inc->toArray();
		$q = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and add_size='300' and status='Publish'")->limit(2);
		$ads_obj  = $q->get();
		$ads_arr = $ads_obj->toArray();
		$data['ads_arr'] = $ads_arr;

		$html="";
		$html.='<div class="quick-look-pop">
		
		<input type="hidden" name="property_id" value="'.$prop_arr[0]['id'].'" id="pop_prop_id" />
    <div class="ql-left">
        <div class="ql-slide-img">';
		
		if(count($gallery_images) > 0){
				foreach($gallery_images as $val){
					$image = $_SERVER['DOCUMENT_ROOT'].'/uploads/property_gallery/'.$val['image'];
            $html.='<img src="'.url().'/uploads/property_gallery/'.$val['image'].'" class="prop_slider_img"/>';
			} } else {  $html.='<img src="'.url().'/assets/img/no-image.jpg" class="prop_slider_img" />'; }
			
			if(count($prop_arr[0]['property_floor_plans']) > 0){
					$j = 0;
					foreach($prop_arr[0]['property_floor_plans'] as $val){
					$html.='<img src="'.url().'/uploads/property_floor/'.$val['image'].'" class="prop_slider_img" style="width:483px;height:630px;"/>';
					}}
			
					
            $html.='
        </div>';
		
        $html.='<ul class="ql-thumb">';
		   
		   if(count($gallery_images) > 0){
				foreach($gallery_images as $val){
					$image = $_SERVER['DOCUMENT_ROOT'].'/uploads/property_gallery/'.$val['image'];
            $html.='<li><img src="'.url().'/uploads/property_gallery/'.$val['image'].'" class="prop_slider_img" /></li>';
			} } else {  $html.='<li><img src="'.url().'/assets/img/no-image.jpg" class="prop_slider_img" /></li>'; } 
			if(count($prop_arr[0]['property_floor_plans']) > 0){
					$j = 0;
					foreach($prop_arr[0]['property_floor_plans'] as $val){
					$html.='<li><img src="'.url().'/uploads/property_floor/'.$val['image'].'" class="prop_slider_img" /></li>';
					}}
			
			
			
       $html.= '</ul>
    </div>
    <div class="ql-right">
        <div class="ql-right-head">';
         $html.= '<h2>';
		 if (strlen($prop_arr[0]['property_title']) > 20) { $html.= substr($prop_arr[0]['property_title'],0,20).'...'; } else { $html.= $prop_arr[0]['property_title'];  }
		$html.= '</h2>
            <h3>From $'.number_format($prop_arr[0]['price'] , 2).' <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="The price or price range shown here is indicative only and will vary depending on the final inclusions, location of the build, the house façade and other customisations selected."></i></h3><div class="pop_logo">
            <a href="'.url().'/builder-detail/'.$prop_arr[0]['builder_detail']['builder_id'].'"><img src="'.url().'/uploads/builder_logo/'.$prop_arr[0]['builder_detail']['logo'].'" alt="image"></a></div>
        </div>
        <div class="ql-details">
            <div class="qld-left">
                <div class="view1-bottom-box">
                    <p><img src="'.url().'/assets/img/bed-green.png" alt="Bedrooms">Bedrooms:</p>
                    <p>'.$prop_arr[0]['bedrooms'].'</p>
                </div>
                <div class="view1-bottom-box">
                    <p><img src="'.url().'/assets/img/bathroom.png" alt="Bathrooms">Bathrooms:</p>
                    <p>'.$prop_arr[0]['bathrooms'].'</p>
                </div>
                <div class="view1-bottom-box">
                    <p><img src="'.url().'/assets/img/house-size.png" alt="House size">House size:</p>
                    <p>'.$prop_arr[0]['housesize'].'</p>
                </div>';
				if($prop_arr[0]['property_type'] == '2') {
				$html.=  '<div class="view1-bottom-box">
                    <p><img src="'.url().'/assets/img/house-size.png" alt="House size">Land size:</p>
                    <p>'.$prop_arr[0]['land_size'].'</p>
                </div>';
				} 
                $html.= '<div class="view1-bottom-box">
                    <p><img src="'.url().'/assets/img/story.png" alt="Storey">Storey:</p>
                    <p>'.$prop_arr[0]['stories'].'</p>
                </div>
				
            </div>
            <div class="qld-right">
                <div class="prb-sec2">
                 <div class="pd-box1">
				   <a href="javascript:void(0);" rel="'.$prop_arr[0]['id'].'" class="save_property_new" >';
				 $check_save_prop = SaveProperty::check_new_save_prop($prop_arr[0]['id']);
                $html.= '<div class="pd-box2">
                    <span>';  if($check_save_prop != '0') { 
					$html.= '<img src="'.url().'/assets/img/star_hover.png" data-pop-save_'.$prop_arr[0]['id'].'="Saved" id="pop_save_src_'.$prop_arr[0]['id'].'">';
					} else { $html.='<img src="'.url().'/assets/img/star.png" data-pop-save_'.$prop_arr[0]['id'].'="Save" id="pop_save_src_'.$prop_arr[0]['id'].'">'; } $html.= '</span>
                    <p>	<a href="javascript:void(0);" rel="'.$prop_arr[0]['id'].'" class="save_property_new" data-pop-save_'.$prop_arr[0]['id'].'="Saved" ><span id="pop_save_text2_'.$prop_arr[0]['id'].'" class="prop_text1">';
					if($check_save_prop != '0') { $html.= 'Saved' ; } else { $html.= 'Save' ; } $html.= '</span></a></p>
                </div>
				</a>
                </div>
                <div class="pd-box1">
				<a href="javascript:void(0);" rel="'.$prop_arr[0]['id'].'" class="save_property" >
                    <div class="pd-box2">';
					$check_save_prop =  SaveProperty::check_save_prop($prop_arr[0]['id']) ;
                     $html.= '<span>';
					 if($check_save_prop != '0') { $html.= '<img src="'.url().'/assets/img/comapre_hover.png" style="width:61%" id="pop_compare_src_'.$prop_arr[0]['id'].'">'; } else { $html.= '<img src="'.url().'/assets/img/comapre.png" style="width:61%" id="pop_compare_src_'.$prop_arr[0]['id'].'">'; } $html.= '</span>
                        <p><span id="pop_save_text_'.$prop_arr[0]['id'].'" class="prop_text popup_prop_text">';
						if($check_save_prop != '0') { $html.= 'Compared' ; } else { $html.= 'Compare' ; } $html.='</span></p>
                    </div>
					</a>
                </div>
                <div class="clr"></div>
             </div>
             <a class="view-full" href="'.url().'/propertydetail/'.$prop_arr[0]['id'].'">View full detail <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
            </div>
            <div class="clr"></div>
        </div>
        <div class="ql-callback">
            <a href="" class="head-icon"><i class="fa fa-phone" aria-hidden="true"></i></a>
            <h2>Request a callback</h2>
            <p>Need help finding your dream home? Our consultants are here to help.</p>
            <form id="call_back">
                  <p>
                     <span><input type="text" placeholder="Enter your name" name="name" id="pop_name"></span>
                     <span><input type="text" placeholder="Enter your phone number" name="pop_phone_number" id="pop_phone_number" /></span>
                  </p>
                  <p><input type="text" placeholder="Enter your email" name="email" id="pop_email"></p>
                  <p>
                  <select name="contact_time" id="pop_contact_time">
                       <option value="">Best contact time</option>
					   <option  value="morning">Morning</option><option value="afternoon">Afternoon</option><option value="evening">Evening</option><option  value="weekends_only">Weekends Only</option><option value="anytime">Anytime</option>
                  </select>
                  </p>
                  <p>
                     <input type="checkbox" id="pop_terms-conditions" checked>
                     By using this, I agree to the iCompare <a href="'.url().'/terms-and-conditions" target="_blank">terms & conditions</a>, <a href="'.url().'/privacy-policy" target="_blank">Privacy policy</a>
                  </p>
                  <p>
                     <input type="button" value="Submit" id="submit_call_back">
                  </p>
            </form>
        </div>
    </div>
    <div class="clr"></div>
</div>';
echo $html;
		} else {
			$html='<h2>Error in processing request.</h2>';
		}

	}
	
	public function send_request_call_back()
	{
		$property_id = $_REQUEST['property_id'];
		if(!empty($property_id)) {
		$propertobj = Property::with('builder_detail','property_gallery')->where('id',$property_id)->get();
		$prop_arr =	$propertobj->toArray();

		 $status = 'false';
		 $data1 = array();
		foreach($prop_arr as $prop_val) {
			$builder_email = "";
			$email = "";
			$property_title = "";
			$builder_id = $prop_val['builder_detail']['builder_id'];
			$user_obj = User::where('id',$builder_id)->get();
			$user_arr = $user_obj->toArray();
			$email = $user_arr[0]['email'];
			$input = array();
			$input['name'] = $_REQUEST['name'];
			$input['phone_number'] = $_REQUEST['phone_number'];
			$input['email'] = $_REQUEST['email'];
			$input['contact_time'] = $_REQUEST['contact_time'];
			$data = array();
			$data['email'] = $email;
			$data['from']  = $_REQUEST['email'];
			$data['property_type'] = $prop_val['property_type'];
			$data['property_title'] = $prop_val['property_title'];
			$data1['property_title'] = $prop_val['property_title'];
			$sendmail = \Mail::send('emails.request-callback',
			array('property_arr'=>$prop_arr,'user_inputs'=>$input), function($message) use($data)
			{
				$property_title = $data['property_title'];
				if($data['property_type']=='1') {
					$subject = 'icompareBuilders - '.$property_title.' User Request a Callback';
				}
				if($data['property_type']=='2') {
					$subject = 'icompareBuilders - House & Lands '.$property_title.' User Request a Callback';
				}
				$email = $data['email'];
				//$email = 'palka.k@macrew.net';
				$from = $data['from'];
				//$email = "palka.k@macrew.net";
				$message->from($from);
				$message->to($email)->subject($subject);
			});
			$status = 'true';
		}
		echo 'success';
		}
		else {
		
		//Session::flash('failed', 'Please save some homes');
		echo 'failed_savesomehomes';
		}
	}

	
	
	
	
}
