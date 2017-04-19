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
				
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $title; ?>
							<input type="button"  value="Add Blog" onclick="window.location.href='<?php echo url(); ?>/admin/blog/create'"class="btn btn-primary add_button">
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
				
				if(!empty($blogs_arr)) {
				
				foreach($blogs_arr as $blog_val) {

				?>
				
										<tr>
                                            <td><?php echo $blog_val['title']; ?></td>
                                            <td><?php
											$string = strip_tags($blog_val['description']);

if (strlen($string) > 300) {

    // truncate string
    $stringCut = substr($string, 0, 300);

    // make sure it ends in a word so assassinate doesn't become ass...
    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
}
echo $string;
											
											?></td>
                                            <td><button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/blog/edit/<?php echo $blog_val['id']; ?>'"><i class="icon-pencil icon-white"></i>Edit</button> 
											<button class="btn btn-danger btn-mini" onclick="javascript:delete_blog(<?php echo $blog_val['id'] ;  ?>)" ><i class="icon-remove icon-white"></i>Delete</button>
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
			var status = confirm('Are you sure you want to delete Blog content.');
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/blog/delete/'+blog_id;
			}
		}
	}
    </script>
@stop