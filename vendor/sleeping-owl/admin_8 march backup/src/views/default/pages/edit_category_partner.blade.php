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
                            Partners
						
                        </div>
						
						<?php // echo Route::getCurrentRoute()->getActionName(); 
						
						 $currentAction = Route::currentRouteAction();
					     list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method);
						 if($controller == 'CategoryController' && $method == 'edit_partner') {
						
						 
						?>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($landestate_arr); 
						die; */
						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/partner/update/<?php echo $landestate_arr['broker_id']; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										 <div class="form-group">
                                            <label>Firstname</label>
                                           <input placeholder="Enter firstname" class="form-control" value="<?php if(!empty($landestate_arr['firstname'])) { echo $landestate_arr['firstname'] ; } ?>" name="firstname" type="text">
                                        </div>
										 <div class="form-group">
                                            <label>Lastname</label>
                                           <input placeholder="Enter lastname" class="form-control" value="<?php if(!empty($landestate_arr['lastname'])) { echo $landestate_arr['lastname'] ; } ?>" name="lastname" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea rows="3" class="form-control" name="address"><?php if(!empty($landestate_arr['address'])) { echo $landestate_arr['address'] ; } ?></textarea>
                                        </div>
										 <div class="form-group">
                                            <label>Company Name</label>
                                             <input placeholder="Enter company name" class="form-control" value="<?php if(!empty($landestate_arr['company_name'])) { echo $landestate_arr['company_name'] ; } ?>" name="company_name" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Phone Number</label>
                                             <input placeholder="Enter phone number" class="form-control" value="<?php if(!empty($landestate_arr['phn_no'])) { echo $landestate_arr['phn_no'] ; } ?>" name="phn_no" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>Upload Logo</label>
                                            <input type="file" name="landestate_logo">
											
                                        </div>
										<div class="form-group">
										<?php if(!empty($landestate_arr['logo'])) {   ?>
                                            <label>Image</label>
                                            <img src="<?php echo url(); ?>/uploads/landestate_logo/<?php echo $landestate_arr['logo'];  ?>"  width="50" height="50"/>
										<?php } ?>
                                        </div>
                                        <div class="form-group">
                                            <label>History/Description</label>
                                            <textarea rows="3" class="form-control" id="desc" name="broker_desc"><?php if(!empty($landestate_arr['broker_desc'])) { echo $landestate_arr['broker_desc'] ; } ?></textarea>
											 <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('desc');
            </script>
                                        </div>
										

										<div class="form-group">
                                            <label>Established Year</label>
                                             <input placeholder="Enter Established Year" class="form-control" value="<?php if(!empty($landestate_arr['established'])) { echo $landestate_arr['established'] ; } ?>" name="established" type="text">
                                        </div>

										
										<div class="form-group">
                                            <label>Landestate Location</label>
                                             <select class="builder_location" multiple="multiple" name="broker_location[]">
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
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
                        </div>
						<?php } else if($controller == 'CategoryController' && $method == 'create_category') { ?>
						  <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($landestate_arr); 
						die; */

						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/partner/add" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
									 	<div class="form-group">
                                            <label>Email</label>
                                           <input placeholder="Enter email" class="form-control" name="email" type="text" value="<?php if(!empty(Input::old('email'))) { echo Input::old('email') ; }  ?>">
                                        </div>
                                        <!--<div class="form-group">
                                            <label>Password</label>
                                            <input placeholder="Enter password" class="form-control" name="password" type="password">
                                        </div>-->
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
                                            <label>Upload Logo</label>
                                            <input type="file" name="partner_logo">
											
                                        </div>
                                        <div class="form-group">
                                            <label>History/Description</label>
                                            <textarea rows="3" class="form-control" id="desc" name="partner_desc"><?php if(!empty(Input::old('partner_desc'))) { echo Input::old('partner_desc') ; }  ?></textarea>
											 <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('desc');
            </script>
                                        </div>
										

										<div class="form-group">
                                            <label>Established Year</label>
                                             <input placeholder="Enter Established Year" class="form-control" value="<?php if(!empty(Input::old('established'))) { echo Input::old('established') ; }  ?>" name="established" type="text">
                                        </div>

										<div class="form-group">
                                            <label>Location</label>
                                           <select class="builder_location" multiple="multiple" name="partner_location[]">
										   <?php  
											foreach($states_arr as $state_val) {
										   ?>
										   <option value="<?php echo $state_val['id']; ?>"><?php echo $state_val['loc_name']; ?></option>
										   <?php  } ?>
										  </select>
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
    });
    </script>
@stop