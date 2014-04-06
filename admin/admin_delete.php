<?php require_once('../Connections/conn_mutya.php'); ?>
<?php
$curr_admin_id=$_REQUEST['admin_id'];
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_conn_mutya = new KT_connection($conn_mutya, $database_conn_mutya);

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

// Make an instance of the transaction object
$del_admin = new tNG_delete($conn_conn_mutya);
$tNGs->addTransaction($del_admin);
// Register triggers
$del_admin->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "admin_id");
$del_admin->registerTrigger("END", "Trigger_Default_Redirect", 99, "admin.php?admin_id=".$curr_admin_id);
// Add columns
$del_admin->setTable("`admin`");
$del_admin->setPrimaryKey("admin_id", "NUMERIC_TYPE", "GET", "admin_id");

// Execute all the registered transactions
$tNGs->executeTransactions();
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
</head>
<body>
<div class="dock" id="dock">
  <div class="dock-container">
  <a class="dock-item" href="control_window.php"><img src="images/control.png" alt="Controls" /><span>Controls</span></a> 
  <a class="dock-item" href="contestant.php"><img src="images/contestant.png" alt="contestant" /><span>Contact</span></a> 
  <a class="dock-item" href="#"><img src="images/user.png" alt="Administrator" /><span>Portfolio</span></a>  <a class="dock-item" href="judges.php"><img src="images/judge.png" alt="judges" /><span>Judges</span></a>   <a class="dock-item" href="criteria_main.php"><img src="images/criteria.png" alt="criteria" /><span>Criteria</span></a>  <a class="dock-item" href="gallery.php"><img src="images/gallery.png" alt="gallery" /><span>Gallery</span></a> <a class="dock-item" href="reporting.php"><img src="images/print.png" alt="reports" /><span>Reports</span></a> 
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
<table width="800" border="0" align="center">
  <tr>
    <td><?php
	echo $tNGs->getErrorMsg();
?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rec_admin);
?>
