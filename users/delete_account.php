
<div class="delete_account_container">

  <h2 style="color:#FFD966;">Delete Account Confirmation</h2><br>

  <form action="" method="post">
    <h4>Please insert your password to confirm the account removal..</h4>
    <input type="password" id="submit_deletion" name="password" placeholder="Password Confirmation" required/>
    <input type="submit" id="yes_btn" class="yes_btn" name="delete" value="Proceed" />
  </form><br>

  <form method="POST" action=""><input type="submit" class="cancel_account" name="cancel" value="Cancel" /></form><br><br>

  <div style="display:none;" id="proceed_account_removal">
    <form method="post" action="">
 	<input type="submit" class="delete_account_btn" value="Delete My Account" name="proceed"/>
    </form>

  </div>

</div><!-- /.delete_account_container -->

<?php 

  if(isset($_POST['delete'])){
    $password = trim($_POST['password']);
   
    $search_password = mysqli_query($con, "select * from FYP_Users where id='$_SESSION[user_id]'");
    $fetch = mysqli_fetch_array($search_password);

    $search_user = mysqli_query($con, "select * from FYP_UserRemoval where id='$_SESSION[user_id]'");

    if(password_verify($password, $fetch['password'])) {

	if(!mysqli_num_rows($search_user) == 0) {
 	  echo "<script>alert('Your account is already set to be removed in less than 30 days.')</script>";
	  echo "<script>window.open('my_account.php?action=account','_self')</script>";	  

	} else {
	  echo "<script>alert('Are you sure you want to delete your account?')</script>";
	
	  //Display Removal Confirmation
          echo "<script>document.getElementById('proceed_account_removal').style.display = 'block';</script>";
          echo "<script>document.getElementById('yes_btn').style.display = 'none';</script>";
          echo "<script>document.getElementById('submit_deletion').style.display = 'none';</script>";

	}

    } else {
 	  echo "<script>alert('The confirmation password is invalid.')</script>";
	  echo "<script>window.open(window.location.href,'_self')</script>";
    }
  }

  if(isset($_POST['proceed'])) {

	//Insert to removal database table
	$insert_user = mysqli_query($con, "INSERT INTO FYP_UserRemoval SELECT id, ip_address, registerDateTime, name, email, password,
	 country, city, postcode, user_address, contact, role FROM FYP_Users where id='$_SESSION[user_id]'" );

	//Change status of user account
	$update_status_account = mysqli_query($con, "update FYP_Users set account_status='to be removed' where id='$_SESSION[user_id]' ");

	if($insert_user) {
	  echo "<script>alert('Your account will be deleted after 30 days from today.')</script>";
	  echo "<script>window.open(window.location.href,'_self')</script>";

 	} else {
	  //echo mysqli_error($con);
	  echo "<script>alert('There was an error with deleting your account, please try again.')</script>";
	  echo "<script>window.open(window.location.href,'_self')</script>";

	}
	
  }
  
  if(isset($_POST['cancel'])){
    echo "<script>window.open('my_account.php?action=account','_self')</script>";
  
  }
?>


