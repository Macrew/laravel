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
                            Land Estates
							<input type="button"  value="Add Land Estate" onclick="window.location.href='<?php echo url(); ?>/admin/landestate/create'"class="btn btn-primary add_button">
							<input type="button"  value="Manage Display Lands Locations" onclick="window.location.href='<?php echo url(); ?>/admin/landestate/manage-display-land-location'"class="btn btn-primary add_button">
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>phone Number</th>
                                            <th>Address</th>
                                            <th>Action</th>


                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
				
				if(!empty($landestates_arr)) {
				
				foreach($landestates_arr as $build_val) {

				?>
				
										<tr>
                                            <td><?php echo $build_val['landestates']['company_name']; ?></td>
                                            <td><?php echo $build_val['landestates']['firstname'].' '.$build_val['landestates']['lastname']; ?></td>
                                            <td><?php echo $build_val['email']; ?></td>
                                            <td><?php echo $build_val['landestates']['phn_no']; ?></td>
                                            <td><?php echo $build_val['landestates']['address']; ?></td>
                                            <td><button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/landestate/edit/<?php echo $build_val['landestates']['landestate_id']; ?>'"><i class="icon-pencil icon-white"></i>Edit</button> 
											<button class="btn btn-danger btn-mini" onclick="javascript:delete_landestate(<?php echo $build_val['landestates']['landestate_id'] ;  ?>)" ><i class="icon-remove icon-white"></i>Delete</button>
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
	function delete_landestate(landestate_id)
	{
		if(landestate_id)
		{
			var status = confirm('Are you sure you want to delete LandEstate details.');
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/landestate/delete/'+landestate_id;
			}
		}
	}
    </script>
@stop