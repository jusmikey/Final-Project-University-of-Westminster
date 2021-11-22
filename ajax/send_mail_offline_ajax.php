

<?php 

session_start();

include '../includes/db.php';

$tx_id = $_POST['tx_id'];

$mail_content = '';

$product_title = '';

$total_paid = 0;

$select_payment_by_tx_id = mysqli_query($con,"select * from FYP_Payments where tx_id='$tx_id' ");

if(mysqli_num_rows($select_payment_by_tx_id) == 1){
    $space = '.';
}
if(mysqli_num_rows($select_payment_by_tx_id) > 1){
    $space = ', ';
}

$select_customer = mysqli_query($con,"select * from FYP_Users where id='$_SESSION[user_id]' ");
$fetch_customer = mysqli_fetch_array($select_customer);
$customer_name = $fetch_customer['name'];

while($fetch_payment = mysqli_fetch_array($select_payment_by_tx_id)){
 
 $select_product_by_mail = mysqli_query($con,"select * from FYP_Products where product_id = '$fetch_payment[product_id]' ");
 
 $fetch_product = mysqli_fetch_array($select_product_by_mail);
 
 $product_title .= $fetch_product['product_title'] . $space;
 
 $array_price = array($fetch_payment['product_price']);
 
 $sum_price = array_sum($array_price);
 
 $values = $sum_price * $fetch_payment['quantity'];
 
 $total_paid += $values;

  $new_total = number_format($total_paid,2);
 
    $mail_content .= '<tr>
      <td>'.$fetch_product["product_title"].'</td>
      <td>'.$fetch_payment["quantity"].'</td>
      <td>&#163;'.$fetch_payment["product_price"].'</td>
      <td>'.$fetch_payment["invoice_id"].'</td>
      <td>'.$fetch_payment["payment_timestamp"].'</td>
   </tr>';
}

  //Purchase & Order Email to Consumer
  $to = "michbodzio97@yahoo.com"; //$to = $_SESSION['email'];

  $subject = "Purchase Order Successful | W1712116 Online Shopping";

  $message = '
    <html>
 	<p>
 	  Hello <b style="color:blue">'.$customer_name.',</b>
 	</p>
 
 	<p>
 	  We appreciate your recent order !
 	</p>
 
 	<table width="100%" align="left" border="0">
   	  <tr>
    	    <td colspan="6"><h2>Your Order Details from W1712116 Online Shopping</h2></td>
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
     	    <td><h3>&#163;'.$new_total.'</h3></td>
   	  </tr>
 	</table>
 
 	<h3>If you have any questions, please do not hesitate to contact us - W1712116 Online Shopping</h3>
 
    </html>
  ';

  // Always set content-type when sending HTML email
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

  // More headers
  $headers .= 'FYP_w1712116 | Online Shopping' . "\r\n";

  $send_mail = mail($to,$subject,$message,$headers);

  if($send_mail){
    echo 1;
  }else{
    echo 0;
  }
?>