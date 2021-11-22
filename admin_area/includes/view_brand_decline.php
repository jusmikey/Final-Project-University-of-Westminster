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


<h2>List of Declined Brand Team Members</h2>
  <div class="border_bottom"></div>

<div class="view_product_box">

  <table>
    <tr>
      <th>User ID</th>
      <th>Name</th> 
      <th>Email</th>
      <th>Brand Title</th>
      <th>Team Invitation Date</th>
      <th>Member Status</th> 
      <th>Remove</th>
    </tr>

  <?php 
	$display_team = mysqli_query($con, "select * from FYP_BrandTeams where status='Declined' order by team_timestamp desc");

	while($row = mysqli_fetch_array($display_team)) {
	  $name = mysqli_query($con, "select * from FYP_Users where id='$row[user_id]'");
          $fetch_name = mysqli_fetch_array($name);

	  $brand = mysqli_query($con, "select * from FYP_Brands where brand_id='$row[brand_id]'");
          $fetch_b = mysqli_fetch_array($brand);

	  echo " <tr>
		  <td>$row[user_id]</td>
      		  <td>$fetch_name[name]</td>
      		  <td>$row[email]</td>
      		  <td>$fetch_b[brand_title]</td>
		  <td>$row[team_timestamp]</td> ";

	  if($row['status'] == 'Approved') {
	    echo "<td style='color:lightgreen;'>$row[status]</td>"; 
	  } elseif($row['status'] == 'Pending') {
	    echo "<td style='color:red;'>$row[status]</td>";
	  } else {
	    echo "<td style='color:blue;'>$row[status]</td>";
	  }

	  echo "<td><a href='index.php?action=view_brand_decline&delete_user=$row[user_id]'>Remove</a></td>";

	  if(isset($_GET['delete_user'])) {
    	    $delete_user = mysqli_query($con, "delete from FYP_BrandTeams where user_id='$_GET[delete_user]'");

    	    if($delete_user) {
		echo "<script>alert('User has been removed from brand team successfully.')</script>";
		echo "<script>window.open('index.php?action=view_brand_decline','_self')</script>";
    	    } else {
       		//echo "<script>alert('This user failed to remove from Brand Teams, try again.');</script>";
       		echo mysqli_error($con);
	    }
	  }
      		  
	}
  ?>
    </tr>
  </table>

</div> <!--- /.view_product_box --->
