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
                            Users
						
                        </div>
						
						<?php // echo Route::getCurrentRoute()->getActionName(); 
						
						 $currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method);
						 if($controller == 'BuilderController' && $method == 'edit_user') {
						
						 
						?>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($builders_arr); 
						die; */
						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/user/update/<?php echo $users_arr['user_id']; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										 <div class="form-group">
                                            <label>Firstname</label>
                                           <input placeholder="Enter firstname" class="form-control" value="<?php if(!empty($users_arr['firstname'])) { echo $users_arr['firstname'] ; } ?>" name="firstname" type="text">
                                        </div>
										 <div class="form-group">
                                            <label>Lastname</label>
                                           <input placeholder="Enter lastname" class="form-control" value="<?php if(!empty($users_arr['lastname'])) { echo $users_arr['lastname'] ; } ?>" name="lastname" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea rows="3" class="form-control" name="address"><?php if(!empty($users_arr['address'])) { echo $users_arr['address'] ; } ?></textarea>
                                        </div>
										 
										<div class="form-group">
                                            <label>Phone Number</label>
                                             <input placeholder="Enter phone number" class="form-control" value="<?php if(!empty($users_arr['phone'])) { echo $users_arr['phone'] ; } ?>" name="phone" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="Active" <?php if($user['status'] == 'Active') { echo 'selected' ; } ?>>Active</option>
                                                <option value="Inactive" <?php if($user['status'] == 'Inactive') { echo 'selected' ; } ?>>Inactive</option>
                                            </select>
                                        </div>
										
										<div class="form-group">
                                            <label>User Location</label>
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
                                     
										
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
                        </div>
						<?php } else if($controller == 'BuilderController' && $method == 'create_user') { ?>
						  <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($builders_arr); 
						die; */

						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/user/add" enctype="multipart/form-data">
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
                                            <label>Phone Number</label>
                                             <input placeholder="Enter phone number" class="form-control" value="<?php if(!empty(Input::old('phone'))) { echo Input::old('phone') ; }  ?>" name="phone" type="text">
                                        </div>
										<div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
										
										<div class="form-group">
                                            <label>User Location</label>
                                           <select class="builder_location" multiple="multiple" name="builder_location[]">
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