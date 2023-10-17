

<?php 

error_reporting(0);

require("../model/config_pdo.php"); 



//include_once("../include/common_function.php"); 

$comp_name=$db->prepare("select company_name,address,mobile_no,phone_no,email_id,website,gst_no from company_details where id='3'");
	 $comp_name->execute();
     $comp = $comp_name->fetchAll();
	$company[0] = $comp[0]['company_name'];
	$company[1] = $comp[0]['address'];
	$company[2] = $comp[0]['mobile_no'];
	$company[3] = $comp[0]['phone_no'];
	$company[4] = $comp[0]['email_id'];
	$company[5] = $comp[0]['website'];
	$company[6] = $comp[0]['gst_no'];

 
function pdo_get_site_name($db,$site_id)
{
   $ehs_site_name=$db->prepare("select site_name from site_creation where id='$site_id'");
     $ehs_site_name->execute();
     $site_name_result = $ehs_site_name->fetchAll();
     $site_name=$site_name_result[0][site_name];  
  return $site_name;
}

function pdo_get_plant_name($db,$plant_id)
{
   $get_plant_name=$db->prepare("select plant from plant_creation where id='$plant_id'");
     $get_plant_name->execute();
     $get_plant_name_result = $get_plant_name->fetchAll();
     $plant_name=$get_plant_name_result[0][plant];  
  return $plant_name;
}
function pdo_get_assign_person($db,$staff_id)
{
   $staff_name1=$db->prepare("select staff_name from staff_creation where id='$staff_id'");
     $staff_name1->execute();
     $staff_name1_result = $staff_name1->fetchAll();
     $staff_name=$staff_name1_result[0][staff_name];
       return $staff_name;
  
  }

function pdo_get_shift_name($db,$shift_id)
{
   $shift_name1=$db->prepare("select shift_name from shift_creation where shift_id='$shift_id'");
     $shift_name1->execute();
     $shift_name1_result = $shift_name1->fetchAll();
     $site_name=$shift_name1_result[0][shift_name];  
  return $site_name;
}

