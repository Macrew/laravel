@extends('layout.default')

@section('content')	
<?php
$custommin_price = 100000;
$custommax_price = 1000000;
$custommin_block_width = 5;
$custommax_block_width = 20;
$custommin_block_length = 10;
$custommax_block_length = 40;
$custommin_house_size = 5;
$custommax_house_size = 50;
$custommin_land_size = 150;
$custommax_land_size = 1000;
?>

<div class="bread_crum"><!--bread crum section!-->
	<ul>
    	<li><a href="#"><img src="{{ URL::asset('assets/images/search-ico.png') }}" alt="Search"  /></a></li>
        <li><a href="#"><img src="{{ URL::asset('assets/images/compare-ico.png') }}" onMouseOver="this.src='<?php echo url();?>/assets/images/compare-ico-h.png'" onMouseOut="this.src='<?php echo url();?>/assets/images/compare-ico.png'" alt="" /></a></li>
        <li><a href="#"><img src="{{ URL::asset('assets/images/enquire.png') }}" onMouseOver="this.src='<?php echo url();?>/assets/images/enquire_h.png'" onMouseOut="this.src='<?php echo url();?>/assets/images/enquire.png'" /></a></li>
    </ul>
</div><!--bread crum section!-->
 
 <div class="search_top"><!--top banner!-->
	<h2>Search <span>Australia’s</span> Best Builders</h2>
</div><!--top banner!-->

