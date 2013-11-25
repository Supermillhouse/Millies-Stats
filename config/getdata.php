<?php require('database.php');
require('languages/'.LANG.'.php');
require('bf3conn.php');

if(isset($_GET['newrank']))
{
	$idf=mysqli_real_escape_string($dbconn, $_GET['newrank']);
	$i=0;
	$array=array("Score", "(Playtime/3600)", "Kills", "Deaths", "TKs", "Kills/Deaths", "(Score/(Playtime/60))", "(Score/Rounds)", "Rounds", "Suicide", "Killstreak", "Deathstreak");
	while($i<12){$query=mysqli_fetch_array(mysqli_query($dbconn, "SELECT sub.PlayerID, sub.StatsID AS StatsID, sub.rank AS Rank FROM (SELECT(@num := @num+1) AS rank, tsp.StatsID, tsp.PlayerID FROM tbl_playerstats tps STRAIGHT_JOIN tbl_server_player tsp ON tsp.StatsID = tps.StatsID INNER JOIN (SELECT @num := 0) x WHERE tsp.ServerID = ".SWID." ORDER BY ".$array[$i]." DESC) sub WHERE  sub.StatsID = $idf"));
			echo "<td style='text-align:center' class='cmess'>".$query['Rank']."</td>";
		$i++;
		}
}


if(isset($_GET['un']))
{
	if($_GET['un']!="")
	{
		$sdata=mysqli_real_escape_string($dbconn, $_GET['un']);
		$suq="SELECT sp.`StatsID`, pd.`PlayerID`, pd.`SoldierName` FROM `".$sqlprefix."playerdata".$suffix."` pd LEFT JOIN `".$sqlprefix."server_player".$suffix."` sp ON sp.`PlayerID`=pd.`PlayerID` AND sp.`ServerID`='".SWID."' WHERE pd.`SoldierName` LIKE '%$sdata%' LIMIT 10";
		$sur=mysqli_query($dbconn, $suq);
		while($data=mysqli_fetch_array($sur))
		{
			$response.="<a href='playerstat.php?pid=".$data['StatsID']."'>".$data['SoldierName']."</a><br />";
		}
		echo $response;
		mysqli_close($dbconn);
	}
}

if(isset($_GET['weaponstat']))
{
	echo "<table width='100%' class='cmess'>";
	$dir = dir("../weapons/".$_GET['weap']."");
	while (($file = $dir->read()) !== false)
	{
		if($file!="." && $file!="../" && $file!="./" && $file!="/" && $file!="..")
		{
			$wname=explode(".", $file);
			$name=$wname['0'];
			if($weaponstat=mysqli_fetch_array(mysqli_query($dbconn, "SELECT (`".$name."_kills`), (`".$name."_hs`), (`".$name."_deaths`)  FROM `".$sqlprefix."".mysqli_real_escape_string($dbconn,$_GET['weaponstat'])."".$suffix."` WHERE `StatsID`='".mysqli_real_escape_string($dbconn, $_GET['pid'])."'")))
			{
			echo "
				<tr>
					<td align='center' width='20%'><img src='./weapons/".$_GET['weap']."/".$file."' width='260px' /><br /></td><th width='20%'>$name</th><td width='20%'>$lng_playerstat_kills_by_weap ".$weaponstat[0]." </td><td width='20%'>$lng_playerstat_hs_by_weap ".$weaponstat[1]."</td><td width='20%'>$lng_playerstat_deaths_by_weap ".$weaponstat[2]."</td>
				</tr>
			";
			}
			else
			{
				echo"
				<tr>
					<td align='center' width='20%'><img src='./weapons/".$_GET['weap']."/".$file."' width='260px' /><br /></td><td colspan='3'><center>$lng_no_result</center></td>
				</tr>
				";
			}
		}
	}
	echo "</table>";
	$dir->close();
}

if(isset($_GET['weaponstatf']))
{
	echo "<table width='100%' class='cmess'>";
	$dir = dir("../weapons/".$_GET['weap']."");
	while (($file = $dir->read()) !== false)
	{
		if($file!="." && $file!="../" && $file!="./" && $file!="/" && $file!=".." && $file!="@eaDir")
		{
			$wname=explode(".", $file);
			$name=$wname['0'];
			if($weaponstat=mysqli_fetch_array(mysqli_query($dbconn, "SELECT SUM(wp.`".$name."_kills`), SUM(wp.`".$name."_hs`), SUM(wp.`".$name."_deaths`) FROM `".$sqlprefix."".mysqli_real_escape_string($dbconn, $_GET['weaponstatf'])."".$suffix."` wp LEFT JOIN `".$sqlprefix."server_player".$suffix."` ps ON wp.`StatsID`=ps.`StatsID` AND ps.`ServerID`='".SWID."';")))
			{
			echo "
				<tr>
					<td align='center' width='25%'><img src='./weapons/".$_GET['weap']."/".$file."' width='260px' /><br /></td><th width='25%'>$name</th><td width='25%'>$lng_playerstat_kills_by_weap ".$weaponstat[0]." </td><td width='25%'>$lng_playerstat_hs_by_weap ".$weaponstat[1]."</td>
				</tr>
			";
			}
			else
			{
				echo"
				<tr>
					<td align='center' width='25%'><img src='./weapons/".$_GET['weap']."/".$file."' width='260px' /><br /></td><td colspan='3'><center>$lng_no_result</center></td>
				</tr>
				";
			}
		}
	}
	echo "</table>";
	$dir->close();
}



if(isset($_GET['cmess']))
{
	require('database.php');
	$text=$_GET['cmess'];
	$query="SELECT cl.* FROM `".$sqlprefix."chatlog".$suffix."` cl WHERE `logSoldierName` LIKE '%".mysqli_real_escape_string($dbconn, $text)."%' OR `logMessage` LIKE '%".mysqli_real_escape_string($dbconn, $text)."%'";
	$result=mysqli_query($dbconn, $query);
	echo"
	<table width='100%' cellpadding='5' cellspacing='5' style='font-family:Arial, Helvetica, sans-serif; font-size:12px;' class='cmess'>
	<tr class='cmess'>
		<th>$lng_messwriter</th><th>$lng_messtext</th><th>$lng_messdate</th><th>$lng_messtype</th>
	</tr>
	";
	while($ndata=mysqli_fetch_array($result))
	{
		echo"
		<tr class='cmess'>
			<th>".$ndata['4']."</th><th>".$ndata['5']."</th><th>".$ndata['1']."</th><th>".$ndata['3']."</th>
		</tr>
		";
	}
	while($ndata=mysqli_fetch_array($result2))
	{
		echo"
		<tr class='cmess'>
			<th>".$ndata['4']."</th><th>".$ndata['5']."</th><th>".$ndata['1']."</th><th>".$ndata['3']."</th>
		</tr>
		";
	}
	echo"
	</table>
	";
}
?>