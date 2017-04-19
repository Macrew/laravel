@extends('layout.default')

@section('content')	

<section class="plist_main"><!--property section!-->
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<?php if(isset($message)){ ?>
			<div class="alert alert-danger">
				<ul>
					<li><?php  echo $message; ?></li>
				</ul>
			</div>
			<?php } ?>
			<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		<input type="hidden" name="compare_ids" value="<?php // echo $savepropids; ?>" id="compare_ids"/>
		<input type="hidden" name="save_compare_url" value="" id="save_compare_url"/>
		<input type="hidden" name="save_enquire_url" value="" id="save_enquire_url"/>
	<div class="list_left"><!--left section!-->
    
	<div class="filter_sec">
        	<h2>Refine your search</h2>
             <div class="select_box"><!--copyable text!-->
            	<i><img src="{{ URL::asset('assets/img/location.png') }}" /></i>
            	<select class="selectpicker" name="land_estate_location" id ="land_estate_location">
				<?php $main_states = array('Queensland'=>'QLD' ,'Victoria'=>'VIC','New South Wales'=>'NSW','Western Australia'=>'WA');
								 $header_state = Session::get('header_state');
								 $main_text = array_search($header_state, $main_states);

				?>
                  <option>Land Location</option>
				  <optgroup label="<?php echo $main_text ; ?>">
				  <?php  foreach($build_location as $build_val) {
						if(!empty($_REQUEST['search_region'])) { if($build_val['id'] == $_REQUEST['search_region']) {

				  ?>
				  <option value="<?php echo $build_val['id'] ;  ?>" selected="selected"><?php echo $build_val['loc_name'] ;  ?></option>
				  <?php } else {   ?>  <option value="<?php echo $build_val['id'] ;  ?>"><?php echo $build_val['loc_name'] ;  ?></option> <?php } } else {  ?> <option value="<?php echo $build_val['id'] ;  ?>"><?php echo $build_val['loc_name'] ;  ?></option> <?php } } ?>
				  </optgroup>
                  
                </select>
            </div><!--copyable text!-->
  
        
        </div>
	
	
	
           <?php if(!empty($ads_arr)) { ?>
        <div class="add_model"><!--add section!-->
		<?php  foreach($ads_arr as $ads_val) { ?>
        	<h3>Get your free</h3>
            <div class="add_photo"><!--<div class="add_text"><h4>$<span>20</span> Voucher</h4></div> <div class="voucher-offer__plus"><span>plus</span></div>--> <img src="<?php echo url(); ?>/uploads/add_management/<?php echo $ads_val['image']; ?>" /></div>
            <p>Our independent home building guide with expert tips to save you time and money</p>
			<?php }   ?>
            <!--<div class="book"><img src="{{ URL::asset('assets/img/book.png') }}" /></div>
            <div class="enq_btn">When you enquire through icompare today. </div>-->
        </div><!--add section!-->
        <?php } ?>
        
    </div><!--left section!-->
    <div class="list_mid"><!--middle section!-->
    	<div class="white_mid save_property_top"><!--white box!-->
        	<div class="t_listleft">
			
						<div class="cp-left save_sidebarcheck top_sidebarcheck">
				
			<input type="checkbox" name="landallcheck" value="all" id="landallcheck">
						<label for="landallcheck">
			</label>Select All</div>
			<span id="prop_count"><?php echo $total_land; ?></span> Lands
			</div>
            <div class="t_listright">
			
            	<input type="submit" class="button2 land_enquire" disabled value="Enquire"/>
                <div class="clr"></div>
            </div>
            <div class="clr"></div>
        </div><!--white box!-->
		
