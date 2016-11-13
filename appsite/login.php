
<?php

 header("content-type:text/html; charset=utf-8"); 

session_start(); 

//检测是否登录，若没登录则转向登录界面  
/*
if(isset($_SESSION['userid'])&&isset($_SESSION['username'])){  
      
     $arr = array(  
    'flag'=>'success',    
    'sessionid'=>$_SESSION['userid'],
	'sessionname'=>$_SESSION['username']
                 );  
				 
	$login_jstring = json_encode($arr,JSON_UNESCAPED_UNICODE);  
        echo $login_jstring;   			 

}

*/

if(isset($_POST["username"]) &&isset ($_POST["password"] ))
{
	
$username = htmlspecialchars($_POST['username']);  
$password = MD5($_POST['password']);  


  
error_reporting(E_ALL ^ E_DEPRECATED);
 require("db/db_config.php");
 $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
 mysql_query("set names 'utf8'"); //数据库输出编码 应该与你的数据库编码保持一致.
 mysql_select_db($mysql_database); //打开数据库
$check_query = mysql_query("select uId from user where uAccount='{$username}' and uPassword='{$password}' limit 1");  
if($result = mysql_fetch_array($check_query)){  
    //登录成功  
 
    $_SESSION['username'] = $username;  
    $_SESSION['userid'] = $result['uId'];  
	
	$arr = array(  
    'flag'=>'success',    
    'userid'=>$_SESSION['userid'],
	'username'=>$_SESSION['username']
                 );  
				 
	$login_jstring = json_encode($arr,JSON_UNESCAPED_UNICODE);  
        echo $login_jstring;  
	
     
} else {  
   
   $arr = array(  
    'flag'=>'fail',    
    'userid'=>0,
	'username'=>""
                 );  
				 
	$login_jstring = json_encode($arr,JSON_UNESCAPED_UNICODE);  
        echo $login_jstring;  
   
        }  
  
}  



  
//注销登录 
/* 
if($_GET['action'] == "logout"){  
    unset($_SESSION['userid']);  
    unset($_SESSION['username']);  
    echo '注销登录成功！点击此处 <a href="login.php">登录</a>';  
    exit;  
}  
 */ 
  
?>  