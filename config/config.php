<?php
$infocount = 1;
$timeout = 2;

for ($i=0; $i<=$infocount; $i++){
	$fp = @fsockopen (SERVER_IP, SERVER_PORT, $errno, $errstr, $timeout);
	$serverinfo=mysqli_fetch_array(mysqli_query($dbconn, "SELECT IP_Address, ServerName, usedSlots, maxSlots, mapName, Gamemode FROM ".$sqlprefix."server".$suffix." WHERE `ServerID`='".SWID."'"));
	$serverdata=$serverinfo;
	define("SERVEROK", 0);
	$map=$serverinfo[4];
	$playmode=$serverinfo[5];
	$serverinfo[1].="&nbsp;";
}

if(!file_exists('config/database.php'))
{
	header('location:install.php');
}
else
{
	include('config/database.php');
	include('config/languages/'.LANG.'.php');
	if(file_exists('install.php'))
	{
		echo"
		<div id='installerror'>$lng_install_error</div>
		";
	}
	$scoreboard_players = mysqli_query($dbconn,"SELECT `TeamID` FROM `".$sqlprefix."currentplayers".$suffix."` WHERE `ServerID` = '".SWID."' ORDER BY TeamID ASC");
//  $teamscore=mysqli_fetch_array(mysqli_query($dbconn, "SELECT ServerID, Score FROM ".$sqlprefix."teamscores".$suffix." WHERE `TeamID`='".SWID."'"));
	$dogtags=mysqli_fetch_array(mysqli_query($dbconn, "SELECT SUM(`Count`) FROM `".$sqlprefix."dogtags".$suffix."`"));
	$score=mysqli_fetch_array(mysqli_query($dbconn, "SELECT COUNT(`StatsID`), SUM(`Score`), SUM(`Headshots`), SUM(`Kills`), SUM(`Deaths`) FROM `".$sqlprefix."playerstats".$suffix."`"));
	switch($map)
	{
		case "MP_001": $sname="Grand Bazaar"; $simage="mp_001"; break;
		case "MP_003": $sname="Tehran Highway"; $simage="mp_003"; break;
		case "MP_007": $sname="Caspian Border"; $simage="mp_007"; break;
		case "MP_011": $sname="Seine Crossing"; $simage="mp_011"; break;
		case "MP_012": $sname="Operation Firestorm"; $simage="mp_012"; break;
		case "MP_013": $sname="Damavand Peak"; $simage="mp_013"; break;
		case "MP_017": $sname="Noshahr Canals"; $simage="mp_017"; break;
		case "MP_018": $sname="Kharg Island"; $simage="mp_018"; break;
		case "MP_Subway": $sname="Operation Metro"; $simage="mp_subway"; break;
		case "XP1_001": $sname="Strike At Karkand"; $simage="xp1_001"; break;
		case "XP1_002": $sname="Gulf of Oman"; $simage="xp1_002"; break;
		case "XP1_003": $sname="Sharqi Peninsula"; $simage="xp1_003"; break;
		case "XP1_004": $sname="Wake Island"; $simage="xp1_004"; break;
		case "XP2_Factory": $sname="Scrapmetal"; $simage="xp2_factory"; break;
		case "XP2_Office": $sname="Operation 925"; $simage="xp2_office"; break;
		case "XP2_Palace": $sname="Donya Fortress"; $simage="xp2_palace"; break;
		case "XP2_Skybar": $sname="Ziba Tower"; $simage="xp2_skybar"; break;
		case "XP3_Desert": $sname="Bandar Desert"; $simage="xp3_desert"; break;
		case "XP3_Alborz": $sname="Alborz Mountains"; $simage="xp3_alborz"; break;
		case "XP3_Shield": $sname="Armored Shield"; $simage="xp3_shield"; break;
		case "XP3_Valley": $sname="Death Valley"; $simage="xp3_valley"; break;
		case "XP4_Quake": $sname="Epicenter"; $simage="xp4_quake"; break;
		case "XP4_FD": $sname="Markaz Monolith"; $simage="xp4_fd"; break;
		case "XP4_Parl": $sname="Azadi Palace"; $simage="xp4_parl"; break;
		case "XP4_Rubble": $sname="Talah Market"; $simage="xp4_rubble"; break;
    case "XP5_001": $sname="Operation Riverside"; $simage="xp5_001"; break;
    case "XP5_002": $sname="Nebandan Flats"; $simage="xp5_002"; break;
    case "XP5_003": $sname="Kiasar Railroad"; $simage="xp5_003"; break;
    case "XP5_004": $sname="Sabalan Pipeline"; $simage="xp5_004"; break;
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
		case "": $sname=""; $simage=""; break;
	}
	switch($playmode)
	{
		case "ConquestLarge0": $mode="Conquest Large"; $modetype="conq"; break;
		case "ConquestSmall0": $mode="Conquest Small"; $modetype="conq"; break;
		case "RushLarge0": $mode="Rush"; $modetype="rush"; break;
		case "SquadRush0": $mode="Squad Rush"; $modetype="rush"; break;
		case "SquadDeathMatch0": $mode="Squad Deathmatch"; $modetype="sdm"; break;
		case "TeamDeathMatch0": $mode="Team Deathmatch"; $modetype="conq"; break;	
		case "ConquestAssaultLarge0": $mode="Conquest Assault 64"; $modetype="conq"; break;
		case "ConquestAssaultSmall0": $mode="Conquest Assault"; $modetype="conq"; break;
		case "ConquestAssaultSmall1": $mode="Conquest Assault"; $modetype="conq"; break;
		case "TeamDeathMatchC0": $mode="TDM Close Quarters"; $modetype="conq"; break;	
    case "Domination0": $mode="Conquest Domination"; $modetype="conq"; break;
    case "GunMaster0": $mode="Gun Master"; $modetype="conq"; break;
    case "TankSuperiority0": $mode="Tank Superiority"; $modetype="conq"; break;
    case "Scavenger0": $mode="Scavenger"; $modetype="conq"; break;
    case "CaptureTheFlag0": $mode="Capture The Flag"; $modetype="conq"; break;
    case "AirSuperiority0": $mode="Air Superiority"; $modetype="conq"; break;
    case "Elimination0": $mode="Defuse"; $modetype="conq"; break;
    case "Obliteration": $mode="Obliteration"; $modetype="conq"; break;
    case "": $mode=""; break;
	}
	
	$squad_array = array('None'=>'0','Alpha'=>'1','Bravo'=>'2','Charlie'=>'3','Delta'=>'4','Echo'=>'5','Foxtrot'=>'6','Golf'=>'7','Hotel'=>'8','India'=>'9','Juliet'=>'10','Kilo'=>'11','Lima'=>'12','Mike'=>'13','November'=>'14','Oscar'=>'15','Papa'=>'16','Quebec'=>'17','Romeo'=>'18','Sierra'=>'19','Tango'=>'20','Uniform'=>'21','Victor'=>'22','Whiskey'=>'23','X-Ray'=>'24','Yankee'=>'25','Zulu'=>'26');
  $country_array = array('Null'=>'','Unknown'=>'--','Afghanistan'=>'AF','Albania'=>'AL','Algeria'=>'DZ','American Samoa'=>'AS','Andorra'=>'AD','Angola'=>'AO','Anguilla'=>'AI','Antarctica'=>'AQ','Antigua'=>'AG','Argentina'=>'AR','Armenia'=>'AM','Aruba'=>'AW','Australia'=>'AU','Austria'=>'AT','Azerbaijan'=>'AZ','Bahamas'=>'BS','Bahrain'=>'BH','Bangladesh'=>'BD','Barbados'=>'BB','Belarus'=>'BY','Belgium'=>'BE','Belize'=>'BZ','Benin'=>'BJ','Bermuda'=>'BM','Bhutan'=>'BT','Bolivia'=>'BO','Bosnia'=>'BA','Botswana'=>'BW','Bouvet Island'=>'BV','Brazil'=>'BR','Indian Ocean'=>'IO','Brunei Darussalum'=>'BN','Bulgaria'=>'BG','Burkina Faso'=>'BF','Burundi'=>'BI','Cambodia'=>'KH','Cameroon'=>'CM','Canada'=>'CA','Cape Verde'=>'CV','Cayman Islands'=>'KY','Central Africa'=>'CF','Chad'=>'TD','Chile'=>'CL','China'=>'CN','Christmas Island'=>'CX','Cocos Islands'=>'CC','Columbia'=>'CO','Comoros'=>'KM','Congo'=>'CG','Republic of Congo'=>'CD','Cook Islands'=>'CK','Costa Rica'=>'CR','Ivory Coast'=>'CI','Croatia'=>'HR','Cuba'=>'CU','Cyprus'=>'CY','Czech Repuplic'=>'CZ','Denmark'=>'DK','Djibouti'=>'DJ','Dominica'=>'DM','Dominican Republic'=>'DO','East Timor'=>'TP','Ecuador'=>'EC','Egypt'=>'EG','El Salvador'=>'SV','Equatorial Guinea'=>'GQ','Eritrea'=>'ER','Estonia'=>'EE','Ethiopia'=>'ET','Falkland Islands'=>'FK','Faroe Islands'=>'FO','Fiji'=>'FJ','Finland'=>'FI','France'=>'FR','Metropolitan France'=>'FX','French Guiana'=>'GF','French Polynesia'=>'PF','French Territories'=>'TF','Gabon'=>'GA','Gambia'=>'GM','Georgia'=>'GE','Germany'=>'DE','Ghana'=>'GH','Gibraltar'=>'GI','Greece'=>'GR','Greenland'=>'GL','Grenada'=>'GD','Guadeloupe'=>'GP','Guam'=>'GU','Guatemala'=>'GT','Guinea'=>'GN','Guinea-Bissau'=>'GW','Guyana'=>'GY','Haiti'=>'HT','McDonald Islands'=>'HM','Vatican City'=>'VA','Honduras'=>'HN','Hong Kong'=>'HK','Hungary'=>'HU','Iceland'=>'IS','India'=>'IN','Indonesia'=>'ID','Iran'=>'IR','Iraq'=>'IQ','Ireland'=>'IE','Israel'=>'IL','Italy'=>'IT','Jamaica'=>'JM','Japan'=>'JP','Jordan'=>'JO','Kazakstan'=>'KZ','Kenya'=>'KE','Kiribati'=>'KI','North Korea'=>'KP','South Korea'=>'KR','Kuwait'=>'KW','Kyrgyzstan'=>'KG','Lao'=>'LA','Latvia'=>'LV','Lebanon'=>'LB','Lesotho'=>'LS','Liberia'=>'LR','Libya'=>'LY','Liechtenstein'=>'LI','Lithuania'=>'LT','Luxembourg'=>'LU','Macau'=>'MO','Macedonia'=>'MK','Madagascar'=>'MG','Malawi'=>'MW','Malaysia'=>'MY','Maldives'=>'MV','Mali'=>'ML','Malta'=>'MT','Marshall Islands'=>'MH','Martinique'=>'MQ','Mauritania'=>'MR','Mauritius'=>'MU','Mayotte'=>'YT','Mexico'=>'MX','Micronesia'=>'FM','Moldova'=>'MD','Monaco'=>'MC','Mongolia'=>'MN','Montserrat'=>'MS','Morocco'=>'MA','Mozambique'=>'MZ','Myanmar'=>'MM','Namibia'=>'NA','Nauru'=>'NR','Nepal'=>'NP','Netherlands'=>'NL','Netherlands Antilles'=>'AN','New Caledonia'=>'NC','New Zealand'=>'NZ','Nicaragua'=>'NI','Niger'=>'NE','Nigeria'=>'NG','Niue'=>'NU','Norfolk Island'=>'NF','Mariana Islands'=>'MP','Norway'=>'NO','Oman'=>'OM','Pakistan'=>'PK','Palau'=>'PW','Palestine'=>'PS','Panama'=>'PA','Papua New Guinea'=>'PG','Paraguay'=>'PY','Peru'=>'PE','Philippines'=>'PH','Pitcairn'=>'PN','Poland'=>'PL','Portugal'=>'PT','Puerto Rico'=>'PR','Qatar'=>'QA','Reunion'=>'RE','Romania'=>'RO','Russia'=>'RU','Rwanda'=>'RW','Saint Helena'=>'SH','Saint Kitts'=>'KN','Saint Lucia'=>'LC','Saint Pierre'=>'PM','Saint Vincent'=>'VC','Samoa'=>'WS','San Marino'=>'SM','Sao Tome'=>'ST','Saudi Arabia'=>'SA','Senegal'=>'SN','Seychelles'=>'SC','Sierra Leone'=>'SL','Singapore'=>'SG','Slovakia'=>'SK','Slovenia'=>'SI','Solomon Islands'=>'SB','Somalia'=>'SO','South Africa'=>'ZA','Sandwich Islands'=>'GS','Spain'=>'ES','Sri Lanka'=>'LK','Sudan'=>'SD','Suriname'=>'SR','Svalbard'=>'SJ','Swaziland'=>'SZ','Sweden'=>'SE','Switzerland'=>'CH','Syria'=>'SY','Taiwan'=>'TW','Tajikistan'=>'TJ','Tanzania'=>'TZ','Thailand'=>'TH','Togo'=>'TG','Tokelau'=>'TK','Tonga'=>'TO','Trinidad'=>'TT','Tunisia'=>'TN','Turkey'=>'TR','Turkmenistan'=>'TM','Turks Islands'=>'TC','Tuvalu'=>'TV','Uganda'=>'UG','Ukraine'=>'UA','United Arab Emirates'=>'AE','United Kingdom'=>'GB','United States'=>'US','US Minor Outlying Islands'=>'UM','Uruguay'=>'UY','Uzbekistan'=>'UZ','Vanuatu'=>'VU','Venezuela'=>'VE','Vietnam'=>'VN','Virgin Islands (British)'=>'VG','Virgin Islands (US)'=>'VI','Wallis and Futuna'=>'WF','Western Sahara'=>'EH','Yemen'=>'YE','Yugoslavia'=>'YU','Zambia'=>'ZM','Zimbabwe'=>'ZW');

	
/*	if(SERVEROK==1)
	{
		define("SIP", $serverdata['1']);
		define("SERVERNAME", $serverdata['2']);
		define("AKTPLAYERS", $serverdata['3']);
		define("SLOTS", $serverdata['3']."/".$serverdata['4']);
	}
	else
	{*/
	define("SIP", $serverdata['0']);
	define("SERVERNAME", $serverdata['1']);
	define("AKTPLAYERS", $serverdata['2']);
	define("SLOTS", $serverdata['2']."/".$serverdata['3']);
//	}
	define("SMODE", $mode);
	define("SMAP", $sname);
	define("MAPIMAGE", $simage);
	define("MAXP", $score['0']);
	define("POINTS", $score['1']);
	define("HSHOTS", $score['2']);
	define("KILLS", $score['3']);
	define("DEATHS", $score['4']);
	define("DOGTAGS", $dogtags['0']);
	define("MODETYPE", $modetype);
	define("TEAM1SCORE", $teamscore['1']);
//}	
	define("MENU", "<a href='index.php'>$lng_home</a><a href='players.php'>$lng_players</a><a href='maps.php'>$lng_maps</a><a href='messages.php'>$lng_messages</a>");
//	<a href='weapons.php'>$lng_weapons</a>
	define("FOOTERTEXT", "  Original Code and Design By: <a href='http://www.multi-gaming.hu/index.php' target='_blank'>[RMG] Dr4k3</a> &copy; 2012 | Server Stat By: <a href='http://sourceforge.net/projects/bf3conn/' target='_blank'>BF3_Conn</a> | Modified By : <a href='http://www.slagsareus.com' target='_blank'>[SLAG] Supermillhouse</a> | Procon plugin by: <a href='https://forum.myrcon.com/showthread.php?6698' target='_blank'>XpKiller</a><br/><br /><h3>v0.0.1.1</h3>");
}
?>