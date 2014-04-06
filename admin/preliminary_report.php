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
$query_pre_scores = "SELECT contestants.contestant_num, contestants.firstname, contestants.lastname, contestants.municipality, pre_scores.rating FROM (pre_scores LEFT JOIN pre_criteria ON pre_scores.criteria_id = pre_criteria.criteria_id) LEFT JOIN contestants ON pre_scores.contestant_id = contestants.contestant_id WHERE pre_criteria.criteria_id=". $_REQUEST['criteria_id'] . "  ORDER BY pre_scores.rating DESC;";
$pre_scores = mysql_query($query_pre_scores, $conn_mutya) or die(mysql_error());
$row_pre_scores = mysql_fetch_assoc($pre_scores);
$totalRows_pre_scores = mysql_num_rows($pre_scores);

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_pre_criteria = "SELECT criteria_id, criteria_name FROM pre_criteria";
$pre_criteria = mysql_query($query_pre_criteria, $conn_mutya) or die(mysql_error());
$row_pre_criteria = mysql_fetch_assoc($pre_criteria);
$totalRows_pre_criteria = mysql_num_rows($pre_criteria);

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_judges = "SELECT judgeid, firstname, lastname FROM judges";
$judges = mysql_query($query_judges, $conn_mutya) or die(mysql_error());
$row_judges = mysql_fetch_assoc($judges);
$totalRows_judges = mysql_num_rows($judges);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style2 {font-size: 24px}
-->
</style>
</head>
<body>
<table border="1" align="center">
    <tr><td align="center">Miss Manaragat 2012</td></tr>
    <tr><td>&nbsp;<br /></td></tr>
  <tr><td align="center"><span class="style2"><?php echo $row_pre_criteria['criteria_name'] . " Competition"; ?></span></td>
  </tr>
</table>
<br />
<table border="1" align="center" width="800">
  <tr>
    <td width="100" align="center">Contestant #</td>
    <td width="180">Municipality</td>
    <td>Contestant</td>
    <td align="center">Rating</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center"><?php echo $row_pre_scores['contestant_num']; ?></td>
      <td><?php echo $row_pre_scores['municipality']; ?></td>
      <td><?php echo $row_pre_scores['lastname'] . ", " . $row_pre_scores['firstname']; ?></td>
      <td align="center"><?php echo $row_pre_scores['rating']; ?></td>
    </tr>
    <?php } while ($row_pre_scores = mysql_fetch_assoc($pre_scores)); ?>
</table>

<br /><br />
<table width="950" border="1" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <?php do { ?>
      <td align="center"><?php echo $row_judges['lastname'] . ", " . $row_judges['firstname'] . " " . $row_judges['middlename']; ?></td>
    <?php } while ($row_judges = mysql_fetch_assoc($judges)); ?>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($pre_scores);

mysql_free_result($pre_criteria);

mysql_free_result($judges);
?>
