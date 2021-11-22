
<style>
.menubar{
  display:none;
}
</style>

<?php 
  include 'includes/db.php';

  $select_payment = mysqli_query($con,"select * from FYP_Payments where tx_id='$_GET[code]' ");
  $fetch_invoice = mysqli_fetch_array($select_payment);
  $checkout_invoice = $fetch_invoice['invoice_id'];
  $select_user = mysqli_query($con,"select * from FYP_Users where id='$fetch_invoice[buyer_id]'");
  $fetch_user = mysqli_fetch_array($select_user);

?>

<div class="checkout_container">
	  
  <div class="checkout_header">
  
  <div class="checkout_header_box">
  <h1>Your Order Completion</h1>
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
	   <i class="fa fa-check"></i> Your order was completed successfully! Thank you for purchasing..
	  </div>
	  
	  <div class="checkout_invoice_box">
	  <?php echo $checkout_invoice; ?> <a href="my_account.php?action=view_receipt&invoice_id=<?php echo $checkout_invoice;?>" target="_blank"><i class="fa fa-angle-right"></i></a>
	  </div>
	  
	  <div class="list_of_products">


	  <?php 
	  $select_payment_by_invoice = mysqli_query($con,"select * from FYP_Payments where invoice_id='$checkout_invoice' ");
	  
	  while($row_payment = mysqli_fetch_array($select_payment_by_invoice)){
	   
	   $select_product = mysqli_query($con,"select * from FYP_Products where product_id='$row_payment[product_id]' ");
	   
	   $row_product = mysqli_fetch_array($select_product);
	  ?>
	  
	  <p><?php echo $row_payment['quantity'];?> x <?php echo $row_product['product_title'];?></p>
	  
	  <?php } ?>

	  </div> <!--- /.list_of_products --->
	  
	 <p>The details of the order have been sent to your billing email address <span style="color:#B266FF; text-decoration:underline;"> <?php echo $fetch_user['email'];?></span>. If you do not receive this email please check your <b>Spam</b> or <b>Junk</b> mail folder.</p>
	  
	</div><!--/.payment_successful_right_box------->
	</div><!--/.payment_successful_right------------->
	
   </div><!--/.payment_successful_box------------------->
  </div><!--/.payment_successful_container----------------->

  <p><a class="continue_after_pay" href="index.php"><i class="fa fa-arrow-left"></i> Continue with your shopping..</a></p><br>

  
</div><!--/.checkout_container-------------------------------->