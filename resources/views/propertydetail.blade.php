@extends('layout.default')

@section('content')
<?php //echo '<pre>'; print_r($gallery_images);echo '</pre>'; ?>
<?php if(count($gallery_images) == 1){ ?>
<style>
ul.pgwSlider.wide > li, .pgwSlider.wide > ul > li{ height:auto!important;}
</style>
<?php } ?>
<div class="more-pages product-detail-wrap">
    <div class="innner-banner pd-banner">
        <div class='propery_mainslider'>
		<ul class="pgwSlider">
			<?php 
			if(count($gallery_images) > 0){
				foreach($gallery_images as $val){
					$image = $_SERVER['DOCUMENT_ROOT'].'/uploads/property_gallery/'.$val['image'];
					//$size = getimagesize($image);

					?>
						 <li>
						<img src="<?php echo url(); ?>/public/timthumb.php?src=/uploads/property_gallery/<?php echo $val['image'];  ?>&h=400&w=800&Q=100"/>
						</li>
			<?php
				}
			}else{ ?>
				<li class='property_detailimg'>
					<img src="{{ URL::asset('assets/img/no-image.jpg') }}"/>
				</li>
			<?php	}
			?>
			</ul>
		</div>
		       <div class="pd-cap <?php if(count($gallery_images) == 1) { echo 'pd-cap1';  } ?>">
            <div class="pd-box1 ">
			<a href="javascript:void(0);" rel="<?php echo $prop_arr[0]['id']; ?>" class="save_property" >
                <div class="pd-box2">
					<?php  $check_save_prop =  App\Models\SaveProperty::check_save_prop($prop_arr[0]['id']) ;  ?>
                      <span class="detail_img"><?php  if($check_save_prop != '0') { ?><img src="{{ URL::asset('assets/img/comapre_hover.png') }}" style="width:61%" id="compare_src_<?php echo $prop_arr[0]['id']; ?>"><?php } else { ?><img src="{{ URL::asset('assets/img/comapre.png') }}" style="width:61%" id="compare_src_<?php echo $prop_arr[0]['id']; ?>"><?php } ?></span>
                    <p>
                            		<span id="save_text_<?php echo $prop_arr[0]['id']; ?>" class="prop_text"><?php  if($check_save_prop != '0') { echo 'Compared' ; } else { echo 'Compare' ; } ?></span></p>
                </div>
				</a>
            </div>
            <div class="pd-box1">
                <div class="pd-box2 share_prop">
                    <span><img src="{{ URL::asset('assets/img/share.png') }}"/></span>
                    <p class="prop_text">Share</p>
                    <div class = 'socialite inactive1'>
                    <div class='fb_mail_main'>
						<div class='submain'>
							
								<div class="fb-share-button" data-href="" data-layout="icon_link"></div>
								<div class="email" onclick ="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"><i class="fa fa-envelope"></i> Email</div>
							</div>
						</div>
					</div>
                </div>
            </div>
			<div class="pd-box1">
			<a class="open_floorplan" value="Enquire to Builders"  data-target='.floorplan_detail' data-id = '<?php echo $prop_arr[0]['id']; ?>'  href='javascript:void(0);' data-toggle='modal'>
                <div class="pd-box2 floorplan">
                    <span class="detail_img"><img src="{{ URL::asset('assets/img/floor-white.png') }}"></span>
                    <p><span class="prop_text">Floor Plan</span></p>
                </div>
				</a>
            </div>
            <div class="pd-box1">
			<a class="open_enquirybox" value="Enquire to Builders"  data-target='.bs-example-modal-lg' data-id = '<?php echo $prop_arr[0]['id']; ?>'  href='javascript:void(0);' data-toggle='modal'>
                <div class="pd-box2">
                    <span><i class="fa fa-envelope"></i></span>
                    <p><span class="prop_text">Enquire</span></p>
                </div>
				</a>
            </div>
	
			<div class="pd-box1">
                <div class="pd-box2">
                  	<?php  $check_save_prop =  App\Models\SaveProperty::check_new_save_prop($prop_arr[0]['id']) ;  ?>
                <a href="javascript:void(0);" rel="<?php echo $prop_arr[0]['id']; ?>" class="save_property_new" ><?php  if($check_save_prop != '0') { ?><img src="{{ URL::asset('assets/img/star_hover.png') }}" data-save_<?php echo $prop_arr[0]['id'];  ?>="Saved" id="save_src_<?php echo $prop_arr[0]['id']; ?>" class="detail_img"><?php } else { ?><img src="{{ URL::asset('assets/img/star.png') }}" class="detail_img" data-save_<?php echo $prop_arr[0]['id'];  ?>="Save" id="save_src_<?php echo $prop_arr[0]['id']; ?>"><?php } ?></a>
                    <p>
                 <a href="javascript:void(0);" rel="<?php echo $prop_arr[0]['id']; ?>" class="save_property_new" data-save_<?php echo $prop_arr[0]['id'];  ?>="Saved" ><span id="save_text2_<?php echo $prop_arr[0]['id']; ?>" class="prop_text1"><?php  if($check_save_prop != '0') { echo 'Saved' ; } else { echo 'Save' ; } ?></span></a></p>
                </div>
            </div>
			
						
            <div class="clr"></div>
        </div>
    </div>
    <div class="pd-main">
    <div class="container search_page">
        <div class="search_lt">
            <p class="back-link"><a href="<?php echo url() ?>/property/search-property"><i class="fa fa-arrow-left"></i> &nbsp;Back to results</a></p>
            <div class="pd-left-top">
				<div class='propdetail_title'>
					<h1><?php echo $prop_arr[0]['property_title']; ?></h1>
					<p>From <?php echo '$'.number_format($prop_arr[0]['price'] , 2); ?> <!--<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="The price or price range shown here is indicative only and will vary depending on the final inclusions, location of the build, the house façade and other customisations selected."></i>--></p>
				</div>	
                <div class="pd-left-top-btns">
					<?php
					/* if($prop_arr[0]['builder_detail']['phn_no'] != ''){
						if (strpos($prop_arr[0]['builder_detail']['phn_no'],'or') !== false){
							 $prop_phn = explode('or',$prop_arr[0]['builder_detail']['phn_no']); 
							 $prop_phn = $prop_phn[0];
						}else{
							 $prop_phn = $prop_arr[0]['builder_detail']['phn_no']; 
						} */
						?>
						<a href="tel:1800 824 823" class="see_all" target = '_blank';><i class="fa fa-phone"></i> &nbsp; Call iCompare</a>
                    <?php 
                   // } ?>
                    <a href="<?php echo url() ?>/builder-detail/<?php echo $prop_arr[0]['builder_detail']['builder_id']; ; ?>" class="see_all">View Builder Profile</a>
                </div>
            </div>
            <div class="pd-left-btm">
            <?php echo $prop_arr[0]['description']; ?>
            <div class="plb-sec1">
                <div class="plb-sec1-box">
                    <div class="view1-bottom-box">
                        <p><img alt="green" src="{{ URL::asset('assets/img/bed-green.png') }}">Bedrooms:</p>
                        <p><?php echo $prop_arr[0]['bedrooms']; ?></p>
                    </div>
                    <div class="view1-bottom-box">
                        <p><img alt="green" src="{{ URL::asset('assets/img/bathroom.png') }}">Bathrooms:</p>
                        <p><?php echo $prop_arr[0]['bathrooms']; ?></p>
                    </div>
                    <div class="view1-bottom-box">
                        <p><img alt="green" src="{{ URL::asset('assets/img/living.png') }}">Living:</p>
                        <p><?php echo $prop_arr[0]['living']; ?></p>
                    </div>
                    <div class="view1-bottom-box">
                        <p><img alt="green" src="{{ URL::asset('assets/img/dual-occ.png') }}">Dual Occ:</p>
                        <p><?php echo $prop_arr[0]['dual_occ']; ?></p>
                    </div>
                </div>
                <div class="plb-sec1-box">
                    <div class="view1-bottom-box">
                        <p><img alt="green" src="{{ URL::asset('assets/img/car.png') }}">Cars:</p>
                        <p><?php echo $prop_arr[0]['cars']; ?></p>
                    </div>
                    <div class="view1-bottom-box">
                        <p><img alt="green" src="{{ URL::asset('assets/img/story.png') }}">Stories:</p>
                        <p><?php echo $prop_arr[0]['stories']; ?></p>
                    </div>
                    <div class="view1-bottom-box">
                        <p><img alt="green" src="{{ URL::asset('assets/img/alfresco.png') }}">Alfresco:</p>
                        <p><?php echo $prop_arr[0]['alfresco']; ?></p>
                    </div> 
                </div>
                <div class="plb-sec1-box">
                    <div class="view1-bottom-box">
                        <p><img alt="green" src="{{ URL::asset('assets/img/house-size.png') }}">House size:</p>
                        <p><?php echo $prop_arr[0]['housesize']; ?></p>
                    </div>
                    <div class="view1-bottom-box">
                        <p><img alt="green" src="{{ URL::asset('assets/img/min-block-width.png') }}">Min Block width:</p>
                        <p><?php echo $prop_arr[0]['min_block_width']; ?></p>
                    </div>
                    <div class="view1-bottom-box">
                        <p><img alt="green" src="{{ URL::asset('assets/img/min-block-length.png') }}">Min Block length:
