@extends('layout.default')

@section('content')
<?php //echo '<pre>'; print_r($home_longlat); die('asf'); ?>

<div class="mobile-search">
<a href="javascript:void(0)" id="land-mobile-div">View Map</a>
<button class="prop_count"><?php if(!empty($total_land)) { echo $total_land ; } else { echo '0' ; } ?></button>
</div>
 <div class="full-wrap">
<div class="display-village-wrap">
<div id="land_view_list">
   <div class="dv-left display-land-wrap">
   <div class="dv-left-top1">
   <div class="list_mid land_list"><!--middle section!-->
   <!--<h2>Refine your search</h2>-->
   <div class="select-land-wrap">
   <p>Search Australia’s land estates</p>
            <div class="select_box"><!--copyable text!-->
            	<select name="build_location" id ="filter-region">
				<?php // $main_states = array('Queensland'=>'QLD' ,'Victoria'=>'VIC','New South Wales'=>'NSW','Western Australia'=>'WA','Tasmania'=>'TAS','Northern Territory'=>'NT','Australian Capital Territory'=>'ACT','South Australia'=>'SA');
				$state = Session::get('header_state'); 
				$states = App\State::Getstates()->groupBy('state_name')->get();
				$states_arr = $states->toArray();

				?>
                      <?php if(!empty($states_arr)) { foreach($states_arr as $state_val)  { ?>
                      <option value="<?php echo $state_val['state_name']; ?>" <?php if(!empty($state)) { if($state == $state_val['state_name']){ echo 'selected="selected"' ; } }   ?>><?php echo $state_val['state_name']; ?></option>
					  <?php } } ?>
                      <!--<option value="QLD" <?php //if(!empty($state)) { if($state == 'QLD'){ echo 'selected="selected"' ; } }   ?>>QLD</option>
                      <option value="NSW" <?php //if(!empty($state)) { if($state == 'NSW'){ echo 'selected="selected"' ; } }   ?>>NSW</option>
                      <option value="WA" <?php //if(!empty($state)) { if($state == 'WA'){ echo 'selected="selected"' ; } }   ?>>WA</option>-->
                      <!--<option value="TAS" <?php //if(!empty($state)) { if($state == 'TAS'){ echo 'selected="selected"' ; } }   ?>>TAS </option>
                      <option value="ACT" <?php //if(!empty($state)) { if($state == 'ACT'){ echo 'selected="selected"' ; } }   ?>>ACT</option>
                      <option value="NT" <?php //if(!empty($state)) { if($state == 'NT'){ echo 'selected="selected"' ; } }   ?>>NT </option>
                      <option value="SA" <?php //if(!empty($state)) { if($state == 'SA'){ echo 'selected="selected"' ; } }   ?>>SA</option>-->
                  
                </select>
            </div><!--copyable text!-->
			 <div class="select_box region_sel">
			<select  name="search_region" id ="search_region1">
        				<?php // $main_states = array('Queensland'=>'QLD' ,'Victoria'=>'VIC','New South Wales'=>'NSW','Western Australia'=>'WA','Tasmania'=>'TAS','Northern Territory'=>'NT','Australian Capital Territory'=>'ACT','South Australia'=>'SA');
						//$main_states = array('Queensland'=>'QLD' ,'Victoria'=>'VIC','New South Wales'=>'NSW','Western Australia'=>'WA');
							 $header_state = Session::get('header_state');
							 $main_states = App\State::get_mainstates();
							 $main_text = array_search($header_state, $main_states);

        				?>
                      <option value="build-region">Select build region</option>
    				  <optgroup label="<?php echo $main_text ; ?>">
        				  <?php  foreach($build_location as $build_val) { ?>
        				  <option value="<?php echo $build_val['id'] ;  ?>"><?php echo $build_val['loc_name'] ;  ?></option>
        				  <?php } ?>
    				  </optgroup>
                  
                </select>
				<input type="submit" id="display_land_search" name="submit" class="land-filter">
			</div>
			<div class="clr"></div>
		</div>
    	<div class="white_mid save_property_top mid_land"><!--white box!-->
        	<div class="t_listleft">
			<span class="prop_count"><?php echo $total_land; ?></span> Land Estates
			<!--<span id="display_count"><?php //echo $total_display_home; ?></span> Display Lands-->
			<div class="cp-left save_sidebarcheck top_sidebarcheck">
			<div class='p_chk'>	
				<input type="checkbox" name="landallcheck" value="all" id="landallcheck"/>
				<label for="landallcheck">
			</div>
			</label>Select All</div>
			</div>
            <div class="t_listright">
			
            	<input type="submit" class="button2 land_enquire" disabled value="Enquire"/>
                <div class="clr"></div>
            </div>
            <div class="clr"></div>
        </div><!--white box!-->
	</div>	
