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
                            Ads
						
                        </div>
						
						<?php // echo Route::getCurrentRoute()->getActionName(); 
						
						 $currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method);
						 if($controller == 'ContentController' && $method == 'edit_ads') {
						
						 
						?>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php 
						/*    echo '<pre>';
						print_r($content_arr); 
						die;  */
						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/ads/update/<?php echo $content_arr->id; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										 <div class="form-group">
                                            <label>Head Line</label>
                                           <input placeholder="Enter headline" class="form-control" value="<?php if(!empty($content_arr->headline)) { echo $content_arr->headline ; } ?>" name="headline" type="text">
                                        </div>
										
										 <div class="form-group">
                                            <label>Text</label>
                                           <input placeholder="Enter Text" class="form-control" value="<?php if(!empty($content_arr->add_text)) { echo $content_arr->add_text ; } ?>" name="add_text" type="text">
                                        </div>

										
										<div class="form-group">
                                            <label>Select Ad size</label>
                                           <select class="builder_location"  name="add_size">
										  <option  value="">Please select one option</option><option value="100" <?php  if(!empty($content_arr->add_size)){ if($content_arr->add_size == '100') { echo 'selected=selected'; } } ?>>100</option><option value="200" <?php  if(!empty($content_arr->add_size)){ if($content_arr->add_size == '200') { echo 'selected=selected'; } } ?> >200</option><option value="300" <?php  if(!empty($content_arr->add_size)){ if($content_arr->add_size == '300') { echo 'selected=selected'; } } ?>>300</option><option value="400" <?php  if(!empty($content_arr->add_size)){ if($content_arr->add_size == '400') { echo 'selected=selected'; } } ?>>400</option><option value="500" <?php  if(!empty($content_arr->add_size)){ if($content_arr->add_size == '500') { echo 'selected=selected'; } } ?>>500</option>
										  </select>
                                        </div>
										
                                      
                                        <div class="form-group">
                                            <label>Upload Image</label>
                                            <input type="file" name="image">
											
                                        </div>
										<div class="form-group">
										<?php if(!empty($content_arr->image)) {   ?>
                                            <label>Image</label>
                                            <img src="<?php echo url(); ?>/uploads/add_management/<?php echo $content_arr->image;  ?>"  width="50" height="50"/>
										<?php } ?>
										</div>
									<?php 	$start_date = date("m/d/Y",strtotime($content_arr->start_date)) ;
											$end_date = date("m/d/Y",strtotime($content_arr->end_date)) ;							
									?>
										 <div class="form-group">
                                            <label>Start Date</label>
                                           <input placeholder="Enter Start Date" class="form-control start_date" value="<?php if(!empty($start_date)) { echo $start_date ; } ?>" name="start_date"  type="text">
                                        </div>
										
										 <div class="form-group">
                                            <label>End Date</label>
                                           <input placeholder="Enter End Date" class="form-control end_date" value="<?php if(!empty($end_date)) { echo $end_date ; } ?>" name="end_date"  type="text">
                                        </div>
										 
																		
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
                        </div>
						<?php } else if($controller == 'ContentController' && $method == 'create_ads') { ?>
						  <div class="panel-body">
  <form method="post" action="<?php echo url(); ?>/admin/ads/add" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										 <div class="form-group">
                                            <label>Head Line</label>
                                           <input placeholder="Enter headline" class="form-control" value="<?php if(!empty(Input::old('headline'))) { echo Input::old('headline') ; }  ?>" name="headline" type="text">
                                        </div>
										
										 <div class="form-group">
                                            <label>Text</label>
                                           <input placeholder="Enter Text" class="form-control" value="<?php if(!empty(Input::old('add_text'))) { echo Input::old('add_text') ; }  ?>" name="add_text" type="text">
                                        </div>

										
										<div class="form-group">
                                            <label>Select Ad size</label>
                                           <select class="builder_location"  name="add_size">
										  <option  value="">Please select one option</option><option value="100">100</option><option value="200">200</option><option value="300">300</option><option value="400">400</option><option value="500">500</option>
										  </select>
                                        </div>
										
                                      
                                        <div class="form-group">
                                            <label>Upload Image</label>
                                            <input type="file" name="image">
											
                                        </div>
									
										 <div class="form-group">
                                            <label>Start Date</label>
                                           <input placeholder="Enter Start Date" class="form-control start_date" value="<?php if(!empty(Input::old('start_date'))) { echo Input::old('start_date') ; }  ?>" name="start_date"  type="text">
                                        </div>
										
										 <div class="form-group">
                                            <label>End Date</label>
                                           <input placeholder="Enter End Date" class="form-control end_date" value="<?php if(!empty(Input::old('end_date'))) { echo Input::old('end_date') ; }  ?>" name="end_date" type="text">
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
		 $('.end_date').datepicker();
		 $('.start_date').datepicker();
    });
    </script>
@stop