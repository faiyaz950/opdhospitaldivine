<?php
include("../DLL/config.php");
if(isset($_POST['submit']))
{
$id = $_REQUEST['c'];
$pat_name=$_POST['pat_name'];
$fat_name=$_POST['fat_name'];
$sex = $_POST['gender'];
$address = $_POST['address'];
$mobile_no = $_POST['mobile_no'];
$age = $_POST['age'];
$agemonths = $_POST['agemonths'];
$remarks = $_POST['remarks'];
$refer = $_POST['refer'];
$pmjay = isset($_POST['pmjay']) ? $_POST['pmjay'] : '';
if ($pmjay != 'Yes' && $pmjay != 'No') {
header("Location: ../edit-patient.php?id=$id");die;
}
$date = date("Y-m-d h:m:s");
$sql = mysql_query("update patient_mst set pat_name='$pat_name', fat_name='$fat_name', sex='$sex', address='$address', mobile_no='$mobile_no', age='$age', agemonths='$agemonths', remarks='$remarks', refer='$refer', pmjay='$pmjay', updated_date='$date' where id='$id'");
if($sql)
{
header("Location: ../show_patients.php");
}
}
?>
