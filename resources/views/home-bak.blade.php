@extends('layout.default')

@section('content')	
<section class="slide_sec">
<?php 
				$url = url();
				$urlz = str_replace('http://www.', '', $url);
			?>
<div class="banner_logo"><a href="{{ url('/') }}" title='<?php echo $urlz; ?> Homepage'><img src="{{ URL::asset('assets/img/logo2.png') }}" /></a></div>
    <img src="{{ URL::asset('assets/img/slide.jpg') }}" class="full" />
    	<div class="slide_con">
		
				<div class="logoBottom"><a href="{{ url('/') }}" title='<?php echo $urlz; ?> Homepage'><img src="{{ URL::asset('assets/img/logo2.png') }}" /></a></div><!--logo section!-->
        	<!--<h2>Discover Your <span>Perfect Home</span></h2>-->
            <!--<h3>The most complete source of New Home Builders</h3>-->
                <div class="search-wrap">
               <label>Search Australia’s Best Builders</label>
				<form action="<?php echo url(); ?>/property/search-property" method="get" > 
                <div class="search-top">
                <?php
                $state = Session::get('header_state'); 
				
				$states = App\State::Getstates()->groupBy('state_name')->get();
				$states_arr = $states->toArray();
                ?>
                    <input type='hidden' id = 'ajax_searchstate' value = '<?php echo url()."/change-state-search"; ?>'>
                    <select class='single-story' id='main_regionchange' name="main_regionchange">
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
					<select  name="search_region" id ="search_region">
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
                    <input type="submit" name="submit">
                    <div class="clr"></div>
                </div>
                <!-----------new select 5 Jan 2016 ------------>
                <div class="select-wrap">
                    <select name="property_type">
					  <option value="All-Types" selected="selected">All property types</option>
                      <option value="Any">Any</option>
                      <option value="Single-Storey">Single Storey Homes</option>
                      <option value="Double-Storey">Double Storey Homes</option>
                      <option value="Homes-With-Alfrescos">Homes With Alfrescos</option>
                      <option value="Dual-occupancy-Homes">Dual-occupancy Homes</option>
                      <option value="Custom-Designs">Custom Designs</option>
                    </select>

					<select name="bedrooms" >
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
					

					<select name="bathrooms">
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
                    <select name="min_price">
                          <option value="min-price">Min price</option>
						<?php foreach($price_arr as $key => $price_val) { ?>
						  <option value="<?php echo $key ; ?>"><?php echo $price_val ; ?></option>
						  <?php } ?>
                    </select>
					

                    <select name="max_price">
                          <option value="max-price">Max price</option>
						<?php foreach($price_arr as $key => $price_val) { ?>
						  <option value="<?php echo $key ; ?>"><?php echo $price_val ; ?></option>
						  <?php } ?>
                    </select>
				</form>
                    <div class="clr"></div>
                </div>
                <!-----------new select 5 Jan 2016 ------------>
            </div>
            <!--<div class="home_ico"><img src="{{ URL::asset('assets/img/home_ico.png') }}" /></div>-->
        </div>

</section>