</p>
                        <p><?php echo $prop_arr[0]['min_block_length']; ?></p>
                    </div>
                </div>
                <div class="clr"></div>
            </div>
            <?php if($prop_arr[0]['builder_detail']['builder_location'] != ''){ ?>
				<div class="plb-sec2">
					<div class="detail-top-box">
						<div class="detail-top-left"><p><i class="fa fa-map-marker"></i> <strong>Build locations</strong></p></div>
						<div class="detail-top-right"><p><?php echo $prop_arr[0]['builder_detail']['builder_location']; ?> </p></div>
						 <div class="clr"></div>
					 </div>
				</div>
            <?php } 
            if($prop_arr[0]['promotional_brochure'] != ''){   ?>
			   <div class="plb-sec3">
					<div class="promotion">
						<h3>Promotion</h3>
						<div class='detail_promotion'>
							<span class="promotion__description">Choose from our style pack discount on your new home. </span>
							<a download="<?php echo $prop_arr[0]['property_title'] ?>" href="<?php echo url(); ?>/propertymanagement/getDownloadfile/<?php echo $prop_arr[0]['promotional_brochure'];  ?>" class="promotion__link js-promotion__link"><i class="fa fa-download"></i>
							Promotions Brochure</a>
						</div>
					</div>
				</div>
			<?php
			}
			 ?>
            <div class="plb-sec3">
				<?php
				/* if(count($prop_arr[0]['property_gallery']) > 0){
					$i = 0;
					foreach($prop_arr[0]['property_gallery'] as $val){
						$class = 'style="display:none;"'; if($i == 0){ $class = 'style="display:block;"'; } */
				?>
						<!--<div class="plb-sec3-box" <?php //echo $class; ?> >
							<a class="fancybox" data-fancybox-group="gallery" href="<?php //echo url(); ?>/uploads/property_gallery/<?php //echo $val['image'];  ?>" target="_blank" > 
								<img src="<?php //echo url(); ?>/uploads/property_gallery/<?php //echo $val['image'];  ?>" />  
								View gallery
							</a>
						</div>-->
				<?php /* $i++; 
					}
				}
				if(count($prop_arr[0]['property_floor_plans']) > 0){
					$j = 0;
					foreach($prop_arr[0]['property_floor_plans'] as $val){
						$class = 'style="display:none;"'; if($j == 0){ $class = 'style="display:block;"'; } */
				?>
                <!--<div class="plb-sec3-box" <?php //echo $class; ?> >
                    <a class="fancybox" data-fancybox-group="gallery" href="<?php //echo url(); ?>/uploads/property_floor/<?php //echo $val['image'];  ?>" target="_blank" > 
						<img src="{{ URL::asset('assets/img/floorplan.jpg') }}" class="floor_plan_img" />
						View Floor Plans 
					</a>
                </div>-->
                <?php /*  $j++;
					}
				} */
				if($prop_arr[0]['brochure'] != ''){
					?>
					<div class="plb-sec3-box">
						<a href="<?php echo url(); ?>/propertymanagement/getDownloadfile/<?php echo $prop_arr[0]['brochure'];  ?>" > 
							<img src="{{ URL::asset('assets/img/compare.png') }}" alt="image">
							Download house brochure
						</a>
					</div>
					 <?php
				}
			 ?>
			 
			<?php if($prop_arr[0]['builder_detail']['inclusion_brochure'] != ''){
					?>
					<div class="plb-sec3-box">
						<a href="<?php echo url(); ?>/uploads/brochure/<?php echo $prop_arr[0]['builder_detail']['inclusion_brochure'];  ?>" > 
							<img src="{{ URL::asset('assets/img/inclusions-brochure.jpg') }}" alt="image">
							View inclusion brochure
						</a>
					</div>
					<div class="clr"></div>
					 <?php
				}
			 ?>
			 
            </div>
			<div class="clr"></div>
			  <div class="propdetail_plb-sec3">
						<div class="plb-sec3-propdetail detail_homes">
						<?php  $display_home_arr  =   $prop_arr[0];  $total_disvilge = count($display_home_arr['property_display_homes']);  ?>
							<h2>Display Homes (<?php  echo $total_disvilge ; ?>)</h2>
							<?php 
							
							if(!empty($display_home_arr['property_display_homes'])) { 
								foreach($display_home_arr['property_display_homes'] as $display_val) {
							?>
							<div class="display-home">
							<div class="display-home-left">
							<img src="<?php echo url(); ?>/assets/img/map-pin.png" />
							<strong><?php  echo $display_val['display_village_title'] ; ?></strong>
							<p><?php  echo $display_val['display_location'] ; ?></p>
							</div>
							<div class="display-home-right">
							<a href="<?php echo url(); ?>/properties/display-villages/<?php echo $prop_arr[0]['id'];  ?>">View in maps</a>
							</div>
							</div>
							<div class="clr"></div>
							<?php } } ?>
							<!--<div class="display-home">
							<div class="display-home-left">
							<strong>SOMERFIELD ESTATE</strong>
							<p>2-8 Olivetree Drive (Westwood Boulevard & Olivetree Drive, Off Perry Road)</p>
							</div>
							<div class="display-home-right">
							<a href="https://www.ibuildnew.com.au/products/1033/display-villages">More info &amp; bookings</a>
							</div>
							</div>
							 <div class="clr"></div>-->
						</div>
						<div class="clr"></div>
				
            </div>
			
		<?php if($prop_arr[0]['property_type'] == '1' || $prop_arr[0]['property_type'] == '3') { ?>
			  <div class="propdetail_plb-sec3">

					
		<div class="plb-sec3-propdetail detail_homes">
			<?php   $total_houseland = count($house_land_arr);  ?>
							<h2>House and Land (<?php echo $total_houseland ;   ?>)</h2>
							<?php 
							
							if(!empty($house_land_arr)) { 
								foreach($house_land_arr as $display_val) {
							?>
							<div class="display-home">
							<div class="display-home-left">
							<img src="<?php echo url(); ?>/assets/img/map-pin.png" />
							<strong><?php  echo $display_val['property_title'] ; ?></strong>
							<p><?php  echo $display_val['house_land_address'] ; ?></p>
							</div>
							<div class="display-home-right">
							<a href="<?php echo url(); ?>/propertydetail/<?php echo $display_val['id'];  ?>">View Detail</a>
							</div>
							</div>
							<div class="clr"></div>
							<?php } } ?>
							<!--<div class="display-home">
							<div class="display-home-left">
							<strong>SOMERFIELD ESTATE</strong>
							<p>2-8 Olivetree Drive (Westwood Boulevard & Olivetree Drive, Off Perry Road)</p>
							</div>
							<div class="display-home-right">
							<a href="https://www.ibuildnew.com.au/products/1033/display-villages">More info &amp; bookings</a>
							</div>
							</div>
							 <div class="clr"></div>-->
						</div>
				
               
				<div class="clr"></div>
					
            </div>
			<?php } ?>
        </div>
        </div>
        <div class="search_rt">
            <h3>Call our free and independent home building consultant now</h3>
            <div class="rt_phone">
            	<img src="{{ URL::asset('assets/images/phone.png') }}" />
                <h1>1800 824 823</h1>
            </div>
			<?php if(!empty($ads_arr)) { ?>
             <div class="add_model"><!--add section!-->
                   	
		<?php  foreach($ads_arr as $ads_val) { ?>
        	<h3>Get your Free Building Guide when you Enquire</h3>
            <div class="add_photo"><!--<div class="add_text"><h4>$<span>20</span> Voucher</h4></div> <div class="voucher-offer__plus"><span>plus</span></div>--> <img src="<?php echo url(); ?>/uploads/add_management/<?php echo $ads_val['image']; ?>" /></div>
            <p>Our independent home building guide with expert tips to save you time and money</p>
			<?php }   ?>
            <!--<div class="book"><img src="{{ URL::asset('assets/img/book.png') }}" /></div>
            <div class="enq_btn">When you enquire through icompare today. </div>-->
              </div>
			  <?php } ?>
        </div>
        <div class="clr"></div>
		<div class="inclusion_tree inc_prop_view">
		<h2>Standard inclusions</h2>
	  <table class="collaptable">

