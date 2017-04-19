@extends('layout.default')

@section('content')	
<?php //echo '<pre>';print_r($prop_arr); echo '</pre>';  ?>
<div class="builder-details">
    <div class="bd-banner">
    <div class="bd-banner-inner">
	<?php if(!empty($property_arr)){  
				if(count($property_arr)>0){
						$i = 0;
						$gallery_arr = "";
					foreach($property_arr as $val){
						if(!empty($val['property_gallery'])) {
							foreach($val['property_gallery'] as $prop_img) {
							if(count($gallery_arr) > 5) {
								break;
							}
							$gallery_arr[] = $prop_img['image'];
								//$profile_image = ImgProxy::link("uploads/property_gallery/".$prop_img['image'],50,50);
							/* 	if($i < 6){
									echo '<img src="'.url().'/uploads/property_gallery/'.$prop_img['image'].'" style="height:226px;width:378px"/>';
								} */
								$i++;
							}
						}
					}
				}
			}
			?>
			
			<?php if(!empty($gallery_arr)) { foreach($gallery_arr as $gallry_val) {  ?>
			<img src="<?php echo url() ; ?>/uploads/property_gallery/<?php echo $gallry_val ; ?>" style="height:226px;width:378px"/>
			<?php } } ?>
			
    </div>
    </div>
    <div class="bd-main-wrap">
        <div class="container">
            <div class="bd-left">
                <div class="bd-left-L">
                    <div class="builder-profile-pic"><img src="<?php echo url(); ?>/uploads/builder_logo/<?php echo $builder_data[0]['logo']; ?>" alt="profile" class= 'img-responsive' alt="image" ></div>
                    <div class="about-builder">
                        <div class="about-builder-box">
                            <i class="fa fa-flag"></i>
                            <p>ESTABLISHED</p>
                            <span><?php echo $builder_data[0]['established']; ?></span>
                        </div>
                        <div class="about-builder-box">
                            <i class="fa fa-th-large"></i>
                            <p>HOME DESIGNS</p>
                            <span><?php echo $builder_data[0]['annual_home_builds']; ?></span>
                        </div>
                        <div class="about-builder-box">
                            <i class="fa fa-dollar"></i>
                            <p>PRICE RANGE</p>
                            <span><?php echo $builder_data[0]['price_range']; ?></span>
                        </div>
                        <div class="about-builder-box">
                            <i class="fa fa-thumbs-up"></i>
                            <p>STRUCTURAL GUARANTEE</p>
                            <span><?php echo $builder_data[0]['stuctured_gurantee']; ?></span>
                        </div>
                        <div class="about-builder-box">
                            <i class="fa fa-wrench"></i>
                            <p>FREE MAINTENANCE PERIOD</p>
                            <span><?php echo $builder_data[0]['free_maintaince_period']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="bd-left-R">
                    <h2><?php echo $builder_data[0]['company_name'] ?></h2>
                    <div class='readMore'><?php echo substr($builder_data[0]['builder_desc'],0,300).'...'; ?></div>
                    
                    <div class='readLess' style='display:none;'><?php echo $builder_data[0]['builder_desc']; ?></div>
                    <a class="read-more" href="javascript:void(0);">+ Read More</a>
                    <div class="detail-top">
					<?php if($builder_data[0]['builder_location'] != ''){ ?>
							<div class="detail-top-box">
								<div class="detail-top-left"><p><strong>Build locations</strong></p></div>
								<div class="detail-top-right"><p><?php echo $builder_data[0]['builder_location']; ?></p></div>
								<div class="clr"></div>
							</div>
                       <?php }
                       if($builder_data[0]['industry_awards'] != ''){
						    ?>
							<div class="detail-top-box">
								<div class="detail-top-left"><p><strong>Industry awards</strong></p></div>
								<div class="detail-top-right"><p><?php echo $builder_data[0]['industry_awards']; ?></p></div>
								<div class="clr"></div>
							</div>
                        <?php }
							 if($builder_data[0]['master_builders'] != '' || $builder_data[0]['housing_industry'] != ''){
						    ?>
							<div class="detail-top-box">
								<div class="detail-top-left"><p><strong>Accreditation</strong></p></div>
								<div class="detail-top-right">
						<?php		if($builder_data[0]['master_builders'] != ''){ ?>
										<p>Housing Industry Association (HIA): <?php echo $builder_data[0]['housing_industry']; ?></p> 
							<?php   }if($builder_data[0]['housing_industry'] != ''){ ?>
										<p>Master Builders Association (MBA): <?php echo $builder_data[0]['master_builders']; ?></p>
								<?php } ?>
								</div>
								<div class="clr"></div>
							</div>
                       <?php 
							}
                       ?>
                    </div>
                   <!-- <div class="detail-top display-village">
                    <h3>Display Villages (17)</h3>
                        <div class="detail-top-box">
                            <div class="detail-top-left"><p><strong>SELANDRA RISE ESTATE</strong><br>22-26 Waler Circuit<br>Clyde North, VIC, 3978 </p></div>
                            <div class="detail-top-right"><p><a class="read-more">More info & bookings</a></p></div>
                            <div class="clr"></div>
                        </div>
                        <div class="detail-top-box">
                            <div class="detail-top-left"><p><strong>SELANDRA RISE ESTATE</strong><br>22-26 Waler Circuit<br>Clyde North, VIC, 3978 </p></div>
                            <div class="detail-top-right"><p><a class="read-more">More info & bookings</a></p></div>
                            <div class="clr"></div>
                        </div>
                        <div class="detail-top-box">
                            <div class="detail-top-left"><p><strong>SELANDRA RISE ESTATE</strong><br>22-26 Waler Circuit<br>Clyde North, VIC, 3978 </p></div>
                            <div class="detail-top-right"><p><a class="read-more">More info & bookings</a></p></div>
                            <div class="clr"></div>
                        </div>
                        <a class="see_all" href="http://macrew.info/laravel/ourbuilders">See all Carlisle Homes display villages</a>
                    </div>-->                    
                </div>
                <div class="clr"></div>
            </div>
            <div class="bd-right">
				{!! Form::open(array('class' => 'form','enctype'=>"multipart/form-data")) !!}
					<div class="builder-form">
						<div class="builder-form-head">
							<i class="fa fa-envelope"></i>
							<h2>Contact <?php echo $builder_data[0]['company_name'] ?></h2>
						</div>
						{!! Form::text('firstname', null, array('required', 'class'=>'form-control', 'placeholder'=>'First name')) !!}
						{!! Form::text('lastname', null, array('required', 'class'=>'form-control', 'placeholder'=>'Last name')) !!}
						{!! Form::text('phone', null, array( 'class'=>'form-control', 'placeholder'=>'Phone number')) !!}
						{!! Form::email('email', null, array('required', 'class'=>'form-control', 'placeholder'=>'Email')) !!}
						{!! Form::select('user_location', array('' => 'Please select one option') + $states, null,array('rquired', 'class'=>'form-control')) !!}
						{!! Form::textarea('address', null, array( 'class'=>'form-control', 'placeholder'=>'Your question')) !!}
						<input type='hidden' name='builder_email' value='<?php echo $builder_email; ?>'/>
						<input type="submit" class="button1" value="Ask a question">
					</div>
				{!! Form::close() !!}
            </div>
            <div class="clr"></div>
             <div class="property_main">
            	
					<div class="pro_row">
				<?php if(!empty($prop_arr)){  if(count($prop_arr)>0){
							$i = 1;
							foreach($prop_arr as $val){
								$cls = ''; //echo '<pre>'; print_r($val);die;
								if($i%3 == 0){
									$cls = 'no_mg';
								}
				?>
								<div class="featured-box <?php echo $cls; ?>">
									<div class="featured-image">
										<div class="featured-strip">
											<div class="featured-strip-box"><a href="<?php echo url(); ?>/propertydetail/<?php echo $val['id']; ?>"><img src="<?php echo url(); ?>/assets/images/featured-strip-icon1.png" alt="featured" /><span>View</span></a></div>
											<div class="featured-strip-box"><a  class="open_enquirybox" value="Enquire to Builders"  data-target='.bs-example-modal-lg' data-id = '<?php echo $val['id']; ?>'  href='javascript:void(0);' data-toggle='modal'><img src="<?php echo url(); ?>/assets/images/featured-strip-icon2.png" alt="featured" /><span>Enquire</span></a></div>
											<div class="featured-strip-box">
											<?php  $check_save_prop =  App\Models\SaveProperty::check_save_prop($val['id']) ;  ?>
											<a href="javascript:void(0);" rel="<?php echo $val['id']; ?>" class="save_property" >
											<?php  if($check_save_prop != '0') { ?><img src="<?php echo url(); ?>/assets/images/featured-strip-icon-blue.png" alt="featured" id="compare_src_<?php echo $val['id']; ?>" /><?php } else { ?>
											<img src="<?php echo url(); ?>/assets/images/featured-strip-icon3.png" id="compare_src_<?php echo $val['id']; ?>" alt="featured" /><?php } ?><span id="save_text_<?php echo $val['id']; ?>"></span><span>Compare</span></a>
											<input type="hidden" value="<?php  if($check_save_prop != '0') { echo 'Compared' ; } else { echo 'Compare' ; } ?>" id="comp_text_<?php echo $val['id']; ?>"/> 
											</div>
										</div>
										<div class="model_img">
													<?php  
									
															if(!empty($val['property_gallery'])) {
																foreach($val['property_gallery'] as $prop_img) {
																	//$profile_image = ImgProxy::link("uploads/property_gallery/".$prop_img['image'],50,50);
																	echo '<a href="'.url().'/propertydetail/'.$val['id'].'"><img class="img-full" src="'.url().'/uploads/property_gallery/'.$prop_img['image'].'" class="gal_img" /></a>';
																}
															
															}
															else {
									
																echo '<a href="'.url().'/propertydetail/'.$val['id'].'"><img class="img-full" src="'.url().'/assets/img/no-image.jpg" /></a>';
															}
															?>
															</div>
									</div>
									<div class="featured-box-btm">
										<ul>
											<li><span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/bed-icon.png" alt="Beds" /></a></span><p><span><?php echo $val['bedrooms']; ?></span> Beds</p></li>
											<li><span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/bath-icon.png" alt="Beds" /></a></span><p><span><?php echo $val['bathrooms']; ?></span> Bath</p></li>
											<li><span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/living-icon.png" alt="Beds" /></a></span><p><span><?php echo $val['living']; ?></span> Living</p></li>
											<li><span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/area-icon.png" alt="Beds" /></a></span><p><span><?php echo $val['housesize']; ?></span> Sq</p></li>
										</ul>
										<div class="featured-price">
										<h4><?php echo $val['property_title']; ?></h4>
											<p>From $<?php  echo number_format($val['price'],2) ; ?></p>
											<img src="<?php echo url(); ?>/uploads/builder_logo/<?php echo $val['builder_detail']['logo']; ?>" class="featured-logo" alt="image"/>
										</div>
									</div>
								</div>

				   <?php  $i++;
							}
						}  
						
						$builderfname = !empty($val['builder_detail']['firstname'])?$val['builder_detail']['firstname']:"";
						$builderlname = !empty($val['builder_detail']['lastname'])?$val['builder_detail']['lastname']:"";
						$buildername = $builderfname.' '.$builderlname;
							echo '<a class="see_all" href="'.url().'/property/search-property?builder='.$val['builder_detail']['builder_id'].'" style="margin: 0 0 0 26%;">See '.$builder_data[0]['company_name'].' ('.$val['builder_detail']['firstname'].') range </a>';
						}//else{ echo "<em>Sorry, no property found of ".$builder_data[0]['company_name'].".</em>"; } ?>
					
						 
					<div class="clr"></div>
					</div>
					
				</div>
				
				<div class="property_main">
            	
					<div class="pro_row">
				<?php if(!empty($prop_arr1)){  if(count($prop_arr1)>0){
							$i = 1;
							foreach($prop_arr1 as $val){
								$cls = '';
								if($i%3 == 0){
									$cls = 'no_mg';
								}
				?>
								<div class="pro_box <?php echo $cls; ?>">
								<div class="prop_header">
									<div class="c_logo"><img src="<?php echo url(); ?>/uploads/builder_logo/<?php echo $val['builder_detail']['logo']; ?>" class= 'img-responsive' alt="image"/></div>
									<a href="<?php echo url(); ?>/propertydetail/<?php echo $val['id'];  ?>"><h4><?php echo $val['property_title']; ?></h4></a>
									<h5>From $<?php echo $val['price']; ?> </h5> 
								</div>
								<div class="star home-star">
				<?php  $check_save_prop =  App\Models\SaveProperty::check_new_save_prop($val['id']) ;  ?>
                            	<a href="javascript:void(0);" rel="<?php echo $val['id']; ?>" class="save_property_new" ><?php  if($check_save_prop != '0') { ?><img src="{{ URL::asset('assets/img/star_hover.png') }}" data-save_<?php echo $val['id'];  ?>="Saved" id="save_src_<?php echo $val['id']; ?>"><?php } else { ?><img src="{{ URL::asset('assets/img/star.png') }}" data-save_<?php echo $val['id'];  ?>="Save" id="save_src_<?php echo $val['id']; ?>"><?php } ?></a>
				</div>
									<div class="p_box model_img prop_image">
											<?php  
						
												if(!empty($val['property_gallery'])) {
													foreach($val['property_gallery'] as $prop_img) {
														//$profile_image = ImgProxy::link("uploads/property_gallery/".$prop_img['image'],50,50);
														echo '<a href="'.url().'/propertydetail/'.$val['id'].'"><img src="'.url().'/uploads/property_gallery/'.$prop_img['image'].'" /></a>';
													}
												
												}else{
												
												?><img src="{{ URL::asset('assets/img/p1.png') }}" />
												<?php } ?>
									</div>   	
									<ul class="icon_set">
										<li>
											<i><img src="{{ URL::asset('assets/img/bed.png') }}" /> <span><em><?php echo $val['bedrooms']; ?></em> beds</span></i>
										 </li>
									   <li>
											<i><img src="{{ URL::asset('assets/img/bath.png') }}" /> <span><em><?php echo $val['bathrooms']; ?></em> bath</span></i>
										 </li>
										<li>
											<i><img src="{{ URL::asset('assets/img/sofa.png') }}" /> <span><em><?php echo $val['living']; ?></em> living</span></i>
										 </li>
									   <li>
											<i><img src="{{ URL::asset('assets/img/size.png') }}" /> <span><em><?php echo $val['housesize']; ?></em> sq</span></i>
										 </li>
									</ul>
									
									<ul class="button_set">
										<li>
											<a href="<?php echo url(); ?>/propertydetail/<?php echo $val['id']; ?>"><img src="{{ URL::asset('assets/img/view.png') }}">View</a>
										</li>
										<li>
											<a href="<?php echo url(); ?>/property/contact?property_ids=<?php echo $val['id']; ?>"><img src="{{ URL::asset('assets/img/message.png') }}">Message</a>
										</li>
										<li>
											<?php  $check_save_prop =  App\Models\SaveProperty::check_save_prop($val['id']) ;  ?>
                            	<a href="javascript:void(0);" rel="<?php echo $val['id']; ?>" class="save_property" ><?php  if($check_save_prop != '0') { ?><img src="{{ URL::asset('assets/img/comapre_hover.png') }}" id="compare_src_<?php echo $val['id']; ?>"><?php } else { ?><img src="{{ URL::asset('assets/img/comapre.png') }}" id="compare_src_<?php echo $val['id']; ?>"><?php } ?><span id="save_text_<?php echo $val['id']; ?>"><?php  if($check_save_prop != '0') { echo 'Compared' ; } else { echo 'Compare' ; } ?></span></a>
										</li>
									</ul>
								</div>
				   <?php  $i++;
							}
						}  
							echo '<a class="see_all" href="'.url().'/house-and-lands?builder='.$val['builder_detail']['builder_id'].'" style="margin: 0 0 0 26%;">See '.$builder_data[0]['company_name'].' House & Land Packages</a>';
						}//else{ echo "<em>Sorry, no property found of ".$builder_data[0]['company_name'].".</em>"; } ?>
					
						 
					<div class="clr"></div>
					</div>
					
				</div>
				<div class="clr"></div>
				
				<div class="property_main">
					<?php  
			
			if(!empty($display_home_arr)) {
			foreach($display_home_arr[0] as $display_land_val){
			
			?>
                <div class="display-home">
							<div class="display-home-left">
							<img src="http://macrew.info/laravel/assets/img/map-pin.png">
							<strong><?php  echo $display_land_val['display_village_title']  ; ?></strong>
							<p><?php  echo $display_land_val['display_location']  ; ?></p>
							</div>
							<div class="display-home-right">
							<a href="<?php echo url(); ?>/properties/display-villages/<?php echo  $display_land_val['property_id']; ?>">View in maps</a>
							</div>
				</div>
               <?php } } ?>
				
				</div>
				
				
			</div>
        </div>
    </div>
</div>
 @include('common-modal')
<script>
$('.read-more').click(function(){
	if($(this).text() =='+ Read More'){
		$('.readMore').hide();
		$('.readLess').show();
		$(this).text('+ Read Less');
	}else{
		$('.readMore').show();
		$('.readLess').hide();
		$(this).text('+ Read More');
	}
});
</script>
@stop
