<?php
include("../DLL//config.php");
if(isset($_POST['submit']))
{
$email=$_POST['email'];
$password=$_POST['password'];
$sql = mysql_query("insert into admin(email, password) values ('$email','$password')");
if($sql)
{
header("Location: ../show_admin.php");
}
}
?>
