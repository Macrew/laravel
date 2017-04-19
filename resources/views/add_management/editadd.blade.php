@extends('layout.default')

@section('content')
<?php //echo '<pre>'; print_r($add); echo '</pre>';?>
<section class="main_con sub-main">	
       <div class="container">
           <div class="sub-heading"><h1>Edit Ad</h1></div>
           <div class="addproperty-heading">
				<input type="button" class="btn btn-primary" onclick="window.location.href='{{ url('addmanagement') }}'" value="Back to Add management" style='border-radius:unset;padding:13px;'>
			</div>
           <div class="create-ad">
				{!! Form::model($add,array('class' => 'form','enctype'=>"multipart/form-data", 'files' => true)) !!}
					<div class="create-left">
						{!! Form::label('Head Line') !!}
						{!! Form::text('headline', null, array( 'required', 'class'=>'form-control', 'placeholder'=>'Head Line')) !!}
						
						{!! Form::label('Text') !!}
						{!! Form::text('add_text', null, array( 'required', 'class'=>'form-control', 'placeholder'=>'Text')) !!}
						
						{!! Form::label('Ad Size') !!}
						{!! Form::select('add_size', array('' => 'Please select one option', '100'=>'100' ,'200'=>'200', '300'=>'300','400'=>'400',  '500'=>'500'), null,array('rquired', 'class'=>'form-control')) !!}
						
						{!! Form::label('Image') !!}
						{!! Form::file('image', null,['style'=>'padding:0' ]) !!}
						<div class='full-wrap'>
							<?php 
								if(count($add)>0){ ?>
										<img src="<?php echo url(); ?>/uploads/add_management/<?php echo $add->image;  ?>"  style="width:200px;height:200px;"/>  
							<?php	}
							?>
						</div>
						<div class="clr"></div>
						<div class="half-wrap">
							{!! Form::label('Start Date') !!}
							{!! Form::text('start_date', null, array( 'required', 'class'=>'form-control', 'id'=>'from', 'placeholder'=>'Start Date')) !!}
						</div>
						<div class="half-wrap">
							{!! Form::label('End Date') !!}
							{!! Form::text('end_date', null, array( 'required', 'class'=>'form-control', 'id'=>'to', 'placeholder'=>'End Date')) !!}
						</div>
						<div class="clr"></div>
						<div class="create-btn"><input type="submit" name="publish" value="Publish"></div>
					</div>
					<input type='hidden' name='add_id' value='<?php echo $add->id; ?>' />
				{!! Form::close() !!}
               <!--<div class="create-right">
                   <h3>Preview</h3>
                   <h4>Lorem ipsum is</h4>
                   <img src="img/ad-here.jpg" alt="ad">
                   <p>Lorem Ipsum is simply dummyLorem Ipsum is simply dummyLorem Ipsum is simply dummy</p>
               </div>
               <div class="clr"></div>
           </div>-->
       </div>
</section>
<script>
	$( "#from" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		minDate: 0,
		onClose: function( selectedDate ) {
			$( "#to" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#to" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
		$( "#from" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
	$('div.alert').delay(5000).slideUp(300);
</script>
@stop
