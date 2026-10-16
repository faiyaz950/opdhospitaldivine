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

    $rep_id = $_POST['report_id'];
    $ipd_id = isset($_POST['ipd_id']) ? (int)$_POST['ipd_id'] : 0;
    $inv_type = isset($_POST['inv_type']) ? mysql_real_escape_string($_POST['inv_type']) : ($ipd_id > 0 ? 'Indoor' : 'Outdoor');

    // Investigation Date & Time (supports backdate)
    $inv_date = !empty($_POST['investigation_date']) ? $_POST['investigation_date'] : date("Y-m-d");
    $inv_time = !empty($_POST['investigation_time']) ? $_POST['investigation_time'] : date("H:i");
    if (strlen($inv_time) == 5) {
        $inv_time .= ":00";
    }
    $date = $inv_date;
    $time = $inv_time;
    $datetime = $inv_date . " " . $inv_time;

    $sql = mysql_query("insert into investigate_mst(pid, rid, created_date, created_time, created_datetime, refer, inv_type, ipd_id) values ('$p_id', '$rep_id', '$date', '$time', '$datetime', '$refer_id', '$inv_type', '$ipd_id')");
    $inv_id = mysql_insert_id();
    $rate = getInvestigationRate($rep_id);

    // Billing with backdate
    $check = mysql_query("select * from billing_mst where pat_id='$p_id' and create_date='$date'");
    $count = mysql_num_rows($check);
    if($count < 1)
    {
        $last_bill = mysql_query("select * from param_mst where id='3'");
        $rbill = mysql_fetch_array($last_bill);
        $last_bill_no = $rbill['last_value'];
        $bill_no = $last_bill_no + 1;
        $sql1 = mysql_query("insert into billing_mst(bill_id, bill_type, bill_typenumber, pat_id, bill_amount, created_date, create_date) values ('$bill_no', 'Investigation','$inv_id', '$p_id', '$rate', '$datetime', '$date')");
        $now = mysql_query("update param_mst set last_value='$bill_no' where id='3'");
    }
    else
    {
        $check1 = mysql_query("select * from billing_mst where pat_id='$p_id' and create_date='$date'");
        $pr = mysql_fetch_array($check1);
        $bill_no =  $pr['bill_id'];
        $sql1 = mysql_query("insert into billing_mst(bill_id, bill_type, bill_typenumber, pat_id, bill_amount, created_date, create_date) values ('$bill_no', 'Investigation','$inv_id', '$p_id', '$rate', '$datetime', '$date')");
    }

    if($sql1)
    {
        if ($ipd_id > 0) {
            header("Location: ../show_ipd1.php?msg=inv_added");
        } else {
            header("Location: ../show_investigate.php");
        }
        exit;
    }
}
?>
