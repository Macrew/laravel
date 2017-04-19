<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Models\DisplayLand;

class LandEstateDetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	 public $timestamps = false;
    protected $table = 'landestate_detail';

    //
	
	

	public function display_lands()
    {
        return $this->hasMany('App\Models\DisplayLand','land_id' ,'landestate_id');
    }
	
	public function land_images()
    {
        return $this->hasMany('App\LandGallery','landestate_id' ,'landestate_id');
    }
	
	public static function get_related_display_home($title,$location,$prop)
	{
		$display_home_query = DisplayLand::whereRaw("land_id != '".$prop."' and (display_village_title = '".$title."' or display_location = '".$location."')");
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
		$related_prop = LandEstate::with('landestate_detail')->whereIn('id',$display_prop_ids)->get();
		$realted_prop_arr = $related_prop->toArray();
		return $realted_prop_arr;
		//$data['related_display_home_arr'] = $realted_prop_arr;
		}
	}
	
	public static function get_related_display_home1($landestate_id)
	{
		$display_home_query = DisplayLand::where("land_id" , $landestate_id);
		$count = $display_home_query->count() ;
		//echo $display_home_query->getQuery()->toSql();
		if($count > 0)
		{
			$related_display_home = $display_home_query->get() ;
			$related_display_home_arr = $related_display_home->toArray() ;
			/* foreach($related_display_home_arr as $val)
			{
				$display_prop_ids[] = $val['land_id'];
			} */
			
		//$prop = DisplayLand::where('landestate_id',$display_prop_ids)->get();
		//$prop = LandEstate::with('landestate_detail')->where('id',$prop_id)->get();
		//$prop_arr = $prop->toArray();
		return $related_display_home_arr;
		//$data['related_display_home_arr'] = $realted_prop_arr;
		}
	}
	
}
