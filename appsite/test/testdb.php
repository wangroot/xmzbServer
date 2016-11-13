<?php

 require("db/db_config.php");
 
echo $mysql_server_name; 
echo $mysql_username;
echo $mysql_password; 

$link = mysql_connect($mysql_server_name,$mysql_username,$mysql_password); 
if (!$link) { 
	die('Could not connect to MySQL: ' . mysql_error()); 
} 
echo 'Connection OK'; 
mysql_close($link); 
?>