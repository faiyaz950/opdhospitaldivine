<?php
include("config.php");
function getPatientName($i)
{
$sql = mysql_query("select * from patient_mst where id='$i'");
$r = mysql_fetch_array($sql);
$name = $r['pat_name'];
return $name;
}
function getReferDocName($i)
{
$sql = mysql_query("select * from doctor_mst where id='$i'");
$r = mysql_fetch_array($sql);
$name = $r['doc_name'];
return $name;
}
function getExpenseName($i)
{
$sql = mysql_query("select * from expense_heads where id='$i'");
$r = mysql_fetch_array($sql);
$name = $r['exptype_name'];
return $name;
}
function getIncomeName($i)
{
$sql = mysql_query("select * from income_heads where id='$i'");
$r = mysql_fetch_array($sql);
$name = $r['incometype_name'];
return $name;
}
?>