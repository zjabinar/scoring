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
$query_final_score = "SELECT contestants.contestant_id, contestants.contestant_num, contestants.firstname, contestants.lastname, contestants.municipality, (Sum(final_scores.rating)/5 ) AS total_rating, final_scores.criteria_id, Count(final_scores.criteria_id) AS count_criteria_id FROM final_criteria RIGHT JOIN (contestants RIGHT JOIN final_scores ON contestants.contestant_id = final_scores.contestant_id) ON final_criteria.criteria_id = final_scores.criteria_id GROUP BY contestants.contestant_id, contestants.contestant_num, contestants.firstname, contestants.lastname, contestants.municipality, final_scores.criteria_id HAVING final_scores.criteria_id=". $_REQUEST['criteria_id'] . " ORDER BY Sum(final_scores.rating) DESC;";
$final_score = mysql_query($query_final_score, $conn_mutya) or die(mysql_error());
$row_final_score = mysql_fetch_assoc($final_score);
$totalRows_final_score = mysql_num_rows($final_score);

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_final_criteria = "SELECT criteria_id, criteria_name FROM final_criteria where criteria_id=".$_REQUEST['criteria_id'];
$final_criteria = mysql_query($query_final_criteria, $conn_mutya) or die(mysql_error());
$row_final_criteria = mysql_fetch_assoc($final_criteria);
$totalRows_final_criteria = mysql_num_rows($final_criteria);

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
.style2 {font-size: 18px}
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
  <tr><td align="center"><h1><?php echo $row_final_criteria['criteria_name'] . " Competition"; ?></h1></td>
  </tr>
</table>
<br />
<table border="0" width="800" align="center" class="contestant">
  <tr>
    <th align="center" width="100" class="contestant">Contestant #</th>
    <th align="center" class="contestant">Municipality</th>
    <th align="center" class="contestant">Name</th>
    <th align="center" class="contestant">Score</th>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" class="contestant"><?php echo $row_final_score['contestant_num']; ?></td>
      <td class="contestant">&nbsp;&nbsp;&nbsp;<?php echo $row_final_score['municipality']; ?></td>
      <td class="contestant">&nbsp;&nbsp;&nbsp;<?php echo $row_final_score['lastname'] . ",  " . $row_final_score['firstname']; ?></td>
      <td align="center" class="contestant"><?php echo number_format($row_final_score['total_rating'],2); ?></td>
    </tr>
    <?php } while ($row_final_score = mysql_fetch_assoc($final_score)); ?>
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



</body>

</html>
<?php
mysql_free_result($final_score);
mysql_free_result($final_criteria);
mysql_free_result($judges);
?>
