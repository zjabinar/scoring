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
$tfi_listfinalist2 = new TFI_TableFilter($conn_conn_mutya, "tfi_listfinalist2");
$tfi_listfinalist2->addColumn("contestant_num", "NUMERIC_TYPE", "contestant_num", "=");
$tfi_listfinalist2->addColumn("municipality", "STRING_TYPE", "municipality", "%");
$tfi_listfinalist2->addColumn("avgrating", "NUMERIC_TYPE", "avgrating", "=");
$tfi_listfinalist2->addColumn("finalist", "NUMERIC_TYPE", "finalist", "=");
$tfi_listfinalist2->Execute();

// Sorter
$tso_listfinalist2 = new TSO_TableSorter("finalist", "tso_listfinalist2");
$tso_listfinalist2->addColumn("contestant_num");
$tso_listfinalist2->addColumn("municipality");
$tso_listfinalist2->addColumn("avgrating");
$tso_listfinalist2->addColumn("finalist");
$tso_listfinalist2->setDefault("avgrating DESC");
$tso_listfinalist2->Execute();

// Navigation
$nav_listfinalist2 = new NAV_Regular("nav_listfinalist2", "finalist", "../", $_SERVER['PHP_SELF'], 15);

//NeXTenesio3 Special List Recordset
$maxRows_finalist = $_SESSION['max_rows_nav_listfinalist2'];
$pageNum_finalist = 0;
if (isset($_GET['pageNum_finalist'])) {
  $pageNum_finalist = $_GET['pageNum_finalist'];
}
$startRow_finalist = $pageNum_finalist * $maxRows_finalist;

// Defining List Recordset variable
$NXTFilter_finalist = "1=1";
if (isset($_SESSION['filter_tfi_listfinalist2'])) {
  $NXTFilter_finalist = $_SESSION['filter_tfi_listfinalist2'];
}
// Defining List Recordset variable
$NXTSort_finalist = "avgrating DESC";
if (isset($_SESSION['sorter_tso_listfinalist2'])) {
  $NXTSort_finalist = $_SESSION['sorter_tso_listfinalist2'];
}
mysql_select_db($database_conn_mutya, $conn_mutya);

$query_finalist = "SELECT contestants.contestant_id, contestants.contestant_num, contestants.firstname, contestants.lastname, contestants.middlename, contestants.municipality, contestants.finalist, Avg(semi_scores.rating) AS avgrating FROM semi_scores LEFT JOIN contestants ON semi_scores.contestant_id = contestants.contestant_id WHERE  {$NXTFilter_finalist}  GROUP BY contestants.contestant_id, contestants.contestant_num, contestants.firstname, contestants.lastname, contestants.middlename, contestants.municipality, contestants.finalist ORDER BY contestants.municipality ";
$query_limit_finalist = sprintf("%s LIMIT %d, %d", $query_finalist, $startRow_finalist, $maxRows_finalist);
$finalist = mysql_query($query_limit_finalist, $conn_mutya) or die(mysql_error());
$row_finalist = mysql_fetch_assoc($finalist);

if (isset($_GET['totalRows_finalist'])) {
  $totalRows_finalist = $_GET['totalRows_finalist'];
} else {
  $all_finalist = mysql_query($query_finalist);
  $totalRows_finalist = mysql_num_rows($all_finalist);
}
$totalPages_finalist = ceil($totalRows_finalist/$maxRows_finalist)-1;
//End NeXTenesio3 Special List Recordset

$nav_listfinalist2->checkBoundries();
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
  .KT_col_contestant_num {width:35px; overflow:hidden; font-size: 14px;}
  .KT_col_municipality {width:140px; overflow:hidden; font-size: 14px;}
  .KT_col_avgrating {width:140px; overflow:hidden; font-size: 14px;}
  .KT_col_finalist {width:70px; overflow:hidden; font-size: 14px;}
.style1 {
	font-size: 14px
}
</style>
</head>

<body>
<div class="KT_tng" id="listfinalist2">

  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th>&nbsp;            </th>
            <th>Num </th>
            <th>Municipality </th>
            <th>&nbsp; </th>
            <th>Finalist </th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($totalRows_finalist == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="6"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_finalist > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td>
                    <input name="contestant_id" type="hidden" class="id_field " value="<?php echo $row_finalist['contestant_id']; ?>" />                </td>
                <td><div class="KT_col_contestant_num"><?php echo KT_FormatForList($row_finalist['contestant_num'], 5); ?></div></td>
                <td align="left"><div class="KT_col_municipality"><?php echo KT_FormatForList($row_finalist['municipality'], 20); ?></div></td>
                <td><div class="KT_col_avgrating style1"><?php  //echo number_format(KT_FormatForList($row_finalist['avgrating'],2), 5); ?></div></td>
                <td><div class="KT_col_finalist"><?php if ($row_finalist['finalist']==0) { echo "&nbsp;"; }else{ echo "Finalist"; } //echo KT_FormatForList($row_finalist['finalist'], 10); ?></div></td>
                <td><a class="KT_col_finalist" href="finalist_update.php?btn_update=1&contestant_id=<?php echo $row_finalist['contestant_id']; ?>&amp;KT_back=1">No</a>&nbsp;&nbsp;
                <a class="KT_col_finalist" href="finalist_update.php?btn_update=2&contestant_id=<?php echo $row_finalist['contestant_id']; ?>&amp;KT_back=1">Yes</a> </td>
              </tr>
              <?php } while ($row_finalist = mysql_fetch_assoc($finalist)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
    </form>
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($finalist);
?>
