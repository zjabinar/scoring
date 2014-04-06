<?php require_once('../Connections/conn_mutya.php'); ?>
<?php
if ($_POST["btncancel"]){
	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'])
	. "/criteria_final.php" );
	exit(0);
}
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
$formValidation->addField("criteria_name", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an update transaction instance
$upd_final_criteria = new tNG_update($conn_conn_mutya);
$tNGs->addTransaction($upd_final_criteria);
// Register triggers
$upd_final_criteria->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_final_criteria->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_final_criteria->registerTrigger("END", "Trigger_Default_Redirect", 99, "criteria_final.php");
// Add columns
$upd_final_criteria->setTable("final_criteria");
$upd_final_criteria->addColumn("criteria_name", "STRING_TYPE", "POST", "criteria_name");
$upd_final_criteria->addColumn("info", "STRING_TYPE", "POST", "info");
$upd_final_criteria->setPrimaryKey("criteria_id", "NUMERIC_TYPE", "GET", "criteria_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsfinal_criteria = $tNGs->getRecordset("final_criteria");
$row_rsfinal_criteria = mysql_fetch_assoc($rsfinal_criteria);
$totalRows_rsfinal_criteria = mysql_num_rows($rsfinal_criteria);
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

<body><div class="KT_tnglist">
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td class="KT_th"><label for="criteria_name">Criteria_name:</label></td>
      <td><input type="text" name="criteria_name" id="criteria_name" value="<?php echo KT_escapeAttribute($row_rsfinal_criteria['criteria_name']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("criteria_name");?> <?php echo $tNGs->displayFieldError("final_criteria", "criteria_name"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="info">Info:</label></td>
      <td><input type="text" name="info" id="info" value="<?php echo KT_escapeAttribute($row_rsfinal_criteria['info']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("info");?> <?php echo $tNGs->displayFieldError("final_criteria", "info"); ?> </td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="btncancel" value="Cancel" />
      <input type="submit" name="KT_Update1" id="KT_Update1" value="Update record" />
      </td>
    </tr>
  </table>
</form>
<p>&nbsp;</p></div>
</body>
</html>
