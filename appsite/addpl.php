<?php

 header("content-type:text/html; charset=utf-8"); 

 class pl{  
        public $plid;  
        public $pluser;  
        public $pluserlogo; 
        public $plcontent;  
        public $pldate;  
        public $plemail; 	
        public $plsiteid; 

		 
        function __construct($plid,$pluser,$pluserlogo,$plcontent,$pldate,$plemail,$plsiteid){  
            $this->plid=$plid; 
            $this->pluser=$pluser;
            $this->pluserlogo=$pluserlogo;
            $this->plcontent=$plcontent;
            $this->pldate=$pldate;
            $this->plemail=$plemail;
            $this->plsiteid=$plsiteid;
         			     
        }  
} 


$plcontent=$_POST['plcontent'];
$plsiteid=(int)$_POST['plsiteid'];
$userid=(int)$_POST['userid'];

$pluser="";
$pluserlogo="";
$plemail="";

error_reporting(E_ALL ^ E_DEPRECATED);
 require("db/db_config.php");
 $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
 mysql_query("set names 'utf8'"); //数据库输出编码 应该与你的数据库编码保持一致.
 mysql_select_db($mysql_database); //打开数据库

 $usersql="select * from user where uId='{$userid}' ";
 $result = mysql_query($usersql,$conn) or die(mysql_error());
 
  while($row = mysql_fetch_array($result))
 {
	 $pluser=$row['uName'];
	 $pluserlogo=$row['uLogo'];
	 $plemail=$row['uEmail'];
 }
 
$insql = "insert into pl(plUser,plUserLogo,plContent,plDate,plEmail,plSiteId) values ('$pluser','$pluserlogo','$plcontent',now(),'$plemail','$plsiteid')";
 
$inresult=mysql_query($insql);

if($inresult)
{
	echo "success";
}else
{
	echo "fail";
	
}

       


?>