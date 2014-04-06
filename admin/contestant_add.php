<?php require_once('../Connections/conn_mutya.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');
if ($_POST["btncancel"]){
	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'])
	. "/contestant.php" );
	exit(0);
}
$curr_admin_id=$_REQUEST['admin_id'];
// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_conn_mutya = new KT_connection($conn_mutya, $database_conn_mutya);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("contestant_num", true, "numeric", "", "", "", "");
$formValidation->addField("firstname", true, "text", "", "", "", "");
$formValidation->addField("lastname", true, "text", "", "", "", "");
$formValidation->addField("municipality", true, "text", "", "", "", "");
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

// Make an insert transaction instance
$ins_contestants = new tNG_insert($conn_conn_mutya);
$tNGs->addTransaction($ins_contestants);
// Register triggers
$ins_contestants->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contestants->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contestants->registerTrigger("END", "Trigger_Default_Redirect", 99, "contestant.php?admin_id=".$curr_admin_id);
// Add columns
$ins_contestants->setTable("contestants");
$ins_contestants->addColumn("contestant_num", "NUMERIC_TYPE", "POST", "contestant_num");
$ins_contestants->addColumn("firstname", "STRING_TYPE", "POST", "firstname");
$ins_contestants->addColumn("lastname", "STRING_TYPE", "POST", "lastname");
$ins_contestants->addColumn("middlename", "STRING_TYPE", "POST", "middlename");
$ins_contestants->addColumn("birthdate", "DATE_TYPE", "POST", "birthdate");
$ins_contestants->addColumn("municipality", "STRING_TYPE", "POST", "municipality");
$ins_contestants->addColumn("address", "STRING_TYPE", "POST", "address");
$ins_contestants->addColumn("photo1", "STRING_TYPE", "POST", "photo1");
$ins_contestants->addColumn("photo2", "STRING_TYPE", "POST", "photo2");
$ins_contestants->addColumn("photo3", "STRING_TYPE", "POST", "photo3");
$ins_contestants->addColumn("photo4", "STRING_TYPE", "POST", "photo4");
$ins_contestants->addColumn("photo5", "STRING_TYPE", "POST", "photo5");
$ins_contestants->setPrimaryKey("contestant_id", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscontestants = $tNGs->getRecordset("contestants");
$row_rscontestants = mysql_fetch_assoc($rscontestants);
$totalRows_rscontestants = mysql_num_rows($rscontestants);
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

<link href="style.css" rel="stylesheet" type="text/css" />
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
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
<br /><br />
<table width="200" border="0" align="center">
  <tr>
    <td><center>&nbsp;</center></td>
  </tr>
</table>
<table width="250" border="0" align="center">
  <tr>
    <td><div class="KT_tnglist"><?php
	echo $tNGs->getErrorMsg();
?>
      <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="contestant_num">Cons.#:</label></td>
            <td><input type="text" name="contestant_num" id="contestant_num" value="<?php echo KT_escapeAttribute($row_rscontestants['contestant_num']); ?>" size="32" />
                <?php echo $tNGs->displayFieldHint("contestant_num");?> <?php echo $tNGs->displayFieldError("contestants", "contestant_num"); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="firstname">Firstname:</label></td>
            <td><input type="text" name="firstname" id="firstname" value="<?php echo KT_escapeAttribute($row_rscontestants['firstname']); ?>" size="32" />
                <?php echo $tNGs->displayFieldHint("firstname");?> <?php echo $tNGs->displayFieldError("contestants", "firstname"); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="lastname">Lastname:</label></td>
            <td><input type="text" name="lastname" id="lastname" value="<?php echo KT_escapeAttribute($row_rscontestants['lastname']); ?>" size="32" />
                <?php echo $tNGs->displayFieldHint("lastname");?> <?php echo $tNGs->displayFieldError("contestants", "lastname"); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="middlename">M.:</label></td>
            <td><input type="text" name="middlename" id="middlename" value="<?php echo KT_escapeAttribute($row_rscontestants['middlename']); ?>" size="32" />
                <?php echo $tNGs->displayFieldHint("middlename");?> <?php echo $tNGs->displayFieldError("contestants", "middlename"); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="birthdate">Birthdate:</label></td>
            <td><input type="text" name="birthdate" id="birthdate" value="<?php echo KT_formatDate($row_rscontestants['birthdate']); ?>" size="32" />
                <?php echo $tNGs->displayFieldHint("birthdate");?> <?php echo $tNGs->displayFieldError("contestants", "birthdate"); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="municipality">Municipality:</label></td>
            <td><textarea name="municipality" id="municipality" cols="23" rows="3"><?php echo KT_escapeAttribute($row_rscontestants['municipality']); ?></textarea>
                <?php echo $tNGs->displayFieldHint("municipality");?> <?php echo $tNGs->displayFieldError("contestants", "municipality"); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="address">Address:</label></td>
            <td><textarea name="address" id="address" cols="23" rows="3"><?php echo KT_escapeAttribute($row_rscontestants['address']); ?></textarea>
                <?php echo $tNGs->displayFieldHint("address");?> <?php echo $tNGs->displayFieldError("contestants", "address"); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="photo1">Photo1:</label></td>
            <td><input type="text" name="photo1" id="photo1" value="<?php echo KT_escapeAttribute($row_rscontestants['photo1']); ?>" size="32" />
                <?php echo $tNGs->displayFieldHint("photo1");?> <?php echo $tNGs->displayFieldError("contestants", "photo1"); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="photo2">Photo2:</label></td>
            <td><input type="text" name="photo2" id="photo2" value="<?php echo KT_escapeAttribute($row_rscontestants['photo2']); ?>" size="32" />
                <?php echo $tNGs->displayFieldHint("photo2");?> <?php echo $tNGs->displayFieldError("contestants", "photo2"); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="photo3">Photo3:</label></td>
            <td><input type="text" name="photo3" id="photo3" value="<?php echo KT_escapeAttribute($row_rscontestants['photo3']); ?>" size="32" />
                <?php echo $tNGs->displayFieldHint("photo3");?> <?php echo $tNGs->displayFieldError("contestants", "photo3"); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="photo4">Photo4:</label></td>
            <td><input type="text" name="photo4" id="photo4" value="<?php echo KT_escapeAttribute($row_rscontestants['photo4']); ?>" size="32" />
                <?php echo $tNGs->displayFieldHint("photo4");?> <?php echo $tNGs->displayFieldError("contestants", "photo4"); ?> </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="photo5">Photo5:</label></td>
            <td><input type="text" name="photo5" id="photo5" value="<?php echo KT_escapeAttribute($row_rscontestants['photo5']); ?>" size="32" />
                <?php echo $tNGs->displayFieldHint("photo5");?> <?php echo $tNGs->displayFieldError("contestants", "photo5"); ?> </td>
          </tr>
          <tr class="KT_buttons">
            <td colspan="2"><input type="submit" name="btncancel" value="Cancel" />
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Insert record" />
            </td>
          </tr>
        </table>
      </form>
    </div></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rec_admin);
?>
