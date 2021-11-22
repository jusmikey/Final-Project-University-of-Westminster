<?php 

  $admin_account = mysqli_query($con, "select * from FYP_Users where id='$_SESSION[user_id]'");
  $row = mysqli_fetch_array($admin_account);

?>
<div class="content_container">

<?php

  if(empty($row['name'])) {
    echo "<h2>Welcome to your Admin Account: $row[email]</h2><br>
   	<p><b>Name: Please insert your name in the User Alteration section or in your Consumer Account. </b></p>";
  } else {
    echo "<h2>Welcome to your Admin Account: $row[name]</h2><br>
  	<p><b>Name:</b> $row[name]</p>";
  }

?>


  <p><b>Email:</b> <?php echo $row['email']; ?></p>

<?php 

  // User Address Information
  if(empty($row['user_address'])) {
    echo "<p><b>Your Address:</b> Please insert your address details in the User Alteration section or in your Consumer Account.</p>";
  } else {
    echo "<p><b>Your Address:</b> $row[user_address]</p>";
  }

  // City Information
  if(empty($row['city'])) {
    echo "<p><b>Your City:</b> Please insert your address details in the User Alteration section or in your Consumer Account.</p>";
  } else {
    echo "<p><b>Your City:</b> $row[city]</p>";
  }

  // Country Information
  if(empty($row['country'])) {
    echo "<p><b>Your Country:</b> Please insert your address details in the User Alteration section or in your Consumer Account.</p>";
  } else {
    echo "<p><b>Your Country:</b> $row[country]</p>";
  }

  // Postcode Information
  if(empty($row['postcode'])) {
    echo "<p><b>Your Postcode:</b> Please insert your address details in the User Alteration section or in your Consumer Account.</p>";
  } else {
    echo "<p><b>Your Postcode:</b> $row[postcode]</p>";
  }

  // User Contact Information
  if(empty($row['contact'])) {
    echo "<p><b>Your Contact:</b> Please insert your address details in the User Alteration section or in your Consumer Account.</p>";
  } else {
    echo "<p><b>Your Contact:</b> $row[contact]</p>";
  }

?>

  <br>
  <h3>If you have any queries about the panel, please contact another admin role!<h3>

</div> <!--- /.content_container --->
