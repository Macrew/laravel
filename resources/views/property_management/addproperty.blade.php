@extends('layout.default')

@section('content')
<?php //echo '<pre>'; print_r($inclusions_arr); ?>
<section class="main_con sub-main">
       <div class="container">
           <div class="sub-heading"><h1>Add Property</h1></div>
            <div class="addproperty-heading">
				<input type="button" class="btn btn-primary" onclick="window.location.href='{{ url('propertymanagement') }}'" value="Back to property management" style='border-radius:unset;padding:13px;'>
			</div>
           <div class="container1">
            <ul class="rtabs">
                <li class="selected"><a href="#view1">General</a></li>
                <li class=""><a href="#view2">Images & Brochure</a></li>
                <li class=""><a href="#view3">Inclusions</a></li>
            </ul>
            {!! Form::open(array('class' => 'form','enctype'=>"multipart/form-data",'id'=>'myform')) !!}
				<div class="panel-container">
					<div id="view1" class="" style="display: block;">
						<div class="view1-top">
							<div class="half-wrap">
								{!! Form::label('Property Name') !!}
								{!! Form::text('property_title', null, array( 'required', 'class'=>'form-control')) !!}
							</div>
							<div class="half-wrap">
								{!! Form::label('Price') !!}
								{!! Form::text('price', null, array( 'required',  'class'=>'form-control')) !!}
							</div>
							<div class="clr"></div>
							{!! Form::label('Property Description') !!}
							{!! Form::textarea('description', null, array( 'required', 'class'=>'form-control')) !!}
						</div>
						<div class="view1-bottom">
						<h3>Property Specification</h3>
							<div class="view1-bottom-inner">
								<div class="view1-bottom-box">
									{!! Form::text('bedrooms', null, array( 'required',  'class'=>'form-control')) !!}
									<p><img src="{{ URL::asset('assets/img/bed-green.png') }}" alt="green">Bedrooms</p>
								</div>
								<div class="view1-bottom-box">
									{!! Form::text('cars', null, array( 'required',  'class'=>'form-control')) !!}
									<p><img src="{{ URL::asset('assets/img/car.png') }}" alt="green">Cars</p>
								</div>
								<div class="view1-bottom-box">
									{!! Form::text('housesize', null, array( 'required',  'class'=>'form-control')) !!}
									<p><img src="{{ URL::asset('assets/img/house-size.png') }}" alt="green">House Size</p>
								</div>
								<div class="view1-bottom-box">
									{!! Form::text('bathrooms', null, array( 'required',  'class'=>'form-control')) !!}
									<p><img src="{{ URL::asset('assets/img/bathroom.png') }}" alt="green">Bathrooms</p>
								</div>
								<div class="view1-bottom-box">
									{!! Form::text('stories', null, array( 'required',  'class'=>'form-control')) !!}
									<p><img src="{{ URL::asset('assets/img/story.png') }}" alt="green">Story</p>
								</div>
								<div class="view1-bottom-box">
									{!! Form::text('min_block_width', null, array( 'required',  'class'=>'form-control')) !!}
									<p><img src="{{ URL::asset('assets/img/min-block-width.png') }}" alt="green">Min Block width</p>
								</div>
								<div class="view1-bottom-box">
									{!! Form::text('living', null, array( 'required',  'class'=>'form-control')) !!}
									<p><img src="{{ URL::asset('assets/img/living.png') }}" alt="green">Living</p>
								</div>
								<div class="view1-bottom-box radio-wrap">
									<div class="radio-con">
										<p>{!! Form::radio('alfresco', 'Yes', ['class' => 'form-control']) !!}Yes</p>
										<p>{!! Form::radio('alfresco', 'No', ['class' => 'form-control']) !!}No</p>
										<div class="clr"></div>
									</div>
									<p><img src="{{ URL::asset('assets/img/alfresco.png') }}" alt="green">Alfresco</p>
									<div class="clr"></div>
								</div>
								<div class="view1-bottom-box">
									{!! Form::text('min_block_length', null, array( 'required',  'class'=>'form-control')) !!}
									<p><img src="{{ URL::asset('assets/img/min-block-length.png') }}" alt="green">Min Block length</p>
								</div>
								<div class="view1-bottom-box radio-wrap">
									<div class="radio-con">
										<p>{!! Form::radio('dual_occ', 'Yes', ['class' => 'form-control']) !!}Yes</p>
										<p>{!! Form::radio('dual_occ', 'No', ['class' => 'form-control']) !!}No</p>
										<div class="clr"></div>
									</div>
									<p><img src="{{ URL::asset('assets/img/dual-occ.png') }}" alt="green">Dual Occ</p>
								</div>
								<!--<div class="view1-bottom-box multi-checkbox">
									<select> <!----Multiple checkbox select with jQuery---->
										  <!--<option>1</option>
										  <option>2</option>
									</select>
									<p><img src="{{ URL::asset('assets/img/location.png') }}" alt="green">Build Locations</p>
								</div>-->
								<div class="clr"></div>
							</div>
						</div>
						<div class="view1-top img_prop">
							<div class="half-wrap">
								{!! Form::label('Home Brochure') !!}
								{!! Form::file('brochure', null, array('class'=>'form-control')) !!}
							</div>
							<div class="half-wrap">
								{!! Form::label('Promotional Brochure') !!}
								{!! Form::file('promotional_brochure', null, array('class'=>'form-control')) !!}
							</div>
						</div>
						<button class = 'next_addprop'>Continue <i class="fa fa-angle-right"></i></button>
					</div>
					<div id="view2" class="inactive" style="display: none;">
						<div class="view2-box">
							<h3>Gallery Images</h3>
							<div class="view2-box-inner">
								{!! Form::label('Image') !!}
								{!! Form::file('galleryimage', null,['style'=>'padding:0' ]) !!}
								<input type="button" name="upload" value="Upload">
								<div class="clr"></div>
							</div>
							<div class="clr"></div>
						</div>
						<div class="view2-box">
							<h3>Floor Plan Images</h3>
							<div class="view2-box-inner">
								{!! Form::label('Image') !!}
								{!! Form::file('floorplanimage', null,['style'=>'padding:0' ]) !!}
								<input type="button" name="upload" value="Upload">
								<div class="clr"></div>
							</div>
							<div class="clr"></div>
						</div>
						<div class="view2-box">
							<h3>Brochure</h3>
							<div class="view2-box-inner" style='margin:0 3% 0 0'>
								{!! Form::label('Home Brochure') !!}
								{!! Form::file('floorplanimage', null,['style'=>'padding:0' ]) !!}
								<input type="button" name="upload" value="Upload">
								<div class="clr"></div>
								<i style="color:#a00;">Only pdf file</i>
							</div>
							<div class="view2-box-inner">
								{!! Form::label('Promotional Brochure') !!}
								{!! Form::file('promotionalbrochure', null,['style'=>'padding:0' ]) !!}
								<input type="button" name="upload" value="Upload">
								<div class="clr"></div>
								<i style="color:#a00;">Only pdf file</i>
							</div>
							<div class="clr"></div>
						</div>
					</div>
					<div id="view3" class="inactive" style="display: none;">
						<div class="view3-inner">
							<?php  foreach($inclusions_arr as $inc_val) { 
								?>
								<div class="full-wrap"><!----Multiple checkbox select with jQuery---->
									<label>Select <?php echo $inc_val['title'];  ?></label>
								   <select class="inclusion_id"  name="inclusion_id" rel="<?php echo $inc_val['id']; ?>">
									<option selected>None</option>
									<option value="<?php echo $inc_val['id'];  ?>"><?php echo $inc_val['title'];  ?></option>
								  </select>
								</div>
							
							<?php $inclusion =  App\Inclusion::get_child_inclusions($inc_val['id']) ;
								if(!empty($inclusion)) {
										$style="display:none;";
									foreach($inclusion as $inclusion_val) { ?>
									<div class="subcat_insclusion child-<?php echo $inc_val['id']; ?>"  style=<?php echo $style; ?>>
										<!--<label>Checkboxes</label>-->
										<div class="checkbox">
											<label>
												<input type="checkbox" value="<?php echo $inclusion_val['id'];  ?>" name="inc_<?php echo $inclusion_val['id'];  ?>"><?php echo $inclusion_val['title']; ?>
											</label>
											<label> | Inclusion Type</label>
											<label class="radio-inline">
												<input type="radio" value="2" id="optionsRadiosInline1" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Standard inclusion
											</label>
											<label class="radio-inline">
												<input type="radio" value="3" id="optionsRadiosInline2" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Available as upgrade
											</label>
											<label class="radio-inline">
												<input type="radio" value="1" id="optionsRadiosInline3" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Not available
											</label>
								   
										</div>
									</div>
								<?php	}
								}
							 } 
							
							?>
							<div class="clr"></div>
							<input type="submit" name="add_property" value="Add Property">
						</div>
					</div>
				</div>
            {!! Form::close() !!}
            <br>
        </div>
       </div>
</section>
<script>
	 $(document).ready(function() {
		 $(".inclusion_id").on('change',function(){
			var inc = $(this).val();
			var rel = $(this).attr('rel');
			if(inc != 'None')
			{
				$('.child-'+rel).slideDown();
			} else {
				$('.child-'+rel).slideUp();
			}
		 });
		 
    });
$('div.alert').delay(5000).slideUp(300);
</script>
@stop
