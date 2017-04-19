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

                            Display Homes - <?php echo $builder_arr['company_name']; ?>
						
                        </div>
						
						<?php // echo Route::getCurrentRoute()->getActionName(); 
						
						 $currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						 $controller = preg_replace('/.*\\\/', '', $controller);
						 $method = preg_replace('/.*\\\/', '', $method);
						 if($controller == 'PropertyController' && $method == 'edit_display_home') {
						
						?>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php 
					 /*   echo '<pre>';
						print_r($prop_display_home_arr);   */
						//die; 
						if(!empty($prop_display_home_arr[0])) {
						$display_home = $prop_display_home_arr[0];
						}
						?>
                                  		  
									 <form method="post" action="<?php echo url(); ?>/admin/property/display-home/update/<?php echo $prop_id; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
									 <input type="hidden" name="builder_id" value="<?php echo $builder_id; ?>" />
									 	<div class="form-group">
                                            <label>Select Properties</label>
                                           <select class="property_ids" name="property_ids">
										   <?php  
											foreach($prop_arr as $prop_val) {
											if($prop_val['id'] == $display_home['property_id']) {
										   ?>
										   <option value="<?php echo $prop_val['id']; ?>" selected><?php echo $prop_val['property_title']; ?></option>
										   <?php } else { ?>  <option value="<?php echo $prop_val['id']; ?>"><?php echo $prop_val['property_title']; ?></option>  <?php } } ?>
										  </select>
                                        </div>
										 <div class="form-group">
                                            <label>Display Village Title</label>
                                           <input placeholder="Enter Display Village Title" class="form-control" value="<?php if(!empty($display_home['display_village_title'])) { echo $display_home['display_village_title'] ; }  ?>" name="display_village_title" type="text">
                                        </div>
                                        <div class="form-group">
                                             <label>Display Location</label>
                                             <textarea rows="3" class="form-control" id="desc" name="display_location"><?php if(!empty($display_home['display_location'])) { echo $display_home['display_location'] ; }  ?></textarea>
                                        </div>
										<div class="form-group">
                                         <label>Open Hours</label>
                                            <div class="checkbox">
                                            <label><input type="hidden" name="weekdays" value="weekday"/>WeekDays</label>
                                            <label class="radio-inline">
                                                <input type="text" name="wstart_time"  value="<?php if(!empty($display_home['open_hours'][0]['start_time'])) { echo $display_home['open_hours'][0]['start_time'] ; }  ?>" class="form-control" id="wstart_time">Start Time
                                            </label>
                                            <label class="radio-inline">
                                                <input type="text" name="wend_time"  value="<?php if(!empty($display_home['open_hours'][0]['end_time'])) { echo $display_home['open_hours'][0]['end_time'] ; }  ?>" class="form-control" id="wend_time">End Time
                                            </label>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <!--<label>Checkboxes</label>-->
                                            <div class="checkbox">
                                            <label><input type="hidden" name="saturday" value="saturday"/>Saturdays</label>
                                            <label class="radio-inline">
                                                <input type="text" name="sastart_time"  value="<?php if(!empty($display_home['open_hours'][1]['start_time'])) { echo $display_home['open_hours'][1]['start_time'] ; }  ?>" class="form-control" id="sastart_time">Start Time
                                            </label>
                                            <label class="radio-inline">
                                                <input type="text" name="saend_time"  value="<?php if(!empty($display_home['open_hours'][1]['end_time'])) { echo $display_home['open_hours'][1]['end_time'] ; }  ?>" class="form-control" id="saend_time">End Time
                                            </label>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <!--<label>Checkboxes</label>-->
                                            <div class="checkbox">
                                            <label><input type="hidden" name="sunday" value="sunday"/>Sundays</label>
                                            <label class="radio-inline">
                                                <input type="text" name="sunstart_time"  value="<?php if(!empty($display_home['open_hours'][2]['start_time'])) { echo $display_home['open_hours'][2]['start_time'] ; }  ?>" class="form-control" id="sunstart_time">Start Time
                                            </label>
                                            <label class="radio-inline">
                                                <input type="text" name="sunend_time"  value="<?php if(!empty($display_home['open_hours'][2]['end_time'])) { echo $display_home['open_hours'][2]['end_time'] ; }  ?>" class="form-control" id="sunend_time">End Time
                                            </label>
                                            </div>
                                        </div>
                                        <button class="btn btn-default" type="submit">Save</button>
                                    </form>
                          
                            
                        </div>
						<?php } else if($controller == 'PropertyController' && $method == 'create_display_home'){ ?>
							  <div class="panel-body">
										  
									 <form method="post" action="<?php echo url(); ?>/admin/property/display-home/add/<?php echo $builder_id; ?>" enctype="multipart/form-data">
									 <input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
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
										 <div class="form-group">
                                            <label>Display Village Title</label>
                                           <input placeholder="Enter Display Village Title" class="form-control" value="<?php if(!empty(Input::old('display_village_title'))) { echo Input::old('display_village_title') ; }  ?>" name="display_village_title" type="text">
                                        </div>
                                        <div class="form-group">
                                             <label>Display Location</label>
                                             <textarea rows="3" class="form-control" id="desc" name="display_location"><?php if(!empty(Input::old('display_location'))) { echo Input::old('display_location') ; }  ?></textarea>
                                        </div>
										<div class="form-group">
                                         <label>Open Hours</label>
                                            <div class="checkbox">
                                            <label><input type="hidden" name="weekdays" value="weekday"/>WeekDays</label>
                                            <label class="radio-inline">
                                                <input type="text" name="wstart_time"  value="<?php if(!empty(Input::old('wstart_time'))) { echo Input::old('wstart_time') ; }  ?>" class="form-control" id="wstart_time">Start Time
                                            </label>
                                            <label class="radio-inline">
                                                <input type="text" name="wend_time"  value="<?php if(!empty(Input::old('wend_time'))) { echo Input::old('wend_time') ; }  ?>" class="form-control" id="wend_time">End Time
                                            </label>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <!--<label>Checkboxes</label>-->
                                            <div class="checkbox">
                                            <label><input type="hidden" name="saturday" value="saturday"/>Saturdays</label>
                                            <label class="radio-inline">
                                                <input type="text" name="sastart_time"  value="<?php if(!empty(Input::old('sastart_time'))) { echo Input::old('sastart_time') ; }  ?>" class="form-control" id="sastart_time">Start Time
                                            </label>
                                            <label class="radio-inline">
                                                <input type="text" name="saend_time"  value="<?php if(!empty(Input::old('saend_time'))) { echo Input::old('saend_time') ; }  ?>" class="form-control" id="saend_time">End Time
                                            </label>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <!--<label>Checkboxes</label>-->
                                            <div class="checkbox">
                                            <label><input type="hidden" name="sunday" value="sunday"/>Sundays</label>
                                            <label class="radio-inline">
                                                <input type="text" name="sunstart_time"  value="<?php if(!empty(Input::old('sunstart_time'))) { echo Input::old('sunstart_time') ; }  ?>" class="form-control" id="sunstart_time">Start Time
                                            </label>
                                            <label class="radio-inline">
                                                <input type="text" name="sunend_time"  value="<?php if(!empty(Input::old('sunend_time'))) { echo Input::old('sunend_time') ; }  ?>" class="form-control" id="sunend_time">End Time
                                            </label>
                                            </div>
                                        </div>
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