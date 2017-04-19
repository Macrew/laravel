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
use App\LandEstateDetail;
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
use App\Models\LandEstate;
use App\Models\DisplayLand;
use App\Models\DisplayLandOpenHour;
use App\LandGallery;
use Auth;
use DB;
use Log;

class LandEstateController extends Controller
{
	public function index(){

		//echo $query->getQuery()->toSql();
		//$results = $query->get();
		
		$page	=	"" ;
		$lastpage	=	"" ;
		$numrows  = "" ;
		$total_land = LandEstateDetail::count();
			if(isset($_REQUEST['page']))
			{
				$page = $_REQUEST['page'];
			}
			else
			{
				$page	=	1 ;
			}
			
			$numrows	=	$total_land ;
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
			$query = LandEstateDetail::limit($rows_per_page)->offset($start);
			//$query->limit($rows_per_page);
			//$query->offset($start);
			//echo  $query->getQuery()->toSql();
			$results = $query->get();

		$data['landestates_arr'] = $results->toArray();
		
		$data['total_land'] = $total_land;
		$q = AddManagement::whereRaw("start_date <= CURDATE() and end_date >= CURDATE() and add_size='200' and status='Publish'")->limit(2);
		$ads_obj  = $q->get();
		$ads_arr = $ads_obj->toArray();
		$data['ads_arr'] = $ads_arr;
		$results = DB::table('testimonials')->where('featured','Yes')->orderByRaw('RAND()')->limit('1')->get();
		//$results = User::where($where_arr)->builders;

		$data['testimonials'] = $results;
		$header_state = "";
		 $header_state = Session::get('header_state');
		 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
		$data['build_location'] = State::where(['state_name' => $headr_state])->get();
		
		$data['title'] = 'Search New Lands';
		return view('land-estates',$data);
	}
	
	public function enquire_land()
	{
		$landids  = $_REQUEST['landids'];
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
		if(!empty($firstname) && !empty($lastname)){
			$name = $firstname.' '.$lastname;
		} else {
			$name = "";
		}
		$html='';
		$html.= '<div id="enquire_form"><div id="contactDeveloperPopup"><header><span>Request current land availability & price list</span></header>';
		$html.='<div class="contact-developer-form-container" id="contactDeveloperFormPopupContainer">
		<form method="post" action="" class="contact-form rui-form rui-form-compact" id="emailPropertyAgentPopupForm">
		<input type="hidden" name="landids" value="'.$landids.'" id="landids" />
		<div class="formCont"><input type="hidden" value="600005087" name="emailListingId" id="emailListingId"><div class="register-details-container">
		<p class="field-title-text">Your details</p> 
		<fieldset><label class="rui-form-element ">
		<span>Name *</span> 
		<input type="text" value="'.$name.'" placeholder="Name *" class="rui-input " name="fromName" id="fromName"></label>
		<label class="rui-form-element "><span>Email *</span> <input type="email" value="'.$user_email.'" placeholder="Email *" class="rui-input " name="fromAddress" id="fromAddress"></label> 
		<label class="rui-form-element "><span>Phone</span> <input type="tel" value="'.$phone.'" placeholder="Phone" class="rui-input " name="fromPhone" id="fromPhone"></label>
		</fieldset> 
		
		<div class="rui-form-element">
		<select class="rui-input rui-select" name="lookingTo" id="lookingTo">
		<option value="">About you: Please select</option>
		<option value="My house is on the market">My house is on the market</option>
		<option value="I have recently sold">I have recently sold</option>
		<option value="I am a first home buyer">I am a first home buyer</option>
		<option value="I am looking to invest">I am looking to invest</option>
		<option value="I am an overseas buyer">I am an overseas buyer</option>
		<option value="I am monitoring the market">I am monitoring the market</option>
		</select>
	
	<i class="filter-icon-down"></i></div></div> 
	<div class="register-message-container">
	<p class="field-title-text">Your comments</p> 
	<label class="rui-form-element"><span>Your comments</span><textarea placeholder="Your comments" class="rui-input" name="message" id="message"></textarea></label></div>
	<div class="clr"></div>
	</div></div> <section class="privacy-and-submit"><div id="privacy-policy-container" class="privacy-policy"><div class="privacy-statement cp-left agree"><input type="checkbox" checked="checked" value="1" name="agree" id="pland_agree"><label for="pland_agree">
			</label>By using this form, I agree to the iCompareLoans <a href="http://www.icompareloans.com.au/" target="_blank">terms & conditions</a>, <a href="http://www.icompareloans.com.au/" target="_blank">privacy policy</a></div> <button class="rui-button-brand" type="button" id="enquire_land_user">Send</button></div></section></form></div></div>

	<div id="message-popup" style="display:none;">
	<div id="contactDeveloperPopup"><header><span>Request current land availability & price list</span></header>
	<p style="text-align:center;font-weight:bold;padding-top:10px">Thank you for your enquiry!</p><p style="text-align:center">One of our sales consultants will contact you shortly.</p>
	</div></div>
	
	
	';
				echo $html;
	}
	
