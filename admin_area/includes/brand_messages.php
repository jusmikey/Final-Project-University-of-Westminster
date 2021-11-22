<link href="../users/css/purchase_history.css" rel="stylesheet" />

<style>

  table {
	width: 100%;
  	border-collapse: collapse;
  }

  table, td, th {
  	border: 1px solid black;
	padding:5px;
  }

</style>

<div class="view_product_box" >
  <h2>Brand-Support Area</h2>
  <div class="border_bottom"></div><br>

  <table>

    <thead>
	<tr>
	  <th>Chat Access</th>
	  <th>Brand Title</th>
	  <th>Date & Time</th>
	</tr>
    </thead>

    <?php 
	//$messages = mysqli_query($con, "select distinct brand_id, message_timestamp from FYP_BrandServiceChat group by brand_id, message_timestamp order by min(message_timestamp) desc");
	$messages = mysqli_query($con, "select brand_id, max(message_timestamp) from FYP_BrandServiceChat group by brand_id order by min(message_timestamp) desc");

	while($row = mysqli_fetch_array($messages)) {
	$select_time = mysqli_query($con, "select message_timestamp from FYP_BrandServiceChat where brand_id='$row[brand_id]' ");
	$row_date = mysqli_fetch_array($select_time);

	$select_bid = mysqli_query($con, "select * from FYP_BrandUsers where brand_id='$row[brand_id]' ");
	$row_bid = mysqli_fetch_array($select_bid);
	  
    ?>
    <tbody>
	<tr>
	  <td><a href="index.php?action=view_brand_chat&brand_id=<?php echo $row['brand_id']; ?>">Enter Chat</a></td>
	  <td><?php echo $row_bid['brand_title']; ?></td>
	  <td><?php echo $row_date['message_timestamp']; ?></td>
	</tr> 
    </tbody>

    <?php } //End while loop ?> 

  </table>


</div><!-- /.view_product_box --> 