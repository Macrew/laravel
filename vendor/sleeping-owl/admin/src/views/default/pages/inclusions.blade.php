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
                       
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#inclusion" aria-expanded="true">Inclusions</a>
                                </li>
                                <li class=""><a data-toggle="tab" href="#filter_inclusion" aria-expanded="false">Manage Property Filter Inclusion</a>
                                </li>
                         </ul>
						 <div class="tab-content">
							 <div class="tab-pane fade in active" id="inclusion">
						 <div class="panel-heading">
                            Inclusions
							<input type="button"  value="Add Inclusion" onclick="window.location.href='<?php echo url(); ?>/admin/inclusion/create'"class="btn btn-primary add_button">
                        </div>
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="inclusions">
                                    <thead>
                                        <tr>
                                            <th>Inclusion</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
				
				/* echo '<pre>';
				print_r($states_arr);
				die; */
				if(!empty($inclusions_arr)) {
				
				foreach($inclusions_arr as $inclusion_val) {

				?>
				
										<tr>
                                            <td><?php echo $inclusion_val['title']; ?></td>
                                            <td><button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/inclusion/edit/<?php echo $inclusion_val['id']; ?>'"><i class="icon-pencil icon-white"></i>Edit</button> 
											<button class="btn btn-danger btn-mini" onclick="javascript:delete_inclusion(<?php echo $inclusion_val['id'] ;  ?>)" ><i class="icon-remove icon-white"></i>Delete</button>
											</td>
                                            
                                        </tr>
                                       
						<?php } } ?>
                                       
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
							</div>
							
							  <div class="tab-pane fade" id="filter_inclusion">
							           <div class="panel-body">
						<?php 
					 /*  echo '<pre>';
						print_r($prop_inc_arr); 
						die;   */ 
						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/inclusion/filter/update" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										
										<?php  foreach($inc_arr as $inc_val) {
												 
					
										?>
										 <div class="form-group">
                                            <label>Select <?php echo $inc_val['title'];  ?></label>
                                           <select class="inclusion_id"  name="inclusion_id" rel="<?php echo $inc_val['id']; ?>">
										   <option value="0">None</option>
											<?php 
											$checked =  false;
											if(!empty($filter_inc_arr)) {
                                                 foreach($filter_inc_arr as $prop_val) { 
											 $sel_inc =  App\Inclusion::check_inc_parent($prop_val['id']) ;
											if($sel_inc == $inc_val['id']) {
											$checked = true;
												$style="display:block;";
											?>
										       <option value="<?php echo $inc_val['id'];  ?>" selected><?php echo $inc_val['title'];  ?></option>
											  <?php break; } else {  $checked = false;   }   ?>
											   <?php } } 
											   ?>

											   <?php if($checked == false) { $style="display:none;"; ?>
											     <option value="<?php echo $inc_val['id'];  ?>"><?php echo $inc_val['title'];  ?></option>
												 <?php } ?>
										  </select>
										  </div>
										  

		
   <?php  $inclusion =  App\Inclusion::get_child_inclusions($inc_val['id']) ;
   

		

   ?>
						<?php 
/*  echo '<pre>';
print_r($inclusion); */
$checked1 = false;
					 if(!empty($inclusion)) {
					 if($checked == false) {
						$style="display:none;";
					 } else {
						$style="display:block;";
					 }
						foreach($inclusion as $inclusion_val) {
						
						/* echo '<pre>';
						print_r($filter_inc_arr); */
					
										foreach($filter_inc_arr as $prop_val) {
									if($prop_val['id'] == $inclusion_val['id']) {
											$style="display:block;";
											$checked1 = true;
						?>
									
										<div class="form-group child-<?php echo $inc_val['id']; ?>"  style=<?php echo $style; ?>>
                                            <!--<label>Checkboxes</label>-->
                                            <div class="checkbox">
                                                <label>
                                                   <?php echo $inclusion_val['title']; ?>
                                                </label>
												
                                            <label> | </label>
                                            <label class="radio-inline">
                                                <input type="checkbox" <?php if($prop_val['filter_inclusion'] == 'Yes' ) { echo 'checked=checked'; }  ?>  value="Yes" id="" name="inc_filter_<?php echo $inclusion_val['id'];  ?>">Set as filter inclusion
                                            </label>

                                            </div>
                                        </div>	

	<?php  break ; }  else { $checked1 =  false;  } } 
												if($checked1 ==  false) {
												//$style="display:block;";
										?>
										
<div class="form-group child-<?php echo $inc_val['id']; ?>"  style=<?php echo $style; ?>>
                                            <!--<label>Checkboxes</label>-->
                                            <div class="checkbox">
                                                <label>
                                                   <?php echo $inclusion_val['title']; ?>
                                                </label>
												
                                            <label> | </label>
                                            <label class="radio-inline">
                                                <input type="checkbox"  value="Yes" id="" name="inc_filter_<?php echo $inclusion_val['id'];  ?>">Set as filter inclusion
                                            </label>

                                            </div>
                                        </div>	

									<?php  } } } } ?>
                                                                            
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
                        </div>
							  </div>
							
							</div>
                            
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
        $('#inclusions').DataTable({
                responsive: true
        });
    });
	function delete_inclusion(inc_id)
	{
		if(inc_id)
		{
			var status = confirm('Are you sure you want to delete inclusion.');
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/inclusion/delete/'+inc_id;
			}
		}
	}
		 $(".inclusion_id").select2({ width: '100%' });
		 $(".inclusion_id").on('change',function(){
			var inc = $(this).val();
			var rel = $(this).attr('rel');
			if(inc != '0')
			{
				$('.child-'+rel).slideDown();
			} else {
				$('.child-'+rel).slideUp();
			}
		 });
	
	
    </script>
@stop