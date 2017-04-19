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
				  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <style>
  #sortable { list-style-type: none; margin: 0; padding: 0;  }
  #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 150px; height: 125px; font-size: 1em; text-align: center; }
  </style>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Sort House and Land
						
                        </div>
						

	
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                                <ul id="sortable">
								<?php if(!empty($properties_arr)) { foreach($properties_arr as $prop_val) { ?>
								  <li class="ui-state-default" id="item-<?php echo $prop_val['id'];  ?>"><?php echo $prop_val['property_title'] ; ?><br/><br/><b><?php echo $prop_val['builder_detail']['company_name']; ?></b></li>
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
	    <script>

    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
		 $(".builder_location").select2({ width: '100%' });
    });
    </script>
@stop