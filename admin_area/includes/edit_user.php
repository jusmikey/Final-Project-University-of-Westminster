<h2>Edit User Role & Information</h2>
  <div class="border_bottom"></div><br>

<?php 
  $select_user = mysqli_query($con, "select * from FYP_Users where id='$_GET[user_id]'");
  $fetch_user = mysqli_fetch_array($select_user);

  //Change User Role

  if(isset($_POST['guest'])) {
    if($fetch_user['role'] == 'guest') {
	echo "<script>alert('Role is already set as Guest.')</script>";
    } else {
    	$update_guest = mysqli_query($con, "update FYP_Users set role='guest' where id='$_GET[user_id]'");

    	if($update_guest) {
	  echo "<script>alert('Role as Guest is set successfully.')</script>";
          echo "<script>window.location.replace('index.php?action=edit_user&user_id=$_GET[user_id]');</script>";

    	} else {
	  echo mysqli_error($con);
	}
    }
  }

  if(isset($_POST['admin'])) {
    if($fetch_user['role'] == 'admin') {
	echo "<script>alert('Role is already set as Admin.')</script>";
    } else {
    	$update_admin = mysqli_query($con, "update FYP_Users set role='admin' where id='$_GET[user_id]'");

    	if($update_admin) {
	  echo "<script>alert('Role as Admin is set successfully.')</script>";
          echo "<script>window.location.replace('index.php?action=edit_user&user_id=$_GET[user_id]');</script>";
    	} else {
	  echo mysqli_error($con);
	}
    }
  }