</div>
<div class="dv-left-btm1">
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

        <div class="grey_bg save_prop_check land_content"><!--white box!-->
        	<div class="model_left">
            <div class="cp-left save_sidebarcheck">
				
			<input type="checkbox" class="landlistcheckbox" name="landlistcheck" value="<?php echo $land_val['id']; ?>" id="landlistcheck<?php echo $land_val['id']; ?>">
						<label for="landlistcheck<?php echo $land_val['id']; ?>">
			</label></div>
            	<div class="land_logo_img">
				<?php if(!empty($land_val['logo'])) { ?><a href="<?php echo url(); ?>/land/view/<?php echo $land_val['id']; ?>"><img src="<?php echo url(); ?>/uploads/landestate_logo/<?php echo $land_val['logo']; ?>"></a><?php  } else { ?>
				<a href="<?php echo url(); ?>/land/view/<?php echo $land_val['id']; ?>"><img src="{{ URL::asset('assets/img/no-image.jpg') }}"/></a>
				<?php } ?>
				
				</div>
            </div>
            <div class="clr"></div>
        </div>
  
		<?php } } else {  echo '<h2>No results</h2><br/><p>
There are no products matching your search criteria. Try making your filters less specific.</p>' ;  } ?>

 <ul class="pagination">
		<?php 


$ptemp = url().'/land/display-land?';
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
	</div>	
    </div><!--middle section!-->
	</div>
	
	   <div class="dv-right" id="land_view_map">
   
   
   <script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3"></script>
   <script type="text/javascript" src="<?php echo url(); ?>/assets/js-marker-clusterer/src/markerclusterer.js"></script>
   
   <script type="text/javascript">
   
$(document).ready(function(){
 initialize();

 
 });
 
   var imageUrl = "<?php echo url(); ?>/assets/img/map-pin.png";

        var markers = [];
        
        var markerImage = new google.maps.MarkerImage(imageUrl,
          new google.maps.Size(50, 50));
   function initialize() {
   map = new google.maps.Map(document.getElementById("map"), {
 center: new google.maps.LatLng(-25.274398, 133.775136),
 zoom: 5,
 mapTypeId: google.maps.MapTypeId.ROADMAP,
 mapTypeControl: false,
 mapTypeControlOptions: {
 style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
 },
 navigationControl: true,
 navigationControlOptions: {
 style: google.maps.NavigationControlStyle.SMALL
 }
 });

      <?php  foreach( $display_home_arr as $location ){ 
   
      //$name = $location['location_name'];
        //$addr = $location['location_address'];
         $map_lat = $location['geo_lat'];
         $map_lng = $location['geo_lng'];	
		$display_title = 	preg_replace('/[^A-Za-z0-9\. -]/', '', $location['display_village_title']);		
		$display_location = 	$location['display_location'];				
		$display_id = 	$location['id'];		
		//$dd = "'".utf8_encode(str_replace(',','',trim($display_location)))."'" ;
		//$dd = str_replace('(','',trim($display_location));
		//$dd = str_replace(')','',trim($dd));
		//$dd = str_replace(',','',trim($dd));
		 $display_location1 = preg_replace('/[^A-Za-z0-9\. -]/', '', $display_location);
		//echo (string) $dd ;
   
   if($map_lat != '' || $map_lng != ""){
   ?>
          var latLng = new google.maps.LatLng(<?php echo $map_lat;  ?>,<?php echo $map_lng;  ?>);
          var marker = new google.maps.Marker({
            position: latLng,
           draggable: true,
           icon: markerImage
          });
		   google.maps.event.addListener(marker, 'click', function() {
            var infowindow = new google.maps.InfoWindow({
              content: '<div class=\"map_wrap\"><a href="<?php echo url(); ?>/land/view/<?php echo $location['landestate_id'] ; ?>"><img src=<?php echo url(); ?>/uploads/landestate_logo/<?php echo $location['image'];  ?> class="map-logo" /></a><div class=\"dv-left-btm map-popup-data\"><div class=\"dv-left-btm-inner\"><div class=\"dv-left-btm-box\"><h3><?php echo $display_title ; ?></h3><p><?php echo $display_location1 ; ?></p></div><div class="dv-left-btm-box"><h4>Open hours</h4><?php  foreach($location['open_hours'] as $open_hour_value) { ?><p><?php echo $open_hour_value['day']." ".$open_hour_value['start_time']." - ".$open_hour_value['end_time'] ;  ?></p><?php } ?><a rel="<?php echo $display_id ; ?>" class="see_all book_land_appointment map-button" href=javascript:void(0)>Book Appointment</a><br/><br/><a  class=\"open_landmasterplan\" value=\"Enquire to Builders\"  data-target=\"masterplan\" data-id=<?php echo $location['landestate_id'] ; ?>  href=\"javascript:void(0);\" data-toggle=\"modal\"><img src=<?php echo url(); ?>/assets/img/floor.png>Master Plan</a></div></div></div></div>',
			   maxWidth: 300
            });
            infowindow.open(map, this);
          });
		  
          markers.push(marker);
      <?php }  } ?>
	  	  var markerCluster = new MarkerClusterer(map, markers);
	  
      }

	  
</script>
 
 <div id="map" style="width:100%;"></div>
	</div>
	
   </div>
 
</div>
   <!-- For floorplan popup -->
  <div class="modal fade bs-example-modal-lg masterplan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="load_masterplan_content">
 
  </div>
  </div>
  
</div>  
@stop