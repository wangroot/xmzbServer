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
		public $swcid;
		public $islive;	
		 
        function __construct($sid,$sname,$slogo,$ssite,$ssummary,$sclicktimes,$stag,$sstar,$scid,$swcid,$islive){  
            $this->sid=$sid; 
            $this->sname=$sname;
            $this->slogo=$slogo;
            $this->ssite=$ssite;
            $this->ssummary=$ssummary;
            $this->sclicktimes=$sclicktimes;
            $this->stag=$stag;
            $this->sstar=$sstar;
            $this->scid=$scid;
			$this->swcid=$swcid;
			$this->islive=$islive;
              			
             
        }  
} 
				 

$tagname="";

if(isset($_POST['keyword']))
{ 
$tagname=$_POST['keyword'];
}else{
	$tagname="";
}

//$file  = 'logk.txt';  //要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个



$offset=0;
$pagesize=20;

$sitesql="select * from site where sTag LIKE '%{$tagname}%' limit $offset,$pagesize"; 
//$f  = file_put_contents($file, $sitesql,FILE_APPEND);

$siteresult = mysql_query($sitesql,$conn) or die(mysql_error()); //查询
 
 $sites =array(); 
 
   while($row = mysql_fetch_array($siteresult))
{
 
if($row['swcId']==1)   //网站为斗鱼
{
	$url="";
	$str=$row['sSite'];
    if(preg_match('/\d+/',$str,$arr)){
		
      $url="http://open.douyucdn.cn/api/RoomApi/room/".$arr[0];
    }
//	echo $url;
	
	$handle = fopen($url,"rb");
      $content = "";
    while (!feof($handle)) {
       $content .= fread($handle, 10000);
       }
   fclose($handle); 

   $obj = json_decode($content); 
   $data=$obj->data;
   if($data->room_status==1);
   {
     $mysite=new site($row['sId'],$row['sName'],$row['sLogo'],$row['sSite'],$row['sSummary'],$row['sClickTimes'],$row['sTag'],$row['sStar'],$row['scId'],$row['swcId'],1);    
   }
    if($data->room_status==2);
   {
     $mysite=new site($row['sId'],$row['sName'],$row['sLogo'],$row['sSite'],$row['sSummary'],$row['sClickTimes'],$row['sTag'],$row['sStar'],$row['scId'],$row['swcId'],0);    
   }
    array_push($sites,$mysite);  
   
}	

if($row['swcId']==6)   //网站为熊猫
{
	$url="";
	$str=$row['sSite'];
    if(preg_match('/\d+/',$str,$arr)){
      $url="http://api.m.panda.tv/ajax_get_liveroom_baseinfo?roomid=".$arr[0]."&slaveflag=1&type=json&__version=1.2.0.1441&__plat=android";
    }
	
   $handle = fopen($url,"rb");
      $content = "";
    while (!feof($handle)) {
       $content .= fread($handle, 10000);
       }
   fclose($handle); 
    // echo $content;
   $obj = json_decode($content);
   $data=$obj->data;
   $info=$data->info;
   $videoinfo=$info->videoinfo;
   $status=$videoinfo->status;
 
   
   if($status==2);
   {
     $mysite=new site($row['sId'],$row['sName'],$row['sLogo'],$row['sSite'],$row['sSummary'],$row['sClickTimes'],$row['sTag'],$row['sStar'],$row['scId'],$row['swcId'],1);    
   }
    if($status==3);
   {
     $mysite=new site($row['sId'],$row['sName'],$row['sLogo'],$row['sSite'],$row['sSummary'],$row['sClickTimes'],$row['sTag'],$row['sStar'],$row['scId'],$row['swcId'],0);    
   }
    array_push($sites,$mysite);  
	
   
}

if($row['swcId']==2||$row['swcId']==3||$row['swcId']==4||$row['swcId']==5)   //网站为熊猫
{
     $mysite=new site($row['sId'],$row['sName'],$row['sLogo'],$row['sSite'],$row['sSummary'],$row['sClickTimes'],$row['sTag'],$row['sStar'],$row['scId'],$row['swcId'],0);    
   
    array_push($sites,$mysite);    
}


}
   
  $sites_jstring = json_encode($sites,JSON_UNESCAPED_UNICODE); 
//$f  = file_put_contents($file, $sites_jstring,FILE_APPEND);  
        echo $sites_jstring;   	

   

?>   