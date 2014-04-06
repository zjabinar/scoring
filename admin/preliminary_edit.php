<?php require_once('../Connections/conn_mutya.php'); ?>
<?php
if ($_REQUEST['btnback']){
	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/preliminary.php");
	exit(0);
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
$tfi_listper_scores1 = new TFI_TableFilter($conn_conn_mutya, "tfi_listper_scores1");
$tfi_listper_scores1->addColumn("criteria_name", "STRING_TYPE", "criteria_name", "%");
$tfi_listper_scores1->addColumn("rating", "NUMERIC_TYPE", "rating", "=");
$tfi_listper_scores1->Execute();

// Sorter
$tso_listper_scores1 = new TSO_TableSorter("per_scores", "tso_listper_scores1");
$tso_listper_scores1->addColumn("criteria_name");
$tso_listper_scores1->addColumn("rating");
$tso_listper_scores1->setDefault("criteria_name");
$tso_listper_scores1->Execute();

// Navigation
$nav_listper_scores1 = new NAV_Regular("nav_listper_scores1", "per_scores", "../", $_SERVER['PHP_SELF'], 15);

$contestant_id = $_REQUEST['contestant_id'];
mysql_select_db($database_conn_mutya, $conn_mutya);
$query_contestant = "SELECT contestant_id, contestant_num, firstname, lastname, middlename, birthdate, municipality FROM contestants where contestant_id=".$contestant_id;
$contestant = mysql_query($query_contestant, $conn_mutya) or die(mysql_error());
$row_contestant = mysql_fetch_assoc($contestant);
$totalRows_contestant = mysql_num_rows($contestant);

//NeXTenesio3 Special List Recordset
$maxRows_per_scores = $_SESSION['max_rows_nav_listper_scores1'];
$pageNum_per_scores = 0;
if (isset($_GET['pageNum_per_scores'])) {
  $pageNum_per_scores = $_GET['pageNum_per_scores'];
}
$startRow_per_scores = $pageNum_per_scores * $maxRows_per_scores;

// Defining List Recordset variable
$NXTFilter_per_scores = "1=1";
if (isset($_SESSION['filter_tfi_listper_scores1'])) {
  $NXTFilter_per_scores = $_SESSION['filter_tfi_listper_scores1'];
}
// Defining List Recordset variable
$NXTSort_per_scores = "criteria_name";
if (isset($_SESSION['sorter_tso_listper_scores1'])) {
  $NXTSort_per_scores = $_SESSION['sorter_tso_listper_scores1'];
}
mysql_select_db($database_conn_mutya, $conn_mutya);

$query_per_scores = "SELECT pre_criteria.criteria_name, pre_scores.score_id, pre_scores.contestant_id, pre_scores.rating FROM pre_criteria RIGHT JOIN pre_scores ON pre_criteria.criteria_id = pre_scores.criteria_id WHERE  contestant_id=".$contestant_id . "  ORDER BY  {$NXTSort_per_scores} ";
$query_limit_per_scores = sprintf("%s LIMIT %d, %d", $query_per_scores, $startRow_per_scores, $maxRows_per_scores);
$per_scores = mysql_query($query_limit_per_scores, $conn_mutya) or die(mysql_error());
$row_per_scores = mysql_fetch_assoc($per_scores);

if (isset($_GET['totalRows_per_scores'])) {
  $totalRows_per_scores = $_GET['totalRows_per_scores'];
} else {
  $all_per_scores = mysql_query($query_per_scores);
  $totalRows_per_scores = mysql_num_rows($all_per_scores);
}
$totalPages_per_scores = ceil($totalRows_per_scores/$maxRows_per_scores)-1;
//End NeXTenesio3 Special List Recordset

$nav_listper_scores1->checkBoundries();
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
  .KT_col_criteria_name {width:210px; overflow:hidden;}
  .KT_col_rating {width:140px; overflow:hidden;}
</style>
</head>

<body>
<div class="KT_tng" id="listper_scores1">
  <h1> <?php echo $row_contestant['lastname'] . ",  " . $row_contestant['firstname']; ?></h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> &nbsp;
            </th>
            <th>Criteria </th>
            <th>Rating </th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($totalRows_per_scores == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="4"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_per_scores > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td>
                    <input type="hidden" name="score_id" class="id_field" value="<?php echo $row_per_scores['score_id']; ?>" />
                </td>
                <td><div class="KT_col_criteria_name"><?php echo KT_FormatForList($row_per_scores['criteria_name'], 30); ?></div></td>
                <td><div class="KT_col_rating"><?php echo KT_FormatForList($row_per_scores['rating'], 20); ?></div></td>
                <td><a class="KT_edit_link" href="preliminary_edit_sub.php?contestant_id=<?php echo $row_contestant['contestant_id']; ?>&amp;score_id=<?php echo $row_per_scores['score_id']; ?>&amp;KT_back=1">Edit</a> </td>
              </tr>
              <?php } while ($row_per_scores = mysql_fetch_assoc($per_scores)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listper_scores1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      
      <div class="KT_bottombuttons">
      <input type="submit" name="btnback" value=" Back " />
 </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($contestant);

mysql_free_result($per_scores);
?>
