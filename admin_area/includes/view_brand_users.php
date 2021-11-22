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

  <h2> All Brand Owners </h2>
  <div class="border_bottom"></div>

<div class="view_product_box">
  <table>
    <tr>
      <th>View</th>
      <th>Brand ID</th>
      <th>User ID</th> 
      <th>Business Number</th>
      <th>Brand Title</th> 
      <th>Contact</th>
      <th>Register Date</th>
      <th>Status</th> 
    </tr>

  <?php 
	$display_user = mysqli_query($con, "select * from FYP_BrandUsers order by register_date desc");
	while($row = mysqli_fetch_array($display_user)) {

	  echo " <tr>
		  <td><a href='index.php?action=edit_brand_users&brand_id=$row[brand_id]'>Enter</a></td>
      		  <td>$row[brand_id]</td>
      		  <td>$row[user_id]</td>
      		  <td>$row[brand_number]</td>
      		  <td>$row[brand_title]</td>
      		  <td>$row[brand_contact]</td>
      		  <td>$row[register_date]</td>";

	  if($row['status'] == 'Pending') {
      	    echo "<td style='color:red;'>$row[status]</td>"; 
    	  } else {
	    echo "<td style='color:lightgreen;'>$row[status]</td>";
	  }
	}
  ?>
    </tr>
  </table>
</div> <!--- /.view_product_box --->
