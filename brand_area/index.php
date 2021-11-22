
<?php 
  include '../includes/db.php';
  session_start();

  if(isset($_GET['brand_id'])) {

  $select_brand = mysqli_query($con, "select * from FYP_BrandUsers where brand_id='$_GET[brand_id]'");
  $row = mysqli_fetch_array($select_brand);
  $count = mysqli_num_rows($select_brand);

  $select_team = mysqli_query($con, "select * from FYP_BrandTeams where user_id='$_SESSION[user_id]' and status='Declined'");

  if(!isset($_SESSION['user_id'])) {
    echo "<script>alert('You aren't logged in, please login.')</script>";
    echo "<script>window.open('login.php','_self')</script>";
  } elseif(mysqli_num_rows($select_brand) == 0) {
    echo "<script>alert('You are not a brand, please login.')</script>";
    echo "<script>window.open('login.php','_self')</script>";
  } elseif(mysqli_num_rows($select_team) > 0) {
    echo "<script>alert('You are not part of this brand, logging out.')</script>";
    echo "<script>window.open('login.php','_self')</script>";

  } else {

?>

<!DOCTYPE html><!-- HTML5 Declaration -->

<html>
<head>
  <title>Brand Panel | Online Shopping (W1712116)</title>

  <link href="styles/index.css" type="text/css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>

<body>
  
  <!-- Container -->
  <div class="container">

    <div class="logo_login">
 	<a href="../index.php"><img src="../images/logo.png" alt="W1712116 Project Logo" /></a>
    </div> <!---- /.logo_login ---->

    <!-- Header -->
    <div class="header">

	<!-- Navigation Bar Header -->
	<div class="navbar-header">
	  <h2><a class="admin_name">Brand Panel for: <?php echo $row['brand_title']; ?></a></h2>
	  <h3><a class="admin_name">Business Number: <?php echo $row['brand_number']; ?></a></h3><br>
	</div><!-- Navigation Bar Header (Closing) -->

    </div><!-- Header (Closing) -->

    <!-- Body Container -->
    <div class="body_container">

	<!-- Left Sidebar -->
	<div class="left_sidebar">

	  <!-- Left Sidebar Box -->
	  <div class="left_sidebar_box"> 
	    <ul class="left_sidebar_first_level">
		
		<li><a href="../index.php" target="_blank"><i class="fa fa-arrow-left"></i> Go to the Shop</a></li>

		<!-- Products -->
		<li>
		  <a href="#"><i class="fa fa-th-large"></i>&nbsp;Products<i class="arrow fa fa-angle-left"></i></a>
		  <ul class="left_sidebar_second_level">
			<li><a href="index.php?action=add_pro&brand_id=<?php echo $row['brand_id']; ?>">Add Product</a></li>
			<li><a href="index.php?action=view_pro&brand_id=<?php echo $row['brand_id']; ?>">View Products</a></li>
			<li><a href="index.php?action=pro_offers&brand_id=<?php echo $row['brand_id']; ?>">Product Offers</a></li>
		  </ul> <!-- /.left_sidebar_second_level -->
		</li>

		<!-- View Your Brand -->
		<li>
		  <a href="#"><i class="fa fa-university"></i>&nbsp;Your Brand<i class="arrow fa fa-angle-left"></i></a>
		  <ul class="left_sidebar_second_level">
			<li><a href="index.php?action=view_brand&brand_id=<?php echo $row['brand_id']; ?>">View Your Brand</a></li>
			<li><a href="index.php?action=edit_brand&brand_id=<?php echo $row['brand_id']; ?>">Edit Your Brand</a></li>
		  </ul> <!-- /.left_sidebar_second_level -->
		</li>

		<!-- Users -->
		<li>
		  <a href="#"><i class="fa fa-users"></i>&nbsp;Brand Team<i class="arrow fa fa-angle-left"></i></a>
		  <ul class="left_sidebar_second_level">
			<li><a href="index.php?action=view_users&brand_id=<?php echo $row['brand_id']; ?>">View Your Team</a></li>
			<li><a href="index.php?action=add_user&brand_id=<?php echo $row['brand_id']; ?>">Add a Team Member</a></li>
		  </ul> <!-- /.left_sidebar_second_level -->
		</li>

		<!-- Brand Support -->
		<li>
		  <a href="#"><i class="fa fa-life-ring"></i>&nbsp;Brand-Service Support<i class="arrow fa fa-angle-left"></i></a>
		  <ul class="left_sidebar_second_level">
			<li><a href="index.php?action=write_support&brand_id=<?php echo $row['brand_id']; ?>">Write to Service Chat</a></li>
		  </ul> <!-- /.left_sidebar_second_level -->
		</li>

		<!-- Disputes 
		<li>
		  <a href="#"><i class="fa fa-gavel"></i>&nbsp;Order Disputes<i class="arrow fa fa-angle-left"></i></a>
		  <ul class="left_sidebar_second_level">
			<li><a href="index.php?action=view_disputes&brand_id=<?php echo $row['brand_id']; ?>">View Disputes</a></li>
		  </ul>--> <!-- /.left_sidebar_second_level 
		</li>-->

		<li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>

	    </ul><!-- /.left_sidebar_first_level -->
	  </div><!-- Left Sidebar Box (Closing) -->

	</div><!-- Left Sidebar (Closing) -->

	<!-- Content -->
	<div class="content">

	  <!-- Content Box -->
	  <div class="content_box">
	    <?php
		if(isset($_GET['action'])) {
		  $action = $_GET['action'];
		} else {
		  $action = '';
		}

	 	switch($action) {
		  case 'add_pro';
		  include 'includes/insert_product.php';
		  break;

		  case 'view_pro';
		  include 'includes/view_products.php';
		  break;

		  case 'edit_pro';
		  include 'includes/edit_product.php';
		  break;

		  case 'offer_pro';
		  include 'includes/edit_offer_product.php';
		  break;

		  case 'pro_offers';
		  include 'includes/product_offers.php';
		  break;

		  case 'view_brand';
		  include 'includes/view_brand.php';
		  break;

		  case 'edit_brand';
		  include 'includes/edit_brand.php';
	 	  break;

		  case 'view_users';
		  include 'includes/view_users.php';
		  break;

		  case 'add_user';
		  include 'includes/add_user.php';
		  break;

		  case 'edit_user';
		  include 'includes/edit_user.php';
		  break;

		  case 'write_support';
		  include 'includes/support_chat.php';
		  break;

  		  default;
  		  include('includes/account.php');
  		  break;

		}
	    ?>
	  </div> <!-- Content Box (Closing) -->

	</div><!-- Content (Closing) -->

    </div> <!-- Body Container (Closing) -->

  </div><!-- Container (Closing) -->
</body>
</html>

<script src="../js/jquery-3.5.1.js"></script>

<script>
$(document).ready(function(){
  
  // Drop Down Menu Right
  $(".dropdown-navbar-right").on('click',function(){
   $(this).find(".subnavbar-right").slideToggle('fast');
  });
  
  // Collapse Left Sidebar
  $(".left_sidebar_first_level li").on('click',this,function(){
    $(this).find(".left_sidebar_second_level").slideToggle('fast');

    //change angle left and down on click
    $(this).find('.arrow').toggleClass('fa-angle-left fa-angle-down');
  });
  
  //Keep collapse left sidebar item open and active after clicking on link of current page
  var path = window.location.href;
  $('.left_sidebar_second_level li a').each(function() {
    if(this.href === path) {
	$(this).parents('.left_sidebar_second_level li').addClass('active');
	$(this).parents('.left_sidebar_second_level').addClass('open');

  	//change angle left and down on click
	$(this).parents('.left_sidebar_first_level li').find('.arrow').toggleClass('fa-angle-left fa-angle-down');
     }
  });
  
});
</script>

<?php } ?>

  <!-------- Footer -------->
  <div class="footer">
    <div class="footer1">
	<img src="../images/logo.png" alt="Project logo" />
	<h5 style="color:lightgrey;"> &copy; <?php echo date('Y');?> - Online Shopping Project By Michal Szatkowski (W1712116) </h5>
    </div> <!--- /.footer1 --->
  </div>

<?php } else {

  session_destroy();

  echo "<script>alert('Brand does not exist.');</script>";
  echo "<script>window.open('login.php','_self');</script>";

 } ?>

