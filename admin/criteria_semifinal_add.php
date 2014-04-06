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
$formValidation->addField("criteria_name", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_semi_criteria = new tNG_insert($conn_conn_mutya);
$tNGs->addTransaction($ins_semi_criteria);
// Register triggers
$ins_semi_criteria->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_semi_criteria->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_semi_criteria->registerTrigger("END", "Trigger_Default_Redirect", 99, "criteria_semifinal.php");
// Add columns
$ins_semi_criteria->setTable("semi_criteria");
$ins_semi_criteria->addColumn("criteria_name", "STRING_TYPE", "POST", "criteria_name");
$ins_semi_criteria->addColumn("info", "STRING_TYPE", "POST", "info");
$ins_semi_criteria->setPrimaryKey("criteria_id", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rssemi_criteria = $tNGs->getRecordset("semi_criteria");
$row_rssemi_criteria = mysql_fetch_assoc($rssemi_criteria);
$totalRows_rssemi_criteria = mysql_num_rows($rssemi_criteria);
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
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td class="KT_th"><label for="criteria_name">Criteria_name:</label></td>
      <td><input type="text" name="criteria_name" id="criteria_name" value="<?php echo KT_escapeAttribute($row_rssemi_criteria['criteria_name']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("criteria_name");?> <?php echo $tNGs->displayFieldError("semi_criteria", "criteria_name"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="info">Info:</label></td>
      <td><input type="text" name="info" id="info" value="<?php echo KT_escapeAttribute($row_rssemi_criteria['info']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("info");?> <?php echo $tNGs->displayFieldError("semi_criteria", "info"); ?> </td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Insert record" />
      </td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
