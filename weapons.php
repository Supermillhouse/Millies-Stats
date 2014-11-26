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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $serverinfo['1']; ?> Server stats</title>
<link href="template/style.css" rel="stylesheet" type="text/css" />
<!--<link href="template/style.css?t=[timestamp]" rel="stylesheet" type="text/css" />-->
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
<div class="trackersname"><?php echo $lng_all_weapon_stat; ?></div>
<?php
echo"
<div id='TabbedPanels1' class='TabbedPanels'>
        <ul class='TabbedPanelsTabGroup'>
            <li class='TabbedPanelsTab' onclick=\"weaponstat2('assaultrifle', '');\">$lng_playerstat_weapon1</li>
    				<li class='TabbedPanelsTab' onclick=\"weaponstat2('carbine', '');\">$lng_playerstat_weapon12</li>
            <li class='TabbedPanelsTab' onclick=\"weaponstat2('handgun', '');\">$lng_playerstat_weapon3</li>
    				<li class='TabbedPanelsTab' onclick=\"weaponstat2('lmg', '');\">$lng_playerstat_weapon4</li>
    				<li class='TabbedPanelsTab' onclick=\"weaponstat2('projectileexplosive', '');\">$lng_playerstat_weapon6</li>
    				<li class='TabbedPanelsTab' onclick=\"weaponstat2('impact', '');\">$lng_playerstat_weapon11</li>
						<li class='TabbedPanelsTab' onclick=\"weaponstat2('shotgun', '');\">$lng_playerstat_weapon7</li>
    				<li class='TabbedPanelsTab' onclick=\"weaponstat2('smg', '');\">$lng_playerstat_weapon8</li>
    				<li class='TabbedPanelsTab' onclick=\"weaponstat2('sniperrifle', '');\">$lng_playerstat_weapon9</li>
    				<li class='TabbedPanelsTab' onclick=\"weaponstat2('dmr', '');\">$lng_playerstat_weapon10</li>
    				<li class='TabbedPanelsTab' onclick=\"weaponstat2('melee', '');\">$lng_playerstat_weapon5</li>
    				<li class='TabbedPanelsTab' onclick=\"weaponstat2('explosive', '');\">$lng_playerstat_weapon2</li>
        </ul>
  			<div class='TabbedPanelsContentGroup'>
    		<div class='TabbedPanelsContent' id='weapons_assaultrifle'>
  			<table width='100%' class='cmess'>";
        $dir = dir("weapons/assault");
						
//				if(!isset($_GET['order']))
//				{						
$results = mysqli_query($dbconn, "
SELECT tw.`Friendlyname`, SUM(tws.`Kills`) AS Kills_sum, SUM(tws.`Headshots`) AS Head_sum, SUM(tws.`Deaths`) AS Deaths_sum FROM `tbl_weapons_stats` tws 
LEFT JOIN `tbl_weapons` tw ON tws.`WeaponID` = tw.`WeaponID` 
WHERE tw.`Damagetype` = 'assaultrifle' 
GROUP BY tws.`WeaponID` 
ORDER BY `Friendlyname` ASC" );
/*				}
				else
        {
        
        if($_GET['order']=="kills")
				{
					$order="`Kills_sum`";
				}
        else
        {
				$order=$_GET['order'];				
				}
$results = mysqli_query($dbconn, "
SELECT w.`Friendlyname`, SUM(ws.`Kills`) AS Kills_sum, SUM(ws.`Headshots`) AS Head_sum, SUM(ws.`Deaths`) AS Deaths_sum FROM `".$sqlprefix."weapons_stats".$suffix."` ws 
LEFT JOIN `".$sqlprefix."weapons".$suffix."` w ON ws.`WeaponID` = w.`WeaponID` 
LEFT JOIN `".$sqlprefix."server_player".$suffix."` sp ON ws.`StatsID` = sp.`StatsID` 
WHERE w.`Damagetype` = 'assaultrifle' 
AND sp.`ServerID` = '".SWID."' GROUP BY ws.`WeaponID` 
ORDER BY ".mysqli_real_escape_string($dbconn, $order)." ".mysqli_real_escape_string($dbconn, $_GET['where']));
			}
*/
$maxplayerkill =mysqli_query($dbconn, "
SELECT tws.`WeaponID`, tw.`Friendlyname`, tws.`Kills`, tws.`Deaths`, tws.`StatsID`, tpd.`SoldierName`
 FROM `".$sqlprefix."weapons_stats".$suffix."` tws
 LEFT OUTER JOIN `".$sqlprefix."weapons".$suffix."` tw ON tw.`WeaponID` = tws.`WeaponID`
 LEFT OUTER JOIN `".$sqlprefix."server_player".$suffix."` tsp ON tws.`StatsID` = tsp.`StatsID`
 RIGHT OUTER JOIN `".$sqlprefix."playerdata".$suffix."` tpd ON tsp.`PlayerID` = tpd.`PlayerID`
 RIGHT OUTER JOIN
 (
 SELECT MAX(tws1.`Kills`) AS Kills, tws1.`WeaponID`
 FROM `".$sqlprefix."weapons_stats".$suffix."` tws1
 INNER JOIN `tbl_server_player` tsp1 ON tws1.`StatsID` = tsp1.`StatsID`
 WHERE tsp1.`ServerID` = '".SWID."'
 AND tws1.`Kills` <> '0'
 GROUP BY tws1.`WeaponID`
 ORDER BY tws1.`StatsID` ASC
 )
 q2
 ON tws.`WeaponID` = q2.`WeaponID`
 AND tws.`Kills` = q2.`Kills`
 WHERE tw.`Damagetype` = 'assaultrifle'
 GROUP BY tws.`WeaponID`
 ORDER BY tws.`Kills` DESC");

while ($max= mysqli_fetch_array($maxplayerkill))	
{
$maxplayers[$max['Friendlyname']] = $max['SoldierName'];
$statsid[$max['Friendlyname']] = $max['StatsID'];
$killcount[$max['Friendlyname']] = $max['Kills'];
$deathcount[$max['Friendlyname']] = $max['Deaths'];
}

while($row = mysqli_fetch_array($results))
{
if ($row['Kills_sum'] > $row['Deaths_sum']) $kill = $row['Kills_sum'];
else $kill = $row['Deaths_sum'];
$weapon_name = str_replace("_"," ", $row['Friendlyname']);
$maxsoldiername = $maxplayers[$row['Friendlyname']];
$pidlink = $statsid[$row['Friendlyname']];
$killcount1 = $killcount[$row['Friendlyname']];
$deathcount1 = $deathcount[$row['Friendlyname']]; 
echo "<tr>
				<td align='center' width='25%' height='140px'><img alt='' src='weapons/".$row['Friendlyname'].".png'/></td>
        <th width='15%'>$weapon_name</th>
				<td width='15%'>$lng_playerstat_kills_by_weap $kill</td>
				<td width='15%'>$lng_playerstat_hs_by_weap ".$row['Head_sum']."</td>
				<td width='30%'>$lng_playermax_kill_by_weap <a href='playerstat.php?pid=$pidlink'>".$maxsoldiername. " <br/>" .$killcount1. " " .$lng_player_kills."<br/>" .$deathcount1. " " .$lng_player_deaths."<br/>"; if ($deathcount1==0)$deathcount1=1; echo round(($killcount1 / $deathcount1), 2). " " .$lng_player_kd."</a></td>
			</tr>";
}
echo "</table>";
echo "</div>
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
</div>
";
?>
<div class="spacer"></div>
<div id="footer"><?php echo FOOTERTEXT; ?></div>
<script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>
</body>
</html>