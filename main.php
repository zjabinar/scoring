<?php require_once('Connections/conn_mutya.php'); ?>
<?php
if (!isset($_REQUEST['judge_id']) or $_REQUEST['judge_id']==""){
	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/index.php");
	exit(0);
}
$curr_judge_id=$_REQUEST['judge_id'];
// Load the common classes
require_once('includes/common/KT_common.php');

// Load the required classes
require_once('includes/tfi/TFI.php');
require_once('includes/tso/TSO.php');
require_once('includes/nav/NAV.php');

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
$tfi_listrec_cons2 = new TFI_TableFilter($conn_conn_mutya, "tfi_listrec_cons2");
$tfi_listrec_cons2->addColumn("contestant_num", "NUMERIC_TYPE", "contestant_num", "=");
$tfi_listrec_cons2->addColumn("municipality", "STRING_TYPE", "municipality", "%");
$tfi_listrec_cons2->addColumn("rating", "NUMERIC_TYPE", "rating", "=");
$tfi_listrec_cons2->Execute();

// Sorter
$tso_listrec_cons2 = new TSO_TableSorter("rec_cons", "tso_listrec_cons2");
$tso_listrec_cons2->addColumn("contestant_num");
$tso_listrec_cons2->addColumn("municipality");
$tso_listrec_cons2->addColumn("rating");
$tso_listrec_cons2->setDefault("contestant_num");
$tso_listrec_cons2->Execute();

// Navigation
$nav_listrec_cons2 = new NAV_Regular("nav_listrec_cons2", "rec_cons", "", $_SERVER['PHP_SELF'], 30);

//NeXTenesio3 Special List Recordset
$maxRows_rec_cons = $_SESSION['max_rows_nav_listrec_cons2'];
$pageNum_rec_cons = 0;
if (isset($_GET['pageNum_rec_cons'])) {
  $pageNum_rec_cons = $_GET['pageNum_rec_cons'];
}
$startRow_rec_cons = $pageNum_rec_cons * $maxRows_rec_cons;

// Defining List Recordset variable
$NXTFilter_rec_cons = "1=1";
if (isset($_SESSION['filter_tfi_listrec_cons2'])) {
  $NXTFilter_rec_cons = $_SESSION['filter_tfi_listrec_cons2'];
}
// Defining List Recordset variable
$NXTSort_rec_cons = "contestant_num";
if (isset($_SESSION['sorter_tso_listrec_cons2'])) {
  $NXTSort_rec_cons = $_SESSION['sorter_tso_listrec_cons2'];
}
mysql_select_db($database_conn_mutya, $conn_mutya);
$query_rec_cri_flag = "SELECT used_id, criteria_id, status_id, active_cons FROM criteria_flag";
$rec_cri_flag = mysql_query($query_rec_cri_flag, $conn_mutya) or die(mysql_error());
$row_rec_cri_flag = mysql_fetch_assoc($rec_cri_flag);
$totalRows_rec_cri_flag = mysql_num_rows($rec_cri_flag);

$status_id = $row_rec_cri_flag['status_id'];
$active_cons = $row_rec_cri_flag['active_cons'];

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_rec_judges = "SELECT judgeid, account, password, firstname, lastname, middlename, sex, profession, company_name, company_address FROM judges where judgeid=".$curr_judge_id;
$rec_judges = mysql_query($query_rec_judges, $conn_mutya) or die(mysql_error());
$row_rec_judges = mysql_fetch_assoc($rec_judges);
$totalRows_rec_judges = mysql_num_rows($rec_judges);
$fullname=$row_rec_judges['lastname'] . ",  " . $row_rec_judges['firstname'];

if ($row_rec_cri_flag['used_id']==1) {
	$table_score="semi_score";
}elseif ($row_rec_cri_flag['used_id']==2){
	$table_score="final_score";
}

if ($status_id==1) {
	$cons_id = $active_cons;
}else{
	if(!$_REQUEST['contestant_id']){
		$cons_id="1";
	}else{
		$cons_id=$_REQUEST['contestant_id'];
	}
}


