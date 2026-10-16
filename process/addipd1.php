<?php
include("../DLL/config.php");
include("../functions.php");

if(isset($_POST['submit']))
{
    $pat_id = $_POST['pat_id'];
    $p_id = hms_uhid_pid($pat_id);

    // Doctor details
    $sq = mysql_query("select * from patient_mst where id = '$p_id'");
    $pq = mysql_fetch_array($sq);
    $refer_id = !empty($_POST['refer']) ? (int)$_POST['refer'] : (int)$pq['refer'];

    $rep_id = $_POST['department'];

    // Admission Date & Time (supports backdate)
    $admission_date = !empty($_POST['admission_date']) ? $_POST['admission_date'] : date("Y-m-d");
    $admission_time = !empty($_POST['admission_time']) ? $_POST['admission_time'] : date("H:i");
    if (strlen($admission_time) == 5) {
        $admission_time .= ":00";
    }
    $date = $admission_date;
    $datetime = $admission_date . " " . $admission_time;

    // Discharge Details (if entered during admission)
    $is_discharged = isset($_POST['is_discharged']) && $_POST['is_discharged'] == '1';
    $discharge_date = !empty($_POST['discharge_date']) ? $_POST['discharge_date'] : null;
    $discharge_time = !empty($_POST['discharge_time']) ? $_POST['discharge_time'] : null;
    if ($discharge_time && strlen($discharge_time) == 5) {
        $discharge_time .= ":00";
    }
    
    $discharge_status = ($is_discharged || $discharge_date) ? 1 : 0;
    $discharge_datetime = ($discharge_status && $discharge_date) ? ($discharge_date . " " . ($discharge_time ?: "00:00:00")) : null;
    $discharge_condition = isset($_POST['discharge_condition']) ? mysql_real_escape_string($_POST['discharge_condition']) : '';
    $discharge_summary = isset($_POST['discharge_summary']) ? mysql_real_escape_string($_POST['discharge_summary']) : '';
    $final_diagnosis = isset($_POST['final_diagnosis']) ? mysql_real_escape_string($_POST['final_diagnosis']) : '';

    $dis_date_sql = ($discharge_status && $discharge_date) ? "'$discharge_date'" : "NULL";
    $dis_time_sql = ($discharge_status && $discharge_time) ? "'$discharge_time'" : "NULL";
    $dis_dt_sql   = ($discharge_status && $discharge_datetime) ? "'$discharge_datetime'" : "NULL";

    $sql = mysql_query("insert into patipd_mst(pid, rid, created_date, created_datetime, refer, discharge_status, discharge_date, discharge_time, discharge_datetime, discharge_condition, discharge_summary, final_diagnosis) values ('$p_id', '$rep_id', '$date', '$datetime', '$refer_id', '$discharge_status', $dis_date_sql, $dis_time_sql, $dis_dt_sql, '$discharge_condition', '$discharge_summary', '$final_diagnosis')");
    $ipd_id = mysql_insert_id();
    $rate = getIPDRate($rep_id);

    // Billing with backdate
    $check = mysql_query("select * from billing_mst where pat_id='$p_id' and create_date='$date'");
    $count = mysql_num_rows($check);
    if($count < 1)
    {
        $last_bill = mysql_query("select * from param_mst where id='3'");
        $rbill = mysql_fetch_array($last_bill);
        $last_bill_no = $rbill['last_value'];
        $bill_no = $last_bill_no + 1;
        $sql1 = mysql_query("insert into billing_mst(bill_id, bill_type, bill_typenumber, pat_id, bill_amount, created_date, create_date) values ('$bill_no', 'IPD','$ipd_id','$p_id', '$rate', '$datetime', '$date')");
        $now = mysql_query("update param_mst set last_value='$bill_no' where id='3'");
    }
    else
    {
        $check1 = mysql_query("select * from billing_mst where pat_id='$p_id' and create_date='$date'");
        $pr = mysql_fetch_array($check1);
        $bill_no =  $pr['bill_id'];
        $sql1 = mysql_query("insert into billing_mst(bill_id, bill_type, bill_typenumber, pat_id, bill_amount, created_date, create_date) values ('$bill_no', 'IPD','$ipd_id','$p_id', '$rate', '$datetime', '$date')");
    }

    if($sql1)
    {
        header("Location: ../show_ipd1.php");
        exit;
    }
}
?>
