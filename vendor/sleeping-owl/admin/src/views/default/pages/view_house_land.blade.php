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
	
	<?php 
	
		/* echo '<pre>';
		print_r($prop_arr[0]['property_inclusions']);  */
	$general_arr = $prop_arr[0];
	
	?>
	<div class="row">
	<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            House and Land
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#general">General</a>
                                </li>
                                <li><a data-toggle="tab" href="#inclusion">Inclusions</a>
                                </li>
                                <li><a data-toggle="tab" href="#gallery">Gallery</a></li>
								  <li><a data-toggle="tab" href="#floor-plans">Floor Plans</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="general" class="tab-pane fade in active">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                                   
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
										<tr class="info">
                                            <td>Land Size</td>
											<td><?php if(!empty($general_arr)){ echo $general_arr['land_size'] ;  }   ?></td>
										</tr>
										<tr class="success">
                                            <td>Address</td>
											<td><?php if(!empty($general_arr)){ echo $general_arr['house_land_address'] ;  }   ?></td>
										</tr>
                                    </tbody>
                                </table>
                            
                        </div>
						
                                </div>
                                <div id="inclusion" class="tab-pane fade">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
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

                                <div id="floor-plans" class="tab-pane fade">
                                    	  <div class="panel-body">
										  
										  <?php 
										  
										 /*  echo '<pre>';
										  print_r($general_arr['property_floor_plans']); */
										  
										  

										  ?>
								<div class="row">
								
							<?php if(!empty($general_arr['property_floor_plans'])) {	foreach($general_arr['property_floor_plans'] as $floor_val) { ?>
								<img src="<?php echo url(); ?>/uploads/property_floor/<?php echo $floor_val['image'];  ?>"  style="width:200px;height:200px;"/></td>   
								<?php  } } else { echo 'No Image Found.'; } ?>
								</div>

				
                                        <!--<button class="btn btn-default" type="submit" id="display:none;">Save</button>-->
                                    
                          
                            
									</div>
                                </div>
								
								    <div id="gallery" class="tab-pane fade">
                                    	  <div class="panel-body">
								<div class="row">
							<?php  if(!empty($general_arr['property_gallery'])) {	foreach($general_arr['property_gallery'] as $gall_val) { ?>
								<a href="<?php echo url(); ?>/uploads/property_gallery/<?php echo $gall_val['image'];  ?>" target="_blank" ><img src="<?php echo url(); ?>/uploads/property_gallery/<?php echo $gall_val['image'];  ?>"  style="width:200px;height:200px;"/></a></td>   
								<?php  } } else { echo 'No Image Found.' ; }   ?>
								</div>

				
                                        <!--<button class="btn btn-default" type="submit" id="display:none;">Save</button>-->
                                    
                          
                            
									</div>
                                </div>
								
								
								
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
			</div>
				
           
		</div>
	</div>

@stop