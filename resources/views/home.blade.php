@extends('layout.default')

@section('content')	


<section class="banner">
    <div class="banner-search">
        <h2>Search Australia’s Best Builders</h2>
		<form action="<?php echo url(); ?>/property/search-property" method="get" > 
        <div class="search-top">
<?php
                $state = Session::get('header_state'); 
				
				$states = App\State::Getstates()->groupBy('state_name')->get();
				$states_arr = $states->toArray();
                ?>
                    <input type='hidden' id = 'ajax_searchstate' value = '<?php echo url()."/change-state-search"; ?>'>
                    <select class="vic" id='main_regionchange' name="main_regionchange">
					<?php if(!empty($states_arr)) { foreach($states_arr as $state_val)  { ?>
                      <option value="<?php echo $state_val['state_name']; ?>" <?php if(!empty($state)) { if($state == $state_val['state_name']){ echo 'selected="selected"' ; } }   ?>><?php echo $state_val['state_name']; ?></option>
					  <?php } } ?>
                      <!--<option value="QLD" <?php //if(!empty($state)) { if($state == 'QLD'){ echo 'selected="selected"' ; } }   ?>>QLD</option>
                      <!--<option value="NSW" <?php //if(!empty($state)) { if($state == 'NSW'){ echo 'selected="selected"' ; } }   ?>>NSW</option>
                      <option value="WA" <?php //if(!empty($state)) { if($state == 'WA'){ echo 'selected="selected"' ; } }   ?>>WA</option>
                      <option value="TAS" <?php //if(!empty($state)) { if($state == 'TAS'){ echo 'selected="selected"' ; } }   ?>>TAS </option>
                      <option value="ACT" <?php //if(!empty($state)) { if($state == 'ACT'){ echo 'selected="selected"' ; } }   ?>>ACT</option>
                      <option value="NT" <?php //if(!empty($state)) { if($state == 'NT'){ echo 'selected="selected"' ; } }   ?>>NT </option>
                      <option value="SA" <?php //if(!empty($state)) { if($state == 'SA'){ echo 'selected="selected"' ; } }   ?>>SA</option>-->
                    </select>
            					<select  name="search_region" id ="search_region" class="sele">
        				<?php // $main_states = array('Queensland'=>'QLD' ,'Victoria'=>'VIC','New South Wales'=>'NSW','Western Australia'=>'WA','Tasmania'=>'TAS','Northern Territory'=>'NT','Australian Capital Territory'=>'ACT','South Australia'=>'SA');
						//$main_states = array('Queensland'=>'QLD' ,'Victoria'=>'VIC','New South Wales'=>'NSW','Western Australia'=>'WA');
						$main_states = App\State::get_mainstates();
						//$main_states = array('Victoria'=>'VIC');
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
            <input type="submit" name="search" value="Search" />
            <div class="clr"></div>
        </div>
        <div class="search-btm">
             <select name="property_type" class="big-select">
					  <option value="All-Types" selected="selected">All property types</option>
                      <option value="Any">Any</option>
                      <option value="Single-Storey">Single Storey Homes</option>
                      <option value="Double-Storey">Double Storey Homes</option>
                      <option value="Homes-With-Alfrescos">Homes With Alfrescos</option>
                      <option value="Dual-occupancy-Homes">Dual-occupancy Homes</option>
                      <option value="Custom-Designs">Custom Designs</option>
                    </select>

					<select name="bedrooms" class="big-select">
              <option value="Bedrooms" selected="selected">Beds</option>
			  <option value="1">1 bedroom</option>
			  <option value="1plus">1 or more bedrooms</option>
			  <option value="2">2 bedrooms</option>
			  <option value="2plus">2 or more bedrooms</option>
			  <option value="3">3 bedrooms</option>
			  <option value="3plus">3 or more bedrooms</option>
			  <option value="4">4 bedrooms</option>
			  <option value="4plus">4 or more bedrooms</option>
			  <option value="5">5 bedrooms</option>
			  <option value="5plus">5 or more bedrooms</option>
                </select>
					

					<select name="bathrooms" class="big-select">
                  <option value="Bathrooms" selected="selected">Baths</option>
				  <option value="1">1 bathroom</option>
				  <option value="1plus">1 or more bathrooms</option>
				  <option value="2">2 bathrooms</option>
				  <option value="2plus">2 or more bathrooms</option>
				  <option value="3">3 bathrooms</option>
				  <option value="3plus">3 or more bathrooms</option>
                </select>
					
					
					<?php 
					
					$price_arr = array('50000' => '$50,000', '100000' => '$100,000' , '150000' => '$150,000' , '200000' => '$200,000' , '250000' => '$250,000' , '300000' => '$300,000' ,'350000' => '$350,000' ,'400000'=>'$400,000' , '450000' => '$450,000' , '500000'=>'$500,000' , '550000' => '$550,000' , '600000' => '$600,000' , '650000' => '$650,000' , '700000' => '$700,000' , '750000' => '$750,000' , '800000' => '$800,000' , '850000' => '$850,000' , '900000' => '$900,000' , '950000' => '$950,000' ,'1000000' => '$1,000,000' , '1100000' => '$1,100,000' , '1200000' => '$1,200,000' , '1300000' => '$1,300,000' , '1400000' => '$1,400,000' , '1500000' => '$1,500,000' , '1600000' => '$1,600,000' , '1700000' => '$1,700,000' , '1800000' => '$1,800,000' , '1900000' => '$1,900,000' , '2000000' => '$2,000,000' , '2250000' => '$2,250,000' , '2500000' => '$2,500,000' , '2750000' => '$2,750,000' , '3000000' => '$3,000,000' , '3500000' => '$3,500,000' , '4000000' => '$4,000,000' , '5000000' => '$5,000,000' ) ; 
					
					?>
                    <select name="min_price" class="small-select">
                          <option value="min-price">Min price</option>
						<?php foreach($price_arr as $key => $price_val) { ?>
						  <option value="<?php echo $key ; ?>"><?php echo $price_val ; ?></option>
						  <?php } ?>
                    </select>
					

                    <select name="max_price" class="small-select">
                          <option value="max-price">Max price</option>
						<?php foreach($price_arr as $key => $price_val) { ?>
						  <option value="<?php echo $key ; ?>"><?php echo $price_val ; ?></option>
						  <?php } ?>
                    </select>
        </div>
		</form>
    </div>
	<div class="main_slickslider">
	  <div><img src = "<?php echo url(); ?>/assets/images/slide1.jpg" /></div>
	  <div><img src = "<?php echo url(); ?>/assets/images/slide2.jpg" /></div>
	  <div><img src = "<?php echo url(); ?>/assets/images/slide3.jpg" /></div>
	  <div><img src = "<?php echo url(); ?>/assets/images/slide4.jpg" /></div>
	</div>
    <!--<img class="img-full" src="<?php //echo url(); ?>/assets/images/banner-img.jpg" alt="banner" />-->
