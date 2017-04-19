<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\UserDetail;
use App\UserLocation;
use Request;
use Input;
use Session;
use DB;
use Auth;

class LandEstate extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	// public $timestamps = false;
    protected $table = 'land_estates';

    //
	public function landestate_detail()
    {
        return $this->hasOne('App\LandEstateDetail','landestate_id' ,'user_id');
    }
	
	public function display_lands()
    {
        return $this->hasMany('App\Models\DisplayLand','land_id' ,'id');
    }
	
	public static function get_related_display_home($title,$location,$prop)
	{
		$display_home_query = DisplayLand::whereRaw('land_id != "'.$prop.'" and ( display_village_title = replace("'.$title.'", " ", "|") or display_location = "'.$location.'")');
		$count = $display_home_query->count() ;
		//echo $display_home_query->getQuery()->toSql();
		if($count > 0)
		{
			$related_display_home = $display_home_query->get() ;
			$related_display_home_arr = $related_display_home->toArray() ;
			foreach($related_display_home_arr as $val)
			{
				$display_prop_ids[] = $val['land_id'];
			}
		$related_prop = LandestateDetail::with('land_images')->whereIn('id',$display_prop_ids)->get();
		$realted_prop_arr = $related_prop->toArray();
		return $realted_prop_arr;
		//$data['related_display_home_arr'] = $realted_prop_arr;
		}
	}
	
}
