@extends(AdminTemplate::view('_layout.base'))

@section('content')
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			@include(AdminTemplate::view('_partials.header'))
			@include(AdminTemplate::view('_partials.user'))
			@include(AdminTemplate::view('_partials.menu'))
		</nav>
		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header"><?php echo $title; ?></h1>
				</div>
			</div>
			    <!-- /.row -->
	<?php if(Session::has('save_message')) { ?>
    <div class="alert alert-success">
        <?php  echo Session::get('save_message') ; ?>
    </div>
	<?php } ?>			
<?php if(Session::has('update_message')) { ?>
    <div class="alert alert-success">
        <?php  echo Session::get('update_message') ; ?>
    </div>
	<?php } ?>

	<?php if($errors->any()) { ?>
    <div class="alert alert-danger">
	<?php 
        foreach($errors->all() as $error){  ?>
            <p><?php echo $error ; ?></p>
     <?php   }
		?>
    </div>
	<?php } ?>
				
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">

                           Manage Display Land Location
						
                        </div>
						
						<?php // echo Route::getCurrentRoute()->getActionName(); 
						
						 $currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method);
						 if($controller == 'LandEstateController' && $method == 'manage_display_land_location') {
						
						?>
						<input type="hidden" name="base_url" id="base_url" value="<?php echo url();?>"/>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php 
					 /*   echo '<pre>';
						print_r($prop_display_home_arr);   */
						//die; 
						if(!empty($prop_display_home_arr[0])) {
						$display_home = $prop_display_home_arr[0];
						}
						?>
                                  		  
									 <form method="post" action="" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
									 <div class="form-group">
            	<select name="build_location" id ="filter-region" class="states">
				<?php  $main_states = array('Queensland'=>'QLD' ,'Victoria'=>'VIC','New South Wales'=>'NSW','Western Australia'=>'WA','Tasmania'=>'TAS','Northern Territory'=>'NT','Australian Capital Territory'=>'ACT','South Australia'=>'SA');
								 $state = Session::get('header_state');
								 $main_text = array_search($state, $main_states);

				?>
                        <option value="VIC" <?php if(!empty($state)) { if($state == 'VIC'){ echo 'selected="selected"' ; } }   ?>>VIC</option>
                      <option value="QLD" <?php if(!empty($state)) { if($state == 'QLD'){ echo 'selected="selected"' ; } }   ?>>QLD</option>
                      <option value="NSW" <?php if(!empty($state)) { if($state == 'NSW'){ echo 'selected="selected"' ; } }   ?>>NSW</option>
                      <option value="WA" <?php if(!empty($state)) { if($state == 'WA'){ echo 'selected="selected"' ; } }   ?>>WA</option>
                      <option value="TAS" <?php if(!empty($state)) { if($state == 'TAS'){ echo 'selected="selected"' ; } }   ?>>TAS </option>
                      <option value="ACT" <?php if(!empty($state)) { if($state == 'ACT'){ echo 'selected="selected"' ; } }   ?>>ACT</option>
                      <option value="NT" <?php if(!empty($state)) { if($state == 'NT'){ echo 'selected="selected"' ; } }   ?>>NT </option>
                      <option value="SA" <?php if(!empty($state)) { if($state == 'SA'){ echo 'selected="selected"' ; } }   ?>>SA</option>
                  
                </select>
            </div><!--copyable text!-->
				<div class="form-group">
				     <label>Select Build Region</label>
			<select  name="search_region" id ="search_region1" class="region">
        				<?php $main_states = array('Queensland'=>'QLD' ,'Victoria'=>'VIC','New South Wales'=>'NSW','Western Australia'=>'WA','Tasmania'=>'TAS','Northern Territory'=>'NT','Australian Capital Territory'=>'ACT','South Australia'=>'SA');
							 $header_state = Session::get('header_state');
							 $main_text = array_search($header_state, $main_states);

        				?>
                      <option value="build-region">Select build region</option>
    				  <optgroup label="<?php echo $main_text ; ?>">
        				  <?php  foreach($build_location as $build_val) { ?>
        				  <option value="<?php echo $build_val['id'] ;  ?>"><?php echo $build_val['loc_name'] ;  ?></option>
        				  <?php } ?>
    				  </optgroup>
                  
                </select>
			</div>
			<button class="btn btn-default" type="button" id="display_land_search" class="land-filter">Search</button>
                                    </form>
                          
                            
							 <script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3"></script>
							<div id="map" style="width:100%;height:500px;margin-top:10px;"></div>
							
							
                        </div>
						<?php } ?>
						
						
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
		</div>
	</div>
	    <script>
    $(document).ready(function() {
	initialize();
        $('#dataTables-example').DataTable({
                responsive: true
        });
		 $(".builder_location").select2({ width: '100%' });
		 $(".states").select2({ width: '100%' });
		 $(".region").select2({ width: '100%' });
		  $('#wstart_time').timepicker();
	    $('#wend_time').timepicker();
	    $('#sastart_time').timepicker();
	    $('#saend_time').timepicker();
	    $('#sunstart_time').timepicker();
	    $('#sunend_time').timepicker();
		 $(".property_ids").select2({ width: '100%' });
		 $('#filter-region').change(function(){
	  var base_url = $('#base_url').val();
	  var url = base_url+'/admin/land/change-land-state-search';
	var stat = $(this).val();
	 //$('#loading-indicator').show();
 	$.ajax({
		type:'post',
		url:url,
		data:'state='+stat,
		crossDomain:true, 
		success:function(data)
		{ 
			var main_states = [];
			main_states.push({'QLD':'Queensland'});
			main_states.push({'VIC' :'Victoria'});
			main_states.push({'NSW' :'New South Wales'});
			main_states.push({'WA' :'Western Australia'});
			main_states.push({'TAS' :'Tasmania'});
			main_states.push({'NT' :'Northern Territory'});
			main_states.push({'ACT' :'Australian Capital Territory'});
			main_states.push({'SA' :'South Australia'});
			var option = '<option value="build-region">Select build region</option>';
			//var optionlabel = '<optgroup label="">';
			$.each(main_states, function(index,value){
				if(value[stat] != undefined){
					optionlabel = '<optgroup label="'+value[stat]+'">';
				}
			});
			
			var option_val = '';
			for (var i=0; i<data.length; i++) {
		      option_val += '<option value="' + data[i].id + '">' + data[i].loc_name + '</option>';
		    }
			optionlabell = '</optgroup>';
			$('#search_region1').empty();
			$(".region").select2("destroy");

			$(".region").select2({ width: '100%' });
			
			$('#search_region1').html(option+optionlabel+option_val+optionlabell);
		}
	});
});

	$('#display_land_search').on('click',function() {

	var land_estate_location = $("#search_region1 option:selected").val();
 var base_url = $('#base_url').val();
	var count_url1 = base_url+'/admin/lands/ajax_filter_map_lands';
	var land_estate_location = $("#search_region1 option:selected").val();
	var datastring = 'land_estate_location='+land_estate_location;
	// count total properties
	$.ajax({
		type:'post',
		url:count_url1,
		data:datastring,
		crossDomain:true, 
		dataType:'json',
		success:function(data)
		{
			init_google_map(data);
		}

	});
});



    });
	
