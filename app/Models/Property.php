<?php

namespace App;
use App\Models\PropertyDisplayHome;
use Illuminate\Database\Eloquent\Model;
use App\UserDetail;
use App\UserLocation;
use Request;
use Input;
use Session;
use DB;
use Auth;

class Property extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	// public $timestamps = false;
    protected $table = 'property';

    //
	
	public function builder_detail()
    {
        return $this->hasOne('App\BuilderDetail','builder_id' ,'user_id');
    }
	
	public function property_gallery()
    {
        return $this->hasMany('App\PropertyGallery','property_id' ,'id')->orderBy('gallery_order','asc');
    }
	
	public function property_floor_plans()
    {
        return $this->hasMany('App\PropertyFloorImage','property_id' ,'id');
    }
	
	public function property_inclusions()
    {
        return $this->hasMany('App\PropertyInclusion','property_id' ,'id');
    }
	
	public function property_display_homes()
    {
        return $this->hasMany('App\Models\PropertyDisplayHome','property_id' ,'id');
    }

	public static function addhouseland($input){
		$user = Auth::user();
		$user_id = $user->id; 
		$property = new Property;
		
		if(!empty(Input::file('brochure'))) {
			if (Input::file('brochure')->isValid()) {
				$destinationPath = 'uploads/brochure'; // upload path
				$extension = Input::file('brochure')->getClientOriginalExtension(); // getting image extension
				$fileName = rand(11111,99999).'-simp'.'.'.$extension; // renameing image
				Input::file('brochure')->move($destinationPath, $fileName); // uploading file to given path
				$property->brochure = $fileName;
			}
		}


		if(!empty(Input::file('promotional_brochure'))) {
			if (Input::file('promotional_brochure')->isValid()) {
				$destinationPath = 'uploads/brochure'; // upload path
				$extension = Input::file('promotional_brochure')->getClientOriginalExtension(); // getting image extension
				$fileName = rand(11111,99999).'-prom'.'.'.$extension; // renameing image
				Input::file('promotional_brochure')->move($destinationPath, $fileName); // uploading file to given path
				$property->promotional_brochure = $fileName;
			}
		}
		
		$property->property_title 	= $_POST['property_title'];
		$property->description 		= $_POST['description'];
		$property->bedrooms 		= $_POST['bedrooms'];
		$property->cars				= $_POST['cars'];
		$property->housesize 		= $_POST['housesize'];
		$property->bathrooms 		= $_POST['bathrooms'];
		$property->stories 			= $_POST['stories'];
		$property->min_block_width 	= $_POST['min_block_width'];
		$property->min_block_length = $_POST['min_block_length'];
		$property->living 			= $_POST['living'];
		$property->alfresco 		= $_POST['alfresco'];
		$property->dual_occ 		= $_POST['dual_occ'];
		$property->user_id 			= $user_id;
		$property->price 			= $_POST['price'];
		$property->land_size 		= $_POST['land_size'];
		$property->house_land_address 			= $_POST['house_land_address'];
		$property->property_type 			= '2';
		if($property->save()){
			$property_id	 =	$property->id;
			$data['msg'] = $property_id;
			return $data;
		}else{
			$data['msg'] = 'Failure';
			return $data;
		}
	}
	
		public static function addproperty($input){
		$user = Auth::user();
		$user_id = $user->id; 
		$property = new Property;
		
		if(!empty(Input::file('brochure'))) {
			if (Input::file('brochure')->isValid()) {
				$destinationPath = 'uploads/brochure'; // upload path
				$extension = Input::file('brochure')->getClientOriginalExtension(); // getting image extension
				$fileName = rand(11111,99999).'-simp'.'.'.$extension; // renameing image
				Input::file('brochure')->move($destinationPath, $fileName); // uploading file to given path
				$property->brochure = $fileName;
			}
		}


		if(!empty(Input::file('promotional_brochure'))) {
			if (Input::file('promotional_brochure')->isValid()) {
				$destinationPath = 'uploads/brochure'; // upload path
				$extension = Input::file('promotional_brochure')->getClientOriginalExtension(); // getting image extension
				$fileName = rand(11111,99999).'-prom'.'.'.$extension; // renameing image
				Input::file('promotional_brochure')->move($destinationPath, $fileName); // uploading file to given path
				$property->promotional_brochure = $fileName;
			}
		}
		
		$property->property_title 	= $_POST['property_title'];
		$property->description 		= $_POST['description'];
		$property->bedrooms 		= $_POST['bedrooms'];
		$property->cars				= $_POST['cars'];
		$property->housesize 		= $_POST['housesize'];
		$property->bathrooms 		= $_POST['bathrooms'];
		$property->stories 			= $_POST['stories'];
		$property->min_block_width 	= $_POST['min_block_width'];
		$property->min_block_length = $_POST['min_block_length'];
		$property->living 			= $_POST['living'];
		$property->alfresco 		= $_POST['alfresco'];
		$property->dual_occ 		= $_POST['dual_occ'];
		$property->user_id 			= $user_id;
		$property->price 			= $_POST['price'];
		if($property->save()){
			$property_id	 =	$property->id;
			$data['msg'] = $property_id;
			return $data;
		}else{
			$data['msg'] = 'Failure';
			return $data;
		}
	}
	
	public static function getpropertybyid($id){
		$property = DB::table('property')->where('id', $id)->first();
		return $property;
	}
	
	public static function getproprtybyuser($user_id){
		$property = DB::table('property')->where(array('user_id'=>$user_id,'property_type'=>'1'))->orWhere('property_type','3');
		if(isset($_REQUEST['search'])){
			if($_REQUEST['search'] != ''){
				$property->where('property_title', 'LIKE', '%'. $_REQUEST['search'] .'%');
			}
		} else if(isset($_REQUEST['order'])){
			$sort = '';
			if(isset($_REQUEST['sort'])){ $sort = $_REQUEST['sort']; }
			$property->orderBy($_REQUEST['order'], $sort);
		}
		$prop = $property->paginate(10);
		return $prop;
	}
	
	public static function gethouselandbyuser($user_id){
		$property = DB::table('property')->where(array('user_id'=>$user_id,'property_type'=>'2'));
		if(isset($_REQUEST['search'])){
			if($_REQUEST['search'] != ''){
				$property->where('property_title', 'LIKE', '%'. $_REQUEST['search'] .'%');
			}
		} else if(isset($_REQUEST['order'])){
			$sort = '';
			if(isset($_REQUEST['sort'])){ $sort = $_REQUEST['sort']; }
			$property->orderBy($_REQUEST['order'], $sort);
		}
		$prop = $property->paginate(10);
		return $prop;
	}
	
	public static function get_related_display_home($title,$location,$prop)
	{
		$display_home_query = PropertyDisplayHome::whereRaw("property_id != '".$prop."' and (display_village_title = '".$title."' or display_location = '".$location."')");
		$count = $display_home_query->count() ;
		//echo $display_home_query->getQuery()->toSql();
		if($count > 0)
		{
			$related_display_home = $display_home_query->get() ;
			$related_display_home_arr = $related_display_home->toArray() ;
			foreach($related_display_home_arr as $val)
			{
				$display_prop_ids[] = $val['property_id'];
			}
		$related_prop = Property::with('property_gallery','property_display_homes','builder_detail')->whereIn('id',$display_prop_ids)->get();
		$realted_prop_arr = $related_prop->toArray();
		return $realted_prop_arr;
		//$data['related_display_home_arr'] = $realted_prop_arr;
		}
	}

	public static function getenquirybyuser($user_id){
		$enquiry = DB::table('enquiry_details')->where('builder_id', $user_id);
		/*if(isset($_REQUEST['search'])){
			if($_REQUEST['search'] != ''){
				$property->where('property_title', 'LIKE', '%'. $_REQUEST['search'] .'%');
			}
		} else if(isset($_REQUEST['order'])){
			$sort = '';
			if(isset($_REQUEST['sort'])){ $sort = $_REQUEST['sort']; }
			$property->orderBy($_REQUEST['order'], $sort);
		}*/
		$prop = $enquiry->paginate(10);
		return $prop;
	}
}
