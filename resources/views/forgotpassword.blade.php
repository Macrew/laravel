@extends('layout.default')

@section('content')

<section class="slide_sec">
    <div class="login-banner-con">
        <div class="login-banner-con-inner">
            <h2>Forgot Password</h2>
            <p>Enter you email below to get password reset link</p>
           {!! Form::open(array('class' => 'form','enctype'=>"multipart/form-data")) !!}	
				<div class="form-col" style='margin:0 29% 30px;width:42%;'>
					{!! Form::email('email', null, array( 'required', 'class'=>'form-control', 'placeholder'=>'Email')) !!}
				</div>
                  <div class="clr"></div>
                  <input type="submit" name="login" value="Submit" style='width:27%'>
            {!! Form::close() !!}
        </div>
    </div>
    <img src="{{ URL::asset('assets/img/login-slide-img.jpg') }}" class="full" />
</section>
<script>
$('div.alert').delay(5000).slideUp(300);
</script>
@stop

