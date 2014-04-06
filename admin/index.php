<?php require_once('../Connections/conn_mutya.php'); ?>
<?php 
session_start();
//if ( !isset($_SESSION['kt_login_id']) ){
	//header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/index.php" );
	//exit(0);
	//print("hello");
	//echo $_SESSION['kt_login_id'];
//}else{
	//print("hi");
	//echo $_SESSION['kt_login_id'];
//}
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
if (!$_POST['username']){
	$username = "x";
}else{
	$username = $_POST['username'];
}
if (!$_POST['password']){
	$password = "x";
}else{
	$password = $_POST['password'];
}

mysql_select_db($database_conn_mutya, $conn_mutya);
$query_rec_admin = "SELECT * FROM `admin` where username='" . $username . "' and password='" . $password . "'";
$rec_admin = mysql_query($query_rec_admin, $conn_mutya) or die(mysql_error());
$row_rec_admin = mysql_fetch_assoc($rec_admin);
$totalRows_rec_admin = mysql_num_rows($rec_admin);

if ($totalRows_rec_admin>0) {
	//print("has value");
	//echo $_SESSION['kt_login_id'];
	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/control_window.php?admin_id=".$row_rec_admin['admin_id'] );
	exit(0);
	//echo $totalRows_rec_admin;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Miss Manaragat 2012</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/interface.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
function loginpage_onload() {
    document.forms[0].elements["username"].focus();
}
// -->
</script>
<!--[if lt IE 7]>
 <style type="text/css">
 div, img { behavior: url(iepngfix.htc) }
 </style>
<![endif]-->

<link href="style.css" rel="stylesheet" type="text/css" />
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

</head>
<body onload="loginpage_onload();">
<div class="dock" id="dock">
  <div class="dock-container">
  <a class="dock-item" href="#"><img src="images/control.png" alt="Controls" /><span>Controls</span></a> 
  <a class="dock-item" href="#"><img src="images/contestant.png" alt="contestant" /><span>Contestant</span></a>  
  <a class="dock-item" href="#"><img src="images/user.png" alt="Administrator" /><span>Administrator</span></a> 
  <a class="dock-item" href="#"><img src="images/judge.png" alt="judges" /><span>Judges</span></a>   
  <a class="dock-item" href="#"><img src="images/criteria.png" alt="criteria" /><span>Criteria</span></a>  
 
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
<table border="0" width="480" align="center"><tr><td align="center"><img src="images/mutya_txt.png" /></td></tr></table><br /><br />
<table width="450" border="0" align="center">
  <tr>
    <td>
    <form enctype="" action="" name="userData" id='userForm' method="post" style='text-align:left'>
	<div id='errOutput' class="errOutput"></div>
	<div class="zpFormContent">
		<fieldset>
			<legend>Admin Login Form</legend>

			<label class='zpFormLabel'>Username</label>
					<input class='zpFormRequired' value="" size="20" name="username" type="text" >
			<br />

			<label class='zpFormLabel'>Password</label>
			<input class='zpFormRequired' value="" size="20" name="password" type="password" >
           </fieldset>
	</div>
	<div class="zpFormButtons">
		<input value="  Login  " name="Submit" onclick="" type="submit" class="button"> 
		<input value="Clear" name="Clear" onclick="" type="reset" class="button">
	</div>
	
</form></td>
  </tr>
</table>
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

// Run this to auto-activate all "zpForm" class forms in the document.
new Zapatec.Form('userForm', {
	showErrors: 'afterField',
	showErrorsOnSubmit: true,
	submitErrorFunc: testErrOutput,
	theme: "winxp"
});
</script>
<!-- End Script for zpforms-->
</body>
</html>
<?php
mysql_free_result($rec_admin);
?>