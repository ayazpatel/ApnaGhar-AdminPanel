<?php
$server = "localhost";
$username = "ayaz";
$password = "ayaz29292";
$database = "test_ayafitech_com";
$connection = mysqli_connect("$server","$username","$password");
$select_db = mysqli_select_db($connection, $database);
if(!$select_db)
{
	echo("connection terminated");
}
?>