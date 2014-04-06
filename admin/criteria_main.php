<?php
//if (!isset($_REQUEST['admin_id']) or $_REQUEST['admin_id']==""){
//	header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']). "/index.php");
//	exit(0);
//}
$curr_admin_id=$_REQUEST['admin_id'];
?>
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
<link href="p7ap/p7ap_01.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="p7ap/p7APscripts.js"></script>
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
<table width="580" border="0" align="center">
  <tr>
    <td><div id="p7ABW1" class="p7AB">
      <div class="p7ABtrig">
        <h3><a href="javascript:;" id="p7ABt1_1">Preliminary Criteria</a></h3>
      </div>
      <div id="p7ABw1_1">
        <div id="p7ABc1_1" class="p7ABcontent">
          <iframe frameborder="0" height="300" width="500" scrolling="no" src="criteria_preliminary.php"></iframe>
        </div>
      </div>
      <div class="p7ABtrig">
        <h3><a href="javascript:;" id="p7ABt1_2">Semi Final Criteria</a></h3>
      </div>
      <div id="p7ABw1_2">
        <div id="p7ABc1_2" class="p7ABcontent">
          <iframe frameborder="0" height="300" width="500" scrolling="no" src="criteria_semifinal.php"></iframe>
        </div>
      </div>
      <div class="p7ABtrig">
        <h3><a href="javascript:;" id="p7ABt1_3">Final Criteria</a></h3>
      </div>
      <div id="p7ABw1_3">
        <div id="p7ABc1_3" class="p7ABcontent">
          <iframe frameborder="0" height="300" width="500" scrolling="no" src="criteria_final.php"></iframe>
        </div>
      </div>
      <script type="text/javascript">
<!--
P7_opAB(1,1,2,99,0);
//-->
      </script>
</div></td>
  </tr>
</table>
</body>
</html>