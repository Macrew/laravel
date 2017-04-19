@extends('layout.default') 
@section('content')
<div class="container">
	<div class="news_sec">
		<h2>Fortnightly news, promotions & tips from iCompareBuilders</h2>
		<div class="news_main">
			<input type="text" placeholder="Email address" />
			<input type="submit" value="Subscribe" />
			<div class="clr"></div>
		</div>
		<div class="social_ico"><img src="{{ URL::asset('assets/img/f.png') }}" /> <img src="{{ URL::asset('assets/img/y.png') }}" /> <img src="{{ URL::asset('assets/img/in.png') }}" /> <img src="{{ URL::asset('assets/img/p.png') }}" /></div>
	</div>
	
	<div class="f_left">
		<h3>Company</h3>
		<ul>
			<li><a href="#">About</a></li>
			<li><a href="#">Blog</a></li>
			<li><a href="#">Contact Us</a></li>
		</ul>
	</div>
	
	<div class="f_left">
		<h3>Homes & Builders</h3>
		<ul>
			<li><a href="#">Browse Homes</a></li>
			<li><a href="#">Builders</a></li>
			<li><a href="#">Your Saved Homes</a></li>
		</ul>
	</div>
	
	<div class="f_left">
		<h3>For Builders</h3>
		<ul>
			<li><a href="#">Builder Sign In</a></li>
			<li><a href="#">Builder Enquiries</a></li>
		</ul>
	</div>
	
	<div class="f_left">
		<h3>Account</h3>
		<ul>
			<li><a href="#">Login</a></li>
			<li><a href="#">Register</a></li>
			<li><a href="#">Reset Site</a></li>
		</ul>
	</div>
	
	<div class="f_left no_mg">
		<h3>Category Partners</h3>
		<img src="{{ URL::asset('assets/img/au.png') }}" /><br />
		<img src="{{ URL::asset('assets/img/ad.png') }}" />
	</div>
	<div class="clr"></div>
	
	
	<h4>Call our free and independent home <br />building consultant now</h4>
	<div class="call"><em><img src="{{ URL::asset('assets/img/phone_ico.png') }}" /></em> <span>1800 236 236</span></div>
</div>
<div class="f_bar"><a href="#">Terms & Conditions</a>      <a href="#"> Privacy Policy</a>       &copy; <?php echo date('Y'); ?> iCompareBuilders Pty Ltd. All rights reserved</div>  
    @stop
