
  <h2> Create Your Brand Team </h2>
  <div class="border_bottom"> </div><!-- /.border_bottom -->

<?php
  
  $select_brand = mysqli_query($con, "select * from FYP_BrandUsers where brand_id='$_GET[brand_id]'");
  $fetch_brand = mysqli_fetch_array($select_brand);

  $select_bid = mysqli_query($con, "select * from FYP_Brands where brand_title='$fetch_brand[brand_title]'");
  $fetch_bid = mysqli_fetch_array($select_bid);

  if($fetch_brand['status'] == 'Pending') {

?>

  <p>Currently you have not been approved by the service, please be patient.</p>
  <p>Come back another time, and you will be able to insert your products.</p>

<?php } elseif($_SESSION['user_id'] != $fetch_brand['user_id']) { ?>

  <p>You do not have access for this content. <b>Seek Advice if neccessary.</b></p>

<?php } else { ?>
  
  <p>You can create your brand team by inviting users of the website.</p> 
  <p>Find them through their email and wait for their approval.</p><br>

  <form method="post" action="">
    <b>User Email:</b> <input type="email" placeholder="Type User Email" name="user_email" required/> 
    <input class="submit_invitation" type="submit" value="Find Email" name="submit_email"/>
  </form>

  <?php
    if(isset($_POST['submit_email'])) {
	
	$find_email = mysqli_query($con, "select * from FYP_Users where email='$_POST[user_email]'");
	$fetch_user = mysqli_fetch_array($find_email);
	$count_email = mysqli_num_rows($find_email);

	if($count_email > 0) {

	  $find_team = mysqli_query($con, "select * from FYP_BrandTeams where email='$_POST[user_email]'");
	  $count_team = mysqli_num_rows($find_team);

	  if($fetch_user['role'] == 'admin') {
	    echo "<script>alert('This user cannot be added to your team!')</script>";
	  } elseif($count_team > 0) {
	    echo "<script>alert('This user has already been asked to join a team, try again!')</script>";

	  } elseif($fetch_user['id'] == $fetch_brand['user_id']) {
	    echo "<script>alert('You are already in your team!')</script>";
	  } else {
	    $insert_user = mysqli_query($con, "insert into FYP_BrandTeams (user_id, email, brand_id, manager_id) values ('$fetch_user[id]','$fetch_user[email]','$fetch_bid[brand_id]','$fetch_brand[user_id]')");

	    //Send notification email to the invited team member
	    $to = "michbodzio97@yahoo.com"; //$fetch_user['email']
	    $subject = "Invitation from Brand Team | W1712116 Online Shopping";
	    $txt = "You have been invited to join a brand team! You can accept or decline your invitation in you account..";
	    $headers = "Team Brand Invitation | W1712116 Online Shopping";

 	    if($insert_user) {
		mail($to,$subject,$txt,$headers);
		echo "<script>alert('This user was asked to be added to your team successfully!')</script>";
		
	    } else {
		echo "<script>alert('This user wasn't able to be added to your team, try again!')</script>";
	    }
	  }

	} else {
	  echo "<script>alert('User email was not recognised, please try again!')</script>";
	}
    }
  ?>


<?php } // End if pending status ?>
