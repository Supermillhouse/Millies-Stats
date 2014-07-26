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
<table width="100%" border="1">
<?php
if($maps=mysqli_query($dbconn, "SELECT `MapName` FROM `".$sqlprefix."mapstats".$suffix."` WHERE `MapName`<>'' AND `TimeRoundEnd`<>'0001-01-01 00:00:00' AND `ServerID`='".SWID."' GROUP BY `MapName` ORDER BY SUM(`NumberofRounds`) DESC"))
{
while($mapdata=mysqli_fetch_array($maps))
{
	$mapdatas=mysqli_fetch_array(mysqli_query($dbconn, "SELECT SUM(`NumberofRounds`) AS 'numofrounds', MIN(`MinPlayers`) AS 'minplay', MAX(`MaxPlayers`) AS 'maxplay', AVG(`AvgPlayers`) AS 'avg', MAX(`PlayersJoinedServer`) AS 'maxjoin', MAX(`PlayersLeftServer`) AS 'maxleft', MAX(TIMEDIFF(`TimeRoundEnd`,`TimeRoundStarted`)), MIN(TIMEDIFF(`TimeRoundEnd`,`TimeRoundStarted`)), AVG(TIMEDIFF(`TimeRoundEnd`,`TimeRoundStarted`)) FROM `tbl_mapstats` WHERE `MapName`='".mysqli_real_escape_string($dbconn, $mapdata['0'])."' AND `TimeRoundEnd`<>'0001-01-01 00:00:00'"));
	switch($mapdata['0'])
	{
		case "MP_Abandoned": $sname="Zavod 311"; $simage="mp_Abandoned"; break;
		case "MP_Damage": $sname="Lancang Dam"; $simage="mp_Damage"; break;
		case "MP_Flooded": $sname="Flood Zone"; $simage="mp_Flooded"; break;
		case "MP_Journey": $sname="Golmud Railway"; $simage="mp_Journey"; break;
		case "MP_Naval": $sname="Paracel Storm"; $simage="mp_Naval"; break;
		case "MP_Prison": $sname="Operation Locker"; $simage="mp_Prison"; break;
		case "MP_Resort": $sname="Hainan Resort"; $simage="mp_Resort"; break;
		case "MP_Siege": $sname="Siege of Shanghai"; $simage="mp_Siege"; break;
		case "MP_TheDish": $sname="Rogue Transmission"; $simage="mp_TheDish"; break;
		case "MP_Tremors": $sname="Dawnbreaker"; $simage="mp_Tremors"; break;
		case "XP1_001": $sname="Silk Road"; $simage="xp1_001"; break;
		case "XP1_002": $sname="Altai Range"; $simage="xp1_002"; break;
		case "XP1_003": $sname="Guilin Peaks"; $simage="xp1_003"; break;
		case "XP1_004": $sname="Dragon Pass"; $simage="xp1_004"; break;
		case "XP0_Caspian": $sname="Caspian Border 2014"; $simage="xp0_Caspian"; break;
		case "XP0_Firestorm": $sname="Firestorm 2014"; $simage="xp0_Firestorm"; break;
		case "XP0_Metro": $sname="Operation Metro 2014"; $simage="xp0_Metro"; break;
		case "XP0_Oman": $sname="Gulf Of Oman 2014"; $simage="xp0_Oman"; break;
		case "XP2_001": $sname="Lost Islands"; $simage="xp2_001"; break;
		case "XP2_002": $sname="Nansha Strike"; $simage="xp2_002"; break;
		case "XP2_003": $sname="Wavebreaker"; $simage="xp2_003"; break;
		case "XP2_004": $sname="Operation Mortar"; $simage="xp2_004"; break;
		case "XP3_MarketPl": $sname="Pearl Market"; $simage="xp3_MarketPl"; break;
		case "XP3_Prpganda": $sname="Propaganda"; $simage="xp3_Prpganda"; break;
		case "XP3_UrbanGdn": $sname="Lumphini Garden"; $simage="xp3_UrbanGdn"; break;
		case "XP3_WtrFront": $sname="Sunken Dragon"; $simage="xp3_WtrFront"; break;
		case "": $sname=""; $simage=""; break;
	}
	echo"
	<tr class='cmess'>
		<td width='250px'><img src='./maps/$simage.jpg' width='445' height='250'/></td>
		<td valign='top'>
		<div class='servername'>$sname</div>
		<div class='serverdatastat'>
		<table width='100%'>
			<tr>
				<td>$lng_server_rounds".$mapdatas['numofrounds']."</td><td>$lng_server_min".$mapdatas['minplay']."</td><td>$lng_server_max".$mapdatas['maxplay']."</td>
			</tr>
			<tr>
				<td>$lng_server_avarage".round($mapdatas['avg'], 0)."</td><td>$lng_server_max_join".$mapdatas['maxjoin']."</td><td>$lng_server_max_left".$mapdatas['maxleft']."</td>
			</tr>
		</table>
		</div>
		</td>
	</tr>
	";
}
}
else
{
	echo"
	<tr>
		<th>$lng_disab_map</th>
	</tr>
	";
}
?>
</table>
<div style="width:100%; clear:both; float:left; color:#F00;"><center><?php echo $lng_server_description; ?></center></div>
</div>
<div class="spacer"></div>
<div id="footer"><?php echo FOOTERTEXT; ?></div>
</body>
</html>