	public function send_email_land()
	{
		//print_r($_REQUEST['data']);
		$user_data = $_REQUEST['data'];
		$land_ids = "";$email_id = "";$name="";$phn = "";$lookingTo="";$message="";
		foreach($user_data as $user_val){
			if($user_val['name'] == 'landids') {
				$land_ids  = $user_val['value'];
			}
			if($user_val['name'] == 'fromName') {
				$name  = $user_val['value'];
			}
			if($user_val['name'] == 'fromAddress') {
				$email_id  = $user_val['value'];
			}
			if($user_val['name'] == 'fromPhone') {
				$phn  = $user_val['value'];
			}
			if($user_val['name'] == 'lookingTo') {
				$lookingTo  = $user_val['value'];
			}
			if($user_val['name'] == 'message') {
				$message  = $user_val['value'];
			}

	 }
	 
		$request_arr  = array();
		$request_arr['name']  = $name;
		$request_arr['email_id']  = $email_id;
		$request_arr['phn']  = $phn;
		$request_arr['lookingTo']  = $lookingTo;
		$request_arr['message']  = $message;
	 
		$land_arr  =  explode(',',$land_ids);
	 	$propertobj = LandEstateDetail::with('land_images')->whereIn('id',$land_arr)->get();
		$land_arr = $propertobj->toArray();
		foreach($land_arr as $prop_val) {
		$land_estate_id   = $prop_val['landestate_id'];
		$user_obj = User::where('id',$land_estate_id)->get();
		$user_arr = $user_obj->toArray();
		$email = $user_arr[0]['email'];
		$data1 = array();
		$data1['email'] = $email;
			//$data1['email'] = 'palka.k@macrew.net';
			$data1['land_user'] = $prop_val['company_name'];
			$data1['from'] = $request_arr['email_id'] ;
			$sendmail1 = \Mail::send('emails.enquire-land',
		 array('land_arr'=>$prop_val,'request_arr'=>$request_arr,'land_user'=>$data1['land_user']), function($message) use($data1)
			{
				//$email = $data['email'];
				$email = $data1['email'];
				//$email = 'palka.k@macrew.net';
				$from = $data1['from'];
				$message->from($from);
				$message->to($email)->subject('icompareBuilders - User Enquiry Regarding Land Estate');
			}); 
				echo 'success';
			}

	}
	
	
	
