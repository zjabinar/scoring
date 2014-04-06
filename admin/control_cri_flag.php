<?php require_once('../Connections/conn_mutya.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_conn_mutya = new KT_connection($conn_mutya, $database_conn_mutya);

// Start trigger
$formValidation = new tNG_FormValidation();
$tNGs->prepareValidation($formValidation);
// End trigger

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
$query_rec_cri_search = "SELECT * FROM criteria_flag";
$rec_cri_search = mysql_query($query_rec_cri_search, $conn_mutya) or die(mysql_error());
$row_rec_cri_search = mysql_fetch_assoc($rec_cri_search);
$totalRows_rec_cri_search = mysql_num_rows($rec_cri_search);

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_cri_pre = "SELECT criteria_id, criteria_name FROM pre_criteria";
$cri_pre = mysql_query($query_cri_pre, $conn_mutya) or die(mysql_error());
$row_cri_pre = mysql_fetch_assoc($cri_pre);
$totalRows_cri_pre = mysql_num_rows($cri_pre);

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_cri_semi = "SELECT * FROM semi_criteria";
$cri_semi = mysql_query($query_cri_semi, $conn_mutya) or die(mysql_error());
$row_cri_semi = mysql_fetch_assoc($cri_semi);
$totalRows_cri_semi = mysql_num_rows($cri_semi);

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_cri_final = "SELECT criteria_id, criteria_name FROM final_criteria";
$cri_final = mysql_query($query_cri_final, $conn_mutya) or die(mysql_error());
$row_cri_final = mysql_fetch_assoc($cri_final);
$totalRows_cri_final = mysql_num_rows($cri_final);

// Make an update transaction instance
$upd_criteria_flag = new tNG_update($conn_conn_mutya);
$tNGs->addTransaction($upd_criteria_flag);
// Register triggers
$upd_criteria_flag->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_criteria_flag->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_criteria_flag->registerTrigger("END", "Trigger_Default_Redirect", 99, "control_window.php");
// Add columns
$upd_criteria_flag->setTable("criteria_flag");
$upd_criteria_flag->addColumn("used_id", "NUMERIC_TYPE", "POST", "used_id");
$upd_criteria_flag->addColumn("criteria_id", "NUMERIC_TYPE", "POST", "criteria_id");
$upd_criteria_flag->setPrimaryKey("active_id", "NUMERIC_TYPE", "GET", "active_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscriteria_flag = $tNGs->getRecordset("criteria_flag");
$row_rscriteria_flag = mysql_fetch_assoc($rscriteria_flag);
$totalRows_rscriteria_flag = mysql_num_rows($rscriteria_flag);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td class="KT_th"><label for="used_id">Used_id:</label></td>
      <td><input type="text" name="used_id" id="used_id" value="<?php echo KT_escapeAttribute($row_rscriteria_flag['used_id']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("used_id");?> <?php echo $tNGs->displayFieldError("criteria_flag", "used_id"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="criteria_id">Criteria_id:</label></td>
      <td><input type="text" name="criteria_id" id="criteria_id" value="<?php echo KT_escapeAttribute($row_rscriteria_flag['criteria_id']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("criteria_id");?> <?php echo $tNGs->displayFieldError("criteria_flag", "criteria_id"); ?> </td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Update1" id="KT_Update1" value="Update record" />
      </td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rec_cri_search);

mysql_free_result($cri_pre);

mysql_free_result($cri_semi);

mysql_free_result($cri_final);
?>
