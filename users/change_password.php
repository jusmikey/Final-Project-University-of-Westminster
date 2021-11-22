<script>
 $(document).ready(function(){
  
  $("#password_confirm2").on('keyup',function(){   
   
   var password_confirm1 = $("#password_confirm1").val();
   
   var password_confirm2 = $("#password_confirm2").val();
   
   //alert(password_confirm2);
   
   if(password_confirm1 == password_confirm2){
   
    $("#status_for_confirm_password").html('<strong style="color:green">Password match</strong>');
   
   }else{
    $("#status_for_confirm_password").html('<strong style="color:red">Password do not match</strong>');
   
   }
   
  });
  
 });
</script>

<?php 

  $select_user = mysqli_query($con,"select * from FYP_Users where id='$_SESSION[user_id]' ");
  $fetch_user = mysqli_fetch_array($select_user);

?>
	
<div class="change_password_box">

  <form method = "post" action="" enctype="multipart/form-data">
    
    <h2 style="color:#FFD966;">Change Password.</h2><br>
	   
    <b>Current Password:</b></td><br>
    <input type="password" name="current_password" required placeholder="Current Password" /><br><br>
  
    <b>New Password:</b><br>
    <input type="password" id="password_confirm1" name="new_password" required placeholder="New Password" /><br><br>
	  
    <b>Re-type New Password:</b><br>
    <input type="password" id="password_confirm2" name="confirm_new_password" required placeholder="Re-Type New Password" /><br><br>

    <p id="status_for_confirm_password"></p><!-- Showing validate password here -->
	  
    <input type="submit" name="change_password" value="Update Password" />	
	
  </form>

</div> <!---- /.change_password_box ---->

<?php 
  if(isset($_POST['change_password'])){   
   
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_new_password = trim($_POST['confirm_new_password']);

    $select_user = mysqli_query($con, "select * from FYP_Users where id='$_SESSION[user_id]'");
    $fetch = mysqli_fetch_array($select_user);

    //Password Conditions
    $pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';

    //Validate current password of the user
    if(password_verify($current_password, $fetch['password'])) {

	//Check if new password suits the pattern condition
	if(preg_match($pattern, $new_password)) {

	  //check if confirmation password matches new password
	  if($new_password == $confirm_new_password) {
	
	    //Hash passwords for secure encryption
	    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

	    $update_pass = mysqli_query($con, "update FYP_Users set password='$hashed_password' where id='$_SESSION[user_id]'");
	
	    if($update_pass) {
	      echo "<script>alert('Password was successfully updated..')</script>";
	      echo "<script>window.open(window.location.href,'_self')</script>";
	    } else {
	      echo "<script>alert('Password failed to update, try again..')</script>";
	      echo "<script>window.open(window.location.href,'_self')</script>";
	    }

	  } else {
	    echo "<script>alert('Passwords do not match to one another, try again..')</script>";
	    echo "<script>window.open(window.location.href,'_self')</script>";

	  }
	} else {
	  echo "<script>alert('Password requires a number, a capital letter, a special character, and more than 8 characters long...')</script>";
	  echo "<script>window.open(window.location.href,'_self')</script>";

	}
    } else {
	echo "<script>alert('Current Password is not valid..')</script>";
	echo "<script>window.open(window.location.href,'_self')</script>";

    }
     
 }

?>