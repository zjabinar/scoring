<?php require_once('../Connections/conn_mutya.php'); ?>
<?php

if ($_REQUEST['btnstatus']) {
	if ($_REQUEST['btnstatus']=="Show") {
		$show = 0;
	}elseif($_REQUEST['btnstatus']=="Hide") {
		$show = 1;
	}
}

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
$query_judges = "SELECT judgeid, firstname, lastname FROM judges";
$judges = mysql_query($query_judges, $conn_mutya) or die(mysql_error());
$row_judges = mysql_fetch_assoc($judges);
$totalRows_judges = mysql_num_rows($judges);

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_contestant = "SELECT contestant_id, municipality FROM contestants";
$contestant = mysql_query($query_contestant, $conn_mutya) or die(mysql_error());
$row_contestant = mysql_fetch_assoc($contestant);
$totalRows_contestant = mysql_num_rows($contestant);

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_final_scores = "SELECT score_id, judge_id, contestant_id, criteria_id, rating FROM final_scores";
$final_scores = mysql_query($query_final_scores, $conn_mutya) or die(mysql_error());
$row_final_scores = mysql_fetch_assoc($final_scores);
$totalRows_final_scores = mysql_num_rows($final_scores);

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_cri_flag = "SELECT active_id, used_id, criteria_id, status_id, active_cons FROM criteria_flag";
$cri_flag = mysql_query($query_cri_flag, $conn_mutya) or die(mysql_error());
$row_cri_flag = mysql_fetch_assoc($cri_flag);
$totalRows_cri_flag = mysql_num_rows($cri_flag);


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
    body{ font-family:'Courier New'; font-family:times; font-size:10pt }
    th{ font-family:'Courier New'; font-size:10pt; font-weight:normal }
    td{ font-family:'Courier New'; font-size:10pt }

    table.contestant{ border-style:solid; border-width:thin; border-color:black; border-collapse:collapse }
    th.contestant{ border-style:solid; border-width:thin; background-color:#d0d0d0 }
    td.contestant{ border-style:solid; border-width:thin; padding-left:0.4mm; padding-right:0.4mm }
	td.judge{ border-top:solid; border-width:thin; padding-left:0.4mm; padding-right:0.4mm}


-->
</style>
</head>

<body>
<table border="0" align="center" width="550">
<tr>
<td align="left" style="font-size:16px">
<?php
mysql_select_db($database_conn_mutya, $conn_mutya);
if ($row_cri_flag['used_id']==1) {
	$query_cri = "SELECT criteria_id, criteria_name FROM semi_criteria where criteria_id=". $row_cri_flag['criteria_id'];
}else{
	$query_cri = "SELECT criteria_id, criteria_name FROM final_criteria where criteria_id=". $row_cri_flag['criteria_id'];
}
	$cri = mysql_query($query_cri, $conn_mutya) or die(mysql_error());
	$row_cri = mysql_fetch_assoc($cri);
	$totalRows_cri = mysql_num_rows($cri);
	echo $row_cri['criteria_name'] . " Competition";
?>
</td>

<td align="right">
<form action="" method="post">
<input type="submit" name="btnstatus" value="<?php if ($show==1){echo "Show";}elseif($show==0){echo "Hide";}else{echo "Show";} ?>" />
<input type="hidden" name="status" value="<?php echo $status; ?>" />
</form>
</td>
</tr>
</table>
<table border="1" align="center" width="550" class="contestant">
  <tr>
    <th align="center" class="contestant">Const #</th>
    <?php do { ?>
      <th align="center" class="contestant"><?php echo $row_judges['lastname']; ?></th>
    <?php } while ($row_judges = mysql_fetch_assoc($judges)); ?>
  </tr>
  <?php do { ?>
    <tr>
      <td class="contestant">&nbsp;&nbsp;<?php echo $row_contestant['contestant_id'] ; ?></td>
      <?php
	  
		mysql_select_db($database_conn_mutya, $conn_mutya);
		$query_judges = "SELECT judgeid, firstname, lastname FROM judges";
		$judges = mysql_query($query_judges, $conn_mutya) or die(mysql_error());
		$row_judges = mysql_fetch_assoc($judges);
		$totalRows_judges = mysql_num_rows($judges);
    	do { 
			if ($row_cri_flag['used_id']==1) {
				mysql_select_db($database_conn_mutya, $conn_mutya);
				$query_scores = "SELECT score_id, judge_id, contestant_id, criteria_id, rating FROM semi_scores where criteria_id=". $row_cri_flag['criteria_id']. " and judge_id=". $row_judges['judgeid'] . " and contestant_id=" . $row_contestant['contestant_id'];
				//echo $query_scores . "<br />";
				$scores = mysql_query($query_scores, $conn_mutya) or die(mysql_error());
				$row_scores = mysql_fetch_assoc($scores);
				$totalRows_scores = mysql_num_rows($scores);
			}else{
				mysql_select_db($database_conn_mutya, $conn_mutya);
				$query_scores = "SELECT score_id, judge_id, contestant_id, criteria_id, rating FROM final_scores where criteria_id=".$row_cri_flag['criteria_id']. " and judge_id=". $row_judges['judgeid'] . " and contestant_id=" . $row_contestant['contestant_id'];
				//echo $query_scores;
				$scores = mysql_query($query_scores, $conn_mutya) or die(mysql_error());
				$row_scores = mysql_fetch_assoc($scores);
				$totalRows_scores = mysql_num_rows($scores);
			}

			do { 
				if ($show==1){
					if ($row_scores['rating']==0) {
						echo '<td align="center" class="contestant">&nbsp;</td>';
					}else{
						echo '<td align="center" class="contestant">' . $row_scores['rating'] . '</td>';
					}
				}elseif ($show==0){
					if ($row_scores['rating']==0) {
						echo '<td align="center" class="contestant">&nbsp;</td>';
					}else{
						echo '<td align="center" class="contestant">Rated</td>';
					}
				}else{
					if ($row_scores['rating']==0) {
						echo '<td align="center" class="contestant">&nbsp;</td>';
					}else{
						echo '<td align="center" class="contestant">' . $row_scores['rating'] . '</td>';
					}
				}
    		} while ($row_scores = mysql_fetch_assoc($scores));
			
    	} while ($row_judges = mysql_fetch_assoc($judges));
	  ?>
      
    </tr>
    <?php } while ($row_contestant = mysql_fetch_assoc($contestant)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($judges);

mysql_free_result($semi_cri);

mysql_free_result($contestant);

mysql_free_result($semi_scores);

mysql_free_result($cri_flag);

mysql_free_result($final_scores);

mysql_free_result($scores);
?>
