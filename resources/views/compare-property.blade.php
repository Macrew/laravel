@extends('layout.default')

@section('content')	
 <!-----------new select 5 Jan 2016 ------------>
 <input type="hidden" name="compare_ids" value="<?php echo $_REQUEST['propertyids']; ?>" id="compare_ids"/>
 <?php 
 
 Session::set('compare_ids',$_REQUEST['propertyids']);
?>
<div class="bread_crum"><!--bread crum section!-->
	<ul>
    	<li><a href="<?php echo url(); ?>/property/search-property"><img src="{{ URL::asset('assets/images/search_h.png') }}" alt="Search" onMouseOver="this.src='{{ URL::asset('assets/images/search-ico.png') }}'" onMouseOut="this.src='{{ URL::asset('assets/images/search_h.png') }}" /></a></li>
        <li><a href="javascript:void(0);"><img src="{{ URL::asset('assets/images/compare-ico-h.png') }}" alt="" /></a></li>
        <li><a href="javascript:void(0);"><img src="{{ URL::asset('assets/images/enquire.png') }}" onMouseOver="this.src='{{ URL::asset('assets/images/enquire_h.png') }}'" onMouseOut="this.src='{{ URL::asset('assets/images/enquire.png') }}'" /></a></li>
    </ul>
</div><!--bread crum section!-->

<div class="comp_top"><!--top banner!-->
	<h2>Get your <span>Free Building Guide</span> when you Enquire</h2>
    <p>Our independent home building guide with expert tips to save you time and money</p>
    <a href="#" data-target='.bs-example-modal-lg' data-id = '<?php echo $_REQUEST['propertyids']; ?>' data-toggle='modal' class="open_enquirybox" >Enquire to all Builders</a>
