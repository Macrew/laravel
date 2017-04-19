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

class DisplayLand extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	 public $timestamps = false;
    protected $table = 'display_land';

    //
	public function open_hours()
    {
        return $this->hasMany('App\Models\DisplayLandOpenHour','display_land_id' ,'id');
    }

	
	

}
