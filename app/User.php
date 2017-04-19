<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\UserDetail;
use App\UserLocation;
use Request;
use Input;
use Session;
use Mail;
use DB;
use App\Instagram\InstagramClass;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
	
	public function builders()
    {
        return $this->hasOne('App\BuilderDetail','builder_id' ,'id');
    }
	
	 public function users()
    {
        return $this->hasOne('App\UserDetail','user_id' ,'id');
    }
	
	 public function landestates()
    {
        return $this->hasOne('App\LandEstateDetail','landestate_id' ,'id');
    }
	
	 public function brokers()
    {
        return $this->hasOne('App\BrokerDetail','broker_id' ,'id');
    }
    public function partners()
    {
        return $this->hasOne('App\CategoryDetail','partner_id' ,'id');
    }
    
    public static function registerUser($input){
		$user_type = 'User';
		$user = new User;
		$userdetail = new UserDetail;
		$userlocation = new UserLocation;
		$user->email = $input['email'];
		$user->password = bcrypt($input['password']);
		$user->status = 'Active';
		$user->user_type = $user_type;
		if($user->save())
		{
			$userdetail_id	 =	$user->id;			
			$userdetail->user_id = $userdetail_id;	
		/*	$fileName='';
			if(!empty(Input::file('userimage'))) {
			  if (Input::file('userimage')->isValid()) {
				  $destinationPath = 'uploads/user_profile_image'; // upload path
				  $extension = Input::file('userimage')->getClientOriginalExtension(); // getting image extension
				  $fileName = rand(11111,99999).'.'.$extension; // renameing image
				  Input::file('userimage')->move($destinationPath, $fileName); // uploading file to given path
				  $userdetail->userimage = $fileName;
				  // sending back with message
				 // Session::flash('success', 'Upload successfully'); 
				  //return Redirect::to('upload');
				}
			}
			if($fileName == ''){
				$fileName = '';
			}*/
			
			$userdetail->firstname = $input['firstname'];
			$userdetail->lastname = $input['lastname'];
			$userdetail->phone = $input['phone'];
			//$userdetail->address = $_POST['address'];
			$userdetail->save();
			
			$userlocation->state_id = $input['user_location'];
			$userlocation->user_type = $user_type;
			$userlocation->user_id = $user->id;			
			$userlocation->save();
			return 'Success';
		}else{
			return 'Failure';
		}
	}
	
	public static function register_facebook_user($input){
		$user_type = 'User';
		$user = new User;
		$userdetail = new UserDetail;
		$user->email = $input['email'];
		$user->status = 'Active';
		$user->user_type = $user_type;
		$user->login_type = $input['login_type'];
		if($user->save())
		{
			$userdetail_id	 =	$user->id;			
			$userdetail->user_id = $userdetail_id;	
		
			$userdetail->firstname = $input['firstname'];
			$userdetail->lastname = $input['lastname'];
			$userdetail->phone = $input['phone'];
			//$userdetail->address = $_POST['address'];
			$userdetail->save();
			return 'Success';
		}else{
			return 'Failure';
		}
	}
	
	public static function register_instagram_user($input){
		$user_type = 'User';
		$user = new User;
		$userdetail = new UserDetail;
		$user->username = $input['username'];
		$user->status = 'Active';
		$user->user_type = $user_type;
		$user->login_type = $input['login_type'];
		if($user->save())
		{
			$userdetail_id	 =	$user->id;			
			$userdetail->user_id = $userdetail_id;	
		
			$userdetail->firstname = $input['firstname'];
			//$userdetail->address = $_POST['address'];
			$userdetail->save();
			return 'Success';
		}else{
			return 'Failure';
		}
	}
	
	//Function for getting user extra information
	public static function getuserinfo($id){
		$user = DB::table('user_detail')->where('user_id', $id)->first();
		return $user;
	} 
	
	public static function getuserinfonew($id){
		$user = DB::table('users')->where('id', $id)->first();
		return $user;
	} 

	public static function get_instagram_url(){
		 $instagram = new InstagramClass(array(
		'apiKey'      => env('INSTAGRAM_KEY'),
		'apiSecret'   => env('INSTAGRAM_SECRET'),
		'apiCallback' => env('INSTAGRAM_REDIRECT_URI'),
	  ));
	  $loginUrl   = $instagram->getLoginUrl();
	  return $loginUrl;
	} 
	
	public static function getnewuserinfo($id,$user_type){
	if($user_type == 'User') {
		$user = DB::table('user_detail')->where('user_id', $id)->first();
	} 
	if($user_type == 'Builder') {
		$user = DB::table('builder_details')->where('builder_id', $id)->first();
	}
	if($user_type == 'LandEstate') {
	  $user = DB::table('landestate_detail')->where('landestate_id', $id)->first();
	}
		return $user;
	} 
	
	public static function get_builder_enquires($builder_id)
	{		
		$numenqs = DB::table('enquiry_details')->where(array('builder_id'=>$builder_id,'msg_status'=>'unread'))->count();
		return $numenqs;
	}
	
	public static function get_builder_saved_properties($builder_id)
	{
		$numsavedprop = 0;
		$numsavedprop = DB::table('property')->whereRaw('id IN(SELECT property_id FROM `save_properties` where type="Save" group by user_ip) AND  user_id="'.$builder_id.'"')->count();
		return $numsavedprop;
	}
	
	public static function get_property_view($user_id)
	{
		$numpropview = DB::table('property_view_report')->where('user_id',$user_id)->count();
		return $numpropview;
	}
	
	
	
}