<!--==================================Search body start here!================-->
<div class="content">
    <div class="search_page container">
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
				  		<div class="s_filter">
            	<h3>Refine your search</h3>
			<input type="hidden" name="house_lands" value="house_lands_page" id="house_lands"/>
                <div class="filter_fm">
                	<div class="filter_row"><!--row section!-->
                    	<div class="loc_left">
						<label>Build Location</label>
            	<select name="build_location" id="build_location">
				<?php $main_states = array('Queensland'=>'QLD' ,'Victoria'=>'VIC','New South Wales'=>'NSW','Western Australia'=>'WA');
								 $header_state = Session::get('header_state');
								 $main_text = array_search($header_state, $main_states);

				?>
                  <option>Build Location</option>
				  <optgroup label="<?php echo $main_text ; ?>">
				  <?php  foreach($build_location as $build_val) {
						if(!empty($_REQUEST['search_region'])) { if($build_val['id'] == $_REQUEST['search_region']) {

				  ?>
				  <option value="<?php echo $build_val['id'] ;  ?>" selected="selected"><?php echo $build_val['loc_name'] ;  ?></option>
				  <?php } else {   ?>  <option value="<?php echo $build_val['id'] ;  ?>"><?php echo $build_val['loc_name'] ;  ?></option> <?php } } else {  ?> <option value="<?php echo $build_val['id'] ;  ?>"><?php echo $build_val['loc_name'] ;  ?></option> <?php } } ?>
				  </optgroup>
                  
                </select>
                        </div>
                        <div class="loc_left loc_rt">
                        	<label>Specific Builder</label>
                   <select id="spe-builder">
                  <option value="Specific Builder">Specific Builder</option>
				 <?php  if(!empty($builder_arr)) {  
						foreach($builder_arr as $build_val) {
						if(!empty($_REQUEST['builder'])) {
						if($build_val['builder_id'] == $_REQUEST['builder']) {
				 ?>
                  <option value="<?php echo $build_val['builder_id']; ?>" selected="selected"><?php echo $build_val['company_name']; ?></option>
				  <?php } else {  ?> <option value="<?php echo $build_val['builder_id']; ?>"><?php echo $build_val['company_name']; ?></option>   <?php  } } else { ?> <option value="<?php echo $build_val['builder_id']; ?>"><?php echo $build_val['company_name']; ?></option>   <?php } } } ?>
                </select>
                        </div>
                        <div class="clr"></div>
                    </div><!--row section!-->
                    
                    <div class="filter_row"><!--row section!-->
                    	<div class="range_lt">
                        	<label>Price Range</label>
                        <div class="noUiSlider" id="price_range"></div>
						<span id="price-lower-value" class="example-val"></span>
						<span id="price-lower-offset"></span>
						<span id="price-upper-value" class="example-val"></span>
						<span id="price-upper-offset"></span>
						<input type="hidden" name="min_price" value="<?php echo $custommin_price ; ?>" id="min_price" />
						<input type="hidden" name="max_price" value="<?php echo $custommax_price ; ?>" id="max_price" />
						<input type="hidden" name="filter_min_price" value="" id="filter_min_price" />
						<input type="hidden" name="filter_max_price" value="" id="filter_max_price" />
                        </div>
                        <div class="range_lt">
                        	<label>Min. Block width (m)</label>
                            <div class="noUiSlider" id="min-block-width"></div>
							<span id="width-lower-value" class="example-val"></span>
							<span id="width-lower-offset"></span>
							<span id="width-upper-value" class="example-val"></span>
							<span id="width-upper-offset"></span>
							<input type="hidden" name="min_block_width" value="<?php echo $custommin_block_width ; ?>" id="min_block_width" />
							<input type="hidden" name="max_block_width" value="<?php echo $custommax_block_width ; ?>" id="max_block_width" />
							<input type="hidden" name="filter_min_width" value="" id="filter_min_width" />
							<input type="hidden" name="filter_max_width" value="" id="filter_max_width" />
                        </div>
                        <div class="range_lt">
                        	<label>Min. Block length (m)</label>
                            <div class="noUiSlider" id="min-block-length"></div>
							<span id="length-lower-value" class="example-val"></span>
							<span id="length-lower-offset"></span>
							<span id="length-upper-value" class="example-val"></span>
							<span id="length-upper-offset"></span>
							<input type="hidden" name="min_block_length" value="<?php echo $custommin_block_length ; ?>" id="min_block_length" />
							<input type="hidden" name="max_block_length" value="<?php echo $custommax_block_length ; ?>" id="max_block_length" />
							<input type="hidden" name="filter_min_length" value="" id="filter_min_length" />
							<input type="hidden" name="filter_max_length" value="" id="filter_max_length" />
                        </div>
                        <div class="range_lt">
                        	<label>House size</label>
                            <div class="noUiSlider" id="house-size"></div>
							<span id="size-lower-value" class="example-val"></span>
							<span id="size-lower-offset"></span>
							<span id="size-upper-value" class="example-val"></span>
							<span id="size-upper-offset"></span>
							<input type="hidden" name="min_house_size" value="<?php echo $custommin_house_size ; ?>" id="min_house_size" />
							<input type="hidden" name="max_house_size" value="<?php echo $custommax_house_size ; ?>" id="max_house_size" />
							<input type="hidden" name="filter_min_hsize" value="" id="filter_min_hsize" />
							<input type="hidden" name="filter_max_hsize" value="" id="filter_max_hsize" />
                        </div>

                        <div class="clr"></div>
                    </div><!--row section!-->
					
					<div class="filter_row"><!--row section!-->
					 <div class="range_lt">
                        	<label>Land size</label>
                            <div class="noUiSlider" id="house-land-size"></div>
							<span id="landsize-lower-value" class="example-val"></span>
							<span id="landsize-lower-offset"></span>
							<span id="landsize-upper-value" class="example-val"></span>
							<span id="landsize-upper-offset"></span>
							<input type="hidden" name="min_house_land_size" value="<?php echo $custommin_land_size ; ?>" id="min_house_land_size" />
							<input type="hidden" name="max_house_land_size" value="<?php echo $custommax_land_size ; ?>" id="max_house_land_size" />
							<input type="hidden" name="filter_min_hlandsize" value="" id="filter_min_hlandsize" />
							<input type="hidden" name="filter_max_hlandsize" value="" id="filter_max_hlandsize" />
                        </div>
						<div class="clr"></div>
					</div>	
                    
                   <div class="filter_row"><!--row section!-->
                    	<div class="loc_left">
                        	<h3>More refinements</h3>
                        	<div class="m_filter_row">
                            	<div class="m_filter_lt">
                                	<label>Bedrooms</label>
                            		<select  name="bedrooms" id="bedrooms">
              <option selected="selected" value="Bedrooms">Bedrooms</option>
			  <?php if(!empty($_REQUEST['bedrooms'])) { if($_REQUEST['bedrooms'] == '1') {  ?>
			  <option value="1" selected="selected">1 bedroom</option>
			  <?php } else { ?>
			   <option value="1">1 bedroom</option>
			  <?php } } else { ?>
			  <option value="1">1 bedroom</option>
			  <?php  }  ?>
			  
			  <?php if(!empty($_REQUEST['bedrooms'])) { if($_REQUEST['bedrooms'] == '1plus') {  ?>
			  <option value="1plus" selected="selected">1 or more bedrooms</option>
			  <?php } else { ?>
			   <option value="1plus">1 or more bedrooms</option>
			  <?php } } else { ?>
			  <option value="1plus">1 or more bedrooms</option>
			  <?php  }  ?>
			  
			  <?php if(!empty($_REQUEST['bedrooms'])) { if($_REQUEST['bedrooms'] == '2') {  ?>
			  <option value="2" selected="selected">2 bedrooms</option>
			  <?php } else { ?>
			   <option value="2">2 bedrooms</option>
			  <?php } } else { ?>
			  <option value="2">2 bedrooms</option>
			  <?php  }  ?>
			  
			  <?php if(!empty($_REQUEST['bedrooms'])) { if($_REQUEST['bedrooms'] == '2plus') {  ?>
			  <option value="2plus" selected="selected">2 or more bedrooms</option>
			  <?php } else { ?>
			   <option value="2plus">2 or more bedrooms</option>
			  <?php } } else { ?>
			  <option value="2plus">2 or more bedrooms</option>
			  <?php  }  ?>
			  
			  <?php if(!empty($_REQUEST['bedrooms'])) { if($_REQUEST['bedrooms'] == '3') {  ?>
			  <option value="3" selected="selected">3 bedrooms</option>
			  <?php } else { ?>
			   <option value="3">3 bedrooms</option>
			  <?php } } else { ?>
			  <option value="3">3 bedrooms</option>
			  <?php  }  ?>
			  
			  <?php if(!empty($_REQUEST['bedrooms'])) { if($_REQUEST['bedrooms'] == '3plus') {  ?>
			  <option value="3plus" selected="selected">3 or more bedrooms</option>
			  <?php } else { ?>
			   <option value="3plus">3 or more bedrooms</option>
			  <?php } } else { ?>
			  <option value="3plus">3 or more bedrooms</option>
			  <?php  }  ?>
			  
			   <?php if(!empty($_REQUEST['bedrooms'])) { if($_REQUEST['bedrooms'] == '4') {  ?>
			  <option value="4" selected="selected">4 bedrooms</option>
			  <?php } else { ?>
			   <option value="4">4 bedrooms</option>
			  <?php } } else { ?>
			  <option value="4">4 bedrooms</option>
			  <?php  }  ?>
			  
			    <?php if(!empty($_REQUEST['bedrooms'])) { if($_REQUEST['bedrooms'] == '4plus') {  ?>
			  <option value="4plus" selected="selected">4 or more bedrooms</option>
			  <?php } else { ?>
			   <option value="4plus">4 or more bedrooms</option>
			  <?php } } else { ?>
			  <option value="4plus">4 or more bedrooms</option>
			  <?php  }  ?>
			  
			  <?php if(!empty($_REQUEST['bedrooms'])) { if($_REQUEST['bedrooms'] == '5') {  ?>
			  <option value="5" selected="selected">5 bedrooms</option>
			  <?php } else { ?>
			   <option value="5">5 bedrooms</option>
			  <?php } } else { ?>
			  <option value="5">5 bedrooms</option>
			  <?php  }  ?>
			  
			   <?php if(!empty($_REQUEST['bedrooms'])) { if($_REQUEST['bedrooms'] == '5plus') {  ?>
			  <option value="5plus" selected="selected">5 or more bedrooms</option>
			  <?php } else { ?>
			   <option value="5plus">5 or more bedrooms</option>
			  <?php } } else { ?>
			  <option value="5plus">5 or more bedrooms</option>
			  <?php  }  ?>

                </select>
                                </div>
                                <div class="m_filter_lt">
                                	<label>Bathrooms</label>
                            		<select id="bathrooms" name="bathrooms">
                  <option selected="selected" value="Bathrooms">Bathrooms</option>
				   <?php if(!empty($_REQUEST['bathrooms'])) { if($_REQUEST['bathrooms'] == '1') {  ?>
			  <option value="1" selected="selected">1 bathroom</option>
			  <?php } else { ?>
			   <option value="1">1 bathroom</option>
			  <?php } } else { ?>
			  <option value="1">1 bathroom</option>
			  <?php  }  ?>
			  
			   <?php if(!empty($_REQUEST['bathrooms'])) { if($_REQUEST['bathrooms'] == '1plus') {  ?>
			  <option value="1plus" selected="selected">1 or more bathrooms</option>
			  <?php } else { ?>
			   <option value="1plus">1 or more bathrooms</option>
			  <?php } } else { ?>
			  <option value="1plus">1 or more bathrooms</option>
			  <?php  }  ?>
			  
			    <?php if(!empty($_REQUEST['bathrooms'])) { if($_REQUEST['bathrooms'] == '2') {  ?>
			  <option value="2" selected="selected">2 bathrooms</option>
			  <?php } else { ?>
			   <option value="2">2 bathrooms</option>
			  <?php } } else { ?>
			  <option value="2">2 bathrooms</option>
			  <?php  }  ?>
			  
			    <?php if(!empty($_REQUEST['bathrooms'])) { if($_REQUEST['bathrooms'] == '2plus') {  ?>
			  <option value="2plus" selected="selected">2 or more bathrooms</option>
			  <?php } else { ?>
			   <option value="2plus">2 or more bathrooms</option>
			  <?php } } else { ?>
			  <option value="2plus">2 or more bathrooms</option>
			  <?php  }  ?>
			  
			    <?php if(!empty($_REQUEST['bathrooms'])) { if($_REQUEST['bathrooms'] == '3') {  ?>
			  <option value="3" selected="selected">3 bathrooms</option>
			  <?php } else { ?>
			   <option value="3">3 bathrooms</option>
			  <?php } } else { ?>
			  <option value="3">3 bathrooms</option>
			  <?php  }  ?>
			  
			    <?php if(!empty($_REQUEST['bathrooms'])) { if($_REQUEST['bathrooms'] == '3plus') {  ?>
			  <option value="3plus" selected="selected">3 or more bathrooms</option>
			  <?php } else { ?>
			   <option value="3plus">3 or more bathrooms</option>
			  <?php } } else { ?>
			  <option value="3plus">3 or more bathrooms</option>
			  <?php  }  ?>

                </select>
                                </div>
                                <div class="m_filter_lt">
                                	<label>Living Space</label>
                            		<select id="living_spaces" name="living_spaces">
									 <option selected="selected" value="Living Spaces">Living Spaces</option>
									 <option value="1">1 living space</option>
									 <option value="1plus">1 or more living spaces</option>
									 <option value="2">2 living spaces</option>
									 <option value="2plus">2 or more living spaces</option>
									 <option value="3">3 living spaces</option>
									 <option value="3plus">3 or more living spaces</option>
									 <option value="4">4 living spaces</option>
									 <option value="4plus">4 or more living spaces</option>
									</select>
                                </div>
                                <div class="clr"></div>
                            </div>
                            <div class="m_filter_row">
                            	<div class="m_filter_lt">
                                	<label>Car Spaces</label>
                            		<select name="car_spaces" id="car_spaces">
									  <option selected="selected" value="Car Spaces">Car Spaces</option>
									  <option value="1">1 car space</option>
									  <option value="1plus">1 or more car spaces</option>
									  <option value="2">2 car spaces</option>
									  <option value="2plus">2 or more car spaces</option>
									  <option value="3">3 car spaces</option>
									  <option value="3plus">3 or more car spaces</option>
									</select>
                                </div>
                                <div class="m_filter_lt">
                                	<label>Stories</label>
                            		<select  id="floor_count" name="floor_count">
									<option selected="selected" value="Stories">Stories</option>
										<?php if(!empty($_REQUEST['property_type'])) { if($_REQUEST['property_type'] == 'Single-Storey') {  ?>
									  <option value="1" selected="selected">1 storey</option>
									  <?php } else { ?>
									   <option value="1">1 storey</option>
									  <?php } } else { ?>
									  <option value="1">1 storey</option>
									  <?php  }  ?>
									  
									  <?php if(!empty($_REQUEST['property_type'])) { if($_REQUEST['property_type'] == 'Double-Storey') {  ?>
									  <option value="2" selected="selected">2 stories</option>
									  <?php } else { ?>
									   <option value="2">2 stories</option>
									  <?php } } else { ?>
									  <option value="2">2 stories</option>
									  <?php  }  ?>
									  <option value="3">3 stories</option>
									</select>
                                </div>
                                <div class="m_filter_lt">
                                	<label>Alfresco</label>
                            		<select  name="alfresco" id="alfresco">
									  <option selected="selected" value="Alfresco">Alfresco</option>
									   <?php if(!empty($_REQUEST['property_type'])) { if($_REQUEST['property_type'] == 'Homes-With-Alfrescos') {  ?>
									  <option value="Yes" selected="selected">Has Alfresco</option>
									  <?php } else { ?>
									   <option value="Yes">Has Alfresco</option>
									  <?php } } else { ?>
									  <option value="Yes">Has Alfresco</option>
									  <?php  }  ?>
									  <option value="No">No Alfresco</option>
									</select>
                                </div>
								
                                <div class="clr"></div>
                            </div>
							 <div class="m_filter_row">
							 <div class="m_filter_lt">
                                	<label>Dual Occupancy</label>
                            		<select name="duplex" id="duplex">
									 <option selected="selected" value="duplex">Dual Occ</option>
									 <?php if(!empty($_REQUEST['property_type'])) { if($_REQUEST['property_type'] == 'Dual-occupancy-Homes') {  ?>
								  <option value="" selected="selected">Is Dual Occ</option>
								  <?php } else { ?>
								   <option value="Yes">Is Dual Occ</option>
								  <?php } } else { ?>
								  <option value="Yes">Is Dual Occ</option>
								  <?php  }  ?>
									 <option value="No">Not Dual Occ</option>
									</select>
                                </div>
							<div class="clr"></div>
							</div>							
                            
                        </div>
                        <div class="loc_left loc_rt">
                        	<h3 class="opt_title toggle-inc">Refine by popular inclusion</h3>
                            <ul class="inclusion filter-inc" style="display:none;">
                            		
			<?php if(!empty($inc_arr)) { foreach($inc_arr as $inc_val){ 
			$filter_inc_arr =  App\Inclusion::get_filter_inclusion($inc_val['id']) ;
			?>
            	<li><a href="javascript:void(0)" class="inc" rel="<?php echo $inc_val['id']  ; ?>" <?php if(empty($filter_inc_arr)) { echo 'style="background:none;"' ; } ?> id="inc_text_<?php echo $inc_val['id']  ; ?>"><?php  echo $inc_val['title']  ; ?></a>

				<div id="inc_<?php echo $inc_val['id']  ;  ?>" class="child_inc" style="display:none;">
				<?php 
					
				if(!empty($filter_inc_arr)) { 
				foreach($filter_inc_arr as $filter_val) {
					

				?>
				<p><input type="checkbox" value="<?php echo $filter_val['id'];  ?>" rel="<?php echo $inc_val['id']  ; ?>" name="filter_inclusion"><span><?php echo $filter_val['title'];  ?><span> </p>
				<?php } } ?>
				
				</div>
				
				</li>
                <?php   } } ?>
                            </ul>
                        </div>
                        <div class="clr"></div>
                    </div><!--row section!--> 
                    
                </div>
            </div>
			
			
			 	<div class="search_lt"><!--left section!-->
  
            
            <div class="prop_main"><!--property display!-->
            	<div class="sort_sec">
                	<label>House & land</label>
                    <a href="#" class="hnumber prop_count"><?php if(!empty($total_prop)) { echo $total_prop ; } else { echo '0' ; } ?></a><br />
                    <label>Sort by</label>
                  <select id="sort_prop">
                    <option selected="selected" value="Select" >Select</option>
					<option value="base_price:asc">Price: low to high</option>
					<option value="base_price:desc">Price: high to low</option>
					<option value="model_name:asc">House name: A-Z</option>
					<option value="model_name:desc">House name: Z-A</option>
					<option value="builder_name:asc">Builder name: A-Z</option>
					<option value="builder_name:desc">Builder name: Z-A</option>
                  </select>
                </div>	
            	
                <div class="wrappar">
				<div id="ajax_content">
				<div id="ajaxloader"></div>
					<?php  
		
	 	/* echo '<pre>';
		print_r($properties_arr);   */
		if(!empty($properties_arr)) {
		foreach($properties_arr as $prop_val) {
		
		?>
            <div class="featured-box search-featured-box">
                <div class="featured-image">
                    <div class="featured-strip">
                        <div class="featured-strip-box"><a href="javascript:void(0);" class="open_quicklook"   data-target='.quick-look-modal' data-id = '<?php echo $prop_val['id']; ?>'><img src="<?php echo url(); ?>/assets/images/featured-strip-icon1.png" alt="featured" /><span>View</span></a></div>
                        <div class="featured-strip-box"><a class="open_enquirybox" value="Enquire to Builders"  data-target='.bs-example-modal-lg' data-id = '<?php echo $prop_val['id']; ?>'  href='javascript:void(0);' data-toggle='modal'><img src="<?php echo url(); ?>/assets/images/featured-strip-icon2.png" alt="featured" /><span>Enquire</span></a></div>
                                               <div class="featured-strip-box">
						<?php  $check_save_prop =  App\Models\SaveProperty::check_save_prop($prop_val['id']) ;  ?>
						<a href="javascript:void(0);" rel="<?php echo $prop_val['id']; ?>" class="save_property" >
						<?php  if($check_save_prop != '0') { ?><img src="<?php echo url(); ?>/assets/images/featured-strip-icon-blue.png" alt="featured" id="compare_src_<?php echo $prop_val['id']; ?>" /><?php } else { ?>
						<img src="<?php echo url(); ?>/assets/images/featured-strip-icon3.png" id="compare_src_<?php echo $prop_val['id']; ?>" alt="featured" /><?php } ?><span id="save_text_<?php echo $prop_val['id']; ?>"></span><span><?php  if($check_save_prop != '0') { echo 'Compared' ; } else { echo 'Compare' ; } ?></span></a>
						<input type="hidden" value="<?php  if($check_save_prop != '0') { echo 'Compared' ; } else { echo 'Compare' ; } ?>" id="comp_text_<?php echo $prop_val['id']; ?>"/> 
						</div>
                        <div class="featured-strip-box"></div>
                    </div>
					<div class="star">
				<?php  $check_save_prop =  App\Models\SaveProperty::check_new_save_prop($prop_val['id']) ;  ?>
                            	<a href="javascript:void(0);" rel="<?php echo $prop_val['id']; ?>" class="save_property_new" ><?php  if($check_save_prop != '0') { ?><img src="{{ URL::asset('assets/img/star_hover.png') }}" data-save_<?php echo $prop_val['id'];  ?>="Saved" id="save_src_<?php echo $prop_val['id']; ?>"><?php } else { ?><img src="{{ URL::asset('assets/img/star.png') }}" data-save_<?php echo $prop_val['id'];  ?>="Save" id="save_src_<?php echo $prop_val['id']; ?>"><?php } ?></a>
				</div>
					 <div class="model_img">
					<?php  
					
					if(!empty($prop_val['property_gallery'])) {
						foreach($prop_val['property_gallery'] as $prop_img) {
						
							echo '<a href="'.url().'/propertydetail/'.$prop_val['id'].'"><img src="'.url().'/uploads/property_gallery/'.$prop_img['image'].'" class="img-full" /></a>';
						}
					
					} else {
					
					echo '<a href="'.url().'/propertydetail/'.$prop_val['id'].'"><img src="'.url().'/assets/img/no-image.jpg" class="img-full" /></a>';
					}
					
					?>
								
				</div>
                </div>
                <div class="featured-box-btm">
                    <ul>
                        <li><span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/bed-icon.png" alt="Beds" /></a></span><p><span><?php  echo $prop_val['bedrooms'] ; ?></span> Beds</p></li>
                        <li><span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/bath-icon.png" alt="Beds" /></a></span><p><span><?php  echo $prop_val['bathrooms'] ; ?></span> Bath</p></li>
                        <li><span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/living-icon.png" alt="Beds" /></a></span><p><span><?php  echo $prop_val['living'] ; ?></span> Living</p></li>
                        <li><span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/area-icon.png" alt="Beds" /></a></span><p><span><?php  echo $prop_val['housesize'] ; ?></span> Sq</p></li>
                    </ul>
                    <div class="featured-price">
					<h4><?php echo $prop_val['property_title']; ?></h4>
                        <p>From $<?php  echo number_format($prop_val['price'],2) ; ?></p>
						<img src="<?php echo url(); ?>/uploads/builder_logo/<?php echo $prop_val['builder_detail']['logo']; ?>" class="featured-logo" alt="image"/>
                    </div>
                    
                    <h5><?php  if(!empty($prop_val['description'])) {  $string = strip_tags($prop_val['description']);

if (strlen($string) > 115) {

    // truncate string
    $stringCut = substr($string, 0, 115);

    // make sure it ends in a word so assassinate doesn't become ass...
    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
}
echo $string; ; } ?></h5>
                </div>
            </div>

            
			
			<?php } } else {  echo '<h2>No results</h2><br/><p>
There are no products matching your search criteria. Try making your filters less specific.</p>' ;  } ?>
<div class="clr"></div>
<ul class="pagination">
		<?php 


$ptemp = url().'/house-and-lands?';
		 $pages = '';

//echo $_REQUEST['po_no'];
	if(!empty($_REQUEST['search_region'])) $whereArr1[] = 'search_region='.$_REQUEST['search_region'];
	if(!empty($_REQUEST['property_type'])) $whereArr1[] = 'property_type='.$_REQUEST['property_type'];
	if(!empty($_REQUEST['bedrooms'])) $whereArr1[] = 'bedrooms='.$_REQUEST['bedrooms'];
	if(!empty($_REQUEST['bathrooms'])) $whereArr1[] = 'bathrooms='.$_REQUEST['bathrooms'];
	if(!empty($_REQUEST['builder'])) $whereArr1[] = 'builder='.$_REQUEST['builder'];
	if(!empty($_REQUEST['min_price'])) $whereArr1[] = 'min_price='.$_REQUEST['min_price'];
	if(!empty($_REQUEST['max_price'])) $whereArr1[] = 'max_price='.$_REQUEST['max_price'];
	if(!empty($_REQUEST['main_regionchange'])) $whereArr1[] = 'main_regionchange='.$_REQUEST['main_regionchange'];
	if(!empty($whereArr1)) {
		$whereStr1 = implode("&", $whereArr1);
		}
	if(!empty($whereStr1))
	{
		$whereStr1 = '&'.$whereStr1;
	} else {
		$whereStr1="";
	
	}
//echo $whereStr;
	if ($currentpage != 1) 
{ //GOING BACK FROM PAGE 1 SHOULD NOT BET ALLOWED
 $previous_page = $currentpage - 1;
 //$previous = '<a href="'.$ptemp.'?pageno='.$previous_page.'"> </a> '; 
$previous = '&lt;Previous' ;
 $pages .= '<li><a href="'.$ptemp.'page='.$previous_page.$whereStr1.'">'. $previous .'</a></li>'; 
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
            $pages.= "<li><a  href=\"" . $ptemp ."page=".$i.$whereStr1. "\"  rel=".$i.">" . $i . "</a>\n</li>";
        } else {
            $pages.= "<li><a  href=\"" . $ptemp . "page=" . $i .$whereStr1. "\"  rel=".$i." >" . $i . "</a>\n</li>";
        }
    }
    

