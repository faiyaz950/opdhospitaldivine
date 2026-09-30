<?php
include("../DLL/config.php");
if(isset($_POST['submit']))
{
$income_type=$_POST['income_type'];
$amount=$_POST['amount'];
$date = $_POST['date1'];
$sql = mysql_query("insert into income_mst(incometype,amount,created_date) values ('$income_type','$amount','$date')");
if($sql)
{
header("Location: ../show_incomes.php");
}
}
?>
