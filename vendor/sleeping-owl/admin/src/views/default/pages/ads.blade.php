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

			<?php if(Session::has('update_message')) { ?>
    <div class="alert alert-success">
        <?php  echo Session::get('update_message') ; ?>
    </div>
	<?php } ?>
				
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $title; ?>
							<input type="button"  value="Create Ad" onclick="window.location.href='<?php echo url(); ?>/admin/ads/create'"class="btn btn-primary add_button">
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Headline</th>
                                            <th>Add Size</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
				
				if(!empty($ads_arr)) {
				
				foreach($ads_arr as $ads_val) {

				?>
				
										<tr>
                                            <td><?php echo $ads_val['headline']; ?></td>
                                            <td><?php echo $ads_val['add_size'].'px'; ?></td>
                                            <td><?php
											echo $ads_val['start_date'];	
											?></td>
											 <td><?php
											echo $ads_val['end_date'];	
											?></td>
                                            <td><button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/ads/change_ads_status/<?php echo $ads_val['id']; ?>/<?php echo $ads_val['status']; ?>'"><?php  if($ads_val['status']  == 'Unpublish') { ?><i class="fa fa-times"></i> <?php } else { ?><i class="fa fa-check"></i><?php } ?></button> <button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/ads/edit/<?php echo $ads_val['id']; ?>'"><i class="icon-pencil icon-white"></i>Edit</button> 
											<button class="btn btn-danger btn-mini" onclick="javascript:delete_ads(<?php echo $ads_val['id'] ;  ?>)" ><i class="icon-remove icon-white"></i>Delete</button>
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
	function delete_ads(ad_id)
	{
		if(ad_id)
		{
			var status = confirm('Are you sure you want to delete ads content.');
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/ads/delete/'+ad_id;
			}
		}
	}
    </script>
@stop