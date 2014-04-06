<?php require_once('../Connections/conn_mutya.php'); ?>
<?php
//if (!isset($_REQUEST['admin_id']) or $_REQUEST['admin_id']==""){
//	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/index.php");
//	exit(0);
//}
$curr_admin_id=$_REQUEST['admin_id'];

if ($_POST['btnpre']){
	if ($_POST['rpt_pre']) {
		header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/report_preliminary.php?criteria_id=". $_POST['rpt_pre']);
		exit(0);
	}
}
if ($_POST['btnsemi']){
	if ($_POST['rpt_semi']) {
		header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/report_semifinal_criteria.php?criteria_id=". $_POST['rpt_semi']);
		exit(0);
	}
}
if ($_POST['btnfinal']){
	if ($_POST['rpt_final']) {
		header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/report_final_criteria.php?criteria_id=". $_POST['rpt_final']);
		exit(0);
	}
}

if ($_POST['btnresult']){
	if ($_POST['rpt_result']) {
		if ($_POST['rpt_result']==1) {
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/report_semi_finalist.php");
			exit(0);
		}elseif ($_POST['rpt_result']==2) {
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/report_semi_finalist_all.php");
			exit(0);
		}elseif ($_POST['rpt_result']==3) {
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/report_finalist.php");
			exit(0);
		}elseif ($_POST['rpt_result']==4) {
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/report_finalist_all.php");
			exit(0);
		}elseif ($_POST['rpt_result']==5) {
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/report_preliminary_all.php");
			exit(0);
		}
	}
}

if ($_POST['btnSet'] or $_POST['btnSet'] <> NULL){
		if($_POST['status_id']){
			$status_id=$_POST['status_id'];
			$active_cons=$_POST['active_cons'];
			$sql_setting = "UPDATE criteria_flag set status_id=".$status_id. ", active_cons=".$active_cons;
			echo $sql_setting;
			mysql_query($sql_setting);
			header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/control_window.php?admin_id=".$curr_admin_id);
			exit(0);
		}
}

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
$query_setting = "SELECT active_id, used_id, criteria_id, status_id, active_cons FROM criteria_flag";
$setting = mysql_query($query_setting, $conn_mutya) or die(mysql_error());
$row_setting = mysql_fetch_assoc($setting);
$totalRows_setting = mysql_num_rows($setting);

mysql_select_db($database_conn_mutya, $conn_mutya);
if ($row_setting['used_id']==1){
	$query_rec_cri = "SELECT criteria_id, criteria_name FROM semi_criteria where criteria_id=". $row_setting['criteria_id'];
}else{
	$query_rec_cri = "SELECT criteria_id, criteria_name FROM final_criteria where criteria_id=". $row_setting['criteria_id'];
}
$rec_cri = mysql_query($query_rec_cri, $conn_mutya) or die(mysql_error());
$row_rec_cri = mysql_fetch_assoc($rec_cri);
$totalRows_rec_cri = mysql_num_rows($rec_cri);

