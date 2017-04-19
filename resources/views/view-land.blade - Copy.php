@extends('layout.default')

@section('content')

<div class="enquire-wrap">

<?php  //echo '<pre>'; print_r($landestates_arr); die;   ?>
<?php $land_arr =  $landestates_arr[0];  ?>
    <div class="en-bar">
        <div class="container">
            <div class="en-bae-left"><img src="<?php echo url(); ?>/uploads/landestate_logo/<?php echo $land_arr['logo'];  ?>" alt="image"></div>
            <div class="en-bae-right"><a class="en-btn lands_enquire" href="javascript:void(0);">Enquire</a></div>
            <div class="clr"></div>
        </div>
    </div>
	<input type="hidden" name="land_id" id="land_id" value="<?php echo $land_id ; ?>"/>
    <div class="en-main2">
        <div class="enq-slides"><img src="<?php echo url(); ?>/uploads/land_images/<?php echo $land_arr['land_image'];  ?>" alt="image"></div>
        <div class="en-sec2">
            <h3><?php echo $land_arr['company_name'];  ?></h3>
            <h2><?php //echo $land_arr['title'];  ?></h2>
            <!--<div class="en-display">
			<?php  
			/* $display_lands_arr =  $land_arr['display_lands'];
			if(!empty($display_lands_arr)) {
			foreach($display_lands_arr as $display_land_val){ */
			
			?>
                <div class="display-home display-land">
							<div class="display-home-left">
							<img src="http://macrew.info/laravel/assets/img/map-pin.png">
							<strong><?php // echo $display_land_val['display_village_title']  ; ?></strong>
							<p><?php  //echo $display_land_val['display_location']  ; ?></p>
							</div>
							<div class="display-home-right">
							<a href="<?php //echo url(); ?>/land/display-land/<?php // echo  $display_land_val['land_id']; ?>">More info &amp; bookings</a>
							</div>
				</div>
               <?php // } } ?>
            </div>-->
        </div>
        
        <div class="en-sec3">
            <div class="en-sec3-left">
                <div class="en-sec3-left-top">
                    <div class="en-sec3-left-top-box">
                        <i class="fa fa-building"></i>
                        <h3>Price Range</h3>
                        <p><?php echo $land_arr['price_range'];  ?></p>
                    </div>
                    <div class="en-sec3-left-top-box">
                        <i class="fa fa-calendar"></i>
                        <h3>Established</h3>
                        <p><?php echo $land_arr['established'];  ?> </p>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="en-sec3-left-btm">
                    <p><?php echo $land_arr['land_desc'];  ?></p>
                    </ul>
                </div>
            </div>
            <div class="en-sec3-right">
                <div class="en-sec3-right-form">
                    <h2>Want to find out more?</h2>
                    <div class="en-sec3-right-form-nner">
                        <p>Drop us a line and someone will be in touch shortly about River Parks.</p>
                        <label>Your details</label>
						<form action="<?php echo url(); ?>/land/enquire/<?php  echo $land_id;  ?>" method="post">
						 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
                        <input type="text" name="name" placeholder="Name *">
                        <input type="text" name="email_id" placeholder="Email *">
                        <input type="text" name="phn" placeholder="Phone *">
                        <select name="lookingTo">
                             <option value="">About you: Please select</option>
		<option value="My house is on the market">My house is on the market</option>
		<option value="I have recently sold">I have recently sold</option>
		<option value="I am a first home buyer">I am a first home buyer</option>
		<option value="I am looking to invest">I am looking to invest</option>
		<option value="I am an overseas buyer">I am an overseas buyer</option>
		<option value="I am monitoring the market">I am monitoring the market</option>
                        </select>
                        <label>Your comments</label>
                        <textarea name="message" placeholder="Your Comments"></textarea>
                        <p class="cp-left agree"><input type="checkbox" id="land_agree" name="agree" value="1" checked="checked"><label for="land_agree">
			</label><span>By using this form, I agree to the icomparebuilders <a href="<?php echo url(); ?>/terms-and-conditions">terms &amp; conditions</a>,<a href="<?php echo url(); ?>/privacy-policy">privacy policy</a></span></p>
                        <input type="submit" class="button1" value="Send">
						</form>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
    </div>
</div>
@stop