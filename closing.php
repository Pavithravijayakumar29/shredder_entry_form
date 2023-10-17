<?php 
error_reporting(0);
ob_start();
session_start();
require("../model/config_pdo.php"); 

$sess_site_id=$_SESSION['sess_site_id'];
 $site_name_chck=$_GET['site_name'];
 $plant_name=$_GET['plant_name'];
 $entry_date=$_GET['entry_date'];
 $shredder_name =$_GET['shredder_name'];
//echo "select  MAX(CAST(close AS SIGNED INTEGER)) as  close from  shredder_entry_sub where site_name='$site_name_chck' and plant_name='$plant_name' and entry_date <='$entry_date' and  shredder_name = '$shredder_name'  order by id desc  limit 1";

$sql1=$db->prepare(("select close from  shredder_entry_sub where site_name='$site_name_chck' and plant_name='$plant_name' and entry_date <='$entry_date' and  shredder_name = '$shredder_name'  order by id desc  limit 1"));

$sql1->execute();
$sql=$sql1->fetchAll();
if($sql[0][close]==""||$sql[0][close]==null)
{
	$cls=0;
}
else {
	$cls=$sql[0][close];	# code...
}
echo trim($cls);
?>