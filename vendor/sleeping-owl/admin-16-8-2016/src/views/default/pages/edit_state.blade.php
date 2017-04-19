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
                            States
						
                        </div>
						
						<?php // echo Route::getCurrentRoute()->getActionName(); 
						
						 $currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method);
						 if($controller == 'StateController' && $method == 'edit_state') {
						
						 
						?>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($builders_arr); 
						die; */
						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/state/update/<?php echo $states_arr['id']; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										 <div class="form-group">
                                            <label>State Name</label>
                                           <select class="form-control" name="state_name">
										    <option value="none">None</option>
                                                <option value="VIC" <?php if(!empty($states_arr['state_name'])) { if($states_arr['state_name'] == 'VIC') { echo 'selected=selected' ; } } ?>>VIC</option>
                                                <option value="QLD" <?php if(!empty($states_arr['state_name'])) { if($states_arr['state_name'] == 'QLD') { echo 'selected=selected' ; } } ?>>QLD</option>
                                                <option value="NSW" <?php if(!empty($states_arr['state_name'])) { if($states_arr['state_name'] == 'NSW') { echo 'selected=selected' ; } } ?>>NSW</option>
                                                <option value="WA" <?php if(!empty($states_arr['state_name'])) { if($states_arr['state_name'] == 'WA') { echo 'selected=selected' ; } } ?>>WA</option>
												<option value="ACT" <?php if(!empty($states_arr['state_name'])) { if($states_arr['state_name'] == 'ACT') { echo 'selected=selected' ; } } ?>>ACT</option>
                                                <option value="SA" <?php if(!empty($states_arr['state_name'])) { if($states_arr['state_name'] == 'SA') { echo 'selected=selected' ; } } ?>>SA</option>
                                                <option value="NT" <?php if(!empty($states_arr['state_name'])) { if($states_arr['state_name'] == 'NT') { echo 'selected=selected' ; } } ?>>NT</option>
                                                <option value="TAS" <?php if(!empty($states_arr['state_name'])) { if($states_arr['state_name'] == 'TAS') { echo 'selected=selected' ; } } ?>>TAS</option>
                                            </select>
                                        </div>
										 <div class="form-group">
                                            <label>Location</label>
                                           <input placeholder="Enter location" class="form-control" value="<?php if(!empty($states_arr['loc_name'])) { echo $states_arr['loc_name'] ; } ?>" name="loc_name" type="text">
                                        </div>
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
                        </div>
						<?php } else if($controller == 'StateController' && $method == 'create_state') { ?>
						  <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($builders_arr); 
						die; */

						
						?>
                                     <form method="post" action="<?php echo url(); ?>/admin/state/add" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										 <div class="form-group">
                                            <label>State Name</label>
                                           <select class="form-control" name="state_name">
										   <option value="none">None</option>
                                                <option value="VIC">VIC</option>
                                                <option value="QLD">QLD</option>
                                                <option value="NSW">NSW</option>
                                                <option value="WA">WA</option>
                                                <option value="ACT">ACT</option>
                                                <option value="SA">SA</option>
                                                <option value="NT">NT</option>
                                                <option value="TAS">TAS</option>
                                            </select>
                                        </div>
										 <div class="form-group">
                                            <label>Location</label>
                                           <input placeholder="Enter location" class="form-control" value="" name="loc_name" type="text">
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
@stop