</section>

<section class="content">
<div class="steps">
    <h2>Find a new home builder in<br>just three simple steps</h2>
    <div class="container">
        <div class="steps-box">
            <h3>Search</h3>
            <img src="<?php echo url(); ?>/assets/images/step-icon1.png" alt="Search" />
            <p>Set your location and any other relevant filters to refine your search.</p>
        </div>
        <div class="steps-box">
            <h3>Compare</h3>
            <img src="<?php echo url(); ?>/assets/images/step-icon2.png" alt="Compare" />
            <p>Select up to 4 new homes to compare features and inclusions side by side.</p>
        </div>
        <div class="steps-box">
            <h3>Enquire</h3>
            <img src="<?php echo url(); ?>/assets/images/step-icon3.png" alt="Enquire" />
            <p>Send a request for more details directly to your builders of choice.</p>
        </div>
        <div class="clr"></div>
    </div>
</div>

<div class="featured">
    <div class="container">
        <h2><span>I</span><span>This weeks</span> Featured designs</h2>
        <a href="<?php echo url() ?>/property/search-property" class="view-btn">View all Designs</a>
        <div class="wrappar">
					<?php if(!empty($prop_arr)){
		if(count($prop_arr)>0){
					$i = 1;
					foreach($prop_arr as $val){
						$cls = '';
						if($i%3 == 0){
							$cls = 'no_mg';
						}
		?>
		
						<div class="featured-box <?php echo $cls; ?>">
							<div class="featured-image">
								<div class="featured-strip">
									<div class="featured-strip-box"><a href="<?php echo url(); ?>/propertydetail/<?php echo $val['property']['id']; ?>"><img src="<?php echo url(); ?>/assets/images/featured-strip-icon1.png" alt="featured" /><span>View</span></a></div>
									<div class="featured-strip-box"><a  class="open_enquirybox" value="Enquire to Builders"  data-target='.bs-example-modal-lg' data-id = '<?php echo $val['property']['id']; ?>'  href='javascript:void(0);' data-toggle='modal'><img src="<?php echo url(); ?>/assets/images/featured-strip-icon2.png" alt="featured" /><span>Enquire</span></a></div>
									<div class="featured-strip-box">
									<?php  $check_save_prop =  App\Models\SaveProperty::check_save_prop($val['property']['id']) ;  ?>
									<a href="javascript:void(0);" rel="<?php echo $val['property']['id']; ?>" class="save_property" >
									<?php  if($check_save_prop != '0') { ?><img src="<?php echo url(); ?>/assets/images/featured-strip-icon-blue.png" alt="featured" id="compare_src_<?php echo $val['property']['id']; ?>" /><?php } else { ?>
									<img src="<?php echo url(); ?>/assets/images/featured-strip-icon3.png" id="compare_src_<?php echo $val['property']['id']; ?>" alt="featured" /><?php } ?><span id="save_text_<?php echo $val['property']['id']; ?>"></span><span>Compare</span></a>
									<input type="hidden" value="<?php  if($check_save_prop != '0') { echo 'Compared' ; } else { echo 'Compare' ; } ?>" id="comp_text_<?php echo $val['property']['id']; ?>"/> 
									</div>
								</div>
								<div class="model_img">
											<?php  
							
													if(!empty($val['property']['gallery'])) {
														foreach($val['property']['gallery'] as $prop_img) {
															//$profile_image = ImgProxy::link("uploads/property_gallery/".$prop_img['image'],50,50);
															echo '<a href="'.url().'/propertydetail/'.$val['property']['id'].'"><img class="img-full" src="'.url().'/public/timthumb.php?src=/uploads/property_gallery/'.$prop_img->image.'&h=400&w=700&q=100" class="gal_img" /></a>';
														}
													
													}
													else {
							
							echo '<a href="'.url().'/propertydetail/'.$val['property']['id'].'"><img class="img-full" src="'.url().'/assets/img/no-image.jpg" /></a>';
							}
													?>
													</div>
							</div>
							<div class="featured-box-btm">
								<ul>
									<li><span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/bed-icon.png" alt="Beds" /></a></span><p><span><?php echo $val['property']['bedrooms']; ?></span> Beds</p></li>
									<li><span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/bath-icon.png" alt="Beds" /></a></span><p><span><?php echo $val['property']['bathrooms']; ?></span> Bath</p></li>
									<li><span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/living-icon.png" alt="Beds" /></a></span><p><span><?php echo $val['property']['living']; ?></span> Living</p></li>
									<li><span class="features"><a href=""><img src="<?php echo url(); ?>/assets/images/area-icon.png" alt="Beds" /></a></span><p><span><?php echo $val['property']['housesize']; ?></span> Sq</p></li>
								</ul>
								<div class="featured-price">
								<h4><?php echo $val['property']['property_title']; ?></h4>
									<p>From $<?php  echo number_format($val['property']['price'],2) ; ?></p>
									<img src="<?php echo url(); ?>/uploads/builder_logo/<?php echo $val['property']['logo']; ?>" class="featured-logo" alt="image"/>
								</div>
							</div>
						</div>
			 <?php  $i++;
					}
				}  }else{ echo "<em>Sorry, no featured property found at this location.</em>"; } ?>
  
            <div class="clr"></div>
        </div>
    </div>
