<script>
  $(document).ready(function() {

    $('#example1').DataTable();
  });
</script>

<?php

error_reporting(0);
ob_start();
session_start();
include("../model/config_pdo.php");

$comp_name = $db->prepare("SELECT company_name,address,mobile_no,phone_no,email_id,website,gst_no from company_details where id='3'");
$comp_name->execute();
$comp = $comp_name->fetchAll();
$company_0 = $comp[0]['company_name'];
$company_1 = $comp[0]['address'];
$company_2 = $comp[0]['mobile_no'];
$company_3 = $comp[0]['phone_no'];
$company_4 = $comp[0]['email_id'];
$company_5 = $comp[0]['website'];
$company_6 = $comp[0]['gst_no'];

//$company=get_company_name();

$user_type_ids = $_SESSION['user_type_ids'];

$session_user_name = $_SESSION['sess_user_name'];

$session_password = $_SESSION['password'];

$user_types = $_SESSION['user_types'];

$sess_site_id = $_SESSION['sess_site_id'];
$from_date = $_POST['from_date'];

$to_date = $_POST['to_date'];

$site_name = $_POST['site_name'];
$plant_name = $_POST['plant_name'];


$current_date = date('Y-m-d');


function pdo_get_site_name($db, $site_id)
{
  $ehs_site_name = $db->prepare("select site_name from site_creation where id='$site_id'");
  $ehs_site_name->execute();
  $site_name_result = $ehs_site_name->fetchAll();
  $site_name = $site_name_result[0][site_name];
  return $site_name;
}

function pdo_get_plant_name($db, $plant_id)
{
  $get_plant_name = $db->prepare("select plant from plant_creation where id='$plant_id'");
  $get_plant_name->execute();
  $get_plant_name_result = $get_plant_name->fetchAll();
  $plant_name = $get_plant_name_result[0][plant];
  return $plant_name;
}

if ($from_date != "") {
  $from_date1 = "entry_date>='$from_date'";
} else {
  $from_date1 = "entry_date='$current_date'";
}

if ($to_date != "") {
  $to_date1 = "entry_date<='$to_date'";
} else {
  $to_date1 = "entry_date='$current_date'";
}

if ($site_name != "") {
  $site_name1 = "site_name IN ($site_name) ";
} else {
  $site_name1 = '';
}

if ($plant_name != "") {
  $plant_name1 = "plant_name IN ($plant_name)";
} else {
  $plant_name1 = '';
}

$all_value10 = $from_date1 . "/" . $to_date1 . "/" . $site_name1 . "/" . $plant_name1 . "/" . $type1;

$all_array10 = explode('/', $all_value10);

foreach ($all_array10 as $value10) {

  if ($value10 != '') {
    $get_query131 .= $value10 . " AND ";
  }
}
?>
<style>
  .tooltip8 {
    position: relative;
    display: inline-block;

  }

  .tooltip8 .tooltiptext8 {
    visibility: hidden;
    width: 400%;
    background-color: #F93;
    color: #000;
    text-align: left;
    border-radius: 6px;
    padding: 5px 10px;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
    top: -4px;
    left: 105%;

  }

  .tooltip8 .tooltiptext8 {
    position: absolute;
    background: #F93;
  }

  .tooltip8 .tooltiptext8:after,
  .tooltip8 .tooltiptext8:before {
    right: 100%;
    top: 50%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
  }

  .tooltip8:hover .tooltiptext8 {
    visibility: visible;
  }
</style>

<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td width="4%" colspan="5" align="right" valign="bottom">

      <img src="image/excel-icon.png" onclick="insurance_entry_excel_report('<?php echo $_POST['from_date']; ?>','<?php echo $_POST['to_date']; ?>','<?php echo $_POST['site_name']; ?>','<?php echo $_POST['plant_name']; ?>')" width="30" height="30" title="Click to export" />
      <a tabindex="7" href="javascript:print_function('shredder_entry_form/shredder_main_print.php?from_date=<?php echo $_POST['from_date']; ?>&to_date=<?php echo $_POST['to_date'] ?>&site_name=<?php echo $_POST['site_name']; ?>&plant_name=<?php echo $_POST['plant_name']; ?>');" style="float:center"><img align="right" src="image/report_print.png" width="35" height="35" border="0" title="PRINT" value="Print" /></a>

    </td>

  </tr>

</table>

