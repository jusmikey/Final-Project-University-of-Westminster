<?php 
  $ip = get_ip();
  $sel_cart = mysqli_query($con, "select * from FYP_Cart where ip_address='$ip'");
  $row_cart = mysqli_fetch_array($sel_cart);
 
?>

<?php if(mysqli_num_rows($sel_cart) == 1) { 

  $result_p = mysqli_query($con, "select * from FYP_Products where product_id='$row_cart[product_id]'");
  $row_p = mysqli_fetch_array($result_p); ?>


<!-- Real Payment just Using this url:  https://www.paypal.com/cgi-bin/webscr -->
<!-- <form action="https://www.paypal.com/cgi-bin/webscr" method="post"> -->

<!-- Testing Environment using url: sandbox.paypal -->
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

  <!-- Identify your business so that you can collect the payments. -->
  <input type="hidden" name="business" value="sb-nvhok4864602@business.example.com">

  <!-- Specify a Buy Now button. -->
  <input type="hidden" name="cmd" value="_xclick">

  <!-- Specify details about the item that buyers will purchase. -->
  <input type="hidden" name="item_name" value="<?php echo $row_p['product_title']; ?>">
  <input type="hidden" name="item_number" value="<?php echo $row_p['product_id']; ?>">

  <!----- IF product on offer ----->
  <?php if($row_p['product_offer'] == 'off') { ?>
  <input type="hidden" name="amount" value="<?php echo $row_p['product_price']; ?>">

  <?php } elseif($row_p['product_offer'] == 'on') { ?>
  <input type="hidden" name="amount" value="<?php echo $row_p['offer_price']; ?>">

  <?php } ?>

  <input type="hidden" name="currency_code" value="GBP">
  <input type="hidden" name="quantity" value="<?php echo $row_cart['quantity']; ?>">

  <input type="hidden" name="return" value="https://w1712116.users.ecs.westminster.ac.uk/w1712116_FYP_Final/payment_successful.php">
  <input type="hidden" name="cancel_return" value="https://w1712116.users.ecs.westminster.ac.uk/shirts/index.php">

  <!-- Display the payment button. -->
  <input type="image" name="submit" border="0"
  src="images/checkout_button.png"
  alt="Buy Now">
  <img alt="" border="0" width="1" height="1"
  src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >

</form>

<?php } elseif(mysqli_num_rows($sel_cart) > 1) { ?>

<?php 

  function get_cart_list() {
    global $con;
    global $ip;

    $sel_cart = mysqli_query($con, "select * from FYP_Cart where ip_address='$ip'");
    $return = array();

    while($fetch_cart = mysqli_fetch_array($sel_cart)) {
	$return[] = $fetch_cart;
    }
    return $return;
}

  $cart_list = get_cart_list();
  $paypal_form = '';
  $paypal_form .= '

<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
  <input type="hidden" name="business" value="sb-nvhok4864602@business.example.com">
  <input type="hidden" name="cmd" value="_cart">
  <input type="hidden" name="upload" value="1">
  <input type="hidden" name="return" value="https://w1712116.users.ecs.westminster.ac.uk/w1712116_FYP_Final/payment_successful.php">
  <input type="hidden" name="cancel_return" value="https://w1712116.users.ecs.westminster.ac.uk/shirts/index.php">

';

  $i = 0;
  foreach($cart_list as $each_item) {
  $i++;

  $item_name = $each_item['product_title'];
  $product_id = $each_item['product_id'];
  $price = $each_item['product_price'];
  $quantity = $each_item['quantity'];
  $paypal_form .= '
  <input type="hidden" name="item_name_'.$i.'" value="'.$item_name.'">
  <input type="hidden" name="item_number_'.$i.'" value="'.$product_id.'">
  <input type="hidden" name="amount_'.$i.'" value="'.$price.'">
  <input type="hidden" name="quantity_'.$i.'" value="'.$quantity.'">
  ';

  }

  $paypal_form .= '
  <input type="hidden" name="currency_code" value="GBP">
  <input type="image" name="submit_btn" border="0"
  src="images/checkout_button.png"
  alt="Buy Now">
  <img alt="" border="0" width="1" height="1"
  src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >

</form> 
';
echo $paypal_form;

?>

<?php } elseif(mysqli_num_rows($sel_cart) == 0) {
	echo "<script>alert('Could not proceed with checkout because your cart is empty.')</script>";
	echo "<script>window.location.replace('checkout.php?payment=process&location=$_GET[location]');</script>";

} ?>