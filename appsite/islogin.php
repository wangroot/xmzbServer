<?php

header("content-type:text/html; charset=utf-8"); 

session_start(); 

//检测是否登录，若没登录则转向登录界面  
if(isset($_SESSION['userid'])&&isset($_SESSION['username'])){  
      
     $arr = array(  
    'flag'=>'yes',    
    'userid'=>$_SESSION['userid'],
	'username'=>$_SESSION['username']
                 );  
				 
	$login_jstring = json_encode($arr,JSON_UNESCAPED_UNICODE);  
        echo $login_jstring;   			 

}else
{
	
	$arr = array(  
    'flag'=>'no',    
    'userid'=>1,
	'username'=>""
                 );  
				 
	$login_jstring = json_encode($arr,JSON_UNESCAPED_UNICODE);  
        echo $login_jstring;
	
}


?>