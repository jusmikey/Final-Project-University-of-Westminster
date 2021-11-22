
<!---- Header starts ----->
<?php include('includes/header.php'); ?>
<!----- Header ends ----->

<!----- Content wrapper starts ----->

<?php if($_GET['payment'] != 'payment-successful'){ ?>

   <?php if(!isset($_GET['location']) || $_GET['location'] == '') {
	echo "<script>alert('Please specify a location to continue with purchase.')</script>";
	echo "<script>window.location.replace('index.php');</script>";
    } ?>

  <div class="content_wrapper">	  
	    
  <?php 
    $invoice_number = mt_rand();
    $ip = get_ip();
	 
      //No Login Information
      if(!isset($_SESSION['user_id'])){
	     include('login.php');
	     include('includes/footer.php');

	  }else{
	  
	  $update_cart = mysqli_query($con,"update FYP_Cart set buyer_id='$_SESSION[user_id]', invoice_number='$invoice_number' where ip_address='$ip' ");
	  
	  $sel_pro_loc = mysqli_query($con, "select * from FYP_Cart where buyer_id='$_SESSION[user_id]'");

	  $sel_user = mysqli_query($con, "select * from FYP_Users where id='$_SESSION[user_id]'");
	  $fetch_details = mysqli_fetch_array($sel_user);
	  
	  if(mysqli_num_rows($sel_pro_loc) == 0) {
	    echo "<div style='text-align:center;'><p style='background:#FFD966; padding:5px; margin-top:10px; border-radius:5px; color:white; float:left; width:100%;'>There are no products in your cart..</p></div>"; 
	  } ?>

	  <div class="checkout_container">
	  
	    <div class="checkout_header">
	  
	      <h1>Your Order Checkout</h1>
	 
	    </div><!---/.checkout_header -->

	    <div class="check_image" >
	      <img width="100%" height="200px" src="images/vg_pay.png" alt="Firstly observe your chosen products, make sure your location is valid, otherwise products are removed. Choose payment method." />
	    </div> <!--- ./check_image --->

	  <div class="checkout_left">
	  
	  <div class="checkout_left_box">
	  	<h3>Total Items (<?php total_items();?>)</h3>
	  </div><!--/.checkout_left_box -->

	  <?php 
	  $checkout_ip = get_ip();
	  
	  $sel_cart = mysqli_query($con,"select * from FYP_Cart where ip_address='$checkout_ip' ");
	  
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
	  
	  <h4 style="margin:10px 0">Please choose your preferred method of payment.</h4>

	  <!--- Products for Adults (18+) ---->  
	  <h4 style="margin:10px 0; padding:5px; border-radius:5px; border: solid 1px red;">You will be asked for age identification if purchasing products for over 18+.</h4>

	  <!---<div class= style="padding:20px; background:lightblue; text-align:center;">

	   Note for purchasing items for +18 adults 
	  <h3 style="color:blue;">Disclaimer</h3>
	  <p>Please be aware when purchasing products for over +18 of age adults.<br></p>
	  <p>During delivery you will be asked for proof of age, and if you are not above +18 of age, or fail to show your identification,<br>
	  then specific products with the (18+) label tag, will not be provided to you. </p>
	  
	  </div>-->

	  
	      <!------ PAYPAL METHOD PAYMENT ----->
	  
	      <div class="payment_method_container">
	      	<div class="payment_method_box">
	    
		  <div class="payment_method_header accordion-toggle payment_method_paypal">
		    <input type="radio" id="paypal_radio" name="paypal_radio" value="paypal" checked><img src="images/pp-logo-100px.png">
		  </div><!---/.payment_method_header-->
		
		  <div class="payment_method_body payment_method_body_paypal accordion-content">
		 
		   <p>In order to complete your transaction, we will transfer you over to Paypal's secure servers.</p>
		 
		    <div class="payment_gateway_box">
			<?php if(mysqli_num_rows($sel_pro_loc) == 0) {
			    echo "<h3>Your cart is empty, please choose products.</h3>";
			  } elseif(empty($fetch_details['city']) || empty($fetch_details['country']) || empty($fetch_details['postcode']) || empty($fetch_details['user_address']) || empty($fetch_details['name']) || empty($fetch_details['contact'])) {
			     echo "<h3>Please state your location.</h3>"; 
			  } else { ?>

			    <form id="pay_chkout" method="post" action=""> <input id="proceed_paypal" type="submit" name="sub" value="Continue with PayPal" /></form>
			    <?php if(isset($_POST['sub'])) {

    			    //Select buyer
    			    $select_buyer = mysqli_query($con, "select * from FYP_Users where id='$_SESSION[user_id]'");
    			    $fetch_buyer = mysqli_fetch_array($select_buyer);

			    //Setting City
			    $location_value_city = strtolower($fetch_buyer['city']);
			    $location_value_post = strtolower($fetch_buyer['postcode']);

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
			
			    $select_cart_country = mysqli_query($con, "select * from FYP_Cart where ip_address='$ip' and buyer_id='$_SESSION[user_id]' and lower(product_country) not like lower('%$fetch_buyer[country]%')");

			    if(mysqli_num_rows($select_cart_country) > 0) {
				$remove_pros_country = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and buyer_id='$_SESSION[user_id]' and lower(product_country) not like lower('%$fetch_buyer[country]%')");
				echo "<script>alert('Some products were removed due to invalid delivery location..')</script>";
				echo "<script>document.getElementById('pay_chkout').style.display = 'none';</script>";
				include('payment.php');
			    } else {		   

			    	if($location_value_city == 'london' || in_array($user_explode[0], $london_postcodes) || in_array($location_value_city, $highwycombe_locations) 
	  			  || in_array($user_explode[0], $highwycombe_postcodes) || in_array($user_sub[0], $highwycombe_postcodes) || in_array($location_value_city, $guildford_locations) || in_array($user_explode[0], $guildford_postcodes)
	  			  || in_array($location_value_city, $windsor_locations) || in_array($user_explode[0], $windsor_postcodes)) {
		  		
				//Eliminate specified locations
	  			  if($location_value_city == 'london') {
				    if(in_array($user_explode[0], $london_postcodes) == false) {
					echo "<script>alert('False postcode to your provided location.')</script>";
				    } else {
					$remove_city = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and buyer_id='$_SESSION[user_id]' and lower(product_location) not like lower('%london%')");
					echo "<script>alert('Some products were removed due to invalid delivery location..')</script>";
					echo "<script>document.getElementById('pay_chkout').style.display = 'none';</script>";
					include('payment.php');
				    }

				  } elseif(in_array($location_value_city, $highwycombe_locations)) {
				    if(in_array($user_explode[0], $highwycombe_postcodes) == false && in_array($user_sub[0], $highwycombe_postcodes) == false) {
					echo "<script>alert('False postcode to your provided location.')</script>";
				    } else {
					$remove_city = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and buyer_id='$_SESSION[user_id]' and lower(product_location) not like lower('%high wycombe%')");
					echo "<script>alert('Some products were removed due to invalid delivery location..')</script>";
					echo "<script>document.getElementById('pay_chkout').style.display = 'none';</script>";
					include('payment.php');

				    }

				  } elseif(in_array($location_value_city, $guildford_locations)) {
				    if(in_array($user_explode[0], $guildford_postcodes) == false) {
					echo "<script>alert('False postcode to your provided location.')</script>";
				    } else {
					$remove_city = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and buyer_id='$_SESSION[user_id]' and lower(product_location) not like lower('%guildford%')");
					echo "<script>alert('Some products were removed due to invalid delivery location..')</script>";
					echo "<script>document.getElementById('pay_chkout').style.display = 'none';</script>";
					include('payment.php');

				    }

				  } elseif(in_array($location_value_city, $windsor_locations)) {
				    if(in_array($user_explode[0], $windsor_postcodes) == false) {
					echo "<script>alert('False postcode to your provided location.')</script>";
				    } else {
					$remove_city = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and buyer_id='$_SESSION[user_id]' and lower(product_location) not like lower('%windsor%')");
					echo "<script>alert('Some products were removed due to invalid delivery location..')</script>";
					echo "<script>document.getElementById('pay_chkout').style.display = 'none';</script>";
					include('payment.php');

				    }

				  } 

				} else {
				  $remove_city = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip' and buyer_id='$_SESSION[user_id]' and lower(product_location) not like lower('%$fetch_buyer[city]%')");
				  echo "<script>alert('Some products were removed due to invalid delivery location..')</script>";
				}

			    } //If country is false

			  } //If button is set ?>
			<?php } //If Not delivery info is provided or cart is empty ?>

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
	  
	      <!----- (OFFLINE) METHOD PAYMENT ----->

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
			  if(mysqli_num_rows($sel_pro_loc) == 0) {
			    echo "<h3>Your cart is empty, please choose products.</h3>";
			  } else { ?>
		   	    <button id="payment_offline_btn">Complete Order <i class="fa fa-arrow-circle-right"></i></button>
			 <?php } ?>

		  </div>

		 <div class="paypal_text_box">
		  <div class="paypal__text">
		   <p>By completing your purchase, you agree to these <a href="" target="_blank" style="text-decoration:none; color:#FFD966; font-weight:bold;">Terms of Service.</a></p>
		  </div>
		  
		 </div>
		 
	       </div>
		 
	    </div><!--/.payment_method_body-->
		
	    </div><!--/.payment_method_box------->
	  </div><!---/.payment_method_container------------->	  
	</div><!-- /.checkout_right_box -->

	</div><!-- /.checkout_right -->
	  
	  <div class="load_checkout_message"></div><!--/.load_checkout_message-->
	  
	  <div class="load_billing_address"></div><!--/.load_billing_address-->
	  
    </div><!-----/.checkout_container -->

    <?php include('includes/footer.php'); ?>
	  
	  <?php  } ?>
  </div><!-- /.content_wrapper-->
  <!------------ Content wrapper ends -------------->
  
  
  <input type="hidden" id="checked_on_page_reload" value="<?php echo $_SESSION['checked_on_page_reload'];?>">
  
  <input type="hidden" id="get_user_id" value="<?php echo $_SESSION['user_id']; ?>">
  <input type="hidden" id="get_user_ip" value="<?php echo $ip; ?>">
  <input type="hidden" id="get_invoice_number" value="<?php echo $invoice_number; ?>">
  <input type="hidden" id="get_location" value="<?php echo $_GET['location']; ?>">

  <div class="checkout_background_loading">
   <img src="images/spinner_loader.gif">
  </div>  
  
  <script>
  $(document).ready(function(){
  
    insert_offline_payment_data();
	
	display_billing_address();
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
  
  //////// On page reload keep radio button checked ////////
  
  $(document).on("click",".accordion-toggle", function(){
    
	if($(this).hasClass('payment_method_offline')){
	  var radio_name = 'payment_method_offline';
	}else if($(this).hasClass('payment_method_paypal')){
	  var radio_name = 'payment_method_paypal';
	}
	
	$.ajax({
	  url:'ajax/get_session_checked_ajax.php',
	  type:'post',
	  data:{get_radio_name:radio_name},
	  dataType:'html',
	  success: function(get_session_checked){
	      //alert(get_session_checked);
	  }	  
	});	
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
      url:'ajax/send_mail_offline_ajax.php',
      type:'post',
      data:{tx_id:tx_id},
      dataType:'html',
      success: function(sendmail){
        
      }
     });
  }
  
  function insert_offline_payment_data(){
    
	var user_id = $("#get_user_id").val();
	
	var user_ip = $("#get_user_ip").val();
	
	//alert(user_ip);
	
	$("#payment_offline_btn").on('click',function(){
	 
	  $.ajax({
	   url:'ajax/insert_offline_payment_data_ajax.php',
	   type:'post',
	   data:{userID:user_id,userIP:user_ip},
	   dataType:'json',
	   beforeSend: function(){
	    
		$(".checkout_background_loading img").css({"top":"30%"});
		
	    $(".checkout_background_loading").show();
		
	   },
	   success: function(insert_offline_payment){
	    
		//alert(insert_offline_payment[0]);		
		
		if(insert_offline_payment[0] == 'ok'){
		  //alert('You have purchased successfully !');
		  
		  setTimeout(function(){
		  
		  $(".load_checkout_message").html('<a href="checkout.php?payment=process"><div class="success_message"><i class="fa fa-check"></i> You have purchased successfully ! <i class="fa fa-close"></i></div></a>');
		  
		  close_message_box();
		  
		  $(".checkout_background_loading").hide();
		  
		  },1000);	  
		  
		  ////////// Mail Starts //////////////////////////
		  
		  var tx_id = insert_offline_payment[2];
		  
		  send_mail_offline(tx_id);
		  
		  ///////////////////// Mail Ends ////////////////////////////
		  
		  setTimeout(function(){
 		    var invoice = $("#get_invoice_number").val();
		    //window.open('my_account.php?action=view_receipt&invoice_id='+invoice,'_self');
		    window.open('checkout.php?payment=payment-successful&code='+insert_offline_payment[2],'_self');
		   
		  }, 2500);
		  
		  
		  
		}else{
		  if(insert_offline_payment[1] == 'empty'){
		    //alert('Your cart is empty !');
			
			setTimeout(function(){
			
			 $(".load_checkout_message").html('<div class="error_message"><i class="fa fa-shopping-cart"></i> Your cart is empty ! </div>');
			 
			 $(".checkout_background_loading").hide();
			 
			 close_message_box();
			 
			}, 2000);
			
			
		  }

		  if(insert_offline_payment[0] == 'wrong') {
 			setTimeout(function(){
			
			 $(".load_checkout_message").html('<a><div class="error_message"><i class="fa fa-sign-in"></i> Please specify your address and delivery details to proceed with payment! </div></a>');
			 
			 $(".checkout_background_loading").hide();
			 
			 close_message_box();
			 
			}, 2000);

		  }
		  
		  if(insert_offline_payment[0] == 'logged out'){
		  
		    setTimeout(function(){
			
			 $(".load_checkout_message").html('<a><div class="error_message"><i class="fa fa-sign-in"></i> You have logged out. Please log in to complete order !</div></a>');
			 
			 $(".checkout_background_loading").hide();
			 
			 close_message_box();
			 
			}, 2000);
		    
		  }

		  if(insert_offline_payment[0] == 'invalid postcode'){
		  
		    setTimeout(function(){
			
			 $(".load_checkout_message").html('<a><div class="error_message"><i class="fa fa-sign-in"></i> Invalid postcode for the chosen city delivery location!</div></a>');
			 
			 $(".checkout_background_loading").hide();
			 
			 close_message_box();
			 
			}, 2000);
		    
		  }

		  if(insert_offline_payment[0] == 'invalid delivery location'){
		  
		    setTimeout(function(){
			
			 $(".load_checkout_message").html('<a><div class="error_message"><i class="fa fa-sign-in"></i> Invalid location details for the valid delivery location!</div></a>');
			 
			 $(".checkout_background_loading").hide();
			 
			 close_message_box();
			 
			}, 2000);
		    
		  }

		  if(insert_offline_payment[0] == 'country'){
		  
		    setTimeout(function(){
			
			 $(".load_checkout_message").html('<a><div class="error_message"><i class="fa fa-sign-in"></i> Some products were removed due to different country location!</div></a>');
			 
			 $(".checkout_background_loading").hide();
			 
			 close_message_box();
			 
			}, 2000);
		    
		  }

		  if(insert_offline_payment[0] == 'city'){
		  
		    setTimeout(function(){
			
			 $(".load_checkout_message").html('<a><div class="error_message"><i class="fa fa-sign-in"></i> Some products were removed due to different city location!</div></a>');
			 
			 $(".checkout_background_loading").hide();
			 
			 close_message_box();
			 
			}, 2000);
		    
		  }

		}
		
	   }
	   
	  });
	  
	});
	
  }
  
  function display_billing_address(){
    var user_id = $("#get_user_id").val();
    var get_loc = $("#get_loc").val();
	var invoice_number = $("#get_invoice_number").val();
	//alert(user_id);
	
	$.ajax({
	  url:'ajax/display_billing_address_ajax.php',
	  type:'post',
	  data:{post_user_id:user_id, post_loc:get_loc, invoice_number:invoice_number},
	  dataType:'html',
	  success: function(buyer_billing_address){
	   //alert(buyer_billing_address);
	  $(".load_billing_address").html(buyer_billing_address); 
	  
	  edit_billing_address();
	  
	  }
	});
  }
  
  function edit_billing_address(){
   
   $(".fa-close, #cancel_billing_address_btn").click(function(){
    $(".billing_address_box").show();
	
	$(".billing_address_form_box").hide();
   });
  
   $(".fa-pencil, #checkout_additional_editor").on("click",function(){
    
	$(".update_message").remove();
	
	$(".billing_address_box").hide();
	
	$(".billing_address_form_box").show();
	
	$("textarea").focus();
	
   });
    
   $("#update_billing_address_btn").on('click',function(){
     
	 var user_id = $(this).data("user_id");
	 
	 var invoice_number = $(this).data("invoice_number");	 
	 var name = $("#edit_name").val();
	 var user_address = $("#edit_user_address").val();
	 var city = $("#edit_city").val();
	 var postcode = $("#edit_postcode").val();
	 var country = $("#edit_country").val();
	 var contact = $("#edit_contact").val();
	 var delivery = $(".edit_delivery:checked").val();
	 
	 var additional_content = $(".checkout_additional_editor").val();
	 
	 $.ajax({
	   url:'ajax/edit_billing_address_ajax.php',
	   type:'post',
	   data:{user_id:user_id, invoice_number:invoice_number, name:name, user_address:user_address, city:city, country:country, postcode:postcode, contact:contact, delivery:delivery, additional_content:additional_content},
	   dataType:'json',
	   success: function(update_billing_address){
		$(".load_checkout_message").html('<div class="success_message"><i class="fa fa-check"></i> Details Updated Successfully!</div>');

		if(update_billing_address[0] == 'ok'){		 
		 display_billing_address();
		 setTimeout(
                  function() 
                  {
                     location.reload();
                  }, 2500); 
		}
		
	   }
	   
	 });
	 
   });
	
  }
  
  function close_message_box(){
    $(".load_checkout_message .fa-close").on('click',function(){
	  $(this).parents(".load_checkout_message").find("div").hide();
	});	
  }
  </script>
	  
	  
  
<?php  

  } else { ?>

<?php include 'payment-gateway-successful.php'; ?>

<?php } ?>
  
  
  
  
  
  
