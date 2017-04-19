<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Request;
use Input;
use DB;

class AddManagement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	 public $timestamps = false;
    protected $table = 'add_management';

    //Function for saving adds
    public static function create_add(){
		/* $user = Auth::user();
		$user_id = $user->id; */
		$add = new AddManagement;
		$fileName='';
		if(!empty(Input::file('image'))) {
		  if (Input::file('image')->isValid()) {
			  $destinationPath = 'uploads/add_management'; // upload path
			  $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
			  $fileName = rand(11111,99999).'.'.$extension; // renameing image
			  Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
			  $add->image = $fileName;
			}
		}
		$status = 'Unpublish';
		$add_text = !empty($_POST['add_text'])?$_POST['add_text']:"";
		 $start_date = date("Y-m-d",strtotime($_POST['start_date']));
		 $end_date = date("Y-m-d",strtotime($_POST['end_date']));
		$add->headline		= $_POST['headline'];
		$add->add_text		= $add_text;
		$add->add_size 		= $_POST['add_size'];
		$add->start_date 	= $start_date;
		$add->end_date		= $end_date;
		/* $add->user_id 		= $user_id; */
		$add->status 		= $status;
		if($add->save())
		{
			return 'Success';
		}else{
			return 'Failure';
		}
	}
	
	public static function getaddbyuser($id){
		$add = DB::table('add_management')->whereRaw("user_id = '$id'");
		if(isset($_REQUEST['search'])){
			if($_REQUEST['search'] != ''){
				$search =  $_REQUEST['search'];
				$add->whereRaw("headline LIKE '%$search%' or start_date LIKE '%$search%' or end_date LIKE '%$search%'");
			}
		} else if(isset($_REQUEST['order'])){
			$sort = '';
			if(isset($_REQUEST['sort'])){ $sort = $_REQUEST['sort']; }
			$add->orderBy($_REQUEST['order'], $sort);
		}
		//echo $add->toSql();
		$adds = $add->paginate(10);
		return $adds;
	}
	
	public static function getaddbyid($id){
		$add = DB::table('add_management')->where('id', $id)->first();
		return $add;
	}
}
