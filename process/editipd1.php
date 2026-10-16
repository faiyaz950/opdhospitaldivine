<?php
include("../DLL/config.php");
include("../functions.php");

if(isset($_POST['submit']))
{
    $ipd_id = (int)$_POST['ipd_id'];
    $refer_id = (int)$_POST['refer'];
    $rep_id = (int)$_POST['department'];

    $admission_date = !empty($_POST['admission_date']) ? $_POST['admission_date'] : date("Y-m-d");
    $admission_time = !empty($_POST['admission_time']) ? $_POST['admission_time'] : date("H:i");
    if (strlen($admission_time) == 5) {
        $admission_time .= ":00";
    }
    $created_date = $admission_date;
    $created_datetime = $admission_date . " " . $admission_time;

    $discharge_status = (int)$_POST['discharge_status'];

    if ($discharge_status == 1) {
        $discharge_date = !empty($_POST['discharge_date']) ? $_POST['discharge_date'] : date("Y-m-d");
        $discharge_time = !empty($_POST['discharge_time']) ? $_POST['discharge_time'] : date("H:i");
        if (strlen($discharge_time) == 5) {
            $discharge_time .= ":00";
        }
        $discharge_datetime = $discharge_date . " " . $discharge_time;
        $discharge_condition = isset($_POST['discharge_condition']) ? mysql_real_escape_string($_POST['discharge_condition']) : '';
        $discharge_summary   = isset($_POST['discharge_summary']) ? mysql_real_escape_string($_POST['discharge_summary']) : '';
        $final_diagnosis     = isset($_POST['final_diagnosis']) ? mysql_real_escape_string($_POST['final_diagnosis']) : '';

        $sql = mysql_query("UPDATE `patipd_mst` SET 
            `refer` = '$refer_id',
            `rid` = '$rep_id',
            `created_date` = '$created_date',
            `created_datetime` = '$created_datetime',
            `discharge_status` = 1,
            `discharge_date` = '$discharge_date',
            `discharge_time` = '$discharge_time',
            `discharge_datetime` = '$discharge_datetime',
            `discharge_condition` = '$discharge_condition',
            `discharge_summary` = '$discharge_summary',
            `final_diagnosis` = '$final_diagnosis'
            WHERE `id` = '$ipd_id'");
    } else {
        $sql = mysql_query("UPDATE `patipd_mst` SET 
            `refer` = '$refer_id',
            `rid` = '$rep_id',
            `created_date` = '$created_date',
            `created_datetime` = '$created_datetime',
            `discharge_status` = 0,
            `discharge_date` = NULL,
            `discharge_time` = NULL,
            `discharge_datetime` = NULL
            WHERE `id` = '$ipd_id'");
    }

    // Update billing rate/date if needed
    $rate = getIPDRate($rep_id);
    mysql_query("UPDATE `billing_mst` SET 
        `bill_amount` = '$rate',
        `created_date` = '$created_datetime',
        `create_date` = '$created_date'
        WHERE `bill_type` = 'IPD' AND `bill_typenumber` = '$ipd_id'");

    if($sql)
    {
        header("Location: ../edit-ipd1.php?id=" . $ipd_id . "&msg=updated");
        exit;
    }
}
?>
