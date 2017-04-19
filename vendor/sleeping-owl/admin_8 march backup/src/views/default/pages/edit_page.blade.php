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
                            Pages
						
                        </div>
						
						<?php // echo Route::getCurrentRoute()->getActionName(); 
						
						 $currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method);
						 if($controller == 'ContentController' && $method == 'edit_page') {
						
						 
						?>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($landestate_arr); 
						die; */
						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/page/update/<?php echo $content_arr['id']; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										 <div class="form-group">
                                            <label>Title</label>
                                           <input placeholder="Enter Title" class="form-control" value="<?php if(!empty($content_arr['title'])) { echo $content_arr['title'] ; } ?>" name="title" type="text">
                                        </div>
										
										
											<div class="form-group">
                                            <label>Select Parent</label>
                                           <select class="builder_location"  name="parent_id">
										   <option value="0">None</option>
										   <?php  
											 foreach($pages_arr as $page_val) { 
											 if($content_arr['parent_id'] == $page_val['id']) {
										   ?>
										   <option value="<?php echo $page_val['id']; ?>" selected><?php  echo $page_val['title']; ?></option>
										   <?php  } else { ?>
										   <option value="<?php echo $page_val['id']; ?>"><?php  echo $page_val['title']; ?></option>
										   <?php  } } ?>
										  </select>
                                        </div>
                                         <div class="form-group">
                                            <label>Description</label>
                                            <textarea rows="3" class="form-control" id="desc" name="description"><?php if(!empty($content_arr['description'])) { echo $content_arr['description'] ; } ?></textarea>
											 <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('desc');
            </script>
                                        </div>
                                        <div class="form-group">
                                            <label>Upload Featured Image</label>
                                            <input type="file" name="featured_image">
											
                                        </div>
										<div class="form-group">
										<?php if(!empty($content_arr['featured_image'])) {   ?>
                                            <label>Image</label>
                                            <img src="<?php echo url(); ?>/uploads/featured_images/<?php echo $landestate_arr['featured_image'];  ?>"  width="50" height="50"/>
										<?php } ?>
										</div>
										
										  <div class="form-group">
                                            <label>Meta Keywords</label>
                                            <textarea rows="3" class="form-control"  name="meta_keywords"><?php if(!empty($content_arr['meta_keywords'])) { echo $content_arr['meta_keywords'] ; } ?></textarea>
                                        </div>
										
										  <div class="form-group">
                                            <label>Meta Description</label>
                                            <textarea rows="3" class="form-control"  name="meta_description"><?php if(!empty($content_arr['meta_description'])) { echo $content_arr['meta_description'] ; } ?></textarea>
                                        </div>
																		
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
                        </div>
						<?php } else if($controller == 'ContentController' && $method == 'create_page') { ?>
						  <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($landestate_arr); 
						die; */

						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/page/add" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
									 	<div class="form-group">
                                            <label>Title</label>
                                           <input placeholder="Enter Title" class="form-control" name="title" type="text" value="<?php if(!empty(Input::old('title'))) { echo Input::old('title') ; }  ?>">
                                        </div>
										<div class="form-group">
                                            <label>Select Parent</label>
                                           <select class="builder_location"  name="parent_id">
										   <option value="0">None</option>
										   <?php  
											 foreach($pages_arr as $page_val) { 
										   ?>
										   <option value="<?php echo $page_val['id']; ?>"><?php  echo $page_val['title']; ?></option>
										   <?php  } ?>
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
                                            <label>Upload Featured Image</label>
                                            <input type="file" name="featured_image">
											
                                        </div>
										
										  <div class="form-group">
                                            <label>Meta Keywords</label>
                                            <textarea rows="3" class="form-control"  name="meta_keywords"><?php if(!empty(Input::old('meta_keywords'))) { echo Input::old('meta_keywords') ; }  ?></textarea>
                                        </div>
										
										  <div class="form-group">
                                            <label>Meta Description</label>
                                            <textarea rows="3" class="form-control"  name="meta_description"><?php if(!empty(Input::old('meta_description'))) { echo Input::old('meta_description') ; }  ?></textarea>
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