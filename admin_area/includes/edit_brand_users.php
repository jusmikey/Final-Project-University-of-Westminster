
<?php 

  $brand = mysqli_query($con, "select * from FYP_BrandUsers where brand_id='$_GET[brand_id]'");
  $fetch_brand = mysqli_fetch_array($brand);

  $brand_id = mysqli_query($con, "select * from FYP_Brands where brand_title like '%$fetch_brand[brand_title]'");
  $fetch_bid = mysqli_fetch_array($brand_id);

?>

<div class="container_brand">
<?php
  
  //Remove Brand
  if(isset($_POST['remove'])) {

    $insert_reason = mysqli_query($con, "insert into FYP_BrandRemoval (brand_id,user_id,brand_number,brand_title,brand_country,brand_postcode,brand_contact,register_date,removal_reason,admin_id)
    	values ('$_GET[brand_id]','$fetch_brand[user_id]','$fetch_brand[brand_number]','$fetch_brand[brand_title]','$fetch_brand[brand_country]','$fetch_brand[brand_postcode]','$fetch_brand[brand_contact]','$fetch_brand[register_date]','$_POST[removal_reason]','$_SESSION[user_id]') ");
	
	if($insert_reason) {
	
	  //Removing a brand user
          $remove_com = mysqli_query($con, "delete from FYP_BrandUsers where brand_id='$_GET[brand_id]' ");
	  $remove_pro = mysqli_query($con, "delete from FYP_Products where product_brand='$fetch_bid[brand_id]'");
	  $remove_bid = mysqli_query($con, "delete from FYP_Brands where brand_id='$fetch_bid[brand_id]'");
	  $remove_message = mysqli_query($con, "delete from FYP_BrandServiceChat where brand_id='$_GET[brand_id]'");
	  $remove_team = mysqli_query($con, "delete from FYP_BrandTeams where manager_id='$fetch_brand[user_id]'");

	  if($remove_bid) {
            echo "<script>alert('Brand user has been removed successfully.');</script>";
            echo "<script>window.location.replace('index.php?action=view_brand_users');</script>";
    	  } else {
	    //echo mysqli_error($con);
	    echo "<script>alert('Removing brand user was unsuccessful.');</script>";

	  }
	} else {
	  echo "<script>alert('Removing brand user was unsuccessful.');</script>";
	  //echo mysqli_error($con);
	}
  }

?>

<?php

  //State 'Approved' Brand

  if(isset($_POST['approve'])) {
    $update_brand = mysqli_query($con, "update FYP_BrandUsers set status='Approved' where brand_id='$_GET[brand_id]'");

    $check_exist = mysqli_query($con, "select * from FYP_Brands where brand_title='$fetch_brand[brand_title]'");
    $exist = mysqli_num_rows($check_exist);

    if(!$exist > 0) {
	//Add status if there is no brand
	$insert_brand = mysqli_query($con, "insert into FYP_Brands (brand_title) values ('$fetch_brand[brand_title]')");

	//Send Email of Approved Brand Registration
	$sel_email = mysqli_query($con, "select * from FYP_Users where id='$fetch_brand[user_id]'");
	$fetch_email = mysqli_fetch_array($sel_email);

	$to = "michbodzio97@yahoo.com"; //$fetch_email['email'];
	$subject = "Your Brand Has been Approved!";
	$txt = "Congratulations, your brand business has been approved by our team, and  your products can be displayed to the public" . 
	  "\r\n" . "Please check out how you can manage your brand in the brand area panel." . "\r\n" . "We hope you enjoy your stay.";
	$headers = "Brand Approval | Online Shopping W1712116"; 

	if($insert_brand) {
	  mail($to,$subject,$txt,$headers);
	  echo "<script>alert('This brand user has been approved');</script>";
      	  echo "<script>window.location.replace('index.php?action=edit_brand_users&brand_id=$_GET[brand_id]');</script>";

	} else {
	  echo "<p style='color:white; padding:5px; background:red;'>There has been error with approving this brand user.</p><br>";
	}
    } else {

	//Change status of brand
	$update_brand = mysqli_query($con, "update FYP_Brands set status='Approved' where brand_id='$fetch_bid[brand_id]'");

	if($update_brand) {
	  echo "<script>alert('This brand user has been approved');</script>";
      	  echo "<script>window.location.replace('index.php?action=edit_brand_users&brand_id=$_GET[brand_id]');</script>";

	} else {
	  echo "<p style='color:white; padding:5px; background:red;'>There has been error with approving this brand user.</p><br>";
	}
    }
  } 

  //State 'Pending' Brand

  if(isset($_POST['pending'])) { 
    $update_user_brand = mysqli_query($con, "update FYP_BrandUsers set status='Pending' where brand_id='$_GET[brand_id]'");
    $update_brand = mysqli_query($con, "update FYP_Brands set status='Pending' where brand_id='$fetch_bid[brand_id]'");
    $update_pro = mysqli_query($con, "update FYP_Products set status='Pending' where product_brand='$fetch_bid[brand_id]'");

    if($update_brand && $update_user_brand && $update_pro) {
       	echo "<script>alert('This brand user has been altered.');</script>";
      	echo "<script>window.location.replace('index.php?action=edit_brand_users&brand_id=$_GET[brand_id]');</script>";
    } else {
      	echo "<p style='color:white; padding:5px; background:red;'>There has been error with altering this brand user.</p><br>";
	echo mysqli_error($con);
    }
  }
?>

  <h2>Brand ID: <?php echo $fetch_brand['brand_id']; ?></h2>
  <h2>Brand Title: <?php echo $fetch_brand['brand_title']; ?></h2><br>
  <h3>Business Number: <?php echo $fetch_brand['brand_number']; ?></h3>
  <h3>User ID: <?php echo $fetch_brand['user_id']; ?></h3><br>

  <?php 
    if($fetch_brand['status'] == 'Pending') {
    	echo "<p><b>Status:</b> <a style='color:red;'>Pending</a></p>";
    } else {
    	echo "<p><b>Status:</b> <a style='color:lightgreen;'>Approved</a></p>";
    }
  ?>

  
  <p><b>Created on: </b><?php echo $fetch_brand['register_date']; ?></p><div class="border_bottom"> </div><!-- /.border_bottom -->

  <!------ Brand Information ------>
  <h4>Brand Information:</h4>
  <p><?php echo $fetch_brand['brand_information']; ?></p><br>

  <!---- Address ---->
  <h4>Brand Location:</h4>
  <p><b>City: </b><?php echo $fetch_brand['brand_city']; ?></p>
  <p><b>Country: </b><?php echo $fetch_brand['brand_country']; ?></p>
  <p><b>Postcode: </b><?php echo $fetch_brand['brand_postcode']; ?></p><br>
  <p><b>Brand Contact: </b><?php echo $fetch_brand['brand_contact']; ?></p><div class="border_bottom"> </div><!-- /.border_bottom -->

  <div style="padding:10px; text-align:center;">
    <form action="" method="post"><input style="border:none; cursor:pointer; color:white; background:lightgreen; padding:10px;" type="submit" name="approve" value="Approve"/></form><br>
    <form action="" method="post"><input style="border:none; cursor:pointer; color:white; background:orange; padding:10px;" type="submit" name="pending" value="Pending"/></form><br>
  </div>

    <div class="border_bottom"> </div><!-- /.border_bottom -->

  <div class="reason" style="padding:10px; text-align:center;">
    <b><p>Write a reason of removal..</p></b><br>
    <form action="" method="post">
	<textarea cols="60" rows="8" name="removal_reason" placeholder="Write a reason for removal" required></textarea><br><br>
	<input style="border:none; cursor:pointer; color:white; background:red; padding:10px;" value="Remove Brand" name="remove" type="submit">
    </form>
  </div> <!--- ./reason ---->

    <div class="border_bottom"> </div><!-- /.border_bottom --><br>

<!----- Go back to all brand users section ------>
<a style="float:right; text-decoration:none; color:black; font-size:18px; margin-right:20px;" href="index.php?action=view_brand_users"><i class="fa fa-arrow-left"></i> Go back to all brand users</a>
<br><br>

</div> <!--- /.container_brand --->