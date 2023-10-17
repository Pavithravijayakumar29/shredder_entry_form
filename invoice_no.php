<?php 

error_reporting(0);

ob_start();

session_start();

require_once("../model/config_pdo.php"); 

include_once("../include/common_function.php"); 


 $ipaddress = $_SESSION['sess_ipaddress'];

 $ses_site=$_SESSION['sess_site_id'];

 $ses_site_name=get_site_name($_SESSION['sess_site_id']);

 $site_name=$_GET[site_name];


$date=date("Y");

$st_date=substr($date,2);

$month=date("m");	   

$datee=$st_date.$month; 


$sql_qr=$db->prepare("select invoice_head from site_creation where id='$site_name'");
$sql_qr->execute();
$sql_qr_result = $sql_qr->fetchAll();
 $invoice_head=$sql_qr_result[0][invoice_head];


if(!isset($_GET['shredder_no']))

{

//$rs1=$db->prepare("select shredder_no from   shredder_entry_main where site_name='$site_name' and shredder_no LIKE'%$invoice_head%' order by id desc");

$rs1=$db->prepare("select shredder_no from   shredder_entry_main where site_name='$site_name' order by id desc limit 0,1");

//echo "select shredder_no from   shredder_entry_main where site_name='$site_name' order by entry_date desc limit 0,1";

$rs1->execute();
$rs2=$rs1->fetchAll();

	foreach($rs2 as $res1)

	{
		$shre_no = $res1['shredder_no'];

		$pur_array=explode('-',$shre_no);

	   	$year1=$pur_array[2];

        $year2=substr($year1, 0, 2);

	    $year='20'.$year2;

		$enquiry_no=$pur_array[3];

	}

	//echo "enquiry_no : ".$enquiry_no; 
		if($enquiry_no=='')
	{
			$enquiry_nos='SDR-'.$invoice_head."-".$datee.'-0001';
			//$enquiry_nos = 1;
	}
		elseif($year!=date("Y"))
	{
			$enquiry_nos='SDR-'.$invoice_head."-".$datee.'-0001';
			//$enquiry_nos= 2;
	}
	else

	{

		$enquiry_no+=1;

	 	$enquiry_nos='SDR-'.$invoice_head."-".$datee.'-'.str_pad($enquiry_no, 4, '0', STR_PAD_LEFT);
		//$enquiry_nos = 3 ;


	}

	

}


?>

<div class="col-sm-3">
<input type="hidden" readonly name="shredder_no" id="shredder_no" class="text_box" style="font-size:12px" value="<?php  echo $enquiry_nos;?>" /><strong> <span style="color:#FF0000;"><strong><?php  echo $enquiry_nos;?></strong></span>

</strong> </div>