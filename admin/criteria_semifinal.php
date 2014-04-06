<?php require_once('../Connections/conn_mutya.php'); ?>
<?php
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
$tfi_listrec_semifinal2 = new TFI_TableFilter($conn_conn_mutya, "tfi_listrec_semifinal2");
$tfi_listrec_semifinal2->addColumn("criteria_name", "STRING_TYPE", "criteria_name", "%");
$tfi_listrec_semifinal2->addColumn("info", "STRING_TYPE", "info", "%");
$tfi_listrec_semifinal2->Execute();

// Sorter
$tso_listrec_semifinal2 = new TSO_TableSorter("rec_semifinal", "tso_listrec_semifinal2");
$tso_listrec_semifinal2->addColumn("criteria_name");
$tso_listrec_semifinal2->addColumn("info");
$tso_listrec_semifinal2->setDefault("criteria_name");
$tso_listrec_semifinal2->Execute();

// Navigation
$nav_listrec_semifinal2 = new NAV_Regular("nav_listrec_semifinal2", "rec_semifinal", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rec_semifinal = $_SESSION['max_rows_nav_listrec_semifinal2'];
$pageNum_rec_semifinal = 0;
if (isset($_GET['pageNum_rec_semifinal'])) {
  $pageNum_rec_semifinal = $_GET['pageNum_rec_semifinal'];
}
$startRow_rec_semifinal = $pageNum_rec_semifinal * $maxRows_rec_semifinal;

// Defining List Recordset variable
$NXTFilter_rec_semifinal = "1=1";
if (isset($_SESSION['filter_tfi_listrec_semifinal2'])) {
  $NXTFilter_rec_semifinal = $_SESSION['filter_tfi_listrec_semifinal2'];
}
// Defining List Recordset variable
$NXTSort_rec_semifinal = "criteria_name";
if (isset($_SESSION['sorter_tso_listrec_semifinal2'])) {
  $NXTSort_rec_semifinal = $_SESSION['sorter_tso_listrec_semifinal2'];
}
mysql_select_db($database_conn_mutya, $conn_mutya);

$query_rec_semifinal = "SELECT * FROM semi_criteria WHERE  {$NXTFilter_rec_semifinal}  ORDER BY  {$NXTSort_rec_semifinal} ";
$query_limit_rec_semifinal = sprintf("%s LIMIT %d, %d", $query_rec_semifinal, $startRow_rec_semifinal, $maxRows_rec_semifinal);
$rec_semifinal = mysql_query($query_limit_rec_semifinal, $conn_mutya) or die(mysql_error());
$row_rec_semifinal = mysql_fetch_assoc($rec_semifinal);

if (isset($_GET['totalRows_rec_semifinal'])) {
  $totalRows_rec_semifinal = $_GET['totalRows_rec_semifinal'];
} else {
  $all_rec_semifinal = mysql_query($query_rec_semifinal);
  $totalRows_rec_semifinal = mysql_num_rows($all_rec_semifinal);
}
$totalPages_rec_semifinal = ceil($totalRows_rec_semifinal/$maxRows_rec_semifinal)-1;
//End NeXTenesio3 Special List Recordset

$nav_listrec_semifinal2->checkBoundries();
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
  .KT_col_criteria_name {width:175px; overflow:hidden;}
  .KT_col_info {width:175px; overflow:hidden;}
</style>
</head>

<body>
<div class="KT_tng" id="listrec_semifinal2">
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="criteria_name" class="KT_sorter KT_col_criteria_name <?php echo $tso_listrec_semifinal2->getSortIcon('criteria_name'); ?>"> <a href="<?php echo $tso_listrec_semifinal2->getSortLink('criteria_name'); ?>">Criteria_name</a> </th>
            <th id="info" class="KT_sorter KT_col_info <?php echo $tso_listrec_semifinal2->getSortIcon('info'); ?>"> <a href="<?php echo $tso_listrec_semifinal2->getSortLink('info'); ?>">Info</a> </th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($totalRows_rec_semifinal == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="4"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rec_semifinal > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_semi_criteria" class="id_checkbox" value="<?php echo $row_rec_semifinal['criteria_id']; ?>" />
                    <input type="hidden" name="criteria_id" class="id_field" value="<?php echo $row_rec_semifinal['criteria_id']; ?>" />
                </td>
                <td><div class="KT_col_criteria_name"><?php echo KT_FormatForList($row_rec_semifinal['criteria_name'], 25); ?></div></td>
                <td><div class="KT_col_info"><?php echo KT_FormatForList($row_rec_semifinal['info'], 25); ?></div></td>
                <td><a class="KT_edit_link" href="criteria_semifinal_edit.php?criteria_id=<?php echo $row_rec_semifinal['criteria_id']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> 
                <a class="KT_edit_link" href="criteria_semifinal_delete.php?criteria_id=<?php echo $row_rec_semifinal['criteria_id']; ?>&amp;KT_back=1"><?php echo NXT_getResource("delete_one"); ?></a> </td>
              </tr>
              <?php } while ($row_rec_semifinal = mysql_fetch_assoc($rec_semifinal)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrec_semifinal2->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">

        <a class="KT_additem_op_link" href="criteria_semifinal_add.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rec_semifinal);
?>
