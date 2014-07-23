<?php require('database.php');
require('languages/'.LANG.'.php');
require('bf3conn.php');

$players = "";
$maxplayers = "";

if(isset($_GET['newrank']))
{
	$idf=mysqli_real_escape_string($dbconn, $_GET['newrank']);
	$i=0;
	$array=array("Score", "(Playtime/3600)", "Kills", "Deaths", "TKs", "Kills/Deaths", "(Score/(Playtime/60))", "(Score/Rounds)", "Rounds", "Suicide", "Killstreak", "Deathstreak");
	while($i<12)
{
$query=mysqli_fetch_array(mysqli_query($dbconn, "SELECT sub.PlayerID, sub.StatsID AS StatsID, sub.rank AS Rank FROM (SELECT(@num := @num+1) AS rank, tsp.StatsID, tsp.PlayerID FROM ".$sqlprefix."playerstats tps STRAIGHT_JOIN ".$sqlprefix."server_player tsp ON tsp.StatsID = tps.StatsID INNER JOIN (SELECT @num := 0) x WHERE tsp.ServerID = ".SWID." ORDER BY ".$array[$i]." DESC) sub WHERE  sub.StatsID = $idf"));
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
	
$results = mysqli_query($dbconn, "
			SELECT tws.`WeaponID`, tw.`Friendlyname`, tws.`Kills`, tws.`Headshots`, tws.`Deaths` FROM `".$sqlprefix."weapons_stats".$suffix."` tws 
			INNER JOIN `".$sqlprefix."weapons".$suffix."` tw ON tw.`WeaponID` = tws.`WeaponID` 
      WHERE tws.`StatsID` = '".mysqli_real_escape_string($dbconn,$_GET['pid'])."'
			AND tw.`Damagetype` = '".mysqli_real_escape_string($dbconn,$_GET['weaponstat'])."' ORDER BY tw.`Friendlyname` ASC");

if(mysqli_num_rows($results) > 0)
{
while ($row1 = mysqli_fetch_array($results))	
  {
    $players[$p] = array ($row1['Friendlyname'], $row1['Kills'], $row1['Headshots'], $row1['Deaths'] );
    $p++;
    switch (true)    
    {
      case ($row1['Friendlyname'] == 'M26Mass'):
      case strstr($row1['Friendlyname'], 'M26_Buck'):
        $m26_buc_k = $m26_buc_k + $row1['Kills'];
        $m26_buc_h = $m26_buc_h + $row1['Headshots'];
        $m26_buc_d = $m26_buc_d + $row1['Deaths'];
        break;
      case ($row1['Friendlyname'] == 'M26Mass_Flechette'):    
      case strstr($row1['Friendlyname'], 'M26_Flechette'):      
        $m26_flech_k = $m26_flech_k + $row1['Kills'];
        $m26_flech_h = $m26_flech_h + $row1['Headshots'];
        $m26_flech_d = $m26_flech_d + $row1['Deaths'];
        break;
      case ($row1['Friendlyname'] == 'M26Mass_Frag'):  
      case strstr($row1['Friendlyname'], 'M26_Frag'):      
        $m26_frag_k = $m26_frag_k + $row1['Kills'];
        $m26_frag_h = $m26_frag_h + $row1['Headshots'];
        $m26_frag_d = $m26_frag_d + $row1['Deaths'];
        break;
      case ($row1['Friendlyname'] == 'M26Mass_Slug'):  
      case strstr($row1['Friendlyname'], 'M26_Slug'):      
        $m26_slug_k = $m26_slug_k + $row1['Kills'];
        $m26_slug_h = $m26_slug_h + $row1['Headshots'];
        $m26_slug_d = $m26_slug_d + $row1['Deaths'];
        break;
      case strstr($row1['Friendlyname'], 'M320_SHG'):  
        $m320_shg_k = $m320_shg_k + $row1['Kills'];
        $m320_shg_h = $m320_shg_h + $row1['Headshots'];
        $m320_shg_d = $m320_shg_d + $row1['Deaths'];
        break;
      case strstr($row1['Friendlyname'], 'M320_HE'):
        $m320_he_k = $m320_he_k + $row1['Kills'];
        $m320_he_h = $m320_he_h + $row1['Headshots'];
        $m320_he_d = $m320_he_d + $row1['Deaths'];
        break;
      case strstr($row1['Friendlyname'], 'M320_LVG'):      
        $m320_lvg_k = $m320_lvg_k + $row1['Kills'];
        $m320_lvg_h = $m320_lvg_h + $row1['Headshots'];
        $m320_lvg_d = $m320_lvg_d + $row1['Deaths'];
        break;
      case strstr($row1['Friendlyname'], 'M320_FLASH'):      
        $m320_flash_k = $m320_flash_k + $row1['Kills'];
        $m320_flash_h = $m320_flash_h + $row1['Headshots'];
        $m320_flash_d = $m320_flash_d + $row1['Deaths'];
        break;
      case strstr($row1['Friendlyname'], 'M320_SMK'):      
        $m320_smk_k = $m320_smk_k + $row1['Kills'];
        $m320_smk_h = $m320_smk_h + $row1['Headshots'];
        $m320_smk_d = $m320_smk_d + $row1['Deaths'];
        break;
      case strstr($row1['Friendlyname'], 'M320_3GL'):
        $m320_3gl_k = $m320_3gl_k + $row1['Kills'];
        $m320_3gl_h = $m320_3gl_h + $row1['Headshots'];
        $m320_3gl_d = $m320_3gl_d + $row1['Deaths'];
        break;
      case strstr($row1['Friendlyname'], 'C4'):      
        $c4_k = $c4_k + $row1['Kills'];
        $c4_h = $c4_h + $row1['Headshots'];
        $c4_d = $c4_d + $row1['Deaths'];
        break;
      case strstr($row1['Friendlyname'], 'Claymore'):      
        $clay_k = $clay_k + $row1['Kills'];
        $clay_h = $clay_h + $row1['Headshots'];
        $clay_d = $clay_d + $row1['Deaths'];
        break;
    }
  }













$num_rows = count($players);
  foreach ($players as $weaponstat)
  {
    $weapon_name = str_replace("_"," ", $weaponstat[0]);

    if((($weaponstat[0] > 'C4') || $i == $num_rows) && ($c4_k != null))      
    {
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/C4.png'/></td><th width='30%'>C4</th><td width='15%'>$lng_playerstat_kills_by_weap $c4_k</td><td width='15%'>$lng_playerstat_hs_by_weap $c4_h</td><td width='15%'>$lng_playerstat_deaths_by_weap $c4_d</td>
      </tr>";
      $c4_k = null;
    }
    if((($weaponstat[0] > 'Claymore') || $i == $num_rows) && ($clay_k != null))      
    {
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/Claymore.png'/></td><th width='30%'>Claymore</th><td width='15%'>$lng_playerstat_kills_by_weap $clay_k</td><td width='15%'>$lng_playerstat_hs_by_weap $clay_h</td><td width='15%'>$lng_playerstat_deaths_by_weap $clay_d</td>
      </tr>";
      $clay_k = null;
    }
    if((($weaponstat[0] > 'M26Mass') || $i == $num_rows) && ($m26_buc_k != null))      
    {
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M26Mass.png'/></td><th width='30%'>M26 Mass</th><td width='15%'>$lng_playerstat_kills_by_weap $m26_buc_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m26_buc_h</td><td width='15%'>$lng_playerstat_deaths_by_weap $m26_buc_d</td>
      </tr>";
      $m26_buc_k = null;
    }
    if((($weaponstat[0] > 'M26_Mass_Flechette') || $i == $num_rows) && ($m26_flech_k != null))      
    {
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M26Mass.png'/></td><th width='30%'>M26 Mass Flechette</th><td width='15%'>$lng_playerstat_kills_by_weap $m26_flech_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m26_flech_h</td><td width='15%'>$lng_playerstat_deaths_by_weap $m26_flech_d</td>
      </tr>";
      $m26_flech_k = null;
    }
    if((($weaponstat[0] > 'M26_Mass_Frag') || $i == $num_rows) && ($m26_frag_k != null))      
    {
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M26Mass.png'/></td><th width='30%'>M26 Mass Frag</th><td width='15%'>$lng_playerstat_kills_by_weap $m26_frag_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m26_frag_h</td><td width='15%'>$lng_playerstat_deaths_by_weap $m26_frag_d</td>
      </tr>";
      $m26_frag_k = null;
    }
    if((($weaponstat[0] > 'M26_Mass_Slug') || $i == $num_rows) && ($m26_slug_k != null))      
    {
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M26Mass.png'/></td><th width='30%'>M26 Mass Slug</th><td width='15%'>$lng_playerstat_kills_by_weap $m26_slug_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m26_slug_h</td><td width='15%'>$lng_playerstat_deaths_by_weap $m26_slug_d</td>
      </tr>";
      $m26_slug_k = null;
    }
    if((($weaponstat[0] > 'M320_3GL') || $i == $num_rows) && ($m320_3gl_k != null))      
    {
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M320.png'/></td><th width='30%'>M320 3GL</th><td width='15%'>$lng_playerstat_kills_by_weap $m320_3gl_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m320_3gl_h</td><td width='15%'>$lng_playerstat_deaths_by_weap $m320_3gl_d</td>
      </tr>";
      $m320_3gl_k = null;
    }
    if((($weaponstat[0] > 'M320_FB') || $i == $num_rows) && ($m320_flash_k != null))      
    {
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M320.png'/></td><th width='30%'>M320 FB</th><td width='15%'>$lng_playerstat_kills_by_weap $m320_flash_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m320_flash_h</td><td width='15%'>$lng_playerstat_deaths_by_weap $m320_flash_d</td>
      </tr>";
      $m320_flash_k = null;
    }
    if((($weaponstat[0] > 'M320_HE') || $i == $num_rows) && ($m320_he_k != null))      
    {
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M320.png'/></td><th width='30%'>M320 HE</th><td width='15%'>$lng_playerstat_kills_by_weap $m320_he_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m320_he_h</td><td width='15%'>$lng_playerstat_deaths_by_weap $m320_he_d</td>
      </tr>";
      $m320_he_k = null;
    }
    if((($weaponstat[0] > 'M320_LVG') || $i == $num_rows) && ($m320_lvg_k != null))      
    {
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M320.png'/></td><th width='30%'>M320 LVG</th><td width='15%'>$lng_playerstat_kills_by_weap $m320_lvg_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m320_lvg_h</td><td width='15%'>$lng_playerstat_deaths_by_weap $m320_lvg_d</td>
      </tr>";
      $m320_lvg_k = null;
    }
    if((($weaponstat[0] > 'M320_SHG') || $i == $num_rows) && ($m320_shg_k != null))      
    {
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M320.png'/></td><th width='30%'>M320 SHG</th><td width='15%'>$lng_playerstat_kills_by_weap $m320_shg_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m320_shg_h</td><td width='15%'>$lng_playerstat_deaths_by_weap $m320_shg_d</td>
      </tr>";
      $m320_shg_k = null;
    }
    if((($weaponstat[0] > 'M320_SMK') || $i == $num_rows) && ($m320_smk_k != null))      
    {
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M320.png'/></td><th width='30%'>M320 SMK</th><td width='15%'>$lng_playerstat_kills_by_weap $m320_smk_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m320_smk_h</td><td width='15%'>$lng_playerstat_deaths_by_weap $m320_smk_d</td>
      </tr>";
      $m320_smk_k = null;
    }
    $i++;
    if ($weaponstat[0] == 'M26Mass') continue;
    else if (strstr($weaponstat[0], 'M26_Buck')) continue;
    else if (strstr($weaponstat[0], 'M26Mass_Flechette')) continue;
    else if (strstr($weaponstat[0], 'M26_Flechette')) continue;
    else if (strstr($weaponstat[0], 'M26Mass_Frag')) continue;
    else if (strstr($weaponstat[0], 'M26_Frag')) continue;
    else if (strstr($weaponstat[0], 'M26Mass_Slug')) continue;
    else if (strstr($weaponstat[0], 'M26_Slug')) continue;
    else if (strstr($weaponstat[0], 'M320_SHG')) continue;
    else if (strstr($weaponstat[0], 'M320_HE')) continue;
    else if (strstr($weaponstat[0], 'M320_LVG')) continue;
    else if (strstr($weaponstat[0], 'M320_FLASH')) continue;
    else if (strstr($weaponstat[0], 'M320_SMK')) continue;
    else if (strstr($weaponstat[0], 'M320_3GL')) continue;
    else if (strstr($weaponstat[0], 'C4')) continue;
    else if (strstr($weaponstat[0], 'Claymore')) continue;
    else if (strstr($weaponstat[0], 'Gameplay')) continue;   
    else if (strstr($weaponstat[0], 'Tomahawk')) continue;

							echo "
							<tr>
								<td align='center' width='25%' height='140px'><img src='weapons/".$weaponstat[0].".png'/></td>
								<th width='30%'>$weapon_name</th>
								<td width='15%'>$lng_playerstat_kills_by_weap ".$weaponstat[1]."</td>
								<td width='15%'>$lng_playerstat_hs_by_weap ".$weaponstat[2]."</td>
								<td width='15%'>$lng_playerstat_deaths_by_weap ".$weaponstat[3]."</td>
							</tr>
							";

  }


















			/*if(sizeof($players) != 0)
			{
			foreach($players as $row)
      {
        $weapon_name = str_replace("_"," ", $row['Friendlyname']);
        $killcount = $row['Kills'];
        $hscount = $row['Headshots'];
        $deathcount = $row['Deaths']; 
			
							echo "
							<tr>
								<td align='center' width='25%' height='140px'><img src='weapons/".$row['Friendlyname'].".png'/></td>
								<th width='30%'>".$row['Friendlyname']."</th>
								<td width='15%'>$lng_playerstat_kills_by_weap ".$killcount."</td>
								<td width='15%'>$lng_playerstat_hs_by_weap ".$hscount."</td>
								<td width='15%'>$lng_playerstat_deaths_by_weap ".$deathcount."</td>
							</tr>
							";
			}*/
			}
			else
			{
				echo"
				<tr>
					<td align='center' width='25%' height='140px'></td><td colspan='3'><center>$lng_no_result</center></td>
				</tr>
				";
			}
	echo "</table>";

}

if(isset($_GET['weaponstatf']))
{
  $i = 0;
  $p = 0;
  $weaponstat=mysqli_query($dbconn, "SELECT tw.`Friendlyname`, SUM(tws.`Kills`) AS Kills_sum, SUM(tws.`Headshots`) AS Head_sum, SUM(tws.`Deaths`) AS Deaths_sum FROM `".$sqlprefix."weapons_stats".$suffix."` tws 
  INNER JOIN `".$sqlprefix."weapons".$suffix."` tw ON tws.`WeaponID` = tw.`weaponID` 
  INNER JOIN `".$sqlprefix."server_player".$suffix."` tsp ON tws.`StatsID` = tsp.`StatsID` 
  WHERE tw.`Damagetype` = '".mysqli_real_escape_string($dbconn,$_GET['weaponstatf'])."' AND tsp.`ServerID` = '".SWID."' 
  GROUP BY tws.`WeaponID` 
  ORDER BY tw.`Friendlyname`" );
  
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
 WHERE tw.`Damagetype` <> 'suicide'
 AND tw.`Damagetype` <> 'none'
 AND tw.`Damagetype` <> 'nonlethal'
 AND tw.`Damagetype` <> 'vehiclelight'
 GROUP BY tws.`WeaponID`
 ORDER BY tws.`Kills` DESC");

  while ($max= mysqli_fetch_array($maxplayerkill))
  {
  $maxplayers[$max['Friendlyname']] = $max['SoldierName'];
  $statsid[$max['Friendlyname']] = $max['StatsID'];
  $killcount[$max['Friendlyname']] = $max['Kills'];
  $deathcount[$max['Friendlyname']] = $max['Deaths'];
  }

  while ($row1 = mysqli_fetch_array($weaponstat))	
  { 
    if ($row1['Kills_sum'] > $row1['Deaths_sum']) $kill = $row1['Kills_sum'];
    else $kill = $row1['Deaths_sum'];
    $players[$p] = array ($row1['Friendlyname'], $kill, $row1['Head_sum']);
    $p++;
    switch (true)    
    {
      case ($row1['Friendlyname'] == 'M26Mass'):
      case strstr($row1['Friendlyname'], 'M26_Buck'):
        $m26_buc_k = $m26_buc_k + $kill;
        $m26_buc_h = $m26_buc_h + $row1['Head_sum'];
        break;
      case ($row1['Friendlyname'] == 'M26Mass_Flechette'):    
      case strstr($row1['Friendlyname'], 'M26_Flechette'):      
        $m26_flech_k = $m26_flech_k + $kill;
        $m26_flech_h = $m26_flech_h + $row1['Head_sum'];
        break;
      case ($row1['Friendlyname'] == 'M26Mass_Frag'):  
      case strstr($row1['Friendlyname'], 'M26_Frag'):      
        $m26_frag_k = $m26_frag_k + $kill;
        $m26_frag_h = $m26_frag_h + $row1['Head_sum'];
        break;
      case ($row1['Friendlyname'] == 'M26Mass_Slug'):  
      case strstr($row1['Friendlyname'], 'M26_Slug'):      
        $m26_slug_k = $m26_slug_k + $kill;
        $m26_slug_h = $m26_slug_h + $row1['Head_sum'];
        break;
      case strstr($row1['Friendlyname'], 'M320_SHG'):  
        $m320_shg_k = $m320_shg_k + $kill;
        $m320_shg_h = $m320_shg_h + $row1['Head_sum'];
        break;
      case strstr($row1['Friendlyname'], 'M320_HE'):
        $m320_he_k = $m320_he_k + $kill;
        $m320_he_h = $m320_he_h + $row1['Head_sum'];
        break;
      case strstr($row1['Friendlyname'], 'M320_LVG'):      
        $m320_lvg_k = $m320_lvg_k + $kill;
        $m320_lvg_h = $m320_lvg_h + $row1['Head_sum'];
        break;
      case strstr($row1['Friendlyname'], 'M320_FLASH'):      
        $m320_flash_k = $m320_flash_k + $kill;
        $m320_flash_h = $m320_flash_h + $row1['Head_sum'];
        break;
      case strstr($row1['Friendlyname'], 'M320_SMK'):      
        $m320_smk_k = $m320_smk_k + $kill;
        $m320_smk_h = $m320_smk_h + $row1['Head_sum'];
        break;
      case strstr($row1['Friendlyname'], 'M320_3GL'):
        $m320_3gl_k = $m320_3gl_k + $kill;
        $m320_3gl_h = $m320_3gl_h + $row1['Head_sum'];
        break;
      case strstr($row1['Friendlyname'], 'C4'):      
        $c4_k = $c4_k + $kill;
        $c4_h = $c4_h + $row1['Head_sum'];
        break;
      case strstr($row1['Friendlyname'], 'Claymore'):      
        $clay_k = $clay_k + $kill;
        $clay_h = $clay_h + $row1['Head_sum'];
        break;
    }
  }
  echo "<table width='100%' class='cmess'>";
  $num_rows = count($players);
  foreach ($players as $weaponstat)
  {
    $weapon_name = str_replace("_"," ", $weaponstat[0]);

    if((($weaponstat[0] > 'C4') || $i == $num_rows) && ($c4_k != null))      
    {
    $c4_k_max = mysqli_fetch_array(mysqli_query($dbconn, "SELECT tws.`StatsID`, SUM(tws.`Kills`) AS Killsmax, SUM(tws.`Deaths`) AS Deathsmax, tpd.`SoldierName`  FROM `".$sqlprefix."weapons".$suffix."` tw INNER JOIN `".$sqlprefix."weapons_stats".$suffix."` tws ON tw.`WeaponID` = tws.`WeaponID` INNER JOIN `".$sqlprefix."server_player".$suffix."` tsp ON tws.`StatsID` = tsp.`StatsID` INNER JOIN `".$sqlprefix."playerdata".$suffix."` tpd ON tsp.`PlayerID` = tpd.`PlayerID` WHERE tw.`Friendlyname` LIKE '%C4%' AND tsp.`ServerID` = '".SWID."' GROUP BY tws.`StatsID` ORDER BY SUM(tws.`Kills`) DESC LIMIT 1"));
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/C4.png'/></td><th width='15%'>C4</th><td width='15%'>$lng_playerstat_kills_by_weap $c4_k</td><td width='15%'>$lng_playerstat_hs_by_weap $c4_h</td><td width='30%'>$lng_playermax_kill_by_weap <a href='playerstat.php?pid=".$c4_k_max['StatsID']."'>".$c4_k_max['SoldierName']. " </br> " .$c4_k_max['Killsmax']. " " .$lng_player_kills." </br> " .$c4_k_max['Deathsmax']. " " .$lng_player_deaths." </br> "; if ($c4_k_max['Deathsmax']==0)$c4_k_max['Deathsmax']=1; echo round(($c4_k_max['Killsmax'] / $c4_k_max['Deathsmax']), 2). " " .$lng_player_kd."</a></td>
      </tr>";
      $c4_k = null;
    }
    if((($weaponstat[0] > 'Claymore') || $i == $num_rows) && ($clay_k != null))      
    {
      $clay_k_max = mysqli_fetch_array(mysqli_query($dbconn, "SELECT tws.`StatsID`, SUM(tws.`Kills`) AS Killsmax, SUM(tws.`Deaths`) AS Deathsmax, tpd.`SoldierName`  FROM `".$sqlprefix."weapons".$suffix."` tw INNER JOIN `".$sqlprefix."weapons_stats".$suffix."` tws ON tw.`WeaponID` = tws.`WeaponID` INNER JOIN `".$sqlprefix."server_player".$suffix."` tsp ON tws.`StatsID` = tsp.`StatsID` INNER JOIN `".$sqlprefix."playerdata".$suffix."` tpd ON tsp.`PlayerID` = tpd.`PlayerID` WHERE tw.`Friendlyname` LIKE '%Claymore%' AND tsp.`ServerID` = '".SWID."' GROUP BY tws.`StatsID` ORDER BY SUM(tws.`Kills`) DESC LIMIT 1"));
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/Claymore.png'/></td><th width='15%'>Claymore</th><td width='15%'>$lng_playerstat_kills_by_weap $clay_k</td><td width='15%'>$lng_playerstat_hs_by_weap $clay_h</td><td width='30%'>$lng_playermax_kill_by_weap <a href='playerstat.php?pid=".$clay_k_max['StatsID']."'>".$clay_k_max['SoldierName']." </br> " .$clay_k_max['Killsmax']. " " .$lng_player_kills." </br> " .$clay_k_max['Deathsmax']. " " .$lng_player_deaths." </br> "; if ($clay_k_max['Deathsmax']==0)$clay_k_max['Deathsmax']=1; echo round(($clay_k_max['Killsmax'] / $clay_k_max['Deathsmax']), 2). " " .$lng_player_kd."</a></td>
      </tr>";
      $clay_k = null;
    }
    if((($weaponstat[0] > 'M26Mass') || $i == $num_rows) && ($m26_buc_k != null))      
    {
      $m26_buc_k_max = mysqli_fetch_array(mysqli_query($dbconn, "SELECT tws.`StatsID`, SUM(tws.`Kills`) AS Killsmax, SUM(tws.`Deaths`) AS Deathsmax, tpd.`SoldierName`  FROM `".$sqlprefix."weapons".$suffix."` tw INNER JOIN `".$sqlprefix."weapons_stats".$suffix."` tws ON tw.`WeaponID` = tws.`WeaponID` INNER JOIN `".$sqlprefix."server_player".$suffix."` tsp ON tws.`StatsID` = tsp.`StatsID` INNER JOIN `".$sqlprefix."playerdata".$suffix."` tpd ON tsp.`PlayerID` = tpd.`PlayerID` WHERE (tw.`Friendlyname` LIKE '%M26_Buck%' OR tw.`Friendlyname` = 'M26Mass') AND tsp.`ServerID` = '".SWID."' GROUP BY tws.`StatsID` ORDER BY SUM(tws.`Kills`) DESC LIMIT 1"));
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M26Mass.png'/></td><th width='15%'>M26 Mass</th><td width='15%'>$lng_playerstat_kills_by_weap $m26_buc_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m26_buc_h</td><td width='30%'>$lng_playermax_kill_by_weap <a href='playerstat.php?pid=$".$m26_buc_k_max['StatsID']."'>".$m26_buc_k_max['SoldierName']. " </br> " .$m26_buc_k_max['Killsmax']. " " .$lng_player_kills." </br> " .$m26_buc_k_max['Deathsmax']. " " .$lng_player_deaths." </br> "; if ($m26_buc_k_max['Deathsmax']==0)$m26_buc_k_max['Deathsmax']=1; echo round(($m26_buc_k_max['Killsmax'] / $m26_buc_k_max['Deathsmax']), 2). " " .$lng_player_kd."</a></td>
      </tr>";
      $m26_buc_k = null;
    }
    if((($weaponstat[0] > 'M26_Mass_Flechette') || $i == $num_rows) && ($m26_flech_k != null))      
    {
      $m26_flech_k_max = mysqli_fetch_array(mysqli_query($dbconn, "SELECT tws.`StatsID`, SUM(tws.`Kills`) AS Killsmax, SUM(tws.`Deaths`) AS Deathsmax, tpd.`SoldierName`  FROM `".$sqlprefix."weapons".$suffix."` tw INNER JOIN `".$sqlprefix."weapons_stats".$suffix."` tws ON tw.`WeaponID` = tws.`WeaponID` INNER JOIN `".$sqlprefix."server_player".$suffix."` tsp ON tws.`StatsID` = tsp.`StatsID` INNER JOIN `".$sqlprefix."playerdata".$suffix."` tpd ON tsp.`PlayerID` = tpd.`PlayerID` WHERE (tw.`Friendlyname` LIKE '%M26_Flechette%' OR tw.`Friendlyname` = 'M26Mass_Flechette') AND tsp.`ServerID` = '".SWID."' GROUP BY tws.`StatsID` ORDER BY SUM(tws.`Kills`) DESC LIMIT 1"));
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M26Mass.png'/></td><th width='15%'>M26 Mass Flechette</th><td width='15%'>$lng_playerstat_kills_by_weap $m26_flech_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m26_flech_h</td><td width='30%'>$lng_playermax_kill_by_weap <a href='playerstat.php?pid=".$m26_flech_k_max['StatsID']."'>".$m26_flech_k_max['SoldierName']. " </br> " .$m26_flech_k_max['Killsmax']. " " .$lng_player_kills." </br> " .$m26_flech_k_max['Deathsmax']. " " .$lng_player_deaths." </br> "; if ($m26_flech_k_max['Deathsmax']==0)$m26_flech_k_max['Deathsmax']=1; echo round(($m26_flech_k_max['Killsmax'] / $m26_flech_k_max['Deathsmax']), 2). " " .$lng_player_kd."</a></td>
      </tr>";
      $m26_flech_k = null;
    }
    if((($weaponstat[0] > 'M26_Mass_Frag') || $i == $num_rows) && ($m26_frag_k != null))      
    {
      $m26_frag_k_max = mysqli_fetch_array(mysqli_query($dbconn, "SELECT tws.`StatsID`, SUM(tws.`Kills`) AS Killsmax, SUM(tws.`Deaths`) AS Deathsmax, tpd.`SoldierName`  FROM `".$sqlprefix."weapons".$suffix."` tw INNER JOIN `".$sqlprefix."weapons_stats".$suffix."` tws ON tw.`WeaponID` = tws.`WeaponID` INNER JOIN `".$sqlprefix."server_player".$suffix."` tsp ON tws.`StatsID` = tsp.`StatsID` INNER JOIN `".$sqlprefix."playerdata".$suffix."` tpd ON tsp.`PlayerID` = tpd.`PlayerID` WHERE (tw.`Friendlyname` LIKE '%M26_Frag%' OR tw.`Friendlyname` = 'M26Mass_Frag') AND tsp.`ServerID` = '".SWID."' GROUP BY tws.`StatsID` ORDER BY SUM(tws.`Kills`) DESC LIMIT 1"));
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M26Mass.png'/></td><th width='15%'>M26 Mass Frag</th><td width='15%'>$lng_playerstat_kills_by_weap $m26_frag_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m26_frag_h</td><td width='30%'>$lng_playermax_kill_by_weap <a href='playerstat.php?pid=".$m26_frag_k_max['StatsID']."'>".$m26_frag_k_max['SoldierName']. " </br> " .$m26_frag_k_max['Killsmax']. " " .$lng_player_kills." </br> " .$m26_frag_k_max['Deathsmax']. " " .$lng_player_deaths." </br> "; if ($m26_frag_k_max['Deathsmax']==0)$m26_frag_k_max['Deathsmax']=1; echo round(($m26_frag_k_max['Killsmax'] / $m26_frag_k_max['Deathsmax']), 2). " " .$lng_player_kd."</a></td>
      </tr>";
      $m26_frag_k = null;
    }
    if((($weaponstat[0] > 'M26_Mass_Slug') || $i == $num_rows) && ($m26_slug_k != null))      
    {
      $m26_slug_k_max = mysqli_fetch_array(mysqli_query($dbconn, "SELECT tws.`StatsID`, SUM(tws.`Kills`) AS Killsmax, SUM(tws.`Deaths`) AS Deathsmax, tpd.`SoldierName`  FROM `".$sqlprefix."weapons".$suffix."` tw INNER JOIN `".$sqlprefix."weapons_stats".$suffix."` tws ON tw.`WeaponID` = tws.`WeaponID` INNER JOIN `".$sqlprefix."server_player".$suffix."` tsp ON tws.`StatsID` = tsp.`StatsID` INNER JOIN `".$sqlprefix."playerdata".$suffix."` tpd ON tsp.`PlayerID` = tpd.`PlayerID` WHERE (tw.`Friendlyname` LIKE '%M26_Slug%' OR tw.`Friendlyname` = 'M26Mass_Slug') AND tsp.`ServerID` = '".SWID."' GROUP BY tws.`StatsID` ORDER BY SUM(tws.`Kills`) DESC LIMIT 1"));
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M26Mass.png'/></td><th width='15%'>M26 Mass Slug</th><td width='15%'>$lng_playerstat_kills_by_weap $m26_slug_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m26_slug_h</td><td width='30%'>$lng_playermax_kill_by_weap <a href='playerstat.php?pid=".$m26_slug_k_max['StatsID']."'>".$m26_slug_k_max['SoldierName']. " </br> " .$m26_slug_k_max['Killsmax']. " " .$lng_player_kills." </br> " .$m26_slug_k_max['Deathsmax']. " " .$lng_player_deaths." </br> "; if ($m26_slug_k_max['Deathsmax']==0)$m26_slug_k_max['Deathsmax']=1; echo round(($m26_slug_k_max['Killsmax'] / $m26_slug_k_max['Deathsmax']), 2). " " .$lng_player_kd."</a></td>
      </tr>";
      $m26_slug_k = null;
    }
    if((($weaponstat[0] > 'M320_3GL') || $i == $num_rows) && ($m320_3gl_k != null))      
    {
      $m320_3gl_k_max = mysqli_fetch_array(mysqli_query($dbconn, "SELECT tws.`StatsID`, SUM(tws.`Kills`) AS Killsmax, SUM(tws.`Deaths`) AS Deathsmax, tpd.`SoldierName`  FROM `".$sqlprefix."weapons".$suffix."` tw INNER JOIN `".$sqlprefix."weapons_stats".$suffix."` tws ON tw.`WeaponID` = tws.`WeaponID` INNER JOIN `".$sqlprefix."server_player".$suffix."` tsp ON tws.`StatsID` = tsp.`StatsID` INNER JOIN `".$sqlprefix."playerdata".$suffix."` tpd ON tsp.`PlayerID` = tpd.`PlayerID` WHERE tw.`Friendlyname` LIKE '%M320_3GL%' AND tsp.`ServerID` = '".SWID."' GROUP BY tws.`StatsID` ORDER BY SUM(tws.`Kills`) DESC LIMIT 1"));
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M320.png'/></td><th width='15%'>M320 3GL</th><td width='15%'>$lng_playerstat_kills_by_weap $m320_3gl_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m320_3gl_h</td><td width='30%'>$lng_playermax_kill_by_weap <a href='playerstat.php?pid=".$m320_3gl_k_max['StatsID']."'>".$m320_3gl_k_max['SoldierName']. " </br> " .$m320_3gl_k_max['Killsmax']. " " .$lng_player_kills." </br> " .$m320_3gl_k_max['Deathsmax']. " " .$lng_player_deaths." </br> "; if ($m320_3gl_k_max['Deathsmax']==0)$m320_3gl_k_max['Deathsmax']=1; echo round(($m320_3gl_k_max['Killsmax'] / $m320_3gl_k_max['Deathsmax']), 2). " " .$lng_player_kd."</a></td>
      </tr>";
      $m320_3gl_k = null;
    }
    if((($weaponstat[0] > 'M320_FB') || $i == $num_rows) && ($m320_flash_k != null))      
    {
      $m320_flash_k_max = mysqli_fetch_array(mysqli_query($dbconn, "SELECT tws.`StatsID`, SUM(tws.`Kills`) AS Killsmax, SUM(tws.`Deaths`) AS Deathsmax, tpd.`SoldierName`  FROM `".$sqlprefix."weapons".$suffix."` tw INNER JOIN `".$sqlprefix."weapons_stats".$suffix."` tws ON tw.`WeaponID` = tws.`WeaponID` INNER JOIN `".$sqlprefix."server_player".$suffix."` tsp ON tws.`StatsID` = tsp.`StatsID` INNER JOIN `".$sqlprefix."playerdata".$suffix."` tpd ON tsp.`PlayerID` = tpd.`PlayerID` WHERE tw.`Friendlyname` LIKE '%M320_FLASH%' AND tsp.`ServerID` = '".SWID."' GROUP BY tws.`StatsID` ORDER BY SUM(tws.`Kills`) DESC LIMIT 1"));
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M320.png'/></td><th width='15%'>M320 FB</th><td width='15%'>$lng_playerstat_kills_by_weap $m320_flash_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m320_flash_h</td><td width='30%'>$lng_playermax_kill_by_weap <a href='playerstat.php?pid=".$m320_flash_k_max['StatsID']."'>".$m320_flash_k_max['SoldierName']. " </br> " .$m320_flash_k_max['Killsmax']. " " .$lng_player_kills." </br> " .$m320_flash_k_max['Deathsmax']. " " .$lng_player_deaths." </br> "; if ($m320_flash_k_max['Deathsmax']==0)$m320_flash_k_max['Deathsmax']=1; echo round(($m320_flash_k_max['Killsmax'] / $m320_flash_k_max['Deathsmax']), 2). " " .$lng_player_kd."</a></td>
      </tr>";
      $m320_flash_k = null;
    }
    if((($weaponstat[0] > 'M320_HE') || $i == $num_rows) && ($m320_he_k != null))      
    {
      $m320_he_k_max = mysqli_fetch_array(mysqli_query($dbconn, "SELECT tws.`StatsID`, SUM(tws.`Kills`) AS Killsmax, SUM(tws.`Deaths`) AS Deathsmax, tpd.`SoldierName`  FROM `".$sqlprefix."weapons".$suffix."` tw INNER JOIN `".$sqlprefix."weapons_stats".$suffix."` tws ON tw.`WeaponID` = tws.`WeaponID` INNER JOIN `".$sqlprefix."server_player".$suffix."` tsp ON tws.`StatsID` = tsp.`StatsID` INNER JOIN `".$sqlprefix."playerdata".$suffix."` tpd ON tsp.`PlayerID` = tpd.`PlayerID` WHERE tw.`Friendlyname` LIKE '%M320_HE%' AND tsp.`ServerID` = '".SWID."' GROUP BY tws.`StatsID` ORDER BY SUM(tws.`Kills`) DESC LIMIT 1"));
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M320.png'/></td><th width='15%'>M320 HE</th><td width='15%'>$lng_playerstat_kills_by_weap $m320_he_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m320_he_h</td><td width='30%'>$lng_playermax_kill_by_weap <a href='playerstat.php?pid=".$m320_he_k_max['StatsID']."'>".$m320_he_k_max['SoldierName']. " </br> " .$m320_he_k_max['Killsmax']. " " .$lng_player_kills." </br> " .$m320_he_k_max['Deathsmax']. " " .$lng_player_deaths." </br> "; if ($m320_he_k_max['Deathsmax']==0)$m320_he_k_max['Deathsmax']=1; echo round(($m320_he_k_max['Killsmax'] / $m320_he_k_max['Deathsmax']), 2). " " .$lng_player_kd."</a></td>
      </tr>";
      $m320_he_k = null;
    }
    if((($weaponstat[0] > 'M320_LVG') || $i == $num_rows) && ($m320_lvg_k != null))      
    {
      $m320_lvg_k_max = mysqli_fetch_array(mysqli_query($dbconn, "SELECT tws.`StatsID`, SUM(tws.`Kills`) AS Killsmax, SUM(tws.`Deaths`) AS Deathsmax, tpd.`SoldierName`  FROM `".$sqlprefix."weapons".$suffix."` tw INNER JOIN `".$sqlprefix."weapons_stats".$suffix."` tws ON tw.`WeaponID` = tws.`WeaponID` INNER JOIN `".$sqlprefix."server_player".$suffix."` tsp ON tws.`StatsID` = tsp.`StatsID` INNER JOIN `".$sqlprefix."playerdata".$suffix."` tpd ON tsp.`PlayerID` = tpd.`PlayerID` WHERE tw.`Friendlyname` LIKE '%M320_LVG%' AND tsp.`ServerID` = '".SWID."' GROUP BY tws.`StatsID` ORDER BY SUM(tws.`Kills`) DESC LIMIT 1"));
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M320.png'/></td><th width='15%'>M320 LVG</th><td width='15%'>$lng_playerstat_kills_by_weap $m320_lvg_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m320_lvg_h</td><td width='30%'>$lng_playermax_kill_by_weap <a href='playerstat.php?pid=".$m320_lvg_k_max['StatsID']."'>".$m320_lvg_k_max['SoldierName']. " </br> " .$m320_lvg_k_max['Killsmax']. " " .$lng_player_kills." </br> " .$m320_lvg_k_max['Deathsmax']. " " .$lng_player_deaths." </br> "; if ($m320_lvg_k_max['Deathsmax']==0)$m320_lvg_k_max['Deathsmax']=1; echo round(($m320_lvg_k_max['Killsmax'] / $m320_lvg_k_max['Deathsmax']), 2). " " .$lng_player_kd."</a></td>
      </tr>";
      $m320_lvg_k = null;
    }
    if((($weaponstat[0] > 'M320_SHG') || $i == $num_rows) && ($m320_shg_k != null))      
    {
      $m320_shg_k_max = mysqli_fetch_array(mysqli_query($dbconn, "SELECT tws.`StatsID`, SUM(tws.`Kills`) AS Killsmax, SUM(tws.`Deaths`) AS Deathsmax, tpd.`SoldierName`  FROM `".$sqlprefix."weapons".$suffix."` tw INNER JOIN `".$sqlprefix."weapons_stats".$suffix."` tws ON tw.`WeaponID` = tws.`WeaponID` INNER JOIN `".$sqlprefix."server_player".$suffix."` tsp ON tws.`StatsID` = tsp.`StatsID` INNER JOIN `".$sqlprefix."playerdata".$suffix."` tpd ON tsp.`PlayerID` = tpd.`PlayerID` WHERE tw.`Friendlyname` LIKE '%M320_SHG%' AND tsp.`ServerID` = '".SWID."' GROUP BY tws.`StatsID` ORDER BY SUM(tws.`Kills`) DESC LIMIT 1"));
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M320.png'/></td><th width='15%'>M320 SHG</th><td width='15%'>$lng_playerstat_kills_by_weap $m320_shg_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m320_shg_h</td><td width='30%'>$lng_playermax_kill_by_weap <a href='playerstat.php?pid=".$m320_shg_k_max['StatsID']."'>".$m320_shg_k_max['SoldierName']. " </br> " .$m320_shg_k_max['Killsmax']. " " .$lng_player_kills." </br> " .$m320_shg_k_max['Deathsmax']. " " .$lng_player_deaths." </br> "; if ($m320_shg_k_max['Deathsmax']==0)$m320_shg_k_max['Deathsmax']=1; echo round(($m320_shg_k_max['Killsmax'] / $m320_shg_k_max['Deathsmax']), 2). " " .$lng_player_kd."</a></td>
      </tr>";
      $m320_shg_k = null;
    }
    if((($weaponstat[0] > 'M320_SMK') || $i == $num_rows) && ($m320_smk_k != null))      
    {
      $m320_smk_k_max = mysqli_fetch_array(mysqli_query($dbconn, "SELECT tws.`StatsID`, SUM(tws.`Kills`) AS Killsmax, SUM(tws.`Deaths`) AS Deathsmax, tpd.`SoldierName`  FROM `".$sqlprefix."weapons".$suffix."` tw INNER JOIN `".$sqlprefix."weapons_stats".$suffix."` tws ON tw.`WeaponID` = tws.`WeaponID` INNER JOIN `".$sqlprefix."server_player".$suffix."` tsp ON tws.`StatsID` = tsp.`StatsID` INNER JOIN `".$sqlprefix."playerdata".$suffix."` tpd ON tsp.`PlayerID` = tpd.`PlayerID` WHERE tw.`Friendlyname` LIKE '%M320_SMK%' AND tsp.`ServerID` = '".SWID."' GROUP BY tws.`StatsID` ORDER BY SUM(tws.`Kills`) DESC LIMIT 1"));
      echo "        
      <tr>          
      <td align='center' width='25%' height='140px'><img src='./weapons/M320.png'/></td><th width='15%'>M320 SMK</th><td width='15%'>$lng_playerstat_kills_by_weap $m320_smk_k</td><td width='15%'>$lng_playerstat_hs_by_weap $m320_smk_h</td><td width='30%'>$lng_playermax_kill_by_weap <a href='playerstat.php?pid=".$m320_smk_k_max['StatsID']."'>".$m320_smk_k_max['SoldierName']. " </br> " .$m320_smk_k_max['Killsmax']. " " .$lng_player_kills." </br> " .$m320_smk_k_max['Deathsmax']. " " .$lng_player_deaths." </br> "; if ($m320_smk_k_max['Deathsmax']==0)$m320_smk_k_max['Deathsmax']=1; echo round(($m320_smk_k_max['Killsmax'] / $m320_smk_k_max['Deathsmax']), 2). " " .$lng_player_kd."</a></td>
      </tr>";
      $m320_smk_k = null;
    }
    $i++;
    if ($weaponstat[0] == 'M26Mass') continue;
    else if (strstr($weaponstat[0], 'M26_Buck')) continue;
    else if (strstr($weaponstat[0], 'M26Mass_Flechette')) continue;
    else if (strstr($weaponstat[0], 'M26_Flechette')) continue;
    else if (strstr($weaponstat[0], 'M26Mass_Frag')) continue;
    else if (strstr($weaponstat[0], 'M26_Frag')) continue;
    else if (strstr($weaponstat[0], 'M26Mass_Slug')) continue;
    else if (strstr($weaponstat[0], 'M26_Slug')) continue;
    else if (strstr($weaponstat[0], 'M320_SHG')) continue;
    else if (strstr($weaponstat[0], 'M320_HE')) continue;
    else if (strstr($weaponstat[0], 'M320_LVG')) continue;
    else if (strstr($weaponstat[0], 'M320_FLASH')) continue;
    else if (strstr($weaponstat[0], 'M320_SMK')) continue;
    else if (strstr($weaponstat[0], 'M320_3GL')) continue;
    else if (strstr($weaponstat[0], 'C4')) continue;
    else if (strstr($weaponstat[0], 'Claymore')) continue;
    else if (strstr($weaponstat[0], 'Gameplay')) continue;
    else if (strstr($weaponstat[0], 'Tomahawk')) continue;
      
    $maxsoldiername = $maxplayers[$weaponstat[0]];
    $pidlink = $statsid[$weaponstat[0]];
    $killcount1 = $killcount[$weaponstat[0]];
    $deathcount1 = $deathcount[$weaponstat[0]];   
    echo "        
    <tr>
    <td align='center' width='25%' height='140px'><img src='./weapons/".$weaponstat[0].".png'/></td><th width='15%'>$weapon_name</th><td width='15%'>$lng_playerstat_kills_by_weap ".$weaponstat[1]."</td><td width='15%'>$lng_playerstat_hs_by_weap ".$weaponstat[2]."</td><td width='30%'>$lng_playermax_kill_by_weap <a href='playerstat.php?pid=$pidlink'>".$maxsoldiername. "</br>" .$killcount1. " " .$lng_player_kills."</br>" .$deathcount1. " " .$lng_player_deaths."</br>"; if ($deathcount1==0)$deathcount1=1; echo round(($killcount1 / $deathcount1), 2). " " .$lng_player_kd."</a></td>
    </tr>";
  }
  echo "</table>";
}

if(isset($_GET['cmess']))
{
	require('database.php');
	$text=$_GET['cmess'];
	$query="SELECT cl.* FROM `".$sqlprefix."chatlog".$suffix."` cl WHERE `logSoldierName` LIKE '%".mysqli_real_escape_string($dbconn, $text)."%' OR `logMessage` LIKE '%".mysqli_real_escape_string($dbconn, $text)."%'";
	$result=mysqli_query($dbconn, $query);
	echo"	<table width='100%' cellpadding='5' cellspacing='5' style='font-family:Arial, Helvetica, sans-serif;
 font-size:12px;
' class='cmess'>	<tr class='cmess'>		<th>$lng_messwriter</th><th>$lng_messtext</th><th>$lng_messdate</th><th>$lng_messtype</th>	
</tr>	";
	while($ndata=mysqli_fetch_array($result))	
{
		echo"		<tr class='cmess'>			<th>".$ndata['4']."</th><th>".$ndata['5']."</th><th>".$ndata['1']."</th><th>".$ndata['3']."</th>		
		</tr>		";
	}
	while($ndata=mysqli_fetch_array($result2))	
{
		echo"		<tr class='cmess'>			<th>".$ndata['4']."</th><th>".$ndata['5']."</th><th>".$ndata['1']."</th><th>".$ndata['3']."</th>		
		</tr>		";
	}
	echo"	</table>	";
}
?>