<?php


 header("content-type:text/html; charset=utf-8"); 
 
 $wcateid=2;
 error_reporting(E_ALL ^ E_DEPRECATED);
                     require("db_config.php");
                     $conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //�������ݿ�
                     mysql_query("set names 'utf8'"); //���ݿ�������� Ӧ����������ݿ���뱣��һ��.
                     mysql_select_db($mysql_database); //�����ݿ�
					 
					 
					 
					 
					 
 //  ����site ��
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
				 



  $pagesize=5;
  $pages=0;
  $offset=(int)$_POST["offset"];
  $pagecount=(int)$_POST["pages"];
 
 $rs=mysql_query("select count(*) from site where swcId='{$wcateid}' ",$conn); //ȡ�ü�¼����$rs
    $myrow = mysql_fetch_array($rs);
    $numrows=$myrow[0];
	if($numrows%$pagesize==0)
	{ 
        $pages=(int)($numrows/$pagesize);}
    else{
		 $pages=(int)($numrows/$pagesize+1);
	}
 
 

$sitesql="select * from site where swcId='{$wcateid}' limit 0,$offset"; 
$siteresult = mysql_query($sitesql,$conn) or die(mysql_error()); //��ѯ
 
 $sites =array(); 
 
while($row = mysql_fetch_array($siteresult))
 {
	    
		if($row['swcId']==1)   //��վΪ����
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
   if($data->room_status==1)
   {
     $mysite=new site($row['sId'],$row['sName'],$row['sLogo'],$row['sSite'],$row['sSummary'],$row['sClickTimes'],$row['sTag'],$row['sStar'],$row['scId'],$row['swcId'],1);    
   }
    if($data->room_status==2)
   {
     $mysite=new site($row['sId'],$row['sName'],$row['sLogo'],$row['sSite'],$row['sSummary'],$row['sClickTimes'],$row['sTag'],$row['sStar'],$row['scId'],$row['swcId'],0);    
   }
    array_push($sites,$mysite);  
   
}	

if($row['swcId']==6)   //��վΪ��è
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
 
   
   if($status==2)
   {
     $mysite=new site($row['sId'],$row['sName'],$row['sLogo'],$row['sSite'],$row['sSummary'],$row['sClickTimes'],$row['sTag'],$row['sStar'],$row['scId'],$row['swcId'],1);    
   }
    if($status==3)
   {
     $mysite=new site($row['sId'],$row['sName'],$row['sLogo'],$row['sSite'],$row['sSummary'],$row['sClickTimes'],$row['sTag'],$row['sStar'],$row['scId'],$row['swcId'],0);    
   }
    array_push($sites,$mysite);  
	
   
}


if($row['swcId']==2)   //��վΪ��è
{
	
 
   
  
     $mysite=new site($row['sId'],$row['sName'],$row['sLogo'],$row['sSite'],$row['sSummary'],$row['sClickTimes'],$row['sTag'],$row['sStar'],$row['scId'],$row['swcId'],0);    
   
    array_push($sites,$mysite);  
	
   
}			
		
          
  }
   
  $sites_jstring = json_encode($sites,JSON_UNESCAPED_UNICODE); 

        echo $sites_jstring;   	

   

?>   