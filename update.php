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


$date = date("Y");

$st_date = substr($date, 2);

$month = date("m");

$datee = $st_date . $month;

$sess_site_id = $_SESSION['sess_site_id'];

function pdo_get_assign_person($db, $staff_id)
{
  $staff_name1 = $db->prepare("select staff_name from staff_creation where id='$staff_id'");
  $staff_name1->execute();
  $staff_name1_result = $staff_name1->fetchAll();
  $staff_name = $staff_name1_result[0][staff_name];
  return $staff_name;
}

$sql = $db->prepare("SELECT * FROM shredder_entry_main where id='$_GET[update_id]' ");

$sql->execute();
$rows = $sql->fetchAll();
foreach ($rows as $record) {

  $random_nos = $record['random_no'];

  $random_scs = $record['random_sc'];

  $shredder_no = $record['shredder_no'];

  $entry_date  = $record['entry_date'];

  $site_name_edit = $record['site_name'];

  $plant_name_edit = $record['plant_name'];

  $description = $record['description'];

  $user_name_edit = $record['user_name'];

  $staff_name = pdo_get_assign_person($db, $user_name_edit);

  $shredder_name_edit = $record['shredder_name'];
}


//CHECK THE ENTRY IS LAST ENTRY OR NOT - START

$check_sql = $db->prepare("SELECT * FROM shredder_entry_main WHERE site_name='$site_name_edit' and plant_name='$plant_name_edit' and shredder_name='$shredder_name_edit' and entry_date > '$entry_date' ");
$check_sql->execute();
$check_main_count = $check_sql->rowCount();

//CHECK THE ENTRY IS LAST ENTRY OR NOT - END




?><input type="hidden" name="random_no" id="random_no" value="<?php echo $random_nos; ?>" />

<input type="hidden" name="random_sc" id="random_sc" value="<?php echo $random_scs; ?>" />



<div class="box box-info">

  <form class="form-horizontal" method="POST">

    <div class="box-body">

      <div class="form-group">

        <label class="col-sm-2 control-label font_label">Shredder&nbsp;No<span style="color:#F00">*</span></label>



        <div class="col-sm-3">

          <input type="hidden" readonly name="shredder_no" id="shredder_no" class="text_box" style="font-size:12px" value="<?php echo $shredder_no; ?>" /><strong> <span style="color:#FF0000;"><strong><?php echo $shredder_no; ?></strong></span>

          </strong>
        </div>



        <label class="col-sm-3 control-label font_label">Date&nbsp;<span style="color:#F00">*</span></label>

        <div class="col-sm-3">

          <input type="date" class="form-control" name="entry_date" id="entry_date" value="<?php echo date("Y-m-d", strtotime($entry_date)); ?>" readonly />

        </div>

      </div>

      <div class="form-group">

        <label class="col-sm-2 control-label font_label">Site&nbsp;Name<span style="color:#F00">*</span></label>

        <div class="col-sm-3">



          <select name="site_name" id="site_name" class="form-control  " style="width:100%" onChange="get_plant_name_panel(site_name.value);" onFocus="get_plant_name_panel(site_name.value);" disabled>

            <?php

            if ($sess_site_id == "All") {

              $sql = $db->prepare("select * FROM site_creation where site_status='1' order by site_name ASC");
              $sql->execute();
            } else {

              $sql = $db->prepare("select * FROM site_creation where id in ($sess_site_id) and site_status='1' order by site_name ASC");
              $sql->execute();
            }

            $rows = $sql->fetchAll();

            foreach ($rows as $rsdata) {

              $id_site = $rsdata['id'];

              $site_name = $rsdata['site_name'];



            ?>

              <option value="<?php echo $id_site; ?>" <?php if ($id_site == $site_name_edit) { ?> selected <?php } ?>><?php echo $site_name; ?></option>

            <?php

            } ?>

          </select>



        </div>



        <label class="col-sm-3 control-label font_label">Plant&nbsp;Name<span style="color:#F00">*</span></label>

        <div class="col-sm-3">

          <div id="panel_plant_name">

            <select name="plant_name" id="plant_name" onChange="" class="form-control  " style="width:100%" disabled>

              <?php

              if ($sess_site_id == "All") {

                $sql = $db->prepare("select * FROM plant_creation order by id ASC");
                $sql->execute();
              } else {

                $sql = $db->prepare("select * FROM plant_creation where site_id in ($sess_site_id) order by id ASC");
                $sql->execute();
              }


              $rows = $sql->fetchAll();

              foreach ($rows as $rsdata) {

                $plant_id = $rsdata['id'];

                $plant = $rsdata['plant'];



              ?>

                <option value="<?php echo $plant_id; ?>" <?php if ($plant_name_edit == $plant_id) { ?> selected<?php } ?>><?php echo $plant; ?></option>

              <?php

              } ?>

            </select>

          </div>
        </div>

      </div>


      <div class="form-group">


        <label class="col-sm-2 control-label font_label">Shredder&nbsp;Name<span style="color:#F00">*</span></label>

        <div class="col-sm-3">
          <select name="shredder_name" id="shredder_name" class="form-control  " style="width:100%" disabled>

            <option value="1" <?php if ($shredder_name_edit == 1) { ?> selected<?php } ?>>Primary Shredder</option>

            <option value="2" <?php if ($shredder_name_edit == 2) { ?> selected<?php } ?>>Secondary Shredder</option>

          </select>


        </div>

        <label class="col-sm-3 control-label font_label">Staff&nbsp;Name<span style="color:#F00">*</span></label>

        <div class="col-sm-3">
          <select name="user_name" id="user_name" class="form-control  " style="width:100%" disabled="">
            <option value="<?php echo $user_name_edit; ?>"><?php echo ucfirst($staff_name); ?></option>
          </select>

        </div>
      </div>
      <div class="form-group">
        <!-- SERVICE KM -->
        <label class="col-sm-8 control-label font_label">Service Hours</label>
        <div class="col-sm-3">
          <input readonly name="service_km" id="service_km" class="form-control numeric" >
          <span  class='text-danger' id="check_service_km"></span>
        </div>

        <div id="service_history_details" style="display:none" ;>
          <img src="image/eye.jpg" onclick="get_service_history_details()" width="30" height="30" title="Service History Details" />
        </div>
        
      </div>

    
      <span class='text-danger' id = "check_entry_date"></span> 
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

          <textarea name="description" id="description" class="form-control numeric" onkeyup=""><?php echo $description; ?></textarea>

        </div>

      </div>



      <div align="center">
        <button type="button" id="button" class="btn btn-info" onClick="update_shredder_main_entry(random_no.value,random_sc.value,shredder_no.value,entry_date.value,site_name.value,plant_name.value,shredder_name.value,description.value,user_name.value,'<?php echo $_GET['update_id']; ?>')">UPDATE</button>

      </div>



    </div>

</div>



</form>
</div>



<?php //$db->close();

?>

<script>
  //$.widget.bridge('uibutton', $.ui.button);

  $(function() {

    //Initialize Select2 Elements

    $(".select2").select2();

  });

  $('.sl').select2({

    placeholder: 'Select'

  })
</script>