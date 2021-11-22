
<style>

 table, td, th {
    border: 1px solid black;
    text-align:left;
    padding:5px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

</style>

<div class="view_product_box" >
  <h2>Client Support Area</h2>
  <div class="border_bottom"></div>

  <table>

    <thead>
	<tr>
	  <th>Chat Access</th>
	  <th>User ID</th>
	  <th>Guest Email</th>
	  <th>First Contact (Date & Time)</th>
	</tr>
    </thead>

    <?php 
	$messages = mysqli_query($con, "select user_id, consumer_email from FYP_ServiceChat group by user_id,consumer_email order by max(message_timestamp) desc ");

	while($row = mysqli_fetch_array($messages)) {
	$select_time = mysqli_query($con, "select message_timestamp from FYP_ServiceChat where user_id='$row[user_id]' or consumer_email='$row[consumer_email]'");
	$row_date = mysqli_fetch_array($select_time);
	  
    ?>
<!---
    <tbody>
	<tr>
	  <td><a href="">Enter Chat</a></td>
	<?php if($row['message_author'] == 'user') { ?>
	  <td><?php echo $row['user_id']; ?></td>
	<?php } elseif($row['message_author'] == 'guest') { ?>
	  <td><?php echo $row['consumer_email']; ?></td>
	<?php } //end if statement ?>
	  <td><?php echo $row_date['message_timestamp']; ?></td>
	</tr> 
	<tr><td colspan="8"><div class="border-bottom"></div></td></tr>
    </tbody>-->

    <tbody>
	<tr>

	  <?php if($row['user_id'] != '') { ?>
	    <td><a href="index.php?action=view_user_chat&user_id=<?php echo $row['user_id']; ?>">Enter Chat</a></td>
	  <?php } else { ?>
	    <td><a href="index.php?action=view_guest_chat&consumer_email=<?php echo $row['consumer_email']; ?>">Enter Chat</a></td>
	  <?php } ?>
	
	  <?php if($row['user_id'] == '') { ?>
	    <td style="color:red;">N/A</td>
	  <?php } else { ?>
	    <td><b><?php echo $row['user_id']; ?></b></td>
	  <?php } ?>

	  <?php if($row['user_id'] == '') { ?>
	    <td><?php echo $row['consumer_email']; ?></td>
	  <?php } else { ?>
	    <td style="color:red;">N/A</td>
	  <?php } ?>

	  <td><?php echo $row_date['message_timestamp']; ?></td>
	</tr> 
    </tbody>

    <?php } //End while loop ?> 

  </table>


</div><!-- /.purchase_history_container --> 
<div class="border_bottom"></div>