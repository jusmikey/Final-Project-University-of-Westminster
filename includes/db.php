<?php

$dbhost = 'phpmyadmin.ecs.westminster.ac.uk';
$dbuser = 'w1712116';
$dbpass = 'wxtRH7T3Hq8a';
$dbname = 'w1712116_0';

$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if(mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_query($con, "SET NAMES 'utf-8'");

?>