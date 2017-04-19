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
	
		<?php if(Session::has('delete_message')) { ?>
    <div class="alert alert-success">
        <?php  echo Session::get('delete_message') ; ?>
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
                            <?php 
							
						$currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method);
						  if($controller == 'PropertyController' && $method == 'edit_house_land_gallery') {
						$property_arr = $prop_arr[0];
						echo $property_arr['property_title'].' '.'Gallery Images';
						?>
								<input type="button" style="margin-left: 700px;" value="Add More Images" onclick="window.location.href='<?php echo url(); ?>/admin/house-and-land/gallery/add_gallery_images/<?php echo $property_arr['id']; ?>'" class="btn btn-primary">
								<button type="button" onclick="window.location.href='<?php echo url(); ?>/admin/house-and-land/sort_gallery/<?php echo $id ;  ?>'"class="btn btn-primary">Sort House and Land Gallery</button>

						<?php
						
						} else if($controller == 'PropertyController' && $method == 'add_more_house_land_images') {
							echo $title; ?>
							
								<input type="button" style="margin-left: 700px;" value="Back" onclick="window.location.href='<?php echo url(); ?>/admin/house-and-land/gallery/edit/<?php echo $propid; ?>'" class="btn btn-primary">
							
							<?php


							} else { 
							echo $title;
							}
							
							?>
							
							
                        </div>
						
						<?php // echo Route::getCurrentRoute()->getActionName(); 
						
						
						 if($controller == 'PropertyController' && $method == 'edit_house_land_gallery') {
						
						 
						?>
						

						<?php 
						/*  echo '<pre>';
						print_r($builders_arr); 
						die; */
						
						?>
     
                        <!-- /.panel-heading -->
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
				
				$property_arr = $prop_arr[0];
				
				/*   echo '<pre>';
				print_r($prop_arr);
				die;   */
				if(!empty($property_arr['property_gallery'])) {
				
				foreach($property_arr['property_gallery'] as $properties_val) {

				?>
				
										<tr>
                                            <td><img src="<?php echo url(); ?>/uploads/property_gallery/<?php echo $properties_val['image'];  ?>"  style="width:200px;height:200px;"/></td>     
                                            <td>
											<button class="btn btn-danger btn-mini" onclick="javascript:delete_gallery(<?php echo $properties_val['id'] ;  ?>)" ><i class="icon-remove icon-white"></i>Delete</button>
											</td>
                                        </tr>
                                       
						<?php } } ?>
                                       
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            
                        </div>
                        <!-- /.panel-body -->

                          

						<?php } else if($controller == 'PropertyController' && $method == 'create_house_land_gallery') { ?>
						  <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($builders_arr); 
						die; */

						
						?>
                                     <form method="post" action="<?php echo url(); ?>/admin/property/add" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										 <div class="form-group">
                                           <label>Select Builder</label>
                                           <select class="builder" name="builder_id">
										   <option value="0">None</option>
										   <?php foreach($builders_arr as $builder_val) {  ?>
                                                <option value="<?php echo $builder_val['builders']['builder_id']; ?>"><?php echo $builder_val['builders']['company_name']; ?></option>
												<?php } ?>
                                            </select>
                                        </div>
										 <div id="prop_html">
										 
                                        </div>
										
										
										<div id="file_upload_html" style="display:none;">
	<div class="form-group">									   <!-- The fileinput-button span is used to style the file input field as button -->

            <div class="dropzone" id="dropzoneFileUpload" style="background-color: #5683aa !important;
  border:none !important;">
            </div>
        </div>
							</div>			
                                        <!--<button class="btn btn-default" type="submit" id="display:none;">Save</button>-->
                                    </form>
                          
                            
                        </div>
						<?php }  else if($controller == 'PropertyController' && $method == 'add_more_house_land_images') { ?>
						
							  <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($builders_arr); 
						die; */

						
						?>
                                    
		
										
										

	<div class="form-group">									   <!-- The fileinput-button span is used to style the file input field as button -->

            <div class="dropzone" id="dropzoneMoreFileUpload" style="background-color: #5683aa !important;
  border:none !important;">
            </div>
        </div>
		<input type="hidden" name="propid" value="<?php echo $propid; ?>" id="propid"/>
				
                                        <!--<button class="btn btn-default" type="submit" id="display:none;">Save</button>-->
                                    
                          
                            
                        </div>
						
						<?php } ?>
						
						
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
		</div>
	</div>
		    <script type="text/javascript">
    $(document).ready(function() {
	 $('#properties').DataTable({
                responsive: true
        });
		 $(".builder").select2({ width: '100%' });
		 
		 $('.builder').on('change',function(){
			var builder_id = $(this).val();
			if(builder_id != '0') {
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			$.ajax({
			url: '<?php echo url(); ?>/admin/house-and-land/gallery/ajax_builder_properties',
			data: { builder: builder_id,_token: CSRF_TOKEN},
			type: 'POST',
			success: function(data) {
				 $('#prop_html').html(data);
				 $(".property_id").select2({ width: '100%' });
				// $('#file_upload_html').show();
				 show_file_html();
			   }
			
			});
			} else {
				alert('Please Select Builder');
				$('#prop_html').html('');
				//$('#file_upload_html').hide();
			}
			
			
		 }); 
		 

    
		
	});

	
	<?php  if($controller == 'PropertyController' && $method == 'create_house_land_gallery') { ?>

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
		
		
		  var url1 = '<?php echo url(); ?>/admin/property/gallery/ajax_update_gallery_images';
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
		
	
	function show_file_html()
	{
		$('.property_id').on('change',function(){
		var prop = $(this).val();
		if(prop != 0)
		{
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			$.ajax({
			url: '<?php echo url(); ?>/admin/property/gallery/ajax_set_property',
			data: { prop: prop,_token: CSRF_TOKEN},
			type: 'POST',
			success: function(data) {
			/* alert(data); */
			   }
			
			});
			$('#file_upload_html').show();
		} else {
			$('#file_upload_html').hide();
			alert('Please Select Property');
		}
		});
	}
	
	function delete_gallery(img_id)
	{
		if(img_id)
		{
			var status = confirm('Are you sure you want to delete Gallery Image.');
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/property/gallery/delete/'+img_id;
			}
		}
	}
	
    </script>

@stop