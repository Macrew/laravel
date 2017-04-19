@extends('layout.default')

@section('content')
<section class="main_con sub-main">
       <div class="container">
           <div class="sub-heading"><h1>Edit House Land</h1></div>
           <div class="addproperty-heading">
				<input type="button" class="btn btn-primary" onclick="window.location.href='{{ url('builder/house-and-land') }}'" value="Back to House and Land" style='border-radius:unset;padding:13px;'>
			</div>
           <div class="container1">
            <ul class="rtabs">
                <li class="tabies selected"><a rel="view1" href='javascript:void(0);'>General</a></li>
                <li class="tabies continew"><a rel="view2">Images & Floor Plans</a></li>
                <li class="tabies"><a rel="view3">Inclusions</a></li>
            </ul>
            
				<div class="panel-container">
						<div id="view1" class="active cls">
							{!! Form::model($property,array('action' => array('builderController@update_house_land', $id),'class' => 'form','enctype'=>"multipart/form-data", 'files' => true)) !!}
								<div class="view1-top">
									<div class="half-wrap">
										{!! Form::hidden('id')!!}
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
										<div class="view1-bottom-box">
										{!! Form::text('land_size', null, array( 'required',  'class'=>'form-control')) !!}
										<p><img src="{{ URL::asset('assets/img/house-size.png') }}" alt="green">Land Size</p>
										</div>
										<div class="view1-bottom-box">
											{!! Form::textarea('house_land_address', null, array( 'required',  'class'=>'form-control')) !!}
											<p><img src="{{ URL::asset('assets/img/house-size.png') }}" alt="green">Address</p>
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
									<div class="view1-top img_prop">
										<div class="half-wrap">
											{!! Form::label('Home Brochure') !!}
											{!! Form::file('brochure', array('class'=>'form-control')) !!}
											<label style='margin:10px 0;float:left;'>Brochure Link</label>
								<?php		if($property->brochure != ''){ ?>
												<a href="<?php echo url(); ?>/propertymanagement/getDownloadfile/<?php echo $property->brochure;  ?>" target="_blank"><?php echo url(); ?>/uploads/brochure/<?php echo $property->brochure;  ?></a>
									<?php	}else{ echo "No Brouchure found"; } ?>
										</div>
										<div class="half-wrap">
											{!! Form::label('Promotional Brochure') !!}
											{!! Form::file('promotional_brochure', null, array('class'=>'form-control')) !!}
											<label style='margin:10px 0;float:left;'>Brochure Link</label>
								<?php		if($property->brochure != ''){ ?>
												<a href="<?php echo url(); ?>/uploads/brochure/<?php echo $property->promotional_brochure;  ?>" target="_blank"><?php echo url(); ?>/uploads/brochure/<?php echo $property->promotional_brochure;  ?></a>
									<?php	}else{ echo "No Brouchure found"; } ?>
										</div>
									</div>
									<input type="submit" name="add_property" value="Save">
								</div>
							{!! Form::close() !!}
						</div>
						<div id="view2" class="cls">
							<div class="view2-box">
								<h3>Gallery Images</h3>
								{!! Form::model($property,array('action'=>'builderController@gallery_images','class' => 'form', 'id'=>'gallery_form', 'enctype'=>"multipart/form-data", 'files' => true )) !!}
									<div class="view2-box-inner">
										{!! Form::hidden('id')!!}
										{!! Form::label('Image') !!}
										{!! Form::file('galleryimage[]', array('multiple'=>true,'id'=>'upload_gallery'),['style'=>'padding:0' ]) !!}
										<!--<input type="button" name="upload_gallery" value="Upload" id='upload_gallery'>-->
										<div class="clr"></div>
									</div>
									<div class='col-md-12 append_galleryimages'>
										<?php  if(!empty($gallery_arr)) {	foreach($gallery_arr as $gall_val) { ?>
											<div class="clas" id="img_<?php echo $gall_val['id'];  ?>">
												<a href="<?php echo url(); ?>/uploads/property_gallery/<?php echo $gall_val['image'];  ?>" target="_blank" > 
													<img src="<?php echo url(); ?>/uploads/property_gallery/<?php echo $gall_val['image'];  ?>"  style="width:200px;height:200px;"/>  
												</a>
												<span class="remove_image" onclick="remove_galleryimg(<?php echo $gall_val['id'];  ?>,'gallery')">
													<img src="{{ URL::asset('assets/img/close-red.png') }}" alt="close" /> 
												</span>
											</div>
										<?php  } }  ?>
									</div>
								{!! Form::close() !!}
								<div class="clr"></div>
							</div>
							<div class="view2-box">
								<h3>Floor Plan Images</h3>
								{!! Form::model($property,array('action'=>'builderController@floor_images','class' => 'form', 'id'=>'floor_form', 'enctype'=>"multipart/form-data", 'files' => true )) !!}
									<div class="view2-box-inner">
										{!! Form::label('Image') !!}
										{!! Form::file('floorplanimage[]', array('multiple'=>true,'id'=>'floorplanimage'),['style'=>'padding:0' ]) !!}
										<div class="clr"></div>
									</div>
									<div class='col-md-12 append_floorimages'>
											<?php  if(!empty($floorimage)) {	foreach($floorimage as $gall_val) { ?>
												<div class="clas" id="img_<?php echo $gall_val['id'];  ?>">
													<a href="<?php echo url(); ?>/uploads/property_floor/<?php echo $gall_val['image'];  ?>" target="_blank" > 
														<img src="<?php echo url(); ?>/uploads/property_floor/<?php echo $gall_val['image'];  ?>"  style="width:200px;height:200px;"/>  
													</a>
													<span class="remove_image" onclick="remove_galleryimg(<?php echo $gall_val['id'];  ?>,'floor')">
														<img src="{{ URL::asset('assets/img/close-red.png') }}" alt="close" /> 
													</span>
												</div>
											<?php  } } ?>
										</div>
								{!! Form::close() !!}
								<div class="clr"></div>
								<div class="clr"></div>
							</div>
						</div>
					 
					<div id="view3" class="cls">
						{!! Form::model($property,array('action'=>'builderController@propertyinclusions','class' => 'form','enctype'=>"multipart/form-data")) !!}
						<input type='hidden' value="<?php echo $id; ?>" name='property_id'>
						<div class="view3-inner">
							<?php  foreach($inclusions_arr as $inc_val) { 
								?>
								<div class="full-wrap"><!----Multiple checkbox select with jQuery---->
									<label>Select <?php echo $inc_val['title'];  ?></label>
								   <select class="inclusion_id"  name="inclusion_id" rel="<?php echo $inc_val['id']; ?>">
										<option selected>None</option>
									<?php 
											$checked =  false;
											if(!empty($prop_inc_arr)) {
                                                 foreach($prop_inc_arr as $prop_val) { 
											 $sel_inc =  App\Inclusion::check_inc_parent($prop_val['inclusion_id']) ;
											if($sel_inc == $inc_val['id']) {
											$checked = true;
												$style="display:block;";
											?>
										       <option value="<?php echo $inc_val['id'];  ?>" selected><?php echo $inc_val['title'];  ?></option>
											  <?php break; } else {  $checked = false;   }   ?>
											   <?php } }
											   ?>

											   <?php if($checked == false) { $style="display:none;"; ?>
											     <option value="<?php echo $inc_val['id'];  ?>"><?php echo $inc_val['title'];  ?></option>
												 <?php } ?>
										  </select>
								</div>
							
							 <?php  $inclusion =  App\Inclusion::get_child_inclusions($inc_val['id']) ;
   
	
		

   ?>
						<?php 
			/*  echo '<pre>';
			print_r($inclusion); */
			$checked1 = false;
								 if(!empty($inclusion)) {
								 if($checked == false) {
									$style="display:none;";
								 } else {
									$style="display:block;";
								 }
									foreach($inclusion as $inclusion_val) {
									foreach($prop_inc_arr as $prop_val) {
												if($prop_val['inclusion_id'] == $inclusion_val['id']) {
														$style="display:block;";
														$checked1 = true;
									?>
									<div class="subcat_insclusion child-<?php echo $inc_val['id']; ?>"  style=<?php echo $style; ?>>
                                            <!--<label>Checkboxes</label>-->
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" checked value="<?php echo $inclusion_val['id'];  ?>" name="inc_<?php echo $inclusion_val['id'];  ?>"><strong><?php echo $inclusion_val['title']; ?></strong>
                                                </label>
												
                                            <label> | Inclusion Type</label>
                                            <label class="radio-inline">
                                                <input type="radio" <?php if($prop_val['inclusion_type'] == '2' ) { echo 'checked=checked'; }  ?> value="2" id="optionsRadiosInline1" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Standard inclusion
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" <?php if($prop_val['inclusion_type'] == '3' ) { echo 'checked=checked'; }  ?> value="3" id="optionsRadiosInline2" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Available as upgrade
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" <?php if($prop_val['inclusion_type'] == '1' ) { echo 'checked=checked'; }  ?>  value="1" id="optionsRadiosInline3" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Not available
                                            </label>
                                       
                                            </div>
                                        </div>
										  
										  
										<?php  break ; }  else { $checked1 =  false;  } } 
												if($checked1 ==  false) {
												//$style="display:block;";
										?>
										
										
										<div class="subcat_insclusion child-<?php echo $inc_val['id']; ?>"  style=<?php echo $style; ?>>
                                            <!--<label>Checkboxes</label>-->
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"  value="<?php echo $inclusion_val['id'];  ?>" name="inc_<?php echo $inclusion_val['id'];  ?>"><strong><?php echo $inclusion_val['title']; ?></strong>
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




									<?php  } } } } ?>
							<div class="clr"></div>
							<input type="submit" name="add_property" value="Save">
						</div>
						{!! Form::close() !!}
					</div>
				</div>
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
		$('ul.rtabs').find('li').click(function(){
			//alert($(this).find('a').attr('rel'));
			var rel = $(this).find('a').attr('rel');
			$('.tabies').removeClass('selected');
			$(this).addClass('selected');
			$('.panel-container').find('.cls').removeClass('active');
			$('.panel-container').find("#"+rel).addClass('active');
		});
		
		$('.next_addprop').click(function(){
			$('.continew').trigger("click");
		});
		
		
		//Function for uploading Gallery images
		$("#upload_gallery").change(function(){
			var url_post = '<?php echo url(); ?>/propertymanagement/gallery_images/<?php echo $property->id; ?>'; 
			$.ajax({
				url:url_post,
				data: new FormData($("#gallery_form")[0]),
				dataType:'text',
				async:false,
				type:'post',
				processData: false,
				contentType: false,
				success:function(response){
					var jsonresponse = $.parseJSON(response);
					if(response != 'failed'){
						$.each(jsonresponse,function(key,value){
							var val = '<?php echo url(); ?>/uploads/property_gallery/'+value["image"]+'';
							var function_vals = "remove_galleryimg("+value['id']+",'gallery')";
							$('.append_galleryimages').append('<div class="clas" id="img_'+value["id"]+'"><a href="'+val+'" target="_blank" > <img src="'+val+'"  style="width:200px;height:200px;"/>  </a><span class="remove_image" onclick="'+function_vals+'"><img src="{{ URL::asset("assets/img/close-red.png") }}" alt="close" /> </span></div>');
						});
						//$('.append_galleryimages').show();
					}else{
					
					}
				},
			});
		 });
    
    
		//Function for uploading Floor images
		$("#floorplanimage").change(function(){
			var url_post = '<?php echo url(); ?>/propertymanagement/floor_images/<?php echo $property->id; ?>'; 
			$.ajax({
				url:url_post,
				data: new FormData($("#floor_form")[0]),
				dataType:'text',
				async:false,
				type:'post',
				processData: false,
				contentType: false,
				success:function(response){
					var jsonresponse = $.parseJSON(response);
					if(response != 'failed'){
						$.each(jsonresponse,function(key,value){
							var val = '<?php echo url(); ?>/uploads/property_floor/'+value["image"]+'';
							var function_vals = "remove_galleryimg("+value['id']+",'floor')";
							$('.append_floorimages').append('<div class="clas" id="img_'+value["id"]+'"><a href="'+val+'" target="_blank" > <img src="'+val+'"  style="width:200px;height:200px;"/>  </a><span class="remove_image" onclick="'+function_vals+'"><img src="{{ URL::asset("assets/img/close-red.png") }}" alt="close" /> </span></div>');
						});
						//$('.append_galleryimages').show();
					}else{
					
					}
				},
			});
		 });		 
    });
    
    
    function remove_galleryimg(imgid,img_type){
		var status = confirm('Are you sure you want to delete Gallery Image.');
		if(status)
		{
			if(img_type=='floor'){
				var url_post = '<?php echo url(); ?>/propertymanagement/remove_floorimg/<?php echo $property->id; ?>'; 
			}else if(img_type == 'gallery'){
				var url_post = '<?php echo url(); ?>/propertymanagement/remove_galleryimg/<?php echo $property->id; ?>'; 
			}
			$.ajax({
					url:url_post,
					data: 'imgid='+imgid,
					dataType:'text',
					async:false,
					type:'get',
					processData: false,
					contentType: false,
					success:function(response){
						var img_id = 'img_'+imgid;
						$('#'+img_id).remove();
					},
			});
		}
	}
$('div.alert').delay(5000).slideUp(300);
</script>
@stop
