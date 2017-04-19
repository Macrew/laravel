@extends(AdminTemplate::view('_layout.base'))

@section('content')
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			@include(AdminTemplate::view('_partials.header'))
			@include(AdminTemplate::view('_partials.user'))
			@include(AdminTemplate::view('_partials.menu'))
		</nav>
		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header"><?php echo $title; ?></h1>
				</div>
			</div>
			    <!-- /.row -->
	<?php if(Session::has('save_message')) { ?>
    <div class="alert alert-success">
        <?php  echo Session::get('save_message') ; ?>
    </div>
	<?php } ?>			
<?php if(Session::has('update_message')) { ?>
    <div class="alert alert-success">
        <?php  echo Session::get('update_message') ; ?>
    </div>
	<?php } ?>

	<?php if($errors->any()) { ?>
    <div class="alert alert-danger">
	<?php 
        foreach($errors->all() as $error){  ?>
            <p><?php echo $error ; ?></p>
     <?php   }
		?>
    </div>
	<?php } ?>
	
	
	<div class="row">
	<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            House & Land
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
							<?php 
						$currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method);
						 
						 ?>
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#general">General</a>
                                </li>
			
						 <?php if($controller == 'PropertyController' && $method == 'edit_house_land') { ?>
                                <li><a data-toggle="tab" href="#floor-plans">Floor Plans</a>
                                <!--</li>
								   <li><a data-toggle="tab" href="#display-homes">Display Homes</a>
                                </li>-->
							<?php } ?>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="general" class="tab-pane fade in active">
                                  <?php // echo Route::getCurrentRoute()->getActionName(); 
						
						 $currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method);
						 if($controller == 'PropertyController' && $method == 'edit_house_land') {
						
						 
						?>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($property_arr); 
						die; */
						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/house-and-land/update/<?php echo $property_arr['id']; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										 <div class="form-group">
                                            <label>Property Title</label>
                                           <input placeholder="Enter Property Title" class="form-control" value="<?php if(!empty($property_arr['property_title'])) { echo $property_arr['property_title'] ; } ?>" name="property_title" type="text">
                                        </div>
										 <div class="form-group">
                                            <label>Select Builder</label>
                                           <select class="builder_location"  name="user_id">
										   <?php  
											foreach($builders_arr as $builders_val) {
											if($builders_val['builders']['builder_id'] == $property_arr['user_id']) { ?>
											<option value="<?php echo $builders_val['builders']['builder_id']; ?>" selected><?php echo $builders_val['builders']['company_name']; ?></option>
										 <?php } else {  ?>
										   <option value="<?php echo $builders_val['builders']['builder_id']; ?>"><?php echo $builders_val['builders']['company_name']; ?></option>
										   <?php  } } ?>
										  </select>
										  </div>
										 <div class="form-group">
                                            <label>Description</label>
                                            <textarea rows="3" class="form-control" id="desc" name="description"><?php if(!empty($property_arr['description'])) { echo $property_arr['description'] ; } ?></textarea>
											 <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('desc');
            </script>
                                        </div>
										  <div class="form-group">
                                            <label>Price</label>
                                           <input placeholder="Enter Price" class="form-control" value="<?php if(!empty($property_arr['price'])) { echo $property_arr['price'] ; } ?>" name="price" type="text">
                                        </div>
										 <fieldset>
										 <legend>Property Specification</legend>
										  <div class="form-group">
                                            <label>Bedrooms</label>
                                           <input placeholder="Enter number of bedrooms" class="form-control" value="<?php if(!empty($property_arr['bedrooms'])) { echo $property_arr['bedrooms'] ; } ?>" name="bedrooms" type="text">
                                        </div>
										 <div class="form-group">
                                            <label>Cars</label>
                                             <input placeholder="Enter Cars" class="form-control" value="<?php if(!empty($property_arr['cars'])) { echo $property_arr['cars'] ; } ?>" name="cars" type="text">
                                        </div>
										<div class="form-group">
                                            <label>House Size</label>
                                             <input placeholder="Enter Housesize" class="form-control" value="<?php if(!empty($property_arr['housesize'])) { echo $property_arr['housesize'] ; } ?>" name="housesize" type="text">
                                        </div>
										
										<div class="form-group">
                                            <label>Bathrooms</label>
                                             <input placeholder="Enter number of bathrooms" class="form-control" value="<?php if(!empty($property_arr['bathrooms'])) { echo $property_arr['bathrooms'] ; } ?>" name="bathrooms" type="text">
                                        </div>
										
										<div class="form-group">
                                            <label>Stories</label>
                                             <input placeholder="Enter number of Stories" class="form-control" value="<?php if(!empty($property_arr['stories'])) { echo $property_arr['stories'] ; } ?>" name="stories" type="text">
                                        </div>
										
										<div class="form-group">
                                            <label>Living</label>
                                             <input placeholder="Enter number of Living" class="form-control" value="<?php if(!empty($property_arr['living'])) { echo $property_arr['living'] ; } ?>" name="living" type="text">
                                        </div>
                                         <div class="checkbox">
												<label> <input type="checkbox"  name="alfresco" <?php if(!empty($property_arr['alfresco'])) { if($property_arr['alfresco'] == 'Yes') { echo 'checked=checked'; } } ?> value="Yes">
												Alfresco
												</label>	
										</div>
										
										 <div class="checkbox">
												<label> <input type="checkbox"  name="dual_occ" <?php if(!empty($property_arr['dual_occ'])) { if($property_arr['dual_occ'] == 'Yes') { echo 'checked=checked'; } } ?> value="Yes">
												Dual Occ
												</label>	
										</div>
										
										<div class="form-group">
                                            <label>Minimum Block Width</label>
                                             <input placeholder="Enter minimum block width" class="form-control" value="<?php if(!empty($property_arr['min_block_width'])) { echo $property_arr['min_block_width'] ; } else { echo '0' ; }  ?>" name="min_block_width" type="text">
                                        </div>
										
										<div class="form-group">
                                            <label>Minimum Block Length</label>
                                             <input placeholder="Enter minimum block width" class="form-control" value="<?php if(!empty($property_arr['min_block_length'])) { echo $property_arr['min_block_length'] ; } else { echo '0' ; }  ?>" name="min_block_length" type="text">
                                        </div>
										
										<div class="form-group">
										    <label>Fixed Site Works</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="fixed_site_works" id="fixed_site_works" value="Yes" <?php if(!empty($property_arr['fixed_site_works'])) { if($property_arr['fixed_site_works'] == 'Yes') { echo 'checked=checked'; } } else { echo 'checked=checked';  } ?>>Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="fixed_site_works" id="fixed_site_works1" value="No" <?php if(!empty($property_arr['fixed_site_works'])) { if($property_arr['fixed_site_works'] == 'No') { echo 'checked=checked'; } } ?>>No
                                            </label>
                                        </div>
										
										</fieldset>	
										
                                       
										
                                        <div class="form-group">
                                            <label>Upload Brochure</label>
                                            <input type="file" name="brochure">
											
                                        </div>
										
										<div class="form-group">
                                            <label>Brochure Link</label>
											<a href="<?php echo url(); ?>/uploads/brochure/<?php echo $property_arr['brochure'];  ?>" target="_blank"><?php echo url(); ?>/uploads/brochure/<?php echo $property_arr['brochure'];  ?></a>
                                        </div>
										
										 <div class="form-group">
                                            <label>Upload Promotional Brochure</label>
                                            <input type="file" name="promotional_brochure">
											
                                        </div>
										<div class="form-group">
                                            <label>Brochure Link</label>
											<a href="<?php echo url(); ?>/uploads/brochure/<?php echo $property_arr['promotional_brochure'];  ?>" target="_blank"><?php echo url(); ?>/uploads/brochure/<?php echo $property_arr['promotional_brochure'];  ?></a>
                                        </div>
										
										<!--<div class="form-group">
                                            <label>Upload Standard Inclusion Brochure</label>
                                            <input type="file" name="inclusion_brochure">
											
                                        </div>
										<div class="form-group">
                                            <label>Brochure Link</label>
											<a href="<?php //echo url(); ?>/uploads/brochure/<?php //echo $property_arr['inclusion_brochure'];  ?>" target="_blank"><?php //echo url(); ?>/uploads/brochure/<?php //echo $property_arr['inclusion_brochure'];  ?></a>
                                        </div>-->
										
									<fieldset>

										<div class="form-group">
                                            <label>Land Size</label>
                                           <input type="text" name="land_size" value="<?php if(!empty($property_arr['land_size'])) { echo $property_arr['land_size'] ; } ?>" class="form-control" placeholder="Enter land size">
                                        </div>
										<div class="form-group">
                                            <label>Address</label>
                                           <textarea name="house_land_address" class="form-control" placeholder="Enter address"><?php if(!empty($property_arr['house_land_address'])) { echo $property_arr['house_land_address'] ; } ?></textarea>
                                        </div>
										 </fieldset>
                                                                            
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
                        </div>
						<?php } else if($controller == 'PropertyController' && $method == 'create_house_land') { 	
						?>
						  <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($property_arr); 
						die; */

						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/house-and-land/add" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
									 	<div class="form-group">
                                            <label>Property Title</label>
											 <input placeholder="Enter Property Title" class="form-control" value="<?php if(!empty(Input::old('property_title'))) { echo Input::old('property_title') ; }  ?>" name="property_title" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Select Builder</label>
                                           <select class="builder_location"  name="user_id">
										   <?php  
											foreach($builders_arr as $builders_val) { ?>
										   <option value="<?php echo $builders_val['builders']['builder_id']; ?>"><?php echo $builders_val['builders']['company_name']; ?></option>
										   <?php  }  ?>
										  </select>
										 </div>
										 
										 
										  <div class="form-group">
                                            <label>Description</label>
                                            <textarea rows="3" class="form-control" id="desc" name="description"><?php if(!empty(Input::old('description'))) { echo Input::old('description') ; }  ?></textarea>
											 <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('desc');
            </script>
                                        </div>
										  <div class="form-group">
                                            <label>Price</label>
                                           <input placeholder="Enter Price" class="form-control" value="<?php if(!empty(Input::old('price'))) { echo Input::old('price') ; }  ?>" name="price" type="text">
                                        </div>
										 <fieldset>
										 <legend>Property Specification</legend>
										  <div class="form-group">
                                            <label>Bedrooms</label>
                                           <input placeholder="Enter number of bedrooms" class="form-control" value="<?php if(!empty(Input::old('bedrooms'))) { echo Input::old('bedrooms') ; }  ?>" name="bedrooms" type="text">
                                        </div>
										 <div class="form-group">
                                            <label>Cars</label>
                                             <input placeholder="Enter Cars" class="form-control" value="<?php if(!empty(Input::old('cars'))) { echo Input::old('cars') ; }  ?>" name="cars" type="text">
                                        </div>
										<div class="form-group">
                                            <label>House Size</label>
                                             <input placeholder="Enter Housesize" class="form-control" value="<?php if(!empty(Input::old('housesize'))) { echo Input::old('housesize') ; }  ?>" name="housesize" type="text">
                                        </div>
										
										<div class="form-group">
                                            <label>Bathrooms</label>
                                             <input placeholder="Enter number of bathrooms" class="form-control" value="<?php if(!empty(Input::old('bathrooms'))) { echo Input::old('bathrooms') ; }  ?>" name="bathrooms" type="text">
                                        </div>
										
										<div class="form-group">
                                            <label>Stories</label>
                                             <input placeholder="Enter number of Stories" class="form-control" value="<?php if(!empty(Input::old('stories'))) { echo Input::old('stories') ; }  ?>" name="stories" type="text">
                                        </div>
										
										<div class="form-group">
                                            <label>Living</label>
                                             <input placeholder="Enter number of Living" class="form-control" value="<?php if(!empty(Input::old('living'))) { echo Input::old('living') ; }  ?>" name="living" type="text">
                                        </div>
                                         <div class="checkbox">
												<label> <input type="checkbox"  name="alfresco" <?php if(!empty(Input::old('alfresco'))) { if(Input::old('alfresco') == 'Yes') { echo 'checked=checked'; } } ?> value="Yes">
												Alfresco
												</label>	
										</div>
										
										 <div class="checkbox">
												<label> <input type="checkbox"  name="dual_occ" <?php if(!empty(Input::old('dual_occ'))) { if(Input::old('dual_occ') == 'Yes') { echo 'checked=checked'; } } ?> value="Yes">
												Dual Occ
												</label>	
										</div>
										
										<div class="form-group">
                                            <label>Minimum Block Width</label>
                                             <input placeholder="Enter minimum block width" class="form-control" value="<?php if(!empty(Input::old('min_block_width'))) { echo Input::old('min_block_width') ; }  ?>" name="min_block_width" type="text">
                                        </div>
										
										<div class="form-group">
                                            <label>Minimum Block Length</label>
                                             <input placeholder="Enter minimum block width" class="form-control" value="<?php if(!empty(Input::old('min_block_length'))) { echo Input::old('min_block_length') ; } ?>" name="min_block_length" type="text">
                                        </div>
										
										<div class="form-group">
										    <label>Fixed Site Works</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="fixed_site_works" id="fixed_site_works" value="Yes" checked="">Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="fixed_site_works" id="fixed_site_works1" value="No">No
                                            </label>
                                        </div>
										
										</fieldset>	
										
                                      
										
                                        <div class="form-group">
                                            <label>Upload Brochure</label>
                                            <input type="file" name="brochure">
											
                                        </div>
								
										
										 <div class="form-group">
                                            <label>Upload Promotional Brochure</label>
                                            <input type="file" name="promotional_brochure">
											
                                        </div>
										
										<!--<div class="form-group">
                                            <label>Upload Standard Inclusion Brochure</label>
                                            <input type="file" name="inclusion_brochure">
											
                                        </div>-->
										
										 <fieldset>
										<div class="form-group">
                                            <label>Land Size</label>
                                           <input type="text" name="land_size" value="" class="form-control" placeholder="Enter land size">
                                        </div>
										<div class="form-group">
                                            <label>Address</label>
                                           <textarea name="house_land_address" class="form-control" placeholder="Enter address"></textarea>
                                        </div>
										 </fieldset>
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
                        </div>
						<?php } ?>
                                </div>
                                <div id="floor-plans" class="tab-pane fade">
								<?php  if($controller == 'PropertyController' && $method == 'edit_house_land') { ?>
                                    	  <div class="panel-body">
										  
										   <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="properties">
                                    <thead>
                                        <tr>
											<th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
				
				/*  echo '<pre>';
				print_r($gallery_arr);
				die;   */
				if(!empty($prop_flor_arr)) {

				foreach($prop_flor_arr as $floor_val) {
					
				?>
				
										<tr>
                                            <td><?php if(!empty($floor_val['image'])) {  ?><img src="<?php echo url(); ?>/uploads/property_floor/<?php echo $floor_val['image'];  ?>" style="width:100px;height:100px;" /><?php  } else { echo 'No Image' ; } ?></td>     
                                            <td><button class="btn btn-danger btn-mini" onclick="javascript:delete_floor_gallery(<?php echo $floor_val['id'] ;  ?>)"><i class="icon-pencil icon-white"></i>Delete</button> 
											</td>
                                            
                                        </tr>
                                       
						<?php } } else {  echo '<tr><td colspan=2 style="text-align:center;font-weight:bold;">No Image Found.</td></tr>' ; } ?>
                                       
                                    </tbody>
                                </table>
                            </div>
										  		
										

	<div class="form-group">									   <!-- The fileinput-button span is used to style the file input field as button -->
<label>Add More Images</label>
            <div class="dropzone" id="dropzoneMoreFileUpload" style="background-color: #5683aa !important;
  border:none !important;">
            </div>
        </div>
		<input type="hidden" name="propid" value="<?php echo $property_arr['id']; ?>" id="propid"/>
				
                                        <!--<button class="btn btn-default" type="submit" id="display:none;">Save</button>-->
                                    
                          
                            
                        </div>
						<?php } ?>
                                </div>
								
								<!--<div id="display-homes" class="tab-pane fade">
								<?php  //if($controller == 'PropertyController' && $method == 'edit_property') { ?>
								
								   <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="properties">
                                    <thead>
                                        <tr>
											<th>Display Village Title</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
				
				/*  echo '<pre>';
				print_r($gallery_arr);
				die;   */
			/* 	if(!empty($display_homes_arr)) {
				foreach($display_homes_arr as $display_home) { */
					
				?>
				
										<tr>
                                            <td><?php // if(!empty($display_home['display_village_title'])) {  ?><?php //echo $display_home['display_village_title'];  ?> <?php //  } ?></td>     
                                            <td><button onclick="window.location.href='<?php //echo url(); ?>/admin/property/display-home/edit/<?php //echo $display_home['id']; ?>'" class="btn btn-primary btn-mini"><i class="icon-pencil icon-white"></i>Edit</button>
											<button class="btn btn-danger btn-mini" onclick="javascript:delete_display_home(<?php // echo $display_home['id'] ;  ?>)"><i class="icon-pencil icon-white"></i>Delete</button> 
											</td>
                                            
                                        </tr>
                                       
						<?php //} } else {  echo '<tr><td colspan=2 style="text-align:center;font-weight:bold;">No Display Home Found.</td></tr>' ; } ?>
                                       
                                    </tbody>
                                </table>
                            </div>
									
								
                                    	  <div class="panel-body">
										  
									 <form method="post" action="<?php //echo url(); ?>/admin/property/display-home/add/<?php //echo $property_arr['id']; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php //echo csrf_token() ; ?>">
										 <div class="form-group">
                                            <label>Display Village Title</label>
                                           <input placeholder="Enter Display Village Title" class="form-control" value="<?php //if(!empty(Input::old('display_village_title'))) { echo Input::old('display_village_title') ; }  ?>" name="display_village_title" type="text">
                                        </div>
                                        <div class="form-group">
                                             <label>Display Location</label>
                                             <textarea rows="3" class="form-control" id="desc" name="display_location"><?php //if(!empty(Input::old('display_location'))) { echo Input::old('display_location') ; }  ?></textarea>
                                        </div>
										<div class="form-group">
                                         <label>Open Hours</label>
                                            <div class="checkbox">
                                            <label><input type="hidden" name="weekdays" value="weekday"/>WeekDays</label>
                                            <label class="radio-inline">
                                                <input type="text" name="wstart_time"  value="<?php //if(!empty(Input::old('wstart_time'))) { echo Input::old('wstart_time') ; }  ?>" class="form-control" id="wstart_time">Start Time
                                            </label>
                                            <label class="radio-inline">
                                                <input type="text" name="wend_time"  value="<?php //if(!empty(Input::old('wend_time'))) { echo Input::old('wend_time') ; }  ?>" class="form-control" id="wend_time">End Time
                                            </label>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <!--<label>Checkboxes</label>-->
                                            <!--<div class="checkbox">
                                            <label><input type="hidden" name="saturday" value="saturday"/>Saturdays</label>
                                            <label class="radio-inline">
                                                <input type="text" name="sastart_time"  value="<?php //if(!empty(Input::old('sastart_time'))) { echo Input::old('sastart_time') ; }  ?>" class="form-control" id="sastart_time">Start Time
                                            </label>
                                            <label class="radio-inline">
                                                <input type="text" name="saend_time"  value="<?php //if(!empty(Input::old('saend_time'))) { echo Input::old('saend_time') ; }  ?>" class="form-control" id="saend_time">End Time
                                            </label>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <!--<label>Checkboxes</label>-->
                                            <!--<div class="checkbox">
                                            <label><input type="hidden" name="sunday" value="sunday"/>Sundays</label>
                                            <label class="radio-inline">
                                                <input type="text" name="sunstart_time"  value="<?php //if(!empty(Input::old('sunstart_time'))) { echo Input::old('sunstart_time') ; }  ?>" class="form-control" id="sunstart_time">Start Time
                                            </label>
                                            <label class="radio-inline">
                                                <input type="text" name="sunend_time"  value="<?php //if(!empty(Input::old('sunend_time'))) { echo Input::old('sunend_time') ; }  ?>" class="form-control" id="sunend_time">End Time
                                            </label>
                                            </div>
                                        </div>
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                        </div>
						<?php // } ?>
                                </div>-->
								
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
			</div>
				
           
		</div>
	</div>
	    <script>
    $(document).ready(function() {
	$('.prop_type').on('click',function(){
		if($(this).is(':checked'))
		{
			var property_type = $(this).val();
			if(property_type == '1')
			{
				$('#house_land').slideUp();
			}
			if(property_type == '2')
			{
				$('#house_land').slideDown();
			}
		}
	});
        $('#dataTables-example').DataTable({
                responsive: true
        });
		 $(".builder_location").select2({ width: '100%' });
		 $(".inclusion_id").select2({ width: '100%' });
		 $(".inclusion_id").on('change',function(){
			var inc = $(this).val();
			var rel = $(this).attr('rel');
			if(inc != '0')
			{
				$('.child-'+rel).slideDown();
			} else {
				$('.child-'+rel).slideUp();
			}
		 });
		 
		 
		 
    });
	
	<?php  if($controller == 'PropertyController' && $method == 'create_house_land') { ?>

	// Change this to the location of your server-side upload handler:
    var url = '<?php echo url(); ?>/admin/property/gallery/ajax_store_gallery_images';
	//var CSRF_TOKEN = 
   var baseUrl = "{{ url('/') }}";
        var token = "{{ Session::getToken() }}";
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("div#dropzoneFileUpload", {
            url: url,
            params: {
                _token: token,
            },
/* 			maxFiles: 6,
    maxfilesexceeded: function(file) {
        this.removeAllFiles();
        this.addFile(file);
    },
	init: function() {
    this.on("maxfilesexceeded", function(file){
        alert("No more files please! You can upload maximum 5 files!");
    });
  } */
        });
        Dropzone.options.myAwesomeDropzone = {
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            accept: function(file, done) {
 
            },
        };
		
		<?php  } else { ?>
		
		
		  var url1 = '<?php echo url(); ?>/admin/property/gallery/ajax_update_floor_images';
		  var token = "{{ Session::getToken() }}";
		 Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("div#dropzoneMoreFileUpload", {
            url: url1,
            params: {
                _token: token,
				propid:document.getElementById('propid').value
            },

        });
        Dropzone.options.myAwesomeDropzone = {
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            accept: function(file, done) {
 
            },
        };
		
		<?php  } ?>
		
	function delete_floor_gallery(img_id)
	{
		if(img_id)
		{
			var status = confirm('Are you sure you want to delete Floor Plan Image.');
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/property/floorplans/delete/'+img_id;
			}
		}
	}
	
	function delete_display_home(home_id)
	{
		if(home_id)
		{
			var status = confirm('Are you sure you want to delete display home.');
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/property/display-home/delete/'+home_id;
			}
		}
	}
	
	
	    $('#wstart_time').timepicker();
	    $('#wend_time').timepicker();
	    $('#sastart_time').timepicker();
	    $('#saend_time').timepicker();
	    $('#sunstart_time').timepicker();
	    $('#sunend_time').timepicker();
	
    </script>
	<style>
	.form-control.ui-timepicker-input {
    width: 90px;
}
	</style>
@stop
