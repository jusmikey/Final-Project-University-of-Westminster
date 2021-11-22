<?php 
  session_start();
  $_SESSION['checked_on_page_reload'] = $_POST['get_radio_name'];

  echo $_SESSION['checked_on_page_reload'];
?>