function check_null_val(json_val)
{
	var json = ""
	if(typeof json_val !== "undefined")
	{
		json = json_val
		return json;
	} else {
		return json;
	}
}
	
	function init_google_map(data)
{
	var base_url = $('#base_url').val();
	  var imageUrl = base_url+"/assets/img/map-pin.png";
		$('#display_count').html(data.total_display_lands);
        var markers = [];
        var geocoder = new google.maps.Geocoder();
        var markerImage = new google.maps.MarkerImage(imageUrl,
          new google.maps.Size(50, 50));
	 var position = new google.maps.LatLng(-25.274398, 133.775136);
	map = new google.maps.Map(document.getElementById("map"));
	map.setZoom(5);
	map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
	map.setCenter(new google.maps.LatLng(-25.274398, 133.775136)); 
	var bounds = new google.maps.LatLngBounds();
		$.each(data, function(i, item) {
		if(typeof data[i] === "object") {		
	   	if(typeof data[i].geo_lat !== "undefined") {		
			var lat  = check_null_val(data[i].geo_lat);
			var html = '';
			var html1 = '';
			var title = data[i].display_village_title;
			var rtitle = title.replace(/[^A-Za-z0-9\. -]/, '');
			
			var display_location = data[i].display_location;
			var rdisplay_location = display_location.replace(/[^A-Za-z0-9\. -]/, '');
			 var longit  = check_null_val(data[i].geo_lng);
			 if(lat != 0 || longit != 0) {

			   var pt = new google.maps.LatLng(lat, longit);
				bounds.extend(pt);
			html+= '<div class="map_wrap"><a href="'+base_url+'/land/view/'+data[i].landestate_id+'"><img src='+base_url+'/uploads/landestate_logo/'+data[i].image+' class="map-logo" /></a><div class="dv-left-btm map-popup-data"><div class="dv-left-btm-inner"><div class="dv-left-btm-box"><h3>'+rtitle+'</h3><p>'+rdisplay_location+'</p><div class="map_id" id="'+data[i].id+'"></div><div class="dv-left-btm-box"><h4>Open hours</h4>';
			var open_hours =  data[i].open_hours;
				$.each(open_hours , function(k, item) { 
				
				html+= '<p>'+open_hours[k].day+" "+open_hours[k].start_time+" - "+open_hours[k].end_time+'</p>';
				
				});
				
				html+= '</div></div></div></div>';
				//addMarker(lat,longit ,html);	
				var latLng = new google.maps.LatLng(lat,longit);
          var marker = new google.maps.Marker({
            position: latLng,
           icon: markerImage,
		   draggable:true,
		    store_id: data[i].id,
          });		
		  
		    google.maps.event.addListener(marker, 'click', function() {
            var infowindow = new google.maps.InfoWindow({
              content: html,
			   maxWidth: 300
            });
            infowindow.open(map, this);
          });
		  html1+= '<div class="map_wrap"><img src='+base_url+'/uploads/landestate_logo/'+data[i].image+' class="map-logo" /><div>'; 
		  var infowindow1 = new google.maps.InfoWindow({maxWidth: 150})
		   google.maps.event.addListener(marker, 'mouseover', (function (marker, html1, infowindow1) {
            return function () {
                infowindow1.setContent(html1);
                infowindow1.open(map, marker);
            };
        })(marker, html1, infowindow1));
        google.maps.event.addListener(marker, 'mouseout', (function (marker, html1, infowindow1) {
            return function () {
                infowindow1.close();
            };
        })(marker, html1, infowindow1));

		  
          markers.push(marker);
		  
		  		google.maps.event.addListener(marker, 'dragend', function() {

geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
if (status == google.maps.GeocoderStatus.OK) {
if (results[0]) {
var adress = results[0].formatted_address;
var lat = marker.getPosition().lat();
var lng = marker.getPosition().lng();
var rel = marker.get('store_id');

 var base_url = $('#base_url').val();
	var count_url1 = base_url+'/admin/lands/update_land_location';
	var datastring = 'adress='+adress+'&lat='+lat+'&lng='+lng+'&rel='+rel;
	// count total properties
	$.ajax({
		type:'post',
		url:count_url1,
		data:datastring,
		crossDomain:true, 
		success:function(data)
		{
			alert(data);
		}

	});


}
}
});
});
		  
			 }
		}		
		}
	});

  var markerCluster = new MarkerClusterer(map, markers);
map.fitBounds(bounds);
}
	
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
	  
      }

	
    </script>
	<style>
	.form-control.ui-timepicker-input {
    width: 90px;
}
.map-logo {
    width: 50% !important;
}
.dv-left-btm-inner {
    padding: 20px 15px;
    position: relative;
}
.dv-left-btm-box {
    margin-bottom: 15px;
}
.dv-left-btm h3 {
    font-size: 15px;
    font-weight: bold;
    margin-bottom: 5px;
    text-transform: uppercase;
}
.dv-left-btm p {
    font-size: 14px;
    line-height: 20px;
    margin-bottom: 2px;
}
.dv-left-btm-box {
    margin-bottom: 15px;
}
.map_wrap .dv-left-btm .see_all {
    position: relative;
    right: auto;
    top: auto;
}
.dv-left-btm .see_all {
    color: #fff;
    font-size: 15px;
    margin: 0 !important;
    padding: 10px 26px;
}
	</style>
@stop