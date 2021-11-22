<head>

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

</head>

  <h2>View Guest Deliveries</h2>
  <div class="border_bottom"></div>

  <div class="view_product_box">

  <table>
    <tr>
      <th>View Delivery</th>
      <th>Invoice Number</th> 
      <th>User Email</th>
      <th>Delivery Status</th>
      <th>Delivery Time</th> 
      <th>Delivery Date</th>
      <th>Receipt</th>
    </tr>

    <?php 
	$display_delivery = mysqli_query($con, "select invoice_id from FYP_Delivery where customer_type='guest' group by invoice_id order by min(delivery_datetime) desc ");

	while($fetch_delivery = mysqli_fetch_array($display_delivery)) { 

	  $select_delivery = mysqli_query($con, "select * from FYP_Delivery where invoice_id='$fetch_delivery[invoice_id]'");
	  $row = mysqli_fetch_array($select_delivery);
	  
	echo " <tr>
		  <td><a href='index.php?action=display_guest_delivery&invoice_id=$row[invoice_id]'>View</a></td>
      		  <td>$row[invoice_id]</td>
      		  <td>$row[guest_email]</td>
      		  <td>$row[delivery_status]</td> ";

	if($row['delivery_type'] == 'morning') {
	  echo "<td>10:00 til 16:00</td>";
	} else {
	  echo "<td>16:00 til 21:00</td>";
	}

      	echo "<td>$row[delivery_datetime]</td>";

	echo "<td><a href='index.php?action=view_receipt&invoice_id=$row[invoice_id]'>View</a></td>";


	} //End while loop
  ?>
    </tr>
  </div> <!---- /.view_product_box ---->
  </table>
