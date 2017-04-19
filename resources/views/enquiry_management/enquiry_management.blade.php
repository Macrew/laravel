@extends('layout.default')

@section('content')
<?php $sort = 'ASC'; if(isset($_GET['sort'])){ if($_GET['sort'] == 'ASC'){ $sort = 'DESC'; }else{ $sort = 'ASC'; } } ?>
<section class="main_con">
       <div class="container property_manag">
           <div class="sub-heading"><h1>Enquiry Management</h1></div>
			<div class='dataTable_wrapper'>
				<table class="campaign table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0" id="properties">
					<thead>
						<tr>
							<th><a href='?order=property_title&sort=<?php echo $sort; ?>' style='color:#fff;'>Name</a></th>
							<th><a href='?order=price&sort=<?php echo $sort; ?>' style='color:#fff;'>Property Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						//echo '<pre>'; print_r($enquiry); echo '</pre>';die;
						if (count($enquiry)>0){
						foreach($enquiry as $val){
							$property = App\Property::getpropertybyid($val->property_id);
							//echo '<pre>'; print_r($property); echo '</pre>';
						 ?>
						 <tr>
							 <td><?php echo $val->first_name.' '.$val->last_name; ?></td>
							 <td><?php echo $property->property_title; ?></td>
							 <td>
							<!-- <a href="<?php //echo url(); ?>/propertymanagement/viewproperty/<?php //echo $val->id; ?>"><img src="{{ URL::asset('assets/img/view_prop.png') }}" alt="edit"></a>
							 <a href="<?php //echo url(); ?>/propertymanagement/editproperty/<?php //echo $val->id; ?>"><img src="{{ URL::asset('assets/img/edit-green.png') }}" alt="close"></a>-->
							 <a href='<?php echo url(); ?>/enquirymanagement/delete_enquery/<?php echo $val->id; ?>' onclick="return confirm(' you want to delete?');"><img src="{{ URL::asset('assets/img/close-red.png') }}" alt="close"></a></td>
						 </tr>
					   <?php }
					   }else{
							echo '<tr><td>No enquiry found.</td></tr>';
					   } ?>
					 </tbody>
			   </table>
			    <div class='paginate_property'>
					{!! $enquiry->appends(array('sort' => Request::query('sort'), 'property_title'=>Request::query('property_title'), 'search'=>Request::query('search')))->render() !!}
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
jQuery('div.alert').delay(5000).slideUp(300);
</script>
@stop
