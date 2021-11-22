
<?php 

  $comment = mysqli_query($con, "select * from FYP_Commentary where id='$_GET[comment_id]'");
  $fetch_comment = mysqli_fetch_array($comment);

?>

<?php

  if(isset($_POST['remove'])) {

    //Removing a comment
    $remove_com = mysqli_query($con, "delete from FYP_Commentary where id='$_GET[comment_id]' ");

    if($remove_com) {
      echo "<script>alert('Comment has been removed successfully.');</script>";
      echo "<script>window.location.replace('index.php?action=comments');</script>";
    } else {
      echo "<script>alert('Comment removing was unsuccessful.');</script>";
    }
  }

?>

<?php
  if(isset($_GET['status']) == 'Approved') {
    $update_com = mysqli_query($con, "update FYP_Commentary set status='Approved' where id='$_GET[comment_id]'");

    if($update_com) {
      echo "<p style='color:white; padding:5px; background:lightgreen;'>This comment has been approved.</p><br>";
    } else {
      echo "<p style='color:white; padding:5px; background:red;'>There has been error with approving this comment.</p><br>";
    }
  }

  $star = "";

  if($fetch_comment['rating'] == 1) {
    $star = "../images/star_one.png";
  } elseif($fetch_comment['rating'] == 2) {
    $star = "../images/star_two.png";
  } elseif($fetch_comment['rating'] == 3) {
    $star = "../images/star_three.png";
  } elseif($fetch_comment['rating'] == 4) { 
    $star = "../images/star_four.png";
  } else {
    $star = "../images/star_five.png";
  }

?>

<div class="container_brand"> <!----- /.container_brand ----->
<h2>Comment ID: <?php echo $fetch_comment['id']; ?></h2><br>
<?php 
  if($fetch_comment['status'] == 'Pending') {
    echo "<p><b>Status:</b> <a style='color:red;'>Pending</a></p>";
  } else {
    echo "<p><b>Status:</b> <a style='color:lightgreen;'>Approved</a></p>";
  }

?>
  <p><b>Created on: </b><?php echo $fetch_comment['comment_timestamp']; ?></p>
  <div class="border_bottom"></div>

  <h4>Comment Content:</h4><br>
  <p><b>Title: </b><?php echo $fetch_comment['title']; ?></p><br>
  <img height="20" src="<?php echo $star; ?>"/><br><br>
  <p style="height:200px; overflow:auto;"><?php echo $fetch_comment['comment']; ?></p><br>
  <br>
  <a href="index.php?action=edit_comment&comment_id=<?php echo $fetch_comment['id']; ?>&status=Approved" style="text-decoration:none;color:white; background:lightgreen; padding:10px; margin-left:20px; margin-right:20px;">Approve</a><br>
  <br><form action="" method="post"><input style="cursor:pointer; border:none; color:white; background:red; padding:10px;" value="Remove Comment" name="remove" type="submit"></form>
  <br><br>

  <div class="border_bottom"></div>
  <br>

<div> <!---- /..container_brand ---->

<!----- Go back to all Comments section ------>
<a style="float:right; text-decoration:none; color:black; font-size:18px; margin-right:20px;" href="index.php?action=comments"><i class="fa fa-arrow-left"></i> Go back to all comments list</a>
