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
							<input type="button"  value="Add Gallery" onclick="window.location.href='<?php echo url(); ?>/admin/property/gallery/create'"class="btn btn-primary add_button">
                        </div>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="properties">
                                    <thead>
                                        <tr>
                                            <th>Property Name</th>
											<th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
				
				/*  echo '<pre>';
				print_r($gallery_arr);
				die;   */
				if(!empty($gallery_arr)) {
				
				foreach($gallery_arr as $properties_val) {

				?>
				
										<tr>
                                            <td><?php echo $properties_val['property_title']; ?></td>
                                            <td><?php if(!empty($properties_val['property_gallery'][0]['image'])) {  ?><img src="<?php echo url(); ?>/uploads/property_gallery/<?php echo $properties_val['property_gallery'][0]['image'];  ?>" style="width:100px;height:100px;" /><?php  } else { echo 'No Image' ; } ?></td>     
                                            <td><button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/property/gallery/edit/<?php echo $properties_val['id']; ?>'"><i class="icon-pencil icon-white"></i>Edit</button> 
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
        $('#properties').DataTable({
                responsive: true
        });
    });
	function delete_property(prop_id)
	{
		if(prop_id)
		{
			var status = confirm('Are you sure you want to delete Property.');
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/property/delete/'+prop_id;
			}
		}
	}
    </script>
@stop