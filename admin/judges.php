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
$tfi_listrec_judges2 = new TFI_TableFilter($conn_conn_mutya, "tfi_listrec_judges2");
$tfi_listrec_judges2->addColumn("account", "STRING_TYPE", "account", "%");
$tfi_listrec_judges2->addColumn("password", "STRING_TYPE", "password", "%");
$tfi_listrec_judges2->addColumn("firstname", "STRING_TYPE", "firstname", "%");
$tfi_listrec_judges2->addColumn("lastname", "STRING_TYPE", "lastname", "%");
$tfi_listrec_judges2->addColumn("middlename", "STRING_TYPE", "middlename", "%");
$tfi_listrec_judges2->addColumn("sex", "STRING_TYPE", "sex", "%");
$tfi_listrec_judges2->addColumn("profession", "STRING_TYPE", "profession", "%");
$tfi_listrec_judges2->Execute();

// Sorter
$tso_listrec_judges2 = new TSO_TableSorter("rec_judges", "tso_listrec_judges2");
$tso_listrec_judges2->addColumn("account");
$tso_listrec_judges2->addColumn("password");
$tso_listrec_judges2->addColumn("firstname");
$tso_listrec_judges2->addColumn("lastname");
$tso_listrec_judges2->addColumn("middlename");
$tso_listrec_judges2->addColumn("sex");
$tso_listrec_judges2->addColumn("profession");
$tso_listrec_judges2->setDefault("account");
$tso_listrec_judges2->Execute();