<section class="main_con">
	
    <div class="container">

        <div class="work_sec">
        	<!--<h2>Featuring top builders including</h2>-->
          	<ul class="logo_part">
			<?php 	if(count($builderdetail) > 0) { 
						foreach($builderdetail as $val){
				?>
            	<li><a href='<?php echo url() ?>/builder-detail/<?php echo $val->builder_id; ?>'><img src="<?php echo url(); ?>/uploads/builder_logo/<?php echo $val->logo; ?>" class= 'img-responsive' alt="image"></a></li>
           <?php 		}
					} else{ echo "<li><em>Sorry, no featured builder found at this location.</em></li>"; }
			?>
            </ul>
            
            <a href="<?php echo url(); ?>/ourbuilders" class="see_all">View building partners</a>
        </div>
		
		<div class="work_sec mobile-search-home">
        	<h2>Find a new home builder in just three simple steps</h2>
            
            <ul class="compare_sec">
            	<li>
                	<img src="{{ URL::asset('assets/img/search.png') }}" />
                	<h4 class="red">Search</h4>
                    <p>Set your location and any other relevant filters to refine your search.</p>
                </li>
               <li>
                	<img src="{{ URL::asset('assets/img/yellow.png') }}" />
                	<h4 class="yellow">Compare</h4>
                    <p>Select up to 4 new homes to compare features and inclusions side by side.</p>
                </li>
				 <li>
                	<img src="{{ URL::asset('assets/img/enquir.png') }}" />
                	<h4 class="blue">Enquire</h4>
                    <p>Send a request for more details directly to your builders of choice.</p>
                </li>
            </ul>
        </div>
        
        
         <div class="work_sec">
        	<h2>This weeks Featured designs</h2>
            <!--<h3>Featured homes on iCompareBuilders this week</h3>-->
          	<div class="property_main">
            	
                <div class="pro_row">
		<?php if(!empty($prop_arr)){
		if(count($prop_arr)>0){
					$i = 1;
					foreach($prop_arr as $val){
						$cls = '';
						if($i%3 == 0){
							$cls = 'no_mg';
						}
		?>
						<div class="pro_box <?php echo $cls; ?>">
						<div class="prop_header">
							<a href="<?php echo url(); ?>/builder-detail/<?php echo $val['property']['builder_id']; ?>"><div class="c_logo"><img src="<?php echo url(); ?>/uploads/builder_logo/<?php echo $val['property']['logo']; ?>" class= 'img-responsive' alt="image" /></div></a>
							<a href="<?php echo url(); ?>/propertydetail/<?php echo $val['property']['id']; ?>"><h4><?php echo $val['property']['property_title']; ?></h4></a>
							<h5>From $<?php  echo number_format($val['property']['price'],2) ; ?> </h5> 
						</div>
						<div class="star home-star">
				<?php  $check_save_prop =  App\Models\SaveProperty::check_new_save_prop($val['property']['id']) ;  ?>
                            	<a href="javascript:void(0);" rel="<?php echo $val['property']['id']; ?>" class="save_property_new" ><?php  if($check_save_prop != '0') { ?><img src="{{ URL::asset('assets/img/star_hover.png') }}" data-save_<?php echo $val['property']['id'];  ?>="Saved" id="save_src_<?php echo $val['property']['id']; ?>"><?php } else { ?><img src="{{ URL::asset('assets/img/star.png') }}" data-save_<?php echo $val['property']['id'];  ?>="Save" id="save_src_<?php echo $val['property']['id']; ?>"><?php } ?></a>
				</div>
							<div class="p_box model_img prop_image">
									<?php  
				
										if(!empty($val['property']['gallery'])) {
											foreach($val['property']['gallery'] as $prop_img) {
												//$profile_image = ImgProxy::link("uploads/property_gallery/".$prop_img['image'],50,50);
												echo '<a href="'.url().'/propertydetail/'.$val['property']['id'].'"><img src="'.url().'/uploads/property_gallery/'.$prop_img->image.'" class="gal_img" /></a>';
											}
										
										}
										else {
				
				echo '<a href="'.url().'/propertydetail/'.$val['property']['id'].'"><img src="'.url().'/assets/img/no-image.jpg" /></a>';
				}
										?>
							</div>   	
							<ul class="icon_set">
								<li>
									<i><img src="{{ URL::asset('assets/img/bed.png') }}" /> <span><em><?php echo $val['property']['bedrooms']; ?></em> beds</span></i>
								 </li>
							   <li>
									<i><img src="{{ URL::asset('assets/img/bath.png') }}" /> <span><em><?php echo $val['property']['bathrooms']; ?></em> bath</span></i>
								 </li>
								<li>
									<i><img src="{{ URL::asset('assets/img/sofa.png') }}" /> <span><em><?php echo $val['property']['living']; ?></em> living</span></i>
								 </li>
							   <li>
									<i><img src="{{ URL::asset('assets/img/size.png') }}" /> <span><em><?php echo $val['property']['housesize']; ?></em> sq</span></i>
								 </li>
							</ul>
							
							<ul class="button_set">
								<li>
									<a href="<?php echo url(); ?>/propertydetail/<?php echo $val['property']['id']; ?>"><img src="{{ URL::asset('assets/img/view.png') }}">View</a>
								</li>
								 <li>
                            	<a  class="open_enquirybox" value="Enquire to Builders"  data-target='.bs-example-modal-lg' data-id = '<?php echo $val['property']['id']; ?>'  href='javascript:void(0);' data-toggle='modal'><img src="{{ URL::asset('assets/img/message.png') }}">Enquire</a>
								</li>
								<li>
									<?php  $check_save_prop =  App\Models\SaveProperty::check_save_prop($val['property']['id']) ;  ?>
                            	<a href="javascript:void(0);" rel="<?php echo $val['property']['id']; ?>" class="save_property" ><?php  if($check_save_prop != '0') { ?><img src="{{ URL::asset('assets/img/comapre_hover.png') }}" id="compare_src_<?php echo $val['property']['id']; ?>"><?php } else { ?><img src="{{ URL::asset('assets/img/comapre.png') }}" id="compare_src_<?php echo $val['property']['id']; ?>"><?php } ?><span id="save_text_<?php echo $val['property']['id']; ?>"><?php  if($check_save_prop != '0') { echo 'Compared' ; } else { echo 'Compare' ; } ?></span></a>
								</li>
							</ul>
						</div>
           <?php  $i++;
					}
				}  }else{ echo "<em>Sorry, no featured property found at this location.</em>"; } ?>
                
                	
                <div class="clr"></div>
                </div>
                
            </div>
            
            <a href="<?php echo url() ?>/property/search-property" class="see_all">View all designs</a>
        </div>
		
		 <!--<div class="work_sec mobile-steps">
        	<h2>Four more reasons to use iCompareBuilders®</h2>
            <!--<h3>It's fast, free and easy.</h3>-->
            <!--<ul class="why_work">
            	<li class="yellow">
                	<img src="{{ URL::asset('assets/img/compare.png') }}" />
                	<h4>Compare all your options</h4>
                    <p>iCompareBuilders® is the market’s most comprehensive evaluation tool. In just a few clicks you can compare different builders, homes, and inclusions, until you’re confident that all options have been considered.</p>
                </li>
                <li class="red">
                	<img src="{{ URL::asset('assets/img/choose.png') }}" />
                	<h4>Make the right choice</h4>
                    <p>Taking the guesswork out of comparing homes has never been easier. Browse by projects and compare builders in a like-for-like manner to avoid unwanted surprises down the track.</p>
                </li>
                <li class="blue">
                	<img src="{{ URL::asset('assets/img/indi.png') }}" />
                	<h4>We are 100% independent</h4>
                    <p>We have no obligations to any builder, other than to present all project specifications true to their existing plans. With iCompareBuilders® there’s no sales pitch, just complete transparency.</p>
                </li>
                <li class="black">
                	<img src="{{ URL::asset('assets/img/easy.png') }}" />
                	<h4>It’s all at your fingertips</h4>
                    <p>Spare your weekends from hoping to stumble upon the perfect home. Compare with iCompareBuilders® for free and when you’re satisfied, submit your enquiry with the tap of a finger. It’s that easy!</p>
                </li>
            </ul>
        </div>-->
        
        
        
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
