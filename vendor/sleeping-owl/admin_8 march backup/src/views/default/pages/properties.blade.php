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
						   <input type="button"  value="Sort Featured Properties" onclick="window.location.href='<?php echo url(); ?>/admin/property/sort_featured'"class="btn btn-primary padd_button">
							<input type="button"  value="Add Property" onclick="window.location.href='<?php echo url(); ?>/admin/property/create'"class="btn btn-primary padd_button">
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="properties">
                                    <thead>
                                        <tr>
                                            <th>Property Name</th>
											<th>Builder</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
				
				/*  echo '<pre>';
				print_r($properties_arr);
				die;  */
				if(!empty($properties_arr)) {
				
				foreach($properties_arr as $properties_val) {

				?>
				
										<tr>
                                            <td><?php echo $properties_val['property_title']; ?></td>
                                            <td><?php echo $properties_val['builder_detail']['company_name']; ?></td>
                                            <td><?php  echo "$".number_format($properties_val['price'], 2);?></td>
                                            <td>
											<button class="btn btn-info" type="button" onclick="window.location.href='<?php echo url(); ?>/admin/property/view/<?php echo $properties_val['id']; ?>'">View Detail</button>
											<button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/property/edit/<?php echo $properties_val['id']; ?>'">Edit</button> 
											<button class="btn btn-danger btn-mini" onclick="javascript:delete_property(<?php echo $properties_val['id'] ;  ?>)" >Delete</button>
											<button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/property/featured/<?php echo $properties_val['id']; ?>'" ><?php if($properties_val['featured'] == "Yes"){  ?><i class="fa fa-star" style='color:#FFD700;'></i> <?php }else{ ?><i class="fa fa-star" ></i><?php } ?></button>
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
		<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Change order</h4>
	      </div>
	      <div class="modal-body">
	       <form action="" enctype="multipart/form-data" method ='POST'>
	       		<div class="form-col" style='margin:0 29% 70px;width:42%;'>
					<input type="number" required name="order" id='featured_id' placeholder="Change order" style=' padding: 4px;width: 100%;'>
					<input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
					<input type='hidden' name='pid' id='property_id'>
					<input type="submit" class='btn btn-primary add_button' name="submit" value="Submit" style='float: left;margin: 3% 0 0 26%;width: 47%;'>
				</div>
                <div class="clr"></div>
                	
                </div>
	       </form>
	      </div>
	    </div>

	  </div>
	</div>
	    <script>
    $(document).ready(function() {
        $('#properties').DataTable({
                responsive: true,
                "order": [[ 3, "desc" ]]
        });
        
    });
	$(document).on("click", ".open-AddBookDialog", function () {
		var myBookId = $(this).data('id');
		$(".modal-body #property_id").val( myBookId );
		$(".modal-body #featured_id").val( $(this).data('rel') );
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