</div><!--top banner!--> 
<!--==================================Compare body start here!================-->
<div class="comp_body">
	<div class="container_property">
    	<div class="top_property"><!--top compare property!-->
    	<?php  
			if(!empty($property_arr))
			{
				foreach($property_arr as $prop_val) {
		   ?>
		        	<div class="prop_box"><!--left box!-->
		            	<div class="property_img">
		                	<div class="prop_name">
		                    	<?php 
		                    	if (strlen($prop_val['property_title']) > 20) { echo substr($prop_val['property_title'],0,20).'...'; } else { echo $prop_val['property_title'];  }  ?><br />by <?php  if (strlen($prop_val['builder_detail']['company_name']) > 20) { echo substr($prop_val['builder_detail']['company_name'],0,20).'...'; } else { echo $prop_val['builder_detail']['company_name'];  }  ?>
		                    </div>
		                    <?php
							$rand_key = "";
							if(!empty($prop_val['property_gallery'])) {
							$rand_key = array_rand($prop_val['property_gallery'], 1); 
							$prop_image =  	$prop_val['property_gallery'][$rand_key]['image'];
							 
							 ?>
		                   	<img src="<?php echo url();  ?>/uploads/property_gallery/<?php echo $prop_image;  ?>" alt="">
						   	<?php } else { ?>
						    <img src="<?php echo url();  ?>/assets/img/no-image.jpg" alt="">
						   	<?php } ?>
		                </div>
		                <a href="javascript:void(0);" data-target='.bs-example-modal-lg' data-id = '<?php echo $prop_val['id'];   ?>' data-toggle='modal' class="enq_btn open_enquirybox">Enquire to Builders</a>
		                
		                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="prop_tb">
		                  <tr>
		                    <td width="50%" valign="middle">Build Location</td>
		                    <?php 
									if(!empty($prop_val)) {
										$user_id = $prop_val['user_id'];
									    $location_arr =   App\UserLocation::get_build_location($user_id) ; 
									if(!empty($location_arr)) {
									$locations = implode(',',$location_arr);
									} else {
										$locations = "";
									}
							?>
		                    <td width="50%" valign="middle">
		                    	<?php if (strlen($locations) > 20) {  ?><div class='readMore'  id="read_more_<?php echo $prop_val['id']; ?>" rel="<?php echo $prop_val['id']; ?>"><?php echo substr($locations,0,20).'...'; ?></div>
								<div class='readLess' id="read_less_<?php echo $prop_val['id']; ?>" rel="<?php echo $prop_val['id']; ?>" style='display:none;'><?php echo $locations; ?></div>
			                    <a class="read-more" rel="<?php echo $prop_val['id']; ?>" href="javascript:void(0);">+ Read More</a><?php } else {  echo $locations; } ?></td>
			                    <?php }  else { ?>  <td class="empty-td">&nbsp;</td>  <?php  } ?>
		                  </tr>
		                  <tr>
		                    <td>Bedrooms</td>
		                    <td><?php echo $prop_val['bedrooms']; ?></td>
		                  </tr>
		                  <tr>
		                    <td>Bathrooms</td>
		                    <td><?php echo $prop_val['bathrooms']; ?></td>
		                  </tr>
		                  <tr>
		                    <td>Living</td>
		                    <td><?php echo $prop_val['living']; ?></td>
		                  </tr>
		                  <tr>
		                    <td>Cars</td>
		                    <td><?php echo $prop_val['cars']; ?></td>
		                  </tr>
		                  <tr>
		                    <td>stories</td>
		                    <td><?php echo $prop_val['stories']; ?></td>
		                  </tr>
		                  <tr>
		                    <td>Alfresco</td>
		                    <td><?php echo $prop_val['alfresco']; ?></td>
		                  </tr>
		                  <tr>
		                    <td>Dual Occ</td>
		                    <td><?php echo $prop_val['dual_occ']; ?></td>
		                  </tr>
		                  <tr>
		                    <td>Min. Block width (m)</td>
		                    <td><?php echo $prop_val['min_block_width']; ?></td>
		                  </tr>
		                  <tr>
		                    <td>Min. Block length (m)</td>
		                    <td><?php echo $prop_val['min_block_length']; ?></td>
		                  </tr>
		                  <tr>
		                    <td>House Size (sq)</td>
		                    <td><?php echo $prop_val['housesize']; ?></td>
		                  </tr>
		                  <tr>
		                    <td>Price</td>
		                    <td>From $<?php  echo number_format($prop_val['price'],2) ; ?>
                      			<i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="The price or price range shown here is indicative only and will vary depending on the final inclusions, location of the build, the house façade and other customisations selected."></i>
                      		</td>
		                  </tr>
		                  <tr>
		                    <td>Display home</td>
		                    <td>
		                    	<?php  
		                    	$display_count =  count($prop_val['property_display_homes']) ; 
								if($display_count > 0) {
								echo '<a href="'.url().'/properties/display-villages/'.$prop_val['id'].'">'.$display_count.' locations</a>';
								} else {
									echo $display_count.' locations';	
								}
								?>
							</td>
		                  </tr>
		                  <tr>
		                    <td>Floor plans</td>
		                    <?php if(!empty($prop_val['property_floor_plans'][0])) { ?>
		                     <td><a href="javascript:void(0);" target="_blank" data-toggle="modal" href="javascript:void(0);" data-id="<?php echo $prop_val['id']; ?>" data-target=".floorplan_detail" value="Enquire to Builders" class="open_floorplan"><img src="<?php echo url();  ?>/uploads/property_floor/<?php echo $prop_val['property_floor_plans'][0]['image']; ?>" alt="home plan" style="height:100px;" ></a></td>
		                    <?php } else { ?>  <td>No Floor Plan </td>  <?php } ?>
		                  </tr>
		                  <tr>
		                    <td>Fixed Site Works</td>
		                    <td>
			                    <?php 
									if(!empty($prop_val['fixed_site_works'])) {
									echo $prop_val['fixed_site_works'];
									} else {
										echo 'No';	
									}
								?> 
							</td>
		                  </tr>
		                </table>
						<a href="javascript:void(0);" class="enq_btn open_enquirybox"  data-target='.bs-example-modal-lg' data-id = '<?php echo $prop_val['id'];   ?>' data-toggle='modal'>Enquire to Builders</a>
		            </div><!--left box!-->
           <?php }
           } ?>
            
            
            <div class="clr"></div>
        </div><!--top compare property!-->        
    </div>
    <div class="inc_prop">
    	
        <div class='container'>
    
    	<div class="common_scroll" id="compare_ajax_inclusion">
		<div id="ajax_compared_inc" class="ajax_scroll">
		<?php  if(!empty($saveincarrs)) { ?>
		<div class="inclusion-table" >
		<h1><span>Your</span> inclusions for comparison</h1>
		<table cellpadding="0" cellspacing="0" class="compare_inclusion">
		<?php
		
		foreach($saveincarrs as $saveinc_val) {  
			$saveprop_arr = array();
			if(!empty($_REQUEST['propertyids'])) {
				$compare_ids = $_REQUEST['propertyids'];
				//	$savepropids = SaveProperty::where(array('user_ip'=>$user_ip))->get(array('property_id'));
				//$saveprop_arr = $savepropids->toArray();
				$saveprop_arr = explode(',',$compare_ids);
				if(count($saveprop_arr) == '1') {
					$saveprop_arr = array_merge($saveprop_arr,array('2'=>'','3'=>'','4'=>''));
				}
				if(count($saveprop_arr) == '2') {
					$saveprop_arr = array_merge($saveprop_arr,array('3'=>'','4'=>''));
				}
				if(count($saveprop_arr) == '3') {
					$saveprop_arr = array_merge($saveprop_arr,array('4'=>''));
				}
			}
		}
		?>

		<tr>
			<th></th>
			<?php	
			foreach($saveprop_arr as $save_prop) {
				if(!empty($save_prop)) {
					$arr_property =  DB::table('property')->where(array('id'=>$save_prop))->get();
					if (strlen($arr_property[0]->property_title) > 20) { echo '<th>'.substr($arr_property[0]->property_title,0,20).'...</th>'; } else { echo "<th>".$arr_property[0]->property_title."</th>";  }
				}
			}
			?>
			
		</tr>
		<tr>
		<?php
		foreach($saveincarrs as $saveinc_val) {  
			?>
			<td><div class="cp-left tree_cp"><input type="checkbox" data-text-<?php echo $saveinc_val['id'] ; ?>="checked" checked="checked" rel="<?php echo $saveinc_val['id'] ; ?>" value="<?php echo $saveinc_val['id'] ; ?>"  name="compare_inc" class="compare_inc" id="saved_inc_<?php echo $saveinc_val['id'] ; ?>"  ><label for="saved_inc_<?php echo $saveinc_val['id'] ; ?>"></label></div> <?php echo $saveinc_val['title'] ; ?></td>
			<?php
			if(!empty($_REQUEST['propertyids'])) {
				foreach($saveprop_arr as $save_prop) {
					if(!empty($save_prop)) {
						$arr =  DB::table('property_inclusion')
						->where(array('property_id'=>$save_prop,'inclusion_id'=>$saveinc_val['id']))
						->get();
						if(!empty($arr)){
							$inc_type = 	$arr[0]->inclusion_type;
							$inclusion_type = array('Not available'=>'1','Standard inclusion'=>'2','Available as upgrade'=>'3');
							if(in_array($inc_type,$inclusion_type)) {
								//$inc_key = key($inclusion_type);
								//$inc_key = array_search($inc_type, $inclusion_type); // $key =
								if($inc_type == '1')
								$inc_key = '<i class="fa fa-minus" data-toggle="tooltip" data-placement="top" title="Not available"></i>';
								if($inc_type == '2')
								$inc_key = '<i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Standard inclusion"></i>';
								if($inc_type == '3')
								$inc_key = '<img src="'.url().'/assets/img/dollar.png" data-toggle="tooltip" data-placement="top" title="Available as upgrade" />';

								echo '<td>'.$inc_key.'</td>';
							}
						} 
						else {
							echo '<td><i class="fa fa-minus" data-toggle="tooltip" data-placement="top" title="Not available"></i></td>';
						}
					} else { echo '<td class="empty-td">&nbsp;</td>'; } 
				}
		echo '</tr>';
		}  }

		?>

		</table>
		</div>
		<?php } ?>
		</div>
		</div>
		<div class="common_scroll" id="compare_all_inclusion">
		<div class="more-inclusion">
		<div class="mi-right">
		<ul>
		<li><i class="fa fa-check"></i> Standard inclusion</li>
		<li><img src="{{ URL::asset('assets/img/dollar.png') }}"> Available as upgrade</li>
		<li>- Not available</li>
		</ul>
		</div>
		<div class="mi-left">
		<h1><span>Add more</span> inclusions for comparison</h1>
		<p>Choose which inclusions you’d like to include in your comparison from the list below.</p>
		<div class="compare_tab">
		<table class="collaptable">
		<?php  


		if(!empty($_REQUEST['propertyids']))
		{ 
		$propids = explode(',',$_REQUEST['propertyids']);
		$inclusion_tree =   App\Inclusion::inclusion_tree(0,$propids) ;
		echo $inclusion_tree;
		}



		?>
		</table>
		</div>	
		</div>





		<div class="clr"></div>
		</div>
    
    </div>
