<div style="background-color: #efefef;padding: 10px;width: 500px;">
<p>Hi, <br/> <h2 style="color: #2fc9d4;"><?php echo $builder ; ?></h2> <br/>Below is the Appointment Detail of the user <br/>
<b>Appointment Date: <?php echo '  '.$appoint_detail['detail']['date'];  ?></b><br/>
<b>Appointment Time: <?php echo '  '.$appoint_detail['detail']['time'];  ?></b><br/>

</p>
<table style="width: 500px;">
<tr>
<td>First Name : </td><td><?php echo $appoint_detail['detail']['firstname']; ?></td>
</tr>
<tr>
<td>Last Name : </td><td><?php echo $appoint_detail['detail']['lastname']; ?></td>
</tr>
<tr>
<td>Phone No. :</td><td> <?php echo $appoint_detail['detail']['phn_no'];  ?></td>
</tr>
<tr>
<td>Email Address : </td><td><?php echo $appoint_detail['detail']['email']; ?></td>
</tr>
<tr>
<td>Walk in display village:</td><td><?php echo $display_homes['display_village_title']; ?></td>
</tr>
<tr>
<td>Walk in display location:</td><td><?php echo $display_homes['display_location']; ?></td>
</tr>
</table>
<p style="color: #2fc9d4;font-weight: bold;">Property Details For which User Want to appoint</p>
<table style="width: 500px;">
<?php  

$prop_arr = array();
$prop_arr[0] = $property_arr;
foreach($prop_arr as $prop_val) {
$basepath = url().'/uploads/property_gallery/'.$prop_val['property_gallery'][0]['image'] ;
?>

<tr><td colspan="2" style="width:30%"><span style="color: #2fc9d4;"><?php echo $prop_val['builder_detail']['company_name'] ; ?></span></td></tr><tr><td style="width:50%" ><?php if(!empty($prop_val['property_gallery'])) { ?><a href="<?php echo url() ; ?>/propertydetail/<?php echo $prop_val['id'];  ?>"><img src="<?php echo $message->embed($basepath); ?>" style="width:50%;height:50%"/></a><?php } ?></td><td style="width:50%"><h4><a href="<?php echo url() ; ?>/propertydetail/<?php echo $prop_val['id'];  ?>" style="color: #2fc9d4;text-decoration:none;"><?php echo $prop_val['property_title'] ; ?></a></h4><br/>From $<?php  echo number_format($prop_val['price'],2) ; ?></td></tr>
<?php  } ?>

</table>

<br/>Thanks & Regards,<br/>
iCompareBuilders
</div>