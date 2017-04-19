@extends('layout.default')

@section('content')
<?php $sort = 'ASC'; if(isset($_GET['sort'])){ if($_GET['sort'] == 'ASC'){ $sort = 'DESC'; }else{ $sort = 'ASC'; } }
//echo '<pre>'; print_r($adds); echo '</pre>';
 ?>
<section class="main_con">
       <div class="container property_manag">
           <div class="sub-heading"><h1>Ads Management</h1></div>
			<div class='dataTable_wrapper'>
				<div class="addproperty-heading">
					<div style='float:left;'>
						 {!! Form::open(array('class' => 'form','method'=>'get','enctype'=>"multipart/form-data",'id'=>'myform')) !!}
							{!! Form::text('search', null, array('placeholder' => 'Search.', 'class'=>'form-control')) !!}
						 {!! Form::close() !!}
					</div>
					<input type="button" class="btn btn-primary" onclick="window.location.href='{{ url('addmanagement/createadd') }}'" value="Create Ad">
				</div>
				<table class="campaign" cellpadding="0" cellspacing="0">
					 <tr>
						  <th><a href='?order=headline&sort=<?php echo $sort; ?>' style='color:#fff;'>Campaign</a></th>
						  <th><a href='?order=start_date&sort=<?php echo $sort; ?>' style='color:#fff;'>Start Date</a></th>
						  <th><a href='?order=end_date&sort=<?php echo $sort; ?>' style='color:#fff;'>End Date</a></th>
						  <!--<th>Ads</th>-->
						  <th>Action</th>
					 </tr>
					<?php 
					if(count($adds) > 0){
						foreach($adds as $val){
					?>
					 <tr>
						 <td><?php echo $val->headline; ?></td>
						 <td><?php echo date('j F, Y',strtotime($val->start_date)); ?></td>
						 <td><?php echo date('j F, Y',strtotime($val->end_date)); ?></td>
						 <!--<td>View Ads</td>-->
						 <td><a href="<?php echo url(); ?>/addmanagement/editadd/<?php echo $val->id; ?>"><img src="{{ URL::asset('assets/img/edit-green.png') }}" alt="edit"></a><a href='<?php echo url(); ?>/addmanagement/deleteadd/<?php echo $val->id; ?>' onclick="return confirm(' you want to delete?');"><img src="{{ URL::asset('assets/img/close-red.png') }}" alt="close"></a></td>
					 </tr>
				<?php 
						}
					}else{
						echo '<tr><td></td><td>Sorry, no ad found.</td><td></td><td></td></tr>';
					}
				?>
				</table>
			   <div class='paginate_property'>
					{!! $adds->appends(array('sort' => Request::query('sort'), 'headline'=>Request::query('headline'), 'search'=>Request::query('search')))->render() !!}
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
