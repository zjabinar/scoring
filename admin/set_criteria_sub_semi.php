<?php require_once('../Connections/conn_mutya.php'); ?>
<?php


if (isset($_REQUEST['criteria_id'])) {
	if($_REQUEST['criteria_id']<>0 or $_REQUEST['criteria_id']<>"") {
		$criteria_id = $_REQUEST['criteria_id'];
		$criteria_table = 1;
		$str = "UPDATE criteria_flag set used_id=" . $criteria_table . ", criteria_id=" . $criteria_id;
		$result = mysql_query($str);
		mysql_select_db($database_conn_mutya, $conn_mutya);
		$query_set_cri = "SELECT criteria_id, criteria_name FROM semi_criteria where criteria_id=".$_REQUEST['criteria_id'];
		$set_cri = mysql_query($query_set_cri, $conn_mutya) or die(mysql_error());
		$row_set_cri = mysql_fetch_assoc($set_cri);
		$totalRows_set_cri = mysql_num_rows($set_cri);
		?>
		<script language="JavaScript" type="text/javascript">
        <!--
        alert("<?php echo $row_set_cri['criteria_name']; ?> is now activated!");
        // -->
        </script>
        <?php
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
	}
}

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
$tfi_listrec_semi1 = new TFI_TableFilter($conn_conn_mutya, "tfi_listrec_semi1");
$tfi_listrec_semi1->addColumn("criteria_id", "NUMERIC_TYPE", "criteria_id", "=");
$tfi_listrec_semi1->addColumn("criteria_name", "STRING_TYPE", "criteria_name", "%");
$tfi_listrec_semi1->Execute();

// Sorter
$tso_listrec_semi1 = new TSO_TableSorter("rec_semi", "tso_listrec_semi1");
$tso_listrec_semi1->addColumn("criteria_id");
$tso_listrec_semi1->addColumn("criteria_name");
$tso_listrec_semi1->setDefault("criteria_id");
$tso_listrec_semi1->Execute();

// Navigation
$nav_listrec_semi1 = new NAV_Regular("nav_listrec_semi1", "rec_semi", "../", $_SERVER['PHP_SELF'], 15);

//NeXTenesio3 Special List Recordset
$maxRows_rec_semi = $_SESSION['max_rows_nav_listrec_semi1'];
$pageNum_rec_semi = 0;
if (isset($_GET['pageNum_rec_semi'])) {
  $pageNum_rec_semi = $_GET['pageNum_rec_semi'];
}
$startRow_rec_semi = $pageNum_rec_semi * $maxRows_rec_semi;

// Defining List Recordset variable
$NXTFilter_rec_semi = "1=1";
if (isset($_SESSION['filter_tfi_listrec_semi1'])) {
  $NXTFilter_rec_semi = $_SESSION['filter_tfi_listrec_semi1'];
}
// Defining List Recordset variable
$NXTSort_rec_semi = "criteria_id";
if (isset($_SESSION['sorter_tso_listrec_semi1'])) {
  $NXTSort_rec_semi = $_SESSION['sorter_tso_listrec_semi1'];
}
mysql_select_db($database_conn_mutya, $conn_mutya);

$query_rec_semi = "SELECT criteria_id, criteria_name FROM semi_criteria WHERE  {$NXTFilter_rec_semi}  ORDER BY  {$NXTSort_rec_semi} ";
$query_limit_rec_semi = sprintf("%s LIMIT %d, %d", $query_rec_semi, $startRow_rec_semi, $maxRows_rec_semi);
$rec_semi = mysql_query($query_limit_rec_semi, $conn_mutya) or die(mysql_error());
$row_rec_semi = mysql_fetch_assoc($rec_semi);

if (isset($_GET['totalRows_rec_semi'])) {
  $totalRows_rec_semi = $_GET['totalRows_rec_semi'];
} else {
  $all_rec_semi = mysql_query($query_rec_semi);
  $totalRows_rec_semi = mysql_num_rows($all_rec_semi);
}
$totalPages_rec_semi = ceil($totalRows_rec_semi/$maxRows_rec_semi)-1;
//End NeXTenesio3 Special List Recordset

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_rec_criteria_flag = "SELECT active_id, used_id, criteria_id FROM criteria_flag";
$rec_criteria_flag = mysql_query($query_rec_criteria_flag, $conn_mutya) or die(mysql_error());
$row_rec_criteria_flag = mysql_fetch_assoc($rec_criteria_flag);
$totalRows_rec_criteria_flag = mysql_num_rows($rec_criteria_flag);

$nav_listrec_semi1->checkBoundries();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
  .KT_col_criteria_id {width:70px; overflow:hidden;}
  .KT_col_criteria_name {width:210px; overflow:hidden;}
</style>
</head>

<body>
<div class="KT_tng" id="listrec_semi1">
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th>&nbsp;            </th>
            <th id="criteria_id" class="KT_sorter KT_col_criteria_id <?php echo $tso_listrec_semi1->getSortIcon('criteria_id'); ?>"> ID </th>
            <th id="criteria_name" class="KT_sorter KT_col_criteria_name <?php echo $tso_listrec_semi1->getSortIcon('criteria_name'); ?>">Criteria </th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($totalRows_rec_semi == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="5"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rec_semi > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td>&nbsp;
                    <input type="hidden" name="criteria_id" class="id_field" value="<?php echo $row_rec_semi['criteria_id']; ?>" />                </td>
                <td><div class="KT_col_criteria_id"><?php echo KT_FormatForList($row_rec_semi['criteria_id'], 10); ?></div></td>
                <td><div class="KT_col_criteria_name"><?php echo KT_FormatForList($row_rec_semi['criteria_name'], 30); ?></div></td>                
                <td><a class="KT_edit_link" href="set_criteria_sub_semi.php?criteria_id=<?php echo $row_rec_semi['criteria_id']; ?>&amp;KT_back=1">Activate</a></td>

              </tr>
              <?php } while ($row_rec_semi = mysql_fetch_assoc($rec_semi)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrec_semi1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons"> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rec_semi);

mysql_free_result($rec_criteria_flag);
?>
