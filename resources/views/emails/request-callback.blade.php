<?php 
$builder = $property_arr[0]['builder_detail']['company_name'];
?>
<div style="background-color: #efefef;padding: 10px;width: 500px;">
<p>Hi, <br/> <h2 style="color: #2fc9d4;"><?php echo $builder ; ?></h2> <br/>Below is the Request a callback of user <br/></p>
<table style="width: 500px;">
<tr>
<td>Name : </td><td><?php echo $user_inputs['name']; ?></td>
</tr>
<tr>
<td>Phone No. : </td><td><?php echo $user_inputs['phone_number']; ?></td>
</tr>
<tr>
<td>Email Address : </td><td><?php echo $user_inputs['email']; ?></td>
</tr>
<tr>
<td>Contact Time:</td><td><?php echo $user_inputs['contact_time']; ?></td>
</tr>
</table>
<?php if(!empty($property_arr[0]['property_gallery'][0]['image'])) { $basepath = url().'/uploads/property_gallery/'.$property_arr[0]['property_gallery'][0]['image']; } else { $basepath = url().'/assets/img/no-image.jpg';  }  ?>
<p style="color: #2fc9d4;font-weight: bold;">Property Details</p>
<table style="width: 500px;"><tr><td colspan="2" style="width:30%"><span style="color: #2fc9d4;"><?php echo $builder ; ?></span></td></tr><tr><td style="width:50%" ><a href="<?php echo url() ; ?>/propertydetail/<?php echo $property_arr[0]['id'];  ?>"><img src="<?php echo $message->embed($basepath); ?>" style="width:50%;height:50%"/></a></td><td style="width:50%"><h4><a href="<?php echo url() ; ?>/propertydetail/<?php echo $property_arr[0]['id'];  ?>" style="color: #2fc9d4;text-decoration:none;"><?php echo $property_arr[0]['property_title'] ; ?></a></h4><br/>From $<?php  echo number_format($property_arr[0]['price'],2) ; ?></td></tr></table>
<br/>Thanks & Regards,<br/>
iCompareBuilders
</div>