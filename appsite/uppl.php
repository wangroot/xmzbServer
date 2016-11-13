<?php

 header("content-type:text/html; charset=utf-8"); 
 
$siteid=1;
 


error_reporting(E_ALL ^ E_DEPRECATED);
 require("db/db_config.php");
 $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
 mysql_query("set names 'utf8'"); //数据库输出编码 应该与你的数据库编码保持一致.
 mysql_select_db($mysql_database); //打开数据库
 
 //  定义site 类
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
 
  $pagesize=5;
  $pages=0;
  $offset=(int)$_POST["offset"];
  $pagecount=(int)$_POST["pages"];
 
  $rs=mysql_query("select count(*) from pl where plSiteId='{$siteid}' ",$conn); //取得记录总数$rs
    $myrow = mysql_fetch_array($rs);
    $numrows=$myrow[0];
	if($numrows%$pagesize==0)
	{ 
        $pages=(int)($numrows/$pagesize);}
    else{
		 $pages=(int)($numrows/$pagesize+1);
	}
 

/* 
 // 超出数据条数
if($pagecount>$pages)
{
	$pls =array(); 
	$mypl=new pl(0,"last","last","last","last","last",0);	       
    array_push($pls,$mypl);  
	 $pls_jstring = json_encode($pls,JSON_UNESCAPED_UNICODE);  
		//$f  = file_put_contents($file, $collects_jstring,FILE_APPEND);
        echo $pls_jstring;
   
	
}  // 没有超出数据条数
else{
 */
if(isset($_POST["siteid"]))
{
	
 $siteid=(int)$_POST['siteid'];
 
$sql="select * from pl where plSiteId='{$siteid}' limit 0,$offset"; 
$result = mysql_query($sql,$conn) or die(mysql_error()); //查询
 

$pls =array(); 
 
 while($row = mysql_fetch_array($result))
 {
	    $mypl=new pl($row['plId'],$row['plUser'],$row['plUserLogo'],$row['plContent'],$row['plDate'],$row['plEmail'],$row['plSiteId']);
		       
        array_push($pls,$mypl);  
          
  }
 

}

  // 输出数据
 //  print_r($arr);  
        $pls_jstring = json_encode($pls,JSON_UNESCAPED_UNICODE);  
		//$f  = file_put_contents($file, $collects_jstring,FILE_APPEND);
        echo $pls_jstring;   	
 	

//}
   
   
?>