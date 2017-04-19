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
                                            <td> 
											<?php if($states_val['trash'] == 'no') { ?>
											<input type="hidden" id="trash_<?php echo $states_val['state_name']; ?>" value="trash" />
											<button class="btn btn-danger btn-mini" onclick="javascript:delete_state('<?php echo $states_val['state_name'];   ?>','<?php echo $states_val['trash'];   ?>')" ><i class="icon-remove icon-white"></i>Trash</button>
											<?php } else { ?>
											<input type="hidden" id="trash_<?php echo $states_val['state_name']; ?>" value="restore" />
											<button class="btn btn-primary btn-mini" onclick="javascript:delete_state('<?php echo $states_val['state_name'];   ?>','<?php echo $states_val['trash'];   ?>')" ><i class="icon-remove icon-white"></i>Restore</button>
											<?php } ?>
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
	function delete_state(state_name,status1)
	{
		if(state_name)
		{
			var trsh = document.getElementById('trash_'+state_name).value;
			if(trsh == 'trash'){
			var txt = "Are you sure you want to move the "+state_name+" states in trash.";
			} else {
				var txt = 'Are you sure you want to restore '+state_name+' states';
			}
			var status = confirm(txt);
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/state/change_visibilty/'+state_name+'/'+status1;
			}
		}
	}
    </script>
@stop