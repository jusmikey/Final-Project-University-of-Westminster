
<?php 

  session_start();

  include '../includes/db.php'; 

  $message = '';
  $error = '';
  $tx_id = '';

  if(isset($_SESSION['user_id'])){
	//If user does not have address specified
    
     $select_details = mysqli_query($con,"select * from FYP_Users where id='$_SESSION[user_id]'");
     $fetch_details = mysqli_fetch_array($select_details);
     $name = $fetch_details['name'];
     $country = $fetch_details['country'];
     $city = $fetch_details['city'];
     $postcode = $fetch_details['postcode'];
     $address = $fetch_details['user_address'];
     $contact = $fetch_details['contact'];

     $sel_deli = mysqli_query($con,"select * from FYP_Cart where buyer_id='$_SESSION[user_id]'");
     $fetch_deli = mysqli_fetch_array($sel_deli);
     $delivery = $fetch_deli['delivery_time'];

     $select_cart = mysqli_query($con,"select * from FYP_Cart where ip_address='$_POST[userIP]' and buyer_id='$_POST[userID]' ");

  //If cart is NOT empty
  if(mysqli_num_rows($select_cart) > 0) {
    $tx_id .= uniqid();

     // Getting buyer additional notes
     $select_additional = mysqli_query($con,"select * from FYP_AdditionalNotes where user_id='$_POST[userID]' ");
     $additional_content = '';
 
     if(mysqli_num_rows($select_additional) > 0){
   	$fetch_additional = mysqli_fetch_array($select_additional);
   	$additional_content = trim(mysqli_real_escape_string($con, $fetch_additional['note_content']));
     }

     if(empty($name) || empty($country) || empty($city) || empty($postcode) || empty($address) || empty($contact) || empty($delivery)) {
	$message .= "wrong";
     } else {

	//Locations allowed (POSTCODES / TOWN NAMES / AREA NAMES(Specifically for London))

	//Setting City
	$location_value_city = strtolower($city);
	$location_value_post = strtolower($postcode);

	//London
	$london_locations = array("regent street", "new cavendish street", "cavendish", "regent", "fitzrovia", "marylebone", "great portland");
	$london_postcodes = array("w1b", "w1w", "w1u");

	//Buckighamshire (High Wycombe)
	$highwycombe_locations = array("high wycombe", "amersham", "chesham", "maidenhead", "watlington", "aylesbury", "benson", "marlow", "west wycombe");
	$highwycombe_postcodes = array("hp5","hp6","hp7", "hp8","hp9","hp10","hp11","hp12","hp13", "hp14", "hp15", "hp16","hp17");

	//Surrey (Guildford)
	$guildford_locations = array("guildford", "wordplesdon", "sutton green", "jacobs well", "whitmoor common", "west clandon", "fairlands", "littleton", "artington", "chilworth", "pewley down", "compton", "peasmarsh", "shalford","farncombe", "bramley", "blackheath");
	$guildford_postcodes = array("gu1", "gu2", "gu3", "gu4");

	//Berkshire (Windsor)
	$windsor_locations = array("windsor", "slough", "maidenhead", "old windsor", "holyport", "taplow", "burnham", "holyport", "bray", "dorney", "dorney reach", "eton wick", "boveney", "water oakley", "fifield", "datchet", "woodside", "cranbourne");
	$windsor_postcodes = array("sl1", "sl2", "sl3", "sl4", "sl6");

	//Fetch user first three / four values (sub string)
	$user_explode = str_split($location_value_post, 3); //Fetch first 3 values
	$user_sub = str_split($location_value_post, 4); //Fetch first 4 values

	//False country location to that of products
        $select_cart_country = mysqli_query($con, "select * from FYP_Cart where ip_address='$_POST[userIP]' and buyer_id='$_POST[userID]' and lower(product_country) not like lower('%$fetch_details[country]%')");

	//False country location to that of products
        $select_cart_loc = mysqli_query($con, "select * from FYP_Cart where ip_address='$_POST[userIP]' and buyer_id='$_POST[userID]' and lower(product_location) not like lower('%$fetch_details[city]%')");

	if($location_value_city == 'london' || in_array($user_explode[0], $london_postcodes) || in_array($location_value_city, $highwycombe_locations) 
	  || in_array($user_explode[0], $highwycombe_postcodes) || in_array($user_sub[0], $highwycombe_postcodes) || in_array($location_value_city, $guildford_locations) || in_array($user_explode[0], $guildford_postcodes)
	  || in_array($location_value_city, $windsor_locations) || in_array($user_explode[0], $windsor_postcodes)) {

	  //Eliminate specified locations
	  if($location_value_city == 'london') { 
	    if(in_array($user_explode[0], $london_postcodes) == false) {
		$message .= "invalid postcode";

	    } elseif(mysqli_num_rows($select_cart_country) > 0) {
		$remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$_POST[userIP]' and buyer_id='$_POST[userID]' and lower(product_country) not like lower('%$fetch_details[country]%')");
		$message .= "country";

	    } elseif(mysqli_num_rows($select_cart_loc) > 0) {
		$remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$_POST[userIP]' and buyer_id='$_POST[userID]' and lower(product_location) not like lower('%$fetch_details[city]%')");
		$message .= "city";

	    } else {

		//Insert payment and delivery
 		while($fetch_cart = mysqli_fetch_array($select_cart)){
    	  	  $quantity = $fetch_cart['quantity'];
	
	  	  // Insert offline payment data to database
	  	  $insert_payment = mysqli_query($con,"insert into FYP_Payments (tx_id,product_id, product_price, buyer_id, invoice_id, currency_code, payment_status, payer_email, quantity, amount, type, payment_type, additional_notes)
		    values ('$tx_id','$fetch_cart[product_id]','$fetch_cart[product_price]','$fetch_cart[buyer_id]','$fetch_cart[invoice_number]','GBP','pending','$_SESSION[email]','$quantity','$fetch_cart[product_price]','offline','Offline Payment', '$additional_content')");

	  	  //Insert delivery information to database
	  	  $insert_delivery = mysqli_query($con, "insert into FYP_Delivery (invoice_id, user_id, user_email, name, address, city, postcode, country, contact, add_info, delivery_type)
		    values ('$fetch_cart[invoice_number]', '$_SESSION[user_id]', '$_SESSION[email]', '$name', '$address', '$city', '$postcode', '$country', '$contact', '$additional_content', '$fetch_cart[delivery_time]')");

        	}
  
    		if($insert_payment){
	  	  // Deleting products from the cart 
	  	  $remove_cart = mysqli_query($con,"delete from FYP_Cart where buyer_id='$_POST[userID]' and ip_address='$_POST[userIP]' ");

	  	  // Removing additional notes
	  	  $remove_addition = mysqli_query($con,"delete from FYP_AdditionalNotes where user_id='$_POST[userID]'");
	  
	  	  $message .= "ok";
		} 
	   }

	  } elseif(in_array($location_value_city, $highwycombe_locations)) {
	     if(in_array($user_explode[0], $highwycombe_postcodes) == false && in_array($user_sub[0], $highwycombe_postcodes) == false) {
		$message .= "invalid postcode";

	     } elseif(mysqli_num_rows($select_cart_country) > 0) {
		$remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$_POST[userIP]' and buyer_id='$_POST[userID]' and lower(product_country) not like lower('%$fetch_details[country]%')");
		$message .= "country";

	     } elseif(mysqli_num_rows($select_cart_loc) > 0) {
		$remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$_POST[userIP]' and buyer_id='$_POST[userID]' and lower(product_location) not like lower('%$fetch_details[city]%')");
		$message .= "city";

	     } else {

		//Insert payment and delivery
 		while($fetch_cart = mysqli_fetch_array($select_cart)){
    	  	  $quantity = $fetch_cart['quantity'];
	
	  	  // Insert offline payment data to database
	  	  $insert_payment = mysqli_query($con,"insert into FYP_Payments (tx_id,product_id, product_price, buyer_id, invoice_id, currency_code, payment_status, payer_email, quantity, amount, type, payment_type, additional_notes)
		    values ('$tx_id','$fetch_cart[product_id]','$fetch_cart[product_price]','$fetch_cart[buyer_id]','$fetch_cart[invoice_number]','GBP','pending','$_SESSION[email]','$quantity','$fetch_cart[product_price]','offline','Offline Payment', '$additional_content')");

	  	  //Insert delivery information to database
	  	  $insert_delivery = mysqli_query($con, "insert into FYP_Delivery (invoice_id, user_id, user_email, name, address, city, postcode, country, contact, add_info, delivery_type)
		    values ('$fetch_cart[invoice_number]', '$_SESSION[user_id]', '$_SESSION[email]', '$name', '$address', '$city', '$postcode', '$country', '$contact', '$additional_content', '$fetch_cart[delivery_time]')");

        	}
  
    		if($insert_payment){
	  	  // Deleting products from the cart 
	  	  $remove_cart = mysqli_query($con,"delete from FYP_Cart where buyer_id='$_POST[userID]' and ip_address='$_POST[userIP]' ");

	  	  // Removing additional notes
	  	  $remove_addition = mysqli_query($con,"delete from FYP_AdditionalNotes where user_id='$_POST[userID]'");
	  
	  	  $message .= "ok";
		} 
	   }

	  } elseif(in_array($location_value_city, $guildford_locations)) {
	    if(in_array($user_explode[0], $guildford_postcodes) == false) {
		$message .= "invalid postcode";

	    } elseif(mysqli_num_rows($select_cart_country) > 0) {
		$remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$_POST[userIP]' and buyer_id='$_POST[userID]' and lower(product_country) not like lower('%$fetch_details[country]%')");
		$message .= "country";

	    } elseif(mysqli_num_rows($select_cart_loc) > 0) {
		$remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$_POST[userIP]' and buyer_id='$_POST[userID]' and lower(product_location) not like lower('%$fetch_details[city]%')");
		$message .= "city";

	    } else {

		//Insert payment and delivery
 		while($fetch_cart = mysqli_fetch_array($select_cart)){
    	  	  $quantity = $fetch_cart['quantity'];
	
	  	  // Insert offline payment data to database
	  	  $insert_payment = mysqli_query($con,"insert into FYP_Payments (tx_id,product_id, product_price, buyer_id, invoice_id, currency_code, payment_status, payer_email, quantity, amount, type, payment_type, additional_notes)
		    values ('$tx_id','$fetch_cart[product_id]','$fetch_cart[product_price]','$fetch_cart[buyer_id]','$fetch_cart[invoice_number]','GBP','pending','$_SESSION[email]','$quantity','$fetch_cart[product_price]','offline','Offline Payment', '$additional_content')");

	  	  //Insert delivery information to database
	  	  $insert_delivery = mysqli_query($con, "insert into FYP_Delivery (invoice_id, user_id, user_email, name, address, city, postcode, country, contact, add_info, delivery_type)
		    values ('$fetch_cart[invoice_number]', '$_SESSION[user_id]', '$_SESSION[email]', '$name', '$address', '$city', '$postcode', '$country', '$contact', '$additional_content', '$fetch_cart[delivery_time]')");

        	}
  
    		if($insert_payment){
	  	  // Deleting products from the cart 
	  	  $remove_cart = mysqli_query($con,"delete from FYP_Cart where buyer_id='$_POST[userID]' and ip_address='$_POST[userIP]' ");

	  	  // Removing additional notes
	  	  $remove_addition = mysqli_query($con,"delete from FYP_AdditionalNotes where user_id='$_POST[userID]'");
	  
	  	  $message .= "ok";
		} 
	   }

	  } elseif(in_array($location_value_city, $windsor_locations)) {
	    if(in_array($user_explode[0], $windsor_postcodes) == false) {
		$message .= "invalid postcode";

	    } elseif(mysqli_num_rows($select_cart_country) > 0) {
		$remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$_POST[userIP]' and buyer_id='$_POST[userID]' and lower(product_country) not like lower('%$fetch_details[country]%')");
		$message .= "country";

	    } elseif(mysqli_num_rows($select_cart_loc) > 0) {
		$remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$_POST[userIP]' and buyer_id='$_POST[userID]' and lower(product_location) not like lower('%$fetch_details[city]%')");
		$message .= "city";

	    } else {

		//Insert payment and delivery
 		while($fetch_cart = mysqli_fetch_array($select_cart)){
    	  	  $quantity = $fetch_cart['quantity'];
	
	  	  // Insert offline payment data to database
	  	  $insert_payment = mysqli_query($con,"insert into FYP_Payments (tx_id,product_id, product_price, buyer_id, invoice_id, currency_code, payment_status, payer_email, quantity, amount, type, payment_type, additional_notes)
		    values ('$tx_id','$fetch_cart[product_id]','$fetch_cart[product_price]','$fetch_cart[buyer_id]','$fetch_cart[invoice_number]','GBP','pending','$_SESSION[email]','$quantity','$fetch_cart[product_price]','offline','Offline Payment', '$additional_content')");

	  	  //Insert delivery information to database
	  	  $insert_delivery = mysqli_query($con, "insert into FYP_Delivery (invoice_id, user_id, user_email, name, address, city, postcode, country, contact, add_info, delivery_type)
		    values ('$fetch_cart[invoice_number]', '$_SESSION[user_id]', '$_SESSION[email]', '$name', '$address', '$city', '$postcode', '$country', '$contact', '$additional_content', '$fetch_cart[delivery_time]')");

        	}
  
    		if($insert_payment){
	  	  // Deleting products from the cart 
	  	  $remove_cart = mysqli_query($con,"delete from FYP_Cart where buyer_id='$_POST[userID]' and ip_address='$_POST[userIP]' ");

	  	  // Removing additional notes
	  	  $remove_addition = mysqli_query($con,"delete from FYP_AdditionalNotes where user_id='$_POST[userID]'");
	  
	  	  $message .= "ok";
		} 
	   }
	  }
	} else { //If location is false
	  $message .= "invalid delivery location"; 
	}

     } //If empty delivery info

  } else { //If cart is empty
      	$error .= "empty"; 
  	$tx_id .= 0;
  }

  } else {
    $message .= "logged out";
  }

  $array = array($message,$error,$tx_id);
  echo json_encode($array);

?>