&nbsp;&nbsp;
<div id="curd_message" align="center" style="font-weight:bold; padding:5px;"></div>
<table id="example1" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
    <tr>

      <th width="4%">#</th>

      <th width="8%">Date</th>

      <th width="14%">Shredder No</th>

      <th width="11%">Shredder Name</th>

      <th width="11%">Site Name </th>

      <th width="8%">Plant Name</th>

      <th width="9%" style="text-align:right">Total value&nbsp;</th>

      <th width="8%">Service Hours</th>

      <th width="5%">Service History</th>

      <th width="9%" align="left" style="text-align:left">Description</th>

      <th width="5%" style="text-align:center">User Name</th>

      <th width="5%" style="text-align:center">View</th>

      <th width="7%" style="text-align:center">Action</th>

    </tr>
  </thead>
  <tbody>
    <?php

    if ($sess_site_id == 'All') {
      $sql = $db->prepare("SELECT * FROM  shredder_entry_main where $get_query131 id!=''  order by entry_date asc");
      $sql->execute();
    } else {
      $sql = $db->prepare("SELECT * FROM  shredder_entry_main where $get_query131  id!='' and site_name in($sess_site_id)order by id DESC");
      $sql->execute();
    }
    $sql_row = $sql->fetchAll();
    foreach ($sql_row as $record) {
      $site_id = $record['site_name'];

      $plant_id = $record['plant_name'];

      $site_name = pdo_get_site_name($db, $site_id);

      $plant_name = pdo_get_plant_name($db, $plant_id);

      $shredder_no = $record['shredder_no'];

      $random_no = $record['random_no'];

      $date = $record['entry_date'];

      $random_sc = $record['random_sc'];

      $total_value = $record['total_value'];

      $entry_status = $record['entry_status'];

      $get_total_value = $db->prepare("select sum(total_value) as total from shredder_entry_sub where random_no='$random_no' and random_sc='$random_sc'");
      $get_total_value->execute();
      $get_total_value_result = $get_total_value->fetchAll();
      $total_value11 = $get_total_value_result[0][total];

      //TO FIND SHREDDER NAME
      $shredder_name_id = $record['shredder_name'];
      if ($shredder_name_id == 1) {
        $shredder_name = "Primary Shredder";
      } else {
        $shredder_name = "Secondary Shredder";
      }

      //TO FIND STAFF NAME
      $user_name = $record['user_name'];
      $pdo_staff = $db->prepare("select staff_name from  staff_creation where id=$user_name");
      $pdo_staff->execute();
      $get_staff = $pdo_staff->fetchAll();
      $staff_name = $get_staff[0][staff_name];


      //SERVICE KM CALCULATION - START

      //GET LAST CLOSE VALUE
      $get_last_close_value = $db->prepare("SELECT close as close,entry_date as entry_date from shredder_entry_sub where site_name='$site_id' and plant_name='$plant_id' and shredder_name='$shredder_name_id' and entry_date = '$date' order by id desc limit 0,1");

      $get_last_close_value->execute();
      $get_close = $get_last_close_value->fetchAll();
      foreach ($get_close as $result_close) {
        $last_close = $result_close['close'];
        $close_entry_date = $result_close['entry_date'];
      }

      //GET LAST READING VALUE
      $get_last_reading_value = $db->prepare(("SELECT reading as reading from shredder_entry_sub where site_name='$site_id' and plant_name='$plant_id' and shredder_name='$shredder_name_id' and entry_date <= '$close_entry_date' and  reading!='' order by id desc limit 0,1"));

      $get_last_reading_value->execute();
      $get_reading = $get_last_reading_value->fetchAll();
      if ($get_reading[0][reading] == "" || $get_reading[0][reading] == null) {
        $last_reading = 'null';
      } else {
        $last_reading = $get_reading[0][reading];
      }

      //GET MAX LIMIT OF SERVICE HOURS- START
      $get_cons_val = $db->prepare("SELECT max_limit as max_limit from constant_values where screen_name='shredder_entry_form' and particulars_name='service_km' ");

      $get_cons_val->execute();
      $fetch_data = $get_cons_val->fetchAll();
      foreach ($fetch_data as $fetch_const_val) {
        $max_limit = $fetch_const_val['max_limit'];
      }
      //GET MAX LIMIT OF SERVICE HOURS - END

      if ($last_reading != 'null') {
        
        $service_km_calc_val = $last_close - $last_reading;
        $service_km_calc = number_format($service_km_calc_val, 2);
        //$service_km_calc = $last_close." - ".$last_reading." = ".$service_km_calc_val;
      } else {
        $service_km_calc = "-";
      }

      if ($service_km_calc >= $max_limit) {
        //$get_service_hours = "<span style='color:#FF0000' >$service_km_calc</span>";
        $get_service_hours = "<span TITLE='Service Hours is Exceeded' style='color:#FF0000' >$service_km_calc</span>";
      } else {
        $get_service_hours = $service_km_calc;
      }
      //SERVICE KM CALCULATION - END


      //CHECK THIS ENTRY IS SERVICED OR NOT - START
      $get_entry_date1 = $record['entry_date'];
      $get_entry_date =  date("d-m-Y", strtotime($record['entry_date']));

      $get_service_status = $db->prepare("SELECT count(id) as id from shredder_entry_sub where site_name='$site_id' and plant_name='$plant_id' and shredder_name='$shredder_name_id' and entry_date = '$date' and service_status=1 ");

      $get_service_status->execute();
      $get_status = $get_service_status->fetchAll();
      foreach ($get_status as $result_status1) {
        $result_status = $result_status1['id'];
      }

      if ($result_status > 0) {

        $display_date = "<span TITLE='Shredder is Serviced for this Date' style='color:#0AB80D' >$get_entry_date</span>";
      } else {
        $display_date = $get_entry_date;
      }
      //CHECK THIS ENTRY IS SERVICED OR NOT - END
             
      //CHECK THE ENTRY IS LAST ENTRY OR NOT - START

      $check_sql = $db->prepare("SELECT * FROM shredder_entry_main WHERE site_name='$site_id' and plant_name='$plant_id' and shredder_name='$shredder_name_id' and entry_date > '$date' ");
      $check_sql->execute();
      $check_main_list_count = $check_sql->rowCount();

      //CHECK THE ENTRY IS LAST ENTRY OR NOT - END

    ?>
      <tr>

        <td><?php echo $i = $i + 1; ?>.</td>

        <td><?php echo $display_date; ?></td>

        <td>&nbsp;<?php echo $shredder_no; ?></td>

        <td><?php echo $shredder_name; ?></td>

        <td><?php echo $site_name; ?></td>

        <td><?php echo $plant_name; ?>&nbsp;</td>

        <!-- <td style="text-align:right"><?php echo number_format($total_value11, 4); ?>&nbsp;</td> -->

        <td><?php echo $total_value11; ?>&nbsp;</td>

        <td style="text-align:center"><?php echo $get_service_hours; ?></td>

        <td>
          <?php if ($last_reading != 'null') { ?>
            <a tabindex="7" href="javascript:shredder_indi_print('shredder_entry_form/shredder_service_history.php?site_id=<?php echo $site_id; ?>&plant_id=<?php echo $plant_id; ?>&shredder_id=<?php echo $shredder_name_id; ?>&entry_date=<?php echo $get_entry_date1; ?>');" style="float:center"><img align="center" src="image/eye.jpg" width="30" height="30" border="0" title="View Service History" value="Print" /></a>
          <?php } else { ?>

            <!-- <a class="disabled-link" href="javascript:shredder_indi_print('shredder_entry_form/shredder_service_history.php?site_id=<?php echo $site_id; ?>&plant_id=<?php echo $plant_id; ?>&shredder_id=<?php echo $shredder_name_id; ?>&entry_date=<?php echo $record['entry_date']; ?>');" style="float:center">
              <img align="center" src="image/eye.jpg" width="30" height="30" border="0" title="View Service History" value="Print" />
            </a> -->

          <?php } ?>
        </td>

        <td><?php echo ucfirst($record['description']); ?></td>

        <td><?php echo $staff_name; ?></td>

        <td width="5%" style="text-align:center"><a tabindex="7" href="javascript:shredder_indi_print('shredder_entry_form/shredder_entry_view.php?shredder_no=<?php echo $record['shredder_no']; ?>&main_id=<?php echo $record['id']; ?>&random_no=<?php echo $record['random_no']; ?>&random_sc=<?php echo $record['random_sc']; ?>');" style="float:center"><img align="center" src="image/view.png" width="30" height="30" border="0" title="PRINT" value="Print" /></a></td>

        <td align="center"><a href="shredder_entry_form/update.php?update_id=<?php echo $record['id']; ?>&shredder_no=<?php echo $record['shredder_no']; ?>&random_no=<?php echo $record['random_no']; ?>&random_sc=<?php echo $record['random_sc']; ?>&from_date=<?php echo $_REQUEST[from_date]; ?>&to_date=<?php echo $_REQUEST[to_date]; ?>&site_name=<?php echo $_REQUEST[site_name]; ?>&plant_name=<?php echo $_REQUEST[plant_name]; ?>" title="Update Shredder Entry" data-toggle="modal" data-target="#myModal" data-remote="false" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>


          <?php if ($entry_status == '1') { 
            if($check_main_list_count == 0){?>
            <a href="#" title="Delete  Details" class="btn btn-default" onClick="delete_shredder_entry_main('<?php echo $record['id']; ?>','<?php echo $record['shredder_no']; ?>','<?php echo $record['random_no']; ?>','<?php echo $record['random_sc']; ?>','<?php echo $_GET['from_date']; ?>','<?php echo $_GET['to_date']; ?>','<?php echo $_GET['site_name']; ?>','<?php echo $_GET['plant_name']; ?>');"><span class="glyphicon glyphicon-trash"></span></a>
          <?php } } ?>
        </td>

      </tr>

    <?php }
    $db = null;
    ?>
  </tbody>
