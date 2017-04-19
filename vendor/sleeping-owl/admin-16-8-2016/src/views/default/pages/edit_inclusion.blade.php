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
						 if($controller == 'InclusionController' && $method == 'edit_inclusion') {
						
						 
						?>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($builders_arr); 
						die; */
						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/inclusion/update/<?php echo $inc_arr['id']; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										 <div class="form-group">
                                            <label>Select parent inclusion</label>
                                           <select class="inclusions" name="parent_id">
										   <option value="0">None</option>
										   <?php foreach($inclusions_arr as $inc_val) {  ?>
                                                <option value="<?php echo $inc_val['id']; ?>" <?php if(!empty($inc_val['id'])) { if($inc_val['id'] == $inc_arr['parent_id']) { echo 'selected=selected' ; } } ?>><?php echo $inc_val['title']; ?></option>
												<?php } ?>
                                            </select>
                                        </div>
										 <div class="form-group">
                                            <label>Title</label>
                                           <input placeholder="Enter location" class="form-control" value="<?php if(!empty($inc_arr['title'])) { echo $inc_arr['title'] ; } ?>" name="title" type="text">
                                        </div>
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
                        </div>
						<?php } else if($controller == 'InclusionController' && $method == 'create_inclusion') { ?>
						  <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($builders_arr); 
						die; */

						
						?>
                                     <form method="post" action="<?php echo url(); ?>/admin/inclusion/add" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										 <div class="form-group">
                                           <label>Select parent inclusion</label>
                                           <select class="inclusions" name="parent_id">
										   <option value="0">None</option>
										   <?php foreach($inclusions_arr as $inc_val) {  ?>
                                                <option value="<?php echo $inc_val['id']; ?>"><?php echo $inc_val['title']; ?></option>
												<?php } ?>
                                            </select>
                                        </div>
										 <div class="form-group">
                                            <label>Title</label>
                                           <input placeholder="Enter location" class="form-control" value="" name="title" type="text">
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
		 $(".inclusions").select2({ width: '100%' });
    });
    </script>
@stop