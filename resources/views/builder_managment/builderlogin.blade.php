@extends('layout.default')

@section('content')

<section class="slide_sec">
    <div class="login-banner-con">
        <div class="login-banner-con-inner">
            <h2>Builder Login</h2>
            <p>Sign in below to access the admin screens for your account</p>
           {!! Form::open(array('class' => 'form','enctype'=>"multipart/form-data")) !!}	
				<div class="form-col">
					{!! Form::label('Username') !!}
					{!! Form::text('username', null, array( 'required', 'class'=>'form-control', 'placeholder'=>'Username')) !!}
				</div>
				<div class="form-col">
					{!! Form::label('Password') !!}
					{!! Form::password('password', array('required', 'class'=>'form-control', 'placeholder'=>'Password')) !!}
				</div>
                  <div class="clr"></div>
                  <input type="submit" name="login" value="Login">
                  <p><a style="color:#a00; text-decoration:underline;" href="{{ url('forgotpassword') }}">Forgot your password?</a></p>
            {!! Form::close() !!}
        </div>
    </div>
    <img src="{{ URL::asset('assets/img/login-slide-img.jpg') }}" class="full" />
</section>
<script>
$('div.alert').delay(5000).slideUp(300);
</script>
@stop
