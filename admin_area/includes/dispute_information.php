
<?php 

	//Fetch Dispute Values from Database

	$purchase_result = mysqli_query($con, "select * from FYP_Disputes where invoice_id='$_GET[invoice_id]' and dispute_id='$_GET[dispute_id]'");
	$fetch_dispute = mysqli_fetch_array($purchase_result);
	
	//Fetch Buyer Values from Database

	$select_buyer = mysqli_query($con,"select * from FYP_Users where id='$fetch_dispute[buyer_id]'");
	$fetch_buyer = mysqli_fetch_array($select_buyer);
	
	//Fetch Payment Values from Database

	$select_payment = mysqli_query($con, "select * from FYP_Payments where invoice_id='$_GET[invoice_id]'");
	$fetch_payment = mysqli_fetch_array($select_payment);
	$total_price = $fetch_payment['product_price'] * $fetch_payment['quantity'];
	
    ?>

  <?php

    //Defining Variables
    $typeErr = $reasonErr = "";
    $resolvement_type = $resolvement_reason = "";
    $in_id = $_GET['invoice_id'];
    $dispute_id = $_GET['dispute_id'];

    if(isset($_POST['file_case'])) {
	if($_SESSION['user_id'] == $fetch_dispute['buyer_id']) {
	  echo "<script>alert('File dispute cannot be finalised by the dispute consumer!'); </script>";
  	} else {

	if(empty($_POST['dispute_type']) || empty($_POST['dispute_reason'])) {
	  echo "<h3 style='color:red;'>Please select from options to proceed successfully with the case dispute.</h3>";		
	} else {
	  $resolvement_type = $_POST['dispute_type'];
	  $resolvement_reason = $_POST['dispute_reason'];

	  $update_dispute = mysqli_query($con,"update FYP_Disputes set dispute_status='Completed', admin_id='$_SESSION[user_id]', resolvement_type='$resolvement_type', resolvement_details='$resolvement_reason' where invoice_id='$_GET[invoice_id]' and dispute_id='$_GET[dispute_id]' ");
	  $update_status_payment = mysqli_query($con, "update FYP_Payments set payment_status='Completed' where invoice_id='$_GET[invoice_id]' ");
	
	  /* Send Successful dispute case to user */
	  //$to = $fetch_buyer['email'];  Send email to user
	  $to = "michbodzio97@yahoo.com";
	  $subject = "Dispute on Order: " . $_GET['invoice_id'] .  " was Finalised | W1712116 Online Shopping";
	  $txt = "The dispute has been  successful fnalised" . "\r\n" . "The result is: $resolvement_type" . "\r\n" . "Reason: $resolvement_reason" ;
	  $headers = "Dispute Finalised | W1712116 Online Shopping";

	if($update_dispute && $update_status_payment) {
	  echo mysqli_error($con);
	  echo "<script>alert('File dispute on order: $in_id has been resolved succesfully!') </script>" ;
	  echo "<script>window.open('index.php?action=view_dispute_information&invoice_id=$in_id&dispute_id=$dispute_id','_self') </script>";

	  //Mail the consumer with the resolvement information
	  mail($to,$subject,$txt,$headers);

	} else {
	  echo "<script>alert('Error: File dispute on order: $invoice_id has been unresolved! Try Again') </script>" ;
	}
      }	
    }}

  ?>


<div class="purchase_history_container" >

  <h3><b>Dispute Information For: </b>Order Invoice #<?php echo $fetch_payment['invoice_id']; ?></h3>
  <h4><b>Dispute Status: </b><?php echo $fetch_dispute['dispute_status']; ?></h4>
  <div class="border_bottom"></div>

  <div class="dispute_info_container">
	<p><strong>Case Filed On<br> </strong><?php echo $fetch_dispute['dispute_timestamp']; ?></p><br>
	<p><strong>Case Filed By</strong></p>
	<p><?php echo $fetch_buyer['email']; ?></p>
	<p><?php echo $fetch_buyer['name']; ?></p>
	<p><?php echo $fetch_buyer['user_address']; ?></p>
	<p><?php echo $fetch_buyer['country']; ?></p>
	<p><?php echo $fetch_buyer['postcode']; ?></p>
	<br>
	<p><strong>Dispute Type: </strong><?php echo $fetch_dispute['dispute_type']; ?></p>
	<p><strong>Dispute Reason: <br></strong><?php echo $fetch_dispute['dispute_reason']; ?></p>
  </div> <!-- /.dispute_info_container -->
     <div class="border_bottom"></div>
  <?php if($fetch_dispute['dispute_status'] == 'Ongoing' ) { ?>

  <!-- Admin Form To Resolve The Dispute -->
  <div class="resolvement_container">	    
      <form method="post" action="" id="dispute_form" enctype="multipart/form-data"> 
    <table>
	
	<tr align="left"> 
	  <td colspan="4"> 
	    <h3><b> Dispute Resolvement Area <b></h3>
	  </td>
	</tr>

	<tr>
	  <td width="30%"><b>Resolvement Type:</b></td>
	  <td colspan="4">
	    <input type="radio" id="Refunded" name="dispute_type" value="Refunded">
  	    <label for="refund">Order Returned & Refunded</label><br>
  	    <input type="radio" id="Exchanged" name="dispute_type" value="Exchanged">
  	    <label for="exchange">Order Exchanged</label><br>
  	    <input type="radio" id="Sorted_Delivery" name="dispute_type" value="Sorted_Delivery">
  	    <label for="undelivered">Order Delivery Sorted </label><br>
  	    <input type="radio" id="Other" name="dispute_type" value="Other">
  	    <label for="other">Other..</label>
	  </td>
	</tr>

	<tr>
	  <td width="30%"></td>
	  <td colspan="3"><br><p><strong>Provide a dispute resolvement information.</strong><br> Include as much information as possible, this will help your case to quarantee a successful dispute resolvement.</p><br></td>
	</tr>

	<tr>
	  <td width="30%"><b>Resolvement Dispute Details:</b></td>
	  <td colspan="3">
	    <textarea class="text_area_dispute" rows="10" cols="50" name="dispute_reason" required></textarea>
	  </td>
	</tr><br>  

	<tr align="left">
	  <td></td>
	  <td colspan="4">
	    <input style="cursor:pointer; width:20%;" type="submit" name="file_case" value="Update" />
	  </td>
	</tr>
	
    </table> 
  </form>
	
  </div> <!-- /.resolvement_container --> 

	<?php } else { ?> 

  	  <div class="dispute_info_container">
	    <h3>Dispute Resolvement Information</h3>
	    <p><strong>Case Completed On<br> </strong><?php echo $fetch_dispute['resolvement_date']; ?></p><br>
	    <p><strong>Case Completed By: <br></strong><?php echo "Name: " . $_SESSION['name'] . "<br>ID: " . $_SESSION['user_id']; ?></p>
	    <br>
	    <p><strong>Resolvement Type: </strong><?php echo $fetch_dispute['resolvement_type']; ?></p>
	    <p><strong>Resolvement Details: <br></strong><?php echo $fetch_dispute['resolvement_details']; ?></p>
  	  </div> <!-- /.dispute_info_container -->

	<?php } ?>
  <table>
 
	<tr>
	  <td colspan="7"><a href="index.php?action=view_disputes" class="back_my_order"><i class="fa fa-arrow-left"></i>  Go back to disputes</a></td>
	</tr>

  </table>



</div><!-- /.purchase_history_container -->