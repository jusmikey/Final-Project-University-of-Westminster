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

<div class="view_product_box">
  <h2> View Product Comments </h2>
  <div class="border_bottom"></div>

  <form action="" method="get" enctype="multipart/form-data" />

    <table>
	<thead>
	  <tr>
	    <th>Status</th>
	    <th>Product ID</th>
	    <th>Product Title</th>
	    <th>Comment Title</th>
	    <th>Edit</th>
	    <th>Date</th>
	    <th>Remove Comment</th>
	  </tr>
	</thead>

	<?php
	  $all_comments = mysqli_query($con, "select * from FYP_Commentary order by comment_timestamp DESC");
	  
	  while($row = mysqli_fetch_array($all_comments)) {
	    $sel_title = mysqli_query($con, "select * from FYP_Products where product_id='$row[product_id]'");
	    $fetch_title = mysqli_fetch_array($sel_title);
	?>
	
	<tbody>
	  <tr>
	    <td><?php 
		  if($row['status'] == 'Approved') {
		    echo "<p style='color:lightgreen;'>Approved</p>";
		  } else {
		    echo "<p style='color:red;'>Pending</p>";
		  } 
		?>
	    </td>
	    <td><?php echo $row['product_id']; ?></td>
	    <td><?php echo $fetch_title['product_title']; ?></td>
	    <td><?php echo $row['title']; ?></td>
	    <td><a href="index.php?action=edit_comment&comment_id=<?php echo $row['id']; ?>">Edit</a></td>	 
	    <td><?php echo $row['comment_timestamp']; ?></td>
	    <td><a href="index.php?action=comments&delete_comment=<?php echo $row['id']; ?>">Remove</a></td>

<?php 

  // Delete Comment
  if(isset($_GET['delete_comment'])) {
    $delete_com = mysqli_query($con, "delete from FYP_Commentary where id='$_GET[delete_comment]'");

    if($delete_com) {
	echo "<script>alert('Comment has been deleted successfully.')</script>";
	echo "<script>window.open('index.php?action=comments','_self')</script>";
    }
  }

?>

	  </tr>
	</tbody>

	<?php } // End While Loop ?>

    </table>
  </form>

</div><!-- /.view_product_box -->