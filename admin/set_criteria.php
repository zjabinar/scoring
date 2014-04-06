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
$query_rec_cri_flag = "SELECT used_id, criteria_id FROM criteria_flag";
$rec_cri_flag = mysql_query($query_rec_cri_flag, $conn_mutya) or die(mysql_error());
$row_rec_cri_flag = mysql_fetch_assoc($rec_cri_flag);
$totalRows_rec_cri_flag = mysql_num_rows($rec_cri_flag);

if ($row_rec_cri_flag['used_id']==1){ //semi final
	$cri_table = "semi_criteria";
	$cri_label = "Semi Finals";
	$cri_id = $row_rec_cri_flag['criteria_id'];
}elseif ( $row_rec_cri_flag['used_id']==2){ //finals
	$cri_table = "final_criteria";
	$cri_label = "Finals";
	$cri_id = $row_rec_cri_flag['criteria_id'];
}
mysql_select_db($database_conn_mutya, $conn_mutya);
$query_criteria = "SELECT criteria_id, criteria_name FROM " . $cri_table . " where criteria_id=" . $cri_id;
$criteria = mysql_query($query_criteria, $conn_mutya) or die(mysql_error());
$row_criteria = mysql_fetch_assoc($criteria);
$totalRows_criteria = mysql_num_rows($criteria);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css" media="screen">
<!--
@import url("p7tp/p7tp_07.css");
-->
</style>
<script type="text/javascript" src="p7tp/p7tpscripts.js"></script>
</head>

<body onload="P7_initTP(7,0)">
<div id="p7TP1" class="p7TPpanel">
	
  <div class="p7TPwrapper">
    <div class="p7TP_tabs">
      <div id="p7tpb1_1" class="down"><a class="down" href="javascript:;">Semi - Final Criteria</a></div>
      <div id="p7tpb1_2"><a href="javascript:;">Final Criteria</a></div>
      <br class="p7TPclear" />
    </div>
    <div class="p7TPcontent">
      <div id="p7tpc1_1">
        <iframe scrolling="no" width="400" height="240" frameborder="0" src="set_criteria_sub_semi.php"></iframe>
      </div>
      <div id="p7tpc1_2">
        <iframe scrolling="no" width="400" height="240" frameborder="0" src="set_criteria_sub_final.php"></iframe>
      </div>
    </div>
  </div>
  <!--[if lte IE 6]>
<style type="text/css">.p7TPpanel div,.p7TPpanel a{height:1%;}.p7TP_tabs a{white-space:nowrap;}</style>
<![endif]-->
</div>
</body>
</html>
<?php
mysql_free_result($rec_cri_flag);

mysql_free_result($criteria);
?>
