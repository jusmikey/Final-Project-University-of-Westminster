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
  <div class="border_bottom"> </div><!-- /.border_bottom -->

<?php
  $select_brand = mysqli_query($con, "select * from FYP_BrandUsers where brand_id='$_GET[brand_id]'");
  $fetch_brand = mysqli_fetch_array($select_brand);

  $select_bid = mysqli_query($con, "select * from FYP_Brands where brand_title='$fetch_brand[brand_title]'");
  $fetch_bid = mysqli_fetch_array($select_bid);


  if($fetch_brand['status'] == 'Pending') {

?>

  <p>Currently you have not been approved by the service, please be patient.</p>
  <p>Come back another time, and you will be able to insert your products.</p>

<?php } else { ?>

<div class="view_product_box">

  <form action="" method="post" enctype="multipart/form-data" />

    <table width="100%">
	<thead>
	  <tr>
	    <th><input type="checkbox" id="checkAll" />Check</th>
	    <th>Title</th>
	    <th>Price</th>
	    <th>Image</th>
	    <th>Edit</th>
	    <th>Status</th>
	    <th>Offer Status</th>
	    <th>Offer Price</th>
	    <th>Delete</th>
	  </tr>
	</thead>

	<?php
	  $all_products = mysqli_query($con, "select * from FYP_Products where product_brand='$fetch_bid[brand_id]' order by product_id DESC");
	  $i = 1;

	  while($row = mysqli_fetch_array($all_products)) {
	  
	?>
	
	<tbody>
	  <tr>
	    <td><input type="checkbox" name="deleteAll[]" value="<?php echo $row['product_id']; ?>" /><?php echo $i; ?></td>
	    <td><?php echo $row['product_title']; ?></td>
	    <td><?php echo "&#163;" . number_format($row['product_price'],2); ?></td>
	    <td><img src="../admin_area/product_images/<?php echo $row['product_image']; ?>" width="65" /></td>
	    <td><a href="index.php?action=edit_pro&product_id=<?php echo $row['product_id']; ?>&brand_id=<?php echo $fetch_brand['brand_id']; ?>">Edit</a></td>	 
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
		    echo "<a style='color:lightgreen; text-decoration:underline;' href='index.php?action=offer_pro&brand_id=$fetch_brand[brand_id]&pro_id=$row[product_id]'>On Offer</a>";
		  } else {
		    echo "<a style='color:red; text-decoration:underline;' href='index.php?action=offer_pro&brand_id=$fetch_brand[brand_id]&pro_id=$row[product_id]'>Off</a>";
		  } 
		?>
	    </td>
	    <td>
		<?php 
		   if(!empty($row['offer_price'])) {
		    echo "<p> &#163;" . number_format($row['offer_price'], 2) . "</p>";
		  } else {
		    echo "<p style='color:red;'>Not on Offer</p>";
		  } 
		?>
	    </td>
	    <td><a href="index.php?action=view_pro&brand_id=<?php echo $fetch_brand['brand_id']; ?>&delete_product=<?php echo $row['product_id']; ?>">Delete</a></td>
	  </tr>
	</tbody>

	<?php $i++;  } // End While Loop ?>
    </table><br>
	
	  <input type="submit" name="delete_all" value="Remove" />
	

  </form>

</div><!-- /.view_product_box -->

<?php 
  // Delete Product
  if(isset($_GET['delete_product'])) {
    $delete_product = mysqli_query($con, "delete from FYP_Products where product_id='$_GET[delete_product]'");

    if($delete_product) {
	echo "<script>alert('Product has been deleted successfully.')</script>";
	echo "<script>window.open('index.php?action=view_pro&brand_id=$fetch_brand[brand_id]','_self')</script>";
    }
  }

  //Remove items selected using foreach loop
  if(isset($_POST['deleteAll'])) {
    $remove = $_POST['deleteAll'];

    foreach($remove as $key) {
	$run_remove = mysqli_query($con, "delete from FYP_Products where product_id='$key'");
	
	if($run_remove) {
		echo "<script>alert('Items have been removed successfully.')</script>";
		echo "<script>window.open('index.php?action=view_pro&brand_id=$fetch_brand[brand_id]','_self')</script>";
	} else {
		echo "<script>alert('Failed to delete product.')</script>";
	}
    }
  }

?>

<?php } // End if pending status ?>

