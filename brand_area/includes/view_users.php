<head>
  <style>

    table, td, th {
  	border: 1px solid black;
    }

    th, td {
	text-align:left;
	padding:5px;
    }

    table {
  	width: 100%;
  	border-collapse: collapse;
    }

  </style>
</head>


  <h2> View Your Team </h2>
  <div class="border_bottom"> </div><!-- /.border_bottom -->

  <div class="form_box">
<?php
  $select_brand = mysqli_query($con, "select * from FYP_BrandUsers where brand_id='$_GET[brand_id]'");
  $fetch_brand = mysqli_fetch_array($select_brand);

  $select_bid = mysqli_query($con, "select * from FYP_Brands where brand_title='$fetch_brand[brand_title]'");
  $fetch_bid = mysqli_fetch_array($select_bid);

  $select_manager = mysqli_query($con, "select * from FYP_Users where id='$fetch_brand[user_id]'");
  $fetch_manager = mysqli_fetch_array($select_manager);

  if($fetch_brand['status'] == 'Pending') {

?>

  <p>Currently you have not been approved by the service, please be patient.</p>
  <p>Come back another time, and you will be able to insert your products.</p>

<?php } else { ?>

  <p><b>Team Leader:</b> <?php echo $fetch_manager['name']; ?></p>
  <p><b>Team Leader Email:</b> <?php echo $fetch_manager['email']; ?></p><br>

  <table style="width:100%">
    <tr>
    	<th>Member Email</th>
	<th>Member Name</th>
    	<th>Member Role</th> 
    	<th>Member Status</th>
    </tr>

    <?php 

 	$select_team = mysqli_query($con, "select * from FYP_BrandTeams where brand_id='$fetch_bid[brand_id]'");

  	while($fetch_team = mysqli_fetch_array($select_team)) {
  	  $select_user = mysqli_query($con, "select * from FYP_Users where id='$fetch_team[user_id]'");
  	  $fetch_user = mysqli_fetch_array($select_user);
    ?>

    <tr>
    	<td><?php echo $fetch_team['email']; ?></td>
    	<td><?php echo $fetch_user['name']; ?></td>
	<td>Team Member</td>

	<?php 
	  if($fetch_team['status'] == 'Pending') {
	    echo "<td style='color:red;'>$fetch_team[status]</td>";
	  } elseif($fetch_team['status'] == 'Declined') {
	    echo "<td style='color:blue;'>$fetch_team[status]</td>";
	  } else {
	    echo "<td style='color:lightgreen;'>$fetch_team[status]</td>";
	  } ?>
    	
    </tr>

    <?php } // end while loop ?>
  </table>

  </div> <!---- /.form_box ---->

<?php } // End if pending status ?>

