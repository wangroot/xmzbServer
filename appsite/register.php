<?php

header("content-type:text/html; charset=utf-8"); 


error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ALL ^ E_DEPRECATED);
 require("db/db_config.php");
 $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
 mysql_query("set names 'utf8'"); //数据库输出编码 应该与你的数据库编码保持一致.
 mysql_select_db($mysql_database); //打开数据库
 

$uname=$_POST['uname'];
$uaccount=$_POST['uaccount'];
$upassword=md5($_POST['upassword']);
$uziploc=$_POST['uziploc'];
$uanswer=$_POST['uanswer'];
$uemail=$_POST['uemail'];

/*
$uname="xx";
$uaccount="xx";
$upassword="xx";
$uziploc="xx";
$uanswer="xx";
$uemail="xx";
*/

$ulogo="defuserlogo.png";

 function checkaccount($account,$conn)
{
    $checkAccount=mysql_query("select uAccount from user where uAccount ='{$account}' ",$conn);
	  $anum_rows = mysql_num_rows($checkAccount);
     if ($anum_rows==0){

       return FALSE;
      }
	  else{
		  
		  return TRUE;
	  }
   
}

  function checkname($name,$conn)
{
    $checkName=mysql_query("select uName from user where uName ='{$name}' ",$conn);
	  $nnum_rows = mysql_num_rows($checkName);
     if ($nnum_rows==0){

       return FALSE;
      }
	  else{
		  
		  return TRUE;
	  }
   
}

if($uname!=""&&$uaccount!=""&&$upassword!=""&&$uziploc!=""&&$uanswer!=""&&$uemail!="")
{


 

if(!checkname($uname,$conn)&&!checkaccount($uaccount,$conn))
{ 
$insql = "insert into user(uName,uAccount,uPassword,uZiploc,uAnswer,uEmail,uLogo) values ('$uname','$uaccount','$upassword','$uziploc','$uanswer','$uemail','$ulogo')";
 
$inresult=mysql_query($insql);

if($inresult)
{
	echo "success";
}else
{
	echo "fail";
	
}
}else{
	
	$ms="注册失败  ";

 if(checkname())
 {   $ms+="昵称已存在  ";  }
 if(checkaccount())
 { $ms+="用户名已存在  ";}

  echo $ms;
	
}




       }

?>