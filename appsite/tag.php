<?php

 header("content-type:text/html; charset=utf-8"); 
 
error_reporting(E_ALL ^ E_DEPRECATED);
 require("db/db_config.php");
 $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
 mysql_query("set names 'utf8'"); //数据库输出编码 应该与你的数据库编码保持一致.
 mysql_select_db($mysql_database); //打开数据库
 
 
//  定义tag 类
  class tag {  
        public $tid;  
        public $tname;  
        public $tlogo; 
      
		 
        function __construct($tid,$tname,$tlogo){  
            $this->tid=$tid; 
            $this->tname=$tname;
            $this->tlogo=$tlogo;
		
             
        }  
} 
 
$sql="select * from tag";
 
$result=mysql_query($sql);

$tags =array(); 

 while($row = mysql_fetch_array($result))
 {
	    $mytag=new tag($row['tId'],$row['tName'],$row['tLogo']);
		       
        array_push($tags,$mytag);  
          
  }
   

 //  print_r($arr);  
        $tags_jstring = json_encode($tags,JSON_UNESCAPED_UNICODE);  
        echo $tags_jstring;   	



?>