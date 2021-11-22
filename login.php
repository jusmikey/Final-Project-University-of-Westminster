<!-- Inside Checkout.php -->
<div class="login_box"> 

  <form method="post" action=""> 
    <h2 style="color:#90D6AC;">Consumer Login</h2><br>
    Email: <input type="email" name="email" placeholder="Insert Email" required /><br><br>
    Password: <input type="password" name="password" placeholder="Insert Password" required /><br><br>
    <input style="width:70%; cursor:pointer; border-radius:5px; border:dotted 2px #90D6AC; color:#90D6AC; font-size:17px; padding:5px; background:white;" type="submit" name="login" value="Login" /><br><br>

    <h3>Don't have an account?</h3>
    <a class="link_register" href="register.php"> Register Here </a><br><br>

    <!------ Forgotten Password ------>
    <a class="link_register" style="color:lightgrey;text-decoration:underline;" href="forgot_password.php"> Forgotten Your Password? </a>
	
  </form>

</div>

  <div class="login_box">
    <form action="" method="post">
	<h3>Purchase as a guest?</h3><input name="guest_option" style="background:none; border:none; cursor:pointer;" type="submit" class="link_register" value="Continue as Guest" /> <br><br>
    </form>
  </div>


<?php 
  if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    //Search through database for the email
    $search = mysqli_query($con, "select * from FYP_Users where email='$email'");
    $count_email = mysqli_num_rows($search);
    $fetch = mysqli_fetch_array($search);

    //Check if email exists in the database
    if($count_email != 0) {

	if(password_verify($password, $fetch['password'])) {

	  //Start Access to Account
	  $_SESSION['user_id'] = $fetch['id']; 
  	  $_SESSION['role'] = $fetch['role'];  
  	  $_SESSION['email'] = $email;

	  echo "<script>alert('You have logged in successfully!')</script>";
  	  echo "<script>window.open('my_account.php?action=account','_self')</script>";

    	} else {
	  echo "<script>alert('Your email or the password is not recognised..');</script>";
    	}
    } else {
	echo "<script>alert('Your email or the password is not recognised..');</script>";
    }
  
  }

  /* Purchase through Guest */

  if(isset($_POST['guest_option'])) {
	if(isset($_GET['location'])) {
	  echo "<script>window.location.replace('checkout_guest.php?payment=process&location=$_GET[location]')</script>";
	}
	  echo "<script>alert('Choose a location..');</script>";
	  echo "<script>window.location.replace('index.php')</script>";

  }

?>