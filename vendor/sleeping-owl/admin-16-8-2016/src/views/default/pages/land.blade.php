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
                            Lands
							<input type="button"  value="Add Land" onclick="window.location.href='<?php echo url(); ?>/admin/land/create'"class="btn btn-primary add_button">
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
											<th>Land Title</th>
                                            <th>Image</th>
                                            <th>Action</th>


                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
				
				if(!empty($landestates_arr)) {
				
				foreach($landestates_arr as $build_val) {

				?>
				
										<tr>
                                            <td><?php echo $build_val['title']; ?></td>
                                            <td><?php if(!empty($build_val['image'])) { ?><img src="<?php echo url().'/uploads/land_images/'.$build_val['image']; ?>" width="50" height="50" /><?php } ?></td>
                                            <td><button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/land/edit/<?php echo $build_val['id']; ?>'"><i class="icon-pencil icon-white"></i>Edit</button> 
											<button class="btn btn-danger btn-mini" onclick="javascript:delete_land(<?php echo $build_val['id'] ;  ?>)" ><i class="icon-remove icon-white"></i>Delete</button>
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
	function delete_land(landestate_id)
	{
		if(landestate_id)
		{
			var status = confirm('Are you sure you want to delete Land details.');
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/land/delete/'+landestate_id;
			}
		}
	}
    </script>
@stop