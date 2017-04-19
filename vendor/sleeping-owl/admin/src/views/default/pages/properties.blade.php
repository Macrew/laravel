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

			<?php if(Session::has('delete_message')) { ?>
    <div class="alert alert-success">
        <?php  echo Session::get('delete_message') ; ?>
    </div>
	<?php } ?>				
				
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <?php echo $title; ?>
						   <input type="button"  value="Sort Featured Properties" onclick="window.location.href='<?php echo url(); ?>/admin/property/sort_featured'"class="btn btn-primary padd_button">
							<input type="button"  value="Add Property" onclick="window.location.href='<?php echo url(); ?>/admin/property/create'"class="btn btn-primary padd_button">
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<div class="row" style="margin:10px;">
						<p style="font-size: 15px;font-weight: bold;">Total Properties <?php echo $numrows; ?></p>
						 <form class="form-inline" role="form">
						<div class="form-group">
						<label for="SelectRegion">Select Region:</label>
						<select  name="main_regionchange" class="form-control" id="">
						<option value="select-region">Select Region</option>
						<option value="VIC" <?php if(!empty($_REQUEST['main_regionchange'])) { if($_REQUEST['main_regionchange'] == 'VIC') { echo "selected=selected" ; } } ?>>VIC</option>
						<option value="QLD" <?php if(!empty($_REQUEST['main_regionchange'])) { if($_REQUEST['main_regionchange'] == 'QLD') { echo "selected=selected" ; } } ?>>QLD</option>
						<option value="NSW" <?php if(!empty($_REQUEST['main_regionchange'])) { if($_REQUEST['main_regionchange'] == 'NSW') { echo "selected=selected" ; } } ?>>NSW</option>
						<option value="WA" <?php if(!empty($_REQUEST['main_regionchange'])) { if($_REQUEST['main_regionchange'] == 'WA') { echo "selected=selected" ; } } ?>>WA</option>
                       </select>
						</div>
						<div class="form-group">
                          <label>Search by keyword</label>
                           <input placeholder="Enter keyword" class="form-control" value="<?php if(!empty($_REQUEST['keyword'])) { echo $_REQUEST['keyword'] ; } ?>" name="keyword" type="text">
                        </div>
					<button type="submit" class="btn btn-default">Search</button>
					</form>
					</div>
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Property Name</th>
											<th>Builder</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
				
				/* echo '<pre>';
				print_r($properties_arr);
				die;  */
				if(!empty($properties_arr)) {
				
				foreach($properties_arr as $properties_val) {

				?>
				
										<tr>
                                            <td><?php echo $properties_val['property_title']; ?></td>
                                            <td><?php echo $properties_val['builder_detail']['company_name']; ?></td>
                                            <td><?php  echo "$".number_format($properties_val['price'], 2);?></td>
                                            <td>
                                           		<input type="hidden" class="url_val" value="<?php echo  url(); ?>/admin/properties/<?php echo $properties_val['id']; ?>" />
												<?php // if($properties_val['status'] == 1){ ?>				
												<div //class="toggle toggle-success"></div>
												<?php //} if($properties_val['status'] == 0){ ?>
												<div //class="toggle-chat1 toggle-success"></div>
												<?php //} ?>
												<button class="btn btn-primary btn-mini" <?php if($properties_val['status'] == "1"){  ?> onclick="window.location.href='<?php echo url(); ?>/admin/properties/<?php echo $properties_val['id']; ?>/activate/0'" <?php } else { ?> onclick="window.location.href='<?php echo url(); ?>/admin/properties/<?php echo $properties_val['id']; ?>/activate/1'" <?php } ?> > <?php if($properties_val['status'] == "1"){  ?>On<?php }else{ ?>Off<?php } ?></button>
											</td>
                                            <td>
												<button class="btn btn-info" type="button" onclick="window.location.href='<?php echo url(); ?>/admin/property/view/<?php echo $properties_val['id']; ?>'">View Detail</button>
												<button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/property/edit/<?php echo $properties_val['id']; ?>'">Edit</button> 
												<button class="btn btn-danger btn-mini" onclick="javascript:delete_property(<?php echo $properties_val['id'] ;  ?>)" >Delete</button>
												<button class="btn btn-primary btn-mini" onclick="window.location.href='<?php echo url(); ?>/admin/property/featured/<?php echo $properties_val['id']; ?>'" ><?php if($properties_val['featured'] == "Yes"){  ?><i class="fa fa-star" style='color:#FFD700;'></i> <?php }else{ ?><i class="fa fa-star" ></i><?php } ?></button>
											</td>                                            
                                        </tr>
                                       
						<?php } } else { ?>
						<tr><td colspan="5" style="text-align:center;">No Property Found.</td></tr>
						<?php } ?>
                                       
                                    </tbody>
                                </table>
                            </div>
							<ul class="pagination">
		<?php 


$ptemp = url().'/admin/properties?';
		 $pages = '';

