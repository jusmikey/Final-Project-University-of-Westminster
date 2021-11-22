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

  <h2> View Diet Ranges </h2>
  <div class="border_bottom"></div>

<div class="view_product_box">

  <form action="" method="post" enctype="multipart/form-data" />

    <table width="100%">
	<thead>
	  <tr>
	    <th>Diet Range Title</th>
	    <th>Edit</th>
	    <th>Delete</th>
	  </tr>
	</thead>

	<?php
	  $all_diets = mysqli_query($con, "select * from FYP_DietaryRange order by diet_id DESC");
	  
	  while($row=mysqli_fetch_array($all_diets)) {
	?>
	
	<tbody>
	  <tr>
	    <td><?php echo $row['diet_title']; ?></td>
	    <td><a href="index.php?action=edit_diet&diet_id=<?php echo $row['diet_id']; ?>">Edit</a></td>	 
	    <td><a href="index.php?action=view_diet&delete_diet=<?php echo $row['diet_id']; ?>">Delete</a></td>
	  </tr>
	</tbody>

	<?php } // End While Loop ?>
    </table>
  </form>

</div><!-- /.view_product_box -->

<?php 
 // Delete Diet
  if(isset($_GET['delete_diet'])) {
    $delete_diet = mysqli_query($con, "delete from FYP_DietaryRange where diet_id='$_GET[delete_diet]'");

    if($delete_diet) {
	echo "<script>alert('Diet Range has been deleted successfully.')</script>";
	echo "<script>window.open('index.php?action=view_diet','_self')</script>";
    }
  }

?>

