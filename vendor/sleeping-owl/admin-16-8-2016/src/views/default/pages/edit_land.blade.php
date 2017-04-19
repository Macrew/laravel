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
                            LandEstates
						
                        </div>
						
						<?php // echo Route::getCurrentRoute()->getActionName(); 
						
						 $currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method);
						 if($controller == 'LandEstateController' && $method == 'edit_land') {
						
						 
						?>
						
						
						 <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#general">General</a>
                                </li>
								   <li><a data-toggle="tab" href="#display-land">Display Land</a>
                                </li>
                            </ul>
						
						       <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="general" class="tab-pane fade in active">
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                                    <form method="post" action="<?php echo url(); ?>/admin/land/update/<?php echo $landestate_arr['id']; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
											<div class="form-group">
                                            <label>Land Title</label>
                                           <input placeholder="Enter Land Title" class="form-control" name="title" type="text" value="<?php if(!empty($landestate_arr['title'])) { echo $landestate_arr['title'] ; } ?>">
                                        </div>
											 <div class="form-group">
                                            <label>Select LandEstate</label>
                                           <select class="builder_location"  name="user_id">
										   <?php  
											foreach($landestates_arr as $builders_val) {
											if($builders_val['landestates']['landestate_id'] == $landestate_arr['user_id']) { ?>
											<option value="<?php echo $builders_val['landestates']['landestate_id']; ?>" selected><?php echo $builders_val['landestates']['company_name']; ?></option>
										 <?php } else {  ?>
										   <option value="<?php echo $builders_val['landestates']['landestate_id']; ?>"><?php echo $builders_val['landestates']['company_name']; ?></option>
										   <?php  } } ?>
										  </select>
										  </div>
                                        <div class="form-group">
                                            <label>Upload Land Image</label>
                                            <input type="file" name="landestate_image">
											
                                        </div>
										<img width="50" height="50" src="<?php echo url(); ?>/uploads/land_images/<?php echo $landestate_arr['image']  ?>">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea rows="3" class="form-control" id="desc" name="land_desc"><?php if(!empty($landestate_arr['description'])) { echo $landestate_arr['description'] ; } ?></textarea>
											 <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('desc');
            </script>
                                        </div>
										<div class="form-group">
                                            <label>Total Size</label>
                                           <input placeholder="Enter Land Size" class="form-control" name="total_size" type="text" value="<?php if(!empty($landestate_arr['total_size'])) { echo $landestate_arr['total_size'] ; } ?>">
                                        </div>
										
										<div class="form-group">
                                            <label>Completion Date</label>
                                           <input placeholder="Enter Completion Date" class="form-control" id="completion_date" name="completion_date" type="text" value="<?php if(!empty($landestate_arr['completion_date'])) { echo $landestate_arr['completion_date'] ; } ?>">
                                        </div>
										
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
                        </div>
						</div>
						  <div id="display-land" class="tab-pane fade in active">
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
				if(!empty($land_arr)) {
				foreach($land_arr as $display_land) {
					
				?>
				
										<tr>
                                            <td><?php if(!empty($display_land['display_village_title'])) {  ?><?php echo $display_land['display_village_title'];  ?> <?php  } ?></td>     
                                            <td><button onclick="window.location.href='<?php echo url(); ?>/admin/land/display-land/edit/<?php echo $display_land['id']; ?>'" class="btn btn-primary btn-mini"><i class="icon-pencil icon-white"></i>Edit</button>
											<button class="btn btn-danger btn-mini" onclick="javascript:delete_display_land(<?php echo $display_land['id'] ;  ?>)"><i class="icon-pencil icon-white"></i>Delete</button> 
											</td>
                                            
                                        </tr>
                                       
						<?php } } else {  echo '<tr><td colspan=2 style="text-align:center;font-weight:bold;">No Display Land Found.</td></tr>' ; } ?>
                                       
                                    </tbody>
                                </table>
                            </div>
									
								
                                    	  <div class="panel-body">
										  
									 <form method="post" action="<?php echo url(); ?>/admin/land/display-land/add/<?php echo $landestate_arr['id']; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										 <div class="form-group">
                                            <label>Display Village Title</label>
                                           <input placeholder="Enter Display Village Title" class="form-control" value="<?php if(!empty(Input::old('display_village_title'))) { echo Input::old('display_village_title') ; }  ?>" name="display_village_title" type="text">
                                        </div>
                                        <div class="form-group">
                                             <label>Display Location</label>
                                             <textarea rows="3" class="form-control" id="desc" name="display_location"><?php if(!empty(Input::old('display_location'))) { echo Input::old('display_location') ; }  ?></textarea>
                                        </div>
										<div class="form-group">
                                         <label>Open Hours</label>
                                            <div class="checkbox">
                                            <label><input type="hidden" name="weekdays" value="weekday"/>WeekDays</label>
                                            <label class="radio-inline">
                                                <input type="text" name="wstart_time"  value="<?php if(!empty(Input::old('wstart_time'))) { echo Input::old('wstart_time') ; }  ?>" class="form-control" id="wstart_time">Start Time
                                            </label>
                                            <label class="radio-inline">
                                                <input type="text" name="wend_time"  value="<?php if(!empty(Input::old('wend_time'))) { echo Input::old('wend_time') ; }  ?>" class="form-control" id="wend_time">End Time
                                            </label>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <!--<label>Checkboxes</label>-->
                                            <div class="checkbox">
                                            <label><input type="hidden" name="saturday" value="saturday"/>Saturdays</label>
                                            <label class="radio-inline">
                                                <input type="text" name="sastart_time"  value="<?php if(!empty(Input::old('sastart_time'))) { echo Input::old('sastart_time') ; }  ?>" class="form-control" id="sastart_time">Start Time
                                            </label>
                                            <label class="radio-inline">
                                                <input type="text" name="saend_time"  value="<?php if(!empty(Input::old('saend_time'))) { echo Input::old('saend_time') ; }  ?>" class="form-control" id="saend_time">End Time
                                            </label>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <!--<label>Checkboxes</label>-->
                                            <div class="checkbox">
                                            <label><input type="hidden" name="sunday" value="sunday"/>Sundays</label>
                                            <label class="radio-inline">
                                                <input type="text" name="sunstart_time"  value="<?php if(!empty(Input::old('sunstart_time'))) { echo Input::old('sunstart_time') ; }  ?>" class="form-control" id="sunstart_time">Start Time
                                            </label>
                                            <label class="radio-inline">
                                                <input type="text" name="sunend_time"  value="<?php if(!empty(Input::old('sunend_time'))) { echo Input::old('sunend_time') ; }  ?>" class="form-control" id="sunend_time">End Time
                                            </label>
                                            </div>
                                        </div>
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                        </div>
						  </div>
						</div>
						
						<?php } else if($controller == 'LandEstateController' && $method == 'create_land') { ?>
						  <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($landestate_arr); 
						die; */

						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/land/add" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
									 	<div class="form-group">
                                            <label>Land Title</label>
                                           <input placeholder="Enter Land Title" class="form-control" name="title" type="text" value="<?php if(!empty(Input::old('title'))) { echo Input::old('title') ; }  ?>">
                                        </div>
											 <div class="form-group">
                                            <label>Select LandEstate</label>
                                           <select class="builder_location"  name="user_id">
										   <?php  
											foreach($landestates_arr as $builders_val) { ?>
										   <option value="<?php echo $builders_val['landestates']['landestate_id']; ?>"><?php echo $builders_val['landestates']['company_name']; ?></option>
										   <?php  }  ?>
										  </select>
										  </div>
                                        <div class="form-group">
                                            <label>Upload Land Image</label>
                                            <input type="file" name="landestate_image">
											
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea rows="3" class="form-control" id="desc" name="land_desc"><?php if(!empty(Input::old('land_desc'))) { echo Input::old('land_desc') ; }  ?></textarea>
											 <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('desc');
            </script>
                                        </div>
										
										<div class="form-group">
                                            <label>Total Size</label>
                                           <input placeholder="Enter Land Size" class="form-control" name="total_size" type="text" value="<?php if(!empty(Input::old('total_size'))) { echo Input::old('total_size') ; }  ?>">
                                        </div>
										
										<div class="form-group">
                                            <label>Completion Date</label>
                                           <input placeholder="Enter Completion Date" class="form-control" id="completion_date" name="completion_date" type="text" value="<?php if(!empty(Input::old('completion_date'))) { echo Input::old('completion_date') ; }  ?>">
                                        </div>
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
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
	    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
		 $(".builder_location").select2({ width: '100%' });
		 $('#completion_date').datepicker({
		   useCurrent : { Default: false },
		   format: "dd-mm-yyyy"
		   });
		   
	
	
	   $('#wstart_time').timepicker();
	    $('#wend_time').timepicker();
	    $('#sastart_time').timepicker();
	    $('#saend_time').timepicker();
	    $('#sunstart_time').timepicker();
	    $('#sunend_time').timepicker();
		   
		   
    });
	
	function delete_display_land(land_id)
	{
		if(land_id)
		{
			var status = confirm('Are you sure you want to delete display land.');
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/land/display-land/delete/'+land_id;
			}
		}
	} 
	
    </script>
@stop