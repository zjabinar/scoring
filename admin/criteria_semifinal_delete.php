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

// Make an instance of the transaction object
$del_semi_criteria = new tNG_delete($conn_conn_mutya);
$tNGs->addTransaction($del_semi_criteria);
// Register triggers
$del_semi_criteria->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "criteria_id");
$del_semi_criteria->registerTrigger("END", "Trigger_Default_Redirect", 99, "criteria_semifinal.php");
// Add columns
$del_semi_criteria->setTable("semi_criteria");
$del_semi_criteria->setPrimaryKey("criteria_id", "NUMERIC_TYPE", "GET", "criteria_id");

// Execute all the registered transactions
$tNGs->executeTransactions();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>

</body>
</html>
