
<?php include('../includes/db.php');
  session_start();
?>

<html>

<head>
  <title>Brand Panel | Log In</title>
  <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="styles/login.css">

</head>

<body>

  <div class="login_container">

    <div class="logo_login">
 	<a href="../index.php"><img src="../images/logo.png" alt="W1712116 Project Logo" /></a>
    </div> <!---- /.logo_login ---->

    <div class="login_element">

  <!---- Login Form for Already Registered Users ---->
  <form action="" method="post" enctype="multipart/form-data">

    <h1>Access the Brand Panel Area</h1>
    <input type="text" name="email" class="text-field" placeholder="Your User Email" /><br><br>
    <input type="password" name="password" class="text-field" placeholder="Your User Password" /><br><br>
    <input type="submit" name="login"  class="button" value="Access" />

  </form>

  <p><a href="../register.php">If you are not a registered user, then please register before trying to login.</a></p>
 


    </div> <!--- /.login_element --->

  <div class="go_back">

    <p><a href="../index.php"><i class="fa fa-arrow-left" ></i> Go back to the shop</a></p>
    <h5 style="color:lightgrey;"> &copy; <?php echo date('Y');?> - Online Shopping Project By Michal Szatkowski (W1712116) </h5>

  </div> <!----- /.go_back ----->

  <?php 
    if(isset($_POST['login'])){
    	$email = trim(mysqli_real_escape_string($con,$_POST['email']));
    	$password = trim(mysqli_real_escape_string($con,$_POST['password']));

    	$sel_user = mysqli_query($con, "select * from FYP_Users where email ='$email'");
    	$check_user = mysqli_num_rows($sel_user);

    	if($check_user > 0){

 	  $db_row = mysqli_fetch_array($sel_user);

	  if(password_verify($password, $db_row['password'])) {

	    $_SESSION['email'] = $db_row['email']; 
 	    $_SESSION['name'] = $db_row['name'];
 	    $_SESSION['user_id'] = $db_row['id'];
 	    $_SESSION['role'] = $db_row['role'];

	    //Check if member of a team
	    $seek_team = mysqli_query($con, "select * from FYP_BrandTeams where user_id='$_SESSION[user_id]'");
	    $fetch_team = mysqli_fetch_array($seek_team);
	    $check_team = mysqli_num_rows($seek_team);

	    //Check if brand already exists
	    $seek_brand = mysqli_query($con, "select * from FYP_BrandUsers where user_id='$_SESSION[user_id]'");
	    $fetch_brand = mysqli_fetch_array($seek_brand);
	    $check_brand = mysqli_num_rows($seek_brand);

	    //If user has been asked to be in a team or is a team member
	    if($check_team != 0) {
	    	if($fetch_team['status'] == 'Approved') {

	      	  //Get Brand ID of Manager
	      	  $bid = mysqli_query($con, "select * from FYP_BrandUsers where user_id='$fetch_team[manager_id]'");
	      	  $fetch_bid = mysqli_fetch_array($bid);

	      	  echo "<script>alert('Your login was successful. Welcome to your Team Brand Panel!')</script>";
 	      	  echo "<script>window.open('index.php?brand_id=$fetch_bid[brand_id]','_self')</script>";
	    	} elseif($fetch_team['status'] == 'Pending') {
	          echo "<script>alert('Your login credentials were recognised. You can only login when you have accepted your brand team!')</script>";
	    	} else {

	      	  //Users that declined brand invitation can create their own brand
	      	  echo "<script>alert('Congratulations, your login was successful. Please register your grocery brand!')</script>";
 	      	  echo "<script>window.open('register.php','_self')</script>";
	    	}

	    //If a user is not a brand and wants to become their own brand
	    } elseif($check_brand == 0) {
	
	    	//If user is of role admin
	    	if($db_row['role'] == 'admin') {
		  echo "<script>alert('You are admin! You cannot register a brand!')</script>";
	    	} else {

	      	  //Normal User role can create a brand
	      	  echo "<script>alert('Congratulations, your login was successful. Please register your grocery brand!')</script>";
 	      	  echo "<script>window.open('register.php','_self')</script>";
	    	}

	  } else {
	    echo "<script>alert('Your login was successful. Welcome to your Brand Panel!')</script>";
 	    echo "<script>window.open('index.php?brand_id=$fetch_brand[brand_id]','_self')</script>";
	  }

	} else {
 	  echo "<script>alert('Password or Email is not recognised, try again!')</script>";
	}

    } else {
 	echo "<script>alert('Password or Email is not recognised, try again!')</script>";
    }
  }

  ?>

  </div> <!--- /.login_container --->

</body>

</html>

