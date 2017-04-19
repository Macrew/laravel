<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Property;
use App\User;
use Auth;

class SaveProperty extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	// public $timestamps = false;
    protected $table = 'save_properties';

	public static function get_saved_property()
	{
		$user_ip =  request()->ip();
		$save_prop = SaveProperty::where(array('user_ip'=>$user_ip,'type'=>'Compare'))->get(array('property_id'));
		$save_prop_arr = $save_prop->toArray();
		$prop_arr = "";
		 if(!empty($save_prop_arr))
		{
			foreach($save_prop_arr as $save_prop_val)
			{
				$prop_arr[] = $save_prop_val['property_id'];
			}
		}
		if(!empty($prop_arr)) {
		$proptyobj = Property::with('builder_detail','property_gallery')->whereIn('id',$prop_arr)->get();
		$proptyobj->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
		$propty_arr = $proptyobj->toArray();
		return $propty_arr;
		} else {
		
		return $prop_arr;
		}
	}
	
	public static function get_house_saved_property()
	{
		$user_ip =  request()->ip();
		$save_prop = SaveProperty::where(array('user_ip'=>$user_ip,'type'=>'Compare'))->get(array('property_id'));
		$save_prop_arr = $save_prop->toArray();
		$prop_arr = "";
		 if(!empty($save_prop_arr))
		{
			foreach($save_prop_arr as $save_prop_val)
			{
				$prop_arr[] = $save_prop_val['property_id'];
			}
		}
		if(!empty($prop_arr)) {
		$proptyobj = Property::with('builder_detail','property_gallery')->whereIn('id',$prop_arr);
		$proptyobj->where('property_type','1');
		$proptyobj->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
		$prop_query = $proptyobj->get();
		$total_house = $proptyobj->count();
		$prop_home_designs = $prop_query->toArray();
		$propty_arr['total_home_designs'] = $total_house;
		$propty_arr['prop_home_designs'] = $prop_home_designs;
		return $propty_arr;
		} else {
		$prop_arr['total_home_designs'] = '0';
		$prop_arr['prop_home_designs'] = '';
		return $prop_arr;
		}
	}
	
	public static function get_houseland_saved_property()
	{
		$user_ip =  request()->ip();
		$save_prop = SaveProperty::where(array('user_ip'=>$user_ip,'type'=>'Compare'))->get(array('property_id'));
		$save_prop_arr = $save_prop->toArray();
		$prop_arr = "";
		 if(!empty($save_prop_arr))
		{
			foreach($save_prop_arr as $save_prop_val)
			{
				$prop_arr[] = $save_prop_val['property_id'];
			}
		}
		if(!empty($prop_arr)) {
		$proptyobj = Property::with('builder_detail','property_gallery')->whereIn('id',$prop_arr);
		$proptyobj = $proptyobj->where('property_type','2');
		$proptyobj->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
		$prop_house_land = $proptyobj->get();
		$total_house = $proptyobj->count();
		$prop_house_arr = $prop_house_land->toArray();
		$propty_arr['total_house_land'] = $total_house;
		$propty_arr['prop_house_arr'] = $prop_house_arr;
		return $propty_arr;
		} else {
		$prop_arr['total_house_land'] = '0';
		$prop_arr['prop_house_arr'] = '';
		return $prop_arr;
		}
	}
	
	public static function count_saved_property()
	{
		$user_ip =  request()->ip();
		$prop_arr = "";
		$saveprop_count = SaveProperty::where(array('user_ip'=>$user_ip,'type'=>'Compare'))->get();
		$save_prop_arr = $saveprop_count->toArray();
		 if(!empty($save_prop_arr))
		{
			foreach($save_prop_arr as $save_prop_val)
			{
				$prop_arr[] = $save_prop_val['property_id'];
			}
		}
		if(!empty($prop_arr)) {
		$proptyobj = Property::whereIn('id',$prop_arr);
		$proptyobj->whereHas('builder_detail', function($q){
					$q->where('trash' , 'no');	
				});
		$saveprop_count = $proptyobj->count();
		} else {
			$saveprop_count = "0";
		}
		return $saveprop_count;
	}
	
	public static function check_save_prop($prop_id)
	{
		$user_ip =  request()->ip();
		$saveprop = SaveProperty::where(array('user_ip'=>$user_ip,'property_id'=>$prop_id,'type'=>'Compare'))->count();
		return $saveprop;
	}
	public static function check_new_save_prop($prop_id)
	{
		$user_ip =  request()->ip();
		$user = Auth::user();
		$user_ip =  request()->ip();
		if($user){
			$userdata = User::getuserinfo($user->id);	
		$saveprop = SaveProperty::where(array('user_id'=>$user->id,'property_id'=>$prop_id,'type'=>'Save'))->count();
		} else {
		$saveprop = SaveProperty::where(array('user_ip'=>$user_ip,'property_id'=>$prop_id,'type'=>'Save'))->count();
		
		}
		return $saveprop;
	}
	
	public static function set_save_propids()
	{
		$prop_arr = self::get_house_saved_property();
		$propidstring = "";
		if(!empty($prop_arr['prop_home_designs'])) {
		$propert_arr = "";
		$i=1;
		foreach($prop_arr['prop_home_designs'] as $prop_val)
		{
			if($i > 4)
				break;
			$propert_arr[] = $prop_val['id'];
			$i++;
		}
		$propidstring = implode(',',$propert_arr);
		$url = url().'/compare?propertyids='.$propidstring;
		return $url;
		} else {
			return $propidstring;
		}
	}
	
	public static function set_save_house_propids()
	{
		$prop_arr = self::get_houseland_saved_property();
		$propidstring = "";
		if(!empty($prop_arr['prop_house_arr'])) {
		$propert_arr = "";
		$i=1;
		foreach($prop_arr['prop_house_arr'] as $prop_val)
		{
			if($i > 4)
				break;
			$propert_arr[] = $prop_val['id'];
			$i++;
		}
		$propidstring = implode(',',$propert_arr);
		$url = url().'/compare?propertyids='.$propidstring;
		return $url;
		} else {
			return $propidstring;
		}
	}
	
	
    //
}
