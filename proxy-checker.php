<?php
/*
	SamAir Proxy List Checker
	Copyright (C) 2006 The SamAir Security (http://www.samair.ru/)
	Version: 1.2 free, 2006/12/02
	Free version limitations: you can check not more than 20 proxies per attempt.
*/
set_time_limit(200);
/*
//Script configuration//////////////////////////////////////////////////////////
*/
//------------------------------------------------------------------------------
//Define what type of checked proxies do you want to save in .txt files.

//Good proxies (elite and anonymous) saved in good.txt file. You can change the name
//of this file.
$goodfilename = "good.txt";

//Do you want to save bad proxies (yes/no)?
$badproxies = "no";  // if "yes" they saved in "badproxies.txt" file

//Do you want to save transparent proxies (yes/no)?
$transparent = "no"; // if "yes" they saved in "transparent.txt" file

//Do you want to save CoDeen proxies (yes/no)?
$codeen = "yes"; // if "yes" they saved in "codeen.txt" file
//------------------------------------------------------------------------------
//Define font colors of proxy types in checking results table
//Elite proxies
$celite = "#008000";

//Anonymous proxies
$canonymous = "#000080";

//CoDeen proxies
$ccodeen = "#000000";

//Transparent proxies
$ctransparent = "#996633";

//Bad or timeouted proxies
$cbadproxy = "#999999";

/*
End of script configuration/////////////////////////////////////////////////////
*/

print "<form method=\"POST\" action=\"proxy-checker.php\">
    <p><textarea rows=\"20\" cols=\"22\" name=\"send\"></textarea></p>
    <br>
    <input type=\"checkbox\" name=\"transparent\" value=\"ON\" checked> show transparent proxies in test results
    <br>
    <br>
    <input type=\"checkbox\" name=\"badproxy\" value=\"ON\" checked> show bad proxies in test results
    <br>
    <br>
    <input type=\"checkbox\" name=\"codeen\" value=\"ON\" checked> show CoDeen proxies  in test results
    <br>
    <br>
    <input type=\"submit\" value=\"send\">

    </form>";

if(isset($_POST['send']))
{
$send = $_POST['send'];

print "Wait...<br><br>";
flush();

print "<table border=\"1\" cellpadding=\"3\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"95%\">
	<tr>
		<td bgcolor=\"#C0C0C0\" align=\"center\" width=\"33%\"><b>Proxy port:IP</b></td>
		<td bgcolor=\"#C0C0C0\" align=\"center\" width=\"33%\"><b>Type</b></td>
		<td bgcolor=\"#C0C0C0\" align=\"center\" width=\"33%\"><b>Country</b></td>
	</tr>
	";

$result = "http://www.samair.ru/proxy-service/proxyjudge.php?send=$send";
$result1 = file($result);
foreach($result1 as $line)
{
$line = trim($line);
@list($proxy, $type, $country) = explode("|", $line);

	if($type == "live CoDeeN proxy" AND !isset($_POST['codeen'])) continue;
	if($type == "transparent" AND !isset($_POST['transparent'])) continue;
	if($type == "bad proxy or timeout" AND !isset($_POST['badproxy'])) continue;

	if($type == "elite")
    {
	$fontcolor = $celite;
    $handle = fopen($goodfilename, "a");
	flock($handle,LOCK_EX);
	fwrite($handle, $proxy . "\n");
	flock($handle,LOCK_UN);
	fclose($handle);
	}
	if($type == "anonymous")
    {
	$fontcolor = $canonymous;
    $handle = fopen($goodfilename, "a");
	flock($handle,LOCK_EX);
	fwrite($handle, $proxy . "\n");
	flock($handle,LOCK_UN);
	fclose($handle);
	}
	if($type == "live CoDeeN proxy")
    {
	$fontcolor = $ccodeen;
		if($codeen == "yes")
		{
	    $handle = fopen("codeen.txt", "a");
		flock($handle,LOCK_EX);
		fwrite($handle, $proxy . "\n");
		flock($handle,LOCK_UN);
		fclose($handle);
        }
	}
	if($type == "transparent")
    {
	$fontcolor = $ctransparent;
		if($transparent == "yes")
		{
	    $handle = fopen("transparent.txt", "a");
		flock($handle,LOCK_EX);
		fwrite($handle, $proxy . "\n");
		flock($handle,LOCK_UN);
		fclose($handle);
        }
	}
	if($type == "bad proxy or timeout")
    {
	$fontcolor = $cbadproxy;
		if($badproxies == "yes")
		{
	    $handle = fopen("badproxies.txt", "a");
		flock($handle,LOCK_EX);
		fwrite($handle, $proxy . "\n");
		flock($handle,LOCK_UN);
		fclose($handle);
        }
	}
@$type = "<font color=\"". $fontcolor . "\">" . $type . "</font>";
print "<tr><td>" . $proxy . "</td><td>" . $type . "</td><td>" . $country . "</td></tr>\n";
}

print "<tr><td height=\"25\" colspan=\"3\" align=\"center\" valign=\"middle\"><small>Powered by <a href=\"http://samair.ru/\">SamAir Security</a></small></td></tr>\n";
print "</table>";

}

?>
