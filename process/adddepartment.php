<?php
include("../DLL//config.php");
if(isset($_POST['submit']))
{
$dep_name=$_POST['dep_name'];
$date = date("Y-m-d H:i:s");
$sql = mysql_query("insert into department_mst(dep_name,created_date) values ('$dep_name','$date')");
if($sql)
{
header("Location: ../show_departments.php");
}
}
?>
