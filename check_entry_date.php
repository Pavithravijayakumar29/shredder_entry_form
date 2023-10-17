<?php 
//echo "success";
error_reporting(0);
ob_start();
session_start();
require("../model/config_pdo.php"); 

$site_name = $_POST['site_name'];
$plant_name =  $_POST['plant_name'];
$entry_date =  $_POST['entry_date'];
$shredder_name =  $_POST['shredder_name'];
$random_no = $_POST['random_no'];
//echo "SELECT * FROM  shredder_entry_main WHERE site_name='$_POST[site_name]' and plant_name='$_POST[plant_name]' and entry_date='$_POST[entry_date]' and shredder_name='$_POST[shredder_name]' ";

$sql2 = $db->prepare("SELECT * FROM  shredder_entry_main WHERE site_name='$_POST[site_name]' and plant_name='$_POST[plant_name]' and entry_date >= '$_POST[entry_date]' and shredder_name='$_POST[shredder_name]' ");

 //echo "SELECT * FROM  shredder_entry_main WHERE site_name='$_POST[site_name]' and plant_name='$_POST[plant_name]' and entry_date<'$_POST[entry_date]' and shredder_name='$_POST[shredder_name]' ";
$sql2->execute();
$count_sub = $sql2->rowCount();
if($count_sub==0){
    $count='0';
}
else{
    $count= '1';
}
echo $count;

?>