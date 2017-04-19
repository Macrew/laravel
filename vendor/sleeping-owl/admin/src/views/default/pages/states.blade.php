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
                            States
							<input type="button"  value="Add State" onclick="window.location.href='<?php echo url(); ?>/admin/state/create'"class="btn btn-primary add_button">
							
							<input type="button"  value="Manage States Visibilty" onclick="window.location.href='<?php echo url(); ?>/admin/state/visibilty'"class="btn btn-primary padd_button">
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="states">
                                    <thead>
                                        <tr>
                                            <th>State</th>
                                            <th>Location</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
				
				/* echo '<pre>';
				print_r($states_arr);
				die; */
				if(!empty($states_arr)) {
				
				foreach($states_arr as $states_val) {

				?>
				
										<tr>
                                            <td><?php echo $states_val['state_name']; ?></td>
                                            <td><?php echo $states_val['loc_name']; ?></td>
                                            <td><button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/state/edit/<?php echo $states_val['id']; ?>'"><i class="icon-pencil icon-white"></i>Edit</button> 
											<button class="btn btn-danger btn-mini" onclick="javascript:delete_state(<?php echo $states_val['id'] ;  ?>)" ><i class="icon-remove icon-white"></i>Delete</button>
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
        $('#states').DataTable({
                responsive: true
        });
    });
	function delete_state(state_id)
	{
		if(state_id)
		{
			var status = confirm('Are you sure you want to delete state.');
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/state/delete/'+state_id;
			}
		}
	}
    </script>
@stop