<div style="background-color: #efefef;padding: 10px;width: 500px;">
<p>Hi Admin, <br/> <h2 style="color: #2fc9d4;"></h2> <br/>Below is the Feedback from user <br/></p>
<table style="width: 500px;">
<tr>
<td>Rating</td><td><?php echo $user_inputs['rate_status']; ?></td>
</tr>
<?php if(!empty($user_inputs['online_enquiry'])) { ?>
<tr>
<td>Did we resolve your online enquiry today?</td><td><?php echo $user_inputs['online_enquiry']; ?></td>
</tr>
<?php }  ?>
<tr>
<td>What had the biggest impact on your score? </td><td><?php echo $user_inputs['biggest_impact']; ?></td>
</tr>
<tr>
<td>Message</td><td><?php echo $user_inputs['message']; ?></td>
</tr>
</table>
<br/>Thanks & Regards,<br/>
iCompareBuilders
</div>
