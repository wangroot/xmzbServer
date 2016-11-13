<?php

 header("content-type:text/html; charset=utf-8"); 

$userid=(int)$_POST['userid'];
$siteid=(int)$_POST['siteid'];
$clname=$_POST['clname'];
$clurl=$_POST['clurl'];

error_reporting(E_ALL ^ E_DEPRECATED);
 require("db/db_config.php");
 $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
 mysql_query("set names 'utf8'"); //数据库输出编码 应该与你的数据库编码保持一致.
 mysql_select_db($mysql_database); //打开数据库

$insql = "insert into collection(clName,clUrl,clsiteId,cluserId) values ('$clname','$clurl','$siteid','$userid')";
 
$inresult=mysql_query($insql);

if($inresult)
{
	echo "success";
}else
{
	echo "fail";
	
}

       


?>