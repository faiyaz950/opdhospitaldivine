<?php
include("../DLL/config.php");
if(isset($_POST['submit']))
{
$pat_id=$_POST['pat_id'];
$pa_id = explode('-', $pat_id);
$p_id = hms_uhid_pid($pat_id);
$date = $_POST['dated'];
$dep_id = $_POST['department'];
$remarks = $_POST['remarks'];
$datetime = date("Y-m-d h:m:s");
$sql = mysql_query("insert into appointment_mst(pid,did,remarks,appointment_date,created_date) values ('$p_id','$dep_id','$remarks','$date','$datetime')");
if($sql)
{
header("Location: ../show_appointment.php");
}
}
?>