</div>
        
    </div>
</div>



<!--==================================Compare body End here!================-->
<div class="featured partners-wrap">
<div class="container">
    <h2><span>I</span><span>our</span> Buildings partners</h2>
    <a href="<?php echo url(); ?>/ourbuilders" class="view-btn">View all Designs</a>
</div>
<div class="partners">
    <div class="container builder-carasouel">
	<?php 	if(count($builderdetail) > 0) { 
						foreach($builderdetail as $val){
				?>
				
				<div class="partners-box"><a href='<?php echo url() ?>/builder-detail/<?php echo $val->builder_id; ?>'><img src="<?php echo url(); ?>/uploads/builder_logo/<?php echo $val->logo; ?>"></a></div>
           <?php 		}
					} else{ echo "<li><em>Sorry, no featured builder found at this location.</em></li>"; }
			?>
            
            
            <div class="clr"></div>
    </div>
</div>
</div>

 @include('common-modal')

  <style>
  #loading-indicator img {left: 50%;position: absolute;top: 50%;transform: translateX(-50%) translateY(-50%);z-index: 99999;}
  #loading-indicator::after {background: rgba(0, 0, 0, 0.898) none repeat scroll 0 0;content: "";height: 100%;left: 0;position: absolute;right: 0;top: 0;width: 1500px;z-index: 9999;}
  </style>
  <div id='loading-indicator' style=" display: none;">
    <img src="{{ URL::asset('assets/img/loading-x.gif') }}" alt="search">
</div>
  <script>
$('.read-more').click(function(){
var rel = $(this).attr('rel');
	if($(this).text() =='+ Read More'){
		$('#read_more_'+rel).hide();
		$('#read_less_'+rel).show();
		$(this).text('- Read Less');
	}else{
		$('#read_more_'+rel).show();
		$('#read_less_'+rel).hide();
		$(this).text('+ Read More');
	}
});

</script> 
@stop
