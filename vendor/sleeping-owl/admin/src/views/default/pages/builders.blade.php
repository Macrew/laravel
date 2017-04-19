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
                            Builders
							<input type="button"  value="Add Builder" onclick="window.location.href='<?php echo url(); ?>/admin/builder/create'"class="btn btn-primary add_button">
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
                                            <th width='20%'>Action</th>


                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
				
				if(!empty($builders_arr)) {
				
				foreach($builders_arr as $build_val) {

				?>
				
										<tr>
                                            <td><?php echo $build_val['builders']['company_name']; ?></td>
                                            <td><?php echo $build_val['builders']['firstname'].' '.$build_val['builders']['lastname']; ?></td>
                                            <td><?php echo $build_val['email']; ?></td>
                                            <td><?php echo $build_val['builders']['phn_no']; ?></td>
                                            <td><?php echo $build_val['builders']['address']; ?></td>
                                            <td><button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/builder/edit/<?php echo $build_val['builders']['builder_id']; ?>'"><i class="icon-pencil icon-white"></i>Edit</button> <?php if($build_val['builders']['trash'] == "no"){  ?>
											<input type="hidden" id="trash_<?php echo $build_val['builders']['builder_id']; ?>" value="trash" />
											<button class="btn btn-danger btn-mini" onclick="javascript:delete_builder(<?php echo $build_val['builders']['builder_id'] ;  ?>)" ><i class="icon-remove icon-white"></i>Delete</button><?php } else { ?>
											<input type="hidden" id="trash_<?php echo $build_val['builders']['builder_id']; ?>" value="restore" />
											<button class="btn btn-primary btn-mini" onclick="javascript:delete_builder(<?php echo $build_val['builders']['builder_id'] ;  ?>)" ><i class="icon-remove icon-white"></i>Restore</button>
											<?php } ?>
											<button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/builder/featured/<?php echo $build_val['builders']['builder_id']; ?>'" ><?php if($build_val['builders']['featured'] == "Yes"){  ?><i class="fa fa-star" style='color:#FFD700;'></i> <?php }else{ ?><i class="fa fa-star" ></i><?php } ?></button>
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
	function delete_builder(builder_id)
	{
		if(builder_id)
		{
			var trsh = document.getElementById('trash_'+builder_id).value;
			if(trsh == 'trash'){
			var txt = "Are you sure you want to move the builder & their plans in trash.";
			} else {
				var txt = 'Are you sure you want to restore builder & their plans';
			}
			var status = confirm(txt);
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/builder/delete/'+builder_id;
			}
		}
	}
    </script>
@stop
