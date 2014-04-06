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
$tfi_listcontestant1 = new TFI_TableFilter($conn_conn_mutya, "tfi_listcontestant1");
$tfi_listcontestant1->addColumn("contestant_num", "NUMERIC_TYPE", "contestant_num", "=");
$tfi_listcontestant1->addColumn("municipality", "STRING_TYPE", "municipality", "%");
$tfi_listcontestant1->addColumn("firstname", "STRING_TYPE", "firstname", "%");
$tfi_listcontestant1->addColumn("lastname", "STRING_TYPE", "lastname", "%");
$tfi_listcontestant1->addColumn("middlename", "STRING_TYPE", "middlename", "%");
$tfi_listcontestant1->Execute();

// Sorter
$tso_listcontestant1 = new TSO_TableSorter("contestant", "tso_listcontestant1");
$tso_listcontestant1->addColumn("contestant_num");
$tso_listcontestant1->addColumn("municipality");
$tso_listcontestant1->addColumn("firstname");
$tso_listcontestant1->addColumn("lastname");
$tso_listcontestant1->addColumn("middlename");
$tso_listcontestant1->setDefault("contestant_num");
$tso_listcontestant1->Execute();

// Navigation
$nav_listcontestant1 = new NAV_Regular("nav_listcontestant1", "contestant", "../", $_SERVER['PHP_SELF'], 15);

//NeXTenesio3 Special List Recordset
$maxRows_contestant = $_SESSION['max_rows_nav_listcontestant1'];
$pageNum_contestant = 0;
if (isset($_GET['pageNum_contestant'])) {
  $pageNum_contestant = $_GET['pageNum_contestant'];
}
$startRow_contestant = $pageNum_contestant * $maxRows_contestant;

// Defining List Recordset variable
$NXTFilter_contestant = "1=1";
if (isset($_SESSION['filter_tfi_listcontestant1'])) {
  $NXTFilter_contestant = $_SESSION['filter_tfi_listcontestant1'];
}
// Defining List Recordset variable
$NXTSort_contestant = "contestant_num";
if (isset($_SESSION['sorter_tso_listcontestant1'])) {
  $NXTSort_contestant = $_SESSION['sorter_tso_listcontestant1'];
}

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_contestant = "SELECT contestant_id, contestant_num, firstname, lastname, middlename, birthdate, municipality, address, finalist FROM contestants";
$contestant = mysql_query($query_contestant, $conn_mutya) or die(mysql_error());
$row_contestant = mysql_fetch_assoc($contestant);
$totalRows_contestant = mysql_num_rows($contestant);

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_pre_cri = "SELECT criteria_id, criteria_name FROM pre_criteria";
$pre_cri = mysql_query($query_pre_cri, $conn_mutya) or die(mysql_error());
$row_pre_cri = mysql_fetch_assoc($pre_cri);
$totalRows_pre_cri = mysql_num_rows($pre_cri);

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_pre_scores = "SELECT score_id, contestant_id, criteria_id, rating FROM pre_scores";
$pre_scores = mysql_query($query_pre_scores, $conn_mutya) or die(mysql_error());
$row_pre_scores = mysql_fetch_assoc($pre_scores);
$totalRows_pre_scores = mysql_num_rows($pre_scores);

$nav_listcontestant1->checkBoundries();
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
  .KT_col_contestant_num {width:70px; overflow:hidden;}
  .KT_col_municipality {width:140px; overflow:hidden;}
  .KT_col_firstname {width:105px; overflow:hidden;}
  .KT_col_lastname {width:105px; overflow:hidden;}
  .KT_col_middlename {width:35px; overflow:hidden;}
</style>
</head>

<body>
<div class="KT_tng" id="listcontestant1">

  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      
 
      
      
<table cellpadding="2" cellspacing="0" class="KT_tngtable">
<thead>
  <tr>
    <th>Num</th>
    <th>&nbsp;Municipality&nbsp;</th>
    <?php do { ?>
    	<th>&nbsp;<?php echo $row_pre_cri['criteria_name']; ?>&nbsp;</th>
    <?php } while ($row_pre_cri = mysql_fetch_assoc($pre_cri)); ?>
    <th>&nbsp;</th>
  </tr>
 </thead>
  <tbody>
  <?php do {?>
    <tr>
      <td align="center"><?php echo $row_contestant['contestant_id']; ?></td>
      <td align="center"><?php echo $row_contestant['municipality']; ?></td>
      	<?php mysql_select_db($database_conn_mutya, $conn_mutya);
		$query_pre_scores = "SELECT score_id, contestant_id, criteria_id, rating FROM pre_scores where contestant_id=". $row_contestant['contestant_id'] . " order by criteria_id";
		//echo $query_pre_scores . "<br />";
		$pre_scores = mysql_query($query_pre_scores, $conn_mutya) or die(mysql_error());
		$row_pre_scores = mysql_fetch_assoc($pre_scores);
		$totalRows_pre_scores = mysql_num_rows($pre_scores); ?>
       <?php do { ?>
			<td align="center"><?php echo $row_pre_scores['rating']; ?></td>
	    <?php } while ($row_pre_scores = mysql_fetch_assoc($pre_scores)); ?>
     	<td align="center"><a class="KT_edit_link" href="preliminary_edit.php?contestant_id=<?php echo $row_contestant['contestant_id']; ?>&amp;KT_back=1"> Edit </a> </td>   
    </tr>
    <?php } while ($row_contestant = mysql_fetch_assoc($contestant)); ?>
   </tbody>
</table> 
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listcontestant1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
</div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>

</body>
</html>
<?php
mysql_free_result($contestant);

mysql_free_result($pre_cri);

mysql_free_result($pre_scores);
?>
