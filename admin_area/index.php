
<?php 
  session_start();

  if($_SESSION['role'] !='admin') {
    echo "<script>alert('You are not admin.. logging out.')</script>";
    echo "<script>window.open('login.php','_self')</script>";
  } elseif(isset($_GET['log_out'])) {
    echo "<script>alert('Loging out..')</script>";
    session_destroy();
    echo "<script>window.open('login.php','_self')</script>";

  } else {

?>

<?php include '../includes/db.php'; ?>

<!DOCTYPE html><!-- HTML5 Declaration -->

<html>
<head>
  <title>Admin Area Panel | Online Shopping W1712116</title>

  <link href="styles/index.css" type="text/css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">   

</head>

<body>
  
  <!-- Container -->
  <div class="container">

    <div class="logo">
 	<a href="../index.php"><img src="../images/logo.png" alt="W1712116 Project Logo" /></a>
    </div> <!---- /.logo ---->
   
    <!-- Header -->
    <div class="header">

	<!-- Navigation Bar Header -->
	<div class="navbar-header">
	  <h3><a href="index.php" class="admin_name">Admin Area - <?php echo $_SESSION['name']; ?></a></h3>
	</div><!-- /.navbar-header -->

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
			<li><a href="index.php?action=add_pro">Add Product</a></li>
			<li><a href="index.php?action=view_pro">View Products</a></li>
			<li><a href="index.php?action=view_offers">All Product Offers</a></li>
		  </ul> <!-- /.left_sidebar_second_level -->
		</li>

		<!-- Categories -->
		<li>
		  <a href="#"><i class="fa fa-plus"></i>&nbsp;Categories<i class="arrow fa fa-angle-left"></i></a>
		  <ul class="left_sidebar_second_level">
			<li><a href="index.php?action=add_cat">Add Categories</a></li>
			<li><a href="index.php?action=view_cat">View Categories</a></li>
		  </ul> <!-- /.left_sidebar_second_level -->
		</li>

		<!-- Dietary Range -->
		<li>
		  <a href="#"><i class="fa fa-plus"></i>&nbsp;Dietary Ranges<i class="arrow fa fa-angle-left"></i></a>
		  <ul class="left_sidebar_second_level">
			<li><a href="index.php?action=add_diet">Add Diet Range</a></li>
			<li><a href="index.php?action=view_diet">View Diet Ranges</a></li>
		  </ul> <!-- /.left_sidebar_second_level -->
		</li>

		<!-- Brands -->
		<li>
		  <a href="#"><i class="fa fa-plus"></i>&nbsp;Brands<i class="arrow fa fa-angle-left"></i></a>
		  <ul class="left_sidebar_second_level">
			<li><a href="index.php?action=add_brand">Add Brands</a></li>
			<li><a href="index.php?action=view_brand">View Brands</a></li>
			<li><a href="index.php?action=view_brand_users">View Brand Owners</a></li>
			<li><a href="index.php?action=view_brand_teams">View Brand Teams</a></li>
			<li><a href="index.php?action=view_brand_decline">View Declined Members</a></li>
		  </ul> <!-- /.left_sidebar_second_level -->
		</li>

		<!-- Product + User Commentary -->
		<li>
		  <a href="#"><i class="fa fa-commenting-o"></i>&nbsp;Product & User Commentary<i class="arrow fa fa-angle-left"></i></a>
		  <ul class="left_sidebar_second_level">
			<li><a href="index.php?action=comments">View Comments</a></li>
		  </ul> <!-- /.left_sidebar_second_level -->
		</li>

		<!-- Users -->
		<li>
		  <a href="#"><i class="fa fa-gift"></i>&nbsp;Admin<i class="arrow fa fa-angle-left"></i></a>
		  <ul class="left_sidebar_second_level">
			<li><a href="index.php?action=view_users">List of Users</a></li>
		  </ul> <!-- /.left_sidebar_second_level -->
		</li>

		<!-- Orders -->
		<li>
		  <a href="#"><i class="fa fa-money"></i>&nbsp;Orders & Payments<i class="arrow fa fa-angle-left"></i></a>
		  <ul class="left_sidebar_second_level">
			<li><a href="index.php?action=view_orders">View Orders</a></li>
			<li><a href="index.php?action=view_deliveries">View User Deliveries</a></li>
			<li><a href="index.php?action=view_guest_deliveries">View Guest Deliveries</a></li>
		  </ul> <!-- /.left_sidebar_second_level -->
		</li>

		<!-- Client and Brand Support -->
		<li>
		  <a href="#"><i class="fa fa-life-ring"></i>&nbsp;Client and Brand Support<i class="arrow fa fa-angle-left"></i></a>
		  <ul class="left_sidebar_second_level">
			<li><a href="index.php?action=view_messages">View Client Messages</a></li>
			<li><a href="index.php?action=view_brand_messages">View Brand Messages</a></li>
		  </ul> <!-- /.left_sidebar_second_level -->
		</li>

		<!-- Disputes -->
		<li>
		  <a href="#"><i class="fa fa-gavel"></i>&nbsp;Order Disputes<i class="arrow fa fa-angle-left"></i></a>
		  <ul class="left_sidebar_second_level">
			<li><a href="index.php?action=view_disputes">User Disputes</a></li>
			<li><a href="index.php?action=view_disputes_guest">Guest Disputes</a></li>
		  </ul> <!-- /.left_sidebar_second_level -->
		</li>

		<!-- Log Out -->
		<li>
		  <a href="index.php?log_out"><i class="fa fa-sign-out"></i> Logout</a>
		</li>


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

		  case 'view_offers';
		  include 'includes/view_offers.php';
		  break;

		  case 'add_cat';
		  include 'includes/insert_category.php';
		  break;

		  case 'view_cat';
		  include 'includes/view_categories.php';
		  break;

		  case 'edit_cat';
		  include 'includes/edit_category.php';
		  break;

		  case 'add_diet';
		  include 'includes/insert_diet.php';
		  break;

		  case 'view_diet';
		  include 'includes/view_diets.php';
		  break;

		  case 'edit_diet';
		  include 'includes/edit_diet.php';
		  break;

		  case 'add_brand';
		  include 'includes/insert_brand.php';
		  break;

		  case 'view_brand';
		  include 'includes/view_brands.php';
		  break;

		  case 'view_brand_users';
		  include 'includes/view_brand_users.php';
	 	  break;

		  case 'view_brand_teams';
		  include 'includes/view_brand_teams.php';
	 	  break;

		  case 'display_team';
		  include 'includes/display_team.php';
	 	  break;

		  case 'view_brand_decline';
		  include 'includes/view_brand_decline.php';
	 	  break;


		  case 'edit_brand_users';
		  include 'includes/edit_brand_users.php';
		  break;

		  case 'edit_brand';
		  include 'includes/edit_brand.php';
		  break;

		  case 'comments';
		  include 'includes/comments.php';
		  break;

		  case 'edit_comment';
		  include 'includes/edit_comment.php';
		  break;

		  case 'view_users';
		  include 'includes/view_users.php';
		  break;

		  case 'edit_user';
		  include 'includes/edit_user.php';
		  break;

		  case 'view_orders';
		  include 'includes/view_orders.php';
		  break;

		  case 'view_receipt';
		  include 'includes/receipt.php';
		  break;

		  case 'view_deliveries';
		  include 'includes/view_deliveries.php';
		  break;

		  case 'display_delivery';
		  include 'includes/display_user_delivery.php';
		  break;

		  case 'display_guest_delivery';
		  include 'includes/display_guest_delivery.php';
		  break;


		  case 'view_guest_deliveries';
		  include 'includes/view_guest_deliveries.php';
		  break;		  

		  case 'view_messages';
	  	  include 'includes/messages_list.php';
		  break;

		  case 'view_guest_chat';
		  include 'includes/support_guest_chats.php';
		  break;

		  case 'view_user_chat';
		  include 'includes/support_user_chats.php';
		  break;

		  case 'view_brand_messages';
		  include 'includes/brand_messages.php';
		  break;

		  case 'view_brand_chat';
		  include 'includes/brand_chat.php';
		  break;

		  case 'view_disputes';
		  include 'includes/disputes.php';
		  break;

		  case 'view_disputes_guest';
		  include 'includes/guest_disputes.php';
		  break;

		  case 'view_dispute_information';
		  include 'includes/dispute_information.php';
		  break;

		  case 'view_guest_dispute_information';
		  include 'includes/dispute_information_guest.php';
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

    <!-------- Footer -------->
  <div class="footer">
    <div class="footer1">
	<img src="../images/logo.png" alt="Project logo" />
	<h5 style="color:lightgrey;"> &copy; <?php echo date('Y');?> - Online Shopping Project By Michal Szatkowski (W1712116) </h5>
    </div> <!--- /.footer1 --->
  </div>

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

<?php } // End Else ?>