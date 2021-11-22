   <head>
    <style>

	table, td, th {
  	  border: 1px solid black;
	  padding:5px;
	}

	table {
  	  width: 100%;
  	  border-collapse: collapse;
	}

    </style>
  </head>

  <h2> View Brands </h2>
  <div class="border_bottom"></div>

<div class="view_product_box">

  <form action="" method="post" enctype="multipart/form-data" />

    <table width="100%">
	<thead>
	  <tr>
	    <th>Brand Title</th>
	    <th>Edit</th>
	    <th>Delete</th>
	  </tr>
	</thead>

	<?php
	  $all_brands = mysqli_query($con, "select * from FYP_Brands order by brand_id DESC");
	  
	  while($row=mysqli_fetch_array($all_brands)) {
	?>
	
	<tbody>
	  <tr>
	    <td><?php echo $row['brand_title']; ?></td>
	    <td><a href="index.php?action=edit_brand&brand_id=<?php echo $row['brand_id']; ?>">Edit</a></td>

	  <?php 
	    $sel_user = mysqli_query($con, "select * from FYP_BrandUsers where brand_title='$row[brand_title]'");
	    $fetch_bid = mysqli_fetch_array($sel_user);

	    if(mysqli_num_rows($sel_user) != 0) {
	    	echo "<td><a href='index.php?action=edit_brand_users&brand_id=$fetch_bid[brand_id]'>Remove Brand Owner</a></td>";
	    } else { ?>
	    	<td><a href="index.php?action=view_brand&delete_brand=<?php echo $row['brand_id']; ?>">Delete</a></td>

	   <?php } ?>
	  </tr>
	</tbody>

	<?php } // End While Loop ?>

    </table>
  </form>

</div><!-- /.view_product_box -->

<?php 
  // Delete Brand
  if(isset($_GET['delete_brand'])) {
    $delete_brand = mysqli_query($con, "delete from FYP_Brands where brand_id='$_GET[delete_brand]'");

    if($delete_brand) {
	echo "<script>alert('Brand has been deleted successfully.')</script>";
	echo "<script>window.open('index.php?action=view_brand','_self')</script>";
    }
  }

?>

