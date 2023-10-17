 <?php
  error_reporting(0);

  ob_start();


  include_once("../model/config_pdo.php");
  include_once("../include/common_function.php");

  ?>
  
 <div id="">
   <?php
    function pdo_get_shift_name($db, $shift_id)
    {
      $shift_name1 = $db->prepare("select shift_name from shift_creation where shift_id='$shift_id'");
      $shift_name1->execute();
      $shift_name1_result = $shift_name1->fetchAll();
      $site_name = $shift_name1_result[0][shift_name];
      return $site_name;
    }

    //GET CONSTANT VALUE
    $get_cons_val = $db->prepare("SELECT max_limit as max_limit from constant_values where screen_name='shredder_entry_form' and particulars_name='service_km' ");

    $get_cons_val->execute();
    $fetch_data = $get_cons_val->fetchAll();
    foreach ($fetch_data as $fetch_const_val) {
      $max_limit = $fetch_const_val['max_limit'];
    }

    $query2 = $db->prepare("select * from  shredder_entry_sub where  id='$_GET[id]' and (shredder_no='$_POST[shredder_no]' or shredder_no='$_GET[shredder_no]') and   (random_no='$_POST[random_no]' or random_no='$_GET[random_no]') and (random_sc='$_POST[random_sc]' or random_sc='$_GET[random_sc]')");
    $query2->execute();
    $rows2 = $query2->fetchALl();
    foreach ($rows2 as $record2) {
      $i = $i + 1;
      $shredder_no_edit = $record2['shredder_no'];
      $opening_edit = $record2['open'];
      $closing_edit = $record2['close'];

      $total_value_edit = $record2['total_value'];
      $type_edit1 = $record2['type'];
      $service_status_edit = $record2['service_status'];
      $shredder_replace_edit = $record2['shredder_replace'];
      $reading_edit = $record2['reading'];
      $serviced_by_edit = $record2['serviced_by'];
      $service_description_edit = $record2['service_description'];
      $spare_used_edit = $record2['spare_used'];
    }


    ?>


   <!-- form start -->
   <table width="90%" class="table table-bordered">
     <thead>
       <tr>
         <th width="4%" class="font_label" height="27" align="left">S.no</th>

         <th width="15%" class="font_label" style="text-align:left"><strong>Shift Name</strong><span style="color:#F00">*</span></th>
         <th width="14%" class="font_label" style="text-align:left" align="left"><strong>Open</strong><span style="color:#F00">*</span></th>
         <th width="13%" class="font_label" style="text-align:"><strong>Close</strong><span style="color:#F00">*</span></th>
         <th width="12%" class="font_label" style="text-align:"><strong>Shredder Replace</strong></th>
         <th width="10%" class="font_label" style="text-align:"><strong>Shredder Service</strong></th>
         <th width="10%" class="font_label" style="text-align:center" align="left"><strong>Reading</strong>
         </th>
         <th width="16%" align="left" class="font_label" style="text-align:"><strong>Total</strong><span style="color:#F00">*</span></th>
         <th width="12%" class="center font_label" style="text-align:center">Action</th>
       </tr>
     </thead>
     <tbody>
       <tr>
         <td align="left"><label for="form-field-1" class="no-padding-right control-label col-sm-20">#</label></td>
         <?php foreach ($variable as $key => $value) : ?>

         <?php endforeach ?>

         <!----------------------------------------------------------------------------->
         <?php

          ?>



         <input type="hidden" name="service_history_count" id="service_history_count" placeholder="service_history_count" value="">
         <input type="hidden" name="last_closing_value" id="last_closing_value" placeholder="last_closing_value" value="">
         <!-- constant Service Km Limit -->
         <input type="hidden" name="const_km_limit" id="const_km_limit" placeholder="const_km_limit" value="<?php echo $max_limit; ?>">


         <td align="left">
           <select name="type" id="type" class="form-control" onchange="freeze_fields(),get_reading_value(),get_yesterday_closing_km()">

             <option value="">Select</option>

             <?php

              $sql = $db->prepare("select * FROM shift_creation where status!='1' order by shift_name ASC");
              $sql->execute();


              $sql_exe = $sql->fetchAll();

              foreach ($sql_exe as $rsdata) {

                $shift_id = $rsdata['shift_id'];

                $shift_name11 = $rsdata['shift_name'];

              ?>

               <option value="<?php echo $shift_id; ?>" <?php if ($shift_id == $type_edit1) { ?> selected <?php } ?>><?php echo $shift_name11; ?></option>

             <?php

              } ?>

           </select>

         </td>
         <td align="left">
           <!-- <input type="text" onKeyPress="if ((event.keyCode &lt; 46) || (event.keyCode &gt; 57)) event.returnValue = false;" id="opening" name="opening" class="form-control numeric" value="<?php echo $opening_edit; ?>" onKeyUp="get_total_shredder_entry(opening.value,closing.value),get_shredder_service_details()" onFocus="get_total_shredder_entry(opening.value,closing.value)"> -->
           <input type="text"  oninput="restrictDecimalPlaces(this, 2)" onKeyPress="if ((event.keyCode &lt; 46) || (event.keyCode &gt; 57)) event.returnValue = false;" id="opening" name="opening" class="form-control numeric" value="<?php echo $opening_edit; ?>" onKeyUp="get_total_shredder_entry(opening.value,closing.value)" onFocus="get_total_shredder_entry(opening.value,closing.value)">
         </td>
        
         <td align="left">
           <input type="text" oninput="restrictDecimalPlaces(this, 2)" onKeyPress="if ((event.keyCode &lt; 46) || (event.keyCode &gt; 57)) event.returnValue = false;" id="closing" name="closing" class="form-control numeric" value="<?php echo $closing_edit; ?>" onKeyUp="get_total_shredder_entry(opening.value,closing.value),get_service_km_calc()" onFocus="get_total_shredder_entry(opening.value,closing.value)">
         </td>

         <td>
           <div class="col-sm-3">
             <input type="checkbox" id="shredder_replace" name="shredder_replace" value="<?php echo $shredder_replace_edit; ?>" <?php if ($shredder_replace_edit == 1) { ?>checked disabled <?php } ?> onclick="get_shredder_service_details()" <?php if ($shredder_replace_edit == 1 || $service_status_edit == 1) { ?> disabled <?php } ?>>

           </div>
         </td>
         <td>
           <div class="col-sm-3">
             <input type="checkbox" id="service_status" name="service_status" value="<?php echo $service_status_edit; ?>" <?php if ($service_status_edit == 1) { ?>checked disabled <?php } ?> onclick="get_shredder_service_details()" <?php if ($shredder_replace_edit == 1 || $service_status_edit == 1) { ?> disabled <?php } ?>>


           </div>
         </td>

         <td>
           <input type="text" oninput="restrictDecimalPlaces(this, 2)" onKeyPress="if ((event.keyCode &lt; 46) || (event.keyCode &gt; 57)) event.returnValue = false;" class="form-control numeric" disabled id="reading" name="reading" onkeyup="get_service_km_calc()" value="<?php echo $reading_edit; ?>" <?php if ($shredder_replace == 1 || $service_status_edit == 1) { ?> enabled <?php } ?>>
         </td>

         <td align="left">
           <input type="text" readonly id="total_value" name="total_value" class="form-control numeric" value="<?php echo $total_value_edit; ?>" placeholder="">
         </td>


         <td align="center"><?php if ($_GET['id'] == '') {
          //if($check_main_count == 0){ ?>
             <input type="button" class="btn btn-info" id="add" value="ADD" onClick="shredder_entry_sub_add(random_no.value,random_sc.value,shredder_no.value,entry_date.value,site_name.value,opening.value,closing.value,total_value.value,type.value,description.value,user_name.value,shredder_name.value)">
           <?php } ?>
           <?php if ($_GET['id'] != '') {  ?>
             <input type="button" class="btn btn-info" id="edit" value="EDIT" onclick="shredder_entry_sub_edit(random_no.value,random_sc.value,shredder_no.value,user_name.value,entry_date.value,site_name.value,opening.value,closing.value,total_value.value,type.value,'<?php echo $_GET['id']; ?>')" />
           <?php } //} ?>
         </td>
       </tr>

       <!-- /.box-body -->
       <div id="curd_message" align="center" style="font-weight:bold; padding:5px;"></div>
       <!-- /.box-footer -->
       <?php
       
        $i = 0;

        $get_query_sub = $db->prepare("select * from  shredder_entry_sub where (shredder_no='$_POST[shredder_no]' or shredder_no='$_GET[shredder_no]') and  (random_no='$_POST[random_no]' or random_no='$_GET[random_no]') and (random_sc='$_POST[random_sc]' or random_sc='$_GET[random_sc]') order by id asc");
        $get_query_sub->execute();
        $rows = $get_query_sub->fetchAll();
        foreach ($rows as $fetch_list2) {
          $i = $i + 1;
          $sub_id = $fetch_list2['id'];
          $opening = $fetch_list2['open'];
          $closing = $fetch_list2['close'];
          $shredder_no = $fetch_list2['shredder_no'];
          $total_value = $fetch_list2['total_value'];
          $site_val = $fetch_list2['site_name'];
          $plant_val = $fetch_list2['plant_name'];
          $shredder_val = $fetch_list2['shredder_name'];
          $entry_date_val = $fetch_list2['entry_date'];
          $shredder_replace = $fetch_list2['shredder_replace'];
          $service_status = $fetch_list2['service_status'];
          $reading = $fetch_list2['reading'];
          $type = ($fetch_list2['type']);
          $random_no = $fetch_list2['random_no'];
          $random_sc = $fetch_list2['random_sc'];
          //later insert shreddre no
          $sql5 = $db->prepare("select id from  shredder_entry_sub where  random_no='$random_no' and random_sc='$random_sc' and mu_status!='1' order by id desc limit 1");
          $sql5->execute();
          $sql_data = $sql5->fetchAll();
          $sql_id5 = $sql_data[0]['id'];


          //ADD ENTRY VIEW FROM MAIN_ID START
          $get_main_id = $db->prepare("select * from  shredder_entry_main where (id='$_POST[id]' or id='$_GET[id]') and(shredder_no='$_POST[shredder_no]' or shredder_no='$_GET[shredder_no]') and  (random_no='$_POST[random_no]' or random_no='$_GET[random_no]') and (random_sc='$_POST[random_sc]' or random_sc='$_GET[random_sc]') order by id desc");

          $get_main_id->execute();
          $row = $get_main_id->fetchAll();
          foreach ($row as $record) {
            $main_table_id = $record['id'];
          }
          //ADD ENTRY VIEW FROM MAIN_ID END

        ?>
         <tr>
           <td align="left"><?php echo $i; ?></td>
           <td align="left"><?php echo pdo_get_shift_name($db, $type); ?></td>
           <td align="right" style="text-align: left"><?php echo $opening; ?></td>
           <td align="right" style="text-align: left"><?php echo $closing; ?></td>

           <td align="center"> <input type="checkbox" width="15px" height="15px" style="padding-bottom: 10px;" value="<?php echo $shredder_replace; ?>" <?php if ($shredder_replace == 1) {echo 'checked';} ?> disabled=<?php echo true; ?>> </td>

           <td align="center"> <input type="checkbox" width="15px" height="15px" style="padding-bottom: 10px;" value="<?php echo $service_status; ?>" <?php if ($service_status == 1) {echo 'checked';} ?> disabled=<?php echo true; ?> >
           </td>

           <td align="right"><?php echo $reading; ?>&nbsp;</td>

           <td align="right"><?php echo ($total_value); ?></td>
           <td colspan="6" align="center" class="center">
             <div class="hidden-sm hidden-xs action-buttons">
               <?php if ($sub_id == $sql_id5) { 
                //if($check_main_count == 0){ ?>
                 <a href="#" onClick="edit_shredder_sublist('<?php echo $sub_id; ?>','<?php echo $shredder_no; ?>','<?php echo $fetch_list2['random_no']; ?>','<?php echo $fetch_list2['random_sc']; ?>',<?php echo $fetch_list2['service_status']; ?>,<?php echo $fetch_list2['shredder_replace']; ?>)" title="Update Panel Reading" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>

                 <a class="btn btn-default" href="#" onclick="delete_shredder_entry_sublist('<?php echo $sub_id; ?>','<?php echo $shredder_no; ?>','<?php echo $fetch_list2['random_no']; ?>','<?php echo $fetch_list2['random_sc']; ?>')"><span class="glyphicon glyphicon-trash"></span></a>

               <?php } //} ?>

             </div>
           </td>

         <?php
          $overall_tot_reading = $i;
        } ?>
         </tr>
         <input type="hidden" name="over_total" id="over_total" value="<?php if ($overall_tot_reading != '') {
                                                                          echo $overall_tot_reading;
                                                                        } else {
                                                                          echo "0";
                                                                        } ?>">

     </tbody>
   </table>
 </div>

 <div class="box-body">
   <div id="shredder_service_details" style="display:none" ;>
     <table width="90%" class="table table-bordered">
       <tr>
         <td>
           <label class="col-sm-1 control-label font_label" for="serviced_by">Serviced By<span id="serviced_by_span" style="color:#F00">*</span></label>
         </td>
         <td>
           <input type="text" name="serviced_by" id="serviced_by" value="<?php echo $serviced_by_edit; ?>" class="form-control numeric" autocomplete="off">

         </td>

         <td>
           <label class="col-sm-1 control-label font_label" for="spare_used">Spare Used<span id="spare_used_span" style="color:#F00">*</span></label>
         </td>
         <td>
           <textarea name="spare_used" id="spare_used" class="form-control numeric" autocomplete="off"><?php echo $spare_used_edit; ?></textarea>

         </td>
         <td>
           <label class="col-sm-1 control-label font_label" for="service_description">Serviced Description<span id="spare_used_span" style="color:#F00">*</span></label>
         </td>
         <td>
           <textarea name="spare_used" id="service_description" class="form-control numeric" autocomplete="off"><?php echo $service_description_edit; ?></textarea>
         </td>
       </tr>
     </table>
     <br><br><br><br><br>
   </div>
 </div>

 <script>
   $(document).ready(function() {
     // get_service_km_calc();
     get_reading_value();
     //check_entry_date();
   });


   function edit_shredder_sublist(id, shredder_no, random_no, random_sc, service_ststus, shredder_replace) {

     $.ajax({

       type: "POST",

       url: "shredder_entry_form/shredder_entry_sublist.php?id=" + id + "&shredder_no=" + shredder_no + "&random_no=" + random_no + "&random_sc=" + random_sc,

       success: function(data) {

         $("#shredder_entry_sublist_div").html(data);


         $('#type').attr('disabled', 'disabled');

         if (service_ststus == 1) {
           $('#shredder_service_details').show();
         } else {
           $('#shredder_service_details').hide();
         }

         if (shredder_replace == 1 || service_ststus == 1) {
           $('#reading').removeAttr('disabled');
         }
         get_reading_value();

       },

       error: function() {

         alert('error handing here');

       }

     });

   }





   function delete_shredder_entry_sublist(delete_id, shredder_no, random_no, random_sc)

   {

     if (confirm("Are you sure?")) {

       $.ajax({

         type: "POST",

         url: "model/shredder_entry_form.php?action=delete_sub&delete_id=" + delete_id + "&shredder_no=" + shredder_no + "&random_no=" + random_no + "&random_sc=" + random_sc,

         success: function(data) {

           if (data == 0) {
             //window.location.href = 'index1.php?hopen=shredder_entry_form/admin';
             window.location.reload(true);
           } else {
             $("#shredder_entry_sublist_div").html(data);
             get_reading_value();
           }
         },

         error: function() {

           alert('error handing here');

         }

       });

     }



   }
 </script>