<div style="background-color: #efefef;padding: 10px;width: 500px;">
<p>Hi, <br/> <h2 style="color: #2fc9d4;"><?php echo $land_user ; ?></h2> <br/>Below is the enquiry of user <br/></p>
<table style="width: 500px;">
<tr>
<td>Name : </td><td><?php echo $request_arr['name']; ?></td>
</tr>
<tr>
<td>Email : </td><td><?php echo $request_arr['email_id']; ?></td>
</tr>
<?php if(!empty($request_arr['phn'])) {  ?>
<tr>
<td>Phone No. :</td><td> <?php echo $request_arr['phn']; ?></td>
</tr>
<?php } ?>
<?php if(!empty($request_arr['lookingTo'])) {  ?>
<tr>
<td>Looking To : </td><td><?php echo $request_arr['lookingTo']; ?></td>
</tr>
<?php  } ?>
<?php if(!empty($request_arr['message'])) { ?>
<tr>
<td>Message :</td><td><?php echo $request_arr['message']; ?></td>
</tr>
<?php } ?>
</table>
<?php  
if(!empty($land_arr['land_images'])){
 $basepath = url().'/uploads/land_images/'.$land_arr['land_images'][0]['image'] ;
} else {
 $basepath = url().'/assets/img/no-image.jpg' ;
}
 ?>
<p style="color: #2fc9d4;font-weight: bold;">Land Details</p>
<table style="width: 500px;"><tr><td colspan="2" style="width:30%"><span style="color: #2fc9d4;"><?php echo $land_user ; ?></span></td></tr><tr><td style="width:30%" ><?php if(!empty($basepath)) { ?><a href="<?php echo url() ; ?>/land/view/<?php echo $land_arr['id'];  ?>"><img src="<?php echo $message->embed($basepath); ?>" style="width:50%;height:50%"/></a><?php } ?></td><td style="width:70%"><h4 style="padding:0;margin:0"><a href="<?php echo url() ; ?>/land/view/<?php echo $land_arr['id'];  ?>" style="color: #2fc9d4;text-decoration:none;"><?php echo $land_arr['company_name'] ; ?></a></h4><br/>Price Range: <?php echo $land_arr['price_range']; ?>&nbsp;&nbsp; Established: <?php echo $land_arr['established']; ?></td></tr></table>

<br/>Thanks & Regards,<br/>
iCompareBuilders
</div>

<?php  //die; ?>