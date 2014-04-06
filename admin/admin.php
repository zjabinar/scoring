<?php require_once('../Connections/conn_mutya.php'); ?>
<?php

//if (!isset($_REQUEST['admin_id']) or $_REQUEST['admin_id']==""){
//	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/index.php");
//	exit(0);
//}
$curr_admin_id=$_REQUEST['admin_id'];

// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the required classes
require_once('../includes/tfi/TFI.php');
require_once('../includes/tso/TSO.php');
require_once('../includes/nav/NAV.php');

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

// Filter
$tfi_listrec_admin9 = new TFI_TableFilter($conn_conn_mutya, "tfi_listrec_admin9");
$tfi_listrec_admin9->addColumn("username", "STRING_TYPE", "username", "%");
$tfi_listrec_admin9->addColumn("password", "STRING_TYPE", "password", "%");
$tfi_listrec_admin9->Execute();

// Sorter
$tso_listrec_admin9 = new TSO_TableSorter("rec_admin", "tso_listrec_admin9");
$tso_listrec_admin9->addColumn("username");
$tso_listrec_admin9->addColumn("password");
$tso_listrec_admin9->setDefault("username");
$tso_listrec_admin9->Execute();

// Navigation
$nav_listrec_admin9 = new NAV_Regular("nav_listrec_admin9", "rec_admin", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rec_admin = $_SESSION['max_rows_nav_listrec_admin9'];
$pageNum_rec_admin = 0;
if (isset($_GET['pageNum_rec_admin'])) {
  $pageNum_rec_admin = $_GET['pageNum_rec_admin'];
}
$startRow_rec_admin = $pageNum_rec_admin * $maxRows_rec_admin;

// Defining List Recordset variable
$NXTFilter_rec_admin = "1=1";
if (isset($_SESSION['filter_tfi_listrec_admin9'])) {
  $NXTFilter_rec_admin = $_SESSION['filter_tfi_listrec_admin9'];
}
// Defining List Recordset variable
$NXTSort_rec_admin = "username";
if (isset($_SESSION['sorter_tso_listrec_admin9'])) {
  $NXTSort_rec_admin = $_SESSION['sorter_tso_listrec_admin9'];
}
mysql_select_db($database_conn_mutya, $conn_mutya);

$query_rec_admin = "SELECT * FROM `admin` WHERE  {$NXTFilter_rec_admin}  ORDER BY  {$NXTSort_rec_admin} ";
$query_limit_rec_admin = sprintf("%s LIMIT %d, %d", $query_rec_admin, $startRow_rec_admin, $maxRows_rec_admin);
$rec_admin = mysql_query($query_limit_rec_admin, $conn_mutya) or die(mysql_error());
$row_rec_admin = mysql_fetch_assoc($rec_admin);

if (isset($_GET['totalRows_rec_admin'])) {
  $totalRows_rec_admin = $_GET['totalRows_rec_admin'];
} else {
  $all_rec_admin = mysql_query($query_rec_admin);
  $totalRows_rec_admin = mysql_num_rows($all_rec_admin);
}
$totalPages_rec_admin = ceil($totalRows_rec_admin/$maxRows_rec_admin)-1;
//End NeXTenesio3 Special List Recordset

$nav_listrec_admin9->checkBoundries();
?>
<?php require_once('../Connections/conn_mutya.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<script src="../includes/nxt/scripts/list.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/list.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: false,
  duplicate_navigation: false,
  row_effects: true,
  show_as_buttons: true,
  record_counter: false
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_username {width:140px; overflow:hidden;}
  .KT_col_password {width:140px; overflow:hidden;}
</style>
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
<br />
<table width="300" border="0" align="center">
  <tr>
    <td>&nbsp;
      <div class="KT_tng" id="listrec_admin9">
        <div class="KT_tnglist">
          <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
            <table cellpadding="2" cellspacing="0" class="KT_tngtable">
              <thead>
                <tr class="KT_row_order">
                  <th>&nbsp; 
                  </th>
                  <th>Username</th>
                  <th>Password </th>
                  <th>&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($totalRows_rec_admin == 0) { // Show if recordset empty ?>
                  <tr>
                    <td colspan="4"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                  </tr>
                  <?php } // Show if recordset empty ?>
                <?php if ($totalRows_rec_admin > 0) { // Show if recordset not empty ?>
                  <?php do { ?>
                    <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                      <td>
                          <input type="hidden" name="admin_id" class="id_field" value="<?php echo $row_rec_admin['admin_id']; ?>" />
                      </td>
                      <td><div class="KT_col_username"><?php echo KT_FormatForList($row_rec_admin['username'], 20); ?></div></td>
                      <td><div class="KT_col_password"><?php echo KT_FormatForList($row_rec_admin['password'], 20); ?></div></td>
                      <td><a class="KT_edit_link" href="admin_edit.php?admin_id=<?php echo $row_rec_admin['admin_id']; ?>&amp;KT_back=1&amp;admin_id="<?php echo $curr_admin_id; ?>"><?php echo NXT_getResource("edit_one"); ?></a> 
                      <a class="KT_edit_link" href="admin_delete.php?admin_id=<?php echo $row_rec_admin['admin_id']; ?>&amp;admin_id="<?php echo $curr_admin_id; ?>">Delete</a> </td>
                    </tr>
                    <?php } while ($row_rec_admin = mysql_fetch_assoc($rec_admin)); ?>
                  <?php } // Show if recordset not empty ?>
              </tbody>
            </table>
            <div class="KT_bottomnav">
              <div>
                <?php
            $nav_listrec_admin9->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
              </div>
            </div>
            <div class="KT_bottombuttons">
              <a class="KT_additem_op_link" href="admin_add.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
          </form>
        </div>
        <br class="clearfixplain" />
      </div>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rec_admin);

mysql_free_result($rec_admin);
?>
