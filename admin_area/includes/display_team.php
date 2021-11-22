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


<h2>Team Brand ID: <?php echo $_GET['brand_id']; ?> </h2>
  <div class="border_bottom"></div> 

  <?php 
    $display_user = mysqli_query($con, "select * from FYP_BrandTeams where brand_id='$_GET[brand_id]' order by team_timestamp desc");
    $fetch_team = mysqli_fetch_array($display_user);

    $bid = mysqli_query($con, "select * from FYP_Brands where brand_id='$_GET[brand_id]'");
    $fetch_bid = mysqli_fetch_array($bid);
  ?>

  <br><h3>Brand Title: <?php echo $fetch_bid['brand_title']; ; ?></h3>
  <h3>Manager ID: <?php echo $fetch_team['manager_id']; ?></h3><br>

<div class="view_product_box">

  <table>
    <tr>
      <th>Team Member ID</th>
      <th>Name</th> 
      <th>Email</th>
      <th>Membership Date</th>
      <th>Member Status</th> 
    </tr>

  <?php 
	$display_team = mysqli_query($con, "select * from FYP_BrandTeams where brand_id='$_GET[brand_id]' order by team_timestamp desc");

	while($row = mysqli_fetch_array($display_team)) {
	  $name = mysqli_query($con, "select * from FYP_Users where id='$row[user_id]'");
          $fetch_name = mysqli_fetch_array($name);


	  echo " <tr>
		  <td>$row[user_id]</td>
      		  <td>$fetch_name[name]</td>
      		  <td>$row[email]</td>
		  <td>$row[team_timestamp]</td> ";

	  if($row['status'] == 'Approved') {
	    echo "<td style='color:lightgreen;'>$row[status]</td>"; 
	  } elseif($row['status'] == 'Pending') {
	    echo "<td style='color:red;'>$row[status]</td>";
	  } else {
	    echo "<td style='color:blue;'>$row[status]</td>";
	  }
      		  
	}
  ?>
    </tr>
  </table>

</div> <!--- /.view_product_box --->
