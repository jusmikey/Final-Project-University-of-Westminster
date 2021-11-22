
<h2 style="color:#FFD966;"> Brand Teams</h2><br>

<?php 

  $select_user = mysqli_query($con, "select * from FYP_BrandTeams where user_id='$_SESSION[user_id]'");
  $fetch_user = mysqli_fetch_array($select_user);


  //If user was asked to become a team member
  if(mysqli_num_rows($select_user) > 0) {

    $select_brand = mysqli_query($con, "select * from FYP_Brands where brand_id='$fetch_user[brand_id]'");
    $fetch_brand = mysqli_fetch_array($select_brand);

    $select_name = mysqli_query($con, "select * from FYP_Users where id='$_SESSION[user_id]'");
    $fetch_name = mysqli_fetch_array($select_name);

    //If user status is 'pending'
    if($fetch_user['status'] == 'Pending') { ?>

    <p style="color:black; border:dotted 2px #B266FF; border-radius:5px; padding:5px; background:white;">You have been asked to become a team member. <br><b> Brand Name: </b><?php echo $fetch_brand['brand_title']; ?> </p>
    <br><p><b>Please choose to accept or decline.</b></p><br>

    <form method="post" action="">
	Your Full Name: <input type="text" value="<?php echo $fetch_name['name']; ?>" placeholder="Insert your full name" name="user_name" required /><br><br>
	<input class="hover_invitation" style="border:#90D6AC dotted 2px; background:white; padding:10px; cursor:pointer; color:black; margin-right:10px;" type="submit" value="Accept" name="approve" />
	<input class="hover_invitation" style="border:#B266FF dotted 2px; background:white; padding:10px; cursor:pointer; color:black;" type="submit" value="Decline" name="remove" />
    </form>

    <?php 

    if(isset($_POST['approve'])) {
	  $update_status = mysqli_query($con, "update FYP_BrandTeams set status='Approved' where user_id='$_SESSION[user_id]'");
	  $update_name = mysqli_query($con, "update FYP_Users set name='$_POST[user_name]' where id='$_SESSION[user_id]'");

	  if($update_status && $update_name) {
	    echo "<script>alert('Congratulations. You are now officially a team member!')</script>";
	    echo "<script>window.open(window.location.href,'_self')</script>";

	  } else {
	    //echo mysqli_error($con);
	    echo "<script>alert('Failed to become a team member, please notify the support service!')</script>";
	  }

    } elseif(isset($_POST['remove'])) {
	  $update_status = mysqli_query($con, "update FYP_BrandTeams set status='Declined' where user_id='$_SESSION[user_id]'");

	  if($update_status) {
	    echo "<script>alert('Your decision was updated, and the brand team will be notified!')</script>";
	    echo "<script>window.open(window.location.href,'_self')</script>";

	  } else {
	    echo mysqli_error($con);
	  }
    }

    ?>

<?php } elseif($fetch_user['status'] == 'Declined') { ?>

  <p>The brand has been notifed about your decision. <br> If you have any questions please don't hesitate to write the service support..</p>

<?php } else { ?>

  <p style="font-size:20px;">You are a team member of: <b><?php echo $fetch_brand['brand_title']; ?></b></p>
  <br>
  <a class="link_brand_team" href="brand_area/login.php">Access your Team Brand Panel Area</a>
  <br><br>

  <form method="post" action="">
    <input class="hover_invitation" style="background:white; cursor:pointer; border:#B266FF dotted 2px;" type="submit" name="leave" value="Leave your Team" />  
  </form>

  <?php 
    if(isset($_POST['leave'])) {
	$change_stat = mysqli_query($con, "update FYP_BrandTeams set status='Declined' where user_id='$_SESSION[user_id]'");

	if($change_stat) {
	  echo "<script>alert('You have left the team successfully.')</script>";
	  echo "<script>window.open('my_account.php?action=team','_self')</script>";

	} else {
	  echo "<script>alert('You were unable to leave the team successfully. Notify your team')</script>";
	  echo mysqli_error($con);
	}
    }
  ?>

<?php } //end user status statements

  } else {
    echo "<p>This section is for your local grocery brands.</p>
	<p>If you're a brand yourself, then don't <a class='link_brand_team' href='brand_area/login.php'>hesitate to register as a brand!</a></p>
    ";
  }
?>