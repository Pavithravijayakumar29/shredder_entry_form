<?php
error_reporting(0);
ob_start();
session_start();
require("../model/config_pdo.php");




$sess_user_id = $_SESSION['sess_user_id'];

$session_user_name = $_SESSION['sess_user_name'];

$user_type_ids = $_SESSION['user_type_ids'];

$user_types = $_SESSION['user_types'];

$sess_site_id = $_SESSION['sess_site_id'];

$ipaddress = $_SESSION['sess_ipaddress'];
$pdo_user1 = $db->prepare("select staff_name from  user_creation where user_id='$sess_user_id'");
$pdo_user1->execute();
$get_user1 = $pdo_user1->fetchAll();
$user_staff_name_date = $get_user1[0]['staff_name'];


$date = date("Y");

$st_date = substr($date, 2);

$month = date("m");

$datee = $st_date . $month;



if (!isset($_GET['shredder_no'])) {

  $rs1 = $db->prepare("select shredder_no from   shredder_entry_main order by id desc");
  $rs1->execute();
  $rows = $rs1->fetchAll();
  foreach ($rows as $res1) {

    $pur_array = explode('-', $res1['shredder_no']);



    $year1 = $pur_array[1];

    $year2 = substr($year1, 0, 2);

    $year = '20' . $year2;

    $enquiry_no = $pur_array[2];
  }

  if ($enquiry_no == '')

    $enquiry_nos = 'SDR-' . $datee . '-0001';

  elseif ($year != date("Y"))

    $enquiry_nos = 'SDR-' . $datee . '-0001';

  else {

    $enquiry_no += 1;

    $enquiry_nos = 'SDR-' . $datee . '-' . str_pad($enquiry_no, 4, '0', STR_PAD_LEFT);
  }
}

if ($edit_id1 != '') {

  $enquiry_num = $enquiry_nosss;
}

$date = date("Y");

$month = date("m");

$year = date("d");

$hour = date("h");

$minute = date("i");

$second = date("s");

$random_sc = date('dmyhis');

$random_no = rand(00000, 99999);



$mode_type = 'panel_reading_entry';

//


?>

<input type="hidden" name="random_no" id="random_no" value="<?php echo $random_no; ?>" />

<input type="hidden" name="random_sc" id="random_sc" value="<?php echo $random_sc; ?>" />



