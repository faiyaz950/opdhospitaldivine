<?php
include("../DLL/config.php");

if(isset($_POST['submit']))
{
    $ipd_id = (int)$_POST['ipd_id'];
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

        $query = mysql_query("UPDATE `patipd_mst` SET 
            `discharge_status` = 1,
            `discharge_date` = '$discharge_date',
            `discharge_time` = '$discharge_time',
            `discharge_datetime` = '$discharge_datetime',
            `discharge_condition` = '$discharge_condition',
            `discharge_summary` = '$discharge_summary',
            `final_diagnosis` = '$final_diagnosis'
            WHERE `id` = '$ipd_id'");
    } else {
        // Cancel discharge (re-admit)
        $query = mysql_query("UPDATE `patipd_mst` SET 
            `discharge_status` = 0,
            `discharge_date` = NULL,
            `discharge_time` = NULL,
            `discharge_datetime` = NULL
            WHERE `id` = '$ipd_id'");
    }

    if ($query) {
        header("Location: ../discharge-patient.php?id=" . $ipd_id . "&msg=saved");
        exit;
    } else {
        header("Location: ../show_ipd1.php?error=failed");
        exit;
    }
}
?>
