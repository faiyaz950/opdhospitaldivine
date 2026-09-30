<?php
include("../DLL//config.php");
if(isset($_POST['submit']))
{
$pat_name=$_POST['pat_name'];
$fat_name=$_POST['fat_name'];
$sex = $_POST['gender'];
$address = $_POST['address'];
$mobile_no = $_POST['mobile_no'];
$age = $_POST['age'];
$agemonths = $_POST['agemonths'];
$refer = $_POST['refer'];
$date = date("Y-m-d h:m:s");
$time = date("H:i:s", time());
$sql = mysql_query("insert into patient_mst(pat_name,fat_name,sex,address,mobile_no,age,agemonths,refer,created_date,created_time,updated_date) values ('$pat_name','$fat_name','$sex','$address','$mobile_no','$age', '$agemonths',  '$refer', '$date','$time','$date')");
if($sql)
{
header("Location: ../show_patients.php");
}
}
?>
