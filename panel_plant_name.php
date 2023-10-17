<?php 

error_reporting(0);

ob_start();

session_start();

require_once("../model/config_pdo.php"); 

include_once("../include/common_function.php"); 


    $sess_site_id=$_SESSION['sess_site_id'];

 $site_name_chck=$_GET['site_name'];

?>

<select name="plant_name" id="plant_name"  class="form-control plant_co select2" style="width:100%"  multiple>

                    <?php 

					//if($sess_site_id=="All")

					//{

                    $sql = $db->prepare("select * FROM plant_creation where site_id IN ($site_name_chck) order by id ASC");
                    $sql->execute();

					//}

					// else

					// {

     //                $sql = $db->prepare("select * FROM plant_creation where site_id in($site_name_chck) order by id ASC");
     //                $sql->execute();

					// }

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

 