<?php if(!empty($inc_arr)) { foreach($inc_arr as $inc_val){ ?>
<tr data-id="<?php echo $inc_val['id']; ?>" data-parent="">
<td class="inc_prop_parent"><?php  echo $inc_val['title']  ; ?></td>
</tr>
<?php $filter_inc_arr =  App\Inclusion::get_child_inclusions($inc_val['id']) ;
				if(!empty($filter_inc_arr)) { 
				foreach($filter_inc_arr as $filter_val) {
					

				?>
				<tr data-id="<?php echo $filter_val['id']; ?>" data-parent="<?php echo $inc_val['id']; ?>">
<td><?php  echo $filter_val['title']  ; ?></td>
</tr>
				<?php } } } } ?>
</table>
</div>
    </div>
    </div>
</div>
    <div id="light" class="white_content share_byemail">
		{!! Form::open(array('class' => 'form','enctype'=>"multipart/form-data",'id'=>'myform')) !!}
			<div class='email_headwithcls'>
				<h3 id="heading">Email</h3>
				<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">
					<img src="{{ URL::asset('assets/img/close-red.png') }}" alt="close" /> 
				</a>
			</div>
			<div class="emailrow">
				<label for="em-f">To:</label>
				<p>
					<span class="emailrow-input">
						<input required type="email" value="" placeholder="" spellcheck="true" maxlength="255" name="to" id="em-f">
					</span>
				</p>
			</div>
			<?php 
			$user = Auth::user();
		if($user){
		$user_email = $user->email;
	
		} else {
				$user_email = "";
				
		} ?>
			<div class="emailrow">
				<label for="em-f">From:</label>
				<p>
					<span class="emailrow-input">
						<input required type="email" value="<?php echo $user_email; ?>" placeholder="" spellcheck="true" maxlength="255" name="from" id="em-f">
					</span>
				</p>
			</div>
			<div class="emailrow">
				<label for="em-f">Subject:</label>
				<p>
					<span class="emailrow-input">
						<input required type="text" value="iCompareBuilder : <?php echo $prop_arr[0]['property_title']; ?>" placeholder="" spellcheck="true" maxlength="255" name="subject" id="em-f">
					</span>
				</p>
			</div>
			<div id="emailprop-msg">
				<span><textarea required name="note" id="note"></textarea></span>
				<div id="lengthlimit">255</div>
			</div>
			<div id="emailprop-sharelink">
				<label>URL:</label>
				<p><?php echo url().'/propertydetail/'.$prop_id; ?></p>
				<input type='hidden' name='property_url' value="<?php echo url().'/propertydetail/'.$prop_id; ?>">
				<div class="at-clear"></div>
			</div>
			<div id="emailprop-send">
				<div class="emailprop-send-inner">
					<button title="Send Email" type="submit" class="btn-blue">Send Email</button>
					<p></p>
					
				</div>
			</div>
		{!! Form::close() !!}
	</div>
	
 @include('common-modal')
    <div id="fade" class="black_overlay"></div>
