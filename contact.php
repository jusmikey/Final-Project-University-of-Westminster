
<!------------ Header starts --------------------->
<?php include('includes/header.php'); ?>
<!------------ Header ends ----------------------->

<?php if(!isset($_SESSION['user_id'])) { ?>

  <!-- For (NOT) registered consumer -->

  <!-- Insert information into Database -->
  <div class="message_container_guest">
  <?php 

	if(isset($_POST['submit_message'])) {
	  
	  $email = trim($_POST['email']);
	  $content = trim(mysqli_real_escape_string($con, $_POST['content']));

	  if(!isset($_POST['service_reason'])) {
	    echo "<p style='padding:5px; background:red; margin-bottom:5px; color:white; border-radius:5px;'>Please specify a reason of service contact.</p>";
	  } else {

	    $service_reason = $_POST['service_reason'];
	    
  	    if($service_reason == 'order_dispute') {
		$invoice_number = trim(mysqli_real_escape_string($con, $_POST['invoice_number']));

		$payments = mysqli_query($con, "select * from FYP_Payments where invoice_id='$invoice_number'");
		$dispute_search = mysqli_query($con, "select * from FYP_Disputes where invoice_id='$invoice_number' and dispute_status='Ongoing'");
		  
	 	if(empty($invoice_number)) {
		  echo "<script>alert('Please provide a valid invoice number!');</script>";
		  echo "<script>window.open('contact.php','_self')</script>";
		} elseif(mysqli_num_rows($payments) == 0) {
		  echo "<script>alert('Please provide a valid invoice number!');</script>";
		  echo "<script>window.open('contact.php','_self')</script>";
		} elseif(mysqli_num_rows($dispute_search) > 0) {
		  echo "<script>alert('This invoice number is already in dispute, please wait for resolvement!');</script>";
		  echo "<script>window.open('contact.php','_self')</script>";
		} else {
	  	  $insert_dispute = mysqli_query($con, "insert into FYP_Disputes (guest_email, invoice_id, dispute_type, dispute_reason,consumer_type) values ('$email','$invoice_number','inquire', '$content', 'guest')");

		  // Send Confirmation Email
		  $to = "michbodzio97@yahoo.com"; //$email
		  $subject = "Order Dispute Inquiry";
		  $txt = "We have received your order dispute! Please be patient as we resolve your inquiry. We will notify you by this email.";
		  $headers = "W1712116 | Online Shopping" ;

		  if($insert_dispute) {
		    mail($to,$subject,$txt,$headers);
		    echo "<script>alert('Order Dispute was filed successfully on invoice id: $invoice_number!');</script>";
		    echo "<script>window.open('contact.php','_self')</script>";

		  }
		}
	    } else {
		$insert_message = mysqli_query($con, "insert into FYP_ServiceChat (message_author, consumer_email, message_content) values ('guest','$email','$content')");

		// Send Confirmation Email
		$to = "michbodzio97@yahoo.com"; //$email
		$subject = "Service Chat Support";
		$txt = "We have received your message! Please be patient as our team responds to you. We will notify you by this email.";
		$headers = "W1712116 | Online Shopping" ;

		if($insert_message) {
		  mail($to,$subject,$txt,$headers);
		  echo "<script>alert('We have received your message, thank you for contacting our team!');</script>";
		  echo "<script>window.open('contact.php','_self')</script>";
		}
	    }
	  }
	}
  ?>

  <h2 class="title">Contact our services for direct support!</h2>
  <p><a class="login_chat_link" href="index.php?action=login">Log In</a> for a more convenient support service.</p>
  <p class="bar">Or <a class="login_chat_link" href="register.php">Register with us</a> to become a member!</p>

    <form method="post" action="" id="message_form" enctype="multipart/form-data"> 

	<h4>Please provide your reason for service:</h4>
	<input type="radio" name="service_reason" value="normal">
	<label for="normal">Service Inquiry</label>
	<input type="radio" name="service_reason" value="order_dispute">
	<label for="order_dispute">Order Dispute</label><br><br>

	<h4>Please provide your email:</h4>
	<input type="email" name="email" value="" placeholder="Your Email" required/><br><br>

	<h4>Please provide your invoice number if you're placing an order dispute:</h4>
	<input type="text" name="invoice_number" value="" placeholder="Your Invoice Order Number" /><br>

	<h4 style="margin-top:10px;">Write your message below:</h4><br>
	<textarea id="text_message_guest" name="content" placeholder="Type your message here.." form="message_form" required></textarea><br><br>
  	<input class="bttn_message_send" type="submit" name="submit_message" value="Send">  
    <form>
   
    <div class="vg_contact">
    <img src="images/vg_contact.png" alt="You will be emailed a response, after our team resolves your inquiry" />
   </div> <!--- /.vg_contact -->

  </div> <!-- /.container -->

<?php } else { ?>

  <!-- Form for registered user -->
  <img style="border-bottom:1px lightgrey dotted; padding-bottom:10px;" class="img_con_reg" src="images/visualguide_contact.png" height="170px" alt="Write a question for the service team, and we will respond in the chat box." width="100%" />
  <br>
  

  <!-- Insert information into Database -->
  <div class="message_container">
  <?php 
	if(isset($_POST['submit_message'])) {
	  $content = $_POST['content'];
	  $user = $_SESSION['user_id'];
	  
	  $insert_message = mysqli_query($con, "insert into FYP_ServiceChat (message_author, user_id, message_content) values ('user','$user','$content')");

	  if($insert_message) {
	    echo "<script>alert(' Your message was sent successfully, it will be picked up by the service as soon as possible.');</script>";
	    echo "<script>window.open('contact.php','_self') </script>";

	  } else {
	    echo "<script>alert('There was an error with your message, please try again or come back later.');</script>";
	    echo "<script>window.open('contact.php','_self') </script>";

	  }
	}
  ?>


  <h2 class="title">Contact our services for direct support!</h2><br>
  <div>
    <form method="post" action="" id="message_form" enctype="multipart/form-data"> 
	<h4>Write your message below:</h4><br>
	<textarea id="service_chat_reg" name="content" form="message_form" placeholder="Type your message here.." required></textarea><br><br>
	<input class="bttn_message_send" type="submit" name="submit_message" value="Send">  
    <form>
  </div>
  </div> <!-- /.container -->

  <div class="messages_content">
    <div style="text-align:center; font-size:18px; color:#B266FF; font-weight:bold;">Service Chat Box</div>

    <!--- Fetch Messages to Display --->
    <?php 
	$select_message = mysqli_query($con, "select * from FYP_ServiceChat where user_id='$_SESSION[user_id]' order by message_timestamp desc ");
	while($fetch_message = mysqli_fetch_array($select_message)) {
	  $content = $fetch_message['message_content']; 
	  $date = $fetch_message['message_timestamp'];

	  if($fetch_message['message_author'] == 'user') {
	  echo "
	    <div class='user_message'>
	      <p>$content</p>
	      <p style='float:right; font-size:12px; font-weight:bold;'>$date</p>
	    </div>
	  ";
	  } elseif($fetch_message['message_author'] == 'admin') {
	  echo "
	    <div class='admin_message'>
	      <p>$content</p>
	      <p style='float:right; font-size:12px; font-weight:bold;'>$date</p>
	    </div>
	  ";
	  }
	}
    ?>

  </div>

<?php } ?>

<br>

<!--- Footer --->
<?php include ('includes/footer.php'); ?>
</html>

