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
                            Edit Testimonials
							<input type="button"  value="Back to Testimonials" onclick="window.location.href='<?php echo url(); ?>/admin/testimonials'"class="btn btn-primary add_button">
                        </div>
						<div class="panel-body">
							{!! Form::model($testimonials[0],array('class' => 'form','enctype'=>"multipart/form-data")) !!}
								<input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
								<div class="form-group">
									{!! Form::label('Created by') !!}
									{!! Form::text('created_by', null, array('required', 'class'=>'form-control', 'placeholder'=>'Created by')) !!}
								</div>
								<div class="form-group">
									{!! Form::label('Description') !!}
									{!! Form::textarea('description', null, array('required', 'id'=>"desc", 'class'=>'form-control', 'placeholder'=>'Created by')) !!}
									<script>
									// Replace the <textarea id="editor1"> with a CKEditor
									// instance, using default configuration.
									CKEDITOR.replace('desc');
									</script>
								</div>
								<div class="form-group">
									{!! Form::label('Enter state or company name') !!}
									{!! Form::text('state_company', null, array('required', 'class'=>'form-control', 'placeholder'=>'Company name or state name (comma separated)')) !!}
								</div>
											

								<button class="btn btn-default" type="submit">Save</button>
							{!! Form::close() !!}                 
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
		 $(".builder_location").select2({ width: '100%' });
    });
    </script>
@stop
