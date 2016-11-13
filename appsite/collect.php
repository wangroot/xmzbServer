<?php

 header("content-type:text/html; charset=utf-8"); 
$userid=1;
 
//$cateid=(int)$_POST['cate'];

error_reporting(E_ALL ^ E_DEPRECATED);
 require("db/db_config.php");
 $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
 mysql_query("set names 'utf8'"); //数据库输出编码 应该与你的数据库编码保持一致.
 mysql_select_db($mysql_database); //打开数据库
 
 //  定义site 类
  class collect {  
        public $clid;  
        public $clname;   
        public $clurl;  
        public $clsiteid;
        public $cluserid;
		 
        function __construct($clid,$clname,$clurl,$clsiteid,$cluserid){  
            $this->clid=$clid; 
            $this->clname=$clname;
            $this->clurl=$clurl;
            $this->clsiteid=$clsiteid;
            $this->cluserid=$cluserid;		
             
        }  
} 
 
 
  $pagesize=5;
  $pages=0;
  $offset=(int)$_POST["offset"];
  $pagecount=(int)$_POST["pages"];
  
 
 $rs=mysql_query("select count(*) from collection where cluserId='{$userid}' ",$conn); //取得记录总数$rs
    $myrow = mysql_fetch_array($rs);
    $numrows=$myrow[0];
	if($numrows%$pagesize==0)
	{ 
        $pages=(int)($numrows/$pagesize);}
    else{
		 $pages=(int)($numrows/$pagesize+1);
	}

	
	
// 超出数据条数
if($pagecount+1>$pages)
{
	$collects =array(); 
	$mycollect=new collect(0,"last","last",0,0);	       
    array_push($collects,$mycollect);  
	 $collects_jstring = json_encode($collects,JSON_UNESCAPED_UNICODE);  
		//$f  = file_put_contents($file, $collects_jstring,FILE_APPEND);
        echo $collects_jstring;
   
	
}  // 没有超出数据条数
else{
if(isset($_POST["userid"]))
{
	
 $userid=(int)$_POST["userid"];
 
$sql="select * from collection  where cluserId='{$userid}' limit $offset,$pagesize"; 
$result = mysql_query($sql,$conn) or die(mysql_error()); //查询
 

$collects =array(); 
 
 while($row = mysql_fetch_array($result))
 {
	    $mycollect=new collect($row['clId'],$row['clName'],$row['clUrl'],$row['clsiteId'],$row['cluserId']);
		       
        array_push($collects,$mycollect);  
          
  }
 

}

  // 输出数据
 //  print_r($arr);  
        $collects_jstring = json_encode($collects,JSON_UNESCAPED_UNICODE);  
		//$f  = file_put_contents($file, $collects_jstring,FILE_APPEND);
        echo $collects_jstring;   	



  } 
   