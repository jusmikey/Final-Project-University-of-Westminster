
<?php 
  session_start();
?>

<head>
<meta charset="UTF-8">
<title>Admin Area Panel | Log In</title>

  <link rel="stylesheet" type="text/css" href="styles/login.css" /> 
  <link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.min.css">

</head>

<body>

  <div class="header">
    <a><img src="../images/logo.png" /></a>
  </div>

  <div class="login_container">
    <form action="" method="post" enctype="multipart/form-data">

    	<h2>Admin Area Access</h2><br>
    	Email: <input type="text" name="email" class="text-field" placeholder="Email" /><br><br>
    	Password: <input type="password" name="password" class="text-field" placeholder="Password" /><br><br>
    	<input style="cursor:pointer; font-size:17px;" type="submit" name="login"  class="button" value="Access" />

    </form>
  </div><!---- /.login_container ---->

  <div class="go_back">

    <p><a href="../index.php"><i class="fa fa-arrow-left" ></i> Go back to the shop</a></p>
    <h5 style="color:lightgrey; margin-top:10px;"> &copy; <?php echo date('Y');?> - Online Shopping Project By Michal Szatkowski (W1712116) </h5>

  </div> <!----- /.go_back ----->

</body>

<?php
  include('../includes/db.php');

  if(isset($_POST['login'])){
    $email = trim(mysqli_real_escape_string($con,$_POST['email']));
    $password = trim(mysqli_real_escape_string($con,$_POST['password']));

    $sel_user = mysqli_query($con, "select * from FYP_Users where email ='$email' ");
    $db_row = mysqli_fetch_array($sel_user);
    $check_user = mysqli_num_rows($sel_user);

    //Check if user exists in the database
    if($check_user > 0){

    	//Authenticate password
	if(password_verify($password, $db_row['password'])) {
 	  
	  $_SESSION['email'] = $db_row['email']; 
 	  $_SESSION['name'] = $db_row['name'];
 	  $_SESSION['user_id'] = $db_row['id'];
 	  $_SESSION['role'] = $db_row['role'];
	
 	  if($db_row['role'] =='admin'){
	    echo "<script>alert('Welcome to admin panel. You have successfully logged in.');</script>";
 	    echo "<script>window.open('index.php?logged_in=You have successfully Logged In!','_self')</script>";
 	  } elseif($db_row['role'] =='guest') {
 	    echo "<script>alert('Area only accessible to admin!')</script>";
 	  }
	} else {
	  echo "<script>alert('Password or Email is not recognised, try again..')</script>";
	}
    } else {
 	echo "<script>alert('Password or Email is not recognised, try again..')</script>";
    }
  }
?>