
<?php 

  include '../includes/db.php'; 

  $message = '';
  $error = '';
  $tx_id = '';
    
     $select_details = mysqli_query($con,"select * from FYP_Guests where guest_ip='$_POST[userIP]'");
     $fetch_details = mysqli_fetch_array($select_details);
     $add_info = trim(mysqli_real_escape_string($con, $fetch_details['additional_information']));          

     $select_cart = mysqli_query($con,"select * from FYP_Cart where ip_address='$_POST[userIP]'");
  
     if(mysqli_num_rows($select_cart) > 0){
 	$tx_id .= uniqid();

  	while($fetch_cart = mysqli_fetch_array($select_cart)){
    	  $quantity = $fetch_cart['quantity'];
	
	  // Insert offline payment data to database
	  $insert_payment = mysqli_query($con,"insert into FYP_Payments (tx_id,product_id, product_price, invoice_id, currency_code, payment_status, payer_email, quantity, amount, type, payment_type, additional_notes) values ('$tx_id','$fetch_cart[product_id]','$fetch_cart[product_price]','$fetch_cart[invoice_number]','GBP', 'pending' ,'$fetch_details[guest_email]','$quantity','$fetch_cart[product_price]','offline','Offline Payment', '$add_info')");  
        
  	}

    	if($insert_payment){
	  
	  $message .= "ok";
  
	}  
  
    } 

  $array = array($message,$tx_id);
  echo json_encode($array);

?>