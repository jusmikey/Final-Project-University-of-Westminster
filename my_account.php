
<!---- Header starts ----->
<?php include('includes/header.php'); ?>
<!---- Header ends ----->

  <div class="content_wrapper">
  
  <?php if(isset($_SESSION['user_id'])){ ?>
  
  <div class="user_container">

  <?php if(!isset($_GET['action'])) {
	echo "<script>window.open('my_account.php?action=account','_self')</script>";
    } else {
  ?>

  <?php if($_GET['action'] !='purchase_history' && $_GET['action'] !='view_receipt') { ?>
  
  <div class="user_content">
  
  <?php 
  if(isset($_GET['action'])){
    $action = $_GET['action'];
  } else {
    $action = '';
  }
  
  switch($action){

  case "account";
  include('users/account.php');
  break;
  
  case "dispute_area";
  include('users/dispute_area.php');
  break;

  case "team";
  include('users/team.php');
  break;

  case "edit_account";
  include('users/edit_account.php');
  break;
  
  case "edit_profile";
  include('users/edit_profile.php');
  break;
  
  case "user_profile_picture";
  include('users/user_profile_picture.php');
  break;
  
  case "change_password";
  include('users/change_password.php');
  break;
  
  case "delete_account";
  include('users/delete_account.php');
  break;  
  
  default;
  include('users/account.php');
  break;
  }
  
  ?>
  
  </div><!-- /.user_content -->
  
  <div class="user_sidebar">
  
  <?php 
  $run_image = mysqli_query($con,"select * from FYP_Users where id='$_SESSION[user_id]'");
  
  $row_image = mysqli_fetch_array($run_image);
  
  if($row_image['image'] !=''){  
  ?>
  
  <div class="user_image" align="center">
    <img src="upload-files/<?php echo $row_image['image']; ?>" />
  </div>
  
  <?php } else { ?>
  
  <div class="user_image" align="center">
    <img src="images/userIcon.png" />
  </div>
  
  <?php } ?>
  
  <ul>
    <li><a href="my_account.php?action=purchase_history">Purchase History</a></li>
    <li><a href="my_account.php?action=dispute_area">File an Order Dispute</a></li>
    <li><a href="my_account.php?action=team">Brand Team</a></li>
    <li><a href="my_account.php?action=edit_account">Edit Account</a></li>
    <li><a href="my_account.php?action=edit_profile">Edit Profile</a></li>
    <li><a href="my_account.php?action=user_profile_picture">Profile Picture</a></li>
    <li><a href="my_account.php?action=change_password">Change Password</a></li>
    <li><a href="my_account.php?action=delete_account">Delete Account</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
  
  </div><!-- /.user_sidebar -->

  <?php } elseif($_GET['action'] == 'purchase_history') { ?>
     <?php include 'users/purchase_history.php'; ?>
  <?php } elseif($_GET['action'] == 'view_receipt') { ?>
    <?php include 'users/receipt.php' ?>
  <?php } ?>

  </div><!-- /.user_container-->
  
  <?php }

    } else { ?>

  <div class="account_access" style="text-align:center;">
    <b><p class="reg_message">Register as a consumer to access your account. </p></b>
    <p><a class="login_link" href="index.php?action=login">Log In </a> to Your Account!</p>
    <p><a class="login_link" href="register.php">Register </a> for an Account!</p>
  </div>
  
  <?php } ?>
  
  </div><!-- /.content_wrapper-->
  <!------------ Content wrapper ends -------------->
  
  <?php include ('includes/footer.php'); ?>
  
  
  
  
