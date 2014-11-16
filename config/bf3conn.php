<?php
require('database.php');
/*
 * BF3Conn - PHP class for communicating with a Battlefield 3 gameserver
 * http://sf.net/p/bf3conn/
 * Copyright (c) 2010 by JLNNN <JLN@hush.ai>
 * Copyright (c) 2011 by an3k <an3k@users.sf.net>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 */

/**
 * <b>Project page:</b>
 * http://sf.net/p/bf3conn/<br />
 * <br /><br />
 * <b>Message board:</b><br /><br />
 * http://sf.net/p/bf3conn/discussion/<br />
 * <br /><br />
 * <b>Support:</b><br /><br />
 * http://sf.net/p/bf3conn/support/
 *
 * @author an3k <an3k@users.sf.net>
 * @version 0.91b
 *
 */
$allserver=mysqli_query($dbconn, "SELECT `ServerID`, `ServerName` FROM ".$sqlprefix."server".$suffix."");
while($servers=mysqli_fetch_array($allserver))
{
	$slinks.="<a href=\"".$_SERVER['PHP_SELF']."?server=".$servers['0']."\">".$servers['1']."</a>";
}

define("SERVERS", $slinks);
if(isset($_GET['server']) && is_numeric($_GET['server']))
{
	define("SWID", $_GET['server']);
}
if(!defined(SWID))
{
	define("SWID", 1);
}
$serverdata=mysqli_fetch_array(mysqli_query($dbconn, "SELECT `IP_Address` FROM ".$sqlprefix."server".$suffix." WHERE `ServerID`='".SWID."'"));
$ipd=explode(":", $serverdata['0']);
if($ipd['0']=="" || $ipd['1']=="")
{
	$serverdata=mysqli_fetch_array(mysqli_query($dbconn, "SELECT `IP_Address` FROM ".$sqlprefix."server".$suffix." WHERE `ServerID`='1'"));
	$ipd=explode(":", $serverdata['0']);
}

define("SERVER_IP", $ipd['0']);
define("SERVER_PORT", $ipd['1']);
 

?>