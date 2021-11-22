<?php 
  if(!empty($_GET['tx'])){
    $amount = $_GET['amt'];
    $transaction_id = $_GET['tx'];
    $currency_code = $_GET['cc'];
    $payment_status = $_GET['st'];

    //Guest IP Address
    $ip = get_ip();  
    
    //Getting user information for automatic purchase email 
    $select_customer = mysqli_query($con,"select * from FYP_Guests where guest_ip='$ip'");
    $fetch_customer = mysqli_fetch_array($select_customer);

    if(mysqli_num_rows($select_customer) > 0) {
      $add_info = trim(mysqli_real_escape_string($con, $fetch_customer['additional_information']));
    }

    //Check if payment data exists with the same transaction ID

    $check_previous_payment = mysqli_query($con,"select payment_id from FYP_Payments where tx_id='$transaction_id' ");

    if(mysqli_num_rows($check_previous_payment) > 0){
    
    } else {
  
  	$select_cart = mysqli_query($con,"select * from FYP_Cart where ip_address='$ip'");
  	while($fetch_cart = mysqli_fetch_array($select_cart)) {

  	$quantity = $fetch_cart['quantity'];
	$invoice_id = $fetch_cart['invoice_number'];
  
  	//Insert payment data transer to database
  
  	$insert_payment = mysqli_query($con,"insert into FYP_Payments (tx_id, product_id, product_price, invoice_id, currency_code, payment_status, payer_email, quantity, amount, type, payment_type) values ('$transaction_id', '$fetch_cart[product_id]', '$fetch_cart[product_price]', '$invoice_id', '$currency_code', '$payment_status', '$fetch_customer[guest_email]', '$quantity', '$fetch_cart[product_price]', 'multiple_items', 'Paypal') ");
	
        } //End While Loop 

	//Insert delivery information to database
  	$sel_cart = mysqli_query($con,"select * from FYP_Cart where ip_address='$ip'");
	$fetch_cart_info = mysqli_fetch_array($sel_cart);

	$insert_delivery = mysqli_query($con, "insert into FYP_Delivery (invoice_id, guest_email, name, address, city, postcode, country, contact, add_info, delivery_type)
	 values ('$fetch_cart_info[invoice_number]', '$fetch_customer[guest_email]', '$fetch_customer[guest_name]', '$fetch_customer[guest_address]', '$fetch_customer[guest_city]', '$fetch_customer[guest_postcode]', '$fetch_customer[guest_country]', '$fetch_customer[guest_contact]', '$add_info', '$fetch_cart_info[delivery_time]')"); 
	
	if($insert_delivery) {
	  // Remove Guest information
	  $remove_guest = mysqli_query($con, "delete from FYP_Guests where guest_ip='$ip'");

	  // Deleting products from the cart
	  $remove_cart = mysqli_query($con, "delete from FYP_Cart where ip_address='$ip'");

	} else {
	  echo mysqli_error($con);
	}

?>

  <!--------- Mail Starts ---------->

<?php
  $mail_content = '';
  $product_title = '';
  $total_paid = 0;

  $select_payment_by_tx_id = mysqli_query($con,"select * from FYP_Payments where tx_id='$transaction_id' ");

  $space = ', ';

  while($fetch_payment = mysqli_fetch_array($select_payment_by_tx_id)) {
 
    $select_product_by_mail = mysqli_query($con,"select * from FYP_Products where product_id = '$fetch_payment[product_id]' ");
    $fetch_product = mysqli_fetch_array($select_product_by_mail);
 
    $product_title .= $fetch_product['product_title'] . $space;
 
    $array_price = array($fetch_payment['product_price']);
 
    $sum_price = array_sum($array_price);
    $values = $sum_price * $fetch_payment['quantity'];
    $total_paid += $values;
    $new_total = number_format($total_paid, 2);
 
    $mail_content .= '<tr>
      <td>'.$fetch_product["product_title"].'</td>
      <td>'.$fetch_payment["quantity"].'</td>
      <td>&#163;'.$fetch_payment["product_price"].'</td>
      <td>'.$fetch_payment["invoice_id"].'</td>
      <td>'.$fetch_payment["payment_timestamp"].'</td>
   </tr>';
}

  //$to = $fetch_payment['payer_email'];
  $to = "michbodzio97@yahoo.com";

  $subject = "Purchase Order Details | W171216 Online Shopping";

  $message = '
    <html> 
 	<p>
 	  We appreciate your recent order !
 	</p>
 
 	<table width="100%" align="left" border="0">
   	  <tr>
    	    <td colspan="6"><h2>Your Order Details from W1712116 | Online Shopping</h2></td>
   	  </tr>
   
   	<tr align="left">
     	  <th><b>Product Name</b></th>
     	  <th><b>Quantity</b></th>
     	  <th><b>Price</b></th>
     	  <th><b>Invoice Number</b></th>
     	  <th><b>Date</b></th>
   	</tr>
   
       '.$mail_content.'
   
   	<tr>
     	  <td></td>
     	  <td></td>
     	  <td><h3>Total Paid</h3></td>
     	  <td><h3>&#163;'. $new_total .'</h3></td>
   	</tr>
     </table>
 
     <h3>If you have any questions, please do not hesitate to contact us - W1712116 | Online Shopping</h3>
 
    </html>
    ';

   // Always set content-type when sending HTML email
   $headers = "MIME-Version: 1.0" . "\r\n";
   $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

   // More headers
   $headers .= 'Purchase Order From W1712116 | Online Shopping' . "\r\n";

   $send_mail = mail($to,$subject,$message,$headers);
?>

  <!---------------- Mails Ends  ------------------>

<?php } // End Else ?>

<?php 

   // Check if paypal payment was successful
 
    $payment_result = mysqli_query($con,"select * from FYP_Payments where tx_id='$transaction_id' ");
  
    if(mysqli_num_rows($payment_result) > 0){
	
	$fetch_payment = mysqli_fetch_array($payment_result);
	$product_price = $fetch_payment['product_price'];
	$total_paid = $product_price * $fetch_payment['quantity'];
	$print_total = '&pound;' . number_format($total_paid,2);
?>

<!-------- Details of order ------------------->

<?php 

  $select_payment = mysqli_query($con,"select * from FYP_Payments where tx_id='$_GET[tx]' ");
  $fetch_invoice = mysqli_fetch_array($select_payment);

?>

<div class="checkout_container">
	  
  <div class="checkout_header">
  
  <div class="checkout_header_box">
  <h1>Order Purchase Completed</h1>
  </div><!-- /.checkout_header_box -->
  
  </div><!---/.checkout_header -->
  
  <div class="payment_successful_container">
   <div class="payment_successful_box">
    
	<div class="payment_successful_left">
	 <div class="payment_successful_left_box">
	    <img style="border-radius:50px;" width="100%" src="images/StyleGuide.png">
	</div><!--/.payment_successful_left_box------->
	</div><!--/.payment_successful_left------------->
	
	<div class="payment_successful_right">
	 <div class="payment_successful_right_box">
	  <div class="thank_you_box">
	   <i class="fa fa-check"></i> Thank you. Your order was completed successfully!
	  </div>
	  
	  <div class="checkout_invoice_box">
	    <?php echo $fetch_invoice['invoice_id']; ?><a href="my_account.php?action=view_receipt&invoice_id=<?php echo $fetch_invoice['invoice_id'];?>" target="_blank"> <i class="fa fa-angle-right"></i></a>
	  </div>
	  
	  <div class="list_of_products">
	  <?php 
	  $select_payment_by_invoice = mysqli_query($con,"select * from FYP_Payments where invoice_id='$fetch_invoice[invoice_id]' ");
	  
	  while($row_payment = mysqli_fetch_array($select_payment_by_invoice)){
	   
	   $select_product = mysqli_query($con,"select * from FYP_Products where product_id='$row_payment[product_id]' ");
	   
	   $row_product = mysqli_fetch_array($select_product);
	  ?>
	  
	  <p><?php echo $row_payment['quantity'];?> x <?php echo $row_product['product_title'];?></p>
	  
	  <?php } ?>
	  </div> <!--- /.list_of_products --->
	  
	  <p>The details of the order have been sent to an email address <span style="color:blue"> <?php echo $fetch_invoice['payer_email'];?></span>. If you do not receive this email please check your <b>Spam</b> or <b>Junk</b> mail folder.</p>
	  
	</div><!--/.payment_successful_right_box------->
	</div><!--/.payment_successful_right------------->
	
   </div><!--/.payment_successful_box------------------->
  </div><!--/.payment_successful_container----------------->

  <p><a class="continue_after_pay" href="index.php"><i class="fa fa-arrow-left"></i> Continue with your shopping..</a></p><br>

</div><!--/.checkout_container-------------------------------->

<!-------- Detail of order ------------------->
      
<?php } ?>

<?php } else { ?>
    
    <div class="container_success">
    <h2>Sorry your payment has failed!</h2><br>

    <div style="background:red;color:white;padding:10px;">
	Your purchase was unsuccessful, please try again, contact the service chat or contact your bank.
    </div>
    <p> Your Email: <?php echo $fetch_customer['guest_email'] ; ?> </p>
    <a href="cart.php"><i class="fa fa-arrow-left"></i>   Go back to your cart</a>

  </div>
    
<?php } ?>
