<?php
include("../DLL//config.php");
if(isset($_POST['submit']))
{
$incometype_name=$_POST['incometype_name'];
$sql = mysql_query("insert into income_heads(incometype_name) values ('$incometype_name')");
if($sql)
{
header("Location: ../show_incometype.php");
}
}
?>
