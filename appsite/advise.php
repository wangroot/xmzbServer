<?php

 header("content-type:text/html; charset=utf-8"); 

$content=$_POST['content'];
$email=$_POST['email'];


error_reporting(E_ALL ^ E_DEPRECATED);
 require("db/db_config.php");
 $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
 mysql_query("set names 'utf8'"); //数据库输出编码 应该与你的数据库编码保持一致.
 mysql_select_db($mysql_database); //打开数据库

$insql = "insert into advise(aContent,aEmail,aDate) values ('$content','$email',now())";
 
$inresult=mysql_query($insql);

if($inresult)
{
	echo "success";
}else
{
	echo "fail";
	
}

       


?>