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

  <h2>Teams of Brands</h2>
  <div class="border_bottom"></div>

<div class="view_product_box">

  <table>
    <tr>
      <th>View Team</th>
      <th>Brand Title</th> 
      <th>Brand ID</th>
      <th>Manager ID</th> 
      <th>Business Number</th>
    </tr>

  <?php 
	$display_user = mysqli_query($con, "select * from FYP_BrandUsers order by register_date desc");

	while($row = mysqli_fetch_array($display_user)) {
	  $bid = mysqli_query($con, "select * from FYP_Brands where brand_title='$row[brand_title]'");
	  $fetch_bid = mysqli_fetch_array($bid);

	  echo " <tr>
		  <td><a href='index.php?action=display_team&brand_id=$fetch_bid[brand_id]'>View Team</a></td>
      		  <td>$row[brand_title]</td>
      		  <td>$row[brand_id]</td>
      		  <td>$row[user_id]</td>
      		  <td>$row[brand_number]</td>";
	}
  ?>
    </tr>
  </table>

</div> <!--- /.view_product_box --->
