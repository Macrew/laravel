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
use App\Property;

class PropertyDisplayHome extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	 public $timestamps = false;
    protected $table = 'property_display_homes';

    //
	public function open_hours()
    {
        return $this->hasMany('App\Models\PropertyDisplayHomeOpenHour','display_home_id' ,'id');
    }
	
	public static function get_property_title($id)
    {
        $prop_arr = Property::where(array('id'=>$id))->get(array('property_title'))->toArray();
		return $prop_arr;
    }
	

}