if ($_POST['btnSubmit'] or $_POST['btnSubmit'] <> NULL){
	if ($row_rec_cri_flag['used_id']==1) {
		if($_POST['rating']){
			$rating=$_POST['rating'];
			$sql_rating = "UPDATE semi_scores set rating=".$rating. " where judge_id=".$curr_judge_id." and contestant_id=" .$cons_id. " and criteria_id=" . $row_rec_cri_flag['criteria_id'];
			mysql_query($sql_rating);
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/main.php?judge_id=".$curr_judge_id . "&contestant_id=".$cons_id);
			exit(0);
		}
	}else{
		if($_POST['rating']){
			$rating=$_POST['rating'];
			$sql_rating = "UPDATE final_scores set rating=".$rating. " where judge_id=".$curr_judge_id." and contestant_id=" .$cons_id. " and criteria_id=" . $row_rec_cri_flag['criteria_id'];
			mysql_query($sql_rating);
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/main.php?judge_id=".$curr_judge_id . "&contestant_id=".$cons_id);
			exit(0);
		}
	}
}


if ($status_id==1) { // controlled rating
	mysql_select_db($database_conn_mutya, $conn_mutya);
	$cons = "SELECT contestant_id, contestant_num, firstname, lastname, middlename, birthdate, municipality, address, photo1, photo2, photo3, photo4, photo5 FROM contestants where contestant_id=".$active_cons;
	$cons_rec = mysql_query($cons, $conn_mutya) or die(mysql_error());
	$cons_row = mysql_fetch_assoc($cons_rec);
	$cons_total = mysql_num_rows($cons_rec);
}else{ //allow judges
	mysql_select_db($database_conn_mutya, $conn_mutya);
	$cons = "SELECT contestant_id, contestant_num, firstname, lastname, middlename, birthdate, municipality, address, photo1, photo2, photo3, photo4, photo5 FROM contestants where contestant_id=".$cons_id;
	$cons_rec = mysql_query($cons, $conn_mutya) or die(mysql_error());
	$cons_row = mysql_fetch_assoc($cons_rec);
	$cons_total = mysql_num_rows($cons_rec);
}




if ($row_rec_cri_flag['used_id']==1) {
	$query_rec_cons = "SELECT semi_scores.judge_id, judges.account, semi_scores.contestant_id, contestants.contestant_num, contestants.firstname, contestants.lastname, contestants.middlename, contestants.municipality, semi_scores.criteria_id, semi_criteria.criteria_name, semi_scores.rating FROM contestants RIGHT JOIN (semi_criteria RIGHT JOIN (judges RIGHT JOIN semi_scores ON judges.judgeid = semi_scores.judge_id) ON semi_criteria.criteria_id = semi_scores.criteria_id) ON contestants.contestant_id = semi_scores.contestant_id WHERE semi_scores.judge_id=" . $curr_judge_id . " and semi_scores.criteria_id=" . $row_rec_cri_flag['criteria_id'] . " ORDER BY  {$NXTSort_rec_cons} ";
	$query_limit_rec_cons = sprintf("%s LIMIT %d, %d", $query_rec_cons, $startRow_rec_cons, $maxRows_rec_cons);
	$rec_cons = mysql_query($query_limit_rec_cons, $conn_mutya) or die(mysql_error());
	$row_rec_cons = mysql_fetch_assoc($rec_cons);
	$cri_name=$row_rec_cons['criteria_name'];
}else{
	$query_rec_cons = "SELECT final_scores.judge_id, judges.account, final_scores.contestant_id, contestants.contestant_num, contestants.firstname, contestants.lastname, contestants.middlename, contestants.municipality, contestants.finalist, final_scores.criteria_id, criteria_name, final_scores.rating FROM contestants RIGHT JOIN (final_criteria RIGHT JOIN (judges RIGHT JOIN final_scores ON judges.judgeid = final_scores.judge_id) ON final_criteria.criteria_id = final_scores.criteria_id) ON contestants.contestant_id = final_scores.contestant_id WHERE final_scores.judge_id=" . $curr_judge_id . " and final_scores.criteria_id=" . $row_rec_cri_flag['criteria_id'] . " and contestants.finalist=1 ORDER BY  {$NXTSort_rec_cons} ";
	$query_limit_rec_cons = sprintf("%s LIMIT %d, %d", $query_rec_cons, $startRow_rec_cons, $maxRows_rec_cons);
	$rec_cons = mysql_query($query_limit_rec_cons, $conn_mutya) or die(mysql_error());
	$row_rec_cons = mysql_fetch_assoc($rec_cons);
	$cri_name=$row_rec_cons['criteria_name'];
}



