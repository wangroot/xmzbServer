<?php

 header("content-type:text/html; charset=utf-8"); 
$userid=1;
 
//$cateid=(int)$_POST['cate'];

error_reporting(E_ALL ^ E_DEPRECATED);
 require("db/db_config.php");
 $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
 mysql_query("set names 'utf8'"); //数据库输出编码 应该与你的数据库编码保持一致.
 mysql_select_db($mysql_database); //打开数据库
 
 
 //  定义user 类
 /*
  class user {  
        public $uid;  
        public $uname;   
        public $uaccount;  
        public $upassword;
        public $uziploc;
		public $uanswer;
        public $uemail;
		public $ulogo;
		 
        function __construct($uid,$uname,$uaccount,$upassword,$uziploc,$uanswer,$uemail,$ulogo){  
            $this->uid=$uid; 
            $this->uname=$uname;
            $this->uaccount=$uaccount;
            $this->upassword=$upassword;
            $this->uziploc=$uziploc;	
            $this->uanswer=$uanswer;
            $this->uemail=$uemail;
            $this->ulogo=$ulogo;			
             
        }  
} 
 
 */
 
 
if( isset($_POST["userid"]))
{
	
 $userid=(int)$_POST["userid"];
 
$sql="select * from user where uId='{$userid}' ";



 
$result=mysql_query($sql);



 while($row = mysql_fetch_array($result))
 {
	 $arr = array(  
    'uid'=>$row['uId'],    
    'uname'=>$row['uName'],
	'uaccount'=>$row['uAccount'],
	'uemail' =>$row['uEmail'],
	'ulogo' =>$row['uLogo']
                 );  
				 
	$user_jstring = json_encode($arr,JSON_UNESCAPED_UNICODE);  
	
	//$f  = file_put_contents($file, $user_jstring,FILE_APPEND);
        echo $user_jstring;     
          
  }
    	


}
   
   
?>