<?php
 
 header("content-type:text/html; charset=utf-8"); 

 error_reporting(E_ALL ^ E_DEPRECATED);
 require("db/db_config.php");
 $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
 mysql_query("set names 'utf8'"); //数据库输出编码 应该与你的数据库编码保持一致.
 mysql_select_db($mysql_database); //打开数据库
 
 
 //  定义site 类
 class site {  
        public $sid;  
        public $sname;  
        public $slogo; 
        public $ssite;  
        public $ssummary;  
        public $sclicktimes; 	
        public $stag; 
        public $sstar;
        public $scid;
		 
        function __construct($sid,$sname,$slogo,$ssite,$ssummary,$sclicktimes,$stag,$sstar,$scid){  
            $this->sid=$sid; 
            $this->sname=$sname;
            $this->slogo=$slogo;
            $this->ssite=$ssite;
            $this->ssummary=$ssummary;
            $this->sclicktimes=$sclicktimes;
            $this->stag=$stag;
            $this->sstar=$sstar;
            $this->scid=$scid; 			
             
        }  
} 				
 
 
 
$keyword=$_POST['keyword'];
$cate=$_POST['cate'];

$sites =array(); 

//按名字搜索
if($cate=="name")
{
	
  $sitesql="select * from site where sName LIKE '%{$keyword}%' "; 
  $siteresult = mysql_query($sitesql,$conn) or die(mysql_error()); //查询
  while($row = mysql_fetch_array($siteresult))
 {
	    $mysite=new site($row['sId'],$row['sName'],$row['sLogo'],$row['sSite'],$row['sSummary'],$row['sClickTimes'],$row['sTag'],$row['sStar'],$row['scId']);
		     
        array_push($sites,$mysite);  
          
  }
	
}

// 按标签搜索
if($cate=="tag")
{
	$sitesql="select * from site where sTag LIKE '%{$keyword}%' "; 
    $siteresult = mysql_query($sitesql,$conn) or die(mysql_error()); //查询
  while($row = mysql_fetch_array($siteresult))
 {
	    $mysite=new site($row['sId'],$row['sName'],$row['sLogo'],$row['sSite'],$row['sSummary'],$row['sClickTimes'],$row['sTag'],$row['sStar'],$row['scId']);
		     
        array_push($sites,$mysite);  
          
  }	
	
}


// 输出
 $sites_jstring = json_encode($sites,JSON_UNESCAPED_UNICODE); 
//$f  = file_put_contents($file, $sites_jstring,FILE_APPEND);  
        echo $sites_jstring;   



}


 