if (isset($_GET['totalRows_rec_cons'])) {
  $totalRows_rec_cons = $_GET['totalRows_rec_cons'];
} else {
  $all_rec_cons = mysql_query($query_rec_cons);
  $totalRows_rec_cons = mysql_num_rows($all_rec_cons);
}
$totalPages_rec_cons = ceil($totalRows_rec_cons/$maxRows_rec_cons)-1;
//End NeXTenesio3 Special List Recordset



$nav_listrec_cons2->checkBoundries();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<META HTTP-EQUIV="refresh" CONTENT="15" />
<title>Miss Manaragat 2012</title>
<!--Beginning for zpforms-->
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8" />
<script type="text/javascript" src="js/zpform/utils/transport.js"></script>
<script type='text/javascript' src='js/zpform/utils/utils.js'></script>
<script type='text/javascript' src='js/zpform/src/form.js'></script>
<link href="js/zpform/themes/winxp.css" rel="stylesheet" type="text/css" />
<link href="js/zpform/website/css/zpcal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	<!--
	.zpIsEditing .zpNotEmpty span.zpStatusImg {
		 background-image: url(js/zpform/src/editing.gif);
		}
	-->
	</style>
<!--End for zpforms-->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/interface.js"></script>
<!--[if lt IE 7]>
 <style type="text/css">
 div, img { behavior: url(iepngfix.htc) }
 </style>
