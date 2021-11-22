<?php 
	include("includes/db.php");
?>

		
			<script>
			  $(document).ready(function() {
			    $("#password_confirm2").on('keyup',function() {
				var password_confirm1 = $("#password_confirm1").val();
				var password_confirm2 = $("#password_confirm2").val();
				//alert(password_confirm2);

				if(password_confirm1 == password_confirm2) {
				  $("#status_for_confirm_password").html('<strong style="background:lightgreen;">Password match</strong>');
				} else {
				  $("#status_for_confirm_password").html('<strong style="background:red;">Passwords do not match</strong>');
				}
			    });
			  });

			</script>
<?php 
  $select_user = mysqli_query($con, "select * from FYP_Users where id='$_SESSION[user_id]'");
  $fetch_user = mysqli_fetch_array($select_user);
?>

<div class="edit_account_info"> 

  <form method="post" action="" enctype="multipart/form-data"> 

	<!-- Edit Account -->
	<h2 style="color:#FFD966;"><b> Edit your account </b></h2><br>

	<b> Change Email:</b><br><br>
	<input type="text" name="email" value="<?php echo $fetch_user['email']; ?>" required placeholder="Email" /><br><br>

	<b> Current Password:</b><br><br>
	<input type="password" name="current_password" required placeholder="Your Current Password" /><br><br>
	<input type="submit" name="edit_account" value="Update" />
  </form>

</div>

<?php 
  if(isset($_POST['edit_account'])){  
  
    $email = trim($_POST['email']);
    $password = trim($_POST['current_password']);
   
    $search = mysqli_query($con, "select * from FYP_Users where id='$_SESSION[user_id]'");
    $fetch = mysqli_fetch_array($search);

    $search_email = mysqli_query($con, "select * from FYP_Users where email='$email'");
    $count_email = mysqli_num_rows($search_email);

    if(password_verify($password, $fetch['password'])) {
	
	if(!$count_email > 0) {
	  $update = mysqli_query($con, "update FYP_Users set email='$email' where id='$_SESSION[user_id]'");
	
	  if($update) {
	    echo "<script>alert('Email was successfully updated..')</script>";
	    echo "<script>window.open(window.location.href,'_self')</script>";
	  } else {
	    //echo mysqli_error($con);	    
	    echo "<script>alert('There was an error with updating your email, please try again..')</script>";
	    echo "<script>window.open(window.location.href,'_self')</script>";

	  }
	} else {
	  echo "<script>alert('This email is already registered..')</script>";
	  echo "<script>window.open(window.location.href,'_self')</script>";

	}
    } else {
	echo "<script>alert('This password is invalid..')</script>";
	echo "<script>window.open(window.location.href,'_self')</script>";

    }

  }

?>		