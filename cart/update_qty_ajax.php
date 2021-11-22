<?php 

  include '../includes/db.php';

  if(isset($_POST['id'])) {
	$update_qty = mysqli_query($con, "update FYP_Cart set quantity='$_POST[quantity]' where ip_address='$_POST[ip]' and product_id='$_POST[id]'");

	if($update_qty) {
	  echo 1;
	}
  }
  
?>