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

// Make an update transaction instance
$upd_pre_scores = new tNG_update($conn_conn_mutya);
$tNGs->addTransaction($upd_pre_scores);
// Register triggers
$upd_pre_scores->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_pre_scores->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_pre_scores->registerTrigger("END", "Trigger_Default_Redirect", 99, "preliminary_edit.php?&contestant_id=".$_REQUEST['contestant_id']);
// Add columns
$upd_pre_scores->setTable("pre_scores");
$upd_pre_scores->addColumn("rating", "NUMERIC_TYPE", "POST", "rating");
$upd_pre_scores->setPrimaryKey("score_id", "NUMERIC_TYPE", "GET", "score_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rspre_scores = $tNGs->getRecordset("pre_scores");
$row_rspre_scores = mysql_fetch_assoc($rspre_scores);
$totalRows_rspre_scores = mysql_num_rows($rspre_scores);
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
      <td class="KT_th"><label for="rating">Rating:</label></td>
      <td><input type="text" name="rating" id="rating" value="<?php echo KT_escapeAttribute($row_rspre_scores['rating']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("rating");?> <?php echo $tNGs->displayFieldError("pre_scores", "rating"); ?> </td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Update1" id="KT_Update1" value="Update Score" />
      </td>
    </tr>
  </table>
</form>

</body>
</html>
