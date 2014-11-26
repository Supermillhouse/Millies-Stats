<?php
if(!file_exists('config/database.php'))
{
	session_start();
	header('location:install.php');
	$_SESSION['install_error']="Database file not created, please enter details above. If you have already maybe you don't have write permissions?";
}
ob_start();
require('config/database.php');
require('config/bf3conn.php');
include('config/config.php');
include('config/languages/' . LANG . '.php');
header('Refresh: 30');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="./template/images/staticon.png"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?php echo $serverinfo['1']; ?> Server stats</title>
<link href="template/style.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<!--

?t=<?//=filemtime('style.css')?>


<div id="headspace">
</div>-->
<div id="menu">
	<div class="menuin">
		<?php echo MENU; ?>
   	</div>
</div>
<div class="spacer"><?php echo SERVERS; ?></div>
<div id="body">
	<div class="serverdata">
    	<div class="serverdatal"><img src="maps/<?php echo MAPIMAGE; ?>.jpg" width="445spx" height="250px" alt="" /></div>
        <div class="serverdatar">
        	<div class="servername">
            <?php echo $serverinfo['1']."&nbsp;".$lng_now; ?> 
            </div>
            <div class="serverdatastat">
            <table align="right" width="100%" border="0">
  <tr>
    <td><?php echo $lng_slots ?></td>
    <td class="result"><?php echo $serverinfo['2']."/".$serverinfo['3'] ?></td>
    <td><?php echo $lng_mode ?></td>
    <td class="result"><?php echo SMODE; ?></td>
    <td><?php echo $lng_map ?></td>
    <td class="result"><?php echo SMAP; ?></td>
  </tr>
  <tr>
    <td><?php echo $lng_allplayers ?></td>
    <td class="result"><?php echo MAXP; ?></td>
    <td><?php echo $lng_scores ?></td>
    <td class="result"><?php echo POINTS; ?></td>
    <td><?php echo $lng_dogtags ?></td>
    <td class="result"><?php echo DOGTAGS; ?></td>
  </tr>
  <tr>
    <td><?php echo $lng_kills ?></td>
    <td class="result"><?php echo KILLS; ?></td>
    <td><?php echo $lng_hshots ?></td>
    <td class="result"><?php echo HSHOTS; ?></td>
    <td><?php echo $lng_deaths ?></td>
    <td class="result"><?php echo DEATHS; ?></td>
  </tr>
  <tr>
  	<td colspan="3" style="text-align:center;"> <a href="http://battlelog.battlefield.com/bf4/servers/show/pc/<?php echo $server_url_code[SWID];?>" target="_blank"><img src="template/images/joinbtn.png" width="200px" alt=""/></a></td>
    <td colspan="3" style="text-align:center;"> <a href="<?php echo CWEBSITE; ?>" target="_blank"><img src="template/images/clanbtn.png" width="200px" alt=""/></a></td>
  </tr>
</table>

            </div>
        </div>
    </div>
    <div class="trackersname"><?php echo $lng_serverndiv; ?></div>
    <div style='width:100%' class="bodytext">
	<center>
