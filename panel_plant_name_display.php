<?php 

error_reporting(0);

ob_start();

session_start();

require_once("../model/config_pdo.php"); 

//include_once("../include/common_function.php"); 

    $sess_site_id=$_SESSION['sess_site_id'];

 $site_name_chck=$_GET['site_name'];

?>

<select name="plant_name" id="plant_name"  class="form-control" onchange="get_yesterday_closing_km(),get_reading_value(),get_shredder_service_details(),check_entry_date()" class="form-control" style="width:100%"  >

                    <?php 

					//if($sess_site_id=="All")

					//{ ?>
                        <option value="">Select</option>
                        <?php

                    $sql = $db->prepare("select * FROM plant_creation where site_id = '$site_name_chck' order by id ASC");
                    $sql->execute();

					//}

					//else

					//{ ?>
                        <!-- <option value="">Select</option> -->
                        <?php


                    //$sql = $db->prepare("select * FROM plant_creation where site_id ='$site_name_chck' order by id ASC");
                   //$sql->execute();


					//}

                    $rows2=$sql->fetchAll();
                    foreach($rows2 as $rsdata)
                    {

                        $plant_id=$rsdata['id'];

                       $plant=$rsdata['plant'];

                       

                        ?>

                        <option value="<?php echo $plant_id;?>" ><?php echo $plant;?></option>

                        <?php

                    }?>

                </select>      

      <script >
           $(function () {

  //Initialize Select2 Elements

  $(".select2").select2();

  });
      </script>        

 