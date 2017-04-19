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
	<?php if(Session::has('save_message')) { ?>
    <div class="alert alert-success">
        <?php  echo Session::get('save_message') ; ?>
    </div>
	<?php } ?>			
<?php if(Session::has('update_message')) { ?>
    <div class="alert alert-success">
        <?php  echo Session::get('update_message') ; ?>
    </div>
	<?php } ?>

	<?php if($errors->any()) { ?>
    <div class="alert alert-danger">
	<?php 
        foreach($errors->all() as $error){  ?>
            <p><?php echo $error ; ?></p>
     <?php   }
		?>
    </div>
	<?php } ?>
				
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Property Inclusion - <?php echo $builder_arr['builders']['company_name']; ?>
							<input type="button"  value="Back" onclick="window.location.href='<?php echo url(); ?>/admin/builder/edit/ <?php echo $builder_arr['builders']['builder_id']; ?>'"class="btn btn-primary padd_button">
                        </div>
						
					           <?php // echo Route::getCurrentRoute()->getActionName(); 
						
						 $currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method);
						 if($controller == 'PropertyController' && $method == 'edit_property_inclusion') {
						
						 
						?>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php 
					 /*  echo '<pre>';
						print_r($prop_inc_arr); 
						die;   */ 
						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/property/inclusion/update/<?php echo $prop_id; ?>/<?php echo $builder_id; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
										
										<?php  foreach($inc_arr as $inc_val) {
												 
					
										?>
										 <div class="form-group">
                                            <label>Select <?php echo $inc_val['title'];  ?></label>
                                           <select class="inclusion_id"  name="inclusion_id" rel="<?php echo $inc_val['id']; ?>">
										   <option value="0">None</option>
											<?php 
											$checked =  false;
											if(!empty($prop_inc_arr)) {
                                                 foreach($prop_inc_arr as $prop_val) { 
											 $sel_inc =  App\Inclusion::check_inc_parent($prop_val['inclusion_id']) ;
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
					 } ?>
					 	<div class="form-group child-<?php echo $inc_val['id']; ?>" style=<?php echo $style; ?>>
										<div class="checkbox">
                                                <label>
                                                    <input class="select_all_inc" type="checkbox" value="<?php echo $inc_val['id'];  ?>">Select All
                                                </label>
										</div>
										</div>
					 <?php 
						foreach($inclusion as $inclusion_val) {
						foreach($prop_inc_arr as $prop_val) {
									if($prop_val['inclusion_id'] == $inclusion_val['id']) {
											$style="display:block;";
											$checked1 = true;
						?>
										<div class="form-group child-<?php echo $inc_val['id']; ?>"  style=<?php echo $style; ?>>
                                            <!--<label>Checkboxes</label>-->
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" checked value="<?php echo $inclusion_val['id'];  ?>" name="inc_<?php echo $inclusion_val['id'];  ?>" class="check_<?php echo $inc_val['id']; ?>"><?php echo $inclusion_val['title']; ?>
                                                </label>
												
                                            <label> | Inclusion Type</label>
                                            <label class="radio-inline">
                                                <input type="radio" <?php if($prop_val['inclusion_type'] == '2' ) { echo 'checked=checked'; }  ?> value="2" id="optionsRadiosInline1" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Standard inclusion
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" <?php if($prop_val['inclusion_type'] == '3' ) { echo 'checked=checked'; }  ?> value="3" id="optionsRadiosInline2" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Available as upgrade
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" <?php if($prop_val['inclusion_type'] == '1' ) { echo 'checked=checked'; }  ?>  value="1" id="optionsRadiosInline3" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Not available
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
                                                    <input type="checkbox"  value="<?php echo $inclusion_val['id'];  ?>" name="inc_<?php echo $inclusion_val['id'];  ?>" class="check_<?php echo $inc_val['id']; ?>" ><?php echo $inclusion_val['title']; ?>
                                                </label>
												
                                            <label> | Inclusion Type</label>
                                            <label class="radio-inline">
                                                <input type="radio" checked="" value="2" id="optionsRadiosInline1" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Standard inclusion
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" value="3" id="optionsRadiosInline2" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Available as upgrade
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" value="1" id="optionsRadiosInline3" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Not available
                                            </label>
                                       
                                            </div>
                                        </div>	




									<?php  } } } } ?>
                                                                            
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
                        </div>
						<?php } else if($controller == 'PropertyController' && $method == 'add_property_inclusion'){ ?>
										
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php 
					 /*  echo '<pre>';
						print_r($prop_inc_arr); 
						die;   */ 
						
						?>
                                    <form method="post" action="<?php echo url(); ?>/admin/property/inclusion/add/<?php echo $builder_id; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
									 <input type="hidden" name="inc_st" value=""/>
									 									 	<div class="form-group">
                                            <label>Select Properties</label>
                                           <select class="property_ids" multiple="multiple" name="property_ids[]">
										   <?php  
											foreach($prop_arr as $prop_val) {
										   ?>
										   <option value="<?php echo $prop_val['id']; ?>"><?php echo $prop_val['property_title']; ?></option>
										   <?php  } ?>
										  </select>
                                        </div>
										
										<?php  foreach($inc_arr as $inc_val) {
												 
					
										?>
										 <div class="form-group">
                                            <label>Select <?php echo $inc_val['title'];  ?></label>
                                           <select class="inclusion_id"  name="inclusion_id" rel="<?php echo $inc_val['id']; ?>">
										   <option value="0">None</option>
											<?php 
											$checked =  false;
											if(!empty($prop_inc_arr)) {
                                                 foreach($prop_inc_arr as $prop_val) { 
											 $sel_inc =  App\Inclusion::check_inc_parent($prop_val['inclusion_id']) ;
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
					 } ?>
					 
					  	<div class="form-group child-<?php echo $inc_val['id']; ?>" style=<?php echo $style; ?>>
										<div class="checkbox">
                                                <label>
                                                    <input class="select_all_inc" type="checkbox" value="<?php echo $inc_val['id'];  ?>">Select All
                                                </label>
										</div>
										</div>
						<?php foreach($inclusion as $inclusion_val) {
						if(!empty($prop_inc_arr)) {
						foreach($prop_inc_arr as $prop_val) {
									if($prop_val['inclusion_id'] == $inclusion_val['id']) {
											$style="display:block;";
											$checked1 = true;
						?>
										<div class="form-group child-<?php echo $inc_val['id']; ?>"  style=<?php echo $style; ?>>
                                            <!--<label>Checkboxes</label>-->
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" checked value="<?php echo $inclusion_val['id'];  ?>" name="inc_<?php echo $inclusion_val['id'];  ?>" class="check_<?php echo $inc_val['id']; ?>"><?php echo $inclusion_val['title']; ?>
                                                </label>
												
                                            <label> | Inclusion Type</label>
                                            <label class="radio-inline">
                                                <input type="radio" <?php if($prop_val['inclusion_type'] == '2' ) { echo 'checked=checked'; }  ?> value="2" id="optionsRadiosInline1" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Standard inclusion
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" <?php if($prop_val['inclusion_type'] == '3' ) { echo 'checked=checked'; }  ?> value="3" id="optionsRadiosInline2" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Available as upgrade
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" <?php if($prop_val['inclusion_type'] == '1' ) { echo 'checked=checked'; }  ?>  value="1" id="optionsRadiosInline3" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Not available
                                            </label>
                                       
                                            </div>
                                        </div>
										  
										  
										<?php  break ; }  else { $checked1 =  false;  } } }
												if($checked1 ==  false) {
												//$style="display:block;";
										?>
										
										
										<div class="form-group child-<?php echo $inc_val['id']; ?>"  style=<?php echo $style; ?>>
                                            <!--<label>Checkboxes</label>-->
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"  value="<?php echo $inclusion_val['id'];  ?>" name="inc_<?php echo $inclusion_val['id'];  ?>" class="check_<?php echo $inc_val['id']; ?>"><?php echo $inclusion_val['title']; ?>
                                                </label>
												
                                            <label> | Inclusion Type</label>
                                            <label class="radio-inline">
                                                <input type="radio" checked="" value="2" id="optionsRadiosInline1" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Standard inclusion
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" value="3" id="optionsRadiosInline2" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Available as upgrade
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" value="1" id="optionsRadiosInline3" name="inc_type_<?php echo $inclusion_val['id'];  ?>">Not available
                                            </label>
                                       
                                            </div>
                                        </div>	




									<?php  } } } } ?>
                                                                            
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
                        </div>
						<?php } ?>
						
						
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
		 $(".builder_location").select2({ width: '100%' });
		 
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
		 
		 $(".select_all_inc").change(function () {
		 var check_val = $(this).val();
    $(".check_"+check_val).prop('checked', $(this).prop("checked"));
	});
		 
		  $('#wstart_time').timepicker();
	    $('#wend_time').timepicker();
	    $('#sastart_time').timepicker();
	    $('#saend_time').timepicker();
	    $('#sunstart_time').timepicker();
	    $('#sunend_time').timepicker();
		 $(".property_ids").select2({ width: '100%' });
    });
    </script>
	<style>
	.form-control.ui-timepicker-input {
    width: 90px;
}
	</style>
@stop