<?php //echo '<pre>'; print_r($prop_arr); echo '</pre>'; ?>
<div id="fb-root"></div>
  <style>
  #loading-indicator img {left: 50%;position: absolute;top: 50%;transform: translateX(-50%) translateY(-50%);z-index: 99999;}
  #loading-indicator::after {background: rgba(0, 0, 0, 0.898) none repeat scroll 0 0;content: "";height: 100%;left: 0;position: absolute;right: 0;top: 0;width: 1500px;z-index: 9999;}
  </style>
  <div id='loading-indicator' style=" display: none;">
    <img src="{{ URL::asset('assets/img/loading-x.gif') }}" alt="search">
</div>
<script>
	(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=498943593602849";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

	$('.share_prop').click(function(e){ 
		e.stopPropagation();
		if($(this).find('.socialite').hasClass('active1')){
			$(this).find('.socialite').removeClass('active1');
			$(this).find('.socialite').addClass('inactive1');
		}else{
			$(this).find('.socialite').removeClass('inactive1');
			$(this).find('.socialite').addClass('active1');
		}
		
	});
	$("body").click(function(){ //alert('ads');
	  $(".socialite").removeClass("active1");
	  $(".socialite").addClass("inactive1");
	});
	$('.fancybox').fancybox({  prevEffect : 'none', nextEffect : 'none'});
	$('div.alert').delay(5000).slideUp(300);
</script>
@stop