<?php
// make an array of game modes
//$mode_array = array('Team Deathmatch'=>'TeamDeathMatchC0','Conquest Assault Large'=>'ConquestAssaultLarge0','Conquest Assault Small'=>'ConquestAssaultSmall1','Conquest Assault Small'=>'ConquestAssaultSmall0','Gun Master'=>'GunMaster0','Conquest Domination'=>'Domination0','Scavenger'=>'Scavenger0','Tank Superiority'=>'TankSuperiority0','Rush'=>'RushLarge0','Conquest Large'=>'ConquestLarge0','Conquest Small'=>'ConquestSmall0','Team Deathmatch'=>'TeamDeathMatch0','Squad Rush'=>'SquadRush0','Squad Deathmatch'=>'SquadDeathMatch0','Capture The Flag'=>'CaptureTheFlag0','Air Superiority'=>'AirSuperiority0');
// make an array of map names
//$map_array = array('Talah Market'=>'XP4_RUBBLE','Azadi Palace'=>'XP4_PARL','Markaz Monolith'=>'XP4_FD','Epicenter'=>'XP4_QUAKE','Bandar Desert'=>'XP3_DESERT','Alborz Mountains'=>'XP3_ALBORZ','Armored Shield'=>'XP3_SHIELD','Death Valley'=>'XP3_VALLEY','Scrapmetal'=>'XP2_FACTORY','Operation 925'=>'XP2_OFFICE','Donya Fortress'=>'XP2_PALACE','Ziba Tower'=>'XP2_SKYBAR','Grand Bazaar'=>'MP_001','Tehran Highway'=>'MP_003','Caspian Border'=>'MP_007','Seine Crossing'=>'MP_011','Operation Firestorm'=>'MP_012','Damavand Peak'=>'MP_013','Noshahar Canals'=>'MP_017','Kharg Island'=>'MP_018','Operation Metro'=>'MP_SUBWAY','Strike at Karkand'=>'XP1_001','Gulf of Oman'=>'XP1_002','Sharqi Peninsula'=>'XP1_003','Wake Island'=>'XP1_004','Operation Riverside'=>'XP5_001','Nebandan Flats'=>'XP5_002','Kiasar Railroad'=>'XP5_003','Sabalan Pipeline'=>'XP5_004');
// make an array of squad names
//$squad_array = array('None'=>'0','Alpha'=>'1','Bravo'=>'2','Charlie'=>'3','Delta'=>'4','Echo'=>'5','Foxtrot'=>'6','Golf'=>'7','Hotel'=>'8','India'=>'9','Juliet'=>'10','Kilo'=>'11','Lima'=>'12','Mike'=>'13','November'=>'14','Oscar'=>'15','Papa'=>'16','Quebec'=>'17','Romeo'=>'18','Sierra'=>'19','Tango'=>'20','Uniform'=>'21','Victor'=>'22','Whiskey'=>'23','X-Ray'=>'24','Yankee'=>'25','Zulu'=>'26');
// make an array of country names
//$country_array = array('Null'=>'','Unknown'=>'--','Afghanistan'=>'AF','Albania'=>'AL','Algeria'=>'DZ','American Samoa'=>'AS','Andorra'=>'AD','Angola'=>'AO','Anguilla'=>'AI','Antarctica'=>'AQ','Antigua'=>'AG','Argentina'=>'AR','Armenia'=>'AM','Aruba'=>'AW','Australia'=>'AU','Austria'=>'AT','Azerbaijan'=>'AZ','Bahamas'=>'BS','Bahrain'=>'BH','Bangladesh'=>'BD','Barbados'=>'BB','Belarus'=>'BY','Belgium'=>'BE','Belize'=>'BZ','Benin'=>'BJ','Bermuda'=>'BM','Bhutan'=>'BT','Bolivia'=>'BO','Bosnia'=>'BA','Botswana'=>'BW','Bouvet Island'=>'BV','Brazil'=>'BR','Indian Ocean'=>'IO','Brunei Darussalum'=>'BN','Bulgaria'=>'BG','Burkina Faso'=>'BF','Burundi'=>'BI','Cambodia'=>'KH','Cameroon'=>'CM','Canada'=>'CA','Cape Verde'=>'CV','Cayman Islands'=>'KY','Central Africa'=>'CF','Chad'=>'TD','Chile'=>'CL','China'=>'CN','Christmas Island'=>'CX','Cocos Islands'=>'CC','Columbia'=>'CO','Comoros'=>'KM','Congo'=>'CG','Republic of Congo'=>'CD','Cook Islands'=>'CK','Costa Rica'=>'CR','Ivory Coast'=>'CI','Croatia'=>'HR','Cuba'=>'CU','Cyprus'=>'CY','Czech Repuplic'=>'CZ','Denmark'=>'DK','Djibouti'=>'DJ','Dominica'=>'DM','Dominican Republic'=>'DO','East Timor'=>'TP','Ecuador'=>'EC','Egypt'=>'EG','El Salvador'=>'SV','Equatorial Guinea'=>'GQ','Eritrea'=>'ER','Estonia'=>'EE','Ethiopia'=>'ET','Falkland Islands'=>'FK','Faroe Islands'=>'FO','Fiji'=>'FJ','Finland'=>'FI','France'=>'FR','Metropolitan France'=>'FX','French Guiana'=>'GF','French Polynesia'=>'PF','French Territories'=>'TF','Gabon'=>'GA','Gambia'=>'GM','Georgia'=>'GE','Germany'=>'DE','Ghana'=>'GH','Gibraltar'=>'GI','Greece'=>'GR','Greenland'=>'GL','Grenada'=>'GD','Guadeloupe'=>'GP','Guam'=>'GU','Guatemala'=>'GT','Guinea'=>'GN','Guinea-Bissau'=>'GW','Guyana'=>'GY','Haiti'=>'HT','McDonald Islands'=>'HM','Vatican City'=>'VA','Honduras'=>'HN','Hong Kong'=>'HK','Hungary'=>'HU','Iceland'=>'IS','India'=>'IN','Indonesia'=>'ID','Iran'=>'IR','Iraq'=>'IQ','Ireland'=>'IE','Israel'=>'IL','Italy'=>'IT','Jamaica'=>'JM','Japan'=>'JP','Jordan'=>'JO','Kazakstan'=>'KZ','Kenya'=>'KE','Kiribati'=>'KI','North Korea'=>'KP','South Korea'=>'KR','Kuwait'=>'KW','Kyrgyzstan'=>'KG','Lao'=>'LA','Latvia'=>'LV','Lebanon'=>'LB','Lesotho'=>'LS','Liberia'=>'LR','Libya'=>'LY','Liechtenstein'=>'LI','Lithuania'=>'LT','Luxembourg'=>'LU','Macau'=>'MO','Macedonia'=>'MK','Madagascar'=>'MG','Malawi'=>'MW','Malaysia'=>'MY','Maldives'=>'MV','Mali'=>'ML','Malta'=>'MT','Marshall Islands'=>'MH','Martinique'=>'MQ','Mauritania'=>'MR','Mauritius'=>'MU','Mayotte'=>'YT','Mexico'=>'MX','Micronesia'=>'FM','Moldova'=>'MD','Monaco'=>'MC','Mongolia'=>'MN','Montserrat'=>'MS','Morocco'=>'MA','Mozambique'=>'MZ','Myanmar'=>'MM','Namibia'=>'NA','Nauru'=>'NR','Nepal'=>'NP','Netherlands'=>'NL','Netherlands Antilles'=>'AN','New Caledonia'=>'NC','New Zealand'=>'NZ','Nicaragua'=>'NI','Niger'=>'NE','Nigeria'=>'NG','Niue'=>'NU','Norfolk Island'=>'NF','Mariana Islands'=>'MP','Norway'=>'NO','Oman'=>'OM','Pakistan'=>'PK','Palau'=>'PW','Palestine'=>'PS','Panama'=>'PA','Papua New Guinea'=>'PG','Paraguay'=>'PY','Peru'=>'PE','Philippines'=>'PH','Pitcairn'=>'PN','Poland'=>'PL','Portugal'=>'PT','Puerto Rico'=>'PR','Qatar'=>'QA','Reunion'=>'RE','Romania'=>'RO','Russia'=>'RU','Rwanda'=>'RW','Saint Helena'=>'SH','Saint Kitts'=>'KN','Saint Lucia'=>'LC','Saint Pierre'=>'PM','Saint Vincent'=>'VC','Samoa'=>'WS','San Marino'=>'SM','Sao Tome'=>'ST','Saudi Arabia'=>'SA','Senegal'=>'SN','Seychelles'=>'SC','Sierra Leone'=>'SL','Singapore'=>'SG','Slovakia'=>'SK','Slovenia'=>'SI','Solomon Islands'=>'SB','Somalia'=>'SO','South Africa'=>'ZA','Sandwich Islands'=>'GS','Spain'=>'ES','Sri Lanka'=>'LK','Sudan'=>'SD','Suriname'=>'SR','Svalbard'=>'SJ','Swaziland'=>'SZ','Sweden'=>'SE','Switzerland'=>'CH','Syria'=>'SY','Taiwan'=>'TW','Tajikistan'=>'TJ','Tanzania'=>'TZ','Thailand'=>'TH','Togo'=>'TG','Tokelau'=>'TK','Tonga'=>'TO','Trinidad'=>'TT','Tunisia'=>'TN','Turkey'=>'TR','Turkmenistan'=>'TM','Turks Islands'=>'TC','Tuvalu'=>'TV','Uganda'=>'UG','Ukraine'=>'UA','United Arab Emirates'=>'AE','United Kingdom'=>'GB','United States'=>'US','US Minor Outlying Islands'=>'UM','Uruguay'=>'UY','Uzbekistan'=>'UZ','Vanuatu'=>'VU','Venezuela'=>'VE','Vietnam'=>'VN','Virgin Islands (British)'=>'VG','Virgin Islands (US)'=>'VI','Wallis and Futuna'=>'WF','Western Sahara'=>'EH','Yemen'=>'YE','Yugoslavia'=>'YU','Zambia'=>'ZM','Zimbabwe'=>'ZW');

