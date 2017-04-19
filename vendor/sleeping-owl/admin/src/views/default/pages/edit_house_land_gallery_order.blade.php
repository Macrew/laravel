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
				<div id="success"></div>
			</div>
			    <!-- /.row -->
			    <style>
  #sortable1 { list-style-type: none; margin: 0; padding: 0;  }
  #sortable1 li { margin: 3px 3px 3px 0; padding: 1px; float: left; font-size: 1em; text-align: center; }
  </style>
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
	
		<?php if(Session::has('delete_message')) { ?>
    <div class="alert alert-success">
        <?php  echo Session::get('delete_message') ; ?>
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
                            <?php 
							
						$currentAction = Route::currentRouteAction();
						list($controller, $method) = explode('@', $currentAction);
						$controller = preg_replace('/.*\\\/', '', $controller);
						$method = preg_replace('/.*\\\/', '', $method);
						//$property_arr = $prop_arr[0];
						//echo '<pre>';print_r($property_arr);echo '</pre>';die;
						echo 'Sort Gallery Images';
						?>
						<input type="button" style="margin-left: 700px;" value="Add More Images" onclick="window.location.href='<?php echo url(); ?>/admin/house-and-land/gallery/add_gallery_images/<?php echo $id; ?>'" class="btn btn-primary" style='float:right;'>							
                        </div>
						

						<?php 
						/*  echo '<pre>';
						print_r($builders_arr); 
						die; */
						
						?>
     
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul id="sortable1">
				<?php
				//$property_arr = $prop_arr[0];
				
				/*   echo '<pre>';
				print_r($propertyp_arr);
				die;   */
				if(!empty($prop_arr)) {
				
				foreach($prop_arr as $properties_val) {

				?>
					<li class="ui-state-default" id="item-<?php echo $properties_val['id']; ?>"><img src="<?php echo url(); ?>/uploads/property_gallery/<?php echo $properties_val['image'];  ?>"  style="width:200px;height:200px;"/> </li>                                       
						<?php } } ?>
                                       
                                    </ul>
                            
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
		<input type="hidden" name="base_url" id="base_url" value="<?php echo url(); ?>"/>

	 <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script type="text/javascript">
  $.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
});

$(document).ready(function () {
	
	if($( "#sortable1" ).length) {

		$( "#sortable1" ).sortable({

			update: function (event, ui) {
				var data = $(this).sortable('serialize');
				var baseUrl = $('#base_url').val();
				var url = baseUrl+'/admin/property/update_sort_gallery';

	       
				// POST to server using $.post or $.ajax
				$.ajax({
					data: data,
					type: 'POST',
					url: url,
					crossDomain:true, 
					success:function(data)
					{
						$('#success').html(data);
					}
				});
			}
		
		});
	}
});
    </script>

@stop