<div class="box box-info">

  <form class="form-horizontal" method="POST">

    <div class="box-body">

      <div class="form-group">



        <label class="col-sm-2 font_label" style="vertical-align:bottom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shredder&nbsp;No </label>
        <div id="shredder_no_div">

          <div class="col-sm-3">
            <input type="hidden" readonly name="shredder_no" id="shredder_no" class="text_box" style="font-size:12px" value="<?php echo $enquiry_nos; ?>" /><strong> <span style="color:#FF0000;"><strong><?php echo $enquiry_nos; ?></strong></span>

            </strong>
          </div>
        </div>

        <div class="col-sm-1"></div>

        <label class="col-sm-2 font_label">Entry Date<span style="color:#F00">*</span></label>

        <div class="col-sm-3">
          <!-- <input type="date" class="form-control" name="entry_date" id="entry_date" value="<?php echo date("Y-m-d"); ?>" onchange="check_entry_date(),get_reading_value(),get_yesterday_closing_km()"/> -->
          <input type="date" class="form-control" name="entry_date" id="entry_date" value="<?php echo date("Y-m-d"); ?>" onchange="check_entry_date(),get_reading_value()" />


        </div>

      </div>

      <div class="form-group">

        <label class="col-sm-2 control-label font_label">Site&nbsp;Name<span style="color:#F00">*</span></label>

        <div class="col-sm-3">



          <select name="site_name" id="site_name" class="form-control  " style="width:100%" onChange="get_plant_name_display1(this.value),get_site_shredder_no(this.value),get_yesterday_closing_km(),get_reading_value(),get_shredder_service_details(),check_entry_date()">

            <option value="">Select</option>

            <?php

            if ($sess_site_id == "All") {

              $sql = $db->prepare("select * FROM site_creation where site_status='1' order by site_name ASC");
              $sql->execute();
            } else {

              $sql = $db->prepare("select * FROM site_creation where id in ($sess_site_id) and site_status='1' order by site_name ASC");
              $sql->execute();
            }

            $row2 = $sql->fetchAll();

            foreach ($row2 as $rsdata) {

              $id_site = $rsdata['id'];

              $site_namess = $rsdata['site_name'];



            ?>

              <option value="<?php echo $id_site; ?>"><?php echo $site_namess; ?></option>

            <?php

            } ?>

          </select>



        </div>





        <label class="col-sm-3 control-label font_label">Plant&nbsp;Name<span style="color:#F00">*</span></label>

        <div class="col-sm-3">

          <div id="panel_plant_name_div">



          </div>

        </div>



      </div>

      <div class="form-group">

        <label class="col-sm-2 control-label font_label">Shredder&nbsp;Name<span style="color:#F00">*</span></label>

        <div class="col-sm-3">
          <select name="shredder_name" id="shredder_name" class="form-control  " style="width:100%" onchange="get_yesterday_closing_km(),check_entry_date(),get_reading_value(),get_shredder_service_details()">
            <option value="">Select</option>
            <option value="1">Primary Shredder</option>

            <option value="2">Secondary Shredder</option>

          </select>


        </div>


        <label class="col-sm-3 control-label font_label">Staff&nbsp;Name<span style="color:#F00">*</span></label>

        <div class="col-sm-3">
          <select name="user_name" id="user_name" class="form-control  " style="width:100%" disabled="">

            <?php


            $pdo_user = $db->prepare("select staff_name from  user_creation where user_id='$sess_user_id'");
            $pdo_user->execute();
            $get_user = $pdo_user->fetchAll();
            $user_staff_name = $get_user[0][staff_name];

            $pdo_staff = $db->prepare("select staff_name from  staff_creation where id='$user_staff_name'");
            $pdo_staff->execute();
            $get_staff = $pdo_staff->fetchAll();
            $staff_name = $get_staff[0][staff_name];

            ?>
            <option value="<?php echo $user_staff_name; ?>"><?php echo $staff_name; ?></option>
          </select>


        </div>

      </div>

      <div class="form-group">
        <!-- SERVICE KM -->
        <label class="col-sm-8 control-label font_label">Service Hours</label>
        <div class="col-sm-3">
          <input readonly name="service_km" id="service_km" class="form-control numeric">
          <span  class='text-danger' id="check_service_km"></span>
        </div>

        <div id="service_history_details" style="display:none" ;>
          <img src="image/eye.jpg" onclick="get_service_history_details()" width="30" height="30" title="Service History Details" />
        </div>
        
      </div>


      <!--------------------------------------------------------------------------------------------------->


      <span class='text-danger' id="check_entry_date"></span>


      <div class="box-body">
        <!--------------------------------------------------------------------------------------------------->
        <span id="sublist_validation" style="display:none; color:red;">Fill Sublist</span>
        <div class="form-group">

          <div class="box-body">

            <div class="col-sm-12">

              <div id="shredder_entry_sublist_div">

                <?php include("shredder_entry_sublist.php"); ?>

              </div>
            </div>
          </div>
        </div>



        <!---------------------------------------------------------------------------------------------->

        <div class="form-group">







          <label class="col-sm-2 font_label">Description<span></span></label>

          <div class="col-sm-4">

            <textarea name="description" id="description" class="form-control numeric" onkeyup=""></textarea>

          </div>



        </div>



        <!---------------------------------------------------------------------------------------------->


        <!-- add plant name -->
        <div align="center">

          <button type="button" id="button" class="btn btn-info" onClick="add_shedder_entry_main(random_no.value,random_sc.value,shredder_no.value,entry_date.value,site_name.value,description.value,shredder_name.value,user_name.value)">SUBMIT</button>

        </div>





      </div>



  </form>
</div>



<?php /*$db->null();*/ ?>