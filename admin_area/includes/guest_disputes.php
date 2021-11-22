<link href="../users/css/purchase_history.css" rel="stylesheet" />

<style>

 table, td, th {
    border: 1px solid black;
    text-align:left;
    padding:5px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  .set_status {
	position:relative;
	width:12%;
  }

  .set_status a {
	text-decoration:none;
	color:blue;
  }

</style>

<?php 

  if(isset($_GET['status_invoice'])) {
    $status_invoice = $_GET['status_invoice'];

    if(isset($_GET['status'])) {
	$status = $_GET['status'];
	
	if($status == 'Ongoing') {
	  $update_status = "update FYP_Disputes set dispute_status='Completed' where invoice_id='$status_invoice'";
	} else {
	  $update_status = "update FYP_Disputes set dispute_status='Ongoing' where invoice_id='$status_invoice'";
	}

	$update_dispute_status = mysqli_query($con, $update_status);
    }
  }

?>



  <h2>List of Guest Order Disputes</h2>
  <div class="border_bottom"></div><br>

<div class="view_products_box" >
  <table>

    <thead>
	<tr>
	  <th colspan="2">Dispute Status</th>
	  <th>Invoice</th>
	  <th>Date</th>
	  <th>Dispute Information</th>
	  <th>Dispute Type</th>
	  <th>Order Receipt</th>
	</tr>
    </thead>

    <?php 
	$purchase_result = mysqli_query($con, "select * from FYP_Disputes where consumer_type='guest' order by dispute_timestamp desc ");

	while($fetch_payment = mysqli_fetch_array($purchase_result)) {
    ?>

    <tbody>
	<tr>
	  <td colspan="2" width="35%" class="set_status">
	    <?php 
		if($fetch_payment['dispute_status'] == 'Ongoing') {
		  $image_src = 'images/invisible.gif';
		  $payment_text = 'Ongoing';
	   	} else {
		  $image_src = 'images/visible.gif';
		  $payment_text = 'Completed';
		}
	    ?>
	    	    <img src="<?php echo $image_src; ?>" />
	    <small>
		<?php echo $payment_text; ?>
	    </small>
	    </a>
	  </td><!-- /.set_status -->

	  <td><small><?php echo $fetch_payment['invoice_id']; ?></small></td>
	  <td><small><?php echo $fetch_payment['dispute_timestamp']; ?></small></td>
	  <td><a href="index.php?action=view_guest_dispute_information&invoice_id=<?php echo $fetch_payment['invoice_id']; ?>&dispute_id=<?php echo $fetch_payment['dispute_id']; ?>">Dispute Case Information<a/></td>
	  <td><small><?php echo $fetch_payment['dispute_type']; ?></small></td>


	  <td><a href="index.php?action=view_receipt&invoice_id=<?php echo $fetch_payment['invoice_id']; ?>">Receipt<a/></td>
	<tr>

    </tbody>

    <?php } //End while loop ?> 

  </table>

</div><!-- /.view_products_box -->