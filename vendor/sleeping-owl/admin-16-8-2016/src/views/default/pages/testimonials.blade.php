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

			<?php if(Session::has('delete_message')) { ?>
					<div class="alert alert-success">
						<?php  echo Session::get('delete_message') ; ?>
					</div>
			<?php } ?>
			<?php if(Session::has('error_message')) { ?>
					<div class="alert alert-success">
						<?php  echo Session::get('error_message') ; ?>
					</div>
			<?php } ?>
			<?php if($errors->any()) { ?>
				<div class="alert alert-danger">
					<?php 
						foreach($errors->all() as $error){  ?>
							<p><?php echo $error; ?></p>
					 <?php   }
					?>
				</div>
			<?php } ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $title; ?>
							<input type="button"  value="Add Testimonials" onclick="window.location.href='<?php echo url(); ?>/admin/testimonials/create'"class="btn btn-primary add_button">
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Action</th>


                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
				
				if(!empty($testimonials)) {
				
				foreach($testimonials as $val) {

				?>
				
										<tr>
                                            <td><?php echo $val->created_by; ?></td>
                                            <td><?php
											$string = strip_tags($val->description);

											if (strlen($string) > 300) {

												// truncate string
												$stringCut = substr($string, 0, 300);

												// make sure it ends in a word so assassinate doesn't become ass...
												$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
											}
											echo $string;
											
											?></td>
                                            <td><button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/testimonials/edit/<?php echo $val->id; ?>'"><i class="icon-pencil icon-white"></i>Edit</button> 
											<button class="btn btn-danger btn-mini" onclick="javascript:delete_blog(<?php echo $val->id;  ?>)" ><i class="icon-remove icon-white"></i>Delete</button>
											<button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/testimonials/featured/<?php echo $val->id; ?>/<?php echo $val->featured; ?>'" ><?php if($val->featured == "Yes"){  ?><i class="fa fa-star" style='color:#FFD700;'></i> <?php }else{ ?><i class="fa fa-star" ></i><?php } ?></button>
											</td>
                                            
                                        </tr>
                                       
						<?php } } ?>
                                       
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            
                        </div>
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
    });
	function delete_blog(blog_id)
	{
		if(blog_id)
		{
			var status = confirm('Are you sure you want to delete Testimonial.');
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/testimonials/delete/'+blog_id;
			}
		}
	}
    </script>
@stop