<div id="ajax_content">
				<div id="ajaxloader"></div>
			<?php  
		
	 /* 	 echo '<pre>';
		print_r($landestates_arr);   */
		if(!empty($landestates_arr)) {
		foreach($landestates_arr as $land_val) {
		if($land_val['land_image'] == ''){
			$img = URL::asset('assets/img/no-image.jpg');
		}else{
			$img = url().'/uploads/land_images/'.$land_val['land_image'];
		}
		?>

        <div class="grey_bg save_prop_check"><!--white box!-->
        	<div class="model_left">
            <div class="cp-left save_sidebarcheck">
				
			<input type="checkbox" class="landlistcheckbox" name="landlistcheck" value="<?php echo $land_val['id']; ?>" id="landlistcheck<?php echo $land_val['id']; ?>">
						<label for="landlistcheck<?php echo $land_val['id']; ?>">
			</label></div>
            	<div class="model_img">
				<?php  
					echo '<a href="'.url().'/land/display-land/'.$land_val['landestate_id'].'"><img src="'.$img.'" ></a>';
					
				?>
				
				</div>
            </div>
            <div class="model_right"><!--right section!-->
			<!--<input type="checkbox" checked="checked" name="savecheck" value="1" id="savecheck_1">-->

            	<div class="c_logo"><?php if(!empty($land_val['logo'])) { ?><img src="<?php echo url(); ?>/uploads/landestate_logo/<?php echo $land_val['logo']; ?>"><?php  } ?></div>
            	<!--<a href="<?php //echo url(); ?>/land/view/<?php //echo $land_val['id']; ?>"><h4><?php // echo $land_val['title'] ; ?></h4></a>-->
                 <p><?php  if(!empty($land_val['land_desc'])) {  $string = strip_tags($land_val['land_desc']);

if (strlen($string) > 200) {

    // truncate string
    $stringCut = substr($string, 0, 500);

    // make sure it ends in a word so assassinate doesn't become ass...
    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
}
echo $string; ; } ?> </p>
            </div><!--right section!-->
            <div class="clr"></div>
        </div>
  
		<?php } } else {  echo '<h2>No results</h2><br/><p>
You have no saved homes. <a href="'.url().'/property/search-property">Back to search.</p>' ;  } ?>

 <ul class="pagination">
		<?php 


$ptemp = url().'/land-estates?';
		 $pages = '';



//echo $whereStr;
	if ($currentpage != 1) 
{ //GOING BACK FROM PAGE 1 SHOULD NOT BET ALLOWED
 $previous_page = $currentpage - 1;
 //$previous = '<a href="'.$ptemp.'?pageno='.$previous_page.'"> </a> '; 
$previous = '&lt;Previous' ;
 $pages .= '<li><a href="'.$ptemp.'page='.$previous_page.'">'. $previous .'</a></li>'; 
}    
$adjacents = 2;
/* $a=1;
foreach($properties_arr as $prop_values) 
{
  if ($a == $currentpage) 
  $pages .= '<li><a href="#" class="active">'. $a .'</a></li>';
  else 
 $pages .= '<li><a href="'.$ptemp.'page='.$a.$whereStr1.'">'. $a .'</a></li>';
 $a++;
} */

  $pmin = ($currentpage > $adjacents) ? ($currentpage - $adjacents) : 1;
    $pmax = ($currentpage < ($lastpage - $adjacents)) ? ($currentpage + $adjacents) : $lastpage;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $currentpage) {
            $pages.= "<li  class=\"active\"><a href='#'>" . $i . "</a></li>\n";
        } elseif ($i == 1) {
            $pages.= "<li><a  href=\"" . $ptemp ."page=".$i. "\"  rel=".$i.">" . $i . "</a>\n</li>";
        } else {
            $pages.= "<li><a  href=\"" . $ptemp . "page=" . $i . "\"  rel=".$i." >" . $i . "</a>\n</li>";
        }
    }
    

//$pages = substr($pages,0,-1); //REMOVING THE LAST COMMA (,)

if($currentpage != $lastpage) 
{

 //GOING AHEAD OF LAST PAGE SHOULD NOT BE ALLOWED
 $next_page = $currentpage + 1;
 $next = 'Next&gt;';
 $pages .= '<li><a href="'.$ptemp.'page='.$next_page.'">'. $next .'</a></li>';

}

if(!empty($numrows)) {
echo   $pages ; //PAGINATION LINKS
}

		?>
	</ul>	


	</div>
		
    </div><!--middle section!-->
    <div class="list_right"><!--right section!-->
    	<div class="phone_sec"><!--phone section!-->
        	<p>Call our free and independent home
building consultant now</p>
            <div class="call"><em><img src="{{ URL::asset('assets/img/phone_ico.png') }}"></em> <span>1800 184 284</span></div>
        </div><!--phone section!-->
          <?php if(!empty($ads_arr)) { ?>
        <div class="add_model"><!--add section!-->
		<?php  foreach($ads_arr as $ads_val) { ?>
        	<h3>Get your free</h3>
            <div class="add_photo"><!--<div class="add_text"><h4>$<span>20</span> Voucher</h4></div> <div class="voucher-offer__plus"><span>plus</span></div>--> <img src="<?php echo url(); ?>/uploads/add_management/<?php echo $ads_val['image']; ?>" /></div>
            <p>Our independent home building guide with expert tips to save you time and money</p>
			<?php }   ?>
            <!--<div class="book"><img src="{{ URL::asset('assets/img/book.png') }}" /></div>
            <div class="enq_btn">When you enquire through icompare today. </div>-->
        </div><!--add section!-->
        <?php } ?>
        
		<?php if(!empty($testimonials)) { ?>
        <div class="t_sec"><!--testimonial section!-->
        	<blockquote class="testimonial__quote">
        	<span class="testimonial__hide-widget"><?php  echo $testimonials[0]->description; ?>
    		</blockquote>
            <h2 class="testimonial__name"><?php  echo $testimonials[0]->created_by; ?><span><?php  echo $testimonials[0]->state_company; ?></span></h2>
            <a href="<?php echo url(); ?>/testimonials" class="more_read">Read More</a>
        </div><!--testimonial section!-->
		<?php } ?>
    </div><!--right section!-->
    <div class="clr"></div>
</section><!--property section!-->



@stop
