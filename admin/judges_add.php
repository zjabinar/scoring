<?php require_once('../Connections/conn_mutya.php'); ?><?php
// Load the common classes
require_once('../includes/common/KT_common.php');
if ($_POST["btncancel"]){
	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'])
	. "/judges.php" );
	exit(0);
}
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
$formValidation->addField("account", true, "text", "", "", "", "");
$formValidation->addField("password", true, "text", "", "", "", "");
$formValidation->addField("firstname", true, "text", "", "", "", "");
$formValidation->addField("lastname", true, "text", "", "", "", "");
$formValidation->addField("sex", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_judges = new tNG_insert($conn_conn_mutya);
$tNGs->addTransaction($ins_judges);
// Register triggers
$ins_judges->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_judges->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_judges->registerTrigger("END", "Trigger_Default_Redirect", 99, "judges.php?admin_id=".$curr_admin_id);
$ins_judges->registerConditionalTrigger("{POST.password} != {POST.re_password}", "BEFORE", "Trigger_CheckPasswords1", 50);
// Add columns
$ins_judges->setTable("judges");
$ins_judges->addColumn("account", "STRING_TYPE", "POST", "account");
$ins_judges->addColumn("password", "STRING_TYPE", "POST", "password");
$ins_judges->addColumn("firstname", "STRING_TYPE", "POST", "firstname");
$ins_judges->addColumn("lastname", "STRING_TYPE", "POST", "lastname");
$ins_judges->addColumn("middlename", "STRING_TYPE", "POST", "middlename");
$ins_judges->addColumn("sex", "STRING_TYPE", "POST", "sex");
$ins_judges->addColumn("profession", "STRING_TYPE", "POST", "profession");
$ins_judges->addColumn("company_name", "STRING_TYPE", "POST", "company_name");
$ins_judges->addColumn("company_address", "STRING_TYPE", "POST", "company_address");
$ins_judges->setPrimaryKey("judgeid", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();
echo "hi";

// Get the transaction recordset
$rsjudges = $tNGs->getRecordset("judges");
$row_rsjudges = mysql_fetch_assoc($rsjudges);
$totalRows_rsjudges = mysql_num_rows($rsjudges);
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
  <a class="dock-item" href="control_window.php"><img src="images/control.png" alt="Controls" /><span>Controls</span></a> 
  <a class="dock-item" href="contestant.php"><img src="images/contestant.png" alt="contestant" /><span>Contestant</span></a>  <a class="dock-item" href="admin.php"><img src="images/user.png" alt="Administrator" /><span>Administrator</span></a> <a class="dock-item" href="judges.php"><img src="images/judge.png" alt="judges" /><span>Judges</span></a>   <a class="dock-item" href="criteria_main.php"><img src="images/criteria.png" alt="criteria" /><span>Criteria</span></a>  <a class="dock-item" href="gallery.php"><img src="images/gallery.png" alt="gallery" /><span>Gallery</span></a> <a class="dock-item" href="reporting.php"><img src="images/print.png" alt="reports" /><span>Reports</span></a> 
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
<br /><br />
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
      <td class="KT_th"><label for="account">Account:</label></td>
      <td><input type="text" name="account" id="account" value="<?php echo KT_escapeAttribute($row_rsjudges['account']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("account");?> <?php echo $tNGs->displayFieldError("judges", "account"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="password">Password:</label></td>
      <td><input type="password" name="password" id="password" value="" size="32" />
          <?php echo $tNGs->displayFieldHint("password");?> <?php echo $tNGs->displayFieldError("judges", "password"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="re_password">Re-type Password:</label></td>
      <td><input type="password" name="re_password" id="re_password" value="" size="32" />
      </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="firstname">Firstname:</label></td>
      <td><input type="text" name="firstname" id="firstname" value="<?php echo KT_escapeAttribute($row_rsjudges['firstname']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("firstname");?> <?php echo $tNGs->displayFieldError("judges", "firstname"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="lastname">Lastname:</label></td>
      <td><input type="text" name="lastname" id="lastname" value="<?php echo KT_escapeAttribute($row_rsjudges['lastname']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("lastname");?> <?php echo $tNGs->displayFieldError("judges", "lastname"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="middlename">M.:</label></td>
      <td><input type="text" name="middlename" id="middlename" value="<?php echo KT_escapeAttribute($row_rsjudges['middlename']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("middlename");?> <?php echo $tNGs->displayFieldError("judges", "middlename"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="sex">Sex:</label></td>
      <td><select name="sex" id="sex">
        <option value="Male" <?php if (!(strcmp("Male", KT_escapeAttribute($row_rsjudges['sex'])))) {echo "SELECTED";} ?>>Male</option>
        <option value="Female" <?php if (!(strcmp("Female", KT_escapeAttribute($row_rsjudges['sex'])))) {echo "SELECTED";} ?>>Female</option>
      </select>
          <?php echo $tNGs->displayFieldError("judges", "sex"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="profession">Profession:</label></td>
      <td><input type="text" name="profession" id="profession" value="<?php echo KT_escapeAttribute($row_rsjudges['profession']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("profession");?> <?php echo $tNGs->displayFieldError("judges", "profession"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="company_name">Company:</label></td>
      <td><textarea name="company_name" id="company_name" cols="23" rows="3"><?php echo KT_escapeAttribute($row_rsjudges['company_name']); ?></textarea>
          <?php echo $tNGs->displayFieldHint("company_name");?> <?php echo $tNGs->displayFieldError("judges", "company_name"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="company_address">Company Aaddress:</label></td>
      <td><textarea name="company_address" id="company_address" cols="23" rows="3"><?php echo KT_escapeAttribute($row_rsjudges['company_address']); ?></textarea>
          <?php echo $tNGs->displayFieldHint("company_address");?> <?php echo $tNGs->displayFieldError("judges", "company_address"); ?> </td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="btncancel" value="Cancel" />
      <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Insert record" />
      </td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>

    </div></td>
  </tr>
</table>
</body>
</html>