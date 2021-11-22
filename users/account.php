<?php 
  include("includes/db.php");
?>

<?php 

  $user_account = mysqli_query($con, "select * from FYP_Users where id='$_SESSION[user_id]'");
  $row = mysqli_fetch_array($user_account);

?>

<?php

  if(empty($row['name'])) {
    echo "<h2 style='color:#FFD966;'>Welcome to your account: $row[email]</h2><br>
   	<p><b>Name: You can insert your name during checkout or in your Profile Edit. </b></p>";
  } else {
    echo "<h2 style='color:#FFD966;'>Welcome to your account: $row[name]</h2><br>
  	<p><b>Name:</b> $row[name]</p>";
  }

?>

  <p><b>Email:</b> <?php echo $row['email']; ?></p>

<?php 

  // User Address Information
  if(empty($row['user_address'])) {
    echo "<p><b>Your Address:</b> You can insert your address details during checkout or in your Profile Edit.</p>";
  } else {
    echo "<p><b>Your Address:</b> $row[user_address]</p>";
  }

  // City Information
  if(empty($row['city'])) {
    echo "<p><b>Your City:</b> You can insert your address details during checkout or in your Profile Edit.</p>";
  } else {
    echo "<p><b>Your City:</b> $row[city]</p>";
  }

  // Country Information
  if(empty($row['country'])) {
    echo "<p><b>Your Country:</b> You can insert your address details during checkout or in your Profile Edit.</p>";
  } else {
    echo "<p><b>Your Country:</b> $row[country]</p>";
  }

  // Postcode Information
  if(empty($row['postcode'])) {
    echo "<p><b>Your Postcode:</b> You can insert your address details during checkout or in your Profile Edit.</p>";
  } else {
    echo "<p><b>Your Postcode:</b> $row[postcode]</p>";
  }

  // User Contact Information
  if(empty($row['contact'])) {
    echo "<p><b>Your Contact:</b> You can insert your address details during checkout or in your Profile Edit.</p>";
  } else {
    echo "<p><b>Your Contact:</b> $row[contact]</p>";
  }

?>

  <br>
  <h3 style="color:#FFD966;">We hope you enjoy your online shopping experience!<h3>

