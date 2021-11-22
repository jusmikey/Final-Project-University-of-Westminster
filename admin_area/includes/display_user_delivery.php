<style>
  .go_back {
	color:black;
	text-decoration:none;
	float:right;
	font-size:19px;
	cursor:pointer;
	margin-right:10px;
	margin-top:10px;
  }

  .cancel_button {
  	background:red;
	color:white;
	cursor:pointer;
	font-size:16px;
	border:red solid 1px;
  }

  .cancel_button:hover {
  	background:white;
	color:red;
	border:;
  }

  .complete_button {
  	background:lightgreen;
	color:white;
	cursor:pointer;
	font-size:16px;
	border:lightgreen solid 1px;

  }

  .complete_button:hover {
  	background:white;
	color:lightgreen;
  }

  .ongoing_button {
  	background:orange;
	color:white;
	cursor:pointer;
	font-size:16px;
	border:orange solid 1px;

  }

  .ongoing_button:hover {
  	background:white;
	color:orange;
  }

  .go_back:hover {
	color:lightgrey;
  }

</style>

<?php
  $select_consumer = mysqli_query($con, "select * from FYP_Delivery where invoice_id='$_GET[invoice_id]'");
  $row = mysqli_fetch_array($select_consumer);

?>

  <h2>Delivery Information For Invoice ID: <?php echo $_GET['invoice_id']; ?></h2>
  <div class="border_bottom"></div>
  <br>

  <p><b>Consumer Type: </b>User</p>
  <p><b>User ID: </b><?php echo $row['user_id']; ?></p>
  <p><b>User Email: </b><?php echo $row['user_email']; ?></p>
  <br>

  <h3>Order & Billing Information</h3><br>
  <p><b>Name: </b><?php echo $row['name']; ?></p>
  <p><b>Address: </b><?php echo $row['address']; ?></p>
  <p><b>City: </b><?php echo $row['city']; ?></p>
  <p><b>Postcode: </b><?php echo $row['postcode']; ?></p>
  <p><b>Country: </b><?php echo $row['country']; ?></p>
  <p><b>Contact: </b><?php echo $row['contact']; ?></p><br>

  <h3>Delivery Details</h3><br>

  <?php if($row['delivery_status'] == 'Ongoing') {
	  echo "<p style='color:orange;'><b>Delivery Status:</b> Ongoing</p>";
	  
	  if($row['delivery_type'] == 'morning') {
	    echo "<p><b>Delivery Time: 10:00 til 16:00</p>";
	  } else {
	    echo "<p><b>Delivery Time: 16:00 til 21:00</p>";
	  }

	} elseif($row['delivery_status'] == 'Cancelled') {
	  echo "<p style='color:red;'><b>Delivery Status:</b> Cancelled</p>";
	} else {
	  echo "<p style='color:lightgreen;'><b>Delivery Status:</b> Completed</p>";
	} ?>

  <p><b>Delivery Placement Datetime: </b><?php echo $row['delivery_datetime']; ?></p>
  <div class="border_bottom"></div>

  <h3>Update Delivery Status</h3><br>

  <form method="post" action="">
    <input class="cancel_button" type="submit" value="Cancel" name="cancel" />
    <input class="complete_button" type="submit" value="Complete" name="complete" />
    <input class="ongoing_button" type="submit" value="Ongoing" name="ongoing" />

  </form>

  <?php 

    if(isset($_POST['cancel'])) {
	$update_delivery = mysqli_query($con, "update FYP_Delivery set delivery_status='Cancelled' where invoice_id='$_GET[invoice_id]'");

	if($update_delivery) {
	  echo "<script>alert('Updated successfully!') </script>" ;
	  echo "<script>window.open(window.location.href,'_self') </script>";
	} else {
	  echo mysqli_error($con);
	  echo "<script<alert('Error, please try again.')</script>";
	}
    }

    if(isset($_POST['complete'])) {
	$update_delivery = mysqli_query($con, "update FYP_Delivery set delivery_status='Completed' where invoice_id='$_GET[invoice_id]'");

	if($update_delivery) {
	  echo "<script>alert('Updated successfully!') </script>" ;
	  echo "<script>window.open(window.location.href,'_self') </script>";
	} else {
	  echo mysqli_error($con);
	  echo "<script<alert('Error, please try again.')</script>";
	}
    }

    if(isset($_POST['ongoing'])) {
	$update_delivery = mysqli_query($con, "update FYP_Delivery set delivery_status='Ongoing' where invoice_id='$_GET[invoice_id]'");

	if($update_delivery) {
	  echo "<script>alert('Updated successfully!') </script>" ;
	  echo "<script>window.open(window.location.href,'_self') </script>";
	} else {
	  echo mysqli_error($con);
	  echo "<script<alert('Error, please try again.')</script>";
	}
    }

  ?>

  <div class="border_bottom"></div>
  <a class="go_back" href="index.php?action=view_deliveries"><i class="fa fa-arrow-left"></i> Go back to all User Deliveries</a>

  <br>
 
