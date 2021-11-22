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

</style>
<?php 
	$purchase_result = mysqli_query($con, "select * from FYP_Payments where invoice_id='$_GET[invoice_id]'");

	$fetch_payment = mysqli_fetch_array($purchase_result);
	
	$select_buyer = mysqli_query($con,"select * from FYP_Users where id='$fetch_payment[buyer_id]'");
	$fetch_buyer = mysqli_fetch_array($select_buyer);
	$total_price = $fetch_payment['product_price'] * $fetch_payment['quantity'];
	
    ?>

<!------- FOR REGISTERED CONSUMER RECEIPT -------->

<?php if(!$fetch_payment['buyer_id'] == '') { ?>

<div class="view_product_box" >

  <h2>(Registered Consumer) Invoice: #<?php echo $fetch_payment['invoice_id']; ?></h2>
  <div class="border_bottom"></div>

  <div class="receipt_info_container">

    <div class="receipt_info_box">

	<div class="receipt_info_left">

	  <div class="receipt_info_left_box">
	    <p><strong>Sold to</strong></p>
	    <p><?php echo $fetch_buyer['email']; ?></p>
	    <p><?php echo $fetch_buyer['name']; ?></p>
	    <p><?php echo $fetch_buyer['user_address']; ?></p>
	    <p><?php echo $fetch_buyer['country']; ?></p>
	    <p><?php echo $fetch_buyer['postcode']; ?></p>
	    
	  </div><!-- /.receipt_info_left_box -->

	</div> <!-- /.receipt_info_left -->

	<div class="receipt_info_right">

	  <div class="receipt_info_right_box">
	    <p><strong>Paid to</strong></p>
	    <p>FYP_W1712116</p>
	    <p><strong>Payment Method</strong></p>
	    <p><?php echo $fetch_payment['payment_type']; ?></p>
	  </div><!-- /.receipt_info_right_box -->

	</div> <!-- /.receipt_info_right -->

    </div> <!-- /.receipt_info_box -->
    
    <div class="receipt_info_box">
	<p><strong>Invoice Date</strong></p>
	<p><?php echo $fetch_payment['payment_timestamp']; ?></p>
    </div> <!-- /.receipt_info_box -->

  </div> <!-- /.receipt_info_container -->

  <table>

    <thead>
	<tr>
	  <th colspan="2"><h2>Items</h2></th>
	  <th>Transaction ID</th>
	  <th>Ordered</th>
	  <th>Quantity</th>
	  <th>Price</th>
	  <th>Subtotal</th>
	</tr>
    </thead>

    <tr><th colspan="8"><div class="border-bottom"></div></th></tr>

    <tbody>

<?php 
 
 $total_paid = 0;
 
 $select_payment_by_invoice_id = mysqli_query($con,"select * from FYP_Payments where invoice_id='$fetch_payment[invoice_id]' ");
 
 while($fetch_multi_payments = mysqli_fetch_array($select_payment_by_invoice_id)){
  
 $select_product = mysqli_query($con, "select * from FYP_Products where product_id='$fetch_multi_payments[product_id]' ");
  
  $fetch_product = mysqli_fetch_array($select_product);
  
  $array_price = array($fetch_multi_payments['product_price']);
  
  $values = array_sum($array_price);
  
  $value_quantity = $values * $fetch_multi_payments['quantity'];
  
  $total_paid += $value_quantity;
  $total_sub = $fetch_multi_payments['product_price'] * $fetch_payment['quantity'];

 ?>

	<tr>
	  <td colspan="2" width="35%">
	    <p class="order_item">
		<a href="../details.php?pro_id=<?php echo $fetch_product['product_id']; ?>" target="_blank">
		  <?php echo $fetch_product['product_title']; ?>
		</a>
	    </p>
	  </td>

	  <td><small><?php echo $fetch_multi_payments['tx_id']; ?></small></td>
	  <td><small><?php echo $fetch_multi_payments['payment_timestamp']; ?></small></td>
	  <td align="center"><?php echo $fetch_multi_payments['quantity']; ?></td>
	  <td><small><b><?php echo "&pound;" . $fetch_multi_payments['product_price']; ?></b></small></td>
	  <td><?php echo "&pound;" . number_format($total_sub,2); ?></td>

	<tr>

    </tbody>
	<?php } //end While loop ?>

	<tr>
	  <td colspan="6"><h3> Total Paid</h3></td>
	  <td><h3><?php echo "&pound;" . number_format($total_paid,2); ?></h3></td>
	</tr>

	<tr>
	  <td colspan="7"><a href="index.php?action=view_orders" style="color:black;" class="back_my_order"><i class="fa fa-arrow-left"></i>  Go back to receipts</a></td>
	</tr>

  </table>

  <div class="additional_notes">
    <h3> Additional Notes </h3>
    <div class="border_bottom"></div>

    <p><?php echo $fetch_payment['additional_notes']; ?></p>
  </div> 

</div><!-- /.view_product_box -->

<!------- FOR GUEST RECEIPT -------->
<?php } else { ?>

<div class="view_product_box" >

  <h2>(Guest) Invoice: #<?php echo $fetch_payment['invoice_id']; ?></h2>
  <div class="border_bottom"></div>

  <div class="receipt_info_container">

    <div class="receipt_info_box">

	<div class="receipt_info_left">

	  <div class="receipt_info_left_box">
	    <p><strong>Sold to</strong></p>
	    <p><?php echo $fetch_payment['payer_email']; ?></p>
	    
	  </div><!-- /.receipt_info_left_box -->

	</div> <!-- /.receipt_info_left -->

	<div class="receipt_info_right">

	  <div class="receipt_info_right_box">
	    <p><strong>Paid to</strong></p>
	    <p>FYP_W1712116</p>
	    <p><strong>Payment Method</strong></p>
	    <p><?php echo $fetch_payment['payment_type']; ?></p>
	  </div><!-- /.receipt_info_right_box -->

	</div> <!-- /.receipt_info_right -->

    </div> <!-- /.receipt_info_box -->
    
    <div class="receipt_info_box">
	<p><strong>Invoice Date</strong></p>
	<p><?php echo $fetch_payment['payment_timestamp']; ?></p>
    </div> <!-- /.receipt_info_box -->

  </div> <!-- /.receipt_info_container -->

  <table>

    <thead>
	<tr>
	  <th colspan="2"><h2>Items</h2></th>
	  <th>Transaction ID</th>
	  <th>Ordered</th>
	  <th>Quantity</th>
	  <th>Price</th>
	  <th>Subtotal</th>
	</tr>
    </thead>

    <tr><th colspan="8"><div class="border-bottom"></div></th></tr>

    <tbody>

<?php 
 
 $total_paid = 0;
 
 $select_payment_by_invoice_id = mysqli_query($con,"select * from FYP_Payments where invoice_id='$fetch_payment[invoice_id]' ");
 
 while($fetch_multi_payments = mysqli_fetch_array($select_payment_by_invoice_id)){
  
 $select_product = mysqli_query($con, "select * from FYP_Products where product_id='$fetch_multi_payments[product_id]' ");
  
  $fetch_product = mysqli_fetch_array($select_product);
  
  $array_price = array($fetch_multi_payments['product_price']);
  
  $values = array_sum($array_price);
  
  $value_quantity = $values * $fetch_multi_payments['quantity'];
  
  $total_paid += $value_quantity;
  $total_sub = $fetch_multi_payments['product_price'] * $fetch_payment['quantity'];

 ?>

	<tr>
	  <td colspan="2" width="35%">
	    <p class="order_item">
		<a href="../details.php?pro_id=<?php echo $fetch_product['product_id']; ?>" target="_blank">
		  <?php echo $fetch_product['product_title']; ?>
		</a>
	    </p>
	  </td>

	  <td><small><?php echo $fetch_multi_payments['tx_id']; ?></small></td>
	  <td><small><?php echo $fetch_multi_payments['payment_timestamp']; ?></small></td>
	  <td align="center"><?php echo $fetch_multi_payments['quantity']; ?></td>
	  <td><small><b><?php echo "&pound;" . $fetch_multi_payments['product_price']; ?></b></small></td>
	  <td><?php echo "&pound;" . number_format($total_sub,2); ?></td>

	<tr>

    </tbody>
	<?php } //end While loop ?>

	<tr>
	  <td colspan="6"><h3> Total Paid</h3></td>
	  <td><h3><?php echo "&pound;" . number_format($total_paid,2); ?></h3></td>
	</tr>

	<tr>
	  <td colspan="7"><a style="color:black;" href="index.php?action=view_orders" class="back_my_order"><i class="fa fa-arrow-left"></i>  Go back to receipts</a></td>
	</tr>

  </table>

  <div class="additional_notes">
    <h3> Additional Notes </h3>
    <div class="border_bottom"></div>

    <p><?php echo $fetch_payment['additional_notes']; ?></p>
  </div> 

</div><!-- /.view_product_box -->

<?php } ?>
