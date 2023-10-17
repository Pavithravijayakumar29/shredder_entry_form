<?php

error_reporting(0);

ob_start();

session_start();

include("../model/config_pdo.php");

$user_type_ids = $_SESSION['user_type_ids'];

$session_user_name = $_SESSION['sess_user_name'];

$session_password = $_SESSION['password'];

$user_types = $_SESSION['user_types'];

$sess_site_id = $_SESSION['sess_site_id'];

$from_date = $_GET['from_date'];

$to_date = $_GET['to_date'];

$site_name = $_GET['site_name'];

$plant_name = $_GET['plant_name'];

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

function pdo_get_shift_name($db, $shift_id)
{
    $shift_name1 = $db->prepare("select shift_name from shift_creation where shift_id='$shift_id'");
    $shift_name1->execute();
    $shift_name1_result = $shift_name1->fetchAll();
    $site_name = $shift_name1_result[0][shift_name];
    return $site_name;
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

if ($sess_site_id == 'All') {
    if ($site_name != "") {
        $site_name1 = "site_name IN ($site_name) ";
    } else {
        $site_name1 = '';
    }
} else {
    if ($site_name != "") {
        $site_name1 = "site_name IN ($site_name) ";
    } else {
        $site_name1 = "site_name IN ($sess_site_id)";
    }
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



$sql = $db->prepare("SELECT * FROM  shredder_entry_main where $get_query131 id!=''  order by entry_date asc");


$sql->execute();

$sql_row = $sql->fetchAll();

$blog = array('', '', '', '', '', '', '', '', '', 'Shredder Entry', '', '', '', '', '', '', '', '', '');

foreach ($blog as $icon) {

    $output        .= '"' . $icon . '",';
}

$output .= "\n";

$output .= "\n";

$output .= '"S.No","Date","Shredder No","Shredder Name","Site Name","Plant Name","Description ","User Name","Shift Name","Open","Close","Total","Status","Reading","Service Hours","Serviced By","Spare Used","Service Description"' . "\n";

$table_values = array(s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11, s12, s13, s14, s15, s16, s17, s18);

$sno = 0;

foreach ($sql_row as $record) {

    $k = 0;
    $entry_date1 = date("d-m-Y", strtotime($record['entry_date']));
    $entry_date = $record['entry_date'];
    $site_id = $record['site_name'];

    $plant_id = $record['plant_name'];

    $site_name = pdo_get_site_name($db, $site_id);

    $plant_name = pdo_get_plant_name($db, $plant_id);

    $shredder_no = $record['shredder_no'];

    $random_no = $record['random_no'];

    $random_sc = $record['random_sc'];

    $total_value = $record['total_value'];

    $entry_status = $record['entry_status'];

    $description =  ucfirst($record['description']);


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



    $sql12 = $db->prepare("select * from   shredder_entry_sub where shredder_no='$shredder_no' and random_no='$random_no' and random_sc='$random_sc'  order by id asc ");

    $sql12->execute();

    $rows2 = $sql12->fetchAll();

    foreach ($rows2 as $rsdata2) {
        $k = $k + 1;
        $sno = $sno + 1;

        $type = pdo_get_shift_name($db, $rsdata2['type']);

        $open = $rsdata2['open'];

        $get_shift_id = $rsdata2['type'];
        // $entry_date = $rsdata2['entry_date'];

        $close = $rsdata2['close'];
        //echo "close".$close."<br>"."endclose";
        $total_value = $rsdata2['total_value'];

        //$total_value1 = number_format($total_value, 0);

        $total_value1 = ($total_value);

        $shredder_replace = $rsdata2['shredder_replace'];

        $service_status = $rsdata2['service_status'];

        $reading = $rsdata2['reading'];

        $spare_used = $rsdata2['spare_used'];

        $service_by = $rsdata2['serviced_by'];

        $service_description = $rsdata2['service_description'];


        //Show once of this four filed in a day

        if ($reading != '') {
            $reading1 = $reading;
        } else {
            $reading1 = '---';
        }
        if ($service_by != '') {
            $service_by1 = $service_by;
        } else {
            $service_by1 = '---';
        }
        if ($service_description != '') {
            $service_description1 = $service_description;
        } else {
            $service_description1 = '---';
        }
        if ($spare_used != '') {
            $spare_used1 = $spare_used;
        } else {
            $spare_used1 = '---';
        }

        if ($shredder_replace == '1') {
            $status = 'Replaced';
        } elseif ($service_status == '1') {
            $status = 'Serviced';
        } else {
            $status = '--';
        }

        //if($k==1){$kms = $km;}else{$kms='---';}
        //SERVICE KM CALCULATION START

        //GET LAST CLOSE VALUE
        $sql_get_max_close = $db->prepare("SELECT close as close , entry_date as close_entry_date from shredder_entry_sub where random_no='$random_no' and random_sc='$random_sc' order by id desc limit 0,1");
        $sql_get_max_close->execute();
        $get_max_close = $sql_get_max_close->fetchAll();
        foreach ($get_max_close as $result_close) {
            $get_close = $result_close['close'];
            $close_entry_date = $result_close['close_entry_date'];
        }

        
        //GET LAST READING VALUE
        //GET READING VALUE -  MORNING SHIFT
        $get_last_reading_value = $db->prepare(("SELECT reading as reading from shredder_entry_sub where site_name='$site_id' and plant_name='$plant_id' and shredder_name='$shredder_name_id' and entry_date < '$close_entry_date' and  reading!='' order by id desc limit 0,1"));

        $get_last_reading_value->execute();
        $get_reading = $get_last_reading_value->fetchAll();


        //GET READING VALUE -  NIGHT SHIFT
        $get_last_reading_value1 = $db->prepare(("SELECT reading as reading from shredder_entry_sub where site_name='$site_id' and plant_name='$plant_id' and shredder_name='$shredder_name_id' and entry_date <= '$close_entry_date' and  reading!='' order by id desc limit 0,1"));

        $get_last_reading_value1->execute();
        $get_reading1 = $get_last_reading_value1->fetchAll();

        // if ($get_reading[0][reading] == "" || $get_reading[0][reading] == null) {
        //     $read = 'null';
        // } else {
        //     $read = $get_reading[0][reading];
        // }


        if ($service_status == 1 || $shredder_replace == 1) {
            $read = $reading;
        } 
        else if(($get_shift_id==2) && ($service_status != 1 && $shredder_replace != 1)){
            if ($get_reading[0][reading] == "" || $get_reading[0][reading] == null) {
                $read = 'null';
            } else {
                $read = $get_reading[0][reading];
            }
        }else{
            if ($get_reading1[0][reading] == "" || $get_reading1[0][reading] == null) {
                $read = 'null';
            } else {
                $read = $get_reading1[0][reading];
            }
        }
        
        //CALCULATION
        if ($read != 'null') {
            $km_val = $close - $read;
            if ($km_val > 0) {
                $km  =  number_format($km_val,2);
                // $km = $km_val;
            } else {
                $km = '-';
            }
        } else {
            $km = "-";
        }
        



        //SERVICE KM CALCULATION END

        foreach ($table_values as $val) {

            if ($val == 's1') {
                $output .= '"' . $sno . '",';
            }

            if ($val == 's2') {
                $output .= '"' . $entry_date1 . '",';
            }

            if ($val == 's3') {
                $output .= '"' . $shredder_no . '",';
            }

            if ($val == 's4') {
                $output .= '"' . $shredder_name . '",';
            }

            if ($val == 's5') {
                $output .= '"' . $site_name . '",';
            }

            if ($val == 's6') {
                $output .= '"' . $plant_name . '",';
            }

            if ($val == 's7') {
                $output .= '"' . $description . '",';
            }

            if ($val == 's8') {
                $output .= '"' . $staff_name . '",';
            }

            if ($val == 's9') {
                $output .= '"' . $type . '",';
            }

            if ($val == 's10') {
                $output .= '"' . $open . '",';
            }

            if ($val == 's11') {
                $output .= '"' . $close . '",';
            }

            if ($val == 's12') {
                $output .= '"' . $total_value1 . '",';
            }

            if ($val == 's13') {
                $output .= '"' . $status . '",';
            }

            if ($val == 's14') {
                $output .= '"' . $reading1 . '",';
            }

            if ($val == 's15') {
                $output .= '"' . $km . '",';
            }

            if ($val == 's16') {
                $output .= '"' . $service_by1 . '",';
            }

            if ($val == 's17') {
                $output .= '"' . $spare_used1 . '",';
            }

            if ($val == 's18') {
                $output .= '"' . $service_description1 . '",';
            }

            if (($val != 's1') && ($val != 's2') && ($val != 's3') && ($val != 's4') && ($val != 's5') && ($val != 's6') && ($val != 's7') && ($val != 's8') && ($val != 's9') && ($val != 's10') && ($val != 's11') && ($val != 's12') && ($val != 's13') && ($val != 's14') && ($val != 's15') && ($val != 's16') && ($val != 's17') && ($val != 's18')) {
                $output .= '"' . $val . '",';
            }
        }

        $output .= "\n";
    }
}

$output .= "\n";

$output .= '" "," "," "," "," "," "," "," ",," "," "," "," "," "," "," ","Printed Date",""' . $curdate = date('d-m-Y') . "\n";

$date = date('d-m-Y H:i:s');

//$filename =  "ShredderEntry" . $date . ".csv";
$filename =  "ShredderEntry" .".csv";

header('Content-type: application/xls');

header('Content-Disposition: attachment; filename=' . $filename);

echo $output;

exit;
