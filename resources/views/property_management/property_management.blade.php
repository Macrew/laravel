@extends('layout.default')

@section('content')
<?php $sort = 'ASC'; if(isset($_GET['sort'])){ if($_GET['sort'] == 'ASC'){ $sort = 'DESC'; }else{ $sort = 'ASC'; } } ?>
<section class="main_con">
       <div class="container property_manag">
           <div class="sub-heading"><h1>Property Management</h1></div>
			<div class='dataTable_wrapper'>
				<div class="addproperty-heading">
					<div style='float:left;'>
						 {!! Form::open(array('class' => 'form','method'=>'get','enctype'=>"multipart/form-data",'id'=>'myform')) !!}
							{!! Form::text('search', null, array('placeholder' => 'Search.', 'class'=>'form-control')) !!}
						 {!! Form::close() !!}
					</div>
					<input type="button" class="btn btn-primary" onclick="window.location.href='{{ url('propertymanagement/addproperty') }}'" value="Add Property">
				</div>
				<table class="campaign table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0" id="properties">
					<thead>
						<tr>
							<th><a href='?order=property_title&sort=<?php echo $sort; ?>' style='color:#fff;'>Property Name</a></th>
							<th><a href='?order=price&sort=<?php echo $sort; ?>' style='color:#fff;'>Price</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if (count($property)>0){
						foreach($property as $val){ 
						 ?>
						 <tr>
							 <td><?php echo $val->property_title; ?></td>
							 <td><?php echo '$'.$val->price; ?></td>
							 <td><a href="<?php echo url(); ?>/propertymanagement/viewproperty/<?php echo $val->id; ?>"><img src="{{ URL::asset('assets/img/view_prop.png') }}" alt="edit"></a><a href="<?php echo url(); ?>/propertymanagement/editproperty/<?php echo $val->id; ?>"><img src="{{ URL::asset('assets/img/edit-green.png') }}" alt="close"></a><a href='<?php echo url(); ?>/propertymanagement/delete_property/<?php echo $val->id; ?>' onclick="return confirm(' you want to delete?');"><img src="{{ URL::asset('assets/img/close-red.png') }}" alt="close"></a></td>
						 </tr>
					   <?php }
					   }else{
							echo '<tr><td>No property found. Please add properties.</td></tr>';
					   } ?>
					 </tbody>
			   </table>
			    <div class='paginate_property'>
					{!! $property->appends(array('sort' => Request::query('sort'), 'property_title'=>Request::query('property_title'), 'search'=>Request::query('search')))->render() !!}
				</div>
			</div>
           
       </div>
</section>
<script>
	/* $(document).ready(function() {
        $('#properties').DataTable({
                responsive: true,
                "language": {
					"lengthMenu": "_MENU_ records per page",
				}
        });
    });*/
$('div.alert').delay(5000).slideUp(300);
</script>
@stop
