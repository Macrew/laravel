<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<?php $url = url();
				$urlz = str_replace('http://www.', '', $url);
					$currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method); 
						 if($controller == 'CompareController' && $method == 'compare_property') { ?>
						 		<meta name="viewport" content="width=700, user-scalable=no">
						<?php  }
						 ?>
		 
		<meta name="_token" content="{!! csrf_token() !!}"/>
		<title><?php echo $title; ?></title>
		<link rel="shortcut icon" type="image/png" href="{{ URL::asset('assets/img/favicon.png') }}"/>
		<link rel="stylesheet" href="{{ URL::asset('assets/css/custom.css') }}" />
		<!--<link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">-->
		<link rel="stylesheet" href="{{ URL::asset('assets/css/style_new.css') }}"> 
		<!--<link rel="stylesheet" href="{{ URL::asset('assets/css/developer_style.css') }}"> -->
		<link rel="stylesheet" href="{{ URL::asset('assets/css/jquery.sidr.dark.css') }}">
		<!--<link href='https://fonts.googleapis.com/css?family=Raleway:400,300,700,600,500,800' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="{{ URL::asset('assets/css/font-awesome.css') }}" />-->
		<link rel="stylesheet" href="{{ URL::asset('assets/css/font-awesome.min.css') }}" />
		<!--<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700,900' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Noto+Serif:400,400italic' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700,700italic' rel='stylesheet' type='text/css'>-->
		<link href='https://fonts.googleapis.com/css?family=Asap:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
		<script src="{{ URL::asset('assets/js/jquery.js') }}"></script>
		<script src="{{ URL::asset('assets/js/jquery-ui.js') }}"></script>
		<script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
		<script src="{{ URL::asset('assets/js/bootstrap-select.js') }}"></script>
		<script src="{{ URL::asset('assets/js/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ URL::asset('assets/js/datatables/dataTables.bootstrap.js') }}"></script>
		<!--<script src="{{ URL::asset('assets/js/responsive-tabs.js') }}"></script>-->
		<script src="{{ URL::asset('assets/rangeslider/nouislider.min.js') }}"></script>
		<script src="{{ URL::asset('assets/rangeslider/wNumb.js') }}"></script>
		<script src="{{ URL::asset('assets/js/dropzone.js') }}"></script>
		<script src="{{ URL::asset('assets/js/jquery.fancybox.pack.js') }}"></script>
		<script src="{{ URL::asset('assets/js/responsiveImg.js') }}"></script>
		<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('assets/css/jquery-ui.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap-select.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('assets/css/dataTables.bootstrap.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('assets/slick-master/slick/slick.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('assets/rangeslider/nouislider.min.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('assets/css/generic-notForTabs.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('assets/css/jquery.fancybox.css') }}" />
		
		<link rel="stylesheet" href="{{ URL::asset('assets/css/responsive-tabs.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('assets/css/dropzone.css') }}" />
		<link rel="stylesheet" href="{{ URL::asset('assets/datepicker/bootstrap-datepicker.css') }}" />
		 <script src="{{ URL::asset('assets/thumbnailslider/pgwslider.js') }}"></script>
         <link href="{{ URL::asset('assets/thumbnailslider/pgwslider.css') }}" rel="stylesheet" type="text/css" />
		
		<link rel="stylesheet" href="{{ URL::asset('assets/mobile-menu/dist/stylesheets/jquery.sidr.dark.css') }}">
		<script type="text/javascript" src="{{ URL::asset('assets/mobile-menu/dist/jquery.sidr.min.js') }}"></script>
		<!--<link rel="stylesheet" href="{{ URL::asset('assets/css/mtree.css') }}" />-->

	</head>
<?php //if(isset($userdata)){echo '<pre>'; print_r($userdata); echo '</pre>';}?>
	<body>
	<style>
	.show-logo
	{
		display:block !important;
	}
	</style>
		<input type="hidden" name="base_url" id="base_url"  value="<?php echo url(); ?>" />
			<div id="list-loading-message" class="map-list-loader-container loading" style="display:none">
    <div id="loader" class="map-list-loader">
    <span class="zsg-loading-spinner"><img src="<?php echo url() ; ?>/assets/img/facebook-loader.gif"></span></div>
   </div>
   	@if(Session::has('success'))
			<div class="alert alert-success" style='text-align:center'><em> {!! session('success') !!}</em></div>
		@endif
		@if(Session::has('error'))
			<div class="alert alert-danger" style='text-align:center'><em> {!! session('error') !!}</em></div>
		@endif	
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
		<header class="header <?php  if($controller != 'HomeController' && $method != 'index') {  echo 'inn_head' ; } ?> ">
		 <?php  
	
		 $save_prop =  App\Models\SaveProperty::get_house_saved_property() ;

		 $houseland_save_prop =  App\Models\SaveProperty::get_houseland_saved_property() ;
		
					 
			  $countsave_prop =  App\Models\SaveProperty::count_saved_property() ; 
			  $compare_url =  App\Models\SaveProperty::set_save_propids() ; 
			  $compare_house_url =  App\Models\SaveProperty::set_save_house_propids() ; 
			  ?>
			
	<div id="save_ajax_content">
			 
			<div class="compare-pop inner_ajax_content<?php //if($controller != 'HomeController' && $method != 'index') { echo 'inner_ajax_content'; }  ?>  main-pop-up" style="display:none;" >
			
    <div class="cp-head">
	 <div class="cp-row">
   <ul>
   <li id="house-div" class="comp-active"><a href="javascript:void(0)" >House</a></li>
   <li id="house-land-div"><a href="javascript:void(0)" >House & Land</a></li>
   </ul>
   </div>
   
   <div class="cp-row" id="house-head">
        <h2><i class="fa fa-bar-chart"></i><?php echo $save_prop['total_home_designs'] ; ?> Compared Homes</h2>
        <p><a href="<?php echo url(); ?>/favourites/filter">View all saved homes</a></p>
	</div>	
	
	<div class="cp-row" id="house-land-head" style="display:none;">
        <h2><i class="fa fa-bar-chart"></i> <?php echo $houseland_save_prop['total_house_land'] ; ?> Compared Homes</h2>
        <p><a href="<?php echo url(); ?>/favourites/filter">View all saved homes</a></p>
	</div>	
        <div class="clr"></div>
		
    </div>
	
    
	
	<input type="hidden" id="compare_url" value="<?php echo $compare_url ; ?>" />
	
	<?php  

		if(!empty($save_prop['prop_home_designs']))
		{  
			
		?>
		
		<div class="cp-inner" id="inner-house">
		
		<?php
			$i=1;
			foreach($save_prop['prop_home_designs'] as $save_prop_val) {
	
	?>
        <div class="cp-box">
            <p class="cp-cross"><i class="fa fa-times delsaveprop"  rel="<?php echo $save_prop_val['id'];  ?>" ></i></p>
            <div class="cp-left">
			<?php  if($i <= 4) { ?>	
			<input type="checkbox" id="savecheck_<?php echo $save_prop_val['id'];  ?>" value="<?php echo $save_prop_val['id'];  ?>" name="savecheck" checked="checked" />
			<?php } else {  ?>
			<input type="checkbox" id="savecheck_<?php echo $save_prop_val['id'];  ?>" value="<?php echo $save_prop_val['id'];  ?>" name="savecheck" />
			<?php } ?>
			<label for="savecheck_<?php echo $save_prop_val['id'];  ?>">
			</label></div>
            <div class="cp-right">
                <div class="cp-r-top">
				<?php
$rand_key = "";
					if(!empty($save_prop_val['property_gallery'])) {
				  $rand_key = array_rand($save_prop_val['property_gallery'], 1); 
				 $prop_image =  	$save_prop_val['property_gallery'][$rand_key]['image'];
				 if(!empty($prop_image))
				 {
					//$prop_new_image = url().'/uploads/property_gallery/'.$prop_image;
					$prop_new_image = '/uploads/property_gallery/'.$prop_image;
				 } else {
					//$prop_new_image = url().'/assets/img/no-image.jpg';
					$prop_new_image = '/assets/img/no-image.jpg';
				 }
				 ?>
                   <a href="<?php echo url(); ?>/propertydetail/<?php echo $save_prop_val['id']; ?>"><img src="<?php echo url(); ?>/public/timthumb.php?src=<?php echo $prop_new_image;  ?>&h=100&w=145&q=1000" class="gal_img" alt=""></a>
				   <?php } else {
						$prop_new_image = url().'/assets/img/no-image.jpg';
				   ?>
				   <a href="<?php echo url(); ?>/propertydetail/<?php echo $save_prop_val['id']; ?>"><img src="<?php echo $prop_new_image;  ?>" alt=""></a>
				   <?php } ?>
                   <a href="<?php echo url(); ?>/propertydetail/<?php echo $save_prop_val['id']; ?>"><h3><?php echo $save_prop_val['property_title'] ; ?></h3></a>
                   <p>From $<?php echo number_format($save_prop_val['price'],2) ; ?></p>
                </div>
                <div class="cp-r-btm">
                    <span><img src="{{ URL::asset('assets/img/bed-green.png') }}" alt="bed"> <?php echo $save_prop_val['bedrooms'] ; ?></span>
                    <span><img src="{{ URL::asset('assets/img/bathroom.png') }}" alt="bathroom"> <?php echo $save_prop_val['bathrooms'] ; ?></span>
                    <span><img src="{{ URL::asset('assets/img/living.png') }}" alt="sofa"> <?php echo $save_prop_val['living'] ; ?></span>
                    <span><img src="{{ URL::asset('assets/img/house-size.png') }}" alt="size"> <?php echo $save_prop_val['housesize'] ; ?></span>
                </div>
				<div class="cp-r-blogo">
				<a href="<?php echo url(); ?>/builder-detail/<?php echo $save_prop_val['builder_detail']['builder_id']; ?>" ><img src="<?php echo url(); ?>/uploads/builder_logo/<?php echo $save_prop_val['builder_detail']['logo'];   ?>"/></a> 
				</div> 
            </div>
            <div class="clr"></div>
        </div>
		<?php $i++ ; }  ?>
    </div>
	
	<div class="cp-footer" id="house_footer">
        <input type="submit" value="Compare" class="button1 compare"><p class="cp-footer-btm">select up to 4 homes</p>
        <div class="clr"></div>
    </div>
	
	<?php } else { echo '<div class="cp-inner" id="inner-house"><p style="text-align:center;">Save some homes to get started!</p></div>';   } ?>

	<?php  
	
		
		if(!empty($houseland_save_prop['prop_house_arr']))
		{
		?>
		<div class="cp-inner" id="inner-house-land" style="display:none;">
	<?php	
	
	$i=1;
			foreach($houseland_save_prop['prop_house_arr'] as $save_prop_val) {
	
	?>
        <div class="cp-box">
            <p class="cp-cross"><i class="fa fa-times delsaveprop"  rel="<?php echo $save_prop_val['id'];  ?>" ></i></p>
            <div class="cp-left">
			<?php  if($i <= 4) { ?>	
			<input type="checkbox" id="savecheck_<?php echo $save_prop_val['id'];  ?>" value="<?php echo $save_prop_val['id'];  ?>" name="savecheck" checked="checked" />
			<?php } else {  ?>
			<input type="checkbox" id="savecheck_<?php echo $save_prop_val['id'];  ?>" value="<?php echo $save_prop_val['id'];  ?>" name="savecheck" />
			<?php } ?>
			<label for="savecheck_<?php echo $save_prop_val['id'];  ?>">
			</label></div>
            <div class="cp-right">
                <div class="cp-r-top">
				<?php
$rand_key = "";
					if(!empty($save_prop_val['property_gallery'])) {
				  $rand_key = array_rand($save_prop_val['property_gallery'], 1); 
				 $prop_image =  	$save_prop_val['property_gallery'][$rand_key]['image'];
				 if(!empty($prop_image))
				 {
					//$prop_new_image = url().'/uploads/property_gallery/'.$prop_image;
					$prop_new_image = '/uploads/property_gallery/'.$prop_image;
				 } else {
					//$prop_new_image = url().'/assets/img/no-image.jpg';
					$prop_new_image = '/assets/img/no-image.jpg';
				 }
				 ?>
                   <a href="<?php echo url(); ?>/propertydetail/<?php echo $save_prop_val['id']; ?>"><img src="<?php echo url(); ?>/public/timthumb.php?src=<?php echo $prop_new_image;  ?>&h=100&w=145&q=1000" class="gal_img" alt=""></a>
				   <?php } else {
						$prop_new_image = url().'/assets/img/no-image.jpg';
				   ?>
				   <a href="<?php echo url(); ?>/propertydetail/<?php echo $save_prop_val['id']; ?>"><img src="<?php echo $prop_new_image;  ?>" alt=""></a>
				   <?php } ?>
                   <a href="<?php echo url(); ?>/propertydetail/<?php echo $save_prop_val['id']; ?>"><h3><?php echo $save_prop_val['property_title'] ; ?></h3></a>
                   <p>From $<?php echo number_format($save_prop_val['price'],2) ; ?></p>
                </div>
                <div class="cp-r-btm">
                    <span><img src="{{ URL::asset('assets/img/bed-green.png') }}" alt="bed"> <?php echo $save_prop_val['bedrooms'] ; ?></span>
                    <span><img src="{{ URL::asset('assets/img/bathroom.png') }}" alt="bathroom"> <?php echo $save_prop_val['bathrooms'] ; ?></span>
                    <span><img src="{{ URL::asset('assets/img/living.png') }}" alt="sofa"> <?php echo $save_prop_val['living'] ; ?></span>
                    <span><img src="{{ URL::asset('assets/img/house-size.png') }}" alt="size"> <?php echo $save_prop_val['housesize'] ; ?></span>
                </div>
				<div class="cp-r-blogo">
				<a href="<?php echo url(); ?>/builder-detail/<?php echo $save_prop_val['builder_detail']['builder_id']; ?>" ><img src="<?php echo url(); ?>/uploads/builder_logo/<?php echo $save_prop_val['builder_detail']['logo'];   ?>"/></a> 
				</div> 
            </div>
            <div class="clr"></div>
        </div>
		<?php $i++ ; }  ?>
    </div>
	
	
	<div class="cp-footer" id="house_land_footer" style="display:none;" >
        <input type="submit" value="Compare" class="button1 compare-house"><p class="cp-footer-btm">select up to 4 homes</p>
        <div class="clr"></div>
    </div>
	<input type="hidden" id="compare_house_url" value="<?php echo $compare_house_url ; ?>" />
	<?php  } else { echo '<div class="cp-inner" id="inner-house-land" style="display:none;"><p style="text-align:center;">Save some homes to get started!</p></div>';   } ?>
</div>  
	</div>	
		
			<?php 
				
			/*	  if($controller != 'HomeController' && $method != 'index') { 
			?>
				<div class="logo"><a href="{{ url('/') }}" title='<?php echo $urlz; ?> Homepage'><img src="{{ URL::asset('assets/images/logo.png') }}" /></a></div><!--logo section!-->
				<?php }*/ ?>
				<div class="logo"  id="home_logo"><a href="{{ url('/') }}" title='<?php echo $urlz; ?> Homepage'><img src="{{ URL::asset('assets/images/logo.png') }}" /></a></div>
				<div class="menu_main">
					<ul><!-- side menu section!-->
						<li class="menu"><a href="<?php echo url(); ?>/land/display-land">Land Estates</a></li>
						<li class="menu"><a href="<?php echo url(); ?>/house-and-lands">House and Land</a></li>
						<li class="menu"><a href="<?php echo url(); ?>/ourbuilders">Builders</a></li>
					</ul>
				</div>
				<div class="toogle-menu side_menu"><a id="right-menu" class="right-menu" href="#right-menu"><img src="{{ URL::asset('assets/images/menu-icon.png') }}" alt="toogle menu"></a>
 
					<div id="sidr-right" class="sidr right">
						<ul class="lt_menu"><!-- side menu section!-->
							<li class="menu side_mainmenu"><a href="<?php echo url(); ?>/land/display-land">Land Estates</a></li>
							<li class="menu side_mainmenu"><a href="<?php echo url(); ?>/house-and-lands">House and Land</a></li>
							<li class="menu side_mainmenu"><a href="<?php echo url(); ?>/ourbuilders">Builders</a></li>
						
							<li class="menu"><a href="{{ url('aboutus') }}">About us</a></li>
							<li class="menu"><a href="{{ url('testimonials') }}">Testimonials</a></li>
							<li class="menu"><a href="{{ url('blog') }}">Blog</a></li>
							<li class="menu"><a href="{{ url('contactus') }}">Contact us</a></li>
							<li class="menu"><a href="{{ url('terms-and-conditions') }}">Terms & Conditions</a></li>
							<li class="menu"><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
							<li class="menu"><a href="{{ url('help') }}">Help</a></li>
						</ul>
					</div>
				</div>
				<!--<div class="sidr-right sidr right" id="sidr right">
					<ul class="lt_menu">
						<!--<li><a href="#">Browse <i class="fa fa-angle-down"></i></a>
						<ul class="sub_menu">
                    	<li><a href="#">Your Saved Homes(0)</a></li>
                        <li><a href="#">Single Storey Homes</a></li>
                        <li><a href="#">Double Storey Homes</a></li>
                        <li><a href="#">Homes With Alfrescos</a></li>
                        <li><a href="#">Dual-occupancy Homes</a></li>
                        <li><a href="<?php //echo url(); ?>/properties">Browse All Designs</a></li>
                    </ul>
						</li>-->
						<!--<li class="menu"><a href="<?php echo url(); ?>/land/display-land">Land Estates</a></li>
						<li class="menu"><a href="<?php echo url(); ?>/house-and-lands">House and Land</a></li>
						<li class="menu"><a href="<?php echo url(); ?>/ourbuilders">Builders</a></li>
						
						<li class="menu"><a href="#">More  <i class="fa fa-angle-down"></i></a>
							<ul class="sub_menu">
								<li class="menu"><a href="{{ url('aboutus') }}">About us</a></li>
								<li class="menu"><a href="{{ url('testimonials') }}">Testimonials</a></li>
								<li class="menu"><a href="{{ url('blog') }}">Blog</a></li>
								<li class="menu"><a href="{{ url('contactus') }}">Contact us</a></li>
								<li class="menu"><a href="{{ url('terms-and-conditions') }}">Terms & Conditions</a></li>
								<li class="menu"><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
								<li class="menu"><a href="{{ url('help') }}">Help</a></li>
							</ul>
						</li>
					</ul>
				</div>-->
				</div>
				<ul class="head-right">
				   
				   
				   @if( Auth::check() )
						 <li>
							<a href="{{ url('logout') }}"><img src="{{ URL::asset('assets/images/login-icon.png') }}" alt="Logout" />
								<span>Logout</span>
							</a>
					   </li>
					@else
						<li>
						   <a href='javascript:void(0)' class="open_enquirybox" value="Enquire to Builders"   data-target='.register-modal-lg' data-toggle='modal'><img src="{{ URL::asset('assets/images/join.png') }}" alt="Join" />
							<span>Join</span>
						   </a>
					   </li>
					   <li>
							  <a href='javascript:void(0)' data-target='.login-modal-lg' data-toggle='modal'><img src="{{ URL::asset('assets/images/login-icon.png') }}" alt="Login" />
								<span>Login</span>
							  </a> 
						</li>
					@endif
					   
				  
				   <li>
					   <a href="javascript:void(0);" class="register"><img src="{{ URL::asset('assets/images/compare-icon.png') }}" alt="Compare" />
						<span>Compare</span>
					   </a>
				   </li>
				</ul>
				<!--	<ul>
					<li class="ph_num">1800 824 823</li>
					<?php  
					
					$state = Session::get('header_state'); 
					$user = Auth::user();
					if($user){
						$userdata = App\User::getuserinfo($user->id);	
					}
					
					?>
						<input type="hidden" name="header_state" value="<?php if(!empty($state)) { echo $state ; } else { echo $state = 'VIC' ; } ?>" />
						<!--<li>
							<a href="#"><?php //if(!empty($state)) { echo $state ; } else { echo $state = 'VIC' ; }   ?> <i class="fa fa-angle-down"></i></a>
							<ul class="sub_menu">
								<li><a href="<?php //echo url(); ?>/change-state/VIC">VIC</a></li>
								<li><a href="<?php //echo url(); ?>/change-state/QLD">QLD</a></li>
								<li><a href="<?php //echo url(); ?>/change-state/NSW">NSW</a></li>
								<li><a href="<?php //echo url(); ?>/change-state/WA">WA</a></li>
							</ul>
						</li>-->
				<!--	@if( Auth::check() )
						@if(Auth::user()->user_type == 'Builder')
						<li><a class ='menu_ancor' href="javascript:void(0);">{{{ Auth::user()->username }}} <i class="fa fa-angle-down"></i></a>
							<ul class='sub_menu'>
								<li><a href="{{ url('propertymanagement') }}">Manage Properties</a></li>
								<li><a href="{{ url('builder/house-and-land') }}">Manage House and Land</a></li>
								<!--<li><a href="{{ url('addmanagement') }}">Manage Ads</a></li>-->
			<!--					<li class="ad_perf_tab"><a href="#" class="ads_tab">Ad Performance</a>
								<?php $numbenq = App\User::get_builder_enquires($user->id);	
									  $numsavedprop = App\User::get_builder_saved_properties($user->id);
									  $numpropview = App\User::get_property_view($user->id);
								?>
								  <p><?php echo $numbenq ; ?>  enquiries - <a href="jaavscript:void(0);">view all messages</a></p>
								  <!--<p>35,708 result views</p>-->
					<!--			  <p><?php echo $numpropview ; ?> detail views</p>
								  <p><?php echo $numsavedprop ; ?> people have saved your property</p>
								</li>
								<li><a href="{{ url('logout') }}">Logout</a></li>
							</ul>
						</li>
						@else
						<li><a href="javascript:void(0);"><?php if(isset($userdata)){echo $userdata->firstname.' '.$userdata->lastname; } ?> <i class="fa fa-angle-down"></i></a>
							<ul class='sub_menu'>
								<li><a href="{{ url('favourites/filter') }}">Your Saved Homes</a></li>
								<li><a href="{{ url('logout') }}">Logout</a></li>
							</ul>
						</li>
						@endif
					@else
					<?php 
					$state = "";
					$state = Session::get('header_state');
					
					?>
						<li><a href='javascript:void(0)' data-target='.login-modal-lg' data-toggle='modal'>Login</a></li>
						<li class="join"><a href='javascript:void(0)' class="open_enquirybox" value="Enquire to Builders"   data-target='.register-modal-lg' data-toggle='modal'>Join</a></li>
					@endif
					</ul>
					
					<!--<a href="#" class="phone"><i class="fa fa-mobile-phone"></i></a>-->
					
				<!--	<a href="javascript:void(0);" class="register"><i class="fa fa-bar-chart"></i> <i class="circle"><span id="saved_homes"><?php echo $countsave_prop ; ?></span> </i>  <span class="cmp">Compared</span></a>
	
				</div>-->
				<div class="clr">

		</header>
        <div class="bottomSlide" id="saved_alert" style="display:none;">
        	<div class="container">
            	<div class="starIcon"><img src="{{ URL::asset('assets/img/star-header.png') }}" alt=""></div>
                <div class="designDetail">
                	<h4>You’ve saved 3 designs</h4>
                    <p><a href="javascript:void(0);" data-toggle="modal" data-target=".login-modal-lg">Login</a> or <a href="javascript:void(0)" class="open_enquirybox" data-target='.register-modal-lg' data-toggle='modal'>Register</a> to save more than 3 designs and access them on <br/> any device.</p>
                </div>
                <div class="buttons">
                	<a class="login" data-toggle="modal" data-target=".login-modal-lg" href="javascript:void(0);">Login</a>
                    <a class="savedDesign" href="<?php echo url(); ?>/favourites/filter">View saved designs</a>
                    <div class="clearfix"></div>
                </div>
                <a class="closeBottomSlide" href="javascript:void(0);">X Close</a>
            </div>
        </div>
		<!--<div class="head_empty"></div>-->
		<?php if($controller != 'HomeController' && $method != 'index') { ?><div class="spacer_new"></div><?php } ?>
	
		@yield('content')
		
		<?php // echo Route::getCurrentRoute()->getActionName(); 
						
						 $currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method);
						 if($controller == 'PropertyController' && $method == 'display_villages'  || $controller == 'LandEstateController' && $method == 'display_lands') {
						 
						 } else {  ?>
<footer class="footer">
     <div class="container">
        <div class="f-box1">
            <a href=""><img src="{{ URL::asset('assets/images/footer-logo.png') }}" alt="logo" /></a>
            <p>Images depicted on this site are for illustration purposes only. Facades and other images of homes may include optional upgrades, additional fixtures, finishes and features that are not included in the base price of the home such as landscaping, feature tiling, decking, furnishing, feature lighting, pools, etc. Any prices or price range shown on this site are indicative only and will vary depending on final inclusions, locations of build, house façade and other customisations.</p>
            <h3>Partners</h3>
			<?php 
				$where_arr = array('user_type'=>'partner');
		
				$category = App\User::with('partners')->where($where_arr)->get();
				$partner = $category->toArray();
				if(count($partner) > 0){
					foreach($partner as $val){
						if($val['partners']['logo'] != ''){ ?>
							<a href='<?php echo $val['partners']["link"]; ?>' target='_blank'><img src="<?php echo url(); ?>/uploads/partner_logo/<?php echo $val['partners']['logo'];  ?>" style='width: 220px;'/></a><br />
				<?php	}
					}
				 } ?>
        </div>
        <div class="f-box2">
            <div class="subscribe">
                <p>Join to receive on-going updates, promo’s & tips from iCompareBuilders</p>
				<span id = 'message_er' style='color:#9C0E0E;font-size: 19px;' style='display:none;'></span>
          		<span id = 'message_suc' style='color:#71B238;font-size: 19px;' style='display:none;'></span>
				{!! Form::open(array('class' => 'form','enctype'=>"multipart/form-data", 'autocomplete'=>'off','url'=>'subscribe','id'=>'subscription_form')) !!}
					<!--<input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">-->
					<input type="text" name = 'email' placeholder="Email address" requied id = 'subsc_email'/>	
					<input type="submit" name="subscribe" value="Subscribe" />
				{!! Form::close() !!}
                <p>Speak to your new home building consultant today for free</p>
            </div>
            <div class="phone">
                <img src="{{ URL::asset('assets/images/phone-icon.png') }}" alt="phone" />
                <p><a href="tel:1800 824 823">1800 824 823</a></p>
            </div>
            <div class="follow">
                <p>Follow us on</p>
                <ul>
                    <li><a href="https://www.facebook.com/icomparebuilders/" target="_blank"><img src="{{ URL::asset('assets/images/facebook.png') }}" alt="facebook"></a></li>
                    <li><a href=""><img src="{{ URL::asset('assets/images/linkedin.png') }}" alt="Linkedin"></a></li>
                    <li><a href=""><img src="{{ URL::asset('assets/images/pintrest.png') }}" alt="Pinterest"></a></li>
                    <li><a href=""><img src="{{ URL::asset('assets/images/youtube.png') }}" alt="Youtube"></a></li>
                </ul>
            </div>
        </div>
        <div class="f-box3">
            <div class="f-box3-menu">
                <h3>Company</h3>
				<a href="{{ url('aboutus') }}">About</a>
				<a href="{{ url('blog') }}">Blog</a>
				<a href="{{ url('contactus') }}">Contact Us</a>
            </div>
            <div class="f-box3-menu">
                <h3>Homes & Builders</h3>
                <a href="<?php echo url(); ?>/ourbuilders">Builders</a>
				<a href="{{ url('favourites/filter') }}">Your Saved Homes</a>
                <a href="<?php echo url(); ?>/ourbuilders/VIC">VIC Builders</a>

				
            </div>
            <div class="f-box3-menu">
                <h3>For Builders</h3>
				@if( !Auth::check() )
						<a href='javascript:void(0)' alue="Enquire to Builders"   data-target='.builder-login-modal-lg' data-toggle='modal'>Builder Sign In</a>
				@endif
				<a href="<?php echo url(); ?>/builder-enquiry">Builder Enquiries</a>
            </div>
            <div class="f-box3-menu">
                <h3>Account</h3>
				@if( !Auth::check() )
					<a href='javascript:void(0)' class="open_enquirybox" value="Enquire to Builders"   data-target='.login-modal-lg' data-toggle='modal'>Login</a>
					<a href='javascript:void(0)' class="open_enquirybox" value="Enquire to Builders"   data-target='.register-modal-lg' data-toggle='modal'>Join</a>
				@endif
				<a href="<?php echo url(); ?>/reset">Reset Site</a> 
            </div>
            <div class="clr"></div>
            <p>Terms & Conditions Privacy Policy <br>© 2016 iCompareBuilders Pty Ltd. All rights reserved</p>
        </div>
        <div class="clr"></div>
     </div>
</footer>
<script type="text/javascript">
var _dcq = _dcq || [];
var _dcs = _dcs || {};
_dcs.account = '9992693';

(function() {
var dc = document.createElement('script');
dc.type = 'text/javascript'; dc.async = true;
dc.src = '//tag.getdrip.com/9992693.js';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(dc, s);
})();
</script>
		<!--<footer> 
			<div class="container">

				<div class="f_left">
					<h3>Company</h3>
					<ul>
						<li><a href="{{ url('aboutus') }}">About</a></li>
						<li><a href="{{ url('blog') }}">Blog</a></li>
						<li><a href="{{ url('contactus') }}">Contact Us</a></li>
					</ul>
				</div>
				
				<div class="f_left">
					<h3>Homes & Builders</h3>
					<ul>
						<!--<li><a href="#">Browse Homes</a></li>-->
					<!--	<li><a href="<?php echo url(); ?>/ourbuilders">Builders</a></li>
						<li><a href="{{ url('favourites/filter') }}">Your Saved Homes</a></li>
					<?php 	$states = App\State::Getstates()->groupBy('state_name')->get();
						$states_arr = $states->toArray(); 
						if(!empty($states_arr))	 {
							foreach($states_arr as $state_val) {
							?>
						<li><a href="<?php echo url(); ?>/ourbuilders/<?php echo $state_val['state_name']; ?>"><?php echo $state_val['state_name']; ?> Builders</a></li>
						<?php } } ?>
						<!--<li><a href="<?php //echo url(); ?>/ourbuilders/NSW">NSW Builders</a></li>
						<li><a href="<?php //echo url(); ?>/ourbuilders/QLD">QLD Builders</a></li>
						<li><a href="<?php //echo url(); ?>/ourbuilders/WA">WA Builders</a></li>
						<li><a href="<?php //echo url(); ?>/ourbuilders/TAS">TAS Builders</a></li>
						<li><a href="<?php //echo url(); ?>/ourbuilders/SA">SA Builders</a></li>
						<li><a href="<?php //echo url(); ?>/ourbuilders/NT">NT Builders</a></li>-->
		<!--			</ul>
				</div>
				
				<div class="f_left">
					<h3>For Builders</h3>
					<ul>
						@if( !Auth::check() )
								<li><a href='javascript:void(0)' alue="Enquire to Builders"   data-target='.builder-login-modal-lg' data-toggle='modal'>Builder Sign In</a></li>
						@endif
						<li><a href="<?php echo url(); ?>/builder-enquiry">Builder Enquiries</a></li>
					</ul>
				</div>
				
				<div class="f_left">
					<h3>Account</h3>
					<ul>
						@if( !Auth::check() )
							<li><a href='javascript:void(0)' class="open_enquirybox" value="Enquire to Builders"   data-target='.login-modal-lg' data-toggle='modal'>Login</a></li>
							<li><a href='javascript:void(0)' class="open_enquirybox" value="Enquire to Builders"   data-target='.register-modal-lg' data-toggle='modal'>Join</a></li>
						@endif
						<li><a href="<?php echo url(); ?>/reset">Reset Site</a></li>
					</ul>
				</div>
				<?php 
				$where_arr = array('user_type'=>'partner');
		
				$category = App\User::with('partners')->where($where_arr)->get();
				$partner = $category->toArray();
				//echo '<pre>';print_r($partner); echo '</pre>';
				?>
				<div class="f_left no_mg">
					<h3>Partners</h3>
					<?php 
						if(count($partner) > 0){
							foreach($partner as $val){
								if($val['partners']['logo'] != ''){ ?>
									<a href='<?php echo $val['partners']["link"]; ?>' target='_blank'><img src="<?php echo url(); ?>/uploads/partner_logo/<?php echo $val['partners']['logo'];  ?>" style='width: 220px;'/></a><br />
						<?php	}
							}
						 } ?>
					
				</div>
				<div class="clr"></div>
				<div class="bottom_f">
				<div class="news_sec">
					<h2>Join to receive on-going updates, promo’s & tips from iCompareBuilders</h2>
					<span id = 'message_er' style='color:#9C0E0E;font-size: 19px;' style='display:none;'></span>
          			<span id = 'message_suc' style='color:#71B238;font-size: 19px;' style='display:none;'></span>
					<form action='<?php echo url(); ?>/subscribe' method='post' id = 'subscription_form'>
						<input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
						<div class="news_main">
							<input type="email" name = 'email' placeholder="Email address" requied id = 'subsc_email'/>
							<input type="submit" value="Subscribe"/>
							<div class="clr"></div>
						</div>
					</form>
					<div class="social_ico"><a href="https://www.facebook.com/icomparebuilders/" target="_blank">
					<img src="{{ URL::asset('assets/img/f.png') }}" /></a> 
					<a href=""><img src="{{ URL::asset('assets/img/y.png') }}" /></a> 
					<a href="https://www.instagram.com/icomparebuilders/" target="_blank"><img src="{{ URL::asset('assets/img/in.png') }}" /></a>
					<a href="" target="_blank"><a href=""><img src="{{ URL::asset('assets/img/p.png') }}" /></a>
					</div>
				</div>
				<div class="call_f">
				<h4>Speak to your new home <br />building consultant today for free</h4>
				<div class="call"><em><a href="tel:1800 824 823"><img src="{{ URL::asset('assets/img/phone_ico.png') }}" /></em> <span>1800 824 823</a></span></div>
				</div>
				<div class="clr"></div>
				</div>

			</div>
			<div class="f_bar"><div class="container"><a href="{{ url('terms-and-conditions') }}">Terms & Conditions</a>      <a href="{{ url('privacy-policy') }}"> Privacy Policy</a>       &copy; <?php echo date('Y'); ?> iCompareBuilders Pty Ltd. All rights reserved
			<p>Images depicted on this site are for illustration purposes only. Facades and other images of homes may include optional upgrades, additional fixtures, finishes and features that are not included in the base price of the home such as landscaping, feature tiling, decking, furnishing, feature lighting, pools, etc. Any prices or price range shown on this site are indicative only and will vary depending on final inclusions, locations of build, house façade and other customisations.</p>
			<div class="footer-logo"><img src="{{ URL::asset('assets/img/logo2.png') }}" /></div>
			</div>
			</div> 
		</footer>-->
		
		<?php } ?>
		
		<!-- For enquire popup -->
		<?php  $loginUrl =  App\User::get_instagram_url() ; ?>
 <div class="modal fade register-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header login_hdr">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
          <h4 class="modal-title">Join Now</h4>
        </div>
		<div id="successMessage" style='color:#71B238;float: left;padding: 10px;text-align: center;width: 100%;display:none' ></div>
        <span id = 'message_error' style='color:#9C0E0E;float: left;padding: 10px;text-align: center;width: 100%;display:none'></span>
        <span id = 'message_success' style='color:#71B238;float: left;padding: 10px;text-align: center;width: 100%;display:none'></span>
		<h3>Join with iCompareBuilders</h3>
		<div class="social_link reg_social_link"><a href="<?php echo url(); ?>/fbAuth"><img src="<?php echo url();  ?>/assets/img/join-facebook.png"/>
		<a href="<?php echo $loginUrl; ?>"><img src="<?php echo url();  ?>/assets/img/join-instagram.png"/>
		</a>
		</a>
		</div>
		<p class="register_details">Or enter your details below</p>
		  <div class="login-form">       
			{!! Form::open(array('class' => 'form','enctype'=>"multipart/form-data", 'autocomplete'=>'off','url'=>'register','id'=>'regForm')) !!}	
			<div class="form-col">
				<!--<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />-->
				{!! Form::label('First Name') !!}
				{!! Form::text('firstname', null, array('class'=>'form-control', 'id'=>'firstname', 'placeholder'=>'First name')) !!}
				    <div id ="firstname_error" class="reg_error"></div>

			</div>
			<div class="form-col">
				{!! Form::label('Last Name') !!}
				{!! Form::text('lastname', null, array('class'=>'form-control', 'id'=>'lastname' , 'placeholder'=>'Last name')) !!}
				<div id ="lastname_error" class="reg_error"></div>
			</div>
			<div class="form-col">
				{!! Form::label('Email') !!}
				{!! Form::email('email', null, array('class'=>'form-control', 'style'=>'display:none', 'type' => 'hidden' , 'placeholder'=>'Email')) !!}
				{!! Form::email('email', null, array('class'=>'form-control', 'id'=>'email' , 'placeholder'=>'Email')) !!}
				<div id ="email_error" class="reg_error"></div>
			</div>
			<div class="form-col">
				{!! Form::label('Phone number') !!}
				{!! Form::text('phone', null, array('class'=>'form-control', 'style'=>'display:none', 'type' => 'hidden' , 'placeholder'=>'Email')) !!}
				{!! Form::text('phone', null, array( 'class'=>'form-control', 'id'=>'phone' , 'placeholder'=>'Phone number')) !!}
				<div id ="phone_error" class="reg_error"></div>
			</div>
			<!--<div class="form-col">
				{!! Form::label('Address') !!}
				{!! Form::textarea('address', null, array( 'class'=>'form-control', 'placeholder'=>'Address')) !!}
			</div>-->
			<?php 
			
			$states = App\State::all();
			$states_arr = $states->toArray();
			$states = array();
			foreach($states_arr as $state_val) { 
				$states[$state_val['id']] = $state_val['loc_name'];
			}
			
			?>
			
			<div class="form-col">
				{!! Form::label('User location') !!}
				{!! Form::select('user_location', array('' => 'Please select one option') + $states, null,array('class'=>'form-control user_location1' , 'id'=>'user_location')) !!}
			</div>
			<div id ="user_location_error" class="reg_error"></div>
			
			<div class="form-col">
				{!! Form::label('Password') !!}
				{!! Form::password('password', array('class'=>'form-control', 'id'=>'password' ,  'placeholder'=>'Password')) !!}
				<div id ="password_error" class="reg_error"></div>
			</div>
			<!--<div class="form-col profile_imageinput">
				{!! Form::label('Profile image') !!}
				{!! Form::file('userimage', null,['style'=>'padding:0' ]) !!}user_location
			</div>-->
		
			<div class="clr"></div>
			<input type="submit" name="register" value="Join" class="l_submit" />
			<!--<p><a style="color:#a00; text-decoration:underline;" href="">Forgot your password?</a></p>-->
			{!! Form::close() !!}
			</div>
      </div>
    </div>
  </div>		
		
		
  <div class="modal fade login-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header login_hdr">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
          <h4 class="modal-title">Login</h4>
        </div>
		<div class='singin_loginpop'>
			<p>Sign in below to access the admin screens for your account</p>
		</div>
        <span id = 'message_error1' style='color:#9C0E0E;float: left;padding: 10px;text-align: center;width: 100%;'></span>
        <span id = 'message_success1' style='color:#71B238;float: left;padding: 10px;text-align: center;width: 100%;'></span>
		<div class="social_link"><a href="<?php echo url(); ?>/fbAuth"><img src="<?php echo url();  ?>/assets/img/fb.png"/>
		</a>
		
		<a href="<?php echo $loginUrl; ?>"><img src="<?php echo url();  ?>/assets/img/sign-instagram.png"/>
		</a>
		
		
		</div>
		<!--<a href="<?php //echo url(); ?>/instaAuth">Instagram Login</a>-->
        <div class="login-form">            
           {!! Form::open(array('action' => "Home@login_user", 'autocomplete'=>'off' , 'class' => 'form-login','enctype'=>"multipart/form-data")) !!}
				<div class="form-col">
					{!! Form::label('Email') !!}
					{!! Form::email('email', null, array('class'=>'form-control', 'style'=>'display:none', 'type' => 'hidden' , 'placeholder'=>'Email')) !!}
					{!! Form::email('email', null, array( 'required', 'class'=>'form-control', 'placeholder'=>'Email')) !!}
				</div>
				<div id ="email_error1" class="reg_error"></div>
				<div class="form-col">
					{!! Form::label('Password') !!}
					{!! Form::password('password', array('required', 'class'=>'form-control', 'placeholder'=>'Password')) !!}
				</div>
				<div id ="password_error1" class="reg_error"></div>
                  <div class="clr"></div>
                  <input type="submit" name="login" value="Login" class='l_submit'>
                  <p style='text-align: center;'><a style="color:#a00; text-decoration:underline;" href="{{ url('forgotpassword') }}">Forgot your password?</a></p>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade builder-login-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header login_hdr">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
          <h4 class="modal-title">Builder Login</h4>
          <p>Sign in below to access the admin screens for your account</p>
        </div>
        <span id = 'message_error2' style='color:#9C0E0E;float: left;padding: 10px;text-align: center;width: 100%;'></span>
        <span id = 'message_success2' style='color:#71B238;float: left;padding: 10px;text-align: center;width: 100%;'></span>
        <div class="login-form">            
           {!! Form::open(array('action' => "Home@builder_login", 'class' => 'builder-login','enctype'=>"multipart/form-data")) !!}
				<div class="form-col">
					{!! Form::label('Username') !!}
					{!! Form::text('username', null, array( 'required', 'class'=>'form-control', 'placeholder'=>'Username')) !!}
				</div>
				<div class="form-col">
					{!! Form::label('Password') !!}
					{!! Form::password('password', array('required', 'class'=>'form-control', 'placeholder'=>'Password')) !!}
				</div>
                  <div class="clr"></div>
                  <input type="submit" name="login" value="Login" class="l_submit">
                  <p style='text-align: center;'><a style="color:#a00; text-decoration:underline;" href="{{ url('forgotpassword') }}">Forgot your password?</a></p>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
  
  
  
		<script type="text/javascript" src="{{ URL::asset('assets/slick-master/slick/slick.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('assets/js/custom.js') }}"></script>
		<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.aCollapTable.js') }}"></script>
		<script src="{{ URL::asset('assets/js/mtree.js') }}"></script>
		<script src="{{ URL::asset('assets/datepicker/bootstrap-datepicker.js') }}"></script>
		<script src="{{ URL::asset('assets/js/bootstrap-notify.js') }}"></script>
		<script src="{{ URL::asset('assets/js/jquery.sidr.min.js') }}"></script>


	</body>
</html> 
