<?php require_once('../Connections/conn_mutya.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');
if ($_POST["btncancel"]){
	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'])
	. "/admin.php" );
	exit(0);
}
$curr_admin_id=$_REQUEST['admin_id'];
// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_conn_mutya = new KT_connection($conn_mutya, $database_conn_mutya);

//start Trigger_CheckPasswords trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckPasswords(&$tNG) {
  $myThrowError = new tNG_ThrowError($tNG);
  $myThrowError->setErrorMsg("Passwords do not match.");
  $myThrowError->setField("password");
  $myThrowError->setFieldErrorMsg("The two passwords do not match.");
  return $myThrowError->Execute();
}
//end Trigger_CheckPasswords trigger

//start Trigger_CheckPasswords1 trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckPasswords1(&$tNG) {
  $myThrowError = new tNG_ThrowError($tNG);
  $myThrowError->setErrorMsg("Passwords do not match.");
  $myThrowError->setField("password");
  $myThrowError->setFieldErrorMsg("The two passwords do not match.");
  return $myThrowError->Execute();
}
//end Trigger_CheckPasswords1 trigger

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("username", true, "text", "", "", "", "");
$formValidation->addField("password", true, "text", "", "6", "15", "");
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
$query_rec_admin = "SELECT username, password FROM `admin`";
$rec_admin = mysql_query($query_rec_admin, $conn_mutya) or die(mysql_error());
$row_rec_admin = mysql_fetch_assoc($rec_admin);
$totalRows_rec_admin = mysql_num_rows($rec_admin);

// Make an update transaction instance
$upd__admin_ = new tNG_update($conn_conn_mutya);
$tNGs->addTransaction($upd__admin_);
// Register triggers
$upd__admin_->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd__admin_->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd__admin_->registerTrigger("END", "Trigger_Default_Redirect", 99, "admin.php?admin_id=".$curr_admin_id);
$upd__admin_->registerConditionalTrigger("{POST.password} != {POST.re_password}", "BEFORE", "Trigger_CheckPasswords1", 50);
// Add columns
$upd__admin_->setTable("`admin`");
$upd__admin_->addColumn("username", "STRING_TYPE", "POST", "username");
$upd__admin_->addColumn("password", "STRING_TYPE", "POST", "password");
$upd__admin_->setPrimaryKey("admin_id", "NUMERIC_TYPE", "GET", "admin_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rs_admin_ = $tNGs->getRecordset("`admin`");
$row_rs_admin_ = mysql_fetch_assoc($rs_admin_);
$totalRows_rs_admin_ = mysql_num_rows($rs_admin_);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Miss Manaragat 2012</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/interface.js"></script>

<!--[if lt IE 7]>
 <style type="text/css">
 div, img { behavior: url(iepngfix.htc) }
 </style>
<![endif]-->

<link href="style.css" rel="stylesheet" type="text/css" /><link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" /><script src="../includes/common/js/base.js" type="text/javascript"></script><script src="../includes/common/js/utility.js" type="text/javascript"></script><script src="../includes/skins/style.js" type="text/javascript"></script><?php echo $tNGs->displayValidationRules();?>
</head>
<body>
<div class="dock" id="dock">
  <div class="dock-container">
  <a class="dock-item" href="control_window.php?admin_id=<?php echo $curr_admin_id; ?>"><img src="images/control.png" alt="Controls" /><span>Controls</span></a> 
  <a class="dock-item" href="contestant.php?admin_id=<?php echo $curr_admin_id; ?>"><img src="images/contestant.png" alt="contestant" /><span>Contestant</span></a>  
  <a class="dock-item" href="admin.php?admin_id=<?php echo $curr_admin_id; ?>"><img src="images/user.png" alt="Administrator" /><span>Administrator</span></a> 
  <a class="dock-item" href="judges.php?admin_id=<?php echo $curr_admin_id; ?>"><img src="images/judge.png" alt="judges" /><span>Judges</span></a>   
  <a class="dock-item" href="criteria_main.php?admin_id=<?php echo $curr_admin_id; ?>"><img src="images/criteria.png" alt="criteria" /><span>Criteria</span></a>  

  <a class="dock-item" href="index.php"><img src="images/logout.png" alt="logout" /><span>Logout</span></a></div>
</div>
<script type="text/javascript">
	
	$(document).ready(
		function()
		{
			$('#dock').Fisheye(
				{
					maxWidth: 50,
					items: 'a',
					itemsText: 'span',
					container: '.dock-container',
					itemWidth: 40,
					proximity: 90,
					halign : 'center'
				}
			)
		}
	);

</script>
<br /><br /><br />
<table width="200" border="0" align="center">
  <tr>
    <td><center>&nbsp;</center></td>
  </tr>
</table>
<table width="300" border="0" align="center">
  <tr>
    <td><div class="KT_tnglist">
<?php
	echo $tNGs->getErrorMsg();
?>
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td class="KT_th"><label for="username">Username:</label></td>
      <td><input type="text" name="username" id="username" value="<?php echo KT_escapeAttribute($row_rs_admin_['username']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("username");?> <?php echo $tNGs->displayFieldError("`admin`", "username"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="password">Password:</label></td>
      <td><input type="password" name="password" id="password" value="" size="32" />
          <?php echo $tNGs->displayFieldHint("password");?> <?php echo $tNGs->displayFieldError("`admin`", "password"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="re_password">Re-type Password:</label></td>
      <td><input type="password" name="re_password" id="re_password" value="" size="32" />
      </td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="btncancel" value="Cancel" />
      <input type="submit" name="KT_Update1" id="KT_Update1" value="Update record" />
      </td>
    </tr>
  </table>
</form>
</div>
</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rec_admin);
?>