//echo $_REQUEST['po_no'];
	if(!empty($_REQUEST['search_region'])) $whereArr1[] = 'search_region='.$_REQUEST['search_region'];
	if(!empty($_REQUEST['property_type'])) $whereArr1[] = 'property_type='.$_REQUEST['property_type'];
	if(!empty($_REQUEST['bedrooms'])) $whereArr1[] = 'bedrooms='.$_REQUEST['bedrooms'];
	if(!empty($_REQUEST['bathrooms'])) $whereArr1[] = 'bathrooms='.$_REQUEST['bathrooms'];
	if(!empty($_REQUEST['builder'])) $whereArr1[] = 'builder='.$_REQUEST['builder'];
	if(!empty($_REQUEST['min_price'])) $whereArr1[] = 'min_price='.$_REQUEST['min_price'];
	if(!empty($_REQUEST['max_price'])) $whereArr1[] = 'max_price='.$_REQUEST['max_price'];
	if(!empty($_REQUEST['main_regionchange'])) $whereArr1[] = 'main_regionchange='.$_REQUEST['main_regionchange'];
	if(!empty($whereArr1)) {
		$whereStr1 = implode("&", $whereArr1);
		}
	if(!empty($whereStr1))
	{
		$whereStr1 = '&'.$whereStr1;
	} else {
		$whereStr1="";
	
	}
//echo $whereStr;
	if ($currentpage != 1) 
{ //GOING BACK FROM PAGE 1 SHOULD NOT BET ALLOWED
 $previous_page = $currentpage - 1;
 //$previous = '<a href="'.$ptemp.'?pageno='.$previous_page.'"> </a> '; 
$previous = '&lt;Previous' ;
 $pages .= '<li><a href="'.$ptemp.'page='.$previous_page.$whereStr1.'">'. $previous .'</a></li>'; 
}    
$adjacents = 2;
/* $a=1;
foreach($properties_arr as $prop_values) 
{
  if ($a == $currentpage) 
  $pages .= '<li><a href="#" class="active">'. $a .'</a></li>';
  else 
 $pages .= '<li><a href="'.$ptemp.'page='.$a.$whereStr1.'">'. $a .'</a></li>';
 $a++;
} */

  $pmin = ($currentpage > $adjacents) ? ($currentpage - $adjacents) : 1;
    $pmax = ($currentpage < ($lastpage - $adjacents)) ? ($currentpage + $adjacents) : $lastpage;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $currentpage) {
            $pages.= "<li  class=\"active\"><a href='#'>" . $i . "</a></li>\n";
        } elseif ($i == 1) {
            $pages.= "<li><a  href=\"" . $ptemp ."page=".$i.$whereStr1. "\"  rel=".$i.">" . $i . "</a>\n</li>";
        } else {
            $pages.= "<li><a  href=\"" . $ptemp . "page=" . $i .$whereStr1. "\"  rel=".$i." >" . $i . "</a>\n</li>";
        }
    }
    

//$pages = substr($pages,0,-1); //REMOVING THE LAST COMMA (,)

if($currentpage != $lastpage) 
{

 //GOING AHEAD OF LAST PAGE SHOULD NOT BE ALLOWED
 $next_page = $currentpage + 1;
 $next = 'Next&gt;';
 $pages .= '<li><a href="'.$ptemp.'page='.$next_page.$whereStr1.'">'. $next .'</a></li>';

}

if(!empty($numrows)) {
echo   $pages ; //PAGINATION LINKS
}

		?>
	</ul>	
							
							
                            <!-- /.table-responsive -->
                            
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
		<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Change order</h4>
	      </div>
	      <div class="modal-body">
	       <form action="" enctype="multipart/form-data" method ='POST'>
	       		<div class="form-col" style='margin:0 29% 70px;width:42%;'>
					<input type="number" required name="order" id='featured_id' placeholder="Change order" style=' padding: 4px;width: 100%;'>
					<input type="hidden" name="_token" value="<?php echo csrf_token() ; ?>">
					<input type='hidden' name='pid' id='property_id'>
					<input type="submit" class='btn btn-primary add_button' name="submit" value="Submit" style='float: left;margin: 3% 0 0 26%;width: 47%;'>
				</div>
                <div class="clr"></div>
                	
                </div>
	       </form>
	      </div>
	    </div>

	  </div>
	</div>
	    <script>
    $(document).ready(function() {
        $('#properties').DataTable({
                responsive: true,
                "order": [[ 3, "desc" ]]
        });
        
    });
	/* $(document).on("click", ".open-AddBookDialog", function () {
		var myBookId = $(this).data('id');
		$(".modal-body #property_id").val( myBookId );
		$(".modal-body #featured_id").val( $(this).data('rel') );
	}); */
	function delete_property(prop_id)
	{
		if(prop_id)
		{
			var status = confirm('Are you sure you want to delete Property.');
			if(status)
			{
				window.location.href='<?php echo url(); ?>/admin/property/delete/'+prop_id;
			}
		}
	}
	//$("[name='toggle-status']").bootstrapSwitch();
	/* jQuery('.toggle').toggles({on: true});
	jQuery("div.toggle-success").click(function(){
		var cls=jQuery(this).attr('class').split(' ');
		cls1=cls[0];
		var elem=jQuery(this).prev('.url_val').val();
		//alert(elem);return false;
		if(cls1 == 'toggle-chat1'){
			window.location.href=elem+"/activate/1";
		}
		if(cls1 == 'toggle'){
			window.location.href=elem+"/activate/0";
		}
	});
   
   jQuery('.toggle-chat1').toggles({on: false}); */
    </script>
@stop
