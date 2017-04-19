<?php 
$builder = $property_arr[0]['builder_detail']['company_name'];
?>
<div style="background-color: #efefef;padding: 10px;width: 500px;">
<p>Hi, <br/> <h2 style="color: #2fc9d4;"><?php echo $builder ; ?></h2> <br/>Below is the enquiry of user <br/></p>
<table style="width: 500px;">
<tr>
<td>First Name : </td><td><?php echo $user_inputs['first_name']; ?></td>
</tr>
<tr>
<td>Last Name : </td><td><?php echo $user_inputs['last_name']; ?></td>
</tr>
<tr>
<td>Phone No. :</td><td> <?php echo $user_inputs['phone']; ?></td>
</tr>
<tr>
<td>Email Address : </td><td><?php echo $user_inputs['email']; ?></td>
</tr>
<tr>
<td>Home Ownership Status:</td><td><?php echo $user_inputs['home_status']; ?></td>
</tr>
<tr>
<td>Own Land for building:</td><td><?php echo $user_inputs['own_land']; ?></td>
</tr>
<tr>
<td>Secured Finance:</td><td><?php echo $user_inputs['secured_finance']; ?></td>
</tr>
<?php 
if(!empty($user_inputs['secured_option1'])) { 
?>
<tr>
<td>Secured Finance Feedback:</td><td><?php echo $user_inputs['secured_option1']; ?></td>
</tr>
<?php } if(!empty($user_inputs['secured_option2'])) { ?>
<tr>
<td>Secured Finance Feedback:</td><td><?php echo $user_inputs['secured_option2']; ?></td>
</tr>
<tr>
<?php } if(!empty($user_inputs['secured_option3'])) { ?>
<td>Secured Finance Feedback:</td><td><?php echo $user_inputs['secured_option3']; ?></td>
</tr>
<?php } ?>
<tr>
<td>Contact Time:</td><td><?php echo $user_inputs['contact_time']; ?></td>
</tr>
<?php if(!empty($user_inputs['state'])) { ?>
<tr>
<td>User Location : </td><td><?php echo $user_inputs['state']; ?></td>
</tr>
<?php } ?>
<?php if(!empty($user_inputs['message'])) { ?>
<tr>
<td>User Message :  </td><td><?php echo $user_inputs['message']; ?></td>
</tr>
<?php } ?>
<?php if(!empty($user_inputs['language'])) { ?>
<tr>
<td>Language : </td><td><?php echo $user_inputs['language']; ?></td>
</tr>
<?php } ?>
</table>
<?php if(!empty($property_arr[0]['property_gallery'][0]['image'])) { $basepath = url().'/uploads/property_gallery/'.$property_arr[0]['property_gallery'][0]['image']; } else { $basepath = url().'/assets/img/no-image.jpg';  }  ?>
<p style="color: #2fc9d4;font-weight: bold;">Property Details</p>
<table style="width: 500px;"><tr><td colspan="2" style="width:30%"><span style="color: #2fc9d4;"><?php echo $builder ; ?></span></td></tr><tr><td style="width:50%" ><a href="<?php echo url() ; ?>/propertydetail/<?php echo $property_arr[0]['id'];  ?>"><img src="<?php echo $message->embed($basepath); ?>" style="width:50%;height:50%"/></a></td><td style="width:50%"><h4><a href="<?php echo url() ; ?>/propertydetail/<?php echo $property_arr[0]['id'];  ?>" style="color: #2fc9d4;text-decoration:none;"><?php echo $property_arr[0]['property_title'] ; ?></a></h4><br/>From $<?php  echo number_format($property_arr[0]['price'],2) ; ?></td></tr></table>
<?php if(!empty($inc_arr)) { ?>
<p><span style="color: #2fc9d4;">Selected inclusions of interest:</span><br/>
<?php  foreach($inc_arr as $inc_val) {
	echo $inc_val['title'].'<br/>';
} ?>
</p>

<?php }  ?>

<br/>Thanks & Regards,<br/>
iCompareBuilders
</div>