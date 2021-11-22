
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

  if(isset($_GET['status_invoice'])) {
    $status_invoice = $_GET['status_invoice'];

    if(isset($_GET['status'])) {
	$status = $_GET['status'];
	
	if($status == 'pending') {
	  $update_status = "update FYP_Payments set payment_status='Completed' where invoice_id='$status_invoice'";
	} else {
	  $update_status = "update FYP_Payments set payment_status='pending' where invoice_id='$status_invoice'";
	}

	$update_payment_status = mysqli_query($con, $update_status);
    }
  }

?>


  <h2>View Payment Orders</h2>
  <div class="border_bottom"></div>
  <div class="view_product_box" >

  <table>

    <thead>
	<tr>
	  <th>Invoice ID</th>
	  <th>Date</th>
	  <th>Payment Email</th>
	  <th>Payment Type</th>
	  <th>Receipt</th>
	</tr>
    </thead>

       <?php 
	$display_payment = mysqli_query($con, "select invoice_id from FYP_Payments group by invoice_id order by min(payment_timestamp) desc ");

	while($fetch_payment = mysqli_fetch_array($display_payment)) { 

	  $select_order = mysqli_query($con, "select * from FYP_Payments where invoice_id='$fetch_payment[invoice_id]'");
	  $row = mysqli_fetch_array($select_order);
	  
	echo " <tr>
		  <td>$row[invoice_id]</td>
      		  <td>$row[payment_timestamp]</td>
      		  <td>$row[payer_email]</td>
      		  <td>$row[payment_type]</td> "; 
      		  
      	echo "<td><a href='index.php?action=view_receipt&invoice_id=$row[invoice_id]'>View</a></td>";

	} //End while loop
  ?>
    </tr>
 

   </table>


</div><!-- /.view_product_box -->