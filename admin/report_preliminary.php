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
//echo $_REQUEST['criteria_id'];
mysql_select_db($database_conn_mutya, $conn_mutya);
$query_pre_scores = "SELECT contestants.contestant_num, contestants.firstname, contestants.lastname, contestants.municipality, pre_scores.rating FROM (pre_scores LEFT JOIN pre_criteria ON pre_scores.criteria_id = pre_criteria.criteria_id) LEFT JOIN contestants ON pre_scores.contestant_id = contestants.contestant_id WHERE pre_criteria.criteria_id=". $_REQUEST['criteria_id'] . "  ORDER BY pre_scores.rating DESC;";
$pre_scores = mysql_query($query_pre_scores, $conn_mutya) or die(mysql_error());
$row_pre_scores = mysql_fetch_assoc($pre_scores);
$totalRows_pre_scores = mysql_num_rows($pre_scores);

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_pre_criteria = "SELECT criteria_id, criteria_name FROM pre_criteria where criteria_id=".$_REQUEST['criteria_id'];
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
<title>Miss Manaragat 2012</title>
<style type="text/css">
<!--
.style2 {font-size: 24px}
-->
</style>
<style type="text/css">
<!--
    body{ font-family:'Courier New'; font-family:times; font-size:9pt }
    th{ font-family:'Courier New'; font-size:9pt; font-weight:normal }
    td{ font-family:'Courier New'; font-size:9pt }

    table.contestant{ border-style:solid; border-width:thin; border-color:black; border-collapse:collapse }
    th.contestant{ border-style:solid; border-width:thin; background-color:#d0d0d0 }
    td.contestant{ border-style:solid; border-width:thin; padding-left:0.4mm; padding-right:0.4mm }
	td.judge{ border-top:solid; border-width:thin; padding-left:0.4mm; padding-right:0.4mm}


-->
</style>
</head>
<body>
<table border="0" align="center">
	<tr><td align="center">Republic of the Philippines</td></tr>
    <tr><td align="center">Province of Samar</td></tr>
    <tr><td align="center">Miss Manaragat 2012</td></tr>
    <tr><td>&nbsp;<br /></td></tr>
  <tr><td align="center"><h1><?php echo $row_pre_criteria['criteria_name'] . " Competition"; ?></h1></td>
  </tr>
</table>
<br />
<table border="1" align="center" width="800" class="contestant">
  <tr>
    <th width="100" align="center" class="contestant">Contestant #</th>
    <th width="180" class="contestant">Municipality</th>
    <th class="contestant">Contestant</th>
    <th align="center" class="contestant">Rating</th>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" class="contestant"><?php echo $row_pre_scores['contestant_num']; ?></td>
      <td class="contestant"><?php echo $row_pre_scores['municipality']; ?></td>
      <td class="contestant"><?php echo $row_pre_scores['lastname'] . ", " . $row_pre_scores['firstname']; ?></td>
      <td align="center" class="contestant"><?php echo number_format($row_pre_scores['rating'],2); ?></td>
    </tr>
    <?php } while ($row_pre_scores = mysql_fetch_assoc($pre_scores)); ?>
</table>

<br /><br /><br />
<table width="950" border="0" align="center">
  <tr>
  <?php do { ?>
      <td align="center"><?php echo $row_judges['lastname'] . ", " . $row_judges['firstname'] . " " . $row_judges['middlename']; ?></td>
    <?php } while ($row_judges = mysql_fetch_assoc($judges)); ?>
  </tr>
  <tr>
    <td align="center" class="judge">Judge</td>
    <td align="center" class="judge">Judge</td>
    <td align="center" class="judge">Judge</td>
    <td align="center" class="judge">Judge</td>
    <td align="center" class="judge">Judge</td>
    <td align="center" class="judge">Judge</td>
    <td align="center" class="judge">Judge</td>
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
