<?php 
  include("includes/db.php");
?>
	
<?php 

  $select_user = mysqli_query($con, "select * from FYP_Users where id='$_SESSION[user_id]'");
  $fetch_user = mysqli_fetch_array($select_user);

?>

<?php 
   
   $check_exist = mysqli_query($con,"select * from FYP_Payments where buyer_id='$_SESSION[user_id]'");
   $invoice_count = mysqli_num_rows($check_exist);

   if($invoice_count > 0){ ?>

<?php 

  //Dispute Procedure
	$dispute_type = '';
	$dispute_reason = '';
	$in_id = '';
	$error_message = '';

  if(isset($_POST['file_case'])) {
	if(empty($_POST['dispute_type']) || empty($_POST['invoice'])) {
	  echo "<p style='margin-bottom:10px;color:white; background:red; padding:5px;'>Please select from options to proceed successfully with the case dispute.</p>";
	} else {
	  $dispute_type = $_POST['dispute_type'];
	  $dispute_reason = $_POST['dispute_reason'];
	  $in_id = $_POST['invoice'];
	
	//Check if order is already being disputed 
	$sel_dis = mysqli_query($con, "select * from FYP_Disputes where dispute_status='Ongoing' and invoice_id='$in_id'");

	if(mysqli_num_rows($sel_dis) > 0) {
	  echo "<script>alert('This order is being disputed already, please wait for resolvement.')</script>";
	  echo "<script>window.open(window.location.href,'_self') </script>";

	} else {
	  $insert_dispute = mysqli_query($con, "insert into FYP_Disputes (buyer_id, invoice_id, dispute_type, dispute_reason) values ('$_SESSION[user_id]','$in_id','$dispute_type','$dispute_reason')");
	  $update_order = mysqli_query($con, "update FYP_Payments set payment_status='In Dispute' where invoice_id='$in_id' ");

	  /* Send email of order dispute */
	  //$to = $_SESSION['email'];
	  $to = "michbodzio97@yahoo.com";
	  $subject = "Order Dispute Filed Successfully | W1712116 Online Shopping";
	  $txt = "Dispute filed on " . $in_id . "\r\n" . "The order dispute team will respond as soon as possible." . "\r\n" . "We hope you enjoy our services..";
	  $headers = "W1712116 | Online shopping";
	
	  if($insert_dispute && $update_order) {
	    echo "<script>alert('Dispute filed successfully on order: $in_id , This information will be passed to our team.') </script>";
	    echo "<script>window.open(window.location.href,'_self') </script>";
  	    mail($to,$subject,$txt,$headers);	

	  } else {
	    echo "<h3 style='color:red;'>Order Dispute was sent unsuccessfully. Please Try Again: " . $in_id . "</h3>";
	  }
  	} }

  } else {
	 
} ?>

   <!-- User Dispute Information -->
  <div class="dispute_user_account">
    <h2 style="color:#FFD966;"> Order Dispute Area </h2><br>
    <form method="post" action="" enctype="multipart/form-data">

      <div class="dispute_form_container">
	<p><b>Please choose a dispute type.</b></p><br>

	<input type="radio" id="refund" name="dispute_type" value="refund">
  	<label for="refund">Return & Refund</label><br>
  	<input type="radio" id="exchange" name="dispute_type" value="exchange">
  	<label for="exchange">Exchange Products</label><br>
  	<input type="radio" id="undelivered" name="dispute_type" value="undelivered">
  	<label for="undelivered">Order not received / Order arrived late </label><br>
  	<input type="radio" id="other" name="dispute_type" value="other">
  	<label for="other">Other..</label><br>

	<br><p><b>Please provide a dispute reason.</b></p><br>
	<p> Include as much information as possible, this will help your case to quarantee a successful dispute.</p><br>
	<textarea rows="10" cols="50" name="dispute_reason" placeholder="Insert your dispute information." required></textarea><br><br>
  
	<p><strong>Please proceed with selecting the specific order number to file a dispute.</strong></p><br>
      </div> <!-- /.dispute_form_container -->

      <div class="dispute_form_table">
 
    	<h3>All Orders Found: </h3><br>
    	<table>

 	  <thead>
   	    <tr>
	    	<th>Select</th>
	    	<th>Order ID</th>
     	    	<th>Date</th>
     	    	<th>Payment Type</th>
     	    	<th>Dispute Status</th>
	    	<th>Receipt Details</th>
   	    </tr>
 	  </thead> 

 	<?php 

	$distinct = mysqli_query($con, "select distinct invoice_id,payment_timestamp, payment_status, payment_type from FYP_Payments where buyer_id='$_SESSION[user_id]' order by payment_timestamp DESC");
  	  while($fetch_payment = mysqli_fetch_array($distinct)){	
	  $invoice_id = $fetch_payment['invoice_id'];	
 	?>
 
 	<tbody>
	  <tr>
	    <td width="3%"><input type="radio" name="invoice" value="<?php echo $invoice_id; ?>"  /></td>
            <td width="13%"><?php echo $invoice_id; ?></td>
	    <td width="17%"><?php echo $fetch_payment['payment_timestamp']; ?></td>
	    <td width="16%"><?php echo $fetch_payment['payment_type']; ?></td>

	  <?php if($fetch_payment['payment_status'] == 'In Dispute'){ ?>
	    <td style="color:orange;" width="15%"><?php echo $fetch_payment['payment_status']; ?></td>
	  <?php } elseif($fetch_payment['payment_status'] == 'Completed') { ?>
	    <td style="color:lightgreen;" width="15%"><?php echo $fetch_payment['payment_status']; ?></td>
	  <?php } else { ?>
	    <td width="15%">None</td>
	  <?php } ?>
	    <td width="13%"><a href="my_account.php?action=view_receipt&invoice_id=<?php echo $invoice_id; ?>">Receipt</a></td>
  	  </tr>  
 	</tbody>
 
 <?php } ?>
 
  	</table><br>
	  <tr align="left">
	    <td></td>
	    <td colspan="4">
	    	<input class="submit_dispute_user" style="cursor:pointer; width:100%;" type="submit" name="file_case" value="Submit Dispute" />
	    </td>
	  </tr>
    	</table>

      </div> <!--- /.dispute_form_table --->  

  </form>
</div> <!--- /.dispute_user_account -->

  <?php } else { ?>
    	<h3> No purchase orders found to dispute. </h3>
  <?php } ?>





		

