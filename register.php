<?php 
	include('includes/header.php');
	include("includes/db.php");
 ?>			

<div class="registration_box"> 

  <form method="post" action="" enctype="multipart/form-data"> 


    <!-- Register -->
    <h2 style='color:#B266FF;'><b> Register as a Consumer <b></h2><br>

    <b> Email:</b><br>
    <input style="margin-bottom:10px;" type="email" name="email" required placeholder="Your Email" /><br>

    <b> Password:</b><br>
    <input style="margin-bottom:10px;" type="password" name="password" id="password_confirm1" required placeholder="Password" /><br>

    <b>Confirm Password:</b><p style="margin-bottom:10px;" id="status_for_confirm_password"></p>
    <input style="margin-bottom:10px;" type="password" name="confirm_password" id="password_confirm2" required placeholder="Confirm Password" /><br>

    <!-- Displaying validated password -->

	<!------ Password Matching ------>

			<script>
			  $(document).ready(function() {
			    $("#password_confirm2").on('keyup',function() {
				var password_confirm1 = $("#password_confirm1").val();
				var password_confirm2 = $("#password_confirm2").val();
				//alert(password_confirm2);

				if(password_confirm1 == password_confirm2) {
				  $("#status_for_confirm_password").html('<p class="passwords_message" style=" padding:5px; border-radius:4px; margin-bottom:3px; color:white; background:lightgreen;">Passwords match. Passwords need more than 8 characters, of special types, including a number.</p>');
				} else {
				  $("#status_for_confirm_password").html('<p class="passwords_message" style="padding:5px; border-radius:4px; margin-bottom:3px; color:white; background:red;">Passwords do not match. Passwords need more than 8 characters, of special types, including a number.</p>');
				}
			    });
			  });

			</script>

    <b> Insert Your Account Image:</b>
    <input style="margin-bottom:10px;" type="file" name="image" /><br><br>

    <input class="register_button" style="margin-bottom:15px;" type="submit" name="register" value="Register" />
    <h4>Already a member? <a class="login_register" href="index.php?action=login"> Access your account.. </a><h4><br><br>

  </form>     

</div>

<?php 
  if(isset($_POST['register'])){  
    $ip = get_ip();
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    /* Saving the profile image */
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    //Password Conditions
    $pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';

    $check_exist = mysqli_query($con,"select * from FYP_Users where email = '$email'");
    $email_count = mysqli_num_rows($check_exist);

    //Check if email does not already exist in the database
    if(!$email_count > 0) {

  	//Check if password suits the pattern
	if(preg_match($pattern, $password)) {
	  
	  //Check if password matches the confirmation password
	  if($password == $confirm_password) {

	    //Profile Image
	    move_uploaded_file($image_tmp,"upload-files/$image");

	    //Hash passwords for secure encryption
	    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

	    $stmt = $con->prepare("insert into FYP_Users (ip_address,email,password,image) values (?,?,?,?) ");
    	    $stmt->bind_param("ssss",$ip, $email, $hashed_password, $image);
    	    $insert_data = $stmt->execute();

     	    /* Send Registration email to new user */
     	    $to = "michbodzio97@yahoo.com";

  	    $subject = "Account Registration Successful | W171216 Online Shopping";

  	    $message = '
    	  	<html>
 	    	  <p>
 	  	    Thank you for registering with us! <b style="color:blue">'.$email.',</b>
 	    	  </p>
 
 	    	  <p>
 	  	    Do not hesitate to contact us and check out your account anytime !
 	    	  </p>
 
    		</html>
    	    ';

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'Account Registration | Online Shopping' . "\r\n";

	    if($insert_data) {

		$sel_user = mysqli_query($con, "select * from FYP_Users where email='$email'");
		$row_user = mysqli_fetch_array($sel_user);

		$send_mail = mail($to,$subject,$message,$headers);	
		$_SESSION['user_id'] = $row_user['id'] . "<br>";
		$_SESSION['role'] = $row_user['role'];	

		echo "<script>alert('Congratulations, you are now an official consumer!')</script>";
	  	echo "<script>window.open('my_account.php?action=account','_self')</script>";	
    	    } else {
		//echo mysqli_error($con);
		echo "<script>alert('Sorry there was an error with your registration, please try again.')</script>";
    	    }

 	  } else {
	    echo "<p style='padding:5px; color:white; background:red; margin-left:10px;'>Passwords did not match.</p>";
	  }
  	} else {
	  echo "Password requires a number, a capital letter, a special character, and more than 8 characters long...";
	}
    } else {
	echo "<script>alert('Sorry the $email is already registered. Try a different email or Login.')</script>";
    }

  }
?>
			
<?php include('includes/footer.php'); ?>			
