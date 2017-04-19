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
                            Categories
						
                        </div>
						
						<?php // echo Route::getCurrentRoute()->getActionName(); 
						
						 $currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method);
						 if($controller == 'ContentController' && $method == 'edit_category') {
						
						 
						?>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($landestate_arr); 
						die; */
						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/category/update/<?php echo $category_arr['id']; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										 <div class="form-group">
                                            <label>Title</label>
                                           <input placeholder="Enter Title" class="form-control" value="<?php if(!empty($category_arr['category_title'])) { echo $category_arr['category_title'] ; } ?>" name="category_title" type="text">
                                        </div>

                                         <div class="form-group">
                                            <label>Description</label>
                                            <textarea rows="3" class="form-control" id="desc" name="description"><?php if(!empty($category_arr['description'])) { echo $category_arr['description'] ; } ?></textarea>
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
										<?php if(!empty($category_arr['featured_image'])) {   ?>
                                            <label>Image</label>
                                            <img src="<?php echo url(); ?>/uploads/featured_images/<?php echo $category_arr['featured_image'];  ?>"  width="50" height="50"/>
										<?php } ?>
										</div>
										
																		
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
                        </div>
						<?php } else if($controller == 'ContentController' && $method == 'create_category') { ?>
						  <div class="panel-body">
						<?php 
						/*  echo '<pre>';
						print_r($landestate_arr); 
						die; */

						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/category/add" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
									 	<div class="form-group">
                                            <label>Title</label>
                                           <input placeholder="Enter Title" class="form-control" name="category_title" type="text" value="<?php if(!empty(Input::old('category_title'))) { echo Input::old('category_title') ; }  ?>">
                                        </div>
                                         <div class="form-group">
                                            <label>Description</label>
                                            <textarea rows="3" class="form-control"  name="description"><?php if(!empty(Input::old('description'))) { echo Input::old('description') ; }  ?></textarea>
										
                                        </div>
                                        <div class="form-group">
                                            <label>Upload Featured Image</label>
                                            <input type="file" name="featured_image">
											
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