<![endif]-->
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script src="includes/skins/style.js" type="text/javascript"></script>
<script src="includes/nxt/scripts/list.js" type="text/javascript"></script>
<script src="includes/nxt/scripts/list.js.php" type="text/javascript"></script>
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
  .KT_col_contestant_num {
	width:35px;
	overflow:hidden;
}
  .KT_col_municipality {
	width:170px;
	overflow:hidden;
}
  .KT_col_rating {
	width:190px;
	overflow:hidden;
}
.style2 {font-size: 14px}
.style3 {color: #FFFFFF}
</style>
<style type="text/css" media="screen">
<!--
@import url("p7tp/p7tp_01.css");
.style5 {font-size: 12px}
.style6 {font-size: 26px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#003399; font-weight:200}
-->
</style>
<script type="text/javascript" src="p7tp/p7tpscripts.js"></script>
</head>
<body onload="P7_initTP(1,0)" link="#FFFFFF3" vlink="#FFFFFF" alink="#FFFFFF">

<!-- fisheye menu
<div class="dock" id="dock">
  <div class="dock-container">
  <a class="dock-item" href="main.php?judge_id=<?php //echo $curr_judge_id; ?>"><img src="images/rating.png" alt="Rating" /><span>Rating</span></a> 
  <a class="dock-item" href="gallery.php?judge_id=<?php //echo $curr_judge_id; ?>"><img src="images/gallery.png" alt="Gallery" /><span>Gallery</span></a>  
  <a class="dock-item" href="help.php?judge_id=<?php //echo $curr_judge_id; ?>"><img src="images/help.png" alt="Help" /><span>Help</span></a> 
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
--> 
<div  style="position:absolute; color:#FFFFFF; font-size:18px; width:484px; height:30px; z-index:100; left: 23px; top: 135px; overflow: hidden; clip: rect(0px 298px 288px 0px); visibility: visible; border: 0px none #000000"><?php echo $cri_name; ?> Competition</div>
  
<div align="right"  style="position:absolute; color:#FFFFFF; font-size:18px; width:251px; height:30px; z-index:100; left: 709px; top: 135px; overflow: hidden; clip: rect(0px 298px 288px 0px); visibility: visible; border: 0px none #000000";>
  <?php echo $fullname; ?>&nbsp;&nbsp;[<a href="index.php">Logout</a>]</div>
<br /><br /><br />
<table border="0" width="480" align="center"><tr><td align="center"><img src="images/mutya_txt.png" /></td></tr></table>
<br /><br />
 <!-- end -->
<table width="950" height="480" border="0" align="center">
  <tr>
    <td width="500" rowspan="2" valign="top" align="left">
      <div class="KT_tng" id="listrec_cons2">
        <div class="KT_tnglist">
          <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
            <table cellpadding="2" cellspacing="0" class="KT_tngtable">
              <thead>
                <tr class="KT_row_order" bgcolor="#000033">
                  <td bgcolor="#333333">&nbsp;                  </td>
                  <td bgcolor="#333333" class="style3" id="contestant_num">Cons.</td>
                  <td bgcolor="#333333" class="style3" id="municipality">Contestant Name </td>
                  <td bgcolor="#333333" class="style3" id="rating">Rating</td>
                  <td bgcolor="#333333">&nbsp;</td>
                </tr>
              </thead>
              <tbody>
                <?php if ($totalRows_rec_cons == 0) { // Show if recordset empty ?>
                  <tr>
                    <td colspan="5"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                  </tr>
                  <?php } // Show if recordset empty ?>
                <?php if ($totalRows_rec_cons > 0) { // Show if recordset not empty ?>
                  <?php do { ?>
                    <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                      <td>
                          <input name="contestant_id" type="hidden" class="id_field " value="<?php echo $row_rec_cons['contestant_id']; ?>" />                      </td>
                      <td><div class="KT_col_contestant_num style2"><?php echo KT_FormatForList($row_rec_cons['contestant_num'], 5); ?></div></td>
                      <td><div class="KT_col_municipality"><?php echo KT_FormatForList($row_rec_cons['firstname'] . ' ' . $row_rec_cons['lastname'], 30); ?></div></td>
          
                      <td><div class="KT_col_rating"><?php if ($row_rec_cons['rating']>0) {echo KT_FormatForList($row_rec_cons['rating'], 30); }else{ echo "&nbsp;";} ?>&nbsp;&nbsp;<?php if ($row_rec_cons['rating']<>100){ echo '&nbsp;&nbsp;'; }?>
                      <?php if ($row_rec_cons['rating']<>0) { // not 0 rating ?>
                      	<img src="images/chart.jpg" height="8" width="<?php echo (($row_rec_cons['rating']) * 15); ?>" />
                       <?php } ?>
                      </div></td>
                      <td>
                      <?php if ($status_id==1) { //  controlled rating?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <?php }else{ // allow judges ?>
                          	<a class="KT_edit_link" href="main.php?judge_id=<?php echo $curr_judge_id; ?>&amp;contestant_id=<?php echo $row_rec_cons['contestant_id']; ?>&amp;KT_back=1&amp;rating=<?php echo $row_rec_cons['rating']; ?>"><?php if ($row_rec_cons['rating']>0) { echo "Change"; }else{ echo "Rate"; }?></a> 
                      <?Php } ?>
                      
                      </td>
                    </tr>
                    <?php } while ($row_rec_cons = mysql_fetch_assoc($rec_cons)); ?>
                  <?php } // Show if recordset not empty ?>
              </tbody>
            </table>
      <div class="KT_bottomnavaaa">
                <?php
            $nav_listrec_cons2->Prepare();
            require("includes/nav/NAV_Text_Navigation_no.inc.php");
          ?>
            </div>
            <div class="KT_bottombuttonsaaa">
</div>
          </form>
        </div>
        <br class="clearfixplain" />
      </div>
</td>
    <td width="450" height="350" valign="top">
            <form enctype="" action="" name="mainform" id='userForm' method="post"  style='text-align:left '>
              <div class="zpFormContent">
                  <table width="100%" border="0">
                    <tr>
                      <td colspan="3"><table border="0" width="100%"><tr><td width="175" rowspan="9"><?php echo "<img src=\"pictures/".$cons_row['photo1'].".jpg\"></img>"; ?></td>
                        <td width="79" height="31"><span class="style5">&nbsp;&nbsp;Cons. #:</span></td>
                            <td width="172"><span class="style5"><?php echo $cons_row['contestant_num'];?></span></td>
                      </tr>
                          <tr>
                            <td height="27"><span class="style5">&nbsp;&nbsp;Cluster #.:</span></td>
                            <td height="27"><span class="style5"><?php echo $cons_row['municipality'];?></span></td>
                        </tr>
                          <tr>
                            <td height="25"><span class="style5">&nbsp;&nbsp;Firstname:</span></td>
                            <td height="25"><span class="style5"><?php echo $cons_row['firstname'] ;?></span></td>
                        </tr>
                          <tr>
                            <td height="28"><span class="style5">&nbsp;&nbsp;Lastname:</span></td>
                            <td height="28"><span class="style5"><?php echo $cons_row['lastname'] ;?></span></td>
                        </tr>
                          <tr>
                            <td height="23"><span class="style5">&nbsp;&nbsp;M.I.:</span></td>
                            <td height="23"><span class="style5"><?php echo $cons_row['middlename'] ;?></span></td>
                        </tr>
                          <tr>
                            <td height="23"><span class="style5">&nbsp;&nbsp;Birthdate:</span></td>
                            <td height="23"><span class="style5"><?php echo $cons_row['birthdate'] ;?></span></td>
                        </tr>
                        <tr>
                          <td height="45" colspan="2" align="center" valign="bottom"><span class="style6">&nbsp;Score:</span></td>
                        </tr>
                        <tr>
                          <td height="30" colspan="2" align="center" valign="bottom"><input value="" size="10" name="rating" type="text" />&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="18%" colspan="2" align="center" valign="middle">
                            <input value="RATE" name="btnSubmit" type="submit" class="button" onclick="return OnSubmit()" /></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
              </div>
              
              <div class="zpFormButtons">
                <!--<input value="RATE" name="btnSubmit" type="submit" class="button" onClick="return OnSubmit()" />-->
              </div>
             
            </form>
</td>
  </tr>
<!-- reserved box for messages -->
  <tr>
    <td height="100">&nbsp;</td>
  </tr>
 <!-- end -->
</table>

</body>
</html>
<!-- Beginning Script for zpforms-->
<script type="text/javascript">
function testErrOutput(objErrors){
	var message = objErrors.generalError + '<br />';
	
	if (objErrors.fieldErrors) {
		for (var ii = 0; ii < objErrors.fieldErrors.length; ii++)
				message += (ii + 1) + ': Field "' + objErrors.fieldErrors[ii].field.name + '" ' + objErrors.fieldErrors[ii].errorMessage + "<br />";
	}
	
	var outputDiv = document.getElementById("errOutput");

	if(outputDiv != null){
		//outputDiv.innerHTML = message;
		//outputDiv.style.display = "block";
	}
}

function myOnSuccess() {
	alert('Success!');
};

function OnSubmit()
{
	var score,test;
	score = document.mainform.rating.value;
	//test=10*score;
	test=score/1;
	if (!test){
		window.alert( "Score should be " + 3 + " to " + 10 );
		return false;
	}
	if (test==0) {
		window.alert( "Score should be " + 3 + " to " + 10 );
		return false;
	} else if( (score < 3) || (10 < score) ) {
		window.alert( "Score should be " + 3 + " to " + 10 );
	} else if( window.confirm( "Your entered the score of " + score + ". Please confirm." ) ) {
		return true;
	}
	return false;
}

// Run this to auto-activate all "zpForm" class forms in the document.
new Zapatec.Form('userForm', {
	showErrors: 'afterField',
	showErrorsOnSubmit: true,
	submitErrorFunc: testErrOutput,
	theme: "winxp"
});
</script>
<!-- End Script for zpforms-->
<?php
mysql_free_result($rec_cons);
mysql_free_result($rec_cri_flag);
mysql_free_result($rec_judges);
?>