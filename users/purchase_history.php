
<div class="purchase_history_container">
<h2 style="color:#FFD966;">Your Purchase History</h2><br>
<table>
 <thead>
   <tr>
     <th>Invoice</th>
     <th>Date</th>
     <th>Payment Type</th>
     <th>Delivery Status</th>
     <th>Receipt</th>
   </tr>
 </thead> 
 
 <tr><th colspan="8"><div class="border_bottom"></div></th></tr>
 
 <?php 
 $purchase_result = mysqli_query($con,"select distinct invoice_id, payment_timestamp, payment_type, payment_status from FYP_Payments where buyer_id='$_SESSION[user_id]' ");
 
 while($fetch_payment = mysqli_fetch_array($purchase_result)){
	$sel_deli = mysqli_query($con, "select * from FYP_Delivery where invoice_id='$fetch_payment[invoice_id]'");
	$fetch_deli = mysqli_fetch_array($sel_deli);
   ?>
 
 <tbody>
  <tr>        
    </td>   
    <td><?php echo $fetch_payment['invoice_id']; ?></td>
    <td><?php echo $fetch_payment['payment_timestamp']; ?></td>
    <td><?php echo $fetch_payment['payment_type']; ?></td>
    <td><?php echo $fetch_deli['delivery_status']; ?></td>
    <td><a href="my_account.php?action=view_receipt&invoice_id=<?php echo $fetch_payment['invoice_id']; ?>">Receipt</a></td>
  </tr>   
 
  <tr><td colspan="8"><div class="border_bottom"></div></td></tr>
 </tbody>
 
 <?php } ?>
 
</table>
</div><!-- /.purchase_history_container -->
