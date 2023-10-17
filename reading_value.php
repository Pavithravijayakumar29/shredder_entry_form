<?php




error_reporting(0);

ob_start();

session_start();

require("../model/config.inc.php"); 

require("../model/Database.class.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 
 
$sess_site_id=$_SESSION['sess_site_id'];

$site_name =$_GET['site_name'];
$plant_name =$_GET['plant_name'];
$shredder_name =$_GET['shredder_name'];
$entry_date =$_GET['entry_date'];



 $sql=mysql_fetch_array(mysql_query("SELECT reading as reading from  shredder_entry_sub where shredder_name='$shredder_name' and plant_name ='$plant_name' and site_name = '$site_name' and reading!='' and entry_date <= '$entry_date' order by id desc limit 0 ,1 "));

 if($sql[reading]==''){
    $reading = "null";
}else{
    $reading =$sql[reading];
} 
//
$sql_close=mysql_fetch_array(mysql_query("select close from  shredder_entry_sub where site_name='$site_name' and plant_name='$plant_name' and entry_date <='$entry_date' and  shredder_name = '$shredder_name'  order by id desc  limit 1"));

if($sql_close[close]=='' || $sql_close[close]=='null'){
   $close_val = "0";
}else{
   $close_val =$sql_close[close];
} 


//echo $sql[reading]."@@@@".$sql[serviced_by]."@@@@".$sql[spare_used]."@@@@".$sql[service_description];
echo $reading."@@@@"."$close_val";

?>