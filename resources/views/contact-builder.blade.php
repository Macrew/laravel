@extends('layout.default')

@section('content')	

<?php $prop_ids = Session::get('compare_ids'); ?>
<div class="step-indecator">
     <div class="step-search"><i class="fa fa-envelope"></i>
</div>
     <div class="container">
         <ul>
             <ul>
             <li class="step-font"><a href="<?php echo url(); ?>/property/search-property">Search</a></li>
             <li class="step-font"><a href="<?php echo url(); ?>/favourites/filter">Save</a></li>
             <li class="step-font"><a href="<?php echo url(); ?>/compare/?propertyids=<?php echo !empty($prop_ids)?$prop_ids:$_REQUEST['property_ids']; ?>">Compare</a></li>
             <li>Enquire</li>
         </ul>
         </ul>
     </div>
 </div>
  
 <div class="en-now-wrap">
    <div class="en-banner">
        <div class="en-banner-cap">
            <h3>Enquire now</h3>
            <p>We'll send the enquiry direct to your chosen builders, who will be in contact for a friendly and no-obligation chat.</p>
        </div>
    </div>  
    <div class="en-main">
            <div class="en-left">
                <div class="builder-form">
				<form action="<?php echo url(); ?>/property/enquire_builder/<?php echo $property_ids;  ?>" method="post">
				<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="text" placeholder="First name" name="first_name">
                <input type="text" placeholder="Last name" name="last_name">
                <input type="text" placeholder="Phone (include area code if not mobile)" name="phone">
                <input type="text" placeholder="Email" name="email">
                <select name="state">
                       	<option value="">State</option>
						<option value="ACT">ACT</option>
						<option value="NSW">NSW</option>
						<option value="NT">NT</option>
						<option value="QLD">QLD</option>
						<option value="SA">SA</option>
						<option value="TAS">TAS</option>
						<option selected="selected" value="VIC">VIC</option>
						<option value="WA">WA</option>
                </select>
                <select name="language">
                      <option value="">Preferred Language</option>
					  <option value="arabic">Arabic</option>
					  <option value="cantonese">Cantonese</option>
					  <option value="croatian">Croatian</option>
					  <option selected="selected" value="english">English</option>
					  <option value="french">French</option>
					  <option value="german">German</option>
					  <option value="greek">Greek</option>
					  <option value="hindi">Hindi</option>
					  <option value="italian">Italian</option>
					  <option value="japanese">Japanese</option>
					  <option value="korean">Korean</option>
					  <option value="macedonian">Macedonian</option>
					  <option value="mandarin">Mandarin</option>
					  <option value="punjabi">Punjabi</option>
					  <option value="serbian">Serbian</option>
					  <option value="spanish">Spanish</option>
					  <option value="tagalog">Tagalog</option>
					  <option value="urdu">Urdu</option>
					  <option value="vietnamese">Vietnamese</option>
					  <option value="other">Other</option>
                </select>				
                <select name="home_status">
                <option selected="selected" value="">Your home ownership status?</option>
				<option value="own">Own my own home</option>
				<option value="renting">Renting currently</option>
				<option value="recently_sold">Recently sold home</option>
				<option value="investing">Investing</option>
				<option value="own_land">Own land and plan to build</option>
				<option value="upgrading">Previously built planning to upgrade</option>
                </select>

                <select name="own_land">
                 <option selected="selected" value="">Do you own land for building?</option>
				<option value="yes">Yes</option>
				<option value="no">No</option>
				<option value="found">Found but not yet acquired</option>
                </select>

                <select name="secured_finance">
                <option selected="selected" value="">Have you secured finance?</option>
				<option value="true">Yes</option><option value="false">No</option>
				<option value="awaiting-approval">Awaiting approval</option>
				<option value="seeking_from_builder">Seeking from builder</option>
				<option value="no-answer">I prefer not to answer</option>
                </select>
				
                <textarea placeholder="Add and optional message" name="message" rows="5" cols="15"></textarea>
                <select name="contact_time">
                 <option selected="selected" value="">Best contact time</option>
				<option value="morning">Morning</option>
				<option value="afternoon">Afternoon</option>
				<option value="evening">Evening</option>
				<option value="weekends_only">Weekends Only</option>
				<option value="anytime">Anytime</option>
                </select>
				<p class="cp-left agree"><input type="checkbox" name="agree" id="agree" value="1" checked="checked" />
				<label for="agree">
                 </label>
				<span>I have read and agree to the iBuildNew Website<a href="<?php echo url(); ?>/terms-and-conditions"> Terms &amp; Conditions</a>,
                            <a href="<?php echo url(); ?>/privacy-policy">Privacy Policy</a>
				</span>
                       </p>		
                <input type="submit" value="Send Enquiry to Builder" class="button1">
				</form>
            </div>
            </div>
            <div class="en-right">
                <h1>Selected homes</h1>
                <div class="compare-pop"> 
                    <div class="cp-inner">
					<?php 
					
					if(!empty($property_arr)) {
					$count =  count($property_arr);  
					foreach($property_arr as $prop_val) {
					
					?>
                        <div class="cp-box">
                            <h2><?php echo $prop_val['builder_detail']['company_name']; ?></h2>
                            <p class="cp-cross"><?php if($count > 1) { ?><a href="<?php echo url(); ?>/property/remove?id=<?php echo $prop_val['id'];  ?>&property_ids=<?php echo $_REQUEST['property_ids']; ?>"/><i class="fa fa-times"></i></a> <?php  } ?></p>
                            <div class="cp-right">
                                <div class="cp-r-top">
                                    <?php
					$rand_key = "";
					if(!empty($prop_val['property_gallery'])) {
				  $rand_key = array_rand($prop_val['property_gallery'], 1); 
				 $prop_image =  	$prop_val['property_gallery'][$rand_key]['image'];
				 
				 ?>
                   <a href="<?php echo url(); ?>/propertydetail/<?php echo $prop_val['id'];  ?>" ><img src="<?php echo url();  ?>/uploads/property_gallery/<?php echo $prop_image;  ?>" alt=""></a>
				   <?php } ?>
                                   <h3><a href="<?php echo url(); ?>/propertydetail/<?php echo $prop_val['id'];  ?>"><?php echo $prop_val['property_title']; ?></a></h3>
                                   <p>From $<?php  echo number_format($prop_val['price'],2) ; ?><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="" data-original-title="The price or price range shown here is indicative only and will vary depending on the final inclusions, location of the build, the house façade and other customisations selected."></i></p>
                                </div>
                            </div>
                            <div class="clr"></div>
                        </div>
					<?php } } ?>
                    </div>
                </div>
				<?php if(!empty($ads_arr)) { ?> 
                <div class="add_model"><!--add section!-->
                   <?php foreach($ads_arr as $ads_val) { ?>
        	<h3>Get your free</h3>
            <div class="add_photo"><!--<div class="add_text"><h4>$<span>20</span> Voucher</h4></div> <div class="voucher-offer__plus"><span>plus</span></div>--> <img src="<?php echo url(); ?>/uploads/add_management/<?php echo $ads_val['image']; ?>" /></div>
            <p>Our independent home building guide with expert tips to save you time and money</p>
			<?php }   ?>
            <!--<div class="book"><img src="{{ URL::asset('assets/img/book.png') }}" /></div>
            <div class="enq_btn">When you enquire through icompare today. </div>-->
              </div>
			  <?php } ?>
            </div>
            <div class="clr"></div>
        </div> 
</div>

@stop