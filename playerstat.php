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
<link rel="shortcut icon" href="./template/images/staticon.png" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $serverinfo['1']; ?> Server stats</title>
<link href="template/style.css" rel="stylesheet" type="text/css" />
<script src="template/functions.js" type="text/javascript"></script>
</head>

<body onload="refreshrank(<?php echo $_GET['pid']; ?>)">
<!--<div id="headspace"></div>-->
<div id="menu">
	<div class="menuin">
		<?php echo MENU ?>
   	</div>
</div>
<div class="spacer"><?php echo SERVERS; ?></div>
<div id="body">
<?php
if(isset($_GET['pid']) && is_numeric($_GET['pid']))
{
	$playerdata=mysqli_fetch_array(mysqli_query($dbconn, "SELECT pd.SoldierName, pd.CountryCode, ps.* FROM ".$sqlprefix."server_player".$suffix." p LEFT JOIN ".$sqlprefix."playerstats".$suffix." ps ON p.StatsID=ps.StatsID LEFT JOIN ".$sqlprefix."playerdata".$suffix." pd ON pd.PlayerID=p.PlayerID WHERE p.StatsID=".mysqli_real_escape_string($dbconn, $_GET['pid']).""));
	echo"
	<div class='trackersname'><img src='flags/".strtoupper($playerdata['1']).".gif' title='".$playerdata['1']."'/>&nbsp;".$playerdata['0']." $lng_playerstat_name &nbsp;<img src='flags/".strtoupper($playerdata['1']).".gif' title='".$playerdata['1']."' /></div>
	<table width='100%' style='border-bottom:1px solid #fff !important;'>
		<tr>
			<td colspan='2'>
				<center>$lng_playerstat_rank <a href=\"javascript:refreshrank('".$playerdata['2']."')\"><img src='template/images/refresh.png' /></a></center>
				<table width='100%'>
					<tr class='cmess'>
						<td style='text-align:center'>$lng_playerstat2</td><td style='text-align:center'>$lng_playerstat3</td><td style='text-align:center'>$lng_playerstat4</td><td style='text-align:center'>$lng_playerstat5</td><td style='text-align:center'>$lng_playerstat6</td><td style='text-align:center'>$lng_playerstat7</td><td style='text-align:center'>$lng_playerstat8</td><td style='text-align:center'>$lng_playerstat9</td><td style='text-align:center'>$lng_playerstat10</td><td style='text-align:center'>$lng_playerstat11</td><td style='text-align:center'>$lng_playerstat12</td><td style='text-align:center'>$lng_playerstat13</td>
					</tr>
					<tr id='playerrank' class='cmess'>&nbsp;</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td><img src='./template/images/bf3-us-assault.png' width='300px' /></td>
			<td>
				<table width='90%' cellpadding='5' cellspacing='20' style='background-image:url(template/images/bg.png); font-size:15px;'>
					<tr>
						<td>$lng_playerstat_point ".$playerdata['3']."</td>
						<td>$lng_playerstat_round ".$playerdata['10']."</td>
						<td>$lng_playerstat_fuul_time ".round(($playerdata['9']/3600), 2)." H</td>
					</tr>
					<tr>
						<td>$lng_playerstat_kills ".$playerdata['4']."</td>
						<td>$lng_playerstat_deaths ".$playerdata['6']."</td>
						<td>$lng_playerstat_suicide ".$playerdata['7']."</td>
					</tr>
					<tr>
						<td>$lng_playerstat_headshot ".$playerdata['5']."</td>
						<td>$lng_playerstat_tks ".$playerdata['8']."</td>
						<td>$lng_playerstat_kd ";if($playerdata['4']!=0){echo round(($playerdata['4']/$playerdata['6']), 2);}else{ echo "0";} echo"</td>
					</tr>
					<tr>
						<td>$lng_playerstat_ppm ".round(($playerdata['3']/($playerdata['9']/60)), 2)."</td>
						<td>$lng_playerstat_ppr ";if(round($playerdata['3']/$playerdata['10'], 2)!=0){echo round(($playerdata['3']/$playerdata['10']), 2);}else{ echo "0";} echo"</td>
						<td>$lng_playerstat_killstreak ".$playerdata['13']."</td>
					</tr>
					<tr>
						<td>$lng_playerstat_deathstreak ".$playerdata['14']."</td>
						<td>$lng_playerstat_firstp ".$playerdata['11']."</td>
						<td>$lng_playerstat_lastp ".$playerdata['12']."</td>
					</tr>
					<tr>
						<td style='text-align:center;'><a href='http://battlelog.battlefield.com/bf4/user/".$playerdata['0']."/' target='_blank'><img src=\"template/images/blogbtn.png\" width='200px' /></a></td>
            <td></td>
						<td style='text-align:center;'><a href='http://bf4stats.com/pc/".$playerdata['0']."/' target='_blank'><img src=\"template/images/bf4stats.png\" width='200px' /></a></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<div class='trackersname'>$lng_playerstat_weapons</div>
	<table width='100%'>
		<tr>
			<td>
				<div id='TabbedPanels1' class='TabbedPanels'>
  					<ul class='TabbedPanelsTabGroup'>
   					<li class='TabbedPanelsTab' tabindex='0'>$lng_playerstat_weapon1</li>
						<li class='TabbedPanelsTab' tabindex='0' onclick=\"weaponstat('carbine', '".mysqli_real_escape_string($dbconn, $_GET['pid'])."', '');\">$lng_playerstat_weapon12</li>
						<li class='TabbedPanelsTab' tabindex='0' onclick=\"weaponstat('handgun', '".mysqli_real_escape_string($dbconn, $_GET['pid'])."', '');\">$lng_playerstat_weapon3</li>
    				<li class='TabbedPanelsTab' tabindex='0' onclick=\"weaponstat('lmg', '".mysqli_real_escape_string($dbconn, $_GET['pid'])."', '');\">$lng_playerstat_weapon4</li>
    				<li class='TabbedPanelsTab' tabindex='0' onclick=\"weaponstat('projectileexplosive', '".mysqli_real_escape_string($dbconn, $_GET['pid'])."', '');\">$lng_playerstat_weapon6</li>
    				<li class='TabbedPanelsTab' tabindex='0' onclick=\"weaponstat('impact', '".mysqli_real_escape_string($dbconn, $_GET['pid'])."', '');\">$lng_playerstat_weapon11</li>
						<li class='TabbedPanelsTab' tabindex='0' onclick=\"weaponstat('shotgun', '".mysqli_real_escape_string($dbconn, $_GET['pid'])."', '');\">$lng_playerstat_weapon7</li>
    				<li class='TabbedPanelsTab' tabindex='0' onclick=\"weaponstat('smg', '".mysqli_real_escape_string($dbconn, $_GET['pid'])."', '');\">$lng_playerstat_weapon8</li>
    				<li class='TabbedPanelsTab' tabindex='0' onclick=\"weaponstat('sniperrifle', '".mysqli_real_escape_string($dbconn, $_GET['pid'])."', '');\">$lng_playerstat_weapon9</li>
    				<li class='TabbedPanelsTab' tabindex='0' onclick=\"weaponstat('dmr', '".mysqli_real_escape_string($dbconn, $_GET['pid'])."', '');\">$lng_playerstat_weapon10</li>
    				<li class='TabbedPanelsTab' tabindex='0' onclick=\"weaponstat('melee', '".mysqli_real_escape_string($dbconn, $_GET['pid'])."', '');\">$lng_playerstat_weapon5</li>
    				<li class='TabbedPanelsTab' tabindex='0' onclick=\"weaponstat('explosive', '".mysqli_real_escape_string($dbconn, $_GET['pid'])."', '');\">$lng_playerstat_weapon2</li>
  					</ul>
  					<div class='TabbedPanelsContentGroup'>
    					<div class='TabbedPanelsContent' id='assaultrifle'>
						<table width='100%' class='cmess'>
						";

$results = mysqli_query($dbconn, "
			SELECT tws.`WeaponID`, tw.`Friendlyname`, tws.`Kills`, tws.`Headshots`, tws.`Deaths` FROM `".$sqlprefix."weapons_stats".$suffix."` tws 
			INNER JOIN `".$sqlprefix."weapons".$suffix."` tw ON tw.`WeaponID` = tws.`WeaponID` 
      WHERE tws.`StatsID` = '".mysqli_real_escape_string($dbconn,$_GET['pid'])."'
			AND tw.`Damagetype` = 'assaultrifle' ORDER BY tw.`Friendlyname` ASC");

			if(mysqli_num_rows($results) > 0)
			{
			while($row=mysqli_fetch_array($results))
      {
        $weapon_name = str_replace("_"," ", $row['Friendlyname']);
        $killcount = $row['Kills'];
        $hscount = $row['Headshots'];
        $deathcount = $row['Deaths']; 
			
							echo "
							<tr>
								<td align='center' width='25%' height='140px'><img src='weapons/".$row['Friendlyname'].".png'/></td>
								<th width='30%'>$weapon_name</th>
								<td width='15%'>$lng_playerstat_kills_by_weap ".$killcount."</td>
								<td width='15%'>$lng_playerstat_hs_by_weap ".$hscount."</td>
								<td width='15%'>$lng_playerstat_deaths_by_weap ".$deathcount."</td>
							</tr>
							";
			}
			}
			else
			{
				echo"
				<tr>
					<td align='center' width='25%' height='140px'></td><td colspan='3'><center>$lng_no_result</center></td>
				</tr>
				";
			}

						echo "
						</table>
						</div>
						<div class='TabbedPanelsContent' id='carbine'></div>
						<div class='TabbedPanelsContent' id='handgun'></div>
    				<div class='TabbedPanelsContent' id='lmg'></div>
    				<div class='TabbedPanelsContent' id='projectileexplosive'></div>
    				<div class='TabbedPanelsContent' id='impact'></div>
						<div class='TabbedPanelsContent' id='shotgun'></div>
    				<div class='TabbedPanelsContent' id='smg'></div>
						<div class='TabbedPanelsContent' id='sniperrifle'></div>
						<div class='TabbedPanelsContent' id='dmr'></div>
						<div class='TabbedPanelsContent' id='melee'></div>
						<div class='TabbedPanelsContent' id='explosive'></div>
  					</div>
				</div>
			</td>
		</tr>
	</table>
	";
}

else
{
	header('location:players.php');
}
?>
</div>
<div class="spacer"></div>
<div id="footer"><?php echo FOOTERTEXT; ?></div>
<script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>
</body>
</html>