?>

	

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

	<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>Untitled Document</title>

	<style type="text/css">

	.style10{ border-top: dotted 1px; border-top-color:#999;}

	.style1{font-weight:bold; text-align:right;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 12px;}

	.style2{font-weight:normal;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 12px;}

	.style3{color:#F00;}

	.style4{font-weight:normal;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;}

	.style5 {

	font-family: Verdana, Arial, Helvetica, sans-serif;

	font-weight: bold;

	font-size: 14px;

	}

	.top{ border-top: 1px dotted #999;}

	.bottom{ border-bottom: 1px dotted #999;}

	.title{font-family:calibri; font-family:calibri; font-size:28px; color:#333; }

	.address{font-family:calibri; font-family:calibri; font-size:20px; color:#333; }

	.main{font-family:calibri; font-family:calibri; font-size:15px; color:#666; }

	.data{font-family:calibri; font-family:calibri; font-size:15px; color:#333; }</style>

	</head>

	

	<body>

	<br />

	<table width="100%" border="0" cellpadding="0" cellspacing="0">

	

 

  <tr>

    <td colspan="3" align="center"></td>
    <tr> </tr>

  </tr> 


  <tr >
   <td rowspan="3" widht="144" align="center"><img src="../image/logo_print.png" height="80" width="80" style="margin-left: 280px;"/></td>
        <td colspan="2"  width="680" height="37" class="title" style=" font-weight:900; font-size:24px">&nbsp;<?php echo $company[0]; ?></td>

    </tr>

    <tr>

        <td colspan="2"   height="20"  class="address">&nbsp;<?php echo $company[1]; ?></td>

    </tr>

    <tr>

        <td colspan="2"  height="20"  class="address">&nbsp;<?php echo $company[2].", ".$company[3]; ?></td>

    </tr>

  <tr>

    <td colspan="3" align="center"></td>

  </tr>

  <tr><td colspan="3" align="center"></td></tr> </tr>
    <tr>
      <td colspan="3" align="center"></td>
    </tr>
    <tr>
      <td colspan="3" align="center"></td>
    </tr>
	</table>
<br>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">

	<tr>

	<th scope="col">&nbsp;</th>

	<th width="11%" align="left" scope="col">&nbsp;</th>

	<th  align="left"scope="col">&nbsp;</th>

	<th  align="center" scope="col" colspan="3" class="address ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Shredder Service History &nbsp;</strong></th>

	<th  align="left"scope="col">&nbsp;</th>

	</tr>

	<tr>

	<th scope="col">&nbsp;</th>

	<th width="11%" align="left" scope="col">&nbsp;</th>

	<th  align="left"scope="col">&nbsp;</th>

	<th  align="center"scope="col" colspan="3">&nbsp;</th>

	<th  align="left"scope="col">&nbsp;</th>

	

	</tr>


	<?php 

	$site_id= $_GET[site_id];

	$plant_id= $_GET[plant_id];

	$shredder_id= $_GET[shredder_id];

	$get_entry_date= $_GET[entry_date];

	$plant_name=pdo_get_plant_name($db,$plant_id);

	$site_name=pdo_get_site_name($db,$site_id);

	//TO FIND SHREDDER NAME
    if($shredder_id == 1)
	{
		$shredder_name = "Primary Shredder";
	}
      
    else{$shredder_name = "Secondary Shredder";}

	
	?>

	

<tr>

<th width="7%" height="32" scope="col">&nbsp;</th>

<td align="left" class="main" scope="col">Site Name</td>

<td width="4%" class="main"  align="center"scope="col">&nbsp;:</td>

<td width="41%" class="data"  align="left"scope="col"><strong><?php echo $site_name;?></strong></td>

</tr>

<tr>

<th width="7%" height="32" scope="col">&nbsp;</th>

<td align="left" class="main" scope="col">Plant Name</td>

<td width="4%" class="main"  align="center"scope="col">&nbsp;:</td>

<td width="41%" class="data"  align="left"scope="col"><strong><?php echo $plant_name;?></strong></td>

</tr>

<tr>

<td width="7%" height="30" class="style2"  align="center"scope="col">&nbsp;</td>

<td align="left" class="main" scope="col">Shredder Name</td>

<td width="4%" class="main"  align="center"scope="col">&nbsp;:</td>

<td width="41%" class="data"  align="left"scope="col"><strong><?php echo $shredder_name;?></strong></td>


</tr>

	<?php

	?>

	<tr>

	<th scope="col">&nbsp;</th>

	<th colspan="6" align="center" scope="col">&nbsp;</th>

	</tr>

	<tr>

	<th scope="col">&nbsp;</th>

	<td colspan="6" align="center" scope="col" class="style2"><strong></strong></td>

	</tr>

	</table>

	

	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">

	<tr>

	<th width="7%" height="34" class="" >&nbsp;</th>

	

	<th width="5%" height="34" class="style10 main " >S.No</th>

    <th width="11%" class="style10 main " align="center"  >&nbsp;Date</th> 

	<th width="16%" class="style10 main " align="center"  >&nbsp;Shift Name</th>  

	<th width="10%" class="style10 main " align="left"  >Status&nbsp; </th>
	
	<th width="10%" class="style10 main " align="left"  >Reading  &nbsp; </th>

	<th width="10%" class="style10 main " align="left"  >Service Hours &nbsp; </th>

	<th width="10%" class="style10 main " align="left"  >Serviced By   &nbsp; </th>

	<th width="10%" class="style10 main " align="left"  > Service Description  &nbsp; </th>

	<th width="10%" class="style10 main " align="left"  >Spare Used  &nbsp; </th>

	<th width="3%" height="34" class="" >&nbsp;</th>

	</tr>

	<tr>

	<td width="7%" height="" class=" " ></td>

	<td colspan="9" align="center" class="style10 style4"></td>

	<td width="3%" height="" class=" " ></td>

	

	</tr>

	

	<tr>

	<?php 

//GET LAST READING VALUE
$s_no=0;
//$get_last_reading_value =$db->prepare ("SELECT * FROM shredder_entry_sub WHERE site_name='$site_id' AND plant_name='$plant_id' AND shredder_name='$shredder_id' AND entry_date <= '$get_entry_date'  and reading!='' ORDER BY id DESC limit 0,3");


$get_last_reading_value =$db->prepare ("SELECT * FROM shredder_entry_sub WHERE site_name='$site_id' AND plant_name='$plant_id' AND shredder_name='$shredder_id'  and reading!='' ORDER BY id DESC");


$get_last_reading_value->execute();
$get_reading = $get_last_reading_value->fetchAll();
foreach($get_reading as $rsdata2)
{
	$s_no=$s_no+1;

	$last_reading = $rsdata2['reading'];

	$sub_id = $rsdata2['id'];

	$random_no=$rsdata2['random_no']; 

	$random_sc=$rsdata2['random_sc']; 

	$entry_date=$rsdata2['entry_date'] ;

	$type=$rsdata2['type'] ;

	$shredder_replace=$rsdata2['shredder_replace'] ;

	$service_status=$rsdata2['service_status'] ;
	     
	$reading=$rsdata2['reading'] ;

	$serviced_by=$rsdata2['serviced_by'] ;

	$service_description=$rsdata2['service_description'] ;

	$spare_used=$rsdata2['spare_used'] ;

	$close_entry_date = $rsdata2['entry_date'];

	$last_close = $rsdata2['close'];

	      //GET MAX LIMIT OF SERVICE HOURS- START
		  $get_cons_val = $db->prepare("SELECT max_limit as max_limit from constant_values where screen_name='shredder_entry_form' and particulars_name='service_km' ");

		  $get_cons_val->execute();
		  $fetch_data = $get_cons_val->fetchAll();
		  foreach ($fetch_data as $fetch_const_val) {
			$max_limit = $fetch_const_val['max_limit'];
		  }
		  //GET MAX LIMIT OF SERVICE HOURS - END


//SERVICE KM CALCULATION - START



//CALCULATION

if($last_reading!=''){
  $service_km_calc = $last_close - $last_reading;
  //$service_km_calc = $last_close." - ". $last_reading." = ".$service_km_calc_val;
}else{
  $service_km_calc="------";
}

if ($service_km_calc >= $max_limit) {
	//$get_service_hours = "<span style='color:#FF0000' >$service_km_calc</span>";
	$get_service_hours = "<span TITLE='Service Hours is Exceeded' style='color:#FF0000' >$service_km_calc</span>";
  } else {
	$get_service_hours = $service_km_calc;
  }

//SERVICE KM CALCULATION - END
	?>

	<th width="7%" height="34" class=" " ></th>

	

	<td align="center" height="32" class="data     "><?php echo $s_no;?></td>

	<td align="center" class="data  " >&nbsp;<?php echo date('d-m-Y',strtotime($entry_date));?>&nbsp;</td>

    <td align="center" class="data  " >&nbsp;<?php echo pdo_get_shift_name($db,$type);?>&nbsp;</td>

	<td align="left" class="data " ><?php if($shredder_replace=='1'){echo "Replaced";}elseif($service_status=='1'){echo "Serviced";}else{echo "-";}?>&nbsp;</td>

	<td align="left" class="data " ><?php if($reading!=''){echo $reading;}else{echo "-";}?>&nbsp;</td>

	<td align="left" class="data " ><?php echo  number_format($get_service_hours,2); ?>&nbsp;</td>

	<td align="left" class="data " ><?php if($serviced_by!=''){echo $serviced_by;}else{echo "-";} ?>&nbsp;</td>

	<td align="left" class="data " ><?php if($service_description!=''){echo $service_description;}else{echo "-";} ?>&nbsp;</td>

	<td align="left" class="data " ><?php if($spare_used!=''){echo $spare_used;}else{echo "-";} ?>&nbsp;</td>


	<!-- <td align="left" class="data " ><?php echo number_format($total_value,4);?>&nbsp;</td> -->
	</tr>
	<?php } ?>
	<td align="right" class=" " ></td>

	<td width="9%" align="right" class="">&nbsp;</td>

	
	

	<?php

	$tot_total_value+=$total_value;

	 ?>

	<!-- <tr>

	<td  width="7%" height="34" class="" ></td>


	<td align="right" colspan="8" width="7%" height="34" class="data top" >&nbsp;</td>

	<td align="left" class="data    top " >Total&nbsp;</td>

	<td align="left" class="data    top " ><?php echo number_format($tot_total_value,4);?>&nbsp;</td>

	<td width="3%"  height="" class=" " ></td>

	</tr> -->
<?php

//echo $close. " " . $reading;
// $km = $close - $read;
//echo "km".$km;
?>
	<tr>

	<th width="7%" height="34" class="" ></th>

	<td align="right" colspan="7" class="style10 main"></td>

	<td align="right" class="style10 style23">&nbsp;</td>

	

	<td align="right" class="style10 style23">&nbsp;</td>

	<td align="right" class=" ">&nbsp;</td>

	</tr>

	</table>

	</body>

	</html>

