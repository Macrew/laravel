<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\State;
class UserLocation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	 public $timestamps = false;
    protected $table = 'users_locations';

    //
	
	
	public static function get_build_location($user_id)
	{
		$locations = "";
		$userloc = UserLocation::where('user_id',$user_id)->get();
		$loc_arr = $userloc->toArray();
		if(!empty($loc_arr)) {
			foreach($loc_arr as $loc_val)
			{
				$loc_arrs[] = $loc_val['state_id'];
			}
			$userlocs = "";
		$userlocs = State::whereIn('id',$loc_arrs)->get();
		if(!empty($userlocs)) {
			foreach($userlocs as $loc)
			{
				$locations[] = $loc['loc_name'];
			}
		}
		return $locations;
		} else {
		
			return $locations;
		}
		
		
	}
}
