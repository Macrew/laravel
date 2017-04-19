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
                            Builders
						
                        </div>
						
						<?php // echo Route::getCurrentRoute()->getActionName(); 
						
						 $currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method);
						 if($controller == 'BuilderController' && $method == 'edit_builder') {
						
						 
						?>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($builders_arr); 
						die; */
						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/builder/update/<?php echo $builders_arr['builder_id']; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										 <div class="form-group">
                                            <label>Firstname</label>
                                           <input placeholder="Enter firstname" class="form-control" value="<?php if(!empty($builders_arr['firstname'])) { echo $builders_arr['firstname'] ; } ?>" name="firstname" type="text">
                                        </div>
										 <div class="form-group">
                                            <label>Lastname</label>
                                           <input placeholder="Enter lastname" class="form-control" value="<?php if(!empty($builders_arr['lastname'])) { echo $builders_arr['lastname'] ; } ?>" name="lastname" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea rows="3" class="form-control" name="address"><?php if(!empty($builders_arr['address'])) { echo $builders_arr['address'] ; } ?></textarea>
                                        </div>
										 <div class="form-group">
                                            <label>Company Name</label>
                                             <input placeholder="Enter company name" class="form-control" value="<?php if(!empty($builders_arr['company_name'])) { echo $builders_arr['company_name'] ; } ?>" name="company_name" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Phone Number</label>
                                             <input placeholder="Enter phone number" class="form-control" value="<?php if(!empty($builders_arr['phn_no'])) { echo $builders_arr['phn_no'] ; } ?>" name="phn_no" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="Active" <?php if($user['status'] == 'Active') { echo 'selected' ; } ?>>Active</option>
                                                <option value="Inactive" <?php if($user['status'] == 'Inactive') { echo 'selected' ; } ?>>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Upload Logo</label>
                                            <input type="file" name="builder_logo">
											
                                        </div>
										<div class="form-group">
                                            <label>Image</label>
                                            <img src="<?php echo url(); ?>/uploads/builder_logo/<?php echo $builders_arr['logo'];  ?>"  width="50" height="50"/>
                                        </div>
                                        <div class="form-group">
                                            <label>History/Description</label>
                                            <textarea rows="3" class="form-control" id="desc" name="builder_desc"><?php if(!empty($builders_arr['builder_desc'])) { echo $builders_arr['builder_desc'] ; } ?></textarea>
											 <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('desc');
            </script>
                                        </div>
										
										
										   <div class="form-group">
                                            <label>Industry Awards</label>
                                            <textarea rows="3" class="form-control" id="industry_awards" name="industry_awards"><?php if(!empty($builders_arr['industry_awards'])) { echo $builders_arr['industry_awards'] ; } ?></textarea>
											 <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('industry_awards');
            </script>
                                        </div>
										
										<div class="form-group">
                                            <label>Established Year</label>
                                             <input placeholder="Enter Established Year" class="form-control" value="<?php if(!empty($builders_arr['established'])) { echo $builders_arr['established'] ; } ?>" name="established" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Annual Home Builds</label>
                                             <input placeholder="Enter Annual Home Builds" class="form-control" value="<?php if(!empty($builders_arr['annual_home_builds'])) { echo $builders_arr['annual_home_builds'] ; } ?>"  name="annual_home_builds" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Price Range</label>
                                             <input placeholder="Enter Price Range" class="form-control" name="price_range" value="<?php if(!empty($builders_arr['price_range'])) { echo $builders_arr['price_range'] ; } ?>" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Stuctured Gurantee</label>
                                             <input placeholder="Enter stuctured gurantee" class="form-control" value="<?php if(!empty($builders_arr['stuctured_gurantee'])) { echo $builders_arr['stuctured_gurantee'] ; } ?>" name="stuctured_gurantee" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Free maintaince Period</label>
                                             <input placeholder="Enter Free Maintainance Period" class="form-control" value="<?php if(!empty($builders_arr['free_maintaince_period'])) { echo $builders_arr['free_maintaince_period'] ; } ?>" name="free_maintaince_period" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Builder Location</label>
                                             <select class="builder_location" multiple="multiple" name="builder_location[]">
										   <?php  
											foreach($states_arr as $state_val) {
											if(in_array($state_val['id'],$location_arr)) { ?>
												 <option value="<?php echo $state_val['id']; ?>" selected><?php echo $state_val['loc_name']; ?></option>
										<?php 	} else {
										   ?>
										   <option value="<?php echo $state_val['id']; ?>"><?php echo $state_val['loc_name']; ?></option>
										   <?php  } } ?>
										  </select>
                                        </div>
										 <fieldset>
										 <legend>Accreditation</legend>
											 <div class="checkbox">
											 
												<label> <input type="checkbox"  name="housing_industry" <?php if(!empty($builders_arr['housing_industry'])) { if($builders_arr['housing_industry'] == 'Yes') { echo 'checked=checked'; } } ?> value="Yes">
												Housing Industry Association (HIA)
												</label>
												
											</div>
											 <div class="checkbox">
												<label><input type="checkbox"  name="master_builders" <?php if(!empty($builders_arr['master_builders'])) { if($builders_arr['master_builders'] == 'Yes') { echo 'checked=checked'; } } ?> value="Yes">
												Master Builders Association (MBA) 
												</label>
												
											</div>
											
										</fieldset>
                                       
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
                        </div>
						<?php } else if($controller == 'BuilderController' && $method == 'create_builder') { ?>
						  <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($builders_arr); 
						die; */

						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/builder/add" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
									 	<div class="form-group">
                                            <label>Email</label>
                                           <input placeholder="Enter email" class="form-control" name="email" type="text" value="<?php if(!empty(Input::old('email'))) { echo Input::old('email') ; }  ?>">
                                        </div>
										<div class="form-group">
                                            <label>Username</label>
                                           <input placeholder="Enter username" class="form-control" name="username" type="text" value="<?php if(!empty(Input::old('username'))) { echo Input::old('username') ; }  ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input placeholder="Enter password" class="form-control" name="password" type="password">
                                        </div>
										 <div class="form-group">
                                            <label>Firstname</label>
                                           <input placeholder="Enter firstname" class="form-control" value="<?php if(!empty(Input::old('firstname'))) { echo Input::old('firstname') ; }  ?>" name="firstname" type="text">
                                        </div>
										 <div class="form-group">
                                            <label>Lastname</label>
                                           <input placeholder="Enter lastname" class="form-control" value="<?php if(!empty(Input::old('lastname'))) { echo Input::old('lastname') ; }  ?>" name="lastname" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea rows="3" class="form-control" name="address"><?php if(!empty(Input::old('address'))) { echo Input::old('address') ; }  ?></textarea>
                                        </div>
										 <div class="form-group">
                                            <label>Company Name</label>
                                             <input placeholder="Enter company name" class="form-control" value="<?php if(!empty(Input::old('company_name'))) { echo Input::old('company_name') ; }  ?>" name="company_name" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Phone Number</label>
                                             <input placeholder="Enter phone number" class="form-control" value="<?php if(!empty(Input::old('phn_no'))) { echo Input::old('phn_no') ; }  ?>" name="phn_no" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Upload Logo</label>
                                            <input type="file" name="builder_logo">
											
                                        </div>
                                        <div class="form-group">
                                            <label>History/Description</label>
                                            <textarea rows="3" class="form-control" id="desc" name="builder_desc"><?php if(!empty(Input::old('builder_desc'))) { echo Input::old('builder_desc') ; }  ?></textarea>
											 <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('desc');
            </script>
                                        </div>
										
										   <div class="form-group">
                                            <label>Industry Awards</label>
                                            <textarea rows="3" class="form-control" id="industry_awards" name="industry_awards"><?php if(!empty(Input::old('industry_awards'))) { echo Input::old('industry_awards') ; }  ?></textarea>
											 <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('industry_awards');
            </script>
                                        </div>
										<div class="form-group">
                                            <label>Established Year</label>
                                             <input placeholder="Enter Established Year" class="form-control" value="<?php if(!empty(Input::old('established'))) { echo Input::old('established') ; }  ?>" name="established" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Annual Home Builds</label>
                                             <input placeholder="Enter Annual Home Builds" class="form-control" value="<?php if(!empty(Input::old('annual_home_builds'))) { echo Input::old('annual_home_builds') ; }  ?>"  name="annual_home_builds" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Price Range</label>
                                             <input placeholder="Enter Price Range" class="form-control" name="price_range" value="<?php if(!empty(Input::old('price_range'))) { echo Input::old('price_range') ; }  ?>" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Stuctured Gurantee</label>
                                             <input placeholder="Enter stuctured gurantee" class="form-control" value="<?php if(!empty(Input::old('stuctured_gurantee'))) { echo Input::old('stuctured_gurantee') ; }  ?>" name="stuctured_gurantee" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Free maintaince Period</label>
                                             <input placeholder="Enter Free Maintainance Period" class="form-control" value="<?php if(!empty(Input::old('free_maintaince_period'))) { echo Input::old('free_maintaince_period') ; }  ?>" name="free_maintaince_period" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Builder Location</label>
                                           <select class="builder_location" multiple="multiple" name="builder_location[]">
										   <?php  
											foreach($states_arr as $state_val) {
										   ?>
										   <option value="<?php echo $state_val['id']; ?>"><?php echo $state_val['loc_name']; ?></option>
										   <?php  } ?>
										  </select>
                                        </div>
										 <fieldset>
										 <legend>Accreditation</legend>
											 <div class="checkbox">
											 
												<label> <input type="checkbox"  name="housing_industry"  value="Yes" <?php if(!empty(Input::old('housing_industry'))) { echo 'checked=checked' ; }  ?>>
												Housing Industry Association (HIA)
												</label>
												
											</div>
											 <div class="checkbox">
												<label><input type="checkbox"  name="master_builders"  value="Yes" <?php if(!empty(Input::old('master_builders'))) { echo 'checked=checked' ; }  ?>>
												Master Builders Association (MBA) 
												</label>
												
											</div>
										</fieldset>
                                       
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
    });
    </script>
@stop