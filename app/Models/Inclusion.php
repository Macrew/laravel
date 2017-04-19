<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\SaveInclusion;

class Inclusion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	 public $timestamps = false;
    protected $table = 'inclusions';

    //
	
	public static  function get_child_inclusions1($inc_id)
	{
		$results = Inclusion::where(['parent_id' => $inc_id])->get();
		//$results = User::with('builders')->where($where_arr)->get();
		$inc_arr = $results->toArray();
		$inclusion_arr = "";
		if(!empty($inc_arr)) {
		foreach($inc_arr as $inc_val)
		{
			$sub_child_inc = Inclusion::where(['parent_id' => $inc_val['id']])->get();
		//$results = User::with('builders')->where($where_arr)->get();
		$sub_inc_arr = $sub_child_inc->toArray();
		if(!empty($sub_inc_arr)) {
		$inclusion_arr[] = $sub_inc_arr;
		}
		}
		}
		
	  /* echo '<pre>';
		print_r($inclusion_arr);   */
		
		$list = "";
		 static $test ;
		if(!empty($inclusion_arr)) {
		$i=0;
		 foreach($inclusion_arr as $inc)
		{
			/* echo '<pre>';
			 print_r($inc); */
			if($i==0)
			{			
				$test = $inc;
			}
			if(count($inclusion_arr) == 1)
			{
				return $test;
			}
			if($i > 0) {
			$list = array_merge($test,$inc);
			}
			$i++;
			
		}
		return $list;
		
		} else {

			
		
		}		
		
		
	}
	
	
	public static  function get_child_inclusions($inc_id)
	{
		$results = Inclusion::where(['parent_id' => $inc_id])->get();
		//$results = User::with('builders')->where($where_arr)->get();
		$inc_arr = $results->toArray();
		$inclusion_arr = "";
		if(!empty($inc_arr)) {
		foreach($inc_arr as $inc_val)
		{
			if(!empty($inc_val)) {
			$inclusion_arr[] = $inc_val;
			}
		}
	}
	return $inclusion_arr;
		
		
	}
	
	public static function check_inc_parent($inc_id)
	{
		$results = Inclusion::where(['id' => $inc_id])->get();
		$inc_arr = $results->toArray();
		if(!empty($inc_arr)) {
		foreach($inc_arr as $inc_val)
		{
			if($inc_val['parent_id'] == 0)
			{
				return  $inc_val['id'];
			} 
			return self::check_inc_parent($inc_val['parent_id']);
			/* echo '<pre>';
			print_r($res); */
		} 
		}
		
	}
	
	
	public static function get_filter_inclusion1($inc_id)
	{
		$results = Inclusion::where(['parent_id' => $inc_id])->get();
		//$results = User::with('builders')->where($where_arr)->get();
		$inc_arr = $results->toArray();
		$inclusion_arr = "";
		if(!empty($inc_arr)) {
		foreach($inc_arr as $inc_val)
		{
			$sub_child_inc = Inclusion::where(['filter_inclusion' => 'Yes','parent_id' => $inc_val['id']])->get();
		//$results = User::with('builders')->where($where_arr)->get();
		$sub_inc_arr = $sub_child_inc->toArray();
		if(!empty($sub_inc_arr)) {
		$inclusion_arr[] = $sub_inc_arr;
		}
		}
		}
		$list = "";
		 static $test ;
		if(!empty($inclusion_arr)) {
		$i=0;
		 foreach($inclusion_arr as $inc)
		{
			/* echo '<pre>';
			 print_r($inc); */
			if($i==0)
			{			
				$test = $inc;
			}
			if(count($inclusion_arr) == 1)
			{
				return $test;
			}
			if($i > 0) {
			$list = array_merge($test,$inc);
			}
			$i++;
			
		}
		return $list;
		
		} else {

			
		
		}		
		
		
	}
	
	public static function get_filter_inclusion($inc_id)
	{
		$subinclusionarr ="";
		$incobj = Inclusion::where(array('parent_id'=>$inc_id,'filter_inclusion'=>'Yes'))->get();
		$subinclusionarr = $incobj->toArray();
		if(!empty($subinclusionarr))
		{
			return $subinclusionarr;
		} else {
			return $subinclusionarr;
		}
		
		
		
		
	}
	
	
	public static function check_parent_inclusion($cat_id)
	{
		$check1 = DB::table('inclusions')
                    ->where('parent_id', $cat_id)
                    ->count();
		$check2 = DB::table('inclusions')
                    ->whereRaw('parent_id != 0 and  id ='.$cat_id)
                    ->count();
		if($check1 == 0 && $check2 > 0)
		return $status='true';
	}
	
	
	public static function inclusion_tree1($catid,$propids)
	{

		$inclusions_arr = DB::table('inclusions')
                    ->where('parent_id', $catid)
                    ->get();

	//$result = $conn->query($sql);
	static $inc_html;
	foreach($inclusions_arr as $cat_val){
	
$saveincids="";
	$i = 0;
	if ($i == 0) $inc_html.= '<tr data-id="'.$cat_val->id.'" data-parent="'.$catid.'">';
	if(!empty($cat_val->title)) {
	$inclusions_arr = DB::table('inclusions')
                    ->where('parent_id', $catid)
                    ->get();
		$st = self::check_parent_inclusion($cat_val->id);
		if($st != 'true') {
	 $inc_html.= '<td>' . $cat_val->title;
	 } else {
	 $user_ip =  request()->ip();
		$saveinc =  SaveInclusion::where(array('user_ip'=>$user_ip))->get(array('inclusion_id'));
		$saveincarr = $saveinc->toArray();
		foreach($saveincarr as $inc_val)
		{
			$saveincids[] = $inc_val['inclusion_id'];
		}
		if(!empty($saveincids)) {
		if(in_array($cat_val->id,$saveincids)) {
		$inc_html.='<td><div class="cp-left tree_cp"><input type="checkbox"  name="compare_inc" checked="checked" id="comp_check_'.$cat_val->id.'" class="compare_inc" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id.'="checked"><label for="comp_check_'.$cat_val->id.'">
			</label></div></td>';
		} else {
			$inc_html.='<td><div class="cp-left tree_cp"><input type="checkbox"  name="compare_inc" class="compare_inc" id="comp_check_'.$cat_val->id.'" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id .'="unchecked"><label for="comp_check_'.$cat_val->id.'">
			</label></div></td>';
		
		}
		} else {
			$inc_html.='<td><div class="cp-left tree_cp"><input type="checkbox"  name="compare_inc" class="compare_inc" id="comp_check_'.$cat_val->id.'" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id .'="unchecked"><label for="comp_check_'.$cat_val->id.'">
			</label></div></td>';
		
		}
	  $inc_html.= '<td>' . $cat_val->title .'</td>';
	  $inclusion_type = array('Not available'=>'1','Standard inclusion'=>'2','Available as upgrade'=>'3');
	foreach($propids as $prop_val) {
$arr =  DB::table('property_inclusion')
            ->where(array('property_id'=>$prop_val,'inclusion_id'=>$cat_val->id))
            ->get();
			if(!empty($arr)){
		$inc_type = 	$arr[0]->inclusion_type;
	if(in_array($inc_type,$inclusion_type)) {
	//$inc_key = key($inclusion_type);
	//$inc_key = array_search($inc_type, $inclusion_type); // $key =
	if($inc_type == '1')
	$inc_key = '<i class="fa fa-minus" data-toggle="tooltip" data-placement="top" title="Not available" ></i>';
	if($inc_type == '2')
	$inc_key = '<i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Standard inclusion" ></i>';
	if($inc_type == '3')
	$inc_key = '<img src="'.url().'/assets/img/dollar.png"  data-toggle="tooltip" data-placement="top" title="Available as upgrade" />';
	
	 $inc_html.='<td>'.$inc_key.'</td>';
	 }
	 } else {
	  $inc_html.='<td><i class="fa fa-minus" data-toggle="tooltip" data-placement="top" title="Not available"  ></i></td>';
	 }
		}
	 }
	 } else {
	 $cat_arr = DB::table('inclusions')
                    ->where('id', $cat_val->id)
                    ->get();
	 $st = self::check_parent_inclusion($cat_val->id);
		if($st != 'true'){
	 $inc_html.= '<td>' . $cat_val->title;
	 } else {
	 $user_ip =  request()->ip();
		$saveinc =  SaveInclusion::where(array('user_ip'=>$user_ip))->get(array('inclusion_id'));
		$saveincarr = $saveinc->toArray();
		foreach($saveincarr as $inc_val)
		{
			$saveincids[] = $inc_val['inclusion_id'];
		}
		if(!empty($saveincids)) {
		if(in_array($cat_val->id,$saveincids)) {
		$inc_html.='<td><div class="cp-left tree_cp"><input type="checkbox"  name="compare_inc" checked="checked" id="comp_check_'.$cat_val->id.'" class="compare_inc" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id.'="checked"><label for="comp_check_'.$cat_val->id.'">
			</label></div></td>';
		} else {
			$inc_html.='<td><div class="cp-left tree_cp"><input type="checkbox"  name="compare_inc" id="comp_check_'.$cat_val->id.'" class="compare_inc" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id.'="unchecked"><label for="comp_check_'.$cat_val->id.'">
			</label></div></td>';
		
		} } else {
			$inc_html.='<td><div class="cp-left tree_cp"><input type="checkbox"  name="compare_inc" class="compare_inc" id="comp_check_'.$cat_val->id.'" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id .'="unchecked"><label for="comp_check_'.$cat_val->id.'">
			</label></div></td>';
		
		}
	  $inc_html.= '<td>' . $cat_val->title .'</td>';
	  $inclusion_type = array('Not available'=>'1','Standard inclusion'=>'2','Available as upgrade'=>'3');
	foreach($propids as $prop_val) {
$arr =  DB::table('property_inclusion')
            ->where(array('property_id'=>$prop_val,'inclusion_id'=>$cat_val->id))
            ->get();
			if(!empty($arr)){
		$inc_type = 	$arr[0]->inclusion_type;
	if(in_array($inc_type,$inclusion_type)) {
	if($inc_type == '1')
	$inc_key = '<i class="fa fa-minus" data-toggle="tooltip" data-placement="top" title="Not available" ></i>';
	if($inc_type == '2')
	$inc_key = '<i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Standard inclusion"></i>';
	if($inc_type == '3')
	$inc_key = '<img src="'.url().'/assets/img/dollar.png" data-toggle="tooltip" data-placement="top" title="Available as upgrade" />';
	
	 $inc_html.='<td>'.$inc_key.'</td>';
	 }
	 } else {
	 $inc_html.='<td><i class="fa fa-minus" data-toggle="tooltip" data-placement="top" title="Not available"></i></td>';
	 }
		}
	 }
	 }
	 self::inclusion_tree($cat_val->id,$propids);
	 $inc_html.= '</td>';
	$i++;
	 if ($i > 0) $inc_html.= '</tr>';
	}
	
	return $inc_html;
	
	}
	
	
	public static function inclusion_tree($catid,$propids)
	{
		$inclusions_arr = DB::table('inclusions')
                    ->where('parent_id', $catid)
                    ->get();

	//$result = $conn->query($sql);
	static $inc_html;
	foreach($inclusions_arr as $cat_val){
	
$saveincids="";
	$i = 0;
	if ($i == 0) $inc_html.= '<tr data-id="'.$cat_val->id.'" data-parent="'.$catid.'">';
	if(!empty($cat_val->title)) {
	$inclusions_arr = DB::table('inclusions')
                    ->where('parent_id', $catid)
                    ->get();
		$st = self::check_parent_inclusion($cat_val->id);
		if($st != 'true') {
	 $inc_html.= '<th>' . $cat_val->title.'</th>';
	 $inc_html.= '<th class="empty-td">&nbsp;</th>';
	 $inc_html.= '<th class="empty-td">&nbsp;</th>';
	 $inc_html.= '<th class="empty-td">&nbsp;</th>';
	 $inc_html.= '<th class="empty-td">&nbsp;</th>';

	 } else {
	 $user_ip =  request()->ip();
		$saveinc =  SaveInclusion::where(array('user_ip'=>$user_ip))->get(array('inclusion_id'));
		$saveincarr = $saveinc->toArray();
		foreach($saveincarr as $inc_val)
		{
			$saveincids[] = $inc_val['inclusion_id'];
		}
		if(!empty($saveincids)) {
		if(in_array($cat_val->id,$saveincids)) {
		$inc_html.='<td><div class="cp-left tree_cp"><input type="checkbox"  name="compare_inc" checked="checked" id="comp_check_'.$cat_val->id.'" class="compare_inc" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id.'="checked"><label for="comp_check_'.$cat_val->id.'">
			</label></div>'.$cat_val->title.'</td>';
		} else {
			$inc_html.='<td><div class="cp-left tree_cp"><input type="checkbox"  name="compare_inc" class="compare_inc" id="comp_check_'.$cat_val->id.'" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id .'="unchecked"><label for="comp_check_'.$cat_val->id.'">
			</label></div>'.$cat_val->title.'</td>';
		
		}
		} else {
			$inc_html.='<td><div class="cp-left tree_cp"><input type="checkbox"  name="compare_inc" class="compare_inc" id="comp_check_'.$cat_val->id.'" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id .'="unchecked"><label for="comp_check_'.$cat_val->id.'">
			</label></div>'.$cat_val->title.'</td>';
		
		}
	  $inclusion_type = array('Not available'=>'1','Standard inclusion'=>'2','Available as upgrade'=>'3');
	  if(count($propids) == '1') {
		$propids = array_merge($propids,array('1'=>'','2'=>'','3'=>''));
	  }
	  if(count($propids) == '2') {
		$propids = array_merge($propids,array('1'=>'','2'=>''));
	  }
	  if(count($propids) == '3') {
		$propids = array_merge($propids,array('1'=>''));
	  }
	foreach($propids as $prop_val) {
	if(!empty($prop_val)) {
$arr =  DB::table('property_inclusion')
            ->where(array('property_id'=>$prop_val,'inclusion_id'=>$cat_val->id))
            ->get();
			if(!empty($arr)){
		$inc_type = 	$arr[0]->inclusion_type;
	if(in_array($inc_type,$inclusion_type)) {
	//$inc_key = key($inclusion_type);
	//$inc_key = array_search($inc_type, $inclusion_type); // $key =
	if($inc_type == '1')
	$inc_key = '<i class="fa fa-minus" data-toggle="tooltip" data-placement="top" title="Not available" ></i>';
	if($inc_type == '2')
	$inc_key = '<i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Standard inclusion" ></i>';
	if($inc_type == '3')
	$inc_key = '<img src="'.url().'/assets/img/dollar.png"  data-toggle="tooltip" data-placement="top" title="Available as upgrade" />';
	
	 $inc_html.='<td>'.$inc_key.'</td>';
	 }
	 } else {
	  $inc_html.='<td><i class="fa fa-minus" data-toggle="tooltip" data-placement="top" title="Not available"  ></i></td>';
	 }
	 } else {
		$inc_html.= '<td class="empty-td">&nbsp;</td>';
	 }
		}
	 }
	 } else {
	 $cat_arr = DB::table('inclusions')
                    ->where('id', $cat_val->id)
                    ->get();
	 $st = self::check_parent_inclusion($cat_val->id);
		if($st != 'true'){
	 $inc_html.= '<td>' . $cat_val->title .'</td>';
	$inc_html.= '<td class="empty-td">&nbsp;</td>';
	 $inc_html.= '<td class="empty-td">&nbsp;</td>';
	 $inc_html.= '<td class="empty-td">&nbsp;</td>';
	 $inc_html.= '<td class="empty-td">&nbsp;</td>';
	 } else {
	 $user_ip =  request()->ip();
		$saveinc =  SaveInclusion::where(array('user_ip'=>$user_ip))->get(array('inclusion_id'));
		$saveincarr = $saveinc->toArray();
		foreach($saveincarr as $inc_val)
		{
			$saveincids[] = $inc_val['inclusion_id'];
		}
		if(!empty($saveincids)) {
		if(in_array($cat_val->id,$saveincids)) {
		$inc_html.='<th><div class="cp-left tree_cp"><input type="checkbox"  name="compare_inc" checked="checked" id="comp_check_'.$cat_val->id.'" class="compare_inc" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id.'="checked"><label for="comp_check_'.$cat_val->id.'">
			</label></div>'.$cat_val->title.'</th>';
		} else {
			$inc_html.='<td><div class="cp-left tree_cp"><input type="checkbox"  name="compare_inc" id="comp_check_'.$cat_val->id.'" class="compare_inc" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id.'="unchecked"><label for="comp_check_'.$cat_val->id.'">
			</label></div></td>';
		
		} } else {
			$inc_html.='<td><div class="cp-left tree_cp"><input type="checkbox"  name="compare_inc" class="compare_inc" id="comp_check_'.$cat_val->id.'" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id .'="unchecked"><label for="comp_check_'.$cat_val->id.'">
			</label></div>'.$cat_val->title.'</td>';
		
		}
	  $inclusion_type = array('Not available'=>'1','Standard inclusion'=>'2','Available as upgrade'=>'3');
	foreach($propids as $prop_val) {
$arr =  DB::table('property_inclusion')
            ->where(array('property_id'=>$prop_val,'inclusion_id'=>$cat_val->id))
            ->get();
			if(!empty($arr)){
		$inc_type = 	$arr[0]->inclusion_type;
	if(in_array($inc_type,$inclusion_type)) {
	if($inc_type == '1')
	$inc_key = '<i class="fa fa-minus" data-toggle="tooltip" data-placement="top" title="Not available" ></i>';
	if($inc_type == '2')
	$inc_key = '<i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Standard inclusion"></i>';
	if($inc_type == '3')
	$inc_key = '<img src="'.url().'/assets/img/dollar.png" data-toggle="tooltip" data-placement="top" title="Available as upgrade" />';
	
	 $inc_html.='<td>'.$inc_key.'</td>';
	 }
	 } else {
	 $inc_html.='<td><i class="fa fa-minus" data-toggle="tooltip" data-placement="top" title="Not available"></i></td>';
	 }
		}
	 }
	 }
	 self::inclusion_tree($cat_val->id,$propids);
	 $inc_html.= '</td>';
	$i++;
	 if ($i > 0) $inc_html.= '</tr>';
	}
	
	return $inc_html;
	
	}
	
	
	
	public static function subcategories($catid)
	{
		$inclusions_arr = DB::table('inclusions')
                    ->where('parent_id', $catid)
                    ->get();

	//$result = $conn->query($sql);
	static $inc_html = null;
	$inc_html.= '<ul class="mtree skinny">';
	foreach($inclusions_arr as $cat_val){


	$i = 0;
	//if ($i == 0) $inc_html.= '<ul>';
	if(!empty($cat_val->title)) {
$inclusions_arr = DB::table('inclusions')
                    ->where('parent_id', $catid)
                    ->get();
		$st = self::check_parent_inclusion($cat_val->id);
		if($st != 'true') {
	 $inc_html.= '<li><a href="#">' . $cat_val->title .'</a>';
	 } else {
	 $user_ip =  request()->ip();
		$saveinc =  SaveInclusion::where(array('user_ip'=>$user_ip))->get(array('inclusion_id'));
		$saveincarr = $saveinc->toArray();
		foreach($saveincarr as $inc_val)
		{
			$saveincids[] = $inc_val['inclusion_id'];
		}
		if(!empty($saveincids)) {
		if(in_array($cat_val->id,$saveincids)) {
		$inc_html.='<li><input type="checkbox"  name="compare_inc" checked="checked" id="comp_check_'.$cat_val->id.'" class="compare_inc" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id.'="checked">';
		} else {
			$inc_html.='<li><input type="checkbox"  name="compare_inc" class="compare_inc" id="comp_check_'.$cat_val->id.'" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id .'="unchecked">';
		
		}
		} else {
			$inc_html.='<li><input type="checkbox"  name="compare_inc" class="compare_inc" id="comp_check_'.$cat_val->id.'" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id .'="unchecked">';
		
		}
	  $inc_html.= '<a href="#">' . $cat_val->title .'</a>'; 

	 }

	 } else {
	 $cat_arr = DB::table('inclusions')
                    ->where('id', $cat_val->id)
                    ->get();
	 $st = self::check_parent_inclusion($cat_val->id);
		if($st != 'true'){
	 $inc_html.= '<li>' . $cat_val->title;
	 } else {
	 $user_ip =  request()->ip();
		$saveinc =  SaveInclusion::where(array('user_ip'=>$user_ip))->get(array('inclusion_id'));
		$saveincarr = $saveinc->toArray();
		foreach($saveincarr as $inc_val)
		{
			$saveincids[] = $inc_val['inclusion_id'];
		}
		if(!empty($saveincids)) {
		if(in_array($cat_val->id,$saveincids)) {
		$inc_html.='<li><input type="checkbox"  name="compare_inc" checked="checked" id="comp_check_'.$cat_val->id.'" class="compare_inc" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id.'="checked">';
		} else {
			$inc_html.='<li><input type="checkbox"  name="compare_inc" id="comp_check_'.$cat_val->id.'" class="compare_inc" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id.'="unchecked">';
		
		} } else {
			$inc_html.='<li><input type="checkbox"  name="compare_inc" class="compare_inc" id="comp_check_'.$cat_val->id.'" value="'.$cat_val->id.'" rel="'.$cat_val->id.'" data-text-'.$cat_val->id .'="unchecked">';
		
		}
	   $inc_html.= '<a href="#">' . $cat_val->title .'</a>'; 
	
	 }
	 }
		$inc_html = self::subcategories($cat_val->id);
	 $inc_html.= '</li>';
	$i++;
	 //if ($i > 0) $inc_html.= '</ul>';
	}
	$inc_html.= '</ul>';
	$returnValue = $inc_html;
    $inc_html = null;
	 return $returnValue;
   // return $returnValue;
	
	}
	
	
	public static function get_subcategories($cat_id)
	{
		$subinclusionarr ="";
		$incobj = Inclusion::where(array('parent_id'=>$cat_id))->get();
		$subinclusionarr = $incobj->toArray();
		if(!empty($subinclusionarr))
		{
			return $subinclusionarr;
		} else {
			return $subinclusionarr;
		}
	}
		
	public static function check_save_inclusion()
	{
		$saveincids = "";
		$user_ip =  request()->ip();
		$saveinc =  SaveInclusion::where(array('user_ip'=>$user_ip))->get(array('inclusion_id'));
		$saveincarr = $saveinc->toArray();
		foreach($saveincarr as $inc_val)
		{
			$saveincids[] = $inc_val['inclusion_id'];
		}
		if(!empty($saveincids))
		{
			return $saveincids;
		} else {
			return $saveincids;
		}
	}	
	
}
