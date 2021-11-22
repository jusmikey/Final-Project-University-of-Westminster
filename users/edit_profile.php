<?php 
  include("includes/db.php");
?>
			
<?php 
  $select_user = mysqli_query($con, "select * from FYP_Users where id='$_SESSION[user_id]'");
  $fetch_user = mysqli_fetch_array($select_user);
?>

<div class="edit_profile_form"> 

  <form method="post" action="" enctype="multipart/form-data"> 

    <h2 style="color:#FFD966;"><b> Edit your account details </b></h2><br>
    <b> Name:</b><br>
    <input type="text" name="name" value="<?php echo $fetch_user['name']; ?>" required placeholder="Name" /><br><br>

    <b> Country:</b><br>
    <select name="edit_country">
	<option> Choose country </option>
	<option value="England"> England </option>
	<option value="Scotland"> Scotland </option>
	<option value="Wales"> Wales </option>
	<option value="Northern Ireland"> Northern Ireland </option>
    </select><br><br>

    <b> Address:</b></td><br>
    <input type="text" name="address" value="<?php echo $fetch_user['user_address']; ?>" required placeholder="Address" /><br><br>

    <b> City:</b><br>
    <input type="text" name="city" value="<?php echo $fetch_user['city']; ?>" required placeholder="City" /><br><br>

    <b> Postcode:</b><br>
    <input type="text" name="postcode" value="<?php echo $fetch_user['postcode']; ?>" required placeholder="Postcode" /><br><br>

    <b> Contact:</b><br>
    <input type="text" name="contact" value="<?php echo $fetch_user['contact']; ?>" required placeholder="Contact" /><br><br>

    <input class="" type="submit" name="edit_profile" value="Update Information" />

  </form>

</div> <!--- /.edit_profile_form --->

<?php 

if(isset($_POST['edit_profile'])){  
  
  if($_POST['name'] !='' && $_POST['edit_country'] !='' && $city = $_POST['city'] !='' && $address = $_POST['address'] !='' && $contact = $_POST['contact'] !=''){
   $name = trim(mysqli_real_escape_string($con, $_POST['name']));
   $country = trim(mysqli_real_escape_string($con, $_POST['edit_country']));
   $city = trim(mysqli_real_escape_string($con, $_POST['city']));
   $postcode = trim(mysqli_real_escape_string($con, $_POST['postcode']));
   $contact = trim(mysqli_real_escape_string($con, $_POST['contact']));
   $address = trim(mysqli_real_escape_string($con, $_POST['address']));   

   $update_profile = mysqli_query($con,"update FYP_Users set name='$name', country='$country', user_address='$address', postcode='$postcode', city='$city', contact='$contact' where id='$_SESSION[user_id]'");
   if($update_profile) {
	echo "<script>alert('Your account information has been changed safely and successfully!')</script>";
	echo "<script>window.open(window.location.href,'_self')</script>";
   } else {
	echo mysqli_error($con);
	echo "<script>alert('There was an error with your information update, please try again later!')</script>";
	echo "<script>window.open(window.location.href,'_self')</script>";
   }
   
  } else {
	echo "<script>alert('Please provide information for all inputs!')</script>";
	echo "<script>window.open(window.location.href,'_self')</script>";
  }
  
}

?>		