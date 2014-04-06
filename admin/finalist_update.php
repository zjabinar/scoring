<?php require_once('../Connections/conn_mutya.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_contestants = "SELECT contestant_id, contestant_num, firstname, lastname FROM contestants";
$contestants = mysql_query($query_contestants, $conn_mutya) or die(mysql_error());
$row_contestants = mysql_fetch_assoc($contestants);
$totalRows_contestants = mysql_num_rows($contestants);

$btn_update = $_REQUEST['btn_update'];
$contestant_id = $_REQUEST['contestant_id'];
//echo "update is - $btn_update <br />";
//echo "contestant is - $contestant_id";

if ($btn_update==1){

	$sql_update="UPDATE contestants set finalist=0 where contestant_id=".$contestant_id;
}else{
	$sql_update="UPDATE contestants set finalist=1 where contestant_id=".$contestant_id;
}
//echo $sql_update;
mysql_query($sql_update);
header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/finalist.php");
exit(0);
?>
<?php
mysql_free_result($contestants);
?>
