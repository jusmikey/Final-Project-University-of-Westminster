   <head>
    <style>

	table, td, th {
  	  border: 1px solid black;
	}

	table {
  	  width: 100%;
  	  border-collapse: collapse;
	}

    </style>
  </head>

  <h2> Live Product Offers </h2>
  <div class="border_bottom"> </div><!-- /.border_bottom -->

<?php
  
  $select_pro = mysqli_query($con, "select * from FYP_Products where product_offer='on'");
  $fetch_pro = mysqli_fetch_array($select_pro);

?>

<div class="view_product_box">

  <form action="" method="post" enctype="multipart/form-data" />

    <table>
	<thead>
	  <tr>
	    <th>Title</th>
	    <th>Brand</th>
	    <th>Original Price</th>
	    <th>Offer Price</th>
	    <th>Image</th>
	    <th>Edit Offer</th>
	    <th>Status</th>
	  </tr>
	</thead>

	<?php
	  $all_products = mysqli_query($con, "select * from FYP_Products where product_offer='on' order by product_id DESC");

	  while($row = mysqli_fetch_array($all_products)) {
	    $select_bid = mysqli_query($con, "select * from FYP_Brands where brand_id='$fetch_pro[product_brand]'");
  	    $fetch_bid = mysqli_fetch_array($select_bid);

	?>
	
	<tbody>
	  <tr>
	    <td style="width:30%;"><?php echo $row['product_title']; ?></td>
	    <td style="width:15%;"><?php echo $fetch_bid['brand_title']; ?></td>
	    <td style="width:9%;"><?php echo "&#163;" . number_format($row['product_price'],2); ?></td>
	    <td style="width:9%;"><?php echo "&#163;" . number_format($row['offer_price'],2); ?></td>
	    <td><img src="../admin_area/product_images/<?php echo $row['product_image']; ?>" width="65" /></td>
	    <td><a href="index.php?action=offer_pro&pro_id=<?php echo $row['product_id']; ?>">Edit Offer</a></td>	 
	    <td>
		<?php 
		   if($row['status'] == 'Approved') {
		    echo "<p style='color:lightgreen;'>Approved</p>";
		  } else {
		    echo "<p style='color:red;'>Pending</p>";
		  } 
		?>
	    </td>
	  </tr>
	</tbody>

	<?php } // End While Loop ?>
    </table><br>
  </form>

</div><!-- /.view_product_box -->
