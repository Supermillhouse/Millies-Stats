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
<link rel="shortcut icon" href="./template/images/staticon.png">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $serverinfo['1']; ?> Server stats</title>
<link href="template/style.css" rel="stylesheet" type="text/css" />
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
	<div class="trackersname"><?php echo $lng_playerstop; ?></div>
    <p><center><?php echo $lng_search_player; ?><form onsubmit="return false"><input type="text" style="width:200px" name="searchplayer" onkeyup="searchuname(this.value)"/></form></center>
    <div name='suname' id='suname'></div></p>
    <table width="100%" style="text-align:center;" class='cmess'>
    	<tr>
        	<td></td>
            <td><?php echo $lng_playerstat1; ?></td>
            <td><?php echo $lng_playerstat2; ?><br /><a href="players.php?order=Score&where=ASC"><img src="template/images/sort_up.png" /></a><a href="players.php?order=Score&where=DESC"><img src="template/images/sort_down.gif" /></a></td>
            <td><?php echo $lng_playerstat3; ?><br /><a href="players.php?order=Playtime&where=ASC"><img src="template/images/sort_up.png" /></a><a href="players.php?order=Playtime&where=DESC"><img src="template/images/sort_down.gif" /></a></td>
            <td><?php echo $lng_playerstat4; ?><br /><a href="players.php?order=Kills&where=ASC"><img src="template/images/sort_up.png" /></a><a href="players.php?order=Kills&where=DESC"><img src="template/images/sort_down.gif" /></a></td>
            <td><?php echo $lng_playerstat5; ?><br /><a href="players.php?order=Deaths&where=ASC"><img src="template/images/sort_up.png" /></a><a href="players.php?order=Deaths&where=DESC"><img src="template/images/sort_down.gif" /></a></td>
            <td><?php echo $lng_playerstat6; ?><br /><a href="players.php?order=TKs&where=ASC"><img src="template/images/sort_up.png" /></a><a href="players.php?order=TKs&where=DESC"><img src="template/images/sort_down.gif" /></a></td>
            <td><?php echo $lng_playerstat7; ?><br /><a href="players.php?order=kd&where=ASC"><img src="template/images/sort_up.png" /></a><a href="players.php?order=kd&where=DESC"><img src="template/images/sort_down.gif" /></a></td>
            <td><?php echo $lng_playerstat8; ?><br /><a href="players.php?order=ppm&where=ASC"><img src="template/images/sort_up.png" /></a><a href="players.php?order=ppm&where=DESC"><img src="template/images/sort_down.gif" /></a></td>
            <td><?php echo $lng_playerstat9; ?><br /><a href="players.php?order=ppr&where=ASC"><img src="template/images/sort_up.png" /></a><a href="players.php?order=ppr&where=DESC"><img src="template/images/sort_down.gif" /></a></td>
            <td><?php echo $lng_playerstat10; ?><br /><a href="players.php?order=Rounds&where=ASC"><img src="template/images/sort_up.png" /></a><a href="players.php?order=Rounds&where=DESC"><img src="template/images/sort_down.gif" /></a></td>
            <td><?php echo $lng_playerstat11; ?><br /><a href="players.php?order=Suicide&where=ASC"><img src="template/images/sort_up.png" /></a><a href="players.php?order=Suicide&where=DESC"><img src="template/images/sort_down.gif" /></a></td>
            <td><?php echo $lng_playerstat12; ?><br /><a href="players.php?order=Killstreak&where=ASC"><img src="template/images/sort_up.png" /></a><a href="players.php?order=Killstreak&where=DESC"><img src="template/images/sort_down.gif" /></a></td>
            <td><?php echo $lng_playerstat13; ?><br /><a href="players.php?order=Deathstreak&where=ASC"><img src="template/images/sort_up.png" /></a><a href="players.php?order=Deathstreak&where=DESC"><img src="template/images/sort_down.gif" /></a></td>
        </tr>
        <?php
			require('config/database.php');
			$counter=0;
			if(!isset($_GET['order']))
			{
				$fullquery=mysqli_query($dbconn, "SELECT pd.SoldierName, pd.CountryCode, ps.* FROM ".$sqlprefix."server_player".$suffix." p LEFT JOIN ".$sqlprefix."playerstats".$suffix." ps ON p.StatsID=ps.StatsID LEFT JOIN ".$sqlprefix."playerdata".$suffix." pd ON pd.PlayerID=p.PlayerID WHERE p.ServerID=".SWID." ORDER BY ps.Score DESC LIMIT 2000");
			}
			else
			{
				if($_GET['order']=="kd")
				{
					$order="`Kills`/`Deaths`";
				}
				elseif($_GET['order']=="ppm")
				{
					$order="`Score`/(`Playtime`/60)";
				}
				elseif($_GET['order']=="ppr")
				{
					$order="`Score`/`Rounds`";
				}
				else
				{
					$order=$_GET['order'];
				}
					$fullquery=mysqli_query($dbconn, "SELECT pd.SoldierName, pd.CountryCode, ps.* FROM ".$sqlprefix."server_player".$suffix." p LEFT JOIN ".$sqlprefix."playerstats".$suffix." ps ON p.StatsID=ps.StatsID LEFT JOIN ".$sqlprefix."playerdata".$suffix." pd ON pd.PlayerID=p.PlayerID WHERE p.ServerID=".SWID." ORDER BY ".mysqli_real_escape_string($dbconn, $order)." ".mysqli_real_escape_string($dbconn, $_GET['where'])." LIMIT 2000");
			}
			$rowsPerPage=50;
			$pageNum="1";
			$fulllistc=mysqli_num_rows($fullquery);
			if(isset($_GET['page']))
			{
				$counter=($_GET['page']-1)*50;
   				 $pageNum = $_GET['page'];
			}
			$offset = ($pageNum - 1) * $rowsPerPage;
			$maxPage = ceil($fulllistc/$rowsPerPage);
			if(!isset($_GET['order']))
			{
				$glist=sprintf("SELECT pd.SoldierName, pd.CountryCode, ps.* FROM ".$sqlprefix."server_player".$suffix." p LEFT JOIN ".$sqlprefix."playerstats".$suffix." ps ON p.StatsID=ps.StatsID LEFT JOIN ".$sqlprefix."playerdata".$suffix." pd ON pd.PlayerID=p.PlayerID WHERE p.ServerID=".SWID." ORDER BY `Score` DESC LIMIT $offset,$rowsPerPage;");
			}
			else
			{
				$glist="SELECT pd.SoldierName, pd.CountryCode, ps.* FROM ".$sqlprefix."server_player".$suffix." p LEFT JOIN ".$sqlprefix."playerstats".$suffix." ps ON p.StatsID=ps.StatsID LEFT JOIN ".$sqlprefix."playerdata".$suffix." pd ON pd.PlayerID=p.PlayerID WHERE p.ServerID=".SWID." ORDER BY ".mysqli_real_escape_string($dbconn, $order)." ".mysqli_real_escape_string($dbconn, $_GET['where'])." LIMIT $offset,$rowsPerPage;";
			}
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
      			$nav .= " <a href=\"$self?order=".$_GET['order']."&where=".$_GET['where']."&page=$page\">$page</a> ";
				}
   			}
			}
			if ($pageNum > 1)
			{
  			 $page  = $pageNum - 1;
			 if(!isset($_GET['order']))
			 {
				$prev  = " <a href=\"$self?page=$page\"><<</a> ";
   			 	$first = " <a href=\"$self?page=1\">$lng_pages_first</a> ";
			 }
			 else
			 {
				 $prev  = " <a href=\"$self?order=".$_GET['order']."&where=".$_GET['where']."&page=$page\"><<</a> ";
				 $first = " <a href=\"$self?order=".$_GET['order']."&where=".$_GET['where']."&page=1\">$lng_pages_first</a> ";
			 }
			}
			else
			{
  			 $prev  = '&nbsp;'; // we're on page one, don't print previous link
   			$first = '&nbsp;'; // nor the first page link
			}

			if ($pageNum < $maxPage)
			{
   			$page = $pageNum + 1;
			if(!isset($_GET['order']))
			{
				$next = " <a href=\"$self?page=$page\">>></a> ";
				$last = " <a href=\"$self?page=$maxPage\">$lng_pages_last</a> ";
			}
			else
			{
   				$next = " <a href=\"$self?order=".$_GET['order']."&where=".$_GET['where']."&page=$page\">>></a> ";
				$last = " <a href=\"$self?order=".$_GET['order']."&where=".$_GET['where']."&page=$maxPage\">$lng_pages_lase</a> ";
			}
			}
			else
			{
   			$next = '&nbsp;'; // we're on the last page, don't print next link
   			$last = '&nbsp;'; // nor the last page link
			}
			while($ndata=mysqli_fetch_array($gres))
			{
				$counter++;
				echo"
				<tr class='cmess'>
				<td>$counter.</td>
				<td style='text-align:justify;'><div style='float:left;'><a href='playerstat.php?pid=".$ndata['2']."'>".$ndata['0']."</a></div><div style='float:right;'><img src='flags/".(strtoupper($ndata['1'])).".gif' /></div></td>
				<td>".$ndata['3']."</td>
				<td>".round((($ndata['9']/3600)), 2)." H</td>
				<td>".$ndata['4']."</td>
				<td>".$ndata['6']."</td>
				<td>".$ndata['8']."</td>
				<td>";if($ndata['4']>0 && $ndata['6']>0){echo round(($ndata['4']/$ndata['6']), 2);}else echo "0";echo"</td>
				<td>".round(($ndata['3']/(($ndata['9']/60))), 2)."</td>
				<td>".round(($ndata['3']/$ndata['10']), 2)."</td>
				<td>".$ndata['10']."</td>
				<td>".$ndata['7']."</td>
				<td>".$ndata['13']."</td>
				<td>".$ndata['14']."</td>
				</tr>
				";
			}
		?>
    </table>
    <?php
	echo"
			<div class='numbers'><center>$lng_pages_full: $first $prev $nav $next $last</center></div>
			</div>
			";
			?>
</div>
<div class="spacer"></div>
<div id="footer"><?php echo FOOTERTEXT; ?></div>
</body>
</html>