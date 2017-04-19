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
                            Mortgage Brokers
							<input type="button"  value="Add Broker" onclick="window.location.href='<?php echo url(); ?>/admin/broker/create'"class="btn btn-primary add_button">
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
				
				if(!empty($brokers_arr)) {
				
				foreach($brokers_arr as $build_val) {

				?>
				
										<tr>
                                            <td><?php echo $build_val['brokers']['company_name']; ?></td>
                                            <td><?php echo $build_val['brokers']['firstname'].' '.$build_val['brokers']['lastname']; ?></td>
                                            <td><?php echo $build_val['email']; ?></td>
                                            <td><?php echo $build_val['brokers']['phn_no']; ?></td>
                                            <td><?php echo $build_val['brokers']['address']; ?></td>
                                            <td><button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/broker/edit/<?php echo $build_val['brokers']['broker_id']; ?>'"><i class="icon-pencil icon-white"></i>Edit</button> 
											<button class="btn btn-danger btn-mini" onclick="javascript:delete_broker(<?php echo $build_val['brokers']['broker_id'] ;  ?>)" ><i class="icon-remove icon-white"></i>Delete</button>
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
	function delete_broker(broker_id)
	{
		if(broker_id)
		{
			var status = confirm('Are you sure you want to delete Broker details.');
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/broker/delete/'+broker_id;
			}
		}
	}
    </script>
@stop