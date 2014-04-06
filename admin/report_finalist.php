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
$query_cri_count = "SELECT Count(pre_criteria.criteria_id) AS pre_count FROM pre_criteria;";
$cri_count = mysql_query($query_cri_count, $conn_mutya) or die(mysql_error());
$row_cri_count = mysql_fetch_assoc($cri_count);
$totalRows_cri_count = mysql_num_rows($cri_count);

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_semi_count = "SELECT Count(semi_criteria.criteria_id) AS semi_count FROM semi_criteria;";
$semi_count = mysql_query($query_semi_count, $conn_mutya) or die(mysql_error());
$row_semi_count = mysql_fetch_assoc($semi_count);
$totalRows_semi_count = mysql_num_rows($semi_count);

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_final_count = "SELECT Count(final_criteria.criteria_id) AS final_count FROM final_criteria;";
$final_count = mysql_query($query_final_count, $conn_mutya) or die(mysql_error());
$row_final_count = mysql_fetch_assoc($final_count);
$totalRows_final_count = mysql_num_rows($final_count);

$count_criteria = $row_cri_count['pre_count'] + $row_semi_count['semi_count'] + $row_final_count['final_count'];
//echo $count_criteria;


mysql_select_db($database_conn_mutya, $conn_mutya);
$query_contestants = "SELECT contestant_id, contestant_num, firstname, lastname, middlename, birthdate, municipality FROM contestants where finalist=1";
$contestants = mysql_query($query_contestants, $conn_mutya) or die(mysql_error());
$row_contestants = mysql_fetch_assoc($contestants);
$totalRows_contestants = mysql_num_rows($contestants);

do { 
	$contestant_id = $row_contestants['contestant_id']; 
	//echo $contestant_id . "<br /><br />";
	
	mysql_select_db($database_conn_mutya, $conn_mutya);
	$query_pre_scores = "SELECT pre_scores.contestant_id, Sum(pre_scores.rating) AS total_scores FROM pre_scores GROUP BY pre_scores.contestant_id HAVING pre_scores.contestant_id=". $contestant_id;
	$pre_scores = mysql_query($query_pre_scores, $conn_mutya) or die(mysql_error());
	$row_pre_scores = mysql_fetch_assoc($pre_scores);
	//echo $query_pre_scores . "<br /><br />";
	
	mysql_select_db($database_conn_mutya, $conn_mutya);
	$query_semi_scores = "SELECT semi_scores.contestant_id, Sum(semi_scores.rating) AS total_scores FROM semi_scores GROUP BY semi_scores.contestant_id HAVING semi_scores.contestant_id=". $contestant_id;
	$semi_scores = mysql_query($query_semi_scores, $conn_mutya) or die(mysql_error());
	$row_semi_scores = mysql_fetch_assoc($semi_scores);
	$totalRows_semi_scores = mysql_num_rows($semi_scores);
	//echo $query_semi_scores . "<br /><br />";
	
	mysql_select_db($database_conn_mutya, $conn_mutya);
	$query_final_scores = "SELECT final_scores.contestant_id, Sum(final_scores.rating) AS total_scores FROM final_scores GROUP BY final_scores.contestant_id HAVING final_scores.contestant_id=". $contestant_id;
	$final_scores = mysql_query($query_final_scores, $conn_mutya) or die(mysql_error());
	$row_final_scores = mysql_fetch_assoc($final_scores);
	$totalRows_final_scores = mysql_num_rows($final_scores);
	//echo $query_final_scores. "<br /><br />";
	
	//echo $row_pre_scores['total_scores'] . " - " . $row_semi_scores['total_scores'] . " - " . $row_final_scores['total_scores'] . "- " . $count_criteria . " <br />";
	
	$scores = ($row_pre_scores['total_scores'] + $row_semi_scores['total_scores'] + $row_final_scores['total_scores'])/ $count_criteria;
	$id = $row_contestants['contestant_id'];
	$num = $row_contestants['contestant_num'];
	$municipality = $row_contestants['municipality'];
	$name = $row_contestants['lastname'] . ", " . $row_contestants['firstname'] . " " . $row_contestants['middlename'] . ".";
	$sql_ins = "insert into temp_finalist (contestant_id,contestant_num,municipality,name,scores) values (".$id.", ".$num.", '". $municipality . "', '" . $name . "', " . $scores . ")" ;
	//echo $sql_ins . "<br />";
	mysql_query($sql_ins);
} while ($row_contestants = mysql_fetch_assoc($contestants)); 

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_judges = "SELECT judgeid, firstname, lastname FROM judges";
$judges = mysql_query($query_judges, $conn_mutya) or die(mysql_error());
$row_judges = mysql_fetch_assoc($judges);
$totalRows_judges = mysql_num_rows($judges);

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_finalist = "SELECT temp_finalist.contestant_num, temp_finalist.municipality, temp_finalist.name, temp_finalist.scores FROM temp_finalist ORDER BY temp_finalist.scores DESC limit 0,3;";
$finalist = mysql_query($query_finalist, $conn_mutya) or die(mysql_error());
$row_finalist = mysql_fetch_assoc($finalist);
$totalRows_finalist = mysql_num_rows($finalist);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
  <tr><td align="center"><h1><?php echo "Semi Finalist"; ?></h1></td>
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
      <td align="center" class="contestant"><?php echo $row_finalist['contestant_num']; ?></td>
      <td class="contestant">&nbsp;&nbsp;&nbsp;<?php echo $row_finalist['municipality']; ?></td>
      <td class="contestant">&nbsp;&nbsp;&nbsp;<?php echo $row_finalist['name']; ?></td>
      <td align="center" class="contestant"><?php echo number_format($row_finalist['scores'],2); ?></td>
    </tr>
    <?php } while ($row_finalist = mysql_fetch_assoc($finalist)); ?>
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

$sql_delete = "delete from temp_finalist" ;
mysql_query($sql_delete);

mysql_free_result($pre_scores);

mysql_free_result($semi_scores);

mysql_free_result($contestants);

mysql_free_result($finalist);

mysql_free_result($cri_count);

mysql_free_result($semi_count);
?>
