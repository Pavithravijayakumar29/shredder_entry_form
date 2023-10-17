<?php 

error_reporting(0);

ob_start();

session_start();  

require("../model/config.inc.php"); 

require("../model/Database.class.php"); 

include_once("../include/common_function.php");

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 

$db->connect(); 

$company=get_company_name();

$user_type_ids=$_SESSION['user_type_ids'];

$session_user_name=$_SESSION['sess_user_name'];

$session_password=$_SESSION['password'];

$user_types=$_SESSION['user_types'];

$sess_site_id=$_SESSION['sess_site_id'];

$get_site_name = $_GET[site_name];

// $site_name_head=get_site_name($_GET[site_name]);

// $plant_name_head=get_plant_name($_GET[plant_name]);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Untitled Document</title>

<style type="text/css">

.top{ border-top: 1px solid #ccc;}

.bottom{ border-bottom: 1px solid #ccc;}

.top1{ border-top: 2px solid #ddd;}

.title{font-family:calibri; font-family:calibri; font-size:24px; color:#333; }

.address{font-family:calibri; font-family:calibri; font-size:18px; color:#333; }

.main{font-family:calibri; font-family:calibri; font-size:16px; font-weight:600; color:#333; }

.main2{font-family:calibri; font-family:calibri; font-size:16px; color:#333; font-weight:600;}

.data{font-family:calibri; font-family:calibri; font-size:16px; color:#111; }

</style>

</head>

<body>

<br />

<table width="850px" border="0" cellpadding="0" cellspacing="0" align="center">

<tr>

<td width="114" rowspan="3"><img src="../image/logo_print.png" height="80" width="80" /></td>

<td width="580" height="30" class="title" style=" font-weight:900; font-size:24px">&nbsp;<?php echo $company[0]; ?></td>

<td width="156" align="right"></td>

</tr>

<tr>

<td height="20" class="address">&nbsp;<?php echo $company[1]; ?></td>

<td align="right" class="main"></td>

</tr>

<tr>

<td height="20" class="address">&nbsp;<?php echo $company[3]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php echo $company[4]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $company[5]; ?></td>

<td align="right" class="main"></td>

</tr>

<tr>

<td height="5" colspan="3" align="center" class="main"></td>

</tr>

<tr>

<td height="25" colspan="3" align="center" class="main top1" valign="bottom"><strong>Shredder Entry</strong></td>

</tr>

</table>

<table width="850px" border="0" cellpadding="0" cellspacing="0" align="center">

<tr><td colspan="7" height="10"></td></tr>

<tr>

<td width="43" height="25" scope="col">&nbsp;</td>

<td width="129" align="left" class="main"><strong>&nbsp;From Month&nbsp;</strong></td>

<td width="23" align="center" class="main">&nbsp;:</td>

<td width="308" align="left" class="data"><?php if($_GET[from_date]!=''){ echo date('d-m-Y',strtotime($_GET[from_date]));}else{ echo date('d-m-Y');} ?></td>

<td width="118" align="left" class="main"><strong>To Month&nbsp;</strong></td>

<td width="21" align="center" class="main">&nbsp;:</td>

<td width="208" align="left" class="data"><?php if($_GET[to_date]!='') {echo date('d-m-Y',strtotime($_GET[to_date]));} else{ echo date('d-m-Y');}  ?></td>

</tr>

<tr>

<td width="43" height="25" scope="col">&nbsp;</td>

<td width="129" align="left" class="main"><strong>&nbsp;Site Name</strong></td>

<td width="23" align="center" class="main">&nbsp;:</td>

<td width="308" align="left" class="data"> 
<?php 
if($get_site_name!=''){

 $value=explode(',',$get_site_name);

 for($i=0;$i<count($value);$i++){
    echo get_site_name($value[$i]);
    if($i<(count($value)-1)) {
        echo ",";
    }

  }
}
else{echo "All";}?></td>

<td width="118" align="left" class="main"><strong>Plant Name</strong></td>

<td width="21" align="center" class="main">&nbsp;:</td>

<td width="208" align="left" class="data">
<?php 
if($_GET[plant_name]!=''){
    
 $list_name=explode(',',$_GET[plant_name]);
 
 for($j=0;$j<count($list_name);$j++){
     $party_names=mysql_fetch_array(mysql_query("SELECT plant FROM  plant_creation WHERE id='$list_name[$j]'"));
     echo  $party_names['plant'];
         if($j<(count($list_name)-1)) {
         echo ",";}
 }
}
else{echo "All";}
?></td>

</tr>

<tr>

<th>&nbsp;</th>

<th colspan="6" align="center">&nbsp;</th>

</tr>

</table>



<table width="950px" border="0" cellpadding="0" cellspacing="0" align="center">

<tr>

<th width="4%" height="35" class="top main bottom">S.No</th>

<th width="10%" class="top main bottom" align="center">&nbsp;Date</th>

<th width="17%" class="top main bottom" align="left">&nbsp;Shredder No </th>

<th width="15%" class="top main bottom" align="left">&nbsp;Shredder Name </th>

<th width="16%" class="top main bottom" align="left">&nbsp;Site Name </th>

<th width="16%" class="top main bottom" align="left">&nbsp;Plant Name</th>
<th width="12%" class="top main bottom" align="left">&nbsp;Service Hours</th>
<th width="3%" class="top main bottom" align="left">Total</th>

<th width="1%" class="top main bottom" align="left">&nbsp;Description</th>


<!--<th width="17%" class="top main bottom" align="left">&nbsp;User Name </th>-->

</tr>

<?php 

$from_date=$_GET['from_date'];

$to_date=$_GET['to_date'];

$site_name=$_GET['site_name'];

$plant_name=$_GET['plant_name'];

$current_date=date('Y-m-d');

if($from_date!=""){ $from_date1 = "entry_date>='$from_date'";}else{$from_date1="entry_date='$current_date'";}

if($to_date!=""){ $to_date1 = "entry_date<='$to_date'";}else{$to_date1="entry_date='$current_date'";}

if($sess_site_id =='All'){
    if($site_name!=""){ $site_name1 = "site_name IN ($site_name) ";}else{$site_name1='';}
}
else{
    if($site_name!=""){ $site_name1 = "site_name IN ($site_name) ";}else{$site_name1="site_name IN ($sess_site_id)";}
}

if($plant_name!=""){ $plant_name1 = "plant_name IN ($plant_name)";}else{$plant_name1='';}

$all_value10 = $from_date1."@".$to_date1."@".$site_name1."@".$plant_name1;

$all_array10 = explode('@',$all_value10);

foreach($all_array10 as $value10)

{ 
    if($value10!='')
    
    {
    
    $get_query131 .= $value10." AND ";
    
    }
} 

$sql1 = ("SELECT * FROM  shredder_entry_main where $get_query131 id!=''  order by entry_date asc");

$rows1 = $db->fetch_all_array($sql1);

foreach($rows1 as $record)

{
    $s_no=$s_no+1;
    $site_id=$record['site_name']; 
    $entry_date = $record['entry_date'];
    
    $plant_id=$record['plant_name']; 
    
    $site_name=get_site_name($site_id);
    
    $plant_name=get_plant_name($plant_id);
    
    $shredder_no=$record['shredder_no'];
    
    $random_no=$record['random_no']; 
    
    $random_sc=$record['random_sc']; 
    $type=$record['type'];
    $description=$record['description'];
    $reading =$record['reading'];
    //echo $reading;
    $sql5=mysql_fetch_array(mysql_query("select sum(total_value) as total from shredder_entry_sub where random_no='$random_no' and random_sc='$random_sc'")); 
    
    $tot_reading=$sql5['total'];
    
    //TO FIND SHREDDER NAME
    $shredder_name_id=$record['shredder_name']; 
    if($shredder_name_id == 1){$shredder_name = "Primary Shredder";}
    else{$shredder_name = "Secondary Shredder";}
  
    //TO FIND STAFF NAME
    $user_name=$record['user_name'];
    $pdo_staff=mysql_fetch_array(mysql_query("select staff_name from  staff_creation where id=$user_name"));
    $staff_name=$pdo_staff['staff_name'];

//SERVICE KM CALCULATION - START

//GET PREVIOUS READING VALUE
$sql_close =  "SELECT close as close , entry_date as entry_date from shredder_entry_sub where random_no='$random_no' and random_sc='$random_sc' order by id desc limit 0,1";
$get_close = $db->fetch_all_array($sql_close);

    foreach($get_close as $record1)
    {
        $close = $record1['close'];
        $close_entry_date = $record1['entry_date'];
    }

$get_value =  "SELECT max_limit as max_limit from constant_values where screen_name='shredder_entry_form' and particulars_name='service_km' ";
$get_data = $db->fetch_all_array($get_value);

foreach($get_data as $get_datas)
{
    $max_limit = $get_datas['max_limit'];
}

//CHECK THE SERVICE HOURS - END

//GET PREVIOUS READING VALUE
// $sql_status =  "SELECT reading as reading from shredder_entry_sub where site_name='$site_id' and plant_name='$plant_id' and shredder_name='$shredder_name_id' and entry_date <= '$close_entry_date' and  reading!='' order by id desc limit 0,1";
// $row_km = $db->fetch_all_array($sql_status);

// foreach($row_km as $record2)
// {
//     $read = $record2['reading'];
// }
$get_read=mysql_fetch_array(mysql_query("SELECT reading as reading from shredder_entry_sub where site_name='$site_id' and plant_name='$plant_id' and shredder_name='$shredder_name_id' and entry_date <= '$close_entry_date' and  reading!='' order by id desc limit 0,1"));
$read=$get_read['reading'];

//CALCULATION
if($read!=''){
    $km_val =  $close - $read;
    $km =  number_format($km_val,2);
}else{
    $km = "-";
}

if($km >= $max_limit)
{
  $km = "<span  TITLE='Service Hours is Exceeded' style='color:#FF0000' >$km</span>";
}else{
  $km = $km;
}

//SERVICE KM CALCULATION - END

//CHECK THIS ENTRY IS SERVICED OR NOT - START

$get_entry_date =  date("d-m-Y",strtotime($record['entry_date']));

$get_service_status="SELECT count(id) as id from shredder_entry_sub where site_name='$site_id' and plant_name='$plant_id' and shredder_name='$shredder_name_id' and entry_date = '$entry_date' and service_status=1";

$get_status = $db->fetch_all_array($get_service_status);

foreach($get_status as $result_status1)
{
    $result_status = $result_status1['id'];
    $service_status = $result_status1['service_status'];
}

if($result_status > 0){
    $display_date = "<span TITLE='Shredder is Serviced for this Date' style='color:#0AB80D' >$get_entry_date</span>";
  }else{
    $display_date = $get_entry_date;
  }
        


//CHECK THIS ENTRY IS SERVICED OR NOT - END

?>

<tr>

<td align="left" height="27" class="data"><?php echo $s_no; ?></td>

<td align="left" class="data">&nbsp;<?php echo $display_date; ?></td>

<td align="left" class="data">&nbsp;<?php echo $shredder_no?></td>

<td align="left" height="27" class="data"><?php echo $shredder_name; ?></td>

<td align="left" class="data">&nbsp;<?php echo $site_name?></td>

<td align="left" class="data">&nbsp;<?php echo $plant_name;?></td>
<td align="center" height="27" class="data"><?php echo $km; ?></td>
<!-- <td align="left" class="data"><?php echo number_format($tot_reading,0);?>&nbsp;</td> -->
<td align="left" class="data"><?php echo ($tot_reading);?>&nbsp;</td>

<td align="center" class="data"><?php if (!empty($description)) {
echo ucfirst($description);
} else {
echo "------";
} ?></td>



</tr>

<?php

 $tot_total_reading+=$tot_reading;

}?>


<tr>

<td height="30" colspan="6" class="top">&nbsp;</td>

<td width="2%" align="right" class=" top main">Total Reading&nbsp;</td>

<!-- <td width="6%" align="right" class=" top data"><?php echo number_format($tot_total_reading,0);?>&nbsp;</td> -->
<td width="6%" align="right" class=" top data"><?php echo number_format($tot_total_reading,2);?>&nbsp;</td>

<td class="top">&nbsp;</td>

</tr>

<tr>

<td height="25" colspan="9" align="right" class=" style10 style4 top data "> Printed Date&nbsp;:&nbsp;<?php echo date('d-m-Y'); ?></td>

</tr>

</table>

</body>

</html>

