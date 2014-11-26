<?php
ob_start();
require('config/database.php');
require('config/bf3conn.php');
include('config/config.php');
include('config/languages/'.LANG.'.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="./template/images/staticon.png"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?php echo $serverinfo['1']; ?> Server stats</title>
<link href="template/style.css" rel="stylesheet" type="text/css"/>
<script src="template/functions.js" type="text/javascript"></script>
</head>

<body>
<!--<div id="headspace"></div>-->
<div id="menu">
	<div class="menuin">
		<?php echo MENU ?>
   	</div>
</div>
<div class="spacer"><?php echo SERVERS; ?></div>
<div id="body">
	<div class="trackersname"><?php echo $lng_all_chat_mess; ?></div>
        <?php
			
			if($fullquery=mysqli_query($dbconn, "SELECT * FROM `".$sqlprefix."chatlog".$suffix."` WHERE `ServerID`='".SWID."' ORDER BY `logDate` DESC LIMIT 1500"))
			{

			$rowsPerPage=50;
			$pageNum="1";
			$fulllistc=mysqli_num_rows($fullquery);
			if(isset($_GET['page']))
			{
   			 $pageNum = $_GET['page'];
			}
			$offset = ($pageNum - 1) * $rowsPerPage;
			$maxPage = ceil($fulllistc/$rowsPerPage);

			$glist=sprintf("SELECT * FROM ".$sqlprefix."chatlog".$suffix." WHERE `ServerID`='".SWID."' ORDER BY `logDate` DESC LIMIT $offset,$rowsPerPage;");

			$gres=mysqli_query($dbconn, $glist);
			$glistcount=mysqli_num_rows($gres);
			$self = $_SERVER['PHP_SELF'];
			$nav  = '';
			for($page = 1; $page <= $maxPage; $page++)
			{
   			if ($page == $pageNum)
   			{
    		 $nav .= " $page "; // no need to create a link to current page
  			}
   			else
   			{
				if(!isset($_GET['order']))
				{
					$nav .= " <a href=\"$self?page=$page\">$page</a> ";
				}
				else
				{
      			$nav .= " <a href=\"$self?page=$page\">$page</a> ";
				}
   			}
			}
			if ($pageNum > 1)
			{
  			 	$page  = $pageNum - 1;
				$prev  = " <a href=\"$self?page=$page\"><<</a> ";
   			 	$first = " <a href=\"$self?page=1\">$lng_pages_first</a> ";
			}
			else
			{
  			 $prev  = '&nbsp;'; // we're on page one, don't print previous link
   			$first = '&nbsp;'; // nor the first page link
			}

			if ($pageNum < $maxPage)
			{
   			$page = $pageNum + 1;
				$next = " <a href=\"$self?page=$page\">>></a> ";
				$last = " <a href=\"$self?page=$maxPage\">$lng_pages_last</a> ";
			}
			else
			{
   			$next = '&nbsp;'; // we're on the last page, don't print next link
   			$last = '&nbsp;'; // nor the last page link
			}
			echo "
				<center><form action='' onsubmit='return false'>$lng_search_mess &nbsp;&nbsp;&nbsp;<input type='text' name='csearch' onkeyup='searchcmess(this.value)' /></form></center>
				<div id='messages' style='max-width:100%;'>
				<div class='numbers'><center>$lng_pages_full $first $prev $nav $next $last</center></div>
				";?>
				<table width='100%' cellpadding='5' cellspacing='5' style='font-family:Arial, Helvetica, sans-serif; font-size:12px;' class='cmess'>
                <?php
				echo"
				<tr class='cmess'>
					<th>$lng_messwriter</th><th>$lng_messtext</th><th>$lng_messdate</th><th>$lng_messtype</th>
				</tr>
			";
			while($ndata=mysqli_fetch_array($gres))
			{
				echo"
				<tr class='cmess'>
					<th>".$ndata['logSoldierName']."</th><th>".$ndata['logMessage']."</th><th>".$ndata['logDate']."</th><th>".$ndata['logSubset']."</th>
				</tr>
				";
			}
		?>
    </table>
    <?php
	echo"
			<div class='numbers'><center>$lng_pages_full $first $prev $nav $next $last</center></div>
			</div>
			";
			}
			else
			{
				echo"
				$lng_no_chat
				";
			}
			?>
</div>
<div class="spacer"></div>
<div id="footer"><?php echo FOOTERTEXT; ?></div>
</body>
</html>