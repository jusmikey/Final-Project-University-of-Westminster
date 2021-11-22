<?php include('includes/header.php'); ?>

<?php if(!isset($_SESSION['email'])) { ?>
  <div class="forgot_password_container">

    <h3 style="color:#B266FF;">Forgotten Details</h3>
    <p>Enter the email address you use to sign in and we'll send you a code to reset your password.</p><br>

    <form method="post" action="">
	<input type="email" name="email" placeholder="Your Account Email" required/><br><br>
	<input class="reset_pass_btn" type="submit" value="Reset Password" name="reset" />
    </form><br>

    <p><a style="text-decoration:underline; color:#B266FF;" href="index.php?action=login">Return to Login..</a></p>

  </div>

  <?php

    if(isset($_POST['reset'])) {
	
	$email = $_POST['email'];
	
	$find_email = mysqli_query($con, "select * from FYP_Users where email='$email'");

	if(mysqli_num_rows($find_email) == 0) {
	  echo "<script>alert('This email does not exist, please insert a valid email.');</script>";
	  echo "<script>window.open(window.location.href,'_self') </script>";
	} else {
	  
 	  $new_password = uniqid();
	  $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
	  $update_pass = mysqli_query($con, "update FYP_Users set password='$hashed_password' where email='$email'");

	  $to = "michbodzio97@yahoo.com"; //$email
	  $subject = "You have reset your password.";
	  $txt = "We are sorry that you forgot your password. We made you another one for your login.." . "\r\n" . "If you have not reset your password, then please contact us immediately through the service chat."
		. "\r\n" . "Your new password: " . $new_password . "\r\n" . "You can use this password for your account, or change it after you access your account. ";
	  $headers = "Password Reset | W1712116 Online Shopping";

	  if($update_pass) {
		mail($to,$subject,$txt,$headers);
	  	echo "<script>alert('Your password was restarded, please check your email to access your details.');</script>";
	  	echo "<script>window.open(window.location.href,'_self') </script>";
	  } else {
		//echo "<script>alert('There was a problem with restarding your password, please contact the service or try again..');</script>";
	  	//echo "<script>window.open(window.location.href,'_self') </script>";
		echo mysqli_error($con);
	  }

	}
    }

  ?>

<?php } else { 
	  echo "<script>alert('You are already in your account!');</script>";
  	  echo "<script>window.open('index.php','_self') </script>";
  }
?>

<?php include('includes/footer.php'); ?>