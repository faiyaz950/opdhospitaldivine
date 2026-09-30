<?php
include("../DLL//config.php");
if(isset($_POST['submit']))
{
$doc_name=$_POST['doc_name'];
$sex = $_POST['gender'];
$address = $_POST['address'];
$city = $_POST['city'];
$mobile_no = $_POST['mobile_no'];
$age = $_POST['age'];
$date = date("Y-m-d h:m:s");
$time = date("H:i:s", time());
$sql = mysql_query("insert into doctor_mst(doc_name,sex,address,city,mobile_no,age,created_date,updated_date) values ('$doc_name','$sex','$address','$city','$mobile_no','$age', '$date','$date')");
if($sql)
{
header("Location: ../show_doctors.php");
}
}
?>
