
@extends('layout.default')

@section('content')
<?php $general_arr = $prop_arr[0];	?>
<section class="main_con sub-main">
       <div class="container">
           <div class="sub-heading"><h1>Add Property</h1></div>
           <div class="addproperty-heading">
				<input type="button" class="btn btn-primary" onclick="window.location.href='{{ url('propertymanagement') }}'" value="Back to property management" style='border-radius:unset;padding:13px;'>
			</div>
           <div class="container1">
            <ul class="rtabs">
                <li class="tabies selected"><a rel="view1" href='javascript:void(0);'>General</a></li>
                <li class="tabies continew"><a rel="view2">Images & Floor Plans</a></li>
                <li class="tabies"><a rel="view3">Inclusions</a></li>
            </ul>
            
				<div class="panel-container">
						<div id="view1" class="active cls">
							 <table class="table">

								<tbody>
									<tr class="info">
										<td>Property Title</td>
										<td><?php if(!empty($general_arr)){ echo $general_arr['property_title'];   }   ?></td>
									</tr>
									<tr class="success">
										<td>Builder</td>
										<td><?php if(!empty($general_arr)){ echo $general_arr['builder_detail']['company_name'];   }   ?></td>
									</tr>
									<tr class="info">
										<td>Description</td>
										<td><?php if(!empty($general_arr)){ echo $general_arr['description'];   }   ?></td>
									</tr>
									<tr class="success">
										 <td>Price</td>
										 <td><?php if(!empty($general_arr)){ echo "$".number_format($general_arr['price'] , 2);   }   ?></td>
									</tr>
									<tr class="info">
										<td>Bedrooms</td>
										<td><?php if(!empty($general_arr)){ echo $general_arr['bedrooms'];   }   ?></td>
									</tr>
									<tr class="success">
										<td>Cars</td>
										<td><?php if(!empty($general_arr)){ echo $general_arr['cars'] ;  }   ?></td>
									</tr>
									<tr class="info">
										<td>Housesize</td>
										<td><?php if(!empty($general_arr)){ echo $general_arr['housesize'] ;  }   ?></td>
									</tr>
									<tr class="success">
										<td>Bathrooms</td>
										<td><?php if(!empty($general_arr)){ echo $general_arr['bathrooms'];   }   ?></td>
									</tr>
									<tr class="info">
										<td>Stories</td>
										<td><?php if(!empty($general_arr)){ echo $general_arr['stories'] ;  }   ?></td>
									</tr>
									<tr class="success">
										<td>Minimum block width</td>
										<td><?php if(!empty($general_arr)){ echo $general_arr['min_block_width'] ;  }   ?></td>
									</tr>
									<tr class="info">
										<td>Minimum block length</td>
										<td><?php if(!empty($general_arr)){ echo $general_arr['min_block_length'] ;  }   ?></td>
									</tr>
									<tr class="success">
										<td>Living</td>
										<td><?php if(!empty($general_arr)){ echo $general_arr['living'] ;  }   ?></td>
									</tr>
									<tr class="info">
										<td>Alfresco</td>
										<td><?php if(!empty($general_arr)){ echo $general_arr['alfresco'] ;  }   ?></td>
									</tr>
									<tr class="success">
										<td>Dual occ</td>
										<td><?php if(!empty($general_arr)){ echo $general_arr['dual_occ'] ;  }   ?></td>
									</tr>
									<tr class="info">
										<td>General Brochure</td>
										<td><?php if(!empty($general_arr)){ echo '<a href="'.url().'/uploads/brochure/'.$general_arr['brochure'].'" target="_blank">'.$general_arr['brochure'].'</a>' ;  }   ?></td>
									</tr>
									<tr class="success">
										<td>Promotional brochure</td>
										<td><?php if(!empty($general_arr)){ echo '<a href="'.url().'/uploads/brochure/'.$general_arr['promotional_brochure'].'" target="_blank">'.$general_arr['promotional_brochure'].'</a>' ;  }   ?></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div id="view2" class="cls">
							<div class="view2-box">
								<h3>Gallery Images</h3>
								<?php  if(!empty($general_arr['property_gallery'])) {	foreach($general_arr['property_gallery'] as $gall_val) { ?>
								<a class="fancybox" href="<?php echo url(); ?>/uploads/property_gallery/<?php echo $gall_val['image'];  ?>" data-fancybox-group="gallery"  ><img src="<?php echo url(); ?>/uploads/property_gallery/<?php echo $gall_val['image'];  ?>"  style="width:200px;height:200px;"/></a></td>   
								<?php  } } else { echo 'No Image Found.' ; }   ?>
								</div>
							<div class="view2-box">
								<h3>Floor Plan Images</h3>
							<?php if(!empty($general_arr['property_floor_plans'])) {	foreach($general_arr['property_floor_plans'] as $floor_val) { ?>
								<img src="<?php echo url(); ?>/uploads/property_floor/<?php echo $floor_val['image'];  ?>"  style="width:200px;height:200px;"/></td>   
								<?php  } } else { echo 'No Image Found.'; } ?>
							</div>
						</div>
					<div id="view3" class="cls">
						<div class="view3-inner">
							<?php $prop_inc    =  $general_arr['property_inclusions'];

							/* echo '<pre>';
							print_r($prop_inc); */
						  foreach($inc_arr as $inc_val) {
						?>
						<h4><?php echo $inc_val['title'];  ?></h4>
						
						 <table class="table">

                                    <tbody>
									 <?php $chk = true; $inclusion =  App\Inclusion::get_child_inclusions($inc_val['id']) ; 
									if(!empty($inclusion))  {
							foreach($inclusion as $inclusion_val) {
							if(!empty($prop_inc)) {
						foreach($prop_inc as $prop_val) {
						if($prop_val['inclusion_id'] == $inclusion_val['id']) {
							//$checked = true;
						 ?>
                                        <tr class="info">
                                            <td><?php echo $inclusion_val['title']; ?></td>
											<td><?php if($prop_val['inclusion_type'] == 1) { echo 'Not available';} else if($prop_val['inclusion_type'] == 2) { echo 'Standard inclusion'; } else if($prop_val['inclusion_type'] == 3) { echo 'Available as upgrade'; } ?></td>
										</tr>

								<?php  } } } else {  $chk = false; } } if($chk == false) { echo '<tr class="info"><td colspan="2">No Inclusion Found.</td></tr>' ;  } } else { echo '<tr class="info"><td colspan="2">No Inclusion Found.</td></tr>' ; }  ?>
                                    </tbody>
                                </table>
                               <?php }  ?>
						</div>
					</div>
				</div>
            <br>
        </div>
       </div>
</section>
<script>
	 $(document).ready(function() {
		 $(".inclusion_id").on('change',function(){
			var inc = $(this).val();
			var rel = $(this).attr('rel');
			if(inc != 'None')
			{
				$('.child-'+rel).slideDown();
			} else {
				$('.child-'+rel).slideUp();
			}
		 });
		$('ul.rtabs').find('li').click(function(){
			//alert($(this).find('a').attr('rel'));
			var rel = $(this).find('a').attr('rel');
			$('.tabies').removeClass('selected');
			$(this).addClass('selected');
			$('.panel-container').find('.cls').removeClass('active');
			$('.panel-container').find("#"+rel).addClass('active');
		});
		
		$('.next_addprop').click(function(){
			$('.continew').trigger("click");
		});
    });
    $('.fancybox').fancybox({  prevEffect : 'none', nextEffect : 'none',
});
$('div.alert').delay(5000).slideUp(300);
</script>
@stop
