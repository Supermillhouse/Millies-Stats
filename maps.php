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
if($maps=mysqli_query($dbconn, "SELECT `MapName` FROM `".$sqlprefix."mapstats".$suffix."` WHERE `MapName`<>'' AND `TimeRoundEnd`<>'0001-01-01 00:00:00' AND `ServerID`='".SWID."' GROUP BY `MapName`"))
{
while($mapdata=mysqli_fetch_array($maps))
{
	$mapdatas=mysqli_fetch_array(mysqli_query($dbconn, "SELECT SUM(`NumberofRounds`), MIN(`MinPlayers`), MAX(`MaxPlayers`), AVG(`AvgPlayers`), MAX(`PlayersJoinedServer`), MAX(`PlayersLeftServer`), MAX(TIMEDIFF(`TimeRoundEnd`,`TimeRoundStarted`)), MIN(TIMEDIFF(`TimeRoundEnd`,`TimeRoundStarted`)), AVG(TIMEDIFF(`TimeRoundEnd`,`TimeRoundStarted`)) FROM `".$sqlprefix."mapstats".$suffix."` WHERE `MapName`='".mysqli_real_escape_string($dbconn, $mapdata['0'])."';"));
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
				<td>$lng_server_rounds".$mapdatas['0']."</td><td>$lng_server_min".$mapdatas['1']."</td><td>$lng_server_max".$mapdatas['2']."</td>
			</tr>
			<tr>
				<td>$lng_server_avarage".round($mapdatas['3'], 0)."</td><td>$lng_server_max_join".$mapdatas['4']."</td><td>$lng_server_max_left".$mapdatas['5']."</td>
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