//$pages = substr($pages,0,-1); //REMOVING THE LAST COMMA (,)

if($currentpage != $lastpage) 
{

 //GOING AHEAD OF LAST PAGE SHOULD NOT BE ALLOWED
 $next_page = $currentpage + 1;
 $next = 'Next&gt;';
 $pages .= '<li><a href="'.$ptemp.'page='.$next_page.$whereStr1.'">'. $next .'</a></li>';

}

if(!empty($numrows)) {
echo   $pages ; //PAGINATION LINKS
}

		?>
	</ul>	


</div>
        </div>
                    
            </div><!--property display!-->
            
    	</div><!--left section!-->
		
		<div class="search_rt"><!--right section!-->
    		<h3>Call our free and independent home building consultant now</h3>
            <div class="rt_phone">
            	<img src="{{ URL::asset('assets/images/phone.png') }}" />
                <h1>1800 824 823</h1>
            </div>
			<?php if(!empty($testimonials)) { ?>
            <div class="testi_sec"><!--testimonoal section!-->
            	<div class="testi_ico"><img src="{{ URL::asset('assets/images/testi_ico.png') }}" alt="" /></div>
                <p><?php  echo $testimonials[0]->description; ?></p>
                <p><strong><?php  echo $testimonials[0]->created_by; ?><br /><?php  echo $testimonials[0]->state_company; ?></strong></p>
                <a href="<?php echo url(); ?>/testimonials">Read more</a>
            </div><!--testimonoal section!-->
            <?php } ?>
			
            <h3>How'd we go? Would you recommend iCompareBuilders? </h3>
            <div class="rating_box"><!--rating box!-->
            	<p>1 = very unlikely 10 = most likely</p>
                <div class="rt_star">
				<a href="javascript:void(0)" class="rate" rel="1"><img src="<?php echo url(); ?>/assets/images/dim-star.png"  onmouseover="this.src='<?php echo url(); ?>/assets/images/light-star.png'" onmouseout="this.src='<?php echo url(); ?>/assets/images/dim-star.png'" /></a> 
				<a href="javascript:void(0)" class="rate" rel="2"><img src="<?php echo url(); ?>/assets/images/dim-star.png" onmouseover="this.src='<?php echo url(); ?>/assets/images/light-star.png'" onmouseout="this.src='<?php echo url(); ?>/assets/images/dim-star.png'" /></a> 
				<a href="javascript:void(0)" class="rate" rel="3"><img src="<?php echo url(); ?>/assets/images/dim-star.png" onmouseover="this.src='<?php echo url(); ?>/assets/images/light-star.png'" onmouseout="this.src='<?php echo url(); ?>/assets/images/dim-star.png'" /></a> 
				<a href="javascript:void(0)" class="rate" rel="4"><img src="<?php echo url(); ?>/assets/images/dim-star.png" onmouseover="this.src='<?php echo url(); ?>/assets/images/light-star.png'" onmouseout="this.src='<?php echo url(); ?>/assets/images/dim-star.png'"/></a> 
				<a href="javascript:void(0)" class="rate" rel="5"><img src="<?php echo url(); ?>/assets/images/dim-star.png" onmouseover="this.src='<?php echo url(); ?>/assets/images/light-star.png'" onmouseout="this.src='<?php echo url(); ?>/assets/images/dim-star.png'"/></a> 
				<a href="javascript:void(0)" class="rate" rel="6"><img src="<?php echo url(); ?>/assets/images/dim-star.png" onmouseover="this.src='<?php echo url(); ?>/assets/images/light-star.png'" onmouseout="this.src='<?php echo url(); ?>/assets/images/dim-star.png'"/></a> 
				<a href="javascript:void(0)" class="rate" rel="7"><img src="<?php echo url(); ?>/assets/images/dim-star.png" onmouseover="this.src='<?php echo url(); ?>/assets/images/light-star.png'" onmouseout="this.src='<?php echo url(); ?>/assets/images/dim-star.png'" /></a>
				<a href="javascript:void(0)" class="rate" rel="8"><img src="<?php echo url(); ?>/assets/images/dim-star.png" onmouseover="this.src='<?php echo url(); ?>/assets/images/light-star.png'" onmouseout="this.src='<?php echo url(); ?>/assets/images/dim-star.png'" /></a>
				<a href="javascript:void(0)" class="rate" rel="9"><img src="<?php echo url(); ?>/assets/images/dim-star.png" onmouseover="this.src='<?php echo url(); ?>/assets/images/light-star.png'" onmouseout="this.src='<?php echo url(); ?>/assets/images/dim-star.png'"/></a>
				<a href="javascript:void(0)" class="rate" rel="10"><img src="<?php echo url(); ?>/assets/images/dim-star.png" onmouseover="this.src='<?php echo url(); ?>/assets/images/light-star.png'" onmouseout="this.src='<?php echo url(); ?>/assets/images/dim-star.png'"/></a>
				</div>
            </div><!--rating box!-->
           		<?php 
			if(!empty($search_verticle_ads)) {   foreach($search_verticle_ads as $ads_val) { 
			?> <div class="add_box"><img src="<?php echo url(); ?>/uploads/add_management/<?php echo $ads_val['image']; ?>" /></div>
			<?php } } ?>
    	</div><!--right section!-->
    	<div class="clr"></div>
    </div>
