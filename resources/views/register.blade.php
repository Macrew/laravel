@extends('layout.default')

@section('content')	

<section class="slide_sec register_banner">
    <div class="login-banner-con">
        <div class="login-banner-con-inner">
            <h2>Sign up</h2>
            <p>Sign up below to access for your account</p>
            
			{!! Form::open(array('class' => 'form','enctype'=>"multipart/form-data")) !!}	
			<div class="form-col">
				<!--<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />-->
				{!! Form::label('First Name') !!}
				{!! Form::text('firstname', null, array('required', 'class'=>'form-control', 'placeholder'=>'First name')) !!}
			</div>
			<div class="form-col">
				{!! Form::label('Last Name') !!}
				{!! Form::text('lastname', null, array('required', 'class'=>'form-control', 'placeholder'=>'Last name')) !!}
			</div>
			<div class="form-col">
				{!! Form::label('Email') !!}
				{!! Form::email('email', null, array('required', 'class'=>'form-control', 'placeholder'=>'Email')) !!}
			</div>
			<div class="form-col">
				{!! Form::label('Phone number') !!}
				{!! Form::text('phone', null, array( 'class'=>'form-control', 'placeholder'=>'Phone number')) !!}
			</div>
			<!--<div class="form-col">
				{!! Form::label('Address') !!}
				{!! Form::textarea('address', null, array( 'class'=>'form-control', 'placeholder'=>'Address')) !!}
			</div>-->
			<div class="form-col">
				{!! Form::label('Password') !!}
				{!! Form::password('password', array('required', 'class'=>'form-control', 'placeholder'=>'Password')) !!}
			</div>
			<!--<div class="form-col profile_imageinput">
				{!! Form::label('Profile image') !!}
				{!! Form::file('userimage', null,['style'=>'padding:0' ]) !!}user_location
			</div>-->
			<div class="form-col">
				{!! Form::label('User location') !!}
				{!! Form::select('user_location', array('' => 'Please select one option') + $states_arr, null,array('rquired', 'class'=>'form-control')) !!}
			</div>
			<div class="clr"></div>
			<input type="submit" name="register" value="Sign-up">
			<!--<p><a style="color:#a00; text-decoration:underline;" href="">Forgot your password?</a></p>-->
			{!! Form::close() !!}
        </div>
    </div>
   <!-- <img src="{{ URL::asset('assets/img/login-slide-img.jpg') }}" class="full" />-->
</section>

@stop
