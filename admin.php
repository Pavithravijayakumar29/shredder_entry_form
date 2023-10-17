<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>
<?php 
error_reporting(0);
ob_start();
session_start(); 
//require_once("model/config_pdo.php"); 
include("model/config_pdo.php");
include_once("../include/common_function_pdo.php");

$user_type_ids=$_SESSION['user_type_ids'];

$session_user_name=$_SESSION['sess_user_name'];

$session_password=$_SESSION['password'];

$user_types=$_SESSION['user_types'];

$sess_site_id=$_SESSION['sess_site_id'];



?>  





<div class="modal fade" data-keyboard="false" data-backdrop="static"  id="myModal" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

 <div class="modal-dialog" style="width: 80%;">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel"></h4>

      </div>

      <div class="modal-body">

        ...

      </div>

    </div>

  </div>

</div>



<div class="row space-hight">

<div class="col-md-12">

<a href="shredder_entry_form/create.php" accesskey="o" data-toggle="modal" data-target="#myModal" title="Add Shredder Entry" data-remote="true" class="btn btn-default"><img src="image/pen.png" width="35" height="35"></a>

<span class="topic-header">Shredder Entry</span>  

</div>

</div>

<div class="col-md-12 pad_no">

<form name="shredder_entry" id="shredder_entry" class="form-horizontal" method="post" action="#">

  

    <div class="col-sm-2">

    <strong>From Date</strong>

             <input type="date" class="form-control numeric" name="from_date" id="from_date"  value="<?php echo date("Y-m-d") ?>">

    </div>

    <div class="col-sm-2">

   <strong>To Month</strong>

               <input type="date" class="form-control numeric" name="to_date" id="to_date" value="<?php echo date("Y-m-d") ?>">

             

    </div>

    <div class="col-sm-2">

   <strong>Site Name </strong>

    <select name="site_name" id="site_name" class="form-control site_co  select2" style="width:100%" onChange="get_plant_name_panel_filter(site_name.value);" onFocus="get_plant_name_panel_filter(site_name.value);" multiple>

      

                    <?php 

          if($sess_site_id=="All")

          {?>


                    <?php

                    $sql = $db->prepare("select * FROM site_creation where site_status='1' order by site_name ASC");
                    $sql->execute();

          }

          else

          {

                    $sql = $db->prepare( "select * FROM site_creation where id in ($sess_site_id) and site_status='1' order by site_name ASC");
                    $sql->execute();

          }

                    $rows=$sql->fetchAll();

                   foreach ($rows as $rsdata) 
                     
                   

                    {

                        $id_site=$rsdata['id'];

                        $site_namess=$rsdata['site_name'];

                        $value=explode(',',$_GET[site_name]);

                        ?>
  <option value="<?php echo $id_site;?>" <?php foreach($value as $val){if($id_site==$val){?> selected<?php } }?>><?php echo $site_namess;?></option>
                       <!--  <option value="<?php echo $id_site;?>" ><?php echo $site_namess;?></option>
 -->
                        <?php

                    }?>

                </select>      

           

         </div>

         

           <div class="col-sm-2">

   <strong>Plant Name </strong>



          <div id="panel_plant_namess">

        <select name="plant_name" id="plant_name" onChange="" class="form-control plant_co select2  " style="width:100%" multiple="">

         <?php
     if ($sess_site_id == "All") 
            {
              $sql = $db->prepare("select * FROM plant_creation order by id ASC");
               $sql->execute();

            }
            else 
            {
              $sql = $db->prepare("select * FROM plant_creation where site_id IN ($sess_site_id) order by id ASC");
               $sql->execute();

            }
           
                    $rows=$sql->fetchAll();

                   foreach ($rows as $rsdata) 
                     
                   

                    {

              $plant_id = $rsdata[id];
              $plant = $rsdata[plant];
              $site_id1 = $rsdata[site_id];
              $value=explode(',',$_GET[plant_name]);
              ?>
              <option value="<?php echo $plant_id; ?>" <?php foreach($value as $val){if($plant_id==$val){?> selected<?php } }?>><?php echo $plant; ?></option>
              <?php
            } ?>
          </select>     

              </div>

           </div>

         

      <div class="col-sm-2" style="margin-top:19px;">

     <!-- <input id="factoryentry" type="submit"  class="btn btn-info"  name="factoryentry" value="GO"  />-->

                   <input id="follow" type="button" class="btn btn-info "  name="follow" value="GO"

                    onclick="schredder_entry_list(from_date.value,to_date.value)"  />

    </div>

</form>



</div>

</div>

 



<div id="shredder_entry_list_div">

 <?php 

 include("shredder_entry_list.php");

 

 ?>

</div>

<script>

function shredder_indi_print(url)

{

  onmouseover19= window.open(url,'onmouseover19','height=600,width=1000,scrollbars=yes,resizable=no,left=50,top=50,toolbar=no,location=no,directories=no,status=no,menubar=no');

}



function shredder_main_print(url)

{

  onmouseover19= window.open(url,'onmouseover19','height=600,width=1000,scrollbars=yes,resizable=no,left=50,top=50,toolbar=no,location=no,directories=no,status=no,menubar=no');

}



function get_plant_name_panel_filter(site_name)

{

  var site_ids = [];
  
   jQuery.each(jQuery('.site_co option:selected'), function() {
        site_ids.push(jQuery(this).val()); 
    });
   
    var site_ids=site_ids.toString();

jQuery.ajax({

    type: "GET",

      url:"shredder_entry_form/panel_plant_name.php",

    data: "site_name="+site_ids,

    success: function(msg){jQuery("#panel_plant_namess").html(msg);

    }

  });   

}



function schredder_entry_list(from_date,to_date)

{ 
  var site_ids = [];
  
   jQuery.each(jQuery('.site_co option:selected'), function() {
        site_ids.push(jQuery(this).val()); 
    });
   
    var site_ids=site_ids.toString();


     var plant_ids = [];
  
   jQuery.each(jQuery('.plant_co option:selected'), function() {
        plant_ids.push(jQuery(this).val()); 
    });
   
    var plant_ids=plant_ids.toString();




   jQuery.ajax({

    type: "POST",

    url: "shredder_entry_form/shredder_entry_list.php",

    data: "from_date="+from_date+"&to_date="+to_date+"&site_name="+site_ids+"&plant_name="+plant_ids,

    success: function(data) {

    jQuery("#shredder_entry_list_div").html(data);

      }

    });

    }





</script>





