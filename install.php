<?php
session_start();
$errormsg="";
if(file_exists('config/database.php'))
{
	header('location:index.php');
}
if(isset($_POST['sqlhost']))
{
	if(empty($_POST['sqlhost']) || empty($_POST['sqluser']) || empty($_POST['sqlpass']) || empty($_POST['sqlpassa']) || empty($_POST['sqldb']) || empty($_POST['prefix']) || empty($_POST['clanname']) || empty($_POST['server_url_code1']))
	{
		$errormsg="Please fill all the data field!";
	}
	else
	{
		if($_POST['sqlpass']!=$_POST['sqlpassa'])
		{
			$errormsg="The two sql password did not match!";
		}
		else
		{
			$dconfig=fopen("config/database.php","w+");
			fputs($dconfig,
			"<?php \n\n\n".
			"error_reporting(0);\n\n\n\n".
			"\$sqlhost=\"".$_POST['sqlhost']."\"; \n".
			"\$sqluser=\"".$_POST['sqluser']."\"; \n".
			"\$sqlpass=\"".$_POST['sqlpass']."\"; \n".
			"\$sqldb=\"".$_POST['sqldb']."\"; \n".
			"\$sqlprefix=\"".$_POST['prefix']."\"; \n".
			"\$server_url_code[1]=\"".$_POST['server_url_code1']."\"; \n".
			"\$server_url_code[2]=\"".$_POST['server_url_code2']."\"; \n".
			"\$server_url_code[3]=\"".$_POST['server_url_code3']."\"; \n".
			"\$server_url_code[4]=\"".$_POST['server_url_code4']."\"; \n".
			"\$server_url_code[5]=\"".$_POST['server_url_code5']."\"; \n".
			"\$suffix=\"".$_POST['suffix']."\"; \n\n\n".
			"define(\"CWEBSITE\", \"".$_POST['clanname']."\");\n".
			"define(\"LANG\", \"".$_POST['lang']."\");\n\n\n".
			"\$dbconn= new mysqli(\$sqlhost, \$sqluser, \$sqlpass, \$sqldb);\n".
			"mysqli_query(\$dbconn, \"utf8\"); \n".
			"?> \n"
			);
			header('location:index.php');
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="./template/images/staticon.png">
<title>Private Server Stat Installation page</title>
<style>
body{
	background-color:#000;
	background-image:url(template/images/bg.jpg);
	background-repeat:no-repeat;
	background-position:top center;
	background-size:100% auto;
}

#serverdatas{
	background-image:url(template/images/bg.png);
	position:absolute;
	top:28%;
	left:50%;
	margin-left:-401px;
	width:800px;
	text-align:justify;
	border:1px solid #000;
	box-shadow:0px 0px 15px #fff;
	-moz-box-shadow:0px 0px 15px #fff;
	-webkit-box-shadow:0px 0px 15px #fff;
	color:#FFF;
}

.top{
	background-image:url(template/images/top.png);
	background-position:top center;
	background-repeat:no-repeat;
	height:61px;
	background-color:transparent;
	font-size:17px;
	font-weight:bold;
	color:#d9d9d9 !important;;
}

.button{
	background-image:url(template/images/btn.jpg);
	width:113px;
	height:41px;
	display:block;
	border:none;
	font-weight:bold;
	cursor:pointer;
	opacity:0.7;
}

input{
	opacity:0.7;
}

td{
	padding:5px;
}
</style>
</head>

<body>
<div id="serverdatas">
<form name="installform" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
	<table width="100%" cellpadding="1" cellspacing="1">
        <tr>
        	<td class='top' colspan="2"><center>Installation page of the server stat</center></td>
        </tr>
        <tr>
			<td>Clan website url:</td><td><input type="text" name="clanname" value="<?php echo $_POST['clanname']; ?>" />Your clan website e.g.http://www.example.com</td>
        </tr>
        <tr>
			<td>Site language:</td><td><select name="lang" id="lang"><option value="en">English</option></select> Default value: English</td>
        </tr>
    	<tr>
			<td>Mysql Server Host:</td><td><input type="text" name="sqlhost" value="localhost" /> Default value:localhost</td>
        </tr>
        <tr>
    		<td>Mysql Server User:</td><td><input type="text" name="sqluser" value="<?php echo $_POST['sqluser']; ?>" /> Do not use root user</td>
        </tr>
        <tr>
        	<td>Mysql Server Password:</td><td><input type="password" name="sqlpass" /></td>
        </tr>
        <tr>
        	<td>Mysql Server Password Again:</td><td><input type="password" name="sqlpassa" /></td>
        </tr>
        <tr>
        	<td>Mysql Server Database:</td><td><input type="text" name="sqldb" value="<?php echo $_POST['sqldb']; ?>" /></td>
        </tr>
        <tr>
        	<td>Mysql Table Prefix:</td><td><input type="text" name="prefix" value="<?php echo $_POST['prefix']; ?>" /> Like: tbl_ or table_</td>
        </tr>
        <tr>
        	<td>Mysql Table suffix</td><td><input type="text" name="suffix" value="<?php echo $_POST['suffix']; ?>" /></td>
        </tr>
        <tr>
        	<td>1st Game Server URL Code</td><td><input type="text" name="server_url_code1" value="<?php echo $_POST['server_url_code1']; ?>" /> Like: ac8ca391-f9b8-4fa6-bcec-4c369e6c40b4</td>
        </tr>
        <tr>
        	<td>2nd Game Server URL Code</td><td><input type="text" name="server_url_code2" value="<?php echo $_POST['server_url_code2']; ?>" /></td>
        </tr>
        <tr>
        	<td>3rd Game Server URL Code</td><td><input type="text" name="server_url_code3" value="<?php echo $_POST['server_url_code3']; ?>" /></td>
        </tr>
        <tr>
        	<td>4th Game Server URL Code</td><td><input type="text" name="server_url_code4" value="<?php echo $_POST['server_url_code4']; ?>" /></td>
        </tr>
        <tr>
        	<td>5th Game Server URL Code</td><td><input type="text" name="server_url_code8" value="<?php echo $_POST['server_url_code5']; ?>" /></td>
        </tr>
        <tr>
        	<td colspan="2" style="color:red;"><center><?php echo $errormsg; ?><br /><?php echo $_SESSION['install_error']; ?></center></td>
        </tr>
        <tr>
        	<td colspan="2"><center><input type="submit" class="button" value="Save" /></center></td>
        </tr>
    </table>
</form>
</div>
</body>
</html>