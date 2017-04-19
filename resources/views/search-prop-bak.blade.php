@extends('layout.default')

@section('content')	
<?php
$custommin_price = 50000;
$custommax_price = 400000;
$custommin_block_width = 5;
$custommax_block_width = 20;
$custommin_block_length = 10;
$custommax_block_length = 40;
$custommin_house_size = 5;
$custommax_house_size = 50;
?>
<!-----------new select 5 Jan 2016 ------------>
<div class="mobile-search">
<a href="javascript:void(0)" id="mobile-div">Refine Search</a>
<button class="prop_count"><?php if(!empty($total_prop)) { echo $total_prop ; } else { echo '0' ; } ?></button>
</div>
 <div class="step-indecator">
     <div class="step-search"><img src="{{ URL::asset('assets/img/search_ico_new.png') }}" />
</div>
     <div class="container search_title">
         <ul>
             <li>1. Search</li>
             <li>2. Compare</li>
             <li>3. Enquire</li>
			 <li>Save</li>
         </ul>
     </div>
 </div>
 <!-----------new select 5 Jan 2016 ------------>


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
		
	<div class="list_left"><!--left section!-->
    	<div class="filter_sec">
        	<h2>Refine your search</h2>
			<input type="hidden" name="house_lands" value="search_property_page" id="house_lands"/>
            <div class="select_box"><!--copyable text!-->
            	<i><img src="{{ URL::asset('assets/img/location.png') }}" /></i>
            	<select class="selectpicker" name="build_location" id ="build_location">
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
            </div><!--copyable text!-->
             <div class="select_box"><!--copyable text!-->
             <i><img src="{{ URL::asset('assets/img/bed-green.png') }}" /></i>
            	<select class="selectpicker" name="bedrooms" id="bedrooms">
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

            </div><!--copyable text!-->
             <div class="select_box"><!--copyable text!-->
             <i><img src="{{ URL::asset('assets/img/bathroom.png') }}" /></i>
            	<select class="selectpicker" id="bathrooms" name="bathrooms">
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
            </div><!--copyable text!-->
             <div class="select_box"><!--copyable text!-->
             <i><img src="{{ URL::asset('assets/img/house-size.png') }}" /></i>
            	<select class="selectpicker" id="living_spaces" name="living_spaces">
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
            </div><!--copyable text!-->
             <div class="select_box"><!--copyable text!-->
             <i><img src="{{ URL::asset('assets/img/car.png') }}" /></i>
            	<select class="selectpicker" name="car_spaces" id="car_spaces">
                  <option selected="selected" value="Car Spaces">Car Spaces</option>
				  <option value="1">1 car space</option>
				  <option value="1plus">1 or more car spaces</option>
				  <option value="2">2 car spaces</option>
				  <option value="2plus">2 or more car spaces</option>
				  <option value="3">3 car spaces</option>
				  <option value="3plus">3 or more car spaces</option>
                </select>
            </div><!--copyable text!-->
             <div class="select_box"><!--copyable text!-->
              <i><img src="{{ URL::asset('assets/img/story.png') }}" /></i>
            	<select class="selectpicker" id="floor_count" name="floor_count">
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
            </div><!--copyable text!-->
             <div class="select_box"><!--copyable text!-->
             <i><img src="{{ URL::asset('assets/img/alfresco.png') }}" /></i>
            	<select class="selectpicker" name="alfresco" id="alfresco">
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
            </div><!--copyable text!-->
            
             <div class="select_box" style='display:none;'><!--copyable text!-->
              <i><img src="{{ URL::asset('assets/img/dual-occ.png') }}" /></i>
            	<select class="selectpicker" name="duplex" id="duplex">
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
            </div><!--copyable text!-->
             <div class="select_box"><!--copyable text!-->
              <i><img src="{{ URL::asset('assets/img/sp-builder.png') }}" /></i>
            	<select class="selectpicker" id="spe-builder">
                  <option value="Specific Builder">Specific Builder</option>
				 <?php  if(!empty($builder_arr)) {  
						foreach($builder_arr as $build_val) {
						if(!empty($_REQUEST['builder'])) {
						if($build_val['builder_id'] == $_REQUEST['builder']) {
				 ?>
                  <option value="<?php echo $build_val['builder_id']; ?>" selected="selected"><?php echo $build_val['company_name']; ?></option>
				  <?php } else {  ?> <option value="<?php echo $build_val['builder_id']; ?>"><?php echo $build_val['company_name']; ?></option>   <?php  } } else { ?> <option value="<?php echo $build_val['builder_id']; ?>"><?php echo $build_val['company_name']; ?></option>   <?php } } } ?>
                </select>
            </div><!--copyable text!-->
            
            <div class="range_sec"><!--range bar!-->
            	<h4><img src="{{ URL::asset('assets/img/price-range.png') }}"> Price Range ($)</h4>
				<div class="noUiSlider" id="price_range"></div>
				<span id="price-lower-value" class="example-val"></span>
				<span id="price-lower-offset"></span>
				<span id="price-upper-value" class="example-val"></span>
				<span id="price-upper-offset"></span>
				<input type="hidden" name="min_price" value="<?php echo $custommin_price ; ?>" id="min_price" />
				<input type="hidden" name="max_price" value="<?php echo $custommax_price ; ?>" id="max_price" />
				<input type="hidden" name="filter_min_price" value="" id="filter_min_price" />
				<input type="hidden" name="filter_max_price" value="" id="filter_max_price" />
            </div><!--range bar!-->
			
            
            <div class="range_sec"><!--range bar!-->
            	<h4><i class="fa fa-arrows-h"></i> Min. Block width (m)</h4>
				<div class="noUiSlider" id="min-block-width"></div>
				<span id="width-lower-value" class="example-val"></span>
				<span id="width-lower-offset"></span>
				<span id="width-upper-value" class="example-val"></span>
				<span id="width-upper-offset"></span>
				<input type="hidden" name="min_block_width" value="<?php echo $custommin_block_width ; ?>" id="min_block_width" />
				<input type="hidden" name="max_block_width" value="<?php echo $custommax_block_width ; ?>" id="max_block_width" />
				<input type="hidden" name="filter_min_width" value="" id="filter_min_width" />
				<input type="hidden" name="filter_max_width" value="" id="filter_max_width" />
            </div><!--range bar!-->
            
             <div class="range_sec"><!--range bar!-->
            	<h4><i class="fa fa-arrows-v"></i> Min. Block length (m)</h4>
				<div class="noUiSlider" id="min-block-length"></div>
				<span id="length-lower-value" class="example-val"></span>
				<span id="length-lower-offset"></span>
				<span id="length-upper-value" class="example-val"></span>
				<span id="length-upper-offset"></span>
				<input type="hidden" name="min_block_length" value="<?php echo $custommin_block_length ; ?>" id="min_block_length" />
				<input type="hidden" name="max_block_length" value="<?php echo $custommax_block_length ; ?>" id="max_block_length" />
				<input type="hidden" name="filter_min_length" value="" id="filter_min_length" />
				<input type="hidden" name="filter_max_length" value="" id="filter_max_length" />
            </div><!--range bar!-->
            
            <div class="range_sec"><!--range bar!-->
            	<h4><i class="fa fa-arrows-alt"></i> House size</h4>
				<div class="noUiSlider" id="house-size"></div>
				<span id="size-lower-value" class="example-val"></span>
				<span id="size-lower-offset"></span>
				<span id="size-upper-value" class="example-val"></span>
				<span id="size-upper-offset"></span>
				<input type="hidden" name="min_house_size" value="<?php echo $custommin_house_size ; ?>" id="min_house_size" />
				<input type="hidden" name="max_house_size" value="<?php echo $custommax_house_size ; ?>" id="max_house_size" />
				<input type="hidden" name="filter_min_hsize" value="" id="filter_min_hsize" />
				<input type="hidden" name="filter_max_hsize" value="" id="filter_max_hsize" />
            </div><!--range bar!-->
            
            <h3>Refine by popular inclusion <i class="fa fa-info-circle"></i></h3>
            <ul class="refine_sec">
		
			
			<?php if(!empty($inc_arr)) { foreach($inc_arr as $inc_val){ ?>
            	<li><a href="javascript:void(0)" class="inc" rel="<?php echo $inc_val['id']  ; ?>" id="inc_text_<?php echo $inc_val['id']  ; ?>"><?php  echo $inc_val['title']  ; ?></a>

				<div id="inc_<?php echo $inc_val['id']  ;  ?>" class="child_inc" style="display:none;">
				<?php 
					$filter_inc_arr =  App\Inclusion::get_filter_inclusion($inc_val['id']) ;
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
        <?php // if(!empty($ads_arr)) { ?>
        <div class="rate_main">
       <h3>How'd we go? Would you recommend iCompareBuilders? <p> 0 = very unlikely 10 = most likely</p></h3>
            <ul class="rate_smiley">
                <li><a href="javascript:void(0)" class="rate" rel="0">0</a></li>
                <li><a href="javascript:void(0)" class="rate" rel="1">1</a></li>
                <li><a href="javascript:void(0)" class="rate" rel="2">2</a></li>
                <li><a href="javascript:void(0)" class="rate" rel="3">3</a></li>
                <li><a href="javascript:void(0)" class="rate" rel="4">4</a></li>
                <li><a href="javascript:void(0)" class="rate" rel="5">5</a></li>
                <li><a href="javascript:void(0)" class="rate" rel="6">6</a></li>
                <li><a href="javascript:void(0)" class="rate" rel="7">7</a></li>
                <li><a href="javascript:void(0)" class="rate" rel="8">8</a></li>
                <li><a href="javascript:void(0)" class="rate" rel="9">9</a></li>
                <li><a href="javascript:void(0)" class="rate" rel="10">10</a></li>
            </ul>
        </div>
        <!--<div class="add_model"><!--add section!-->
		<?php // foreach($ads_arr as $ads_val) { ?>
        	<!--<h3>Get your free</h3>
            <!--<div class="add_photo"><!--<div class="add_text"><h4>$<span>20</span> Voucher</h4></div> <div class="voucher-offer__plus"><span>plus</span></div>--> <!--<img src="<?php //echo url(); ?>/uploads/add_management/<?php //echo $ads_val['image']; ?>" /></div>
            <p>Our independent home building guide with expert tips to save you time and money</p>
			<?php // }   ?>
            <!--<div class="book"><img src="{{ URL::asset('assets/img/book.png') }}" /></div>
            <div class="enq_btn">When you enquire through icompare today. </div>-->
        <!--</div><!--add section!-->
        <?php //} ?>
    </div><!--left section!-->
    <div class="list_mid"><!--middle section!-->
    	<div class="white_mid"><!--white box!-->
        	<div class="t_listleft"><span class="prop_count"><?php if(!empty($total_prop)) { echo $total_prop ; } else { echo '0' ; } ?></span> Home Designs</div>
            <div class="t_listright">
            	<span class="list-text">Sort by:</span>
                <div class="list_by">
                	<select class="selectpicker" id="sort_prop">
                     	<option selected="selected" value="Select" >Select</option>
					<option value="base_price:asc">Price: low to high</option>
					<option value="base_price:desc">Price: high to low</option>
					<option value="model_name:asc">House name: A-Z</option>
					<option value="model_name:desc">House name: Z-A</option>
					<option value="builder_name:asc">Builder name: A-Z</option>
					<option value="builder_name:desc">Builder name: Z-A</option>
                	</select>
					
                </div>
                <div class="clr"></div>
            </div>
            <div class="clr"></div>
        </div><!--white box!-->
		
		<div id="ajax_content">
				<div id="ajaxloader"></div>
			<?php  
		
	 	/* echo '<pre>';
		print_r($properties_arr);   */
		if(!empty($properties_arr)) {
		foreach($properties_arr as $prop_val) {
		
		?>

        <div class="grey_bg"><!--white box!-->
        	<div class="model_left">
            	<div class="star">
				<?php  $check_save_prop =  App\Models\SaveProperty::check_new_save_prop($prop_val['id']) ;  ?>
                            	<a href="javascript:void(0);" rel="<?php echo $prop_val['id']; ?>" class="save_property_new" ><?php  if($check_save_prop != '0') { ?><img src="{{ URL::asset('assets/img/star_hover.png') }}" data-save_<?php echo $prop_val['id'];  ?>="Saved" id="save_src_<?php echo $prop_val['id']; ?>"><?php } else { ?><img src="{{ URL::asset('assets/img/star.png') }}" data-save_<?php echo $prop_val['id'];  ?>="Save" id="save_src_<?php echo $prop_val['id']; ?>"><?php } ?></a>
				</div>
            	<div class="model_img">
				<?php  
				
				if(!empty($prop_val['property_gallery'])) {
					foreach($prop_val['property_gallery'] as $prop_img) {
					
						echo '<a href="'.url().'/propertydetail/'.$prop_val['id'].'"><img src="'.url().'/uploads/property_gallery/'.$prop_img['image'].'" /></a>';
					}
				
				} else {
				
				echo '<a href="'.url().'/propertydetail/'.$prop_val['id'].'"><img src="'.url().'/assets/img/no-image.jpg" /></a>';
				}
				
				?>
				
				</div>
            </div>
            <div class="model_right"><!--right section!-->
            	<a href="<?php echo url(); ?>/builder-detail/<?php echo $prop_val['builder_detail']['builder_id']; ?>"><div class="c_logo"><?php if(!empty($prop_val['builder_detail']['logo'])) { ?><img src="<?php echo url(); ?>/uploads/builder_logo/<?php echo $prop_val['builder_detail']['logo']; ?>"><?php  } ?></div></a>
            	<a href="<?php echo url(); ?>/propertydetail/<?php echo $prop_val['id']; ?>"><h4><?php  echo $prop_val['property_title'] ; ?></h4></a>
                <h5>From $<?php  echo number_format($prop_val['price'],2) ; ?> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="The price or price range shown here is indicative only and will vary depending on the final inclusions, location of the build, the house façade and other customisations selected."></i></h5>
                <ul class="icon_set i_set2">
                 	<li>
                            	<i><img src="{{ URL::asset('assets/img/bed.png') }}"> <span><em><?php  echo $prop_val['bedrooms'] ; ?></em> beds</span></i>
                             </li>
                           <li>
                            	<i><img src="{{ URL::asset('assets/img/bath.png') }}"> <span><em><?php  echo $prop_val['bathrooms'] ; ?></em> bath</span></i>
                             </li>
                            <li>
                            	<i><img src="{{ URL::asset('assets/img/sofa.png') }}"> <span><em><?php  echo $prop_val['living'] ; ?></em> living</span></i>
                             </li>
                           <li>
                            	<i><img src="{{ URL::asset('assets/img/size.png') }}"> <span><em><?php  echo $prop_val['housesize'] ; ?></em> sq </span></i>
                             </li>       	
                 </ul>
                 <p><?php  if(!empty($prop_val['description'])) {  $string = strip_tags($prop_val['description']);

if (strlen($string) > 125) {

    // truncate string
    $stringCut = substr($string, 0, 125);

    // make sure it ends in a word so assassinate doesn't become ass...
    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
}
echo $string; ; } ?> </p>
                 <ul class="button_set">
                        	<li>
							<a href="javascript:void(0);" class="open_quicklook"   data-target='.quick-look-modal' data-id = '<?php echo $prop_val['id']; ?>'><img src="{{ URL::asset('assets/img/quick.png') }}" class="quick-img">Quick View</a>
                            </li>
                            <li>
                            	<a  class="open_enquirybox" value="Enquire to Builders"  data-target='.bs-example-modal-lg' data-id = '<?php echo $prop_val['id']; ?>'  href='javascript:void(0);' data-toggle='modal'><img src="{{ URL::asset('assets/img/message.png') }}">Enquire</a>
                            </li>
                            <li>
							<?php  $check_save_prop =  App\Models\SaveProperty::check_save_prop($prop_val['id']) ;  ?>
                            	<a href="javascript:void(0);" rel="<?php echo $prop_val['id']; ?>" class="save_property" ><?php  if($check_save_prop != '0') { ?><img src="{{ URL::asset('assets/img/comapre_hover.png') }}" id="compare_src_<?php echo $prop_val['id']; ?>"><?php } else { ?><img src="{{ URL::asset('assets/img/comapre.png') }}" id="compare_src_<?php echo $prop_val['id']; ?>"><?php } ?><span id="save_text_<?php echo $prop_val['id']; ?>"><?php  if($check_save_prop != '0') { echo 'Compared' ; } else { echo 'Compare' ; } ?></span></a>
                            </li>
                        </ul>
            </div><!--right section!-->
            <div class="clr"></div>
        </div>
  
		<?php } } else {  echo '<h2>No results</h2><br/><p>
There are no products matching your search criteria. Try making your filters less specific.</p>' ;  } ?>
 <ul class="pagination">
		<?php 


$ptemp = url().'/property/search-property?';
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
		
					<?php if(!empty($search_horizontal_ads)) { ?>
        <div class="add_model horizontal_ad"><!--add section!-->
        <?php  foreach($search_horizontal_ads as $ads_val) { ?>
        	<!--<h3>Get your Free Building Guide when you Enquire</h3>-->
            <div class="add_photo"><!--<div class="add_text"><h4>$<span>20</span> Voucher</h4></div><div class="voucher-offer__plus"><span>plus</span></div>--><img src="<?php echo url(); ?>/uploads/add_management/<?php echo $ads_val['image']; ?>" /></div>
            <!--<p>Our independent home building guide with expert tips to save you time and money</p>-->
			<?php }   ?>
            <!--<div class="book"><img src="{{ URL::asset('assets/img/book.png') }}" /></div>
            <div class="enq_btn">When you enquire through icompare today. </div>-->
        </div><!--add section!-->
        <?php } ?>
		
    </div><!--middle section!-->
    <div class="list_right"><!--right section!-->
    	<div class="phone_sec"><!--phone section!-->
        	<p>Call our free and independent home
building consultant now</p>
            <div class="call"><em><img src="{{ URL::asset('assets/img/phone_ico.png') }}"></em> <span>1800 824 823</span></div>
        </div><!--phone section!-->
		<?php if(!empty($ads_arr)) { ?>
        <div class="add_model"><!--add section!-->
        <?php  foreach($ads_arr as $ads_val) { ?>
        	<h3>Get your Free Building Guide when you Enquire</h3>
            <div class="add_photo"><!--<div class="add_text"><h4>$<span>20</span> Voucher</h4></div><div class="voucher-offer__plus"><span>plus</span></div>--><img src="<?php echo url(); ?>/uploads/add_management/<?php echo $ads_val['image']; ?>" /></div>
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
			<?php 
			
			
			
			if(!empty($search_verticle_ads)) {


			?>
        <div class="add_model verticle_ad"><!--add section!-->
        <?php  foreach($search_verticle_ads as $ads_val) { ?>
        	<!--<h3>Get your Free Building Guide when you Enquire</h3>-->
            <div class="add_photo"><!--<div class="add_text"><h4>$<span>20</span> Voucher</h4></div><div class="voucher-offer__plus"><span>plus</span></div>--><img src="<?php echo url(); ?>/uploads/add_management/<?php echo $ads_val['image']; ?>" /></div>
            <!--<p>Our independent home building guide with expert tips to save you time and money</p>-->
			<?php }   ?>
            <!--<div class="book"><img src="{{ URL::asset('assets/img/book.png') }}" /></div>
            <div class="enq_btn">When you enquire through icompare today. </div>-->
        </div><!--add section!-->
        <?php } ?>
    </div><!--right section!-->
    <div class="clr"></div>
</section><!--property section!-->
 @include('common-modal')
  
  <style>
  #loading-indicator img {left: 50%;position: absolute;top: 50%;transform: translateX(-50%) translateY(-50%);z-index: 99999;}
  #loading-indicator::after {background: rgba(0, 0, 0, 0.898) none repeat scroll 0 0;content: "";height: 100%;left: 0;position: absolute;right: 0;top: 0;width: 1500px;z-index: 9999;}
  </style>
  <div id='loading-indicator' style=" display: none;">
    <img src="{{ URL::asset('assets/img/loading-x.gif') }}" alt="search">
</div>


@stop