?>

  <h3>User Information</h3><br>
  <p><b>User ID: </b><?php echo $fetch_user['id']; ?></p>
  <p><b>Role: </b><?php echo $fetch_user['role']; ?></p>
  <p><b>Name: </b><?php echo $fetch_user['name']; ?></p>
  <p><b>Email: </b><?php echo $fetch_user['email']; ?></p>
  <p><b>Contact: </b><?php echo $fetch_user['contact']; ?></p>
  <p><b>Register Date: </b><?php echo $fetch_user['registerDateTime']; ?></p><br>
  <div class="border_bottom"></div>

  <!--- Edit User Information --->
  <div style="padding:20px; text-align:center;">
    <h3>Edit User Information</h3><br>

    <form action="" method="post">
	Name: <input type="text" name="name" placeholder="Name of User" value="<?php echo $fetch_user['name']; ?>" required/>
	<input type="submit" name="edit_name" value="Change" /><br><br>

	Email: <input type="email" name="email" placeholder="Email of User" value="<?php echo $fetch_user['email']; ?>" required/>
	<input type="submit" name="edit_email" value="Change" /><br><br>

	Contact: <input type="number" name="contact" placeholder="Contact of User" value="<?php echo $fetch_user['contact']; ?>" required/>
	<input type="submit" name="edit_contact" value="Change" /><br><br>

	Address: <input type="text" name="address" placeholder="Address of User" value="<?php echo $fetch_user['user_address']; ?>" required/>
	<input type="submit" name="edit_address" value="Change" /><br><br>

	City: <input type="text" name="city" placeholder="City of User" value="<?php echo $fetch_user['city']; ?>" required/>
	<input type="submit" name="edit_city" value="Change" /><br><br>

	Country: <input type="text" name="country" placeholder="Country of User" value="<?php echo $fetch_user['country']; ?>" required/>
	<input type="submit" name="edit_country" value="Change" /><br><br>

	Postcode: <input type="text" name="postcode" placeholder="Postcode of User" value="<?php echo $fetch_user['postcode']; ?>" required/>
	<input type="submit" name="edit_postcode" value="Change" /><br><br>
    </form>
  <div class="border_bottom"></div>

  <!--- Set Role --->
  <div style="padding:20px; text-align:center;">
    <h3>Change Role</h3><br>
    <form action="" method="post"><input style="border:none; cursor:pointer; color:white; background:blue; font-size:18px; padding:10px;" type="submit" name="guest" value="Set to Consumer"/></form><br>
    <form action="" method="post"><input style="border:none; cursor:pointer; color:white; background:orange; font-size:18px; padding:10px;" type="submit" name="admin" value="Set to Admin"/></form><br>
  </div>
  <div class="border_bottom"></div><br>


    <?php

	//Update user information 

    	//if(isset($_POST['edit_submit'])) {

	  if(isset($_POST['edit_name'])) {
	    $name = $_POST['name'];
	    $update_name = mysqli_query($con, "update FYP_Users set name='$name' where id='$_GET[user_id]'");
		
		if($update_name) {
		  echo "<script>alert('Name changed successfully.');</script>";
            	  echo "<script>window.location.replace('index.php?action=edit_user&user_id=$_GET[user_id]');</script>";
		} else {
		  //echo mysqli_error($con);
		  echo "<script>alert('Name unable to change, please try again.');</script>";
		}
	  }

	  if(isset($_POST['edit_email'])) {
	    $email = $_POST['email'];

	    //If updated email already exists...
	    $check_exist = mysqli_query($con, "select * from FYP_Users where email='$email'");
	    $email_count = mysqli_num_rows($check_exist);

	    if($email_count > 0) {
	       echo "<script>alert('Email already exists.');</script>";
	    } else {
  		$update_email = mysqli_query($con, "update FYP_Users set email='$email' where id='$_GET[user_id]'");
		
		if($update_email) {
		  echo "<script>alert('Email changed successfully.');</script>";
            	  echo "<script>window.location.replace('index.php?action=edit_user&user_id=$_GET[user_id]');</script>";
		} else {
		  //echo mysqli_error($con);
		  echo "<script>alert('Email unable to change, please try again.');</script>";
		}
	    }
	  }

	  if(isset($_POST['edit_contact'])) {
	    $contact = $_POST['contact'];

	    //If contact number already exists
	    $check_contact = mysqli_query($con, "select * from FYP_Users where contact='$contact'");
	    $contact_count = mysqli_num_rows($check_contact);

	    if($contact_count > 0) { 
	      	echo "<script>alert('Contact already exists.');</script>";
	    } else {
	      	$update_contact = mysqli_query($con, "update FYP_Users set contact='$contact' where id='$_GET[user_id]'");
		
		if($update_contact) {
		  echo "<script>alert('Contact changed successfully.');</script>";
            	  echo "<script>window.location.replace('index.php?action=edit_user&user_id=$_GET[user_id]');</script>";
		} else {
		  //echo mysqli_error($con);
		  echo "<script>alert('Contact number unable to change, please try again.');</script>";
		}
	    }
	  }

	  if(isset($_POST['edit_address'])) {
	    $address = $_POST['address'];
	    $update_address = mysqli_query($con, "update FYP_Users set user_address='$address' where id='$_GET[user_id]'");
		
		if($update_address) {
		  echo "<script>alert('Address changed successfully.');</script>";
            	  echo "<script>window.location.replace('index.php?action=edit_user&user_id=$_GET[user_id]');</script>";
		} else {
		  //echo mysqli_error($con);
		  echo "<script>alert('Address unable to change, please try again.');</script>";
		}
	  }

	  if(isset($_POST['edit_city'])) {
	    $city = $_POST['city'];
	    $update_city = mysqli_query($con, "update FYP_Users set city='$city' where id='$_GET[user_id]'");
		
		if($update_city) {
		  echo "<script>alert('City changed successfully.');</script>";
            	  echo "<script>window.location.replace('index.php?action=edit_user&user_id=$_GET[user_id]');</script>";
		} else {
		  //echo mysqli_error($con);
		  echo "<script>alert('City unable to change, please try again.');</script>";
		}
	  }

	  if(isset($_POST['edit_country'])) {
	    $country = $_POST['country'];
	    $update_country = mysqli_query($con, "update FYP_Users set country='$country' where id='$_GET[user_id]'");
		
		if($update_country) {
		  echo "<script>alert('Country changed successfully.');</script>";
            	  echo "<script>window.location.replace('index.php?action=edit_user&user_id=$_GET[user_id]');</script>";
		} else {
		  //echo mysqli_error($con);
		  echo "<script>alert('Country unable to change, please try again.');</script>";
		}
	  }

	  if(isset($_POST['edit_postcode'])) {
	    $postcode = $_POST['postcode'];
	    $update_postcode = mysqli_query($con, "update FYP_Users set postcode='$postcode' where id='$_GET[user_id]'");
		
		if($update_postcode) {
		  echo "<script>alert('Postcode changed successfully.');</script>";
            	  echo "<script>window.location.replace('index.php?action=edit_user&user_id=$_GET[user_id]');</script>";
		} else {
		  //echo mysqli_error($con);
		  echo "<script>alert('Postcode unable to change, please try again.');</script>";
		}
	  }	  

  	//}

    ?>

  </div>
  <br>

  <p style="float:right; margin-right:20px; font-size:18px;"><a style="color:black; text-decoration:none;" href="index.php?action=view_users"><i class="fa fa-arrow-left"></i> Go back to all users</a></p><br><br>