// function to create and display scoreboard

	//global $mode_array, $map_array, $squad_array, $country_array;
	echo "
	<div class='bodytext'>
	<table style='width:100%' border='0'>
	<tr>
	<th></th>
	</tr>
	<tr>
	<td>
	";
	// query for player in server and order them by team
//	$scoreboard_players = mysqli_query($dbconn,"SELECT `TeamID` FROM `".$sqlprefix."currentplayers".$suffix."` WHERE `ServerID` = '".SWID."' ORDER BY TeamID ASC");
//	printf("Select returned %d rows.\n", mysqli_num_rows($scoreboard_players));


	if(mysqli_num_rows($scoreboard_players)==0)
	{
/*		// initialize values
		$mode_name = 'Unknown';
		$map_name = 'Unknown';
		$mode = 'Unknown';
		// figure out current game mode and map name
		$mode_query = mysqli_query($dbconn,"SELECT `mapName`, `Gamemode` FROM `".$sqlprefix."server".$suffix."` WHERE `ServerID` = '". SWID ."'");
		if(mysqli_num_rows($mode_query)!=0)
		{
			$mode_row = mysqli_fetch_assoc($mode_query);
			// convert mode to friendly name
			$mode = $mode_row['Gamemode'];
			$mode_name = array_search($mode,$mode_array);
			// convert map to friendly name
			$map_name = strtoupper($mode_row['mapName']);
			$map_name = array_search($map_name,$map_array);
		}
	*/	

		echo "
		<div style='width:100%' class='bodytext'>
      <table width='80%' align='center' border='0'>
        <tr>
          <td width='25%' style='text-align:left'> &nbsp; &nbsp; <font class='information'>Current Game Mode:</font></td>
          <td width='25%' style='text-align:left'> &nbsp; &nbsp; " . SMODE . "</td>
          <td width='25%' style='text-align:left'> &nbsp; &nbsp; <font class='information'>Current Map:</font></td>
          <td width='25%' style='text-align:left'> &nbsp; &nbsp; " . SMAP . "</td>
        </tr>
        <tr>
          <td colspan='4'>&nbsp;</td>
        </tr>
        <tr>
          <td colspan='4'><center><font class=''>No players currently in " . SERVERNAME . " server.</font></center></td>
        </tr>
      </table>
		</div>		
		";

	}
	else
	{
		echo "
		<div>
		<table width='100%' align='center' border='0'>
		<tr>
		<td>
		";
		// initialize values
/*		$mode_name = SMODE;
		$map_name = SMAP;
		$mode = 'Unknown';
		// figure out current game mode and map name
		$mode_query = mysqli_query($dbconn,"SELECT `mapName`, `Gamemode` FROM `".$sqlprefix."server".$suffix."` WHERE `ServerID` = '".SWID."'");
		if(mysqli_num_rows($mode_query)!=0)
		{
			$mode_row = mysqli_fetch_assoc($mode_query);
			// convert mode to friendly name
			$mode = $mode_row['Gamemode'];
			$mode_name = array_search($mode,$mode_array);
			// convert map to friendly name
			$map_name = strtoupper($mode_row['mapName']);
			$map_name = array_search($map_name,$map_array);
		}
	*/	// initialize values
		$mode_shown = 0;
		$last_team = -1;
		$teamscores = "Unknown";
		while($team_row = mysqli_fetch_assoc($scoreboard_players))
		{
			$this_team = $team_row['TeamID'];
			if($this_team != $last_team)
			{
				// only show the header information once
				if($mode_shown == 0)
				{
					echo "
					<table width='80%' align='center' border='0'>
					<tr>
					<td width='25%' style='text-align:right'> &nbsp; &nbsp; <font class='result'>" . $lng_mode . ":</font></td>
					<td width='25%' style='text-align:left'> &nbsp; &nbsp; <font class='result'>" . SMODE . "</font></td>
					<td width='25%' style='text-align:right'> &nbsp; &nbsp; <font class='result'>" . $lng_map . ":</font></td>
					<td width='25%' style='text-align:left'> &nbsp; &nbsp; <font class='result'>" . SMAP . "</font></td>
					</tr>
					</table>
					";
					$mode_shown = 1;
				}
				// change team name shown depending on team number
				if($this_team == 0)
				{
					$team_name = 'Loading';
				}
				else
				{
					if(MODETYPE == 'rush')
					{
            switch($this_team)
            {
              case '1': $team_name = 'Attk'; break;
              case '2': $team_name = 'Def'; break;
              default: $team_name = 'Team ' . $this_team; break;
            }
					}
					elseif(MODETYPE == 'conq')
					{
            switch($this_team)
            {
              case '1': $team_name = 'US'; break;
              case '2': $team_name = 'CH'; break;
              default: $team_name = 'Team ' . $this_team; break;
            }
					}
					elseif(MODETYPE == 'sdm' )
					{
            switch($this_team)
            {
              case '1': $team_name = 'Alpha'; break;
              case '2': $team_name = 'Bravo'; break;
              case '3': $team_name = 'Charlie'; break;
              case '4': $team_name = 'Delta'; break;
              default: $team_name = 'Team ' . $this_team; break;
            }
					}
					else
					{
						$team_name = 'Team ' . $this_team;
					}
				}
				if(($this_team == 1) && ($mode != 'SquadDeathMatch0'))
				{
				echo"<table width='100%' border='1' cellpadding='0' cellspacing='0'>
              <tr>
              <td width='50%' valign='top'>";
        }
        else if(($this_team == 2) && ($mode != 'SquadDeathMatch0'))
        {
				echo"</td>
             <td width='50%' valign='top'>";
        }
        if(($this_team == 0) && ($mode != 'SquadDeathMatch0'))
        {
        echo "
				<table width='50%' align='left' border='0'>
				<tr>";
				}
				else echo "
				<table width='100%' align='center' border='0'>
				<tr>
				";
				// change team color depending...
				if($this_team == 0)
				{
					echo "<th width='70px' class='result'>" . $team_name . "</th>";
				}
				else
				{
				$teamscore=mysqli_fetch_assoc(mysqli_query($dbconn,"SELECT `Score` FROM `".$sqlprefix."teamscores".$suffix."` WHERE `ServerID` = '".SWID."' AND `TeamID` = $this_team "));
				$teamscores=$teamscore['Score'];
					echo "
					<th colspan='3' style='text-align:right' class='result'>$lng_tickets</th><th colspan='4' style='text-align:left; color:#ff9900'>$teamscores</th>
					</tr>
					<tr>
					<th width='20px' class='result'><font class='teamname'>" . $team_name . "</font></th>";
				}
				echo "<th class='team1' colspan='2' style='text-align:left'>Player</th>";
				
				// if player is loading in, don't show the score, kills, deaths, or squad name headers
				if($this_team == 0)
				{
					echo "<th width='45px'>&nbsp;</th><th width='45px'>&nbsp;</th><th width='45px'>&nbsp;</th><th width='45px'>&nbsp;</th>";
					
				}
				else
				{
					echo"
					<th class='team1' width='65px' style='text-align:left'>" . $lng_player_point . "</th>
					<th class='team1' width='45px' style='text-align:left'>" . $lng_player_kills . "</th>
					<th class='team1' width='45px' style='text-align:left'>" . $lng_player_deaths . "</th>
					<th class='team1' width='100px' style='text-align:left'>" . $lng_player_squad . "</th>
					";
				}
				echo'</tr>';
				// query all players on this team
				$scoreboard_query = mysqli_query($dbconn,"SELECT `ServerID`, `Soldiername`, `Score`, `Kills`, `Deaths`, `TeamID`, `SquadID`, `CountryCode` FROM `".$sqlprefix."currentplayers".$suffix."` WHERE `ServerID` = '".SWID."' AND `TeamID` = $this_team ORDER BY `Score` Desc");
				if(mysqli_num_rows($scoreboard_query)!=0)
				{
					$count = 1;
					while($scoreboard_row = mysqli_fetch_assoc($scoreboard_query))
        {
	        $player = $scoreboard_row['Soldiername'];

	        // initialize value
	        $player_id = 'Unknown';
	        // query for player id
	        $query = mysqli_query($dbconn,"SELECT `PlayerID` FROM `".$sqlprefix."playerdata".$suffix."` WHERE `SoldierName` =  '$player'");
	if(mysqli_num_rows($query)!=0)
	{
		$row = mysqli_fetch_assoc($query);
		$player_id = $row['PlayerID'];

	}
	
		        // initialize value
	        $stats_id = 'Unknown';
	        // query for player id
	        $querysID = mysqli_query($dbconn,"SELECT `StatsID` FROM `".$sqlprefix."server_player".$suffix."` WHERE `PlayerID` =  '$player_id' AND `ServerID` = '".SWID."'");
	if(mysqli_num_rows($querysID)!=0)
	{
		$row = mysqli_fetch_assoc($querysID);
		$stats_id = $row['StatsID'];

	}
	
	
	$score = $scoreboard_row['Score'];
	$kills = $scoreboard_row['Kills'];
	$deaths = $scoreboard_row['Deaths'];
	$team = $scoreboard_row['TeamID'];
	$squad = $scoreboard_row['SquadID'];
	// convert squad name and country name to friendly names
	$squad_name = array_search($squad,$squad_array);
	$country = strtoupper($scoreboard_row['CountryCode']);
	$country_name = array_search($country,$country_array);
  $highlight="";
  $highlightlink="style='color:#84aace'";
	if($count&1)
    {
    $highlight="; color:#ff9900";
    $highlightlink= "style='color:#ff9900'";
    }
  if($this_team == 0)
  {
  $highlight="; color:#fff";
  $highlightlink= "style='color:#fff'";
  }
	echo "
	<tr>
	<td class='result' style='text-align:right; font-size:16px" . $highlight . "'>" . $count . ":&nbsp; </td>";
	
	
	// if player ID is not 'Unknown', make it a link
	if($player_id != "Unknown")
	{
	echo	"<td style='text-align:left; font-size:16px" . $highlight . "'> &nbsp; <a " . $highlightlink . " href='playerstat.php?pid=" .$stats_id. "'>" . $player . "</a></td>";
	}
	else
	{
		echo "<td class='result' style='text-align:left; font-size:16px" . $highlight . "'> &nbsp; " . $player . "</td>";
	}
	
	echo "<td  width='auto' class='result' style='text-align:right; font-size:16px" . $highlight . "'> &nbsp; " . $country_name . "</td>";
	// if player is loading in, don't show the score, kills, deaths, or squad name
	if($this_team == 0)
	{
		echo "
		<td style='text-align:left' colspan='4'>&nbsp;</td>
		</tr>
		";
	}
	else
	{
		echo "
		<td class='result' style='text-align:left; font-size:16px" . $highlight . "' width='65px'> &nbsp; " . $score . "</td>
		<td class='result' style='text-align:left; font-size:16px" . $highlight . "' width='45px'> &nbsp; " . $kills . "</td>
		<td class='result' style='text-align:left; font-size:16px" . $highlight . "' width='45px'> &nbsp; " . $deaths . "</td>
		<td class='result' style='text-align:left; font-size:16px" . $highlight . "' width='100px'> &nbsp; " . $squad_name . "</td>
		</tr>
		";
	}
	$count++;
}
				}
				echo "</table>";
				if(($this_team == 2) && ($mode != 'SquadDeathMatch0'))
				{ 
				echo"</td>
             </tr>
             </table>";
        }
			}
			$last_team = $this_team;
		}
		echo "
		</td>
		</tr>
		</table>
		</div>
		";
	}
	echo "
	</td></tr>
	</table>
	</div>
	<br/>
	";


?>
    </center>
    </div>
    <div class="trackersname"><?php echo $lng_chatbox; ?></div>
    <div class="bodytext">
    <table width='100%' class='cmess' style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
    <?php
	echo"
	<tr>
		<th>$lng_messwriter</th><th>$lng_messtext</th><th>$lng_messdate</th><th>$lng_messtype</th>
	</tr>
	";
	if($top10chat=mysqli_query($dbconn, "SELECT * FROM `".$sqlprefix."chatlog".$suffix."` WHERE `ServerID`='".SWID."' ORDER BY `logDate` DESC LIMIT 20"))
	{
	while($chatdata=mysqli_fetch_array($top10chat))
	{
		echo"
		<tr>
			<th>".$chatdata['logSoldierName']."</th><th>".$chatdata['logMessage']."</th><th>".$chatdata['logDate']."</th><th>".$chatdata['logSubset']."</th>
		</tr>
		";	
	}
	}
	else
	{
		echo"
		<tr>
			<th>$lng_no_chat</th>
		</tr>
		";	
	}
	?>
    		</table>
    </div>
</div>
<div class="spacer"></div>
<div id="footer"><?php echo FOOTERTEXT; ?></div>
</body>
</html>
