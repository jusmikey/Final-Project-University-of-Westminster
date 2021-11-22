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

<div class="view_product_box">
  <h2> View Categories </h2>
  <div class="border_bottom"></div>

  <form action="" method="post" enctype="multipart/form-data" />

    <table width="100%">
	<thead>
	  <tr>
	    <th>Category Title</th>
	    <th>Edit</th>
	    <th>Delete</th>
	  </tr>
	</thead>

	<?php
	  $all_categories = mysqli_query($con, "select * from FYP_Categories order by cat_id DESC");
	  
	  while($row=mysqli_fetch_array($all_categories)) {
	?>
	
	<tbody>
	  <tr>
	    <td><?php echo $row['cat_title']; ?></td>
	    <td><a href="index.php?action=edit_cat&cat_id=<?php echo $row['cat_id']; ?>">Edit</a></td>
	    <td><a href="index.php?action=view_cat&delete_cat=<?php echo $row['cat_id']; ?>">Delete</a></td>
	  </tr>
	</tbody>

	<?php } // End While Loop ?>

    </table>
  </form>

</div><!-- /.view_product_box -->

<?php 
  // Delete Category
  if(isset($_GET['delete_cat'])) {
    $delete_cat = mysqli_query($con, "delete from FYP_Categories where cat_id='$_GET[delete_cat]'");

    if($delete_cat) {
	echo "<script>alert('Category has been deleted successfully.')</script>";
	echo "<script>window.open('index.php?action=view_cat','_self')</script>";
    }
  }

?>