// Navigation
$nav_listrec_judges2 = new NAV_Regular("nav_listrec_judges2", "rec_judges", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rec_judges = $_SESSION['max_rows_nav_listrec_judges2'];
$pageNum_rec_judges = 0;
if (isset($_GET['pageNum_rec_judges'])) {
  $pageNum_rec_judges = $_GET['pageNum_rec_judges'];
}
$startRow_rec_judges = $pageNum_rec_judges * $maxRows_rec_judges;

// Defining List Recordset variable
$NXTFilter_rec_judges = "1=1";
if (isset($_SESSION['filter_tfi_listrec_judges2'])) {
  $NXTFilter_rec_judges = $_SESSION['filter_tfi_listrec_judges2'];
}
// Defining List Recordset variable
$NXTSort_rec_judges = "account";
if (isset($_SESSION['sorter_tso_listrec_judges2'])) {
  $NXTSort_rec_judges = $_SESSION['sorter_tso_listrec_judges2'];
}
mysql_select_db($database_conn_mutya, $conn_mutya);

$query_rec_judges = "SELECT * FROM judges WHERE  {$NXTFilter_rec_judges}  ORDER BY  {$NXTSort_rec_judges} ";
$query_limit_rec_judges = sprintf("%s LIMIT %d, %d", $query_rec_judges, $startRow_rec_judges, $maxRows_rec_judges);
$rec_judges = mysql_query($query_limit_rec_judges, $conn_mutya) or die(mysql_error());
$row_rec_judges = mysql_fetch_assoc($rec_judges);

if (isset($_GET['totalRows_rec_judges'])) {
  $totalRows_rec_judges = $_GET['totalRows_rec_judges'];
} else {
  $all_rec_judges = mysql_query($query_rec_judges);
  $totalRows_rec_judges = mysql_num_rows($all_rec_judges);
}
$totalPages_rec_judges = ceil($totalRows_rec_judges/$maxRows_rec_judges)-1;
//End NeXTenesio3 Special List Recordset

//mysql_select_db($database_conn_mutya, $conn_mutya);
//$query_rec_semi_scores = "SELECT score_id, judge_id, contestant_id, criteria_id, rating FROM semi_scores";
//$rec_semi_scores = mysql_query($query_rec_semi_scores, $conn_mutya) or die(mysql_error());
//$row_rec_semi_scores = mysql_fetch_assoc($rec_semi_scores);
//$totalRows_rec_semi_scores = mysql_num_rows($rec_semi_scores);

//mysql_select_db($database_conn_mutya, $conn_mutya);
//$query_rec_final_scores = "SELECT score_id, judge_id, contestant_id, criteria_id, rating FROM final_scores";
//$rec_final_scores = mysql_query($query_rec_final_scores, $conn_mutya) or die(mysql_error());
//$row_rec_final_scores = mysql_fetch_assoc($rec_final_scores);
//$totalRows_rec_final_scores = mysql_num_rows($rec_final_scores);

//mysql_select_db($database_conn_mutya, $conn_mutya);
//$query_rec_contestants = "SELECT contestant_id, contestant_num, firstname, lastname FROM contestants";
//$rec_contestants = mysql_query($query_rec_contestants, $conn_mutya) or die(mysql_error());
//$row_rec_contestants = mysql_fetch_assoc($rec_contestants);
//$totalRows_rec_contestants = mysql_num_rows($rec_contestants);

$nav_listrec_judges2->checkBoundries();
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
  .KT_col_account {width:84px; overflow:hidden;}
  .KT_col_password {width:84px; overflow:hidden;}
  .KT_col_firstname {width:105px; overflow:hidden;}
  .KT_col_lastname {width:105px; overflow:hidden;}
  .KT_col_middlename {width:56px; overflow:hidden;}
  .KT_col_sex {width:56px; overflow:hidden;}
  .KT_col_profession {width:105px; overflow:hidden;}
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
<table width="800" border="0" align="center">
  <tr>
    <td>&nbsp;
      <div class="KT_tng" id="listrec_judges2">
        <div class="KT_tnglist">
          <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
            <table cellpadding="2" cellspacing="0" class="KT_tngtable">
              <thead>
                <tr class="KT_row_order">
                  <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
                  </th>
                  <th>Account </th>
                  <th>Password </th>
                  <th>Firstname</th>
                  <th>Lastname </th>
                  <th>Middlename </th>
                  <th>Sex</th>
                  <th>Profession </th>
                  <th>&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($totalRows_rec_judges == 0) { // Show if recordset empty ?>
                  <tr>
                    <td colspan="9"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                  </tr>
                  <?php } // Show if recordset empty ?>
                <?php if ($totalRows_rec_judges > 0) { // Show if recordset not empty ?>
                  <?php do { ?>
                  	<!-- php code to check judges id if already has value in semi_scores table and add if has not-->
                    <?php
					mysql_select_db($database_conn_mutya, $conn_mutya);
					$query_rec_semi_scores = "SELECT score_id, judge_id, contestant_id, criteria_id, rating FROM semi_scores where judge_id=". $row_rec_judges['judgeid'];
					$rec_semi_scores = mysql_query($query_rec_semi_scores, $conn_mutya) or die(mysql_error());
					$row_rec_semi_scores = mysql_fetch_assoc($rec_semi_scores);
					$totalRows_rec_semi_scores = mysql_num_rows($rec_semi_scores);
					
					if ($row_rec_semi_scores<=0) {
						mysql_select_db($database_conn_mutya, $conn_mutya);
						$query_rec_contestants = "SELECT contestant_id, contestant_num, firstname, lastname FROM contestants";
						$rec_contestants = mysql_query($query_rec_contestants, $conn_mutya) or die(mysql_error());
						$row_rec_contestants = mysql_fetch_assoc($rec_contestants);

						$cons = 'SELECT contestant_id FROM contestants';
						$res_cons = mysql_query($cons) or die('Query failed: ' . mysql_error());
						while ($line = mysql_fetch_array($res_cons, MYSQL_ASSOC)) {
							foreach ($line as $cons_id) {
								$cri = 'SELECT criteria_id FROM semi_criteria';
								$res_cri = mysql_query($cri) or die('Query failed: ' . mysql_error());
								while ($line = mysql_fetch_array($res_cri, MYSQL_ASSOC)) {
									foreach ($line as $cri_id) {
										//echo $row_rec_judges['judgeid'] . "-" . $cons_id . "-" . $cri_id. " <br />";
										$sql_ins = "insert into semi_scores (judge_id,contestant_id,criteria_id,rating) values (".$row_rec_judges['judgeid'] . "," . $cons_id . "," . $cri_id . ",0)";
										mysql_query($sql_ins);
										//echo $sql_ins . "<br />";
									}
								}
							}
						}
					}
					?>
                    <!-- end of codes -->
                    
                  	<!-- php code to check judges id if already has value in final_scores table and add if has not-->
                    <?php
					mysql_select_db($database_conn_mutya, $conn_mutya);
					$query_rec_final_scores = "SELECT score_id, judge_id, contestant_id, criteria_id, rating FROM final_scores where judge_id=". $row_rec_judges['judgeid'];
					$rec_final_scores = mysql_query($query_rec_final_scores, $conn_mutya) or die(mysql_error());
					$row_rec_final_scores = mysql_fetch_assoc($rec_final_scores);
					$totalRows_rec_final_scores = mysql_num_rows($rec_final_scores);
					
					if ($row_rec_final_scores<=0) {
						mysql_select_db($database_conn_mutya, $conn_mutya);
						$query_rec_contestants = "SELECT contestant_id, contestant_num, firstname, lastname FROM contestants";
						$rec_contestants = mysql_query($query_rec_contestants, $conn_mutya) or die(mysql_error());
						$row_rec_contestants = mysql_fetch_assoc($rec_contestants);

						$cons = 'SELECT contestant_id FROM contestants';
						$res_cons = mysql_query($cons) or die('Query failed: ' . mysql_error());
						while ($line = mysql_fetch_array($res_cons, MYSQL_ASSOC)) {
							foreach ($line as $cons_id) {
								$cri = 'SELECT criteria_id FROM final_criteria';
								$res_cri = mysql_query($cri) or die('Query failed: ' . mysql_error());
								while ($line = mysql_fetch_array($res_cri, MYSQL_ASSOC)) {
									foreach ($line as $cri_id) {
										//echo $row_rec_judges['judgeid'] . "-" . $cons_id . "-" . $cri_id. " <br />";
										$sql_ins = "insert into final_scores (judge_id,contestant_id,criteria_id,rating) values (".$row_rec_judges['judgeid'] . "," . $cons_id . "," . $cri_id . ",0)";
										mysql_query($sql_ins);
										//echo $sql_ins . "<br />";
									}
								}
							}
						}
					}
					?>
                    <!-- end of codes --> 
                  
                  
                    <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                      <td><input type="checkbox" name="kt_pk_judges" class="id_checkbox" value="<?php echo $row_rec_judges['judgeid']; ?>" />
                          <input type="hidden" name="judgeid" class="id_field" value="<?php echo $row_rec_judges['judgeid']; ?>" />
                      </td>
                      <td><div class="KT_col_account"><?php echo KT_FormatForList($row_rec_judges['account'], 12); ?></div></td>
                      <td><div class="KT_col_password"><?php echo KT_FormatForList($row_rec_judges['password'], 12); ?></div></td>
                      <td><div class="KT_col_firstname"><?php echo KT_FormatForList($row_rec_judges['firstname'], 15); ?></div></td>
                      <td><div class="KT_col_lastname"><?php echo KT_FormatForList($row_rec_judges['lastname'], 15); ?></div></td>
                      <td><div class="KT_col_middlename"><?php echo KT_FormatForList($row_rec_judges['middlename'], 8); ?></div></td>
                      <td><div class="KT_col_sex"><?php echo KT_FormatForList($row_rec_judges['sex'], 8); ?></div></td>
                      <td><div class="KT_col_profession"><?php echo KT_FormatForList($row_rec_judges['profession'], 15); ?></div></td>
                      <td><a class="KT_edit_link" href="judges_edit.php?judgeid=<?php echo $row_rec_judges['judgeid']; ?>&amp;KT_back=1&amp;admin_id="<?php echo $curr_admin_id; ?>"><?php echo NXT_getResource("edit_one"); ?></a> 
                      <a class="KT_edit_link"  href="judges_delete.php?judgeid=<?php echo $row_rec_judges['judgeid']; ?>&amp;KT_back=1&amp;admin_id="<?php echo $curr_admin_id; ?>"><?php echo NXT_getResource("delete_one"); ?></a> </td>
                    </tr>
                    <?php } while ($row_rec_judges = mysql_fetch_assoc($rec_judges)); ?>
                  <?php } // Show if recordset not empty ?>
              </tbody>
            </table>
            <div class="KT_bottomnav">
              <div>
                <?php
            $nav_listrec_judges2->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
              </div>
            </div>
            <div class="KT_bottombuttons">
              <a class="KT_additem_op_link" href="judges_add.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
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
mysql_free_result($rec_judges);

mysql_free_result($rec_semi_scores);

mysql_free_result($rec_final_scores);

mysql_free_result($rec_contestants);
?>