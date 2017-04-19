@extends(layout.default) 
@section('content')
<div class="hd_wrap">
	<div class="logo"><img src="{{ URL::asset('assets/img/logo1.png') }}" /></div><!--logo section!-->
	<div class="hd_mid">
		<ul>
			<li><a href="#">Browse <i class="fa fa-angle-down"></i></a>
					<ul class="sub_menu">
                    	<li><a href="#">Menu1</a></li>
                        <li><a href="#">Menu2</a></li>
                        <li><a href="#">Menu3</a></li>
                        <li><a href="#">Menu4</a></li>
                    </ul>
			</li>
			<li><a href="#"> Builders</a></li>
			<li><a href="#">Help</a></li>
			<li><a href="#">More</a></li>
		</ul>
	</div>
	<div class="hd_rt">
		<ul>
			<li><a href="/auth/login">Login</a></li>
			<li><a href="#">Registerssssss</a></li>
		  
		</ul>
		
		<a href="#" class="phone"><i class="fa fa-mobile-phone"></i></a>
		<a href="#" class="register"><i class="fa fa-star"></i> <i class="circle">1</i> Saved</a>
	</div>
	<div class="clr"></div>
<div>
@stop
