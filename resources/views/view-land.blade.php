@extends('layout.default')

@section('content')

<div class="enquire-wrap">

<?php  //echo '<pre>'; print_r($landestates_arr); die;   ?>
<?php $land_arr =  $landestates_arr[0];  

?>
    <div class="en-bar">
        <div class="container">
            <div class="en-bae-left"><img src="<?php echo url(); ?>/uploads/landestate_logo/<?php echo $land_arr['logo'];  ?>" alt="image"></div>
            <div class="en-bae-right"><a class="en-btn lands_enquire" href="javascript:void(0);">Enquire</a></div>
            <div class="clr"></div>
        </div>
    </div>
	<input type="hidden" name="land_id" id="land_id" value="<?php echo $land_id ; ?>"/>
    <div class="en-main2">
	<?php if(count($land_arr['land_images']) > 1) { ?>
	<div class="pd-box2 pd-arrows">
                    <a style="color:#000 !important;" class="left-arrow1 main_slider_prev1" href="javascript:void(0);"><i class="fa fa-arrow-left"></i></a>
                    <a style="color:#000 !important;" class="right-arrow1 main_slider_next1" href="javascript:void(0);"><i class="fa fa-arrow-right"></i></a>
                </div>
		<?php } ?>
        <div class="enq-slides">
		<?php 
			if(!empty($land_arr['land_images'])) {
			foreach($land_arr['land_images'] as $land_val) { ?>
				<img src="<?php echo url(); ?>/uploads/land_images/<?php echo $land_val['image'];  ?>" alt="image">
		<?php 	} } ?>
		</div>
		<div class="en-sec2">
		   <h3><?php echo $land_arr['company_name'];  ?></h3>
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
					  <div class="en-sec3-left-top-box">
                        <a data-target='.floorplan' data-toggle='modal' href="javascript:void(0)" class="master_plan"><img src="<?php echo url(); ?>/assets/img/floor-icon1.png">
                        <h3>View Master Plan</h3></a>
						<p>&nbsp;</p>
                    </div>
                    <div class="clr"></div>
                </div>
		</div>
        <div class="en-sec3">
            <div class="en-sec3-left">
                <div class="en-sec3-left-btm">
                    <p><?php echo $land_arr['land_desc'];  ?></p>
                    </ul>
                </div>
            </div>
            <div class="en-sec3-right">
                <div class="en-sec3-right-form">
                    <h2>Request current land availability & price list</h2>
                    <div class="en-sec3-right-form-nner">
                        <label>Your details</label>
						<?php
							$user = Auth::user();
		if($user){
		$user_email = $user->email;
		$user_type = $user->user_type;
		$userdata = App\User::getnewuserinfo($user->id,$user_type);	
				$firstname = $userdata->firstname;
				$lastname = $userdata->lastname;
				if($user_type == 'User') {
				$phone = $userdata->phone;
				} else if($user_type == 'Builder' || $user_type == 'LandEstate'){
				$phone = $userdata->phn_no;
				}
				
		} else {
				$user_email = "";
				$firstname = "";
				$lastname = "";
				$phone = "";
		}
		if(!empty($firstname) && !empty($lastname)){
			$name = $firstname.' '.$lastname;
		} else {
			$name = "";
		}
		
		?>
						<form action="<?php echo url(); ?>/land/enquire/<?php  echo $land_id;  ?>" method="post">
						 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
                        <input type="text" name="name" placeholder="Name *" value="<?php echo $name; ?>">
                        <input type="text" name="email_id" placeholder="Email *" value="<?php echo $user_email;  ?>">
                        <input type="text" name="phn" placeholder="Phone *" value="<?php echo $phone;  ?>">
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
			</label><span>By using this form, I agree to the iCompareLoans <a href="http://www.icompareloans.com.au/" target="_blank">terms &amp; conditions</a>,<a href="http://www.icompareloans.com.au/" target="_blank">privacy policy</a></span></p>
                        <input type="submit" class="button1" value="Send">
						</form>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
    </div>
</div>
 <!-- For floorplan popup -->
  <div class="modal fade bs-example-modal-lg floorplan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header login_hdr">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
          <h4 class="modal-title">Master Plan</h4>
        </div>
		<div class="en-main">
        <div class="builder-form rate-form floor_popup"> <?php if(!empty($land_arr['master_plan'])) { ?>
	<img src="<?php echo url(); ?>/uploads/land_master_plan/<?php echo $land_arr['master_plan'];  ?>" alt="image">
	<?php } else { echo '<h2>No Master Plan</h2>'; } ?></div>
		</div>
 
  </div>
  </div>
  </div>
@stop