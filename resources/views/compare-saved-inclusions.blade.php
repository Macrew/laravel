@extends('layout.default')

@section('content')	

<!-----------new select 5 Jan 2016 ------------>
<div class="bread_crum"><!--bread crum section!-->
<ul>
<li><a href="<?php echo url(); ?>/property/search-property"><img src="{{ URL::asset('assets/images/search-ico.png') }}" alt="Search"  /></a></li>
<li><a href="javascript:void(0);"><img src="{{ URL::asset('assets/images/compare-ico.png') }}" onMouseOver="this.src='<?php echo url();?>/assets/images/compare-ico-h.png'" onMouseOut="this.src='<?php echo url();?>/assets/images/compare-ico.png'" alt="" /></a></li>
<li><a href="javascript:void(0);"><img src="{{ URL::asset('assets/images/enquire.png') }}" onMouseOver="this.src='<?php echo url();?>/assets/images/enquire_h.png'" onMouseOut="this.src='<?php echo url();?>/assets/images/enquire.png'" /></a></li>
</ul>
</div><!--bread crum section!-->
<div class="search_top"><!--top banner!-->
<h2>Your <span>Saved Homes</span></h2>
</div><!--top banner!-->
<!-----------new select 5 Jan 2016 ------------>


<section class="content"><!--property section!-->
	<div class='search_page container'>
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
		<input type="hidden" name="compare_ids" value="<?php echo $savepropids; ?>" id="compare_ids"/>
		<input type="hidden" name="save_compare_url" value="" id="save_compare_url"/>
		<input type="hidden" name="save_enquire_url" value="" id="save_enquire_url"/>

		<input type="hidden" name="save_home_compare_url" value="" id="save_home_compare_url"/>
		<input type="hidden" name="save_home_enquire_url" value="" id="save_home_enquire_url"/>
		<div class="search_lt"><!--middle section!-->
			<ul class="saved-tabs">
				<li class="save_active_tab" id="home-t"><a href="javascript:void(0)">Saved home designs (<?php echo !empty($total_save_home)?$total_save_home:'0'; ?>)</a></li>
				<li id="homeland-t"><a href="javascript:void(0)">Saved house & land (<?php echo !empty($total_save_home_land)?$total_save_home_land:'0'; ?>)</a></li>
			</ul>
			<div class="white_mid save_property_top"><!--white box!-->
				<div id="home-tab">
					<div class="t_listleft">
						<div class="cp-left save_sidebarcheck top_sidebarcheck">
							<div class='p_chk'>
								<input type="checkbox" name="saveallcheck" value="all" id="saveallcheck">
								<label for="saveallcheck"></label>
							</div>
							Select All
							
						</div>
					</div>
					<div class="t_listright">
						<!--<input type="submit" class="button1 save_compare" disabled value="Compare">-->
						<input type="submit" class="button1 save_enquire" disabled value="Enquire" class="open_enquirybox" value="Enquire to Builders"  data-target='.bs-example-modal-lg' data-id = ''  href='javascript:void(0);' data-toggle='modal'>
						<div class="clr"></div>
						<div class='warning_compare'></div>
					</div>
					<div class="clr"></div>
				</div>
				<div id="home-land-tab" style="display:none;">
					<div class="t_listleft">
						<div class="cp-left save_sidebarcheck top_sidebarcheck">
							<div class='p_chk'>
								<input type="checkbox" name="savehomeallcheck" value="all" id="savehomeallcheck">
								<label for="savehomeallcheck"></label>
							</div>
							Select All
						</div>
					</div>
					<div class="t_listright">
						<!--<input type="submit" class="button1 save_compare" disabled value="Compare">-->
						<input type="submit" class="button1 save_enquire" disabled value="Enquire" class="open_enquirybox" value="Enquire to Builders"  data-target='.bs-example-modal-lg' data-id = ''  href='javascript:void(0);' data-toggle='modal'>
						<div class="clr"></div>
						<div class='warning_compare'></div>
					</div>
					<div class="clr"></div>
				</div>
			</div><!--white box!-->
			<input type="hidden" name="enquire_ids" id="enquire_ids" value="" />
			<input type="hidden" name="enquireland_ids" id="enquireland_ids" value="" />

			<div id="ajaxloader"></div>
			<div id="home-design-data">
			<?php  

			/* echo '<pre>';
			print_r($properties_arr);   */
			if(!empty($properties_arr)) {
			foreach($properties_arr as $prop_val) {

			?>

			<div class="featured-box search-featured-box">
                <div class="featured-image">
                    <div class="featured-strip">
                        <div class="featured-strip-box">
							<a href="javascript:void(0);" class="open_quicklook"   data-target='.quick-look-modal' data-id = '<?php echo $prop_val['id']; ?>'>
								<img src="<?php echo url(); ?>/assets/images/featured-strip-icon1.png" alt="featured" />
								<span>View</span>
							</a>
						</div>
                        <div class="featured-strip-box">
							<a class="open_enquirybox" value="Enquire to Builders"  data-target='.bs-example-modal-lg' data-id = '<?php echo $prop_val['id']; ?>'  href='javascript:void(0);' data-toggle='modal'>
								<img src="<?php echo url(); ?>/assets/images/featured-strip-icon2.png" alt="featured" /><span>Enquire</span>
							</a>
							</div>
						<div class="featured-strip-box">
							<?php  $check_save_prop =  App\Models\SaveProperty::check_save_prop($prop_val['id']) ;  ?>
							<a href="javascript:void(0);" rel="<?php echo $prop_val['id']; ?>" class="save_property" >
								<?php  if($check_save_prop != '0') { ?><img src="<?php echo url(); ?>/assets/images/featured-strip-icon-blue.png" alt="featured" id="compare_src_<?php echo $prop_val['id']; ?>" /><?php } else { ?>
								<img src="<?php echo url(); ?>/assets/images/featured-strip-icon3.png" id="compare_src_<?php echo $prop_val['id']; ?>" alt="featured" /><?php } ?>
								<span id="save_text_<?php echo $prop_val['id']; ?>"></span><span>Compare</span>
							</a>
							<input type="hidden" value="<?php  if($check_save_prop != '0') { echo 'Compared' ; } else { echo 'Compare' ; } ?>" id="comp_text_<?php echo $prop_val['id']; ?>"/> 
						</div>
                    </div>
					<div class='filter_startchk'>
						<div class="cp-left save_sidebarcheck">
							<input type="checkbox" class="savelistcheckbox" name="savelistcheck" value="<?php echo $prop_val['id']; ?>" id="savelistcheck_<?php echo $prop_val['id']; ?>">
							<label for="savelistcheck_<?php echo $prop_val['id']; ?>"></label>
						</div>
						<div class="star">
							<?php  
							$check_save_prop =  App\Models\SaveProperty::check_new_save_prop($prop_val['id']) ;  ?>
							<a href="javascript:void(0);" rel="<?php echo $prop_val['id']; ?>" class="save_property_new" ><?php  if($check_save_prop != '0') { ?>
								<img src="{{ URL::asset('assets/img/star_hover.png') }}" data-save_<?php echo $prop_val['id'];  ?>="Saved" id="save_src_<?php echo $prop_val['id']; ?>"><?php } else { ?>
								<img src="{{ URL::asset('assets/img/star.png') }}" data-save_<?php echo $prop_val['id'];  ?>="Save" id="save_src_<?php echo $prop_val['id']; ?>"><?php } ?>
							</a>
						</div>
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
                        <li>
							<span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/bed-icon.png" alt="Beds" /></a></span>
							<p><span><?php  echo $prop_val['bedrooms'] ; ?></span> Beds</p>
						</li>
                        <li>
							<span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/bath-icon.png" alt="Beds" /></a></span>
							<p><span><?php  echo $prop_val['bathrooms'] ; ?></span> Bath</p>
						</li>
                        <li>
							<span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/living-icon.png" alt="Beds" /></a></span>
							<p><span><?php  echo $prop_val['living'] ; ?></span> Living</p>
						</li>
                        <li>
							<span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/area-icon.png" alt="Beds" /></a></span><p>
							<span><?php  echo $prop_val['housesize'] ; ?></span> Sq</p>
						</li>
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
						echo $string; ; } ?>
					</h5>
                </div>
            </div>
			<?php } } else {  echo '<h2>No results</h2><br/><p>
			You have no saved homes. <a href="'.url().'/property/search-property">Back to search.</a></p>' ;  } ?>
			</div>

			<div id="house-land-design" style="display:none;">
			<?php  

			/*  echo '<pre>';
			print_r($saved_home_land_arr);   */
			if(!empty($saved_home_land_arr)) {
			foreach($saved_home_land_arr as $prop_val) {

			?>

			<div class="featured-box search-featured-box">
                <div class="featured-image">
                    <div class="featured-strip">
                        <div class="featured-strip-box">
						<a href="javascript:void(0);" class="open_quicklook"   data-target='.quick-look-modal' data-id = '<?php echo $prop_val['id']; ?>'>
							<img src="<?php echo url(); ?>/assets/images/featured-strip-icon1.png" alt="featured" /><span>View</span></a>
						</div>
                        <div class="featured-strip-box">
							<a class="open_enquirybox" value="Enquire to Builders"  data-target='.bs-example-modal-lg' data-id = '<?php echo $prop_val['id']; ?>'  href='javascript:void(0);' data-toggle='modal'>
								<img src="<?php echo url(); ?>/assets/images/featured-strip-icon2.png" alt="featured" />
								<span>Enquire</span>
							</a>
						</div>
                        <div class="featured-strip-box">
							<?php  $check_save_prop =  App\Models\SaveProperty::check_new_save_prop($prop_val['id']) ;  ?>
							<a href="javascript:void(0);" rel="<?php echo $prop_val['id']; ?>" class="save_property" >
								<?php  
								if($check_save_prop != '0') { ?>
									<img src="<?php echo url(); ?>/assets/images/featured-strip-icon-blue.png" alt="featured" id="compare_src_<?php echo $prop_val['id']; ?>" /><?php 
								}
								else { ?>
									<img src="<?php echo url(); ?>/assets/images/featured-strip-icon3.png" id="compare_src_<?php echo $prop_val['id']; ?>" alt="featured" /><?php 
								} ?>
								<span id="save_text_<?php echo $prop_val['id']; ?>"></span><span>Compare</span>
							</a>
							<input type="hidden" value="<?php  if($check_save_prop != '0') { echo 'Compared' ; } else { echo 'Compare' ; } ?>" id="comp_text_<?php echo $prop_val['id']; ?>"/> 
						</div>
                    </div>
					<div class='filter_startchk'>
						<div class="cp-left save_sidebarcheck">
							<input type="checkbox" class="savehomelistcheckbox" name="savehomelistcheck" value="<?php echo $prop_val['id']; ?>" id="savehomelistcheck<?php echo $prop_val['id']; ?>">
							<label for="savehomelistcheck<?php echo $prop_val['id']; ?>"></label>
						</div>
						<div class="star">
							<?php  
							$check_save_prop =  App\Models\SaveProperty::check_new_save_prop($prop_val['id']) ;  ?>
							<a href="javascript:void(0);" rel="<?php echo $prop_val['id']; ?>" class="save_property_new" ><?php  if($check_save_prop != '0') { ?><img src="{{ URL::asset('assets/img/star_hover.png') }}" data-save_<?php echo $prop_val['id'];  ?>="Saved" id="save_src_<?php echo $prop_val['id']; ?>"><?php } else { ?><img src="{{ URL::asset('assets/img/star.png') }}" data-save_<?php echo $prop_val['id'];  ?>="Save" id="save_src_<?php echo $prop_val['id']; ?>"><?php } ?></a>
						</div>
					</div>
					<div class="model_img">
						<?php  
						
						if(!empty($prop_val['property_gallery'])) {
							foreach($prop_val['property_gallery'] as $prop_img) {
							
								echo '<a href="'.url().'/propertydetail/'.$prop_val['id'].'"><img src="'.url().'/uploads/property_gallery/'.$prop_img['image'].'" class="img-full" /></a>';
							}
						
						}else{
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
						echo $string; ; } ?>
					</h5>
                </div>
            </div>
			<?php } } else {  echo '<h2>No results</h2><br/><p>
			You have no saved homes. <a href="'.url().'/house-and-lands">Back to search.</a></p>' ;  } ?>
			</div>
		</div><!--middle section!-->
		<div class="search_rt"><!--right section!-->
			<div class="call-us">
				<p>Call our free and independent home building consultant now</p>
				<div class="rt_phone">
					<img src="{{ URL::asset('assets/images/phone.png') }}" />
					<h1>1800 824 823</h1>
				</div>
			</div><!--phone section!-->
			<?php 
			if(!empty($ads_arr)) { ?>
				<div class="add_model"><!--add section!-->
					<?php  
					foreach($ads_arr as $ads_val) { ?>
						<h3>Get your Free Building Guide when you Enquire!</h3>
						<div class="add_photo">
						<img src="<?php echo url(); ?>/uploads/add_management/<?php echo $ads_val['image']; ?>" /></div>
						<p>Our independent home building guide with expert tips to save you time and money</p>
					<?php 
					}   ?>
				</div><!--add section!-->
			<?php 
			} ?>

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
	</div>
</section><!--property section!-->
@include('common-modal')
<style>
#loading-indicator img {left: 50%;position: absolute;top: 50%;transform: translateX(-50%) translateY(-50%);z-index: 99999;}
#loading-indicator::after {background: rgba(0, 0, 0, 0.898) none repeat scroll 0 0;content: "";height: 100%;left: 0;position: absolute;right: 0;top: 0;width: 1500px;z-index: 9999;}
</style>
<div id='loading-indicator' style=" display: none;">
<img src="{{ URL::asset('assets/img/loading-x.gif') }}" alt="search">
</div>
<div class='bottom_padding'></div>


@stop