if ($row_setting['used_id']==1){
	mysql_select_db($database_conn_mutya, $conn_mutya);
	$query_contestants = "SELECT contestant_id, contestant_num, firstname, lastname, middlename, birthdate, municipality, address, finalist FROM contestants";
	$contestants = mysql_query($query_contestants, $conn_mutya) or die(mysql_error());
	$row_contestants = mysql_fetch_assoc($contestants);
	$totalRows_contestants = mysql_num_rows($contestants);
}else{
	mysql_select_db($database_conn_mutya, $conn_mutya);
	$query_contestants = "SELECT contestant_id, contestant_num, firstname, lastname, middlename, birthdate, municipality, address, finalist FROM contestants where finalist=1";
	$contestants = mysql_query($query_contestants, $conn_mutya) or die(mysql_error());
	$row_contestants = mysql_fetch_assoc($contestants);
	$totalRows_contestants = mysql_num_rows($contestants);

//mysql_select_db($database_conn_mutya, $conn_mutya);
//$query_pre_criteria = "SELECT criteria_id, criteria_name FROM pre_criteria";
//$pre_criteria = mysql_query($query_pre_criteria, $conn_mutya) or die(mysql_error());
//$row_pre_criteria = mysql_fetch_assoc($pre_criteria);
//$totalRows_pre_criteria = mysql_num_rows($pre_criteria);

//mysql_select_db($database_conn_mutya, $conn_mutya);
//$query_semi_criteria = "SELECT criteria_id, criteria_name FROM semi_criteria";
//$semi_criteria = mysql_query($query_semi_criteria, $conn_mutya) or die(mysql_error());
//$row_semi_criteria = mysql_fetch_assoc($semi_criteria);
//$totalRows_semi_criteria = mysql_num_rows($semi_criteria);

//mysql_select_db($database_conn_mutya, $conn_mutya);
//$query_final_criteria = "SELECT criteria_id, criteria_name FROM final_criteria";
//$final_criteria = mysql_query($query_final_criteria, $conn_mutya) or die(mysql_error());
//$row_final_criteria = mysql_fetch_assoc($final_criteria);
//$totalRows_final_criteria = mysql_num_rows($final_criteria);
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Miss Manaragat 2012</title>
	<!--Beginning for zpforms-->
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<script type="text/javascript" src="js/zpform/utils/transport.js"></script>
    <script type='text/javascript' src='js/zpform/utils/utils.js'></script>
    <script type='text/javascript' src='js/zpform/src/form.js'></script>
	<link href="js/zpform/themes/winxp.css" rel="stylesheet" type="text/css">
	<link href="js/zpform/website/css/zpcal.css" rel="stylesheet" type="text/css">
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
<link href="p7ap/p7ap_01.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="p7ap/p7APscripts.js"></script>
<style type="text/css" media="screen">
<!--
@import url("p7tp/p7tp_07.css");
.style3 {font-size: 14px}
-->
</style>
<script type="text/javascript" src="p7tp/p7tpscripts.js"></script>
</head>
<body onload="P7_initTP(7,1)">
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

<table width="950" height="460" border="0" align="center">
  <tr>
    <td width="630" rowspan="3" align="center" height="100%" valign="top"><div id="p7ABW1" class="p7AB">
      <div class="p7ABtrig">
        <h3><a href="javascript:;" id="p7ABt1_1">Rating Window</a></h3>
      </div>
      <div id="p7ABw1_1">
        <div id="p7ABc1_1" class="p7ABcontent">
          <iframe scrolling="auto" width="580" height="370" frameborder="0" src="score_board.php" align="middle"></iframe>
        </div>
      </div>
      <div class="p7ABtrig">
        <h3><a href="javascript:;" id="p7ABt1_2">Activiate Criteria</a></h3>
      </div>
      <div id="p7ABw1_2">
        <div id="p7ABc1_2" class="p7ABcontent">
          <iframe scrolling="no" width="470" height="335" frameborder="0" src="set_criteria.php"></iframe>
        </div>
      </div>
      <div class="p7ABtrig">
        <h3><a href="javascript:;" id="p7ABt1_3">Finalist</a></h3>
      </div>
      <div id="p7ABw1_3">
        <div id="p7ABc1_3" class="p7ABcontent">
          <iframe scrolling="no" width="490" height="350" frameborder="0" src="finalist.php"></iframe>
        </div>
      </div>
      <div class="p7ABtrig">
        <h3><a href="javascript:;" id="p7ABt1_4">Preliminary Scores</a></h3>
      </div>
      <div id="p7ABw1_4">
        <div id="p7ABc1_4" class="p7ABcontent">
          <iframe scrolling="no" width="540" height="370" frameborder="0" src="preliminary.php" align="middle"></iframe>
        </div>
      </div>
      <script type="text/javascript">
<!--
P7_opAB(1,1,1,1,1);
//-->
      </script>
</div></td>
    <td height="45%" valign="top"><div id="p7TP1" class="p7TPpanel">
      <div class="p7TPheader">
        <h3>Panel</h3>
      </div>
      <div class="p7TPwrapper">
        <div class="p7TP_tabs">
          <div id="p7tpb1_1" class="down"><a class="down" href="javascript:;">Setting</a></div>
          <div id="p7tpb1_2"><a href="javascript:;">Scores</a></div>
          <div id="p7tpb1_3"><a href="javascript:;">Reports</a></div>
          <br class="p7TPclear" />
        </div>
        <div class="p7TPcontent">
          <div id="p7tpc1_1">
            <fieldset>
            <legend>Contest Settings</legend>
              <form enctype="" action="" method="post">
              <table border="0" width="100%">
                <tr>
                  <td><span class="style3">Category:</span></td>
                  <td><span class="style3">
                    <?php   
			
			if ($row_setting['used_id']==1){
				echo "Semi Finals";
			}else{
				echo "Finals";
			}
			
			?>
                  </span></td>
                </tr>
                <tr>
                  <td><span class="style3">Criteria:</span></td>
                  <td><span class="style3"><?php echo $row_rec_cri['criteria_name']; ?></span></td>
                </tr>
                <tr>
                  <td><span class="style3">Status:</span></td>
                  <td><label>
                    <select name="status_id" id="status_id">
                      <option value="1" <?php if ($row_setting['status_id']==1){ echo 'selected="selected" SELECTED';} ?>  >Controled Rating</option>
                      <option value="2" <?php if ($row_setting['status_id']==2){ echo 'selected="selected" SELECTED';} ?> >Allow Judges</option>
                    </select>
                  </label></td>
                </tr>
                <tr>
                  <td><span class="style3">Contestants:</span></td>
                  <td><select name="active_cons" id="active_cons">
                      <?php
do {  
?>
                      <option value="<?php echo $row_contestants['contestant_num']?>" <?php if ($row_setting['active_cons']==$row_contestants['contestant_num']){ echo 'selected="selected" SELECTED';} ?>><?php echo $row_contestants['contestant_num']. " - " . $row_contestants['municipality']; ?></option>
                      <?php
} while ($row_contestants = mysql_fetch_assoc($contestants));
  $rows = mysql_num_rows($contestants);
  if($rows > 0) {
      mysql_data_seek($contestants, 0);
	  $row_contestants = mysql_fetch_assoc($contestants);
  }
?>
                  </select></td>
                </tr>
                <tr>
                  <td colspan="2" align="right"><div class="zpFormButtons">
                      <input value="      Set      " name="btnSet" type="submit" class="button"/>&nbsp;&nbsp;&nbsp;&nbsp;
                  </div></td>
                </tr>
              </table>
              </form>
              </fieldset>
          </div>
          <div id="p7tpc1_2">
            <iframe scrolling="no" width="250" height="350" frameborder="0" src="score_board_graph.php"></iframe>
          </div>
          <div id="p7tpc1_3">
            <form name="rpt" action="" method="post">
              <fieldset>
              <legend>Preliminary - Criteria</legend>
                <label>
              <?php mysql_select_db($database_conn_mutya, $conn_mutya);
				$query_pre_criteria = "SELECT criteria_id, criteria_name FROM pre_criteria";
				$pre_criteria = mysql_query($query_pre_criteria, $conn_mutya) or die(mysql_error());
				$row_pre_criteria = mysql_fetch_assoc($pre_criteria);
				$totalRows_pre_criteria = mysql_num_rows($pre_criteria); 
				?>
              <select name="rpt_pre" id="rpt_pre">
                <?php do { ?>
                <option value="<?php echo $row_pre_criteria['criteria_id']; ?>"><?php echo $row_pre_criteria['criteria_name']; ?></option>
                <?php } while ($row_pre_criteria = mysql_fetch_assoc($pre_criteria)); ?>
              </select>
              <input type="submit" name="btnpre" value="Report" />
              </label>
              </fieldset>
              <fieldset>
              <?php mysql_select_db($database_conn_mutya, $conn_mutya);
				$query_semi_criteria = "SELECT criteria_id, criteria_name FROM semi_criteria";
				$semi_criteria = mysql_query($query_semi_criteria, $conn_mutya) or die(mysql_error());
				$row_semi_criteria = mysql_fetch_assoc($semi_criteria);
				$totalRows_semi_criteria = mysql_num_rows($semi_criteria);
				?>
              <legend>Semi Finals</legend>
                <label>
              <select name="rpt_semi" id="rpt_semi">
                <?php do { ?>
                <option value="<?php echo $row_semi_criteria['criteria_id']; ?>"><?php echo $row_semi_criteria['criteria_name']; ?></option>
                <?php } while ($row_semi_criteria = mysql_fetch_assoc($semi_criteria)); ?>
              </select>
              <input type="submit" name="btnsemi" value="Report" />
              </label>
              </fieldset>
              <fieldset>
              <?php
				mysql_select_db($database_conn_mutya, $conn_mutya);
				$query_final_criteria = "SELECT criteria_id, criteria_name FROM final_criteria";
				$final_criteria = mysql_query($query_final_criteria, $conn_mutya) or die(mysql_error());
				$row_final_criteria = mysql_fetch_assoc($final_criteria);
				$totalRows_final_criteria = mysql_num_rows($final_criteria);
				?>
              <legend>Finals - Criteria</legend>
                <label>
              <select name="rpt_final" id="rpt_final">
                <?php do { ?>
                <option value="<?php echo $row_final_criteria['criteria_id']; ?>"><?php echo $row_final_criteria['criteria_name']; ?></option>
                <?php } while ($row_final_criteria = mysql_fetch_assoc($final_criteria)); ?>
              </select>
              <input type="submit" name="btnfinal" value="Report" />
              </label>
              </fieldset>
              <fieldset>
              <legend>Results</legend>
                <label>
              <select name="rpt_result" id="rpt_result">
                <option value="5">Preliminary</option>
                <option value="1">Semi Finalist (10)</option>
                <option value="2">Semi Finalist (list all)</option>
                <option value="3">Finalist (3)</option>
                <option value="4">Finalist (list all)</option>
              </select>
              <input type="submit" name="btnresult" value="Report" />
              </label>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
      <!--[if lte IE 6]>
<style type="text/css">.p7TPpanel div,.p7TPpanel a{height:1%;}.p7TP_tabs a{white-space:nowrap;}</style>
<![endif]-->
</div></td>
  </tr>
  <tr>
    <td height="40%">&nbsp;</td>
  </tr>
</table>
<br /><br />
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
		alert("not correct value!");
		return false;
	}
	if (test==0) {
		window.alert( "Score should be " + 80 + " to " + 100 );
		return false;
	} else if( (score < 80) || (100 < score) ) {
		window.alert( "Score should be " + 80 + " to " + 100 );
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
mysql_free_result($setting);

mysql_free_result($contestants);

mysql_free_result($pre_criteria);

mysql_free_result($semi_criteria);

mysql_free_result($final_criteria);

mysql_free_result($semi_cri);

mysql_free_result($final_cri);

mysql_free_result($rec_cri);
?>