	public function get_land_html($prop_data,$page,$lastpage,$numrows,$currentpage,$rows_per_page)
	{
			
	 /* 	echo '<pre>';
		print_r($properties_arr);  */

		
				$html= '';
		if(!empty($prop_data)) {
		 $html.='<div id="ajaxloader"></div>';
		foreach($prop_data as $land_val) {
       $html.=   '<div class="grey_bg save_prop_check land_content"><!--white box!-->
        	<div class="model_left">
            	  <div class="cp-left save_sidebarcheck">
				
			<input type="checkbox" class="landlistcheckbox" name="landlistcheck" value="'.$land_val['id'].'" id="landlistcheck'.$land_val['id'].'">
						<label for="landlistcheck'.$land_val['id'].'">
			</label></div>
			<div class="land_logo_img">';
				 if(!empty($land_val['logo'])) {
				
			$html.=	'<a href="'.url().'/land/view/'.$land_val['id'].'"><img src="'.url().'/uploads/landestate_logo/'.$land_val['logo'].'"></a>';
			  } else { 
				$html.=	'<a href="'.url().'/land/view/'.$land_val['id'].'"><img src="'.url().'/assets/img/no-image.jpg"/></a>';
				 } 
				
				$html.= '</div>';
				$html.=  ' </div>
            <div class="clr"></div>
        </div>';
			
			
				
            
          
                            	
		}

$ptemp = url().'/property/search-property?';
		 $pages = '';

$pages.='<ul class="pagination">';
//echo $whereStr;
	if ($currentpage != 1) 
{ //GOING BACK FROM PAGE 1 SHOULD NOT BET ALLOWED
 $previous_page = $currentpage - 1;
 //$previous = '<a href="'.$ptemp.'?pageno='.$previous_page.'"> </a> '; 
$previous = '&lt;Previous' ;
 $pages.= "<li><a  href=\"javascript:void(0)\"  class=\"land_pagi\" rel=".$previous_page." >" . $previous . "</a>\n</li>";    
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
            $pages.= "<li><a  href=\"javascript:void(0)\"  class=\"land_pagi\" rel=".$i.">" . $i . "</a>\n</li>";
        } else {
            $pages.= "<li><a  href=\"javascript:void(0)\"  class=\"land_pagi\" rel=".$i." >" . $i . "</a>\n</li>";
        }
    }
	
	
    

//$pages = substr($pages,0,-1); //REMOVING THE LAST COMMA (,)

if($currentpage != $lastpage) 
{

 //GOING AHEAD OF LAST PAGE SHOULD NOT BE ALLOWED
 $next_page = $currentpage + 1;
 $next = 'Next&gt;';
$pages.= "<li><a  href=\"javascript:void(0)\"  class=\"land_pagi\" rel=".$next_page." >" . $next . "</a>\n</li>";
}
$pages.='</ul>';
$html.=  $pages ; //PAGINATION LINKS

		} else {
				$html.= '<div id="ajaxloader"></div><h2>No results</h2><br/><p>
There are no products matching your search criteria. Try making your filters less specific.</p>';

			}
			
			
		
