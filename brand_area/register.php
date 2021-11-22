
<?php include('../includes/db.php');
  SESSION_START();

?>

<html>

<head>
  <title>Register as a Brand | Brand Area</title>
  <link href="styles/register.css" type="text/css" rel="stylesheet">
</head>



<body>

  <div class="register_container">

    <div class="logo_login">
 	<a href="../index.php"><img src="../images/logo.png" alt="W1712116 Project Logo" /></a>
    </div> <!---- /.logo_login ---->

  <?php 	  
    //Check if brand already exists
    $seek_brand = mysqli_query($con, "select * from FYP_BrandUsers where user_id='$_SESSION[user_id]'");
    $check_brand = mysqli_num_rows($seek_brand);

    if($check_brand == 0) { ?>
  <div class="register_element">
  <!---- Registration Form for Already Registered Users ---->
  <form action="" method="post" enctype="multipart/form-data">

    <h2>Firstly register your grocery brand!</h2>
    <p style="color:#90D6AC;"> Main Information:</p>
    <input type="text" name="brand_name" placeholder="Your Brand Title" required/>
    <input type="text" name="brand_number" placeholder="Your Business Number" required/>
    
    <!--- Other business details --->
    <p style="color:#90D6AC;">Please specify the main location of your brand.</p>
    <input type="text" name="brand_city" placeholder="City / Town " required/>
    <input type="text" name="brand_country" placeholder="Country" required/><br><br>
    <input type="text" name="brand_postcode" placeholder="Postcode" required/>
    <input type="number" name="brand_contact" placeholder="Main Contact Number" required/>

    <!---- Additional Brand Information ---->
    <p style="color:#90D6AC;">Please specify general description of your brand.</p>
    <textarea name="brand_info" cols="50" rows="7" required placeholder="Your Brand Information"></textarea><br><br>

    <input type="submit" name="register_business" class="button" value="Register your brand!" />

  </form>

  </div> <!--- /.register_element --->

  <p class="log_out"><a href="logout.php">Logout</a></p>
  <p class="go_back"><a href="../index.php">Go back to the shop</a></p>

  <?php 
    if(isset($_POST['register_business'])){

	$brand_name = trim(mysqli_real_escape_string($con, $_POST['brand_name']));
	$brand_number = $_POST['brand_number'];
	$brand_city = $_POST['brand_city'];
	$brand_country = $_POST['brand_country'];
	$brand_postcode = $_POST['brand_postcode'];
	$brand_contact = $_POST['brand_contact'];
	$brand_info = trim(mysqli_real_escape_string($con, $_POST['brand_info']));

	$sel_brand = mysqli_query($con, "select * from FYP_BrandUsers where lower(brand_title) like lower('%$brand_name')");
	$sel_number = mysqli_query($con, "select * from FYP_BrandUsers where lower(brand_number) like lower('%$brand_number')");
	$sel_postcode = mysqli_query($con, "select * from FYP_BrandUsers where lower(brand_postcode) like lower('%$brand_postcode')");
	$sel_contact = mysqli_query($con, "select * from FYP_BrandUsers where lower(brand_contact) like lower('%$brand_contact')");

	if(mysqli_num_rows($sel_brand) > 0) {
	  echo "<script>alert('Brand name already exists!');</script>";
	} elseif(mysqli_num_rows($sel_number) > 0) {
	  echo "<script>alert('Business number already exists!');</script>";
	} elseif(mysqli_num_rows($sel_postcode) > 0) {
	  echo "<script>alert('Postcode already exists!');</script>";
	} elseif(mysqli_num_rows($sel_contact) > 0) {
	  echo "<script>alert('Contact already exists!');</script>";
	} else {

	  //Insert new brand
	  $insert_brand = mysqli_query($con, "insert into FYP_BrandUsers (user_id, brand_title, brand_number, brand_city, brand_country, brand_postcode, brand_contact, brand_information) 
	  values ('$_SESSION[user_id]', '$brand_name', '$brand_number', '$brand_city', '$brand_country', '$brand_postcode', '$brand_contact', '$brand_info')");

	  //Send Registration Brand Email
	  $to = "michbodzio97@yahoo.com"; //$_SESSION['email']
	  $subject = "Congrtualtions on registrating your business brand.";
	  $txt = "Welcome to your brand panel, whilst you wait for our approval, you can start to plan your brand team.";
	  $headers = "Brand Registration | W1712116 Online Shopping";

	  if($insert_brand) {
	  	$sel_brand = mysqli_query($con, "select * from FYP_BrandUsers where user_id='$_SESSION[user_id]'");
	  	$fetch_brand = mysqli_fetch_array($sel_brand);
		mail($to,$subject,$txt,$headers);


	  	echo "<script>alert('Brand created successfully!');</script>";
	  	echo "<script>window.open('index.php?brand_id=$fetch_brand[brand_id]','_self')</script>";
	  } else {
	  	echo "<script>alert('There was an error! Please try again');</script>";
	  }
	}
  }

  ?>

  <?php } else {
    echo "<script>alert('You have already created a brand..');</script>";
    echo "<script>window.open('index.php','_self')</script>";
    }
  ?>

  </div>

</body>

</html>

