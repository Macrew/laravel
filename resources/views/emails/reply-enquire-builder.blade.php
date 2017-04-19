<div style="background-color: #efefef;padding: 10px;width: 500px;">
<p>Hey <h2 style="color: #2fc9d4;"><?php echo $user_inputs['first_name']; ?></h2> <br/>Thanks for using icomparebuilders.  <br/><br/>Here is a record of your enquiry.<br/>If you don't hear from your builder(s) within 2 business days please email us at info@icomparebuilders.com.au so that we can follow them up. </p>
<?php  if(!empty($property_arr)) {
 ?>
<p style="color: #2fc9d4;font-weight: bold;">Property Details</p>
<table style="width: 500px;">
<?php foreach($property_arr as $prop_val) {
if(!empty($property_arr[0]['property_gallery'][0]['image'])) { $basepath = url().'/uploads/property_gallery/'.$property_arr[0]['property_gallery'][0]['image']; } else { $basepath = url().'/assets/img/no-image.jpg';  } 
  ?>
<tr><td colspan="2" style="width:30%"><span style="color: #2fc9d4;"><?php echo $prop_val['builder_detail']['company_name'] ; ?></span></td></tr>
<tr><td style="width:50%" ><a href="<?php echo url() ; ?>/propertydetail/<?php echo $prop_val['id'];  ?>"><img src="<?php echo $message->embed($basepath); ?>" style="width:50%;height:50%"/></a></td><td style="width:50%"><h4><a href="<?php echo url() ; ?>/propertydetail/<?php echo $prop_val['id'];  ?>" style="color: #2fc9d4;text-decoration:none;"><?php echo $prop_val['property_title'] ; ?></a></h4><br/>From $<?php  echo number_format($prop_val['price'],2) ; ?></td></tr>
<?php } ?>
</table>
<?php  } ?>
<?php if(!empty($inc_arr)) { ?>
<p><span style="color: #2fc9d4;">Selected inclusions of interest:</span><br/>
<?php  foreach($inc_arr as $inc_val) {
	echo $inc_val['title'].'<br/>';
} ?>
</p>
<p><span style="color: #2fc9d4;">Message:</span><br/>
<?php if(!empty($user_inputs['message'])) { 
echo $user_inputs['message'] ; 
} else {
echo 'No message supplied'; 
}
?>
</p>
<?php }  ?>
<br/>Thanks & Regards,<br/>
iCompareBuilders
</div>