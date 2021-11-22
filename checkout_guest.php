<!---- Header starts ----->
<?php include('includes/header.php'); ?>
<!----- Header ends ----->

<!----- Content wrapper starts ----->

  <?php if($_GET['payment'] != 'payment-successful'){
 
    if(!isset($_GET['location']) || $_GET['location'] == '') {
	echo "<script>alert('Please specify a location to continue with purchase.')</script>";
	echo "<script>window.location.replace('index.php');</script>";
    } 

    $invoice_number = mt_rand();
    $ip = get_ip();

    $update_cart = mysqli_query($con,"update FYP_Cart set invoice_number='$invoice_number' where ip_address='$ip' ");
	  
    $sel_pro_loc = mysqli_query($con, "select * from FYP_Cart where ip_address='$ip'");
    $fetch_pro_loc = mysqli_fetch_array($sel_pro_loc);

    $sel_guest = mysqli_query($con, "select * from FYP_Guests where guest_ip='$ip' ");
    $fetch_sel_guest = mysqli_fetch_array($sel_guest);

    if(mysqli_num_rows($sel_pro_loc) == 0) {
	//echo "<script>alert('There are no products in your cart..')</script>";
	//echo "<script>window.open(window.location.href,'_self') </script>";
    } 
  ?>

  <div class="content_wrapper">	

    <div class="checkout_container">
	<h3> <a class="continue_shopping_checkout" href="all_products.php?location=<?php echo $_GET['location'];?>"><i class="fa fa-arrow-left"></i> Continue Shopping</a></h3>

	<div class="load_checkout_message"></div><!--/.load_checkout_message-->
	  
	<div class="checkout_header">
	  <h1>Your Order Checkout</h1>
	 </div><!---/.checkout_header -->

	    <div class="check_image" >
	      <img width="100%" height="200px" src="images/vg_pay.png" alt="Firstly observe your chosen products, make sure your location is valid, otherwise products are removed. Choose payment method." />
	    </div> <!--- ./check_image --->

 	<div class="checkout_left">
	  
  	  <div class="checkout_left_box">
	    <h3>Total Items In Your Cart (<?php total_items();?>)</h3>
	  </div><!--/.checkout_left_box -->

	  <?php 
	  
	    $sel_cart = mysqli_query($con,"select * from FYP_Cart where ip_address='$ip' ");
	  
	    while($fetch_cart = mysqli_fetch_array($sel_cart)){
	  
	  	$sel_product = mysqli_query($con,"select * from FYP_Products where product_id='$fetch_cart[product_id]'");
	  
	  	while($fetch_product = mysqli_fetch_array($sel_product)){
	  
	    ?>
	  
	  <div class="checkout_left_product_box">
	    <img src="admin_area/product_images/<?php echo $fetch_product['product_image']; ?>">
	    <p class="checkout_left_title"><?php echo $fetch_product['product_title']; ?></p>

	  <?php 

	    if($fetch_product['product_category'] == 25) {
	    	echo "<b><p style='color:red;'>(+18) Alcoholic Bevarage</p></b>"; 
	    } 

	    //If product on Offer
	    $offer_price = number_format($fetch_product['offer_price'], 2);
	    $pro_price = number_format($fetch_product['product_price'], 2);

	    if($fetch_product['product_offer'] == 'on') {
		echo "<b><p style='color:red'>Offer Price: &#163;$offer_price</p></b>";
		echo "<p style='color:black'>Original Price: &#163;$pro_price</p>";
		echo "<b><p style='font-size:14px;'>Quantity: $fetch_cart[quantity]</p></b>";
	    } else {
		echo "<b><p style='color:black'>Price: &#163;$pro_price</p></b>";
		echo "<b><p style='font-size:14px;'>Quantity: $fetch_cart[quantity]</p></b>";
	    }

	  ?>

	  </div><!-- /.checkout_left_product_box -->
	  
	  <?php } } ?>
	  
	  </div><!-- /.checkout_left -->

	  <div class="checkout_right">
	  
	    <div class="checkout_right_box">
	  
	  	<div class="checkout_total_price">
	  	  <p style="font-size:20px; color:#FFD966;">Total Order Amount: <?php total_price(); ?></p>   
	  	</div>
	  
	  	<br><h4 style="margin:10px 0">Please choose your preferred method of payment.</h4>
	  
		<!------ PayPal Payment Method ------>
	  	<div class="payment_method_container">
	  	  <div class="payment_method_box">
	    
		    <div class="payment_method_header accordion-toggle payment_method_paypal">
			<input type="radio" id="paypal_radio" name="paypal_radio" value="paypal" checked><img src="images/pp-logo-100px.png">
		    </div><!---/.payment_method_header-->
		
		    <div class="payment_method_body payment_method_body_paypal accordion-content">
		 	<p>In order to complete your transaction, we will transfer you over to Paypal's secure servers.</p>
		 
		 	<div class="payment_gateway_box">
			
			<?php 

			  if(mysqli_num_rows($sel_guest) <= 0) {
			    echo "<h3>Please insert / update your delivery and billing information.<h3>";
			  } elseif(mysqli_num_rows($sel_pro_loc) == 0) {
			    echo "<h3>Your cart is empty, please choose products.</h3>";
			  } elseif(empty($fetch_pro_loc['delivery_time'])) {
			    echo "<h3>Please select delivery information..</h3>";
			  } else {
			    include('guest/payment.php'); 
			  } ?>
	     	  	</div>
		 
		 	<div class="paypal_text_box">
		  	  <div class="paypal__text">
		   	    <p>By completing your purchase, you agree to these <a href="" target="_blank" style="text-decoration:none; color:#FFD966; font-weight:bold;">Terms of Service.</a></p>
		 	  </div>
		  
		  	  <div class="paypal__lock">
		   	    <i class="fa fa-lock"></i><span> Secure Conection</span>
		  	  </div>
		  
		 	</div><!--/.paypal_text_box-->
		 
		      </div><!--/.payment_method_body-->
		
	  	  </div><!--/.payment_method_box------->
	  	</div><!---/.payment_method_container------------->

		<!------- Offline Method Payment ------->
		<div class="payment_method_container">
	  	  <div class="payment_method_box">
	    
		    <div class="payment_method_header accordion-toggle payment_method_offline">
			<input type="radio" id="offline_payment_radio" name="offline_payment_radio" value="offline_payment"><span>Offline Payment Methods (Bank Transfer, Cash on Delivery, Money Orders...)</span>
		    </div><!---/.payment_method_header-->
		
		    <div class="payment_method_body payment_method_body_offline accordion-content" style="display:none">
		 
		 	<div class="payment_gateway_box">
	     
		 	  <div class="payment_offline_form_box">

		  	    <div class="payment_offline_btn_box">

			    <?php 
			  	if(mysqli_num_rows($sel_guest) <= 0) {
			    	  echo "<h3>Please insert / update your delivery and billing information.<h3>";
				} elseif(mysqli_num_rows($sel_pro_loc) == 0) {
			    	  echo "<h3>Your cart is empty, please choose products.</h3>";
				} elseif(empty($fetch_pro_loc['delivery_time'])) {
			    	  echo "<h3>Please select delivery information..</h3>";
			  	} else { ?>
		   	  	<button id="payment_offline_btn">Complete Order <i class="fa fa-arrow-circle-right"></i></button>
			    <?php } 
			    ?>

		  	    </div> <!--- /.payment_offline_btn_box --->

		 	    <div class="paypal_text_box">
		  		<div class="paypal__text">
		   		  <p>By completing your purchase, you agree to these <a href="" target="_blank" style="text-decoration:none; color:#FFD966; font-weight:bold;">Terms of Service.</a></p>
		  	      	</div> <!---- /.paypal__text ----> 
		  
		 	    </div> <!--- /.paypal_text_box --->

	     		  </div> <!--- /. payment_offline_form_box--->

			</div> <!---- /.payment_gateway_box ----> 
		 
		    </div><!--/.payment_method_body-->
		
		  </div><!--/.payment_method_box------->
		</div><!---/.payment_method_container------------->

	  </div><!-- /.checkout_right_box -->

	<!------ Delivery and Billing Information ------>

	<h2 style="color:#FFD966; margin-left:20px;">Your Delivery and Billing Information</h2><br>
	<?php 
	  $sel_num = mysqli_num_rows($sel_guest);

	  if($sel_num <= 0) { ?>

	<div id="insert_bill" class="billing_info">

 	
	  <form method="POST" action="">
		<p>Your Name: <input type="text" name="name" required /></p><br> 
		<p>Email: <input type="email" name="email" required /></p><br> 
		<p>Address: <input type="text" name="address" required /></p><br> 
		<p>City: <input type="text" name="city" required /></p><br> 
		<p>Postcode: <input type="text" name="postcode" required /></p><br>

		<p>Country:    
		  <select name="country">
		    <option value="0"> Choose country </option>
		    <option value="England"> England </option>
		    <option value="Scotland"> Scotland </option>
		    <option value="Wales"> Wales </option>
		    <option value="Northern Ireland"> Northern Ireland </option>
    		  </select></p><br>
 
		<p>Contact: <input type="tel" name="contact" required /></p><br>

		<!---- Delivery Type ---->
		<h4>Delivery Times </h4>
		<p>All order deliveries take place 24hours after your order purchase.</p>
		<input type="radio" id="morning" name="delivery" value="morning">
		<label for="morning">10:00 til 16:00</label><br>
		<input type="radio" id="afternoon" name="delivery" value="afternoon">
		<label for="afternoon">16:00 til 21:00</label><br><br>
 
		<h3>Additional Consumer Information For Delivery</h3>
		<textarea id="guest_info1" name="add_info" placeholder="Specify any additional delivery information here.." rows="7" cols="60" ></textarea> 

		<p><input class="submit_guest_info1" type="submit" name="submit" value="Submit Information" /></p><br>
	  </form>
	</div>

	  <?php } else {

	    $guests = mysqli_query($con, "select * from FYP_Guests where guest_ip='$ip'");

	    $fetch_pros_cart = mysqli_fetch_array($guests);
	    $select_cart = mysqli_query($con, "select * from FYP_Cart where ip_address='$ip' and lower(product_location) not like lower('%$fetch_pros_cart[guest_city]%')");
	    $cart_num_rows = mysqli_num_rows($select_cart);

	    if($cart_num_rows > 0) {
		$remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and lower(product_location) not like lower('%$fetch_pros_cart[guest_city]%')");
		echo "<script>alert('Products found in your cart with different location were removed.')</script>";
		echo "<script>window.open(window.location.href,'_self') </script>";
	    }

	    $edit_guests = mysqli_query($con, "select * from FYP_Guests where guest_ip='$ip'");

	    while($fetch_guest = mysqli_fetch_array($edit_guests)) { ?>
	
	    <div id="insert_bill" class="billing_info">

	      <form method="POST" action="">
		<p>Your Name: <input type="text" name="update_name" value="<?php echo $fetch_guest['guest_name']; ?>" required /></p><br> 
		<p>Email: <input type="email" name="update_email" value="<?php echo $fetch_guest['guest_email']; ?>" required /></p><br> 
		<p>Address: <input type="text" name="update_address" value="<?php echo $fetch_guest['guest_address']; ?>" required /></p><br> 
		<p>City: <input type="text" name="update_city" value="<?php echo $fetch_guest['guest_city']; ?>" required /></p><br> 
		<p>Postcode: <input type="text" name="update_postcode" value="<?php echo $fetch_guest['guest_postcode']; ?>" required /></p><br>
		<p>Country: <input type="text" name="update_country" value="<?php echo $fetch_guest['guest_country']; ?>" required /></p><br> 
		<p>Contact: <input type="tel" name="update_contact" value="<?php echo $fetch_guest['guest_contact']; ?>" required /></p><br>

		<!---- Delivery Type ---->
		<h4>Delivery Times </h4>
		<p>All order deliveries take place 24hours after your order purchase.</p>

		<?php if(!mysqli_num_rows($sel_pro_loc) == 0) { ?>
		
		  <?php if($fetch_pro_loc['delivery_time'] == 'morning') { ?>
		<input type="radio" id="morning" name="update_delivery" value="morning" checked />
		<label for="morning">10:00 til 16:00</label><br>
		<input type="radio" id="afternoon" name="update_delivery" value="afternoon" />
		<label for="afternoon">16:00 til 21:00</label><br><br>

		<?php } elseif($fetch_pro_loc['delivery_time'] == 'afternoon') { ?>
		<input type="radio" id="morning" name="update_delivery" value="morning" />
		<label for="morning">10:00 til 16:00</label><br>
		<input type="radio" id="afternoon" name="update_delivery" value="afternoon" checked />
		<label for="afternoon">16:00 til 21:00</label><br><br>

		<?php } else { ?>
		<input type="radio" id="morning" name="update_delivery" value="morning"/>
		<label for="morning">10:00 til 16:00</label><br>
		<input type="radio" id="afternoon" name="update_delivery" value="afternoon"/>
		<label for="afternoon">16:00 til 21:00</label><br><br>

		<?php } } ?>

		<h3>Additional Consumer Information For Delivery</h3>
		<textarea id="guest_info1" name="update_add_info" rows="7" cols="60" ><?php echo $fetch_guest['additional_information']; ?></textarea> 

		<p><input class="submit_guest_info1" type="submit" name="update" value="Update" /></p><br>
	      </form>

	    </div> <!---- /.bill_info ---->

	  <?php }
	    } ?>

	  <?php
	    if(isset($_POST['submit'])) {

		$country = $_POST['country'];
		$add_info = trim(mysqli_real_escape_string($con, $_POST['add_info']));

		if(!isset($_POST['delivery'])) {
		    echo "<script>alert('Delivery Information was not set. Please try again.');</script>";
	  	    echo "<script>window.open(window.location.href,'_self') </script>";
		} elseif($country == "0") {
		    echo "<script>alert('Country location was not set. Please try again.');</script>";
	  	    echo "<script>window.open(window.location.href,'_self') </script>";
		} else {

		  $delivery = $_POST['delivery'];
		
		  //Remove products if country is false
	    	  $remove_country = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and lower(product_country) not like lower('%$country%')");

	  	  //Locations allowed (POSTCODES / TOWN NAMES / AREA NAMES(Specifically for London))

		  //Setting City
	  	  $location_value_city = strtolower($_POST['city']);
		  $location_value_post = strtolower($_POST['postcode']);

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

		  if($location_value_city == 'london' || in_array($user_explode[0], $london_postcodes) || in_array($location_value_city, $highwycombe_locations) 
		    || in_array($user_explode[0], $highwycombe_postcodes) || in_array($location_value_city, $guildford_locations) || in_array($user_explode[0], $guildford_postcodes)
		    || in_array($location_value_city, $windsor_locations) || in_array($user_explode[0], $windsor_postcodes)) {

		    //Eliminate specified locations
		    if($location_value_city == 'london') { 
			if(in_array($user_explode[0], $london_postcodes) == false) {
			  echo "<script>alert('Invalid postcode to your specified city. Try again');</script>";
			  echo "<script>window.open(window.location.href,'_self') </script>";

			} else {
			  $remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and lower(product_location) not like lower('%$_POST[city]%')");

	  		  $insert_guest = mysqli_query($con, "insert into FYP_Guests (guest_ip, guest_email, guest_name, guest_country, guest_city, guest_address, guest_postcode, guest_contact, additional_information) values
		   		('$ip','$_POST[email]','$_POST[name]','$_POST[country]','$_POST[city]','$_POST[address]', '$_POST[postcode]', '$_POST[contact]', '$add_info')");

			  //Update Cart ID
		  	  $guest_id = mt_rand();
		  	  $update_id = mysqli_query($con, "update FYP_Cart set delivery_time='$delivery' where ip_address='$ip'");

		  	  if($update_id) {
		    	    echo "<script>alert('Your delivery and billing information has been submitted successfully. You can procceed with payment.');</script>";
		    	    echo "<script>alert('Products under different locations might have been removed.');</script>";
	  	    	    echo "<script>window.open(window.location.href,'_self') </script>";
	   
		  	  } else {
		    	    echo "<script>alert('There was an error, please try again. Or contact the service chat.')</script>";
		    	    //echo mysqli_error($con);
		  	  }

			}

		    } elseif(in_array($location_value_city, $highwycombe_locations)) {
			if(in_array($user_explode[0], $highwycombe_postcodes) == false && in_array($user_sub[0], $highwycombe_postcodes) == false) {
			  echo "<script>alert('Invalid postcode to your specified city. Try again');</script>";
			  echo "<script>window.open(window.location.href,'_self') </script>";

			} else {
			  $remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and lower(product_location) not like lower('%$_POST[city]%')");

	  		  $insert_guest = mysqli_query($con, "insert into FYP_Guests (guest_ip, guest_email, guest_name, guest_country, guest_city, guest_address, guest_postcode, guest_contact, additional_information) values
		   		('$ip','$_POST[email]','$_POST[name]','$_POST[country]','$_POST[city]','$_POST[address]', '$_POST[postcode]', '$_POST[contact]', '$add_info')");

			  //Update Cart ID
		  	  $guest_id = mt_rand();
		  	  $update_id = mysqli_query($con, "update FYP_Cart set delivery_time='$delivery' where ip_address='$ip'");

		  	  if($update_id) {
		    	    echo "<script>alert('Your delivery and billing information has been submitted successfully. You can procceed with payment.');</script>";
		    	    echo "<script>alert('Products under different locations might have been removed.');</script>";
	  	    	    echo "<script>window.open(window.location.href,'_self') </script>";
	   
		  	  } else {
		    	    echo "<script>alert('There was an error, please try again. Or contact the service chat.')</script>";
		    	    echo mysqli_error($con);
		  	  }
			}

		    } elseif(in_array($location_value_city, $guildford_locations)) {
			if(in_array($user_explode[0], $guildford_postcodes) == false) {
			  echo "<script>alert('Invalid postcode to your specified city. Try again');</script>";
			  echo "<script>window.open(window.location.href,'_self') </script>";

			} else {
			  $remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and lower(product_location) not like lower('%$_POST[city]%')");

	  		  $insert_guest = mysqli_query($con, "insert into FYP_Guests (guest_ip, guest_email, guest_name, guest_country, guest_city, guest_address, guest_postcode, guest_contact, additional_information) values
		   		('$ip','$_POST[email]','$_POST[name]','$_POST[country]','$_POST[city]','$_POST[address]', '$_POST[postcode]', '$_POST[contact]', '$add_info')");

			  //Update Cart ID
		  	  $guest_id = mt_rand();
		  	  $update_id = mysqli_query($con, "update FYP_Cart set delivery_time='$delivery' where ip_address='$ip'");

		  	  if($update_id) {
		    	    echo "<script>alert('Your delivery and billing information has been submitted successfully. You can procceed with payment.');</script>";
		    	    echo "<script>alert('Products under different locations might have been removed.');</script>";
	  	    	    echo "<script>window.open(window.location.href,'_self') </script>";
	   
		  	  } else {
		    	    echo "<script>alert('There was an error, please try again. Or contact the service chat.')</script>";
		    	    //echo mysqli_error($con);
		  	  }

			}

		    } elseif(in_array($location_value_city, $windsor_locations)) {
			if(in_array($user_explode[0], $windsor_postcodes) == false) {
			  echo "<script>alert('Invalid postcode to your specified city. Try again');</script>";
			  echo "<script>window.open(window.location.href,'_self') </script>";

			} else {
			  $remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and lower(product_location) not like lower('%$_POST[city]%')");

	  		  $insert_guest = mysqli_query($con, "insert into FYP_Guests (guest_ip, guest_email, guest_name, guest_country, guest_city, guest_address, guest_postcode, guest_contact, additional_information) values
		   		('$ip','$_POST[email]','$_POST[name]','$_POST[country]','$_POST[city]','$_POST[address]', '$_POST[postcode]', '$_POST[contact]', '$add_info')");

			  //Update Cart ID
		  	  $guest_id = mt_rand();
		  	  $update_id = mysqli_query($con, "update FYP_Cart set delivery_time='$delivery' where ip_address='$ip'");

		  	  if($update_id) {
		    	    echo "<script>alert('Your delivery and billing information has been submitted successfully. You can procceed with payment.');</script>";
		    	    echo "<script>alert('Products under different locations might have been removed.');</script>";
	  	    	    echo "<script>window.open(window.location.href,'_self') </script>";
	   
		  	  } else {
		    	    echo "<script>alert('There was an error, please try again. Or contact the service chat.')</script>";
		    	    //echo mysqli_error($con);
		  	  }

			}
		    }

		  } else {
		    echo "<script>alert('Products were removed because of invalid location. Try again');</script>";
		    echo "<script>window.open(window.location.href,'_self') </script>";

		  }

	      }
	    }

	    if(isset($_POST['update'])) {

		  $update_delivery = $_POST['update_delivery'];
		  $add_info = trim(mysqli_real_escape_string($con, $_POST['update_add_info']));

		  //Locations allowed (POSTCODES / TOWN NAMES / AREA NAMES(Specifically for London))

		  //Remove products if country is false
	    	  $remove_country = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and lower(product_country) not like lower('%$country%')");

		  //Setting City
	  	  $location_value_city = strtolower($_POST['update_city']);
		  $location_value_post = strtolower($_POST['update_postcode']);

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

		  if($location_value_city == 'london' || in_array($user_explode[0], $london_postcodes) || in_array($location_value_city, $highwycombe_locations) 
		    || in_array($user_explode[0], $highwycombe_postcodes) || in_array($location_value_city, $guildford_locations) || in_array($user_explode[0], $guildford_postcodes)
		    || in_array($location_value_city, $windsor_locations) || in_array($user_explode[0], $windsor_postcodes)) {

		    //Eliminate specified locations
		    if($location_value_city == 'london') { 
			if(in_array($user_explode[0], $london_postcodes) == false) {
			  echo "<script>alert('Invalid postcode to your specified city. Try again');</script>";
			  echo "<script>window.open(window.location.href,'_self') </script>";

			} else {
			  $remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and lower(product_location) not like lower('%$_POST[city]%')");

			  $update_guest = mysqli_query($con, "update FYP_Guests set guest_ip='$ip', guest_email='$_POST[update_email]', guest_name='$_POST[update_name]', 
		  		guest_country='$_POST[update_country]', guest_city='$_POST[update_city]', guest_address='$_POST[update_address]', guest_postcode='$_POST[update_postcode]',
		  		guest_contact='$_POST[update_contact]', additional_information='$add_info' where guest_ip='$ip'");

			  $update_id = mysqli_query($con, "update FYP_Cart set delivery_time='$update_delivery' where ip_address='$ip'");

			  if($update_guest) {
 			    echo "<script>alert('Your delivery and billing information has been updated successfully. You can procceed with payment.');</script>";
		  	    echo "<script>alert('Products under different locations were removed.');</script>";
		  	    echo "<script>window.open(window.location.href,'_self') </script>";

			  } else {
		  	    echo "<script>alert('There was an error, please try again. Or contact the service chat.')</script>";
		  	    //echo mysqli_error($con);
			  } 

			}

		    } elseif(in_array($location_value_city, $highwycombe_locations)) {
			if(in_array($user_explode[0], $highwycombe_postcodes) == false && in_array($user_sub[0], $highwycombe_postcodes) == false) {
			  echo "<script>alert('Invalid postcode to your specified city. Try again');</script>";
			  echo "<script>window.open(window.location.href,'_self') </script>";

			} else {
			  $remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and lower(product_location) not like lower('%$_POST[city]%')");

			  $update_guest = mysqli_query($con, "update FYP_Guests set guest_ip='$ip', guest_email='$_POST[update_email]', guest_name='$_POST[update_name]', 
		  		guest_country='$_POST[update_country]', guest_city='$_POST[update_city]', guest_address='$_POST[update_address]', guest_postcode='$_POST[update_postcode]',
		  		guest_contact='$_POST[update_contact]', additional_information='$add_info' where guest_ip='$ip'");

			  $update_id = mysqli_query($con, "update FYP_Cart set delivery_time='$update_delivery' where ip_address='$ip'");

			  if($update_guest) {
 			    echo "<script>alert('Your delivery and billing information has been updated successfully. You can procceed with payment.');</script>";
		  	    echo "<script>alert('Products under different locations were removed.');</script>";
		  	    echo "<script>window.open(window.location.href,'_self') </script>";

			  } else {
		  	    echo "<script>alert('There was an error, please try again. Or contact the service chat.')</script>";
		  	    //echo mysqli_error($con);
			  } 

			}

		    } elseif(in_array($location_value_city, $guildford_locations)) {
			if(in_array($user_explode[0], $guildford_postcodes) == false) {
			  echo "<script>alert('Invalid postcode to your specified city. Try again');</script>";
			  echo "<script>window.open(window.location.href,'_self') </script>";

			} else {
			  $remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and lower(product_location) not like lower('%$_POST[city]%')");

			  $update_guest = mysqli_query($con, "update FYP_Guests set guest_ip='$ip', guest_email='$_POST[update_email]', guest_name='$_POST[update_name]', 
		  		guest_country='$_POST[update_country]', guest_city='$_POST[update_city]', guest_address='$_POST[update_address]', guest_postcode='$_POST[update_postcode]',
		  		guest_contact='$_POST[update_contact]', additional_information='$add_info' where guest_ip='$ip'");

			  $update_id = mysqli_query($con, "update FYP_Cart set delivery_time='$update_delivery' where ip_address='$ip'");

			  if($update_guest) {
 			    echo "<script>alert('Your delivery and billing information has been updated successfully. You can procceed with payment.');</script>";
		  	    echo "<script>alert('Products under different locations were removed.');</script>";
		  	    echo "<script>window.open(window.location.href,'_self') </script>";

			  } else {
		  	    echo "<script>alert('There was an error, please try again. Or contact the service chat.')</script>";
		  	    //echo mysqli_error($con);
			  } 

			}

		    } elseif(in_array($location_value_city, $windsor_locations)) {
			if(in_array($user_explode[0], $windsor_postcodes) == false) {
			  echo "<script>alert('Invalid postcode to your specified city. Try again');</script>";
			  echo "<script>window.open(window.location.href,'_self') </script>";

			} else {
			  $remove_pros = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and lower(product_location) not like lower('%$_POST[city]%')");

			  $update_guest = mysqli_query($con, "update FYP_Guests set guest_ip='$ip', guest_email='$_POST[update_email]', guest_name='$_POST[update_name]', 
		  		guest_country='$_POST[update_country]', guest_city='$_POST[update_city]', guest_address='$_POST[update_address]', guest_postcode='$_POST[update_postcode]',
		  		guest_contact='$_POST[update_contact]', additional_information='$add_info' where guest_ip='$ip'");

			  $update_id = mysqli_query($con, "update FYP_Cart set delivery_time='$update_delivery' where ip_address='$ip'");

			  if($update_guest) {
 			    echo "<script>alert('Your delivery and billing information has been updated successfully. You can procceed with payment.');</script>";
		  	    echo "<script>alert('Products under different locations were removed.');</script>";
		  	    echo "<script>window.open(window.location.href,'_self') </script>";

			  } else {
		  	    echo "<script>alert('There was an error, please try again. Or contact the service chat.')</script>";
		  	    //echo mysqli_error($con);
			  } 

			}
		    }

		  } else {
		    echo "<script>alert('Products were removed because of invalid location. Try again');</script>";
		    echo "<script>window.open(window.location.href,'_self') </script>";

		  }

	    }
	  ?>

	</div>

	  
	</div><!-- /.checkout_right -->

	  
    </div> <!--- /.checkout_container --->

  <div class="checkout_background_loading">
   <img src="images/spinner_loader.gif">
  </div>  

  <input type="hidden" id="get_user_ip" value="<?php echo $ip; ?>">
  <input type="hidden" id="get_invoice_number" value="<?php echo $invoice_number; ?>">
  
  <script>
  $(document).ready(function(){
    insert_offline_payment_data();
  });
  
  /////// Hide menubar /////////////////////////////////
  $(".menubar").hide();
  
  ////// On click auto check or uncheck radio button ///
  $(".payment_method_paypal").on('click',function(){
    $("#paypal_radio").prop("checked", true);
	$("#offline_payment_radio").prop("checked", false);
  });
  
  $(".payment_method_offline").on('click',function(){
    $("#paypal_radio").prop("checked", false);
	$("#offline_payment_radio").prop("checked", true);
  });

 //////// On click auto hide or show accordion content ///////
  $(document).on('click','.accordion-toggle',function(){
  
   if($(this).attr('class').indexOf('open') == -1){
     $(this).toggleClass('open').next().slideToggle('fast');
   }
   
   // Hide the other panels
   $(".accordion-toggle").not($(this)).removeClass("open");
   $(".accordion-content").not($(this).next()).slideUp('fast');
  });
  
   
  $(document).ready(function(){
    
	var radio_name_page_reload = $("#checked_on_page_reload").val();
	
	if(radio_name_page_reload == 'payment_method_offline'){
     
	 $(".payment_method_offline").addClass('open');
	 
	 $("#paypal_radio").prop("checked", false);
	 $("#offline_payment_radio").prop("checked", true);
	 
	 $(".payment_method_body_offline").slideDown("fast");
	 $(".payment_method_body_paypal").slideUp('fast');
	}
	
  });

  function send_mail_offline(tx_id){
      
     $.ajax({
      url:'ajax/guest_send_mail_offline_ajax.php',
      type:'post',
      data:{tx_id:tx_id},
      dataType:'html',
      success: function(sendmail){
        
      }
     });
  }

  function insert_offline_payment_data(){
	
	var user_ip = $("#get_user_ip").val();
	
	$("#payment_offline_btn").on('click',function(){
	 
	  $.ajax({
	   url:'ajax/guest_insert_offline_payment_data_ajax.php',
	   type:'post',
	   data:{userIP:user_ip},
	   dataType:'json',
	   beforeSend: function(){
	    
		$(".checkout_background_loading img").css({"top":"30%"});
		
	    $(".checkout_background_loading").show();
		
	   },
	   success: function(insert_offline_payment){
	    	
		if(insert_offline_payment[0] == 'ok'){
		  
		  setTimeout(function(){
		  
		  $(".load_checkout_message").html('<a href="checkout_guest.php?payment=process"><div class="success_message"><i class="fa fa-check"></i> You have purchased successfully ! <i class="fa fa-close"></i></div></a>');
		  
		  close_message_box();
		  
		  $(".checkout_background_loading").hide();
		  
		  },1000);	  
		  
		  ////////// Mail Starts //////////////////////////
		  
		  var tx_id = insert_offline_payment[1];
		  
		  send_mail_offline(tx_id);
		  
		  ///////////////////// Mail Ends ////////////////////////////
		  
		  setTimeout(function(){
 		    var invoice = $("#get_invoice_number").val();
		    window.open('checkout_guest.php?payment=payment-successful&invoice='+ invoice +'&code='+insert_offline_payment[1],'_self');
		   
		  }, 2500);
		  
	      } else {

		  $(".load_checkout_message").html('<a href="checkout_guest.php?payment=process"><div class="error_message"><i class="fa fa-check"></i> Your purchase was unsuccessful due to insufficient funds! Please try again, or contact the service chat.. <i class="fa fa-close"></i></div></a>');

	      }		
	   }
	   
	  });
	  
	});
	
  }


</script>	  
	  
<?php 

  include('includes/footer.php');

  } else { 
    include ('guest/payment-gateway-successful.php');
    //include('includes/footer.php');
} ?>





