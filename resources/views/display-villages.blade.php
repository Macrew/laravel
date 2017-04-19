@extends('layout.default')

@section('content')

 <div class="full-wrap">
<div class="display-village-wrap">
   <div class="dv-left">
       <div class="dv-left-top">
           <div class="cp-box">
					<div class="cp-left"><a href="<?php echo url() ; ?>/propertydetail/<?php echo $prop_id ; ?>"><i class="fa fa-angle-left"></i></a></div>
					<div class="cp-right">
						<div class="cp-r-top"><?php if(!empty($prop_image)) { ?><a href="<?php echo url() ; ?>/propertydetail/<?php echo $prop_id ; ?>"><img alt="<?php echo $prop_title ; ?>" src="<?php echo url().'/uploads/property_gallery/'.$prop_image; ?>"></a><?php } else { ?> <a href="<?php echo url() ; ?>/propertydetail/<?php echo $prop_id ; ?>"><img src="<?php echo url(); ?>/assets/img/no-image.jpg" alt=""/></a><?php  } ?>
                        <h3><a href=""><?php echo $prop_title ; ?></a></h3>	
						<p>Display Villages (<?php echo $total_display_home ; ?>)</p>
						</div>
					</div>
					<div class="clr"></div>
				</div>
                </div>
             <div class="dv-left-btm">
			 <?php if(!empty($display_home_arr)) { foreach($display_home_arr as $display_home_value) { ?>
             <div class="dv-left-btm-inner">
                 <div class="dv-left-btm-box">
                     <a href="javascript:void(0)" class="see_all book_appointment" rel="<?php echo $display_home_value['id']; ?>">Book Appointment</a>
                     <!--<h2>Williams Landing</h2>-->
                     <h3><?php  echo $display_home_value['display_village_title']; ?></h3>
                     <p><?php  echo $display_home_value['display_location']; ?></p>
                 </div>
                 <div class="dv-left-btm-box">
                     <h4>Open hours</h4>
					 <?php foreach($display_home_value['open_hours'] as $open_hour) { ?>
                     <p><?php echo $open_hour['day'].' '.$open_hour['start_time'].' - '.$open_hour['end_time'];   ?></p>
					<?php } ?>
                 </div>
                 <div class="similer-villages"><?php  $related_display_home_arr =  App\Property::get_related_display_home($display_home_value['display_village_title'],$display_home_value['display_location'],$display_home_value['property_id']) ; ?>
				 <div class="read_more_<?php echo $display_home_value['id']; ?>">
				 <?php if(!empty($related_display_home_arr)) {
				 
				 ?>
                     <h5>Also at this village:</h5>
					 <?php if(count($related_display_home_arr) > 3) { ?> 
                     <span>More <a href="javascript:void(0)" data-vill="<?php echo $display_home_value['id']; ?>" class="related_detail" rel="more"><i class="fa fa-plus"></i></a></span>
					 <?php } ?>
                     <div class="full-wrap related_village">
						<?php  
							$i=1;
							foreach($related_display_home_arr as $home_val) {
							
							if($i > 3) {
							
								break;
							}
							
						?>
                         <div class="sv-box"><?php if(!empty($home_val['property_gallery'][0]['image'])) { ?><a href="<?php echo url(); ?>/propertydetail/<?php echo $home_val['id'] ; ?>"><img src="<?php echo url().'/uploads/property_gallery/'.$home_val['property_gallery'][0]['image']; ?>" alt=""></a><?php } else { ?><a href="<?php echo url(); ?>/propertydetail/<?php echo $home_val['id'] ; ?>"><img src="<?php echo url(); ?>/assets/img/no-image.jpg" alt=""/></a><?php } ?><p><a href="<?php echo url(); ?>/propertydetail/<?php echo $home_val['id'] ; ?>"><?php echo $home_val['property_title'] ; ?></a></p></div>
						 <?php  $i++ ; }  ?>
						 <div class="clr"></div>
                     </div>
					 <?php } ?>
					 </div>
					 <div class="read_less_<?php echo $display_home_value['id']; ?>" style="display:none;" >
					<?php if(!empty($related_display_home_arr)) {
				 
					?>
                     <h5>Also at this village:</h5>
                     <span>Less <a href="javascript:void(0)" class="related_detail" data-vill="<?php echo $display_home_value['id']; ?>" rel="less"><i class="fa fa-minus"></i></a></span>
                     <div class="full-wrap related_village">
						<?php  
							foreach($related_display_home_arr as $home_val) {
						?>
                         <div class="sv-box"><?php if(!empty($home_val['property_gallery'][0]['image'])) { ?><a href="<?php echo url(); ?>/propertydetail/<?php echo $home_val['id'] ; ?>"><img src="<?php echo url().'/uploads/property_gallery/'.$home_val['property_gallery'][0]['image']; ?>" alt=""></a><?php } else { ?><a href="<?php echo url(); ?>/propertydetail/<?php echo $home_val['id'] ; ?>"><img src="<?php echo url(); ?>/assets/img/no-image.jpg" alt=""/></a><?php } ?><p><a href="<?php echo url(); ?>/propertydetail/<?php echo $home_val['id'] ; ?>"><?php echo $home_val['property_title'] ; ?></a></p></div>
						 <?php  }  ?>
						 <div class="clr"></div>
                     </div>
					 <?php } ?>
					 </div>
                 </div>
             </div>
			 <?php } } ?>
             </div>

   </div>
   <div class="dv-right">
   <script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3"></script>
   <script type="text/javascript">
 $(document).ready(function(){
 initialize();
 });
 var icon = new google.maps.MarkerImage("<?php echo url(); ?>/assets/img/map-pin.png",
 new google.maps.Size(50, 50), new google.maps.Point(0, 0),
 new google.maps.Point(16, 32));
 var center = null;
 var map = null;
 var currentPopup;
 var bounds = new google.maps.LatLngBounds();
 function addMarker(lat, lng, info) {
 var pt = new google.maps.LatLng(lat, lng);
//alert(pt);
 bounds.extend(pt);
 var marker = new google.maps.Marker({
 position: pt,
 icon: icon,
 map: map
 });
 var popup = new google.maps.InfoWindow({
 content: info,
 maxWidth: 300
 });
 google.maps.event.addListener(marker, "click", function() {
 if (currentPopup != null) {
 currentPopup.close();
 currentPopup = null;
 }
 popup.open(map, marker);
 currentPopup = popup;
 });
 google.maps.event.addListener(popup, "closeclick", function() {
 currentPopup = null;
 });
 }

 function initialize() {
 map = new google.maps.Map(document.getElementById("map"), {
 center: new google.maps.LatLng(0, 0),
 zoom: 1,
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
 <?php
foreach( $display_home_arr as $location ){
        //$name = $location['location_name'];
        //$addr = $location['location_address'];
        $map_lat = $location['geo_lat'];
        $map_lng = $location['geo_lng'];
		$display_title = 	$location['display_village_title'];				
		$display_location = 	$location['display_location'];				
		$display_id = 	$location['id'];		
		//$dd = "'".utf8_encode(str_replace(',','',trim($display_location)))."'" ;
		//$dd = str_replace('(','',trim($display_location));
		//$dd = str_replace(')','',trim($dd));
		//$dd = str_replace(',','',trim($dd));
		 $display_location1 = preg_replace('/[^A-Za-z0-9\. -]/', '', $display_location);
		//echo (string) $dd ;
		
		?>

		addMarker(<?php echo $map_lat;  ?>,<?php echo $map_lng;  ?>,'<div class=\"map_wrap\"><div class=\"dv-left-btm map-popup-data\"><div class=\"dv-left-btm-inner\"><div class=\"dv-left-btm-box\"><h3><?php echo $display_title ; ?></h3><p><?php echo $display_location1 ; ?></p></div><div class="dv-left-btm-box"><h4>Open hours</h4><?php  foreach($location['open_hours'] as $open_hour_value) { ?><p><?php echo $open_hour_value['day']." ".$open_hour_value['start_time']." - ".$open_hour_value['end_time'] ;  ?></p><?php } ?></p></div><a rel=<?php echo $display_id ; ?> class=\"see_all book_appointment map-button\" href=javascript:void(0)>Book Appointment</a></div></div></div>');
             
 <?php }
 ?>
 center = bounds.getCenter();
 map.fitBounds(bounds);
 map.setOptions({ minZoom: 5, maxZoom: 15 });
 }
 </script>

 
 <div id="map" style="width:100%; height:1000px"></div>
</div>    
</div>
</div>  
@stop