		return $html ;
	}
	
	
	public function ajax_filter_lands()
	{
		if(!empty($_REQUEST['land_estate_location'])) {
		//$query = LandEstateDetail::;
		if(!empty($_REQUEST['land_estate_location']) && $_REQUEST['land_estate_location'] != "Land Location")
		{
			$loc_name = $_REQUEST['land_estate_location'];
			$re = State::where('id', $loc_name)->get(array('id'));
			$state_arr = $re->toArray();
				$states = "";

				
				foreach($state_arr as $st_val)
				{  
					$states[] = $st_val['id'];

				}
			$users = UserLocation::wherein('state_id', $states)->groupBy('user_id')->get(array('user_id'));
			$users_arr = $users->toArray();
			$user_ar = "";
			foreach($users_arr as $user_val)
			{
				$user_ar[] = $user_val['user_id'];
			}
			
			///$userstring = "'" . implode("','", $user_ar) . "'";
			//$wherein.= "->whereIn(user_id,".$userstring.")";
			$query = LandEstateDetail::whereIn('landestate_id',$user_ar);
			
			//$results = Property::with('builder_detail','property_gallery')->$where ;
			//$prop = $results->toArray();
		}
		else {
			 $header_state = "";
				 $header_state = Session::get('header_state');
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
				 $users = UserLocation::where('user_type','LandEstate')->whereIn('state_id', function($query){
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
			
				$query = LandEstateDetail::whereIn('landestate_id',$user_ar);
			
			} 
		
		
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
			$query->orderBy('id','desc');
			
		 //echo $query->getQuery()->toSql();
	//	$query->limit(10);
		$results = $query->get();
		$prop = $results->toArray();
		$html = $this->get_land_html($prop,$page,$lastpage,$numrows,$currentpage,$rows_per_page);
		echo $html ;
		/* echo '<pre>';
		print_r($prop); */

		}
	}
	
	
	public function ajax_filter_count_lands()
	{
		if(!empty($_REQUEST['land_estate_location'])) {
		//$query = LandEstateDetail;
		if(!empty($_REQUEST['land_estate_location']) && $_REQUEST['land_estate_location'] != "Land Location")
		{
			$loc_name = $_REQUEST['land_estate_location'];
			$states = State::where('id', $loc_name)->get(array('id'));
			$users = UserLocation::wherein('state_id', $states)->groupBy('user_id')->get(array('user_id'));
			$users_arr = $users->toArray();
			$user_ar = "";
			foreach($users_arr as $user_val)
			{
				$user_ar[] = $user_val['user_id'];
			}
			///$userstring = "'" . implode("','", $user_ar) . "'";
			//$wherein.= "->whereIn(user_id,".$userstring.")";
			$query = LandEstateDetail::whereIn('landestate_id',$user_ar);
		} else {
			 $header_state = "";
				 $header_state = Session::get('header_state');
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
				 $users = UserLocation::where('user_type','LandEstate')->whereIn('state_id', function($query){
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

				$query = LandEstateDetail::whereIn('landestate_id',$user_ar);
			
			}
		$prop_count = $query->count();
		echo $prop_count;
		}
	}
	
	public function ajax_filter_map_lands()
	{
	
		if(!empty($_REQUEST['land_estate_location'])) {
		//$query = LandEstateDetail;
		if(!empty($_REQUEST['land_estate_location']) && $_REQUEST['land_estate_location'] != "Land Location")
		{
			$loc_name = $_REQUEST['land_estate_location'];
			$states = State::where('id', $loc_name)->get(array('id'));
			$users = UserLocation::wherein('state_id', $states)->groupBy('user_id')->get(array('user_id'));
			$users_arr = $users->toArray();
			$user_ar = "";
			foreach($users_arr as $user_val)
			{
				$user_ar[] = $user_val['user_id'];
			}
			///$userstring = "'" . implode("','", $user_ar) . "'";
			//$wherein.= "->whereIn(user_id,".$userstring.")";
			$query = LandEstateDetail::whereIn('landestate_id',$user_ar);
		} else {
			 $header_state = "";
				 $header_state = Session::get('header_state');
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
				 $users = UserLocation::where('user_type','LandEstate')->whereIn('state_id', function($query){
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

				$query = LandEstateDetail::whereIn('landestate_id',$user_ar);
			
			}
	
		/* if(!empty($_REQUEST['land_estate_location'])) {
		//$query = LandEstateDetail::;
		if(!empty($_REQUEST['land_estate_location']) && $_REQUEST['land_estate_location'] != "Land Location")
		{
			$loc_name = $_REQUEST['land_estate_location'];
			$states = State::where('id', $loc_name)->get(array('id'));
			$users = UserLocation::wherein('state_id', $states)->groupBy('user_id')->get(array('user_id'));
			$users_arr = $users->toArray();
			$user_ar = "";
			foreach($users_arr as $user_val)
			{
				$user_ar[] = $user_val['user_id'];
			}
			
			///$userstring = "'" . implode("','", $user_ar) . "'";
			//$wherein.= "->whereIn(user_id,".$userstring.")";
			$query = LandEstateDetail::whereIn('landestate_id',$user_ar);
			
			//$results = Property::with('builder_detail','property_gallery')->$where ;
			//$prop = $results->toArray();
		}
		else {
			 $header_state = "";
				 $header_state = Session::get('header_state');
				 $headr_state  =   !empty($header_state) ? $header_state : 'VIC' ;
				 $users = UserLocation::where('user_type','LandEstate')->whereIn('state_id', function($query){
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
			
				$query = LandEstateDetail::whereIn('landestate_id',$user_ar);
			
			}  */

		$results = $query->get();
		$prop = $results->toArray();
		
		
		if(!empty($prop)) {
		$landids="";
		foreach($prop as $prop_val)
		{
			$landids[] = $prop_val['landestate_id'];
		}
		} else {
		$landids="";	
		}
		/* echo '<pre>';
		print_r($landids); */
		
		//echo "'".implode("','",$landids)."'";
		
		$prop_display_home = DisplayLand::with('open_hours')->whereIn('land_id',$landids);
		$total_display_home = $prop_display_home->count();
		
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
		/* $prop_display_home->limit($rows_per_page);
		$prop_display_home->offset($start);	 */
		$prop_display_home->orderBy('id','desc');
		//echo $prop_display_home->getQuery->toSql();
		$display_home_arrs = $prop_display_home->get();
		$display_home_arr = $display_home_arrs->toArray();
		$i=0;
		
		foreach($display_home_arr as $display_value)
		{
			$land_eastates = LandEstateDetail::where('landestate_id',$display_value['land_id'])->first();
			$land_logo_arr = $land_eastates->toArray();
			$image = !empty($land_logo_arr['logo'])?$land_logo_arr['logo']:"";
				$display_value = array_merge( $display_value, array( "image" => $image,'landestate_id'=>$land_logo_arr['id'] ) );
			$display_arr[$i] = $display_value;
			$i++;	
		}
		if(!empty($display_arr)) {
		$display_arr = array_merge($display_arr,array('total_display_lands'=>$total_display_home));
		} else {
		$display_arr = array(array(),array('total_display_lands'=>'0'));
		}
		echo json_encode($display_arr);
		}
	}
	
	
	
	public function view_land($land_id)
	{
		$land_estate = LandEstateDetail::with('display_lands','land_images')->where('id',$land_id)->get();
		$data['landestates_arr'] = $land_estate->toArray();
		$data['land_id'] = $land_id;
		$data['title'] = 'View Land';
		return view('view-land',$data);		
		
	}
	
	public function display_lands()
	{
	
		 $header_state = Session::get('header_state');
		 $headr_state  =   !empty($header_state)?$header_state:'VIC' ;
		 $states_obj = State::Getstates()->get(array('state_name'));
		 $st_obj =	State::whereIn('state_name',$states_obj)->get(array('id'));
		
		//$states = State::where('state_name', $headr_state)->get(array('id'));
		$users = UserLocation::wherein('state_id', $st_obj)->groupBy('user_id')->get(array('user_id'));
		$users_arr = $users->toArray();
		$user_ar = "";
		foreach($users_arr as $user_val)
		{
			$user_ar[] = $user_val['user_id'];
		} 
		///$userstring = "'" . implode("','", $user_ar) . "'";
		//$wherein.= "->whereIn(user_id,".$userstring.")";
		 $query = LandEstateDetail::whereIn('landestate_id',$user_ar);
	/* 	$page	=	"" ;
		$lastpage	=	"" ;
		$numrows  = "" ;
		$total_land = $query->count();
			if(isset($_REQUEST['page']))
			{
				$page = $_REQUEST['page'];
			}
			else
			{
				$page	=	1 ;
			}
			
			$numrows	=	$total_land ;
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
			$query->limit($rows_per_page)->offset($start)->orderBy('id','desc');  */
			//$query->limit($rows_per_page);
			//$query->offset($start);
			//echo  $query->getQuery()->toSql();
			 $results = $query->get();

		$data['landestates_arr'] = $results->toArray();

		//$data['total_land'] = $total_land;
	/*  echo '<pre>';
		print_r($data['landestates_arr']); */
	
	
		//$land_estate = LandEstateDetail::all();
		//$prop_arra = $land_estate->toArray();
		$prop_arra = $data['landestates_arr'];
		if(!empty($prop_arra)) {
		$landids="";
		foreach($prop_arra as $prop_val)
		{
			$landids[] = $prop_val['landestate_id'];
		}
		} else {
		$landids="";	
		}  
	/* 	 echo '<pre>';
		print_r($landids);
		die; */
		 $prop_display_home = DisplayLand::with('open_hours')->whereIn('land_id',$landids)->get();
		 $total_display_home = $prop_display_home->count();
		//$total_display_home = $prop_display_home->offset($start);
		//$prop_display_home = $prop_display_home->limit($rows_per_page);
		//$display_home_arrs = 
		$display_home_arr = $prop_display_home->toArray(); 
		//$display_village_title = $display_home_arr[0]['display_village_title'];
		//$display_location = $display_home_arr[0]['display_location'];
		//die;
		
/* 		echo '<pre>';
		print_r($display_home_arr);
		die;
		 */
		//$data['home_longlat'] = $display_home_longlats ;
		
		 $i=0;
		 $display_arr = "";
		foreach($display_home_arr as $display_value)
		{
			$landestate_id = $display_value['land_id'];
			$land_eastates = LandEstateDetail::where('landestate_id',$landestate_id);
			$display_land_count = $land_eastates->count();
			if($display_land_count > 0){
			$land_obj = $land_eastates->first();
			$land_logo_arr = $land_obj->toArray();
			$image = !empty($land_logo_arr['logo'])?$land_logo_arr['logo']:"";
				$display_value = array_merge( $display_value, array( "image" => $image,'landestate_id'=>$land_logo_arr['id'] ) );
			$display_arr[$i] = $display_value;
			}
			$i++;	
		} 
		
		$data['page'] = '0';
	   $data['lastpage'] = '0';
	   $data['numrows'] = '0';
	   $data['currentpage'] = '0';
	   $data['rows_per_page'] = '0';
		
		$data['title'] = 'Land Estates - icomparebuilders';
		$data['display_home_arr'] = $display_arr;
		$data['landestates_arr'] = array();
		$data['total_display_home'] = $total_display_home;
		$data['total_land'] = count($display_arr);

		$data['build_location'] = State::where(['state_name' => $headr_state])->get();
		return view('display-lands', $data);
	}
	
	public function book_land_appointment_html()
	{
		if(!empty($_REQUEST['display_village'])) {
		$display_village = $_REQUEST['display_village'];
		$prop_display_home = DisplayLand::with('open_hours')->where('id',$display_village)->get();
		$display_home_arr = $prop_display_home->toArray();
		/* echo '<pre>';
		print_r($display_home_arr); */
		
		$prop_id  = $display_home_arr[0]['land_id'];
		$village_title  = $display_home_arr[0]['display_village_title'];
		$display_location  = $display_home_arr[0]['display_location'];
		$display_home_id  = $display_home_arr[0]['id'];
		$prop = LandEstateDetail::with('land_images')->where('landestate_id',$prop_id)->get();
		//$prop = LandEstate::with('landestate_detail')->where('id',$prop_id)->get();
		$prop_arr = $prop->toArray();
		$title  = $prop_arr[0]['company_name'];
		$land_id  = $prop_arr[0]['id'];
		//$landestate  = $prop_arr[0]['landestate_detail']['company_name'];
		if(!empty($prop_arr[0]['land_images'])) {
		$image  = url().'/uploads/land_images/'.$prop_arr[0]['land_images']['0']['image'];
		} else {
		$image  = url().'/assets/img/no-image.jpg';
		}
		$related_home_arr = LandEstate::get_related_display_home($village_title,$display_location,$prop_id);
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
		<div class="book_appiont"><ul>
		<li><a href="javascript:void(0)" class="appoint-home book_appiont_active">Select Homes</a></li>
		<li><a href="javascript:void(0)" >Date/Time</a></li>
		<li><a href="javascript:void(0)" >Your Details</a></li>
		</ul></div>
		<div class="appoint_body">
		<div class="cp-box">
            
            <div class="cp-left">
				
			<input type="checkbox" checked="checked" name="display_land_check" value="'.$display_home_id.'" id="display_land_'.$display_home_id.'">
						<label for="display_land_'.$display_home_id.'">
			</label></div>
            <div class="cp-right">
                <div class="cp-r-top">
				                   <a href="'.url().'/land/view/'.$land_id.'">
								   <img alt="" src="'.$image.'">
								   </a>
				                      <a href="'.url().'/land/view/'.$land_id.'"><h3>'.$title.'</h3></a>
                </div>
            </div>
            <div class="clr"></div>
        </div>
		
		<div class="related-villages">';
		if(!empty($related_home_arr)) { 
		$html.='<p>Also at this village</p>';
		foreach($related_home_arr as $related_val) {
		if(!empty($related_val['land_images'])) {
			$image  = url().'/uploads/land_images/'.$related_val['land_images']['image'];
		} else {
			$image  = url().'/assets/img/no-image.jpg';
		}
		$html.= '<div class="cp-box">
            
            <div class="cp-left">
				
			<input type="checkbox"  name="display_land_check" value="'.$related_val['id'].'" id="display_land_'.$related_val['id'].'">
						<label for="display_land_'.$related_val['id'].'">
			</label></div>
            <div class="cp-right">
                <div class="cp-r-top">
				                   <a href="'.url().'/land/view/'.$related_val['id'].'"><img alt="" src="'.$image.'"></a>
				                      <a href="'.url().'/land/view/'.$related_val['id'].'">'.$related_val['landestate_detail']['company_name'].'<h3></h3></a>
                </div>
            </div>
            <div class="clr"></div>
        </div>';
		} }
	
		$html.= '</div>
		
		</div>
		<input type="hidden" name="display_home_ids1" id="display_home_ids1" value="'.$display_home_id.'" />
		<div class="appoint_button"><input type="button" class="button1 appoint_land_next" value="Next"></div>
		</div>';
	
		
		$html.='
	
		<div class="appoint-date-div" style="display:none;">
		<input type="hidden" name="display_home_ids" id="display_home_ids" value="'.$display_home_id.'" />
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
		<div class="appoint_button"><input type="button" class="button1 appoint_landdate_next" value="Next"/></div>
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
			<input type="text" name="firstname" id="firstname1" value="'.$firstname.'" placeholder="First name" />
			<input type="text" name="lastname" id="lastname1" value="'.$lastname.'" placeholder="Last name"/>
			<input type="email" name="email" id="email1" value="'.$user_email.'" placeholder="Email" />
			<input type="text" name="phn_no" id="phn_no1" value="'.$phone.'" placeholder="Phone (include area code if not mobile)"/>
			<p class="cp-left book_agree"><input type="checkbox" name="" id="book_appoint_terms1" value="1" checked="checked"> <label for="book_appoint_terms">
			</label>By using this form, I agree to the icomparebuilders <a href="'.url().'/terms-and-conditions">terms & conditions</a>, <a href="'.url().'/privacy-policy">privacy policy</a></p>
			
		</div>
		<div class="appoint_button"><input type="button" class="button1 appoint_landdetail_next" value="Next"/></div>
		
		
		</div>
		
		
		<div class="complete" style="display:none;">
		
		<div class="complete-div">
			<h3>Booking Complete</h3>
			<p>The LandEstates will be in touch with you soon.</p>
		</div>

		</div>
		
		
		
		</div>';
		
		echo $html;
		
		
		}
	}
	
	public function get_land_time_dropdown()
	{
		
		 $selected_day  = $_REQUEST['selected_day'].'s';
		 $display_home_ids_arr  = explode(',',$_REQUEST['display_home_id']);
		 $display_home_id = $display_home_ids_arr[0];
		if($selected_day == 'Saturdays' || $selected_day == 'Sundays') {
		$open_hour  = DisplayLandOpenHour::where(array('display_land_id'=>$display_home_id,'day'=>$selected_day));
		} else {
		$selected_day = 'Weekdays';
			$open_hour  = DisplayLandOpenHour::where(array('display_land_id'=>$display_home_id,'day'=>$selected_day));
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
	
	public function send_land_appointment_detail()
	{
		$home_ids = explode(',',$_REQUEST['homeid']);
		$home_id = $home_ids[0];
		$display_home = DisplayLand::where('id',$home_id)->get();
		$display_home_arr =	$display_home->toArray();
		$home_arr = $display_home_arr[0];
		$display_home_prop_arr = array();
		$display_home_prop_arr[0] = $home_arr['land_id'];
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
		$propertobj = LandEstateDetail::with('land_images')->whereIn('landestate_id',$prop_ids)->get();
		//$propertobj = LandEstate::with('landestate_detail')->whereIn('id',$prop_ids)->get();
		$prop_arr =	$propertobj->toArray();
		/* echo '<pre>';
		print_r($prop_arr); */
		foreach($prop_arr as $prop_val) {
		$appoint_detail =  array();
		$appoint_detail['detail'] = $_REQUEST;
			//$data1['email'] = 'palka.k@macrew.net';
			$landestate_id  = $prop_val['landestate_id'];
			$user_obj = User::where('id',$landestate_id)->get();
		$user_arr = $user_obj->toArray();
		$email = $user_arr[0]['email'];
		$data1 = array();
		$data1['email'] = $email;
			//$data1['email'] = 'palka.k@macrew.net';
			$data1['landestate'] = $prop_val['company_name'];
			$data1['from'] = $user_email;
			$sendmail1 = \Mail::send('emails.landappointmentdetail',
		 array('land_arr'=>$prop_val,'appoint_detail'=>$appoint_detail,'display_homes'=>$home_arr,'landestate'=>$data1['landestate']), function($message) use($data1)
			{
				//$email = $data['email'];
				$email = $data1['email'];
				//$email = 'palka.k@macrew.net';
				$from = $data1['from'];
				$message->from($from);
				$message->to($email)->subject('icompareBuilders - Display Lands Appointment Detail');
			}); 
			}
		echo 'success';
		
		
	}
	
	public function enquire_land_mail($land_id)
	{
		$input = Input::all();
		//dd($input);
		$rules = array(
			'name'    => 'required',
			'email_id' => 'required|email',
			'phn' => 'required',
			'lookingTo' => 'required',
			'message' => 'required',
			'agree' => 'required',
		);
		
		$request_arr['name']  = $input['name'];
		$request_arr['email_id']  = $input['email_id'];
		$request_arr['phn']  = $input['phn'];
		$request_arr['lookingTo']  = $input['lookingTo'];
		$request_arr['message']  = $input['message'];

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
				return Redirect::to('land/view/'.$land_id.'')
				->withErrors($validator) // send back all errors to the login form
				->withInput(); // send back the input (not the password) so that we can repopulate the form
		}
		else{
		$propertobj = LandEstateDetail::with('land_images')->where('id',$land_id)->get();
	 	//$propertobj = LandEstate::with('landestate_detail')->where('id',$land_id)->get();
		$land_arr =	$propertobj->toArray();
		foreach($land_arr as $prop_val) {
		$land_estate_id   = $prop_val['landestate_id'];
		$user_obj = User::where('id',$land_estate_id)->get();
		$user_arr = $user_obj->toArray();
		$email = $user_arr[0]['email'];
		$data1 = array();
		$data1['email'] = $email;
			//$data1['email'] = 'palka.k@macrew.net';
			$data1['land_user'] = $prop_val['company_name'];
			$data1['from'] = $input['email_id'] ;
			$sendmail1 = \Mail::send('emails.enquire-land',
		 array('land_arr'=>$prop_val,'request_arr'=>$request_arr,'land_user'=>$data1['land_user']), function($message) use($data1)
			{
				//$email = $data['email'];
				$email = $data1['email'];
				//$email = 'palka.k@macrew.net';
				$from = $data1['from'];
				$message->from($from);
				$message->to($email)->subject('icompareBuilders - User Enquiry Regarding Land Estate');
			}); 
				echo 'success';
			}
			\Session::flash('success', 'Mail has been sent to Land estates');
			return redirect()->back();
		}
	}
	
	public function load_master_plan()
	{
		$property_ids = $_REQUEST['property_ids'];
		$query = LandEstateDetail::where('id',$property_ids);
		$floorimg = $query->get();
		$floor_arr = $floorimg->toArray();
		if(!empty($floor_arr[0]['master_plan']))
		{
			
			$img = url().'/uploads/land_master_plan/'.$floor_arr[0]['master_plan'];
		} else {
			$img = "";
		}

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
          <h4 class="modal-title">Master Plan</h4>
        </div>
		<div class="en-main">
        <div class="builder-form rate-form floor_popup">';
		
		if(!empty($img)) {
	$html.='	
		<img src="'.$img.'" />';
		} else {
			
			$html.= '<h2>No Master Plan </h2>';
			
		}
	$html.=	
		'</div>
		</div>
		
		</div>
		</div>
		
		'; 
		echo $html;
		
	}
	
}
