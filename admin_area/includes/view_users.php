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
  <h2> View All Registered Users </h2>
  <div class="border_bottom"></div>

  <form action="" method="post" enctype="multipart/form-data" />

    <table width="100%">
	<thead>
	  <tr>
	    <th>User ID</th>
	    <th>Name</th>
	    <th>Email</th>
	    <th>Image</th>
	    <th>Registration Date</th>
	    <th>Country</th>
	    <th>Role</th>
	    <th>Remove</th>
	  </tr>
	</thead>

	<?php
	  $all_users = mysqli_query($con, "select * from FYP_Users order by id DESC");
	  
	  while($row=mysqli_fetch_array($all_users)) {
	?>
	
	<tbody>
	  <tr>
	    <td><?php echo $row['id']; ?></td>
	    <td><?php echo $row['name']; ?></td>
	    <td><?php echo $row['email']; ?></td>
	    <td>
		<?php if($row['image'] =='') { ?>
	    <img src="../images/userIcon.png" width="65" />
		<?php } else { ?>
	    <img src="../upload-files/<?php echo $row['image']; ?>" width="65" />
		<?php } ?>
	    </td> 
	    <td><?php echo $row['registerDateTime']; ?></td>
	    <td><?php echo $row['country']; ?></td>

	    <?php if($row['role'] == 'guest') { ?>
		<td><a href="index.php?action=edit_user&user_id=<?php echo $row['id']; ?>">Consumer</a></td>
	    <?php } else { ?>
		<td><a href="index.php?action=edit_user&user_id=<?php echo $row['id']; ?>">Admin</a></td>
	    <?php } ?>

	    <td><a href="index.php?action=view_users&delete_user=<?php echo $row['id']; ?>">Remove</a></td>
	  </tr>
	</tbody>

	<?php } // End While Loop ?>

    </table>
  </form>

</div><!-- /.view_product_box -->

<?php 
  // Delete User
  if(isset($_GET['delete_user'])) {
    $delete_user = mysqli_query($con, "delete from FYP_Users where id='$_GET[delete_user]'");

    if($delete_user) {
	echo "<script>alert('User Account has been removed successfully.')</script>";
	echo "<script>window.open('index.php?action=view_users','_self')</script>";
    }
  }


?>