</table>
</div>

<script>
  function insurance_entry_excel_report(from_date, to_date, site_name, plant_name) {
    window.location.href = "shredder_entry_form/export_excel.php?from_date=" + from_date + "&to_date=" + to_date + "&site_name=" + site_name + "&plant_name=" + plant_name;
  }

  function print_function(url) {
    onmouseover19 = window.open(url, 'onmouseover19', 'height=600,width=1200,scrollbars=yes,resizable=no,left=50,top=50,toolbar=no,location=no,directories=no,status=no,menubar=no');
  }
</script>

<style>
  .table2 {
    border: none !important;
  }

  .style10 {
    border-top: dotted 1px;
    border-top-color: #999;
  }

  .style100 {
    border-bottom: dotted 1px;
    border-bottom-color: #999;
  }

  .style1 {
    font-weight: bold;
    text-align: right;
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 12px;
  }

  .style2 {
    font-weight: normal;
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 12px;
  }

  .style3 {
    color: #F00;
  }

  .style4 {
    font-weight: normal;
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 10px;
  }

  .style5 {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-weight: bold;
    font-size: 14px;
  }

  .style6 {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-weight: bold;
    font-size: 16px;
  }

  .style7 {
    font-weight: bold;
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 12px;
    text-align: center;
  }

  .style23 {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 12px
  }

  .style9 {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-weight: bold;
    font-size: 18px;
  }

  .top {
    border-top: 1px solid #ccc;
  }

  .bottom {
    border-bottom: 1px solid #ccc;
  }

  .top1 {
    border-top: 2px solid #ddd;
  }

  .title {
    font-family: calibri;
    font-family: calibri;
    font-size: 24px;
    color: #333;
  }

  .address {
    font-family: calibri;
    font-family: calibri;
    font-size: 18px;
    color: #333;
  }

  .main {
    font-family: calibri;
    font-family: calibri;
    font-size: 16px;
    font-weight: 600;
    color: #333;
  }

  .main2 {
    font-family: calibri;
    font-family: calibri;
    font-size: 16px;
    color: #333;
    font-weight: 600;
  }

  .data {
    font-family: calibri;
    font-family: calibri;
    font-size: 16px;
    color: #111;
  }

  .ui-combobox {


    position: relative;
    display: inline-block;
  }

  .ui-comboboxs {
    position: relative;
    display: inline-block;
  }

  .ui-comboboxss {
    position: relative;
    display: inline-block;
  }

  .ui-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
    *height: 1.7em;
    *top: 0.1em;
  }

  .ui-combobox-toggles {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
    *height: 1.9em;
    *top: 0.1em;
  }

  .ui-combobox-toggless {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
    *height: 1.9em;
    *top: 0.1em;
  }

  .ui-combobox-input {
    margin: 0;
    padding: 0.3em;
    width: 150px;
    height: 35px;
    font-size: 16px;

  }

  .ui-combobox-input-type {
    margin: 0;
    padding: 0.3em;
    width: 150px;
    height: 30px;
    font-size: 16px;

  }

  .ui-combobox-input-types {
    margin: 0;
    padding: 0.3em;
    width: 150px;
    height: 30px;
    font-size: 16px;

  }
</style>
<style>
  #span1 {
    color: red;
  }

  .disabled-link {
    pointer-events: none;
    opacity: 0.5;
    /* Add any additional styling as needed */
  }
</style>