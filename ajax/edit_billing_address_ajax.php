

<?php
  session_start();

  $message = '';

  if(isset($_SESSION['user_id'])){

    include '../includes/db.php';

    $user_id = $_POST['user_id'];
    $delivery = $_POST['delivery'];

    $update_user = mysqli_query($con,"update FYP_Users set name='$_POST[name]', country='$_POST[country]', city='$_POST[city]', postcode='$_POST[postcode]', user_address='$_POST[user_address]', contact='$_POST[contact]' where id='$user_id' ");

    if($update_user){
   
	$add_info = trim(mysqli_real_escape_string($con, $_POST['additional_content']));
   	$update_additional = mysqli_query($con,"update FYP_AdditionalNotes set note_content='$add_info' where user_id='$user_id' ");
	$update_deli = mysqli_query($con, "update FYP_Cart set delivery_time='$delivery' where buyer_id='$_SESSION[user_id]'");

   	$message .= "ok";
    } else {
   	$message .= "failed to update";
    }
  
  } else {
    $message .= "logged out";
  }

  $array = array($message);

  echo json_encode($array);

?>