<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	 public $timestamps = false;
    protected $table = 'states';

    //
	
	public function scopeGetstates($query){
    return $query->where('trash','no')->orderBy('id','asc');
	}
	
	public static function get_mainstates()
	{
		$states = State::Getstates()->groupBy('state_name')->get();
		$states_arr = $states->toArray();
		$main_states = array();
			if(!empty($states_arr)) {
				foreach($states_arr as $state_value) {
				if($state_value == 'QLD') {
					$main_states['Queensland'] = $state_value;
				}
				if($state_value == 'VIC') {
				$main_states['Victoria'] = $state_value;
				}
				if($state_value == 'NSW') {
				$main_states['New South Wales'] = $state_value;
				}
				if($state_value == 'WA') {
				$main_states['Western Australia'] = $state_value;
				}
				if($state_value == 'TAS') {
				$main_states['Tasmania'] = $state_value;
				}
				if($state_value == 'NT') {
				$main_states['Northern Territory'] = $state_value;
				}
				if($state_value == 'ACT') {
				$main_states['Australian Capital Territory'] = $state_value;
				}
				if($state_value == 'SA') {
				$main_states['South Australia'] = $state_value;
				}
				
				
							
				} }
				return $main_states;
	}
	
}