</div>



<div class="featured partners-wrap">
<div class="container">
    <h2><span>I</span><span>our</span> Buildings partners</h2>
    <a href="<?php echo url(); ?>/ourbuilders" class="view-btn">View all Designs</a>
</div>
<div class="partners">
    <div class="container builder-carasouel">
	<?php 	if(count($builderdetail) > 0) { 
						foreach($builderdetail as $val){
				?>
				
				<div class="partners-box"><a href='<?php echo url() ?>/builder-detail/<?php echo $val->builder_id; ?>'><img src="<?php echo url(); ?>/uploads/builder_logo/<?php echo $val->logo; ?>"></a></div>
           <?php 		}
					} else{ echo "<li><em>Sorry, no featured builder found at this location.</em></li>"; }
			?>
            
            
            <div class="clr"></div>
    </div>
</div>
</div>

    <!-- Hidden field for showing property images next and prev. links of slider. -->
    
</section>
<script>
$('div.alert').delay(5000).slideUp(300);
$(window).on("scroll", function() {
    var fromTop = $("body").scrollTop();
	if ($(this).scrollTop() > 200){  
    $('#home_logo').addClass("show-logo");
    $('.hd_rt').addClass("log_sec");
  }
  else{
    $('#home_logo').removeClass("show-logo");
    $('.hd_rt').removeClass("log_sec");
  }
   
  });
  $(document).ready(function(){
  $('.main_slickslider').slick({
    dots: false,
	prevArrow: '',
	nextArrow: '',
	infinite: true,
	autoplay: true,
	speed: 300,
	slidesToShow: 1,
	adaptiveHeight: true
  });
});
  
</script>
 @include('common-modal')
  <style>
  #loading-indicator img {left: 50%;position: absolute;top: 50%;transform: translateX(-50%) translateY(-50%);z-index: 99999;}
  #loading-indicator::after {background: rgba(0, 0, 0, 0.898) none repeat scroll 0 0;content: "";height: 100%;left: 0;position: absolute;right: 0;top: 0;width: 1500px;z-index: 9999;}
  </style>
  <div id='loading-indicator' style=" display: none;">
    <img src="{{ URL::asset('assets/img/loading-x.gif') }}" alt="search">
</div>
@stop