</div>

<div class="featured partners-wrap">
<div class="container">
    <h2><span>I</span><span>our</span> Buildings partners</h2>
    <a href="<?php echo url(); ?>/ourbuilders" class="view-btn">View all Designs</a>
</div>
<div class="partners">
    <div class="container builder-carasouel">
	<?php 
	if(!empty($builder_detail_arr)) {
	foreach($builder_detail_arr as $builder_logo) {
	?>
            <div class="partners-box"><a href="<?php echo url(); ?>/builder-detail/<?php echo $builder_logo->builder_id; ?>"><img src="<?php echo url();?>/uploads/builder_logo/<?php echo $builder_logo->logo; ?>" alt="partners" /></a></div>
          <?php } } ?>
            <div class="clr"></div>
    </div>
</div>
</div>
		
 @include('common-modal')
  <style>
  #loading-indicator img {left: 50%;position: absolute;top: 50%;transform: translateX(-50%) translateY(-50%);z-index: 99999;}
  #loading-indicator::after {background: rgba(0, 0, 0, 0.898) none repeat scroll 0 0;content: "";height: 100%;left: 0;position: absolute;right: 0;top: 0;width: 1500px;z-index: 9999;}
  </style>
  <div id='loading-indicator' style=" display: none;">
    <img src="{{ URL::asset('assets/img/loading-x.gif') }}" alt="search">
</div>


@stop
