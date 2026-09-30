<?php
session_start();
if(!(isset($_SESSION["user_login"])))
{
	$_SESSION["error_msg"]="Please Login";
	header("Location: index.php");die;
}
   $date = $_REQUEST['statusdate'];
//connect to the database
    include_once ('DLL/config.php'); 
    $query = mysql_query("update investigate_mst set seen='1' where created_date='$date'");
	if($query)
	{
	header("location: show_investigate.php");
	}	

?>
