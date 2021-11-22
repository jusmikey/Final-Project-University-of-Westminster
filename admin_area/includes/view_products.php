
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

  <h2> View Products </h2>
  <div class="border_bottom"></div>

<div class="view_product_box">

  <form action="" method="post" enctype="multipart/form-data" />

    <table width="100%">
	<thead>
	  <tr>
	    <th>Title</th>
	    <th>Price</th>
	    <th>Image</th>
	    <th>Edit</th>
	    <th>Status</th>
	    <th>Offer</th>
	    <th>Delete</th>
	  </tr>
	</thead>

	<?php
	  $all_products = mysqli_query($con, "select * from FYP_Products order by product_id DESC");
	  
	  while($row=mysqli_fetch_array($all_products)) {
	?>
	
	<tbody>
	  <tr>
	    <td width="35%"><?php echo $row['product_title']; ?></td>
	    <td><?php echo number_format($row['product_price'],2); ?></td>
	    <td><img src="product_images/<?php echo $row['product_image']; ?>" width="65" /></td>
	    <td><a href="index.php?action=edit_pro&product_id=<?php echo $row['product_id']; ?>">Edit</a></td>	 

	    <td>
		<?php 
		   if($row['status'] == 'Approved') {
		    echo "<p style='color:lightgreen;'>Approved</p>";
		  } else {
		    echo "<p style='color:red;'>Pending</p>";
		  } 
		?>
	    </td>

	    <td>
		<?php 
		   if($row['product_offer'] == 'on') {
		    echo "<a style='color:lightgreen; text-decoration:underline;' href='index.php?action=offer_pro&pro_id=$row[product_id]'>On Offer</a>";
		  } else {
		    echo "<a style='color:red; text-decoration:underline;' href='index.php?action=offer_pro&pro_id=$row[product_id]'>Off</a>";
		  } 
		?>
	    </td>

	    <td><a href="index.php?action=view_pro&delete_product=<?php echo $row['product_id']; ?>">Delete</a></td>
	  </tr>
	</tbody>

	<?php } // End While Loop ?>

    </table>
  </form>

</div><!-- /.view_product_box -->

<?php 
  // Delete Product
  if(isset($_GET['delete_product'])) {
    $delete_product = mysqli_query($con, "delete from FYP_Products where product_id='$_GET[delete_product]'");

    if($delete_product) {
	echo "<script>alert('Product has been deleted successfully.')</script>";
	echo "<script>window.open('index.php?action=view_pro','_self')</script>";
    }
  }

?>

