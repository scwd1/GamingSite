<?php 
require('class/user.php');
/* Debug: Change 0 to 1 */
ini_set('display_errors', 1);
date_default_timezone_set('America/Los_Angeles');
if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
/*if ($_GET['m']=="1"){
echo '<p id="msg" style="display:none;"><table bgcolor="yellow"><td style="color:black;"><center><font style="font-size:15px;">Refund request has been sent, a refund moderator will flag the player.</font></center></td></table></p>';
}elseif ($_GET['m']=="2"){
echo '<p id="msg" style="display:none;"><table bgcolor="yellow"><td style="color:black;"><center><font style="font-size:15px;">Punishment request has been sent.</font></center></td></table></p>';
}elseif ($_GET['m']=="3"){
echo '<p id="msg" style="display:none;"><table bgcolor="yellow"><td style="color:black;"><center><font style="font-size:15px;font-weight:bold;">You may only check-in once per day.</font></center></td></table></p>';
}elseif ($_GET['m']=="4"){
echo '<p id="msg" style="display:none;"><table bgcolor="yellow"><td style="color:black;"><center><font style="font-size:15px;font-weight:bold;">You have successfully checked in.</font></center></td></table></p>';
}*/
//echo '<p><table bgcolor="green"><td style="color:white;font-weight:bold;"><center><font style="font-size:15px;"><img src="global/images/excla.png" height="20">  A brand new version of the CMS is coming soon. Be prepared</font></center></td></table></p>';

//echo '<p><table bgcolor="yellow"><td style="color:black;font-weight:bold;"><center><font style="font-size:15px;"><img src="global/images/excla.png" height="20"> Test of CMS v5.0</font></center></td></table></p>';

function Susp($inf) {
	if($inf['Disabled'] == "1") {
		$suspendredir = '<meta http-equiv="refresh" content="0;url=suspended.php">';
		echo $suspendredir;
		exit();
	}
}
Susp($inf);


function OnLeave($inf) {
	/*$onleavechkquery = mysqli_query($mysqli,"SELECT * FROM `cp_leave` WHERE `user_id` = '$inf[id]' && `date_leave` < DATE(NOW()) && `date_return` > DATE(NOW()) ORDER BY `id` ASC LIMIT 1");
	$numchk = mysqli_num_rows($onleavechkquery);
	$onleavechk = mysqli_fetch_array($onleavechkquery);
	if($numchk == 1) {
		$onleaveredir = '<meta http-equiv="refresh" content="0;url=http://'.$_SERVER["SERVER_NAME"].'/onleave.php?id='.$onleavechk["id"].'">';
		echo $onleaveredir;
		exit();
	}*/
}
if($_SERVER['SCRIPT_NAME'] != "/onleave.php") { OnLeave($inf); }


function Strikeout() {
	/*$query = mysqli_query($mysqli,"SELECT *  FROM `login_strikes` WHERE `ip_address` = '$_SERVER[REMOTE_ADDR]'");
	$result = mysqli_num_rows($query);
	if($result >= 5) {
		echo '<meta http-equiv="refresh" content="0;url=ipban.php">';
		exit();
	}*/
}
Strikeout();

function UserMissing($inf)
{
	echo '<meta http-equiv="refresh" content="0;url=/login.php">';
	session_destroy();
	exit();
}

if($inf['Username'] == "") UserMissing($inf);

function AutoComplete()
{
	if(preg_match("/staff/", $_SERVER["PHP_SELF"] ))
	{
		print "
			<script type='text/javascript' src='../global/js/jquery-1.4.2.min.js'></script>
			<script type='text/javascript' src='../global/js/jquery-ui-1.8.2.custom.min.js'></script>
			<link rel='stylesheet' href='../global/css/smoothness/jquery-ui-1.8.2.custom.css' />
			<script type='text/javascript'>
				jQuery(document).ready(function(){
					$('#accountsearch').autocomplete({source:'../global/source/accounts.php', minLength:2});
				});
			</script>
		";
	}
	else
	{
		print "
			<script type='text/javascript' src='global/js/jquery-1.4.2.min.js'></script>
			<script type='text/javascript' src='global/js/jquery-ui-1.8.2.custom.min.js'></script>
			<link rel='stylesheet' href='global/css/smoothness/jquery-ui-1.8.2.custom.css' />
			<script type='text/javascript' 
				jQuery(document).ready(function(){
					$('#accountsearch').autocomplete({source:'global/source/accounts.php', minLength:2});
				});
			</script>
		";
	}
}

//Removing archive function - No longer needed
/*function Archive($inf) {
	if($inf['gid'] == "0") {
		$archiveredir = '<meta http-equiv="refresh" content="0;url=archived.php">';
		echo $archiveredir;
		exit();
	}
}

Archive($inf);*/

function Nav($inf,$access) {
?>
	<div id='navigation'> 
		<?php 
		if(preg_match("/staff/", $_SERVER["PHP_SELF"])) {
			require('../staff/nav.php');
		} else {
			require('./nav.php');
		}
		?>
	</div></div>

<?php
}

function doLog($user, $section, $area, $details, $mysqli) {
$ip = $_SERVER['REMOTE_ADDR'];
$date = date('Y-m-d H:i:s');
if($section == "General") { $logquery = "INSERT INTO `cp_log_general` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, '$date', '$user', '$area', '$details', '$ip')"; }
if($section == "Staff") { $logquery = "INSERT INTO `cp_log_staff` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, '$date', '$user', '$area', '$details', '$ip')"; }
if($section == "Customer Relations") { $logquery = "INSERT INTO `cp_log_cr` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, '$date', '$user', '$area', '$details', '$ip')"; }
if($section == "Faction") { $logquery = "INSERT INTO `cp_log_faction` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, '$date', '$user', '$area', '$details', '$ip')"; }
if($section == "Family") { $logquery = "INSERT INTO `cp_log_family` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, '$date', '$user', '$area', '$details', '$ip')"; }
$runquery = mysqli_query($mysqli,$logquery);
if (!$runquery) {
    $message  = 'Invalid query: ' . mysqli_error() . "\n";
    $message .= 'Whole query: ' . $logquery;
    die($message);
	}
}

$logdir = "/home/samp/main/scriptfiles/cplogs/";

function LogFile($directory,$filename,$content) {
$content = "[".date('Y-m-d H:i:s')."] ".$content."\r\n";
$file = $directory . "" . $filename;

if (is_writable($file)) {
    if (!$handle = fopen($file, 'a')) {
         echo "Cannot open file ($filename)";
         exit;
    }
    if (fwrite($handle, $content) === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }
    fclose($handle);

} else {
    echo "The file $filename is not writable";
}
}

function escape_string($mysqli, $str) {
	$str = mysqli_real_escape_string($mysqli, stripslashes(trim($str)));
	return $str;
}

function StripNumber($number) {
$search = array("$", ",", " ", ".");
$numberstr = str_replace($search, '', $number);
return $numberstr;
}

function StripName($name) {
$search = array("_");
$namestr = str_replace($search, ' ', $name);
return $namestr;
}

function CheckName($username,$mysqli) {
	$query = mysqli_query($mysqli,"SELECT `id` FROM `accounts` WHERE `Username` = '$username'");
	$name = mysqli_num_rows($query);
	return $name;
}

function GetName($id, $mysqli) {
	$query = mysqli_query($mysqli,"SELECT `Username` FROM `accounts` WHERE `id` = '$id'");
	$username = mysqli_fetch_array($query, MYSQLI_NUM);
	if($username[0] == "") { $username[0] = "Unknown"; }
	return $username[0];
}

function GetID($name,$mysqli) {
	$query = mysqli_query($mysqli,"SELECT `id` FROM `accounts` WHERE `Username` = '$name'");
	$id = mysqli_fetch_array($query, MYSQLI_NUM);
	return $id[0];
}

function GetLastIP($id,$mysqli) {
	$query = mysqli_query($mysqli,"SELECT `IP` FROM `accounts` WHERE `id` = '$id'");
	$ip = mysqli_fetch_array($query, MYSQLI_NUM);
	return $ip[0];
}

function IsPlayerOnline($userid,$mysqli) {
	$query = mysqli_query($mysqli,"SELECT `Online` FROM `accounts` WHERE `id` = '$userid'");
	$online = mysqli_fetch_array($query, MYSQLI_NUM);
	return $online[0];
}

function GetAdminLevel($userid,$mysqli) {
	$query = mysqli_query($mysqli,"SELECT `AdminLevel` FROM `accounts` WHERE `id` = '$userid'");
	$result = mysqli_fetch_array($query, MYSQLI_NUM);
	return $result[0];
}

function GetHelperLevel($userid,$mysqli) {
	$query = mysqli_query($mysqli,"SELECT `Helper` FROM `accounts` WHERE `id` = '$userid'");
	$result = mysqli_fetch_array($query, MYSQLI_NUM);
	return $result[0];
}

function IsDisabled($userid,$mysqli) {
	$query = mysqli_query($mysqli,"SELECT `Disabled` FROM `accounts` WHERE `id` = '$userid'");
	$result = mysqli_fetch_array($query, MYSQLI_NUM);
	return $result[0];
}

function Biz($id, $field,$mysqli) {
	$id = $id + 1;
	$query = mysqli_query($mysqli,"SELECT $field FROM `businesses` WHERE `id` = $id");
	$result = mysqli_fetch_array($query, MYSQLI_NUM);
	return $result[0];
}

function GetMassEmailRecepients($id,$mysqli)
{
	$query = mysqli_query($mysqli,"SELECT * FROM `cp_mass_email` WHERE `id` = $id");
	$row = mysqli_fetch_array($query, MYSQLI_NUM);

	if(unserialize($row['admins']) != 0)
	{
		$op_admins = "AND";
		$op_helpers = "OR";
		$op_vip = "OR";
		$op_famed = "OR";
		$op_faction = "OR";
		$op_gang = "OR";
		$op_biz = "OR";
	}
	else if(unserialize($row['admins']) == 0 && unserialize($row['helpers']) != 0)
	{
		$op_helpers = "AND";
		$op_vip = "OR";
		$op_famed = "OR";
		$op_faction = "OR";
		$op_gang = "OR";
		$op_biz = "OR";
	}
	else if(unserialize($row['admins']) == 0 && unserialize($row['helpers']) == 0 && unserialize($row['vip']) != 0)
	{
		$op_vip = "AND";
		$op_famed = "OR";
		$op_faction = "OR";
		$op_gang = "OR";
		$op_biz = "OR";
	}
	else if(unserialize($row['admins']) == 0 && unserialize($row['helpers']) == 0 && unserialize($row['vip']) == 0 && unserialize($row['famed']) != 0)
	{
		$op_famed = "AND";
		$op_faction = "OR";
		$op_gang = "OR";
		$op_biz = "OR";
	}
	else if(unserialize($row['admins']) == 0 && unserialize($row['helpers']) == 0 && unserialize($row['vip']) == 0 && unserialize($row['famed']) == 0 && unserialize($row['faction']) != 0)
	{
		$op_faction = "AND";
		$op_gang = "OR";
		$op_biz = "OR";
	}
	else if(unserialize($row['admins']) == 0 && unserialize($row['helpers']) == 0 && unserialize($row['vip']) == 0 && unserialize($row['famed']) == 0 && unserialize($row['faction']) == 0 && unserialize($row['gang']) != 0)
	{
		$op_gang = "AND";
		$op_biz = "OR";
	}
	else if(unserialize($row['admins']) == 0 && unserialize($row['helpers']) == 0 && unserialize($row['vip']) == 0 && unserialize($row['famed']) == 0 && unserialize($row['faction']) == 0 && unserialize($row['gang']) == 0 && unserialize($row['biz']) != 0)
	{
		$op_biz = "AND";
	}

	$userquery = "SELECT `Username`, `Email` FROM `accounts` WHERE (`EmailOptOut` = $row[bypass]";
	if($row['banned'] != 1) $userquery .= " AND `Band` = 0";
	if($row['disabled'] != 1) $userquery .= " AND `Disabled` = 0";
	$userquery .= ")";
	if(unserialize($row['admins']) != 0)
	{
		$admins = unserialize($row['admins']);
		if($admins[0] == 1 && $admins[1] == 1.5) $userquery .= " ".$op_admins." (`AdminLevel` = $admins[0] OR `SeniorModerator` = 1";
		if($admins[0] == 1 && $admins[1] != 1.5) $userquery .= " ".$op_admins." (`AdminLevel` = $admins[0] AND `SeniorModerator` = 0";
		else $userquery .= " ".$op_admins." (`AdminLevel` = $admins[0]";
		for($i = 1; $i < count($admins); $i++)
		{
			$userquery .= " OR `AdminLevel` = $admins[$i]";
		}
		$userquery .= ")";
	}
	if(unserialize($row['helpers']) != 0)
	{
		$helpers = unserialize($row['helpers']);
		$userquery .= " ".$op_helpers." (`Helper` = $helpers[0]";
		for($i = 1; $i < count($helpers); $i++)
		{
			$userquery .= " OR `Helper` = $helpers[$i]";
		}
		$userquery .= ")";
	}
	if(unserialize($row['vip']) != 0)
	{
		$vip = unserialize($row['vip']);
		$userquery .= " ".$op_vip." (`DonateRank` = $vip[0]";
		for($i = 1; $i < count($vip); $i++)
		{
			$userquery .= " OR `DonateRank` = $vip[$i]";
		}
		$userquery .= ")";
	}
	if(unserialize($row['famed']) != 0)
	{
		$famed = unserialize($row['famed']);
		$userquery .= " ".$op_famed." (`Famed` = $famed[0]";
		for($i = 1; $i < count($famed); $i++)
		{
			$userquery .= " OR `Famed` = $famed[$i]";
		}
		$userquery .= ")";
	}
	if(unserialize($row['faction']) != 0)
	{
		$faction = unserialize($row['faction']);
		$faction_rank = unserialize($row['faction_rank']);
		$userquery .= " ".$op_faction." ((`Member` = $faction[0]";
		if(unserialize($row['faction_rank']) != 0)
		{
			$userquery .= " AND `Rank` = $faction_rank[0]";
			for($j = 1; $j < count($faction_rank); $j++)
			{
				$userquery .= " OR `Rank` = $faction_rank[$j]";
			}
			$userquery .= ")";
		}
		for($i = 1; $i < count($faction); $i++)
		{
			$userquery .= " OR (`Member` = $faction[$i]";
			if(unserialize($row['faction_rank']) != 0)
			{
				$userquery .= " AND `Rank` = $faction_rank[0]";
				for($j = 1; $j < count($faction_rank); $j++)
				{
					$userquery .= " OR `Rank` = $faction_rank[$j]";
				}
			}
			$userquery .= ")";
		}
		$userquery .= ")";
	}
	if(unserialize($row['gang']) != 0)
	{
		$gang = unserialize($row['gang']);
		$gang_rank = unserialize($row['gang_rank']);
		$userquery .= " ".$op_gang." ((`FMember` = $gang[0]";
		if(unserialize($row['gang_rank']) != 0)
		{
			$userquery .= " AND `Rank` = $gang_rank[0]";
			for($j = 1; $j < count($gang_rank); $j++)
			{
				$userquery .= " OR `Rank` = $gang_rank[$j]";
			}
			$userquery .= ")";
		}
		for($i = 1; $i < count($gang); $i++)
		{
			$userquery .= " OR (`FMember` = $gang[$i]";
			if(unserialize($row['gang_rank']) != 0)
			{
				$userquery .= " AND `Rank` = $gang_rank[0]";
				for($j = 1; $j < count($gang_rank); $j++)
				{
					$userquery .= " OR `Rank` = $gang_rank[$j]";
				}
			}
			$userquery .= ")";
		}
		$userquery .= ")";
	}
	if(unserialize($row['biz']) != 0)
	{
		$biz = unserialize($row['biz']);
		$biz_rank = unserialize($row['biz_rank']);
		$userquery .= " ".$op_biz." ((`Business` = $biz[0]";
		if(unserialize($row['biz_rank']) != 0)
		{
			$userquery .= " AND `BusinessRank` = $biz_rank[0]";
			for($j = 1; $j < count($biz_rank); $j++)
			{
				$userquery .= " OR `BusinessRank` = $biz_rank[$j]";
			}
			$userquery .= ")";
		}
		for($i = 1; $i < count($biz); $i++)
		{
			$userquery .= " OR (`Business` = $biz[$i]";
			if(unserialize($row['biz_rank']) != 0)
			{
				$userquery .= " AND `BusinessRank` = $biz_rank[0]";
				for($j = 1; $j < count($biz_rank); $j++)
				{
					$userquery .= " OR `BusinessRank` = $biz_rank[$j]";
				}
			}
			$userquery .= ")";
		}
		$userquery .= ")";
	}
	return $userquery;
}

function CalculateTotalWealth($id, $mysqli) {
	$username = GetName($id,$mysqli);
	$wealthquery = mysqli_query($mysqli,"SELECT `Money`, `Bank`, `Apartment`, `Apartment2` FROM `accounts` WHERE `id` = $id");
	$wealth = mysqli_fetch_array($wealthquery);
	if($wealth['Apartment'] > 0) {
		$hwealthquery = mysqli_query($mysqli,"SELECT `SafeMoney` FROM `houses` WHERE `id` = $wealth[Apartment] + 1");
		$hwealth = mysqli_fetch_array($hwealthquery);
	}
	if($wealth['Apartment2'] > 0) {
		$hwealth2query = mysqli_query($mysqli,"SELECT `SafeMoney` FROM `houses` WHERE `id` = $wealth[Apartment2] + 1");
		$hwealth2 = mysqli_fetch_array($hwealth2query);
	}
	$totalwealth = $wealth['Money'] + $wealth['Bank'] + $hwealth['SafeMoney'] + $hwealth2['SafeMoney'];
	return number_format($totalwealth);
}

function MapLocation($player,$id,$x,$y,$owner, $mysqli) {
	$playerquery = mysqli_query($mysqli,"SELECT `Apartment`, `Apartment2` FROM `accounts` WHERE `Username` = '$player'");
	$playerarray = mysqli_fetch_array($playerquery);
	$housequery = mysqli_query($mysqli,"SELECT * FROM `houses` WHERE `id` = $playerarray[Apartment] + 1 OR `id` = $playerarray[Apartment2] +1");
	
	while ($house = mysqli_fetch_array($housequery)) {
		if($house['id'] == $playerarray['Apartment'] + 1) {
			$id = $house['id'];
			$x = $house['ExteriorX'];
			$y = $house['ExteriorY'];
			$owner = $house['Owner'];
		}
		if($house['id'] == $playerarray['Apartment2'] + 1) {
			$id2 = $house['id'];
			$x2 = $house['ExteriorX'];
			$y2 = $house['ExteriorY'];
			$owner2 = $house['Owner'];
		}
	}

$zone = GetPlayer2DZone($x, $y);
if(isset($id2)) { $zone2 = GetPlayer2DZone($x2, $y2); }

require_once("map.php");
}

function FlagByIP($ip) {
require_once("geoip.inc");
$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);
$country_code = strtolower(geoip_country_code_by_addr($gi, $ip));
$country_name = geoip_country_name_by_addr($gi, $ip);
$flag = "<img src='http://".$_SERVER['SERVER_NAME']."/global/images/flags/$country_code.png' alt='$country_name' title='$country_name' />";
return $flag;
geoip_close($gi);
}

function FlagWithIP($ip) {
require_once("geoip.inc");
$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);
$country_code = geoip_country_code_by_addr($gi, $ip);
$country_name = geoip_country_name_by_addr($gi, $ip);
$flag = "<img src='http://".$_SERVER['SERVER_NAME']."/global/images/flags/$country_code.png' title='$country_name' />&nbsp;".$ip;
return $flag;
geoip_close($gi);
}

function LastOnline($userid,$mysqli) {
	$query = mysqli_query($mysqli,"SELECT `LastLogin` FROM `accounts` WHERE `id` = '$userid'");
	$user = mysqli_fetch_array($query, MYSQLI_NUM);
	$uDate = date("M j, o - g:iA", strtotime("$user[LastLogin]"));
	$diff = strtotime("now") - strtotime("$user[LastLogin]");
	$num = $diff/86400;
	$days = intval($num);
	if($days == 0) $lo = "<span style='color:green'>$uDate</span>";
	if($days >= 1) $lo = "<span style='color:blue'>$uDate</span>";
	if($days >= 7) $lo = "<span style='color:gold'>$uDate</span>";
	if($days >= 14) $lo = "<span style='color:orange'>$uDate</span>";
	if($days >= 30) $lo = "<span style='color:red'>$uDate</span>";
	if(date("M j, o - g:iA", strtotime("$user[LastLogin]")) == "Dec 31, 1970 - 6:00PM") $lo = "<span style='color:silver'>Unknown</span>";
	return $lo;
}

function GetFacName($facid,$mysqli) {
	$facquery = mysqli_query($mysqli,"SELECT `Name` FROM `groups` WHERE `id` = $facid + 1");
	$fac = mysqli_fetch_array($facquery);
	return $fac[0];
}

function GetFamName($famid,$mysqli) {
	$famquery = mysqli_query($mysqli,"SELECT `Name` FROM `families` WHERE `id` = $famid");
	$fam = mysqli_fetch_array($famquery);
	return $fam[0];
}

function VIPrank($viprank) {
	if($viprank == 0) { $viprank = "None"; }
	if($viprank == 1) { $viprank = "Bronze"; }
	if($viprank == 2) { $viprank = "Silver"; }
	if($viprank == 3) { $viprank = "Gold"; }
	if($viprank == 4) { $viprank = "Platinum"; }
	if($viprank == 5) { $viprank = "VIP Moderator"; }
	return $viprank;
}

function GetJobName($jobid) {
	if($jobid == 1) { $jobname = "Detective"; }
	elseif($jobid == 2) { $jobname = "Lawyer"; }
	elseif($jobid == 3) { $jobname = "Whore"; }
	elseif($jobid == 4) { $jobname = "Drugs Dealer"; }
	elseif($jobid == 5) { $jobname = "Car Jacker"; }
	elseif($jobid == 6) { $jobname = "News Reporter"; }
	elseif($jobid == 7) { $jobname = "Car Mechanic"; }
	elseif($jobid == 8) { $jobname = "Bodyguard"; }
	elseif($jobid == 9) { $jobname = "Arms Dealer"; }
	elseif($jobid == 10) { $jobname = "Car Dealer"; }
	elseif($jobid == 12) { $jobname = "Boxer"; }
	elseif($jobid == 14) { $jobname = "Drug Smuggler"; }
	elseif($jobid == 15) { $jobname = "Paper Boy"; }
	elseif($jobid == 16) { $jobname = "Trucker"; }
	elseif($jobid == 17) { $jobname = "Taxi Driver"; }
	elseif($jobid == 18) { $jobname = "Craftsman"; }
	elseif($jobid == 19) { $jobname = "Bartender"; }
	elseif($jobid == 20) { $jobname = "Trucker"; }
	elseif($jobid == 21) { $jobname = "Pizza Boy"; }
	else { $jobname = "None"; }
	return $jobname;
}

function GetJobLevel($jobid,$exp) {
	if($jobid == 1) {
		if($exp >= 0 && $exp <= 50) { $level = 1; }
		else if($exp >= 51 && $exp <= 100) { $level = 2; }
		else if($exp >= 101 && $exp <= 200) { $level = 3; }
		else if($exp >= 201 && $exp <= 400) { $level = 4; }
		else if($exp >= 401) { $level = 5; }
	}
	elseif($jobid == 2) {
		if($exp >= 0 && $exp <= 50) { $level = 1; }
		else if($exp >= 51 && $exp <= 100) { $level = 2; }
		else if($exp >= 101 && $exp <= 200) { $level = 3; }
		else if($exp >= 201 && $exp <= 400) { $level = 4; }
		else if($exp >= 401) { $level = 5; }
	}
	elseif($jobid == 3) {
		if($exp >= 0 && $exp <= 50) { $level = 1; }
		else if($exp >= 51 && $exp <= 100) { $level = 2; }
		else if($exp >= 101 && $exp <= 200) { $level = 3; }
		else if($exp >= 201 && $exp <= 400) { $level = 4; }
		else if($exp >= 401) { $level = 5; }
	}
	elseif($jobid == 4) {
		if($exp >= 0 && $exp <= 50) { $level = 1; }
		else if($exp >= 51 && $exp <= 100) { $level = 2; }
		else if($exp >= 101 && $exp <= 200) { $level = 3; }
		else if($exp >= 201 && $exp <= 400) { $level = 4; }
		else if($exp >= 401) { $level = 5; }
	}
	elseif($jobid == 7) {
		if($exp >= 0 && $exp <= 50) { $level = 1; }
		else if($exp >= 51 && $exp <= 100) { $level = 2; }
		else if($exp >= 101 && $exp <= 200) { $level = 3; }
		else if($exp >= 201 && $exp <= 400) { $level = 4; }
		else if($exp >= 401) { $level = 5; }
	}
	elseif($jobid == 9) {
		if($exp >= 0 && $exp < 50) { $level = 1; }
		else if($exp >= 50 && $exp < 100) { $level = 2; }
		else if($exp >= 100 && $exp < 200) { $level = 3; }
		else if($exp >= 200 && $exp < 400) { $level = 4; }
		else if($exp >= 400) { $level = 5; }
	}
	elseif($jobid == 12) {
		if($exp >= 0 && $exp <= 50) { $level = 1; }
		else if($exp >= 51 && $exp <= 100) { $level = 2; }
		else if($exp >= 101 && $exp <= 200) { $level = 3; }
		else if($exp >= 201 && $exp <= 400) { $level = 4; }
		else if($exp >= 401) { $level = 5; }
	}
	elseif($jobid == 20) {
		if($exp >= 0 && $exp <= 50) { $level = 1; }
		else if($exp >= 51 && $exp <= 100) { $level = 2; }
		else if($exp >= 101 && $exp <= 200) { $level = 3; }
		else if($exp >= 201 && $exp <= 400) { $level = 4; }
		else if($exp >= 401) { $level = 5; }
	}
	else { $level = 1; }
	return $level;
}

$veharray = array(
	array("Landstalker", 400),
	array("Bravura", 401),
	array("Buffalo", 402),
	array("Linerunner", 403),
	array("Perenail", 404),
	array("Sentinel", 405),
	array("Dumper", 406),
	array("Firetruck", 407),
	array("Trashmaster", 408),
	array("Stretch", 409),
	array("Manana", 410),
	array("Infernus", 411),
	array("Voodoo", 412),
	array("Pony", 413),
	array("Mule", 414),
	array("Cheetah", 415),
	array("Ambulance", 416),
	array("Leviathan", 417),
	array("Moonbeam", 418),
	array("Esperanto", 419),
	array("Taxi", 420),
	array("Washington", 421),
	array("Bobcat", 422),
	array("Mr Whoopee", 423),
	array("BF Injection", 424),
	array("Hunter", 425),
	array("Premier", 426),
	array("Enforcer", 427),
	array("Securicar", 428),
	array("Banshee", 429),
	array("Predator", 430),
	array("Bus", 431),
	array("Rhino", 432),
	array("Barracks", 433),
	array("Hotknife", 434),
	array("Artic Trailer 1", 435),
	array("Previon", 436),
	array("Coach", 437),
	array("Cabbie", 438),
	array("Stallion", 439),
	array("Rumpo", 440),
	array("RC Bandit", 441),
	array("Romero", 442),
	array("Packer", 443),
	array("Monster", 444),
	array("Admiral", 445),
	array("Squalo", 446),
	array("Seasparrow", 447),
	array("Pizza boy", 448),
	array("Tram", 449),
	array("Artic Trailer 2", 450),
	array("Turismo", 451),
	array("Speeder", 452),
	array("Reefer", 453),
	array("Tropic", 454),
	array("Flatbed", 455),
	array("Yankee", 456),
	array("Caddy", 457),
	array("Solair", 458),
	array("Top fun", 459),
	array("Skimmer", 460),
	array("PCJ 600", 461),
	array("Faggio", 462),
	array("Freeway", 463),
	array("RC Baron", 464),
	array("RC Raider", 465),
	array("Glendale", 466),
	array("Oceanic", 467),
	array("Sanchez", 468),
	array("Sparrow", 469),
	array("Patriot", 470),
	array("Quad", 471),
	array("Coastgaurd", 472),
	array("Dinghy", 473),
	array("Hermes", 474),
	array("Sabre", 475),
	array("Rustler", 476),
	array("ZR 350", 477),
	array("Walton", 478),
	array("Regina", 479),
	array("Comet", 480),
	array("BMX", 481),
	array("Burrito", 482),
	array("Camper", 483),
	array("Marquis", 484),
	array("Baggage", 485),
	array("Dozer", 486),
	array("Maverick", 487),
	array("VCN Maverick", 488),
	array("Rancher", 489),
	array("FBI Rancher", 490),
	array("Virgo", 491),
	array("Greenwood", 492),
	array("Jetmax", 493),
	array("Hotring", 494),
	array("Sandking", 495),
	array("Blistac", 496),
	array("Police Maverick", 497),
	array("Boxville", 498),
	array("Benson", 499),
	array("Mesa", 500),
	array("RC Goblin", 501),
	array("Hotring A", 502),
	array("Hotring B", 503),
	array("Bloodring Banger", 504),
	array("Rancher (lure)", 505),
	array("Super GT", 506),
	array("Elegant", 507),
	array("Journey", 508),
	array("Bike", 509),
	array("Mountain Bike", 510),
	array("Beagle", 511),
	array("Cropduster", 512),
	array("Stuntplane", 513),
	array("Petrol", 514),
	array("Roadtrain", 515),
	array("Nebula", 516),
	array("Majestic", 517),
	array("Buccaneer", 518),
	array("Shamal", 519),
	array("Hydra", 520),
	array("FCR 900", 521),
	array("NRG 500", 522),
	array("HPV 1000", 523),
	array("Cement", 524),
	array("Towtruck", 525),
	array("Fortune", 526),
	array("Cadrona", 527),
	array("FBI Truck", 528),
	array("Williard", 529),
	array("Fork lift", 530),
	array("Tractor", 531),
	array("Combine", 532),
	array("Feltzer", 533),
	array("Remington", 534),
	array("Slamvan", 535),
	array("Blade", 536),
	array("Freight", 537),
	array("Streak", 538),
	array("Vortex", 539),
	array("Vincent", 540),
	array("Bullet", 541),
	array("Clover", 542),
	array("Sadler", 543),
	array("Firetruck LA", 544),
	array("Hustler", 545),
	array("Intruder", 546),
	array("Primo", 547),
	array("Cargobob", 548),
	array("Tampa", 549),
	array("Sunrise", 550),
	array("Merit", 551),
	array("Utility van", 552),
	array("Nevada", 553),
	array("Yosemite", 554),
	array("Windsor", 555),
	array("Monster A", 556),
	array("Monster B", 557),
	array("Uranus", 558),
	array("Jester", 559),
	array("Sultan", 560),
	array("Stratum", 561),
	array("Elegy", 562),
	array("Raindance", 563),
	array("RC Tiger", 564),
	array("Flash", 565),
	array("Tahoma", 566),
	array("Savanna", 567),
	array("Bandito", 568),
	array("Freight Flat", 569),
	array("Streak", 570),
	array("Kart", 571),
	array("Mower", 572),
	array("Duneride", 573),
	array("Sweeper", 574),
	array("Broadway", 575),
	array("Tornado", 576),
	array("AT 400", 577),
	array("DFT 30", 578),
	array("Huntley", 579),
	array("Stafford", 580),
	array("BF 400", 581),
	array("News Van", 582),
	array("Tug", 583),
	array("Petrol Tanker", 584),
	array("Emperor", 585),
	array("Wayfarer", 586),
	array("Euros", 587),
	array("Hotdog", 588),
	array("Club", 589),
	array("Freight Box", 590),
	array("Artic Trailer 3", 591),
	array("Andromada", 592),
	array("Dodo", 593),
	array("RC Cam", 594),
	array("Launch", 595),
	array("LSPD Cruiser", 596),
	array("SFPD Cruiser", 597),
	array("LVPD Cruiser", 598),
	array("Police Ranger", 599),
	array("Picador", 600),
	array("SWAT Tank", 601),
	array("Alpha", 602),
	array("Phoenix", 603),
	array("Glendale (damage)", 604),
	array("Sadler (damage)", 605),
	array("Bag box A", 606),
	array("Bag box B", 607),
	array("Stairs", 608),
	array("Boxville (black)", 609),
	array("Farm Trailer", 610),
	array("Utility Van Trailer", 611)
);

	function GetVehicleName($vehid)
	{
		global $veharray;
		for($i = 0; $i != sizeof($veharray); $i++ )
		{
			if($vehid == $veharray[$i][1])
			{
				return $veharray[$i][0];
			}
		}
		return 0;
	}

$gunarray = array(
	array("Nothing", 0),
	array("Brass Knuckles", 1),
	array("Golf Club", 2),
	array("Nightstick", 3),
	array("Knife", 4),
	array("Baseball Bat", 5),
	array("Shovel", 6),
	array("Pool Cue", 7),
	array("Katana", 8),
	array("Chainsaw", 9),
	array("Purple Dildo", 10),
	array("Dildo", 11),
	array("Vibrator", 12),
	array("Silver Vibrator", 13),
	array("Flowers", 14),
	array("Cane", 15),
	array("Grenade", 16),
	array("Tear Gas", 17),
	array("Molotov Cocktail", 18),
	array("9mm", 22),
	array("Silenced 9mm", 23),
	array("Desert Eagle", 24),
	array("Shotgun", 25),
	array("Sawnoff Shotgun", 26),
	array("Combat Shotgun", 27),
	array("Uzi", 28),
	array("MP5", 29),
	array("AK47", 30),
	array("M4", 31),
	array("Tec-9", 32),
	array("Country Rifle", 33),
	array("Sniper Rifle", 34),
	array("RPG", 35),
	array("Heat-Seeking RPG", 36),
	array("Flamethrower", 37),
	array("Minigun", 38),
	array("Satchel Charge", 39),
	array("Detonator", 40),
	array("Spraycan", 41),
	array("Fire Extinguisher", 42),
	array("Camera", 43),
	array("Night Vision Goggles", 44),
	array("Infrared Goggles", 45),
	array("Parachute", 46)
);

	function GetWeaponName($gunid)
	{
		global $gunarray;
		for($i = 0; $i != sizeof($gunarray); $i++ )
		{
			if($gunid == $gunarray[$i][1])
			{
				return $gunarray[$i][0];
			}
		}
		return 0;
	}

	/*  SA:MP Functions
	 *  
	 *  ZONES Functions By ~Cueball~
	 *  ZONES Functions Aided By Betamaster (locations), Mabako (locations), Simon (finetuning)
	 *  Ported to PHP by Scott "h02" Reed (h02@h02.org)
	 *
	 *  (c) Copyright 2005-2012, SA:MP Team
	 *
	*/

	//OUR MAJOR ARRAY: (GLOBAL)

	$gSAZones = array(  // Majority of names and area coordinates adopted from Mabako's 'Zones Script' v0.2
		//	NAME                            AREA (Xmin,Ymin,Zmin,Xmax,Ymax,Zmax)
		array("The Big Ear",	             -410.00,1403.30,-3.00,-137.90,1681.20,200.00),
		array("Aldea Malvada",               -1372.10,2498.50,0.00,-1277.50,2615.30,200.00),
		array("Angel Pine",                  -2324.90,-2584.20,-6.10,-1964.20,-2212.10,200.00),
		array("Arco del Oeste",              -901.10,2221.80,0.00,-592.00,2571.90,200.00),
		array("Avispa Country Club",         -2646.40,-355.40,0.00,-2270.00,-222.50,200.00),
		array("Avispa Country Club",         -2831.80,-430.20,-6.10,-2646.40,-222.50,200.00),
		array("Avispa Country Club",         -2361.50,-417.10,0.00,-2270.00,-355.40,200.00),
		array("Avispa Country Club",         -2667.80,-302.10,-28.80,-2646.40,-262.30,71.10),
		array("Avispa Country Club",         -2470.00,-355.40,0.00,-2270.00,-318.40,46.10),
		array("Avispa Country Club",         -2550.00,-355.40,0.00,-2470.00,-318.40,39.70),
		array("Back o Beyond",               -1166.90,-2641.10,0.00,-321.70,-1856.00,200.00),
		array("Battery Point",               -2741.00,1268.40,-4.50,-2533.00,1490.40,200.00),
		array("Bayside",                     -2741.00,2175.10,0.00,-2353.10,2722.70,200.00),
		array("Bayside Marina",              -2353.10,2275.70,0.00,-2153.10,2475.70,200.00),
		array("Beacon Hill",                 -399.60,-1075.50,-1.40,-319.00,-977.50,198.50),
		array("Blackfield",                  964.30,1203.20,-89.00,1197.30,1403.20,110.90),
		array("Blackfield",                  964.30,1403.20,-89.00,1197.30,1726.20,110.90),
		array("Blackfield Chapel",           1375.60,596.30,-89.00,1558.00,823.20,110.90),
		array("Blackfield Chapel",           1325.60,596.30,-89.00,1375.60,795.00,110.90),
		array("Blackfield Intersection",     1197.30,1044.60,-89.00,1277.00,1163.30,110.90),
		array("Blackfield Intersection",     1166.50,795.00,-89.00,1375.60,1044.60,110.90),
		array("Blackfield Intersection",     1277.00,1044.60,-89.00,1315.30,1087.60,110.90),
		array("Blackfield Intersection",     1375.60,823.20,-89.00,1457.30,919.40,110.90),
		array("Blueberry",                   104.50,-220.10,2.30,349.60,152.20,200.00),
		array("Blueberry",                   19.60,-404.10,3.80,349.60,-220.10,200.00),
		array("Blueberry Acres",             -319.60,-220.10,0.00,104.50,293.30,200.00),
		array("Caligula's Palace",           2087.30,1543.20,-89.00,2437.30,1703.20,110.90),
		array("Caligula's Palace",           2137.40,1703.20,-89.00,2437.30,1783.20,110.90),
		array("Calton Heights",              -2274.10,744.10,-6.10,-1982.30,1358.90,200.00),
		array("Chinatown",                   -2274.10,578.30,-7.60,-2078.60,744.10,200.00),
		array("City Hall",                   -2867.80,277.40,-9.10,-2593.40,458.40,200.00),
		array("Come-A-Lot",                  2087.30,943.20,-89.00,2623.10,1203.20,110.90),
		array("Commerce",                    1323.90,-1842.20,-89.00,1701.90,-1722.20,110.90),
		array("Commerce",                    1323.90,-1722.20,-89.00,1440.90,-1577.50,110.90),
		array("Commerce",                    1370.80,-1577.50,-89.00,1463.90,-1384.90,110.90),
		array("Commerce",                    1463.90,-1577.50,-89.00,1667.90,-1430.80,110.90),
		array("Commerce",                    1583.50,-1722.20,-89.00,1758.90,-1577.50,110.90),
		array("Commerce",                    1667.90,-1577.50,-89.00,1812.60,-1430.80,110.90),
		array("Conference Center",           1046.10,-1804.20,-89.00,1323.90,-1722.20,110.90),
		array("Conference Center",           1073.20,-1842.20,-89.00,1323.90,-1804.20,110.90),
		array("Cranberry Station",           -2007.80,56.30,0.00,-1922.00,224.70,100.00),
		array("Creek",                       2749.90,1937.20,-89.00,2921.60,2669.70,110.90),
		array("Dillimore",                   580.70,-674.80,-9.50,861.00,-404.70,200.00),
		array("Doherty",                     -2270.00,-324.10,-0.00,-1794.90,-222.50,200.00),
		array("Doherty",                     -2173.00,-222.50,-0.00,-1794.90,265.20,200.00),
		array("Donahue Acres",               -1599.56,-1306.60,-89.00,-1219.82,-866.31,300.00),
		array("Downtown",                    -1982.30,744.10,-6.10,-1871.70,1274.20,200.00),
		array("Downtown",                    -1871.70,1176.40,-4.50,-1620.30,1274.20,200.00),
		array("Downtown",                    -1700.00,744.20,-6.10,-1580.00,1176.50,200.00),
		array("Downtown",                    -1580.00,744.20,-6.10,-1499.80,1025.90,200.00),
		array("Downtown",                    -2078.60,578.30,-7.60,-1499.80,744.20,200.00),
		array("Downtown",                    -1993.20,265.20,-9.10,-1794.90,578.30,200.00),
		array("Downtown Los Santos",         1463.90,-1430.80,-89.00,1724.70,-1290.80,110.90),
		array("Downtown Los Santos",         1724.70,-1430.80,-89.00,1812.60,-1250.90,110.90),
		array("Downtown Los Santos",         1463.90,-1290.80,-89.00,1724.70,-1150.80,110.90),
		array("Downtown Los Santos",         1370.80,-1384.90,-89.00,1463.90,-1170.80,110.90),
		array("Downtown Los Santos",         1724.70,-1250.90,-89.00,1812.60,-1150.80,110.90),
		array("Downtown Los Santos",         1370.80,-1170.80,-89.00,1463.90,-1130.80,110.90),
		array("Downtown Los Santos",         1378.30,-1130.80,-89.00,1463.90,-1026.30,110.90),
		array("Downtown Los Santos",         1391.00,-1026.30,-89.00,1463.90,-926.90,110.90),
		array("Downtown Los Santos",         1507.50,-1385.20,110.90,1582.50,-1325.30,335.90),
		array("East Beach",                  2632.80,-1852.80,-89.00,2959.30,-1668.10,110.90),
		array("East Beach",                  2632.80,-1668.10,-89.00,2747.70,-1393.40,110.90),
		array("East Beach",                  2747.70,-1668.10,-89.00,2959.30,-1498.60,110.90),
		array("East Beach",                  2747.70,-1498.60,-89.00,2959.30,-1120.00,110.90),
		array("East Los Santos",             2421.00,-1628.50,-89.00,2632.80,-1454.30,110.90),
		array("East Los Santos",             2222.50,-1628.50,-89.00,2421.00,-1494.00,110.90),
		array("East Los Santos",             2266.20,-1494.00,-89.00,2381.60,-1372.00,110.90),
		array("East Los Santos",             2381.60,-1494.00,-89.00,2421.00,-1454.30,110.90),
		array("East Los Santos",             2281.40,-1372.00,-89.00,2381.60,-1135.00,110.90),
		array("East Los Santos",             2381.60,-1454.30,-89.00,2462.10,-1135.00,110.90),
		array("East Los Santos",             2462.10,-1454.30,-89.00,2581.70,-1135.00,110.90),
		array("Easter Basin",                -1794.90,249.90,-9.10,-1242.90,578.30,200.00),
		array("Easter Basin",                -1794.90,-50.00,-0.00,-1499.80,249.90,200.00),
		array("Easter Bay Airport",          -1499.80,-50.00,-0.00,-1242.90,249.90,200.00),
		array("Easter Bay Airport",          -1794.90,-730.10,-3.00,-1213.90,-50.00,200.00),
		array("Easter Bay Airport",          -1213.90,-730.10,0.00,-1132.80,-50.00,200.00),
		array("Easter Bay Airport",          -1242.90,-50.00,0.00,-1213.90,578.30,200.00),
		array("Easter Bay Airport",          -1213.90,-50.00,-4.50,-947.90,578.30,200.00),
		array("Easter Bay Airport",          -1315.40,-405.30,15.40,-1264.40,-209.50,25.40),
		array("Easter Bay Airport",          -1354.30,-287.30,15.40,-1315.40,-209.50,25.40),
		array("Easter Bay Airport",          -1490.30,-209.50,15.40,-1264.40,-148.30,25.40),
		array("Easter Bay Chemicals",        -1132.80,-768.00,0.00,-956.40,-578.10,200.00),
		array("Easter Bay Chemicals",        -1132.80,-787.30,0.00,-956.40,-768.00,200.00),
		array("El Castillo del Diablo",      -464.50,2217.60,0.00,-208.50,2580.30,200.00),
		array("El Castillo del Diablo",      -208.50,2123.00,-7.60,114.00,2337.10,200.00),
		array("El Castillo del Diablo",      -208.50,2337.10,0.00,8.40,2487.10,200.00),
		array("El Corona",                   1812.60,-2179.20,-89.00,1970.60,-1852.80,110.90),
		array("El Corona",                   1692.60,-2179.20,-89.00,1812.60,-1842.20,110.90),
		array("El Quebrados",                -1645.20,2498.50,0.00,-1372.10,2777.80,200.00),
		array("Esplanade East",              -1620.30,1176.50,-4.50,-1580.00,1274.20,200.00),
		array("Esplanade East",              -1580.00,1025.90,-6.10,-1499.80,1274.20,200.00),
		array("Esplanade East",              -1499.80,578.30,-79.60,-1339.80,1274.20,20.30),
		array("Esplanade North",             -2533.00,1358.90,-4.50,-1996.60,1501.20,200.00),
		array("Esplanade North",             -1996.60,1358.90,-4.50,-1524.20,1592.50,200.00),
		array("Esplanade North",             -1982.30,1274.20,-4.50,-1524.20,1358.90,200.00),
		array("Fallen Tree",                 -792.20,-698.50,-5.30,-452.40,-380.00,200.00),
		array("Fallow Bridge",               434.30,366.50,0.00,603.00,555.60,200.00),
		array("Fern Ridge",                  508.10,-139.20,0.00,1306.60,119.50,200.00),
		array("Financial",                   -1871.70,744.10,-6.10,-1701.30,1176.40,300.00),
		array("Fisher's Lagoon",             1916.90,-233.30,-100.00,2131.70,13.80,200.00),
		array("Flint Intersection",          -187.70,-1596.70,-89.00,17.00,-1276.60,110.90),
		array("Flint Range",                 -594.10,-1648.50,0.00,-187.70,-1276.60,200.00),
		array("Fort Carson",                 -376.20,826.30,-3.00,123.70,1220.40,200.00),
		array("Foster Valley",               -2270.00,-430.20,-0.00,-2178.60,-324.10,200.00),
		array("Foster Valley",               -2178.60,-599.80,-0.00,-1794.90,-324.10,200.00),
		array("Foster Valley",               -2178.60,-1115.50,0.00,-1794.90,-599.80,200.00),
		array("Foster Valley",               -2178.60,-1250.90,0.00,-1794.90,-1115.50,200.00),
		array("Frederick Bridge",            2759.20,296.50,0.00,2774.20,594.70,200.00),
		array("Gant Bridge",                 -2741.40,1659.60,-6.10,-2616.40,2175.10,200.00),
		array("Gant Bridge",                 -2741.00,1490.40,-6.10,-2616.40,1659.60,200.00),
		array("Ganton",                      2222.50,-1852.80,-89.00,2632.80,-1722.30,110.90),
		array("Ganton",                      2222.50,-1722.30,-89.00,2632.80,-1628.50,110.90),
		array("Garcia",                      -2411.20,-222.50,-0.00,-2173.00,265.20,200.00),
		array("Garcia",                      -2395.10,-222.50,-5.30,-2354.00,-204.70,200.00),
		array("Garver Bridge",               -1339.80,828.10,-89.00,-1213.90,1057.00,110.90),
		array("Garver Bridge",               -1213.90,950.00,-89.00,-1087.90,1178.90,110.90),
		array("Garver Bridge",               -1499.80,696.40,-179.60,-1339.80,925.30,20.30),
		array("Glen Park",                   1812.60,-1449.60,-89.00,1996.90,-1350.70,110.90),
		array("Glen Park",                   1812.60,-1100.80,-89.00,1994.30,-973.30,110.90),
		array("Glen Park",                   1812.60,-1350.70,-89.00,2056.80,-1100.80,110.90),
		array("Green Palms",                 176.50,1305.40,-3.00,338.60,1520.70,200.00),
		array("Greenglass College",          964.30,1044.60,-89.00,1197.30,1203.20,110.90),
		array("Greenglass College",          964.30,930.80,-89.00,1166.50,1044.60,110.90),
		array("Hampton Barns",               603.00,264.30,0.00,761.90,366.50,200.00),
		array("Hankypanky Point",            2576.90,62.10,0.00,2759.20,385.50,200.00),
		array("Harry Gold Parkway",          1777.30,863.20,-89.00,1817.30,2342.80,110.90),
		array("Hashbury",                    -2593.40,-222.50,-0.00,-2411.20,54.70,200.00),
		array("Hilltop Farm",                967.30,-450.30,-3.00,1176.70,-217.90,200.00),
		array("Hunter Quarry",               337.20,710.80,-115.20,860.50,1031.70,203.70),
		array("Idlewood",                    1812.60,-1852.80,-89.00,1971.60,-1742.30,110.90),
		array("Idlewood",                    1812.60,-1742.30,-89.00,1951.60,-1602.30,110.90),
		array("Idlewood",                    1951.60,-1742.30,-89.00,2124.60,-1602.30,110.90),
		array("Idlewood",                    1812.60,-1602.30,-89.00,2124.60,-1449.60,110.90),
		array("Idlewood",                    2124.60,-1742.30,-89.00,2222.50,-1494.00,110.90),
		array("Idlewood",                    1971.60,-1852.80,-89.00,2222.50,-1742.30,110.90),
		array("Jefferson",                   1996.90,-1449.60,-89.00,2056.80,-1350.70,110.90),
		array("Jefferson",                   2124.60,-1494.00,-89.00,2266.20,-1449.60,110.90),
		array("Jefferson",                   2056.80,-1372.00,-89.00,2281.40,-1210.70,110.90),
		array("Jefferson",                   2056.80,-1210.70,-89.00,2185.30,-1126.30,110.90),
		array("Jefferson",                   2185.30,-1210.70,-89.00,2281.40,-1154.50,110.90),
		array("Jefferson",                   2056.80,-1449.60,-89.00,2266.20,-1372.00,110.90),
		array("Julius Thruway East",         2623.10,943.20,-89.00,2749.90,1055.90,110.90),
		array("Julius Thruway East",         2685.10,1055.90,-89.00,2749.90,2626.50,110.90),
		array("Julius Thruway East",         2536.40,2442.50,-89.00,2685.10,2542.50,110.90),
		array("Julius Thruway East",         2625.10,2202.70,-89.00,2685.10,2442.50,110.90),
		array("Julius Thruway North",        2498.20,2542.50,-89.00,2685.10,2626.50,110.90),
		array("Julius Thruway North",        2237.40,2542.50,-89.00,2498.20,2663.10,110.90),
		array("Julius Thruway North",        2121.40,2508.20,-89.00,2237.40,2663.10,110.90),
		array("Julius Thruway North",        1938.80,2508.20,-89.00,2121.40,2624.20,110.90),
		array("Julius Thruway North",        1534.50,2433.20,-89.00,1848.40,2583.20,110.90),
		array("Julius Thruway North",        1848.40,2478.40,-89.00,1938.80,2553.40,110.90),
		array("Julius Thruway North",        1704.50,2342.80,-89.00,1848.40,2433.20,110.90),
		array("Julius Thruway North",        1377.30,2433.20,-89.00,1534.50,2507.20,110.90),
		array("Julius Thruway South",        1457.30,823.20,-89.00,2377.30,863.20,110.90),
		array("Julius Thruway South",        2377.30,788.80,-89.00,2537.30,897.90,110.90),
		array("Julius Thruway West",         1197.30,1163.30,-89.00,1236.60,2243.20,110.90),
		array("Julius Thruway West",         1236.60,2142.80,-89.00,1297.40,2243.20,110.90),
		array("Juniper Hill",                -2533.00,578.30,-7.60,-2274.10,968.30,200.00),
		array("Juniper Hollow",              -2533.00,968.30,-6.10,-2274.10,1358.90,200.00),
		array("K.A.C.C. Military Fuels",     2498.20,2626.50,-89.00,2749.90,2861.50,110.90),
		array("Kincaid Bridge",              -1339.80,599.20,-89.00,-1213.90,828.10,110.90),
		array("Kincaid Bridge",              -1213.90,721.10,-89.00,-1087.90,950.00,110.90),
		array("Kincaid Bridge",              -1087.90,855.30,-89.00,-961.90,986.20,110.90),
		array("King's",                      -2329.30,458.40,-7.60,-1993.20,578.30,200.00),
		array("King's",                      -2411.20,265.20,-9.10,-1993.20,373.50,200.00),
		array("King's",                      -2253.50,373.50,-9.10,-1993.20,458.40,200.00),
		array("LVA Freight Depot",           1457.30,863.20,-89.00,1777.40,1143.20,110.90),
		array("LVA Freight Depot",           1375.60,919.40,-89.00,1457.30,1203.20,110.90),
		array("LVA Freight Depot",           1277.00,1087.60,-89.00,1375.60,1203.20,110.90),
		array("LVA Freight Depot",           1315.30,1044.60,-89.00,1375.60,1087.60,110.90),
		array("LVA Freight Depot",           1236.60,1163.40,-89.00,1277.00,1203.20,110.90),
		array("Las Barrancas",               -926.10,1398.70,-3.00,-719.20,1634.60,200.00),
		array("Las Brujas",                  -365.10,2123.00,-3.00,-208.50,2217.60,200.00),
		array("Las Colinas",                 1994.30,-1100.80,-89.00,2056.80,-920.80,110.90),
		array("Las Colinas",                 2056.80,-1126.30,-89.00,2126.80,-920.80,110.90),
		array("Las Colinas",                 2185.30,-1154.50,-89.00,2281.40,-934.40,110.90),
		array("Las Colinas",                 2126.80,-1126.30,-89.00,2185.30,-934.40,110.90),
		array("Las Colinas",                 2747.70,-1120.00,-89.00,2959.30,-945.00,110.90),
		array("Las Colinas",                 2632.70,-1135.00,-89.00,2747.70,-945.00,110.90),
		array("Las Colinas",                 2281.40,-1135.00,-89.00,2632.70,-945.00,110.90),
		array("Las Payasadas",               -354.30,2580.30,2.00,-133.60,2816.80,200.00),
		array("Las Venturas Airport",        1236.60,1203.20,-89.00,1457.30,1883.10,110.90),
		array("Las Venturas Airport",        1457.30,1203.20,-89.00,1777.30,1883.10,110.90),
		array("Las Venturas Airport",        1457.30,1143.20,-89.00,1777.40,1203.20,110.90),
		array("Las Venturas Airport",        1515.80,1586.40,-12.50,1729.90,1714.50,87.50),
		array("Last Dime Motel",             1823.00,596.30,-89.00,1997.20,823.20,110.90),
		array("Leafy Hollow",                -1166.90,-1856.00,0.00,-815.60,-1602.00,200.00),
		array("Liberty City",                -1000.00,400.00,1300.00,-700.00,600.00,1400.00),
		array("Lil' Probe Inn",              -90.20,1286.80,-3.00,153.80,1554.10,200.00),
		array("Linden Side",                 2749.90,943.20,-89.00,2923.30,1198.90,110.90),
		array("Linden Station",              2749.90,1198.90,-89.00,2923.30,1548.90,110.90),
		array("Linden Station",              2811.20,1229.50,-39.50,2861.20,1407.50,60.40),
		array("Little Mexico",               1701.90,-1842.20,-89.00,1812.60,-1722.20,110.90),
		array("Little Mexico",               1758.90,-1722.20,-89.00,1812.60,-1577.50,110.90),
		array("Los Flores",                  2581.70,-1454.30,-89.00,2632.80,-1393.40,110.90),
		array("Los Flores",                  2581.70,-1393.40,-89.00,2747.70,-1135.00,110.90),
		array("Los Santos International",    1249.60,-2394.30,-89.00,1852.00,-2179.20,110.90),
		array("Los Santos International",    1852.00,-2394.30,-89.00,2089.00,-2179.20,110.90),
		array("Los Santos International",    1382.70,-2730.80,-89.00,2201.80,-2394.30,110.90),
		array("Los Santos International",    1974.60,-2394.30,-39.00,2089.00,-2256.50,60.90),
		array("Los Santos International",    1400.90,-2669.20,-39.00,2189.80,-2597.20,60.90),
		array("Los Santos International",    2051.60,-2597.20,-39.00,2152.40,-2394.30,60.90),
		array("Marina",                      647.70,-1804.20,-89.00,851.40,-1577.50,110.90),
		array("Marina",                      647.70,-1577.50,-89.00,807.90,-1416.20,110.90),
		array("Marina",                      807.90,-1577.50,-89.00,926.90,-1416.20,110.90),
		array("Market",                      787.40,-1416.20,-89.00,1072.60,-1310.20,110.90),
		array("Market",                      952.60,-1310.20,-89.00,1072.60,-1130.80,110.90),
		array("Market",                      1072.60,-1416.20,-89.00,1370.80,-1130.80,110.90),
		array("Market",                      926.90,-1577.50,-89.00,1370.80,-1416.20,110.90),
		array("Market Station",              787.40,-1410.90,-34.10,866.00,-1310.20,65.80),
		array("Martin Bridge",               -222.10,293.30,0.00,-122.10,476.40,200.00),
		array("Missionary Hill",             -2994.40,-811.20,0.00,-2178.60,-430.20,200.00),
		array("Montgomery",                  1119.50,119.50,-3.00,1451.40,493.30,200.00),
		array("Montgomery",                  1451.40,347.40,-6.10,1582.40,420.80,200.00),
		array("Montgomery Intersection",     1546.60,208.10,0.00,1745.80,347.40,200.00),
		array("Montgomery Intersection",     1582.40,347.40,0.00,1664.60,401.70,200.00),
		array("Mulholland",                  1414.00,-768.00,-89.00,1667.60,-452.40,110.90),
		array("Mulholland",                  1281.10,-452.40,-89.00,1641.10,-290.90,110.90),
		array("Mulholland",                  1269.10,-768.00,-89.00,1414.00,-452.40,110.90),
		array("Mulholland",                  1357.00,-926.90,-89.00,1463.90,-768.00,110.90),
		array("Mulholland",                  1318.10,-910.10,-89.00,1357.00,-768.00,110.90),
		array("Mulholland",                  1169.10,-910.10,-89.00,1318.10,-768.00,110.90),
		array("Mulholland",                  768.60,-954.60,-89.00,952.60,-860.60,110.90),
		array("Mulholland",                  687.80,-860.60,-89.00,911.80,-768.00,110.90),
		array("Mulholland",                  737.50,-768.00,-89.00,1142.20,-674.80,110.90),
		array("Mulholland",                  1096.40,-910.10,-89.00,1169.10,-768.00,110.90),
		array("Mulholland",                  952.60,-937.10,-89.00,1096.40,-860.60,110.90),
		array("Mulholland",                  911.80,-860.60,-89.00,1096.40,-768.00,110.90),
		array("Mulholland",                  861.00,-674.80,-89.00,1156.50,-600.80,110.90),
		array("Mulholland Intersection",     1463.90,-1150.80,-89.00,1812.60,-768.00,110.90),
		array("North Rock",                  2285.30,-768.00,0.00,2770.50,-269.70,200.00),
		array("Ocean Docks",                 2373.70,-2697.00,-89.00,2809.20,-2330.40,110.90),
		array("Ocean Docks",                 2201.80,-2418.30,-89.00,2324.00,-2095.00,110.90),
		array("Ocean Docks",                 2324.00,-2302.30,-89.00,2703.50,-2145.10,110.90),
		array("Ocean Docks",                 2089.00,-2394.30,-89.00,2201.80,-2235.80,110.90),
		array("Ocean Docks",                 2201.80,-2730.80,-89.00,2324.00,-2418.30,110.90),
		array("Ocean Docks",                 2703.50,-2302.30,-89.00,2959.30,-2126.90,110.90),
		array("Ocean Docks",                 2324.00,-2145.10,-89.00,2703.50,-2059.20,110.90),
		array("Ocean Flats",                 -2994.40,277.40,-9.10,-2867.80,458.40,200.00),
		array("Ocean Flats",                 -2994.40,-222.50,-0.00,-2593.40,277.40,200.00),
		array("Ocean Flats",                 -2994.40,-430.20,-0.00,-2831.80,-222.50,200.00),
		array("Octane Springs",              338.60,1228.50,0.00,664.30,1655.00,200.00),
		array("Old Venturas Strip",          2162.30,2012.10,-89.00,2685.10,2202.70,110.90),
		array("Palisades",                   -2994.40,458.40,-6.10,-2741.00,1339.60,200.00),
		array("Palomino Creek",              2160.20,-149.00,0.00,2576.90,228.30,200.00),
		array("Paradiso",                    -2741.00,793.40,-6.10,-2533.00,1268.40,200.00),
		array("Pershing Square",             1440.90,-1722.20,-89.00,1583.50,-1577.50,110.90),
		array("Pilgrim",                     2437.30,1383.20,-89.00,2624.40,1783.20,110.90),
		array("Pilgrim",                     2624.40,1383.20,-89.00,2685.10,1783.20,110.90),
		array("Pilson Intersection",         1098.30,2243.20,-89.00,1377.30,2507.20,110.90),
		array("Pirates in Men's Pants",      1817.30,1469.20,-89.00,2027.40,1703.20,110.90),
		array("Playa del Seville",           2703.50,-2126.90,-89.00,2959.30,-1852.80,110.90),
		array("Prickle Pine",                1534.50,2583.20,-89.00,1848.40,2863.20,110.90),
		array("Prickle Pine",                1117.40,2507.20,-89.00,1534.50,2723.20,110.90),
		array("Prickle Pine",                1848.40,2553.40,-89.00,1938.80,2863.20,110.90),
		array("Prickle Pine",                1938.80,2624.20,-89.00,2121.40,2861.50,110.90),
		array("Queens",                      -2533.00,458.40,0.00,-2329.30,578.30,200.00),
		array("Queens",                      -2593.40,54.70,0.00,-2411.20,458.40,200.00),
		array("Queens",                      -2411.20,373.50,0.00,-2253.50,458.40,200.00),
		array("Randolph Industrial Estate",  1558.00,596.30,-89.00,1823.00,823.20,110.90),
		array("Redsands East",               1817.30,2011.80,-89.00,2106.70,2202.70,110.90),
		array("Redsands East",               1817.30,2202.70,-89.00,2011.90,2342.80,110.90),
		array("Redsands East",               1848.40,2342.80,-89.00,2011.90,2478.40,110.90),
		array("Redsands West",               1236.60,1883.10,-89.00,1777.30,2142.80,110.90),
		array("Redsands West",               1297.40,2142.80,-89.00,1777.30,2243.20,110.90),
		array("Redsands West",               1377.30,2243.20,-89.00,1704.50,2433.20,110.90),
		array("Redsands West",               1704.50,2243.20,-89.00,1777.30,2342.80,110.90),
		array("Regular Tom",                 -405.70,1712.80,-3.00,-276.70,1892.70,200.00),
		array("Richman",                     647.50,-1118.20,-89.00,787.40,-954.60,110.90),
		array("Richman",                     647.50,-954.60,-89.00,768.60,-860.60,110.90),
		array("Richman",                     225.10,-1369.60,-89.00,334.50,-1292.00,110.90),
		array("Richman",                     225.10,-1292.00,-89.00,466.20,-1235.00,110.90),
		array("Richman",                     72.60,-1404.90,-89.00,225.10,-1235.00,110.90),
		array("Richman",                     72.60,-1235.00,-89.00,321.30,-1008.10,110.90),
		array("Richman",                     321.30,-1235.00,-89.00,647.50,-1044.00,110.90),
		array("Richman",                     321.30,-1044.00,-89.00,647.50,-860.60,110.90),
		array("Richman",                     321.30,-860.60,-89.00,687.80,-768.00,110.90),
		array("Richman",                     321.30,-768.00,-89.00,700.70,-674.80,110.90),
		array("Robada Intersection",         -1119.00,1178.90,-89.00,-862.00,1351.40,110.90),
		array("Roca Escalante",              2237.40,2202.70,-89.00,2536.40,2542.50,110.90),
		array("Roca Escalante",              2536.40,2202.70,-89.00,2625.10,2442.50,110.90),
		array("Rockshore East",              2537.30,676.50,-89.00,2902.30,943.20,110.90),
		array("Rockshore West",              1997.20,596.30,-89.00,2377.30,823.20,110.90),
		array("Rockshore West",              2377.30,596.30,-89.00,2537.30,788.80,110.90),
		array("Rodeo",                       72.60,-1684.60,-89.00,225.10,-1544.10,110.90),
		array("Rodeo",                       72.60,-1544.10,-89.00,225.10,-1404.90,110.90),
		array("Rodeo",                       225.10,-1684.60,-89.00,312.80,-1501.90,110.90),
		array("Rodeo",                       225.10,-1501.90,-89.00,334.50,-1369.60,110.90),
		array("Rodeo",                       334.50,-1501.90,-89.00,422.60,-1406.00,110.90),
		array("Rodeo",                       312.80,-1684.60,-89.00,422.60,-1501.90,110.90),
		array("Rodeo",                       422.60,-1684.60,-89.00,558.00,-1570.20,110.90),
		array("Rodeo",                       558.00,-1684.60,-89.00,647.50,-1384.90,110.90),
		array("Rodeo",                       466.20,-1570.20,-89.00,558.00,-1385.00,110.90),
		array("Rodeo",                       422.60,-1570.20,-89.00,466.20,-1406.00,110.90),
		array("Rodeo",                       466.20,-1385.00,-89.00,647.50,-1235.00,110.90),
		array("Rodeo",                       334.50,-1406.00,-89.00,466.20,-1292.00,110.90),
		array("Royal Casino",                2087.30,1383.20,-89.00,2437.30,1543.20,110.90),
		array("San Andreas Sound",           2450.30,385.50,-100.00,2759.20,562.30,200.00),
		array("Santa Flora",                 -2741.00,458.40,-7.60,-2533.00,793.40,200.00),
		array("Santa Maria Beach",           342.60,-2173.20,-89.00,647.70,-1684.60,110.90),
		array("Santa Maria Beach",           72.60,-2173.20,-89.00,342.60,-1684.60,110.90),
		array("Shady Cabin",                 -1632.80,-2263.40,-3.00,-1601.30,-2231.70,200.00),
		array("Shady Creeks",                -1820.60,-2643.60,-8.00,-1226.70,-1771.60,200.00),
		array("Shady Creeks",                -2030.10,-2174.80,-6.10,-1820.60,-1771.60,200.00),
		array("Sobell Rail Yards",           2749.90,1548.90,-89.00,2923.30,1937.20,110.90),
		array("Spinybed",                    2121.40,2663.10,-89.00,2498.20,2861.50,110.90),
		array("Starfish Casino",             2437.30,1783.20,-89.00,2685.10,2012.10,110.90),
		array("Starfish Casino",             2437.30,1858.10,-39.00,2495.00,1970.80,60.90),
		array("Starfish Casino",             2162.30,1883.20,-89.00,2437.30,2012.10,110.90),
		array("Temple",                      1252.30,-1130.80,-89.00,1378.30,-1026.30,110.90),
		array("Temple",                      1252.30,-1026.30,-89.00,1391.00,-926.90,110.90),
		array("Temple",                      1252.30,-926.90,-89.00,1357.00,-910.10,110.90),
		array("Temple",                      952.60,-1130.80,-89.00,1096.40,-937.10,110.90),
		array("Temple",                      1096.40,-1130.80,-89.00,1252.30,-1026.30,110.90),
		array("Temple",                      1096.40,-1026.30,-89.00,1252.30,-910.10,110.90),
		array("The Camel's Toe",             2087.30,1203.20,-89.00,2640.40,1383.20,110.90),
		array("The Clown's Pocket",          2162.30,1783.20,-89.00,2437.30,1883.20,110.90),
		array("The Emerald Isle",            2011.90,2202.70,-89.00,2237.40,2508.20,110.90),
		array("The Farm",                    -1209.60,-1317.10,114.90,-908.10,-787.30,251.90),
		array("The Four Dragons Casino",     1817.30,863.20,-89.00,2027.30,1083.20,110.90),
		array("The High Roller",             1817.30,1283.20,-89.00,2027.30,1469.20,110.90),
		array("The Mako Span",               1664.60,401.70,0.00,1785.10,567.20,200.00),
		array("The Panopticon",              -947.90,-304.30,-1.10,-319.60,327.00,200.00),
		array("The Pink Swan",               1817.30,1083.20,-89.00,2027.30,1283.20,110.90),
		array("The Sherman Dam",             -968.70,1929.40,-3.00,-481.10,2155.20,200.00),
		array("The Strip",                   2027.40,863.20,-89.00,2087.30,1703.20,110.90),
		array("The Strip",                   2106.70,1863.20,-89.00,2162.30,2202.70,110.90),
		array("The Strip",                   2027.40,1783.20,-89.00,2162.30,1863.20,110.90),
		array("The Strip",                   2027.40,1703.20,-89.00,2137.40,1783.20,110.90),
		array("The Visage",                  1817.30,1863.20,-89.00,2106.70,2011.80,110.90),
		array("The Visage",                  1817.30,1703.20,-89.00,2027.40,1863.20,110.90),
		array("Unity Station",               1692.60,-1971.80,-20.40,1812.60,-1932.80,79.50),
		array("Valle Ocultado",              -936.60,2611.40,2.00,-715.90,2847.90,200.00),
		array("Verdant Bluffs",              930.20,-2488.40,-89.00,1249.60,-2006.70,110.90),
		array("Verdant Bluffs",              1073.20,-2006.70,-89.00,1249.60,-1842.20,110.90),
		array("Verdant Bluffs",              1249.60,-2179.20,-89.00,1692.60,-1842.20,110.90),
		array("Verdant Meadows",             37.00,2337.10,-3.00,435.90,2677.90,200.00),
		array("Verona Beach",                647.70,-2173.20,-89.00,930.20,-1804.20,110.90),
		array("Verona Beach",                930.20,-2006.70,-89.00,1073.20,-1804.20,110.90),
		array("Verona Beach",                851.40,-1804.20,-89.00,1046.10,-1577.50,110.90),
		array("Verona Beach",                1161.50,-1722.20,-89.00,1323.90,-1577.50,110.90),
		array("Verona Beach",                1046.10,-1722.20,-89.00,1161.50,-1577.50,110.90),
		array("Vinewood",                    787.40,-1310.20,-89.00,952.60,-1130.80,110.90),
		array("Vinewood",                    787.40,-1130.80,-89.00,952.60,-954.60,110.90),
		array("Vinewood",                    647.50,-1227.20,-89.00,787.40,-1118.20,110.90),
		array("Vinewood",                    647.70,-1416.20,-89.00,787.40,-1227.20,110.90),
		array("Whitewood Estates",           883.30,1726.20,-89.00,1098.30,2507.20,110.90),
		array("Whitewood Estates",           1098.30,1726.20,-89.00,1197.30,2243.20,110.90),
		array("Willowfield",                 1970.60,-2179.20,-89.00,2089.00,-1852.80,110.90),
		array("Willowfield",                 2089.00,-2235.80,-89.00,2201.80,-1989.90,110.90),
		array("Willowfield",                 2089.00,-1989.90,-89.00,2324.00,-1852.80,110.90),
		array("Willowfield",                 2201.80,-2095.00,-89.00,2324.00,-1989.90,110.90),
		array("Willowfield",                 2541.70,-1941.40,-89.00,2703.50,-1852.80,110.90),
		array("Willowfield",                 2324.00,-2059.20,-89.00,2541.70,-1852.80,110.90),
		array("Willowfield",                 2541.70,-2059.20,-89.00,2703.50,-1941.40,110.90),
		array("Yellow Bell Station",         1377.40,2600.40,-21.90,1492.40,2687.30,78.00),
		// Main Zones                        
		array("Los Santos",                  44.60,-2892.90,-242.90,2997.00,-768.00,900.00),
		array("Las Venturas",                869.40,596.30,-242.90,2997.00,2993.80,900.00),
		array("Bone County",                 -480.50,596.30,-242.90,869.40,2993.80,900.00),
		array("Tierra Robada",               -2997.40,1659.60,-242.90,-480.50,2993.80,900.00),
		array("Tierra Robada",               -1213.90,596.30,-242.90,-480.50,1659.60,900.00),
		array("San Fierro",                  -2997.40,-1115.50,-242.90,-1213.90,1659.60,900.00),
		array("Red County",                  -1213.90,-768.00,-242.90,2997.00,596.30,900.00),
		array("Flint County",                -1213.90,-2892.90,-242.90,44.60,-768.00,900.00),
		array("Whetstone",                   -2997.40,-2892.90,-242.90,-1213.90,-1115.50,900.00)
	);

	//---------------------------------------------------------------------------------------------------

	/* GetPlayer2DZone(x, y, z)
	 * @Info:   Used to retrieve the players zone/area name. DOES NOT COMPARE HEIGHTS!
	 *
	 * @params: x  		- The X coordinate of the location you wish to know which zone is in
	 * @params: y  		- The Y coordinate of the location you wish to know which zone is in
	 * @return: zone  	- The zone the player is in
	 */

	function GetPlayer2DZone($x, $y) //Credits to Cueball, Betamaster, Mabako, and Simon (for finetuning).
	{
		global $gSAZones;
		for($i = 0; $i != sizeof($gSAZones); $i++ )
		{
			if($x >= $gSAZones[$i][1] && $x <= $gSAZones[$i][4] && $y >= $gSAZones[$i][2] && $y <= $gSAZones[$i][5])
			{
				return $gSAZones[$i][0];
			}
		}
		return 0;
	}
	
	//---------------------------------------------------------------------------------------------------

	/* GetPlayer3DZone(x, y, z)
	 * @Info:   Used to retrieve the players zone/area name and comparing with heights.
	 *
	 * @params: x  		- The X coordinate of the location you wish to know which zone is in
	 * @params: y  		- The Y coordinate of the location you wish to know which zone is in
	 * @params: z  		- The Z coordinate of the location you wish to know which zone is in
	 * @return: zone  	- The zone the player is in
	 */

	function GetPlayer3DZone($x, $y, $z) //Credits to Cueball, Betamaster, Mabako, and Simon (for finetuning).
	{
		global $gSAZones;
		for($i = 0; $i != sizeof($gSAZones); $i++ )
		{
			if($x >= $gSAZones[$i][1] && $x <= $gSAZones[$i][4] && $y >= $gSAZones[$i][2] && $y <= $gSAZones[$i][5] && $z >= $gSAZones[$i][3] && $z <= $gSAZones[$i][6])
			{
				return $gSAZones[$i][0];
			}
		}
		return 0;
	}

	//---------------------------------------------------------------------------------------------------

	/* IsPlayerInZone(x, y, z, zone)
	 * @Info:   Used to check if the player is inside the zone[] parameter.
	 *
	 * @params: x  		- The X coordinate of the location you wish to know which zone is in
	 * @params: y  		- The Y coordinate of the location you wish to know which zone is in
	 * @params: z  		- The Z coordinate of the location you wish to know which zone is in
	 * @params: zone  	- The zone to test if the player is in
	 * @return: bool    - If the player is in the tested zone or not
	 */

	function IsPlayerInZone($x, $y, $z, $zone) //Credits to Cueball, Betamaster, Mabako, and Simon (for finetuning).
	{
		$TmpZone = GetPlayer3DZone($x, $y, $z);
		if($TmpZone == $zone) return 1;
		return 0;
	}

	function SendMail($email, $emailname, $subject, $body)
	{
		require 'class.phpmailer.php';

		$mail = new PHPMailer;

		$mail->IsSMTP();                                      // Set mailer to use SMTP
		$mail->Host	    = 'mail.ng-gaming.net'; 			  // Specify main and backup server
		$mail->Port     = 25;								  // Mail port
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'donotreply';                       // SMTP username
		$mail->Password = 'p7u9ase49CRuPH';                   // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
		$mail->SMTPDebug = 0;

		$mail->From = 'donotreply@ng-gaming.net';
		$mail->FromName = 'Next Generation Gaming, LLC.';
		if(!$emailname) $mail->AddAddress($email);			  // Without a name
		else $mail->AddAddress($email, $emailname);			  // With a name

		$mail->IsHTML(true);                                  // Set email format to HTML

		$mail->Subject = $subject;
		$mail->Body    = $body;

		if(!$mail->Send()) {
		   echo 'Email could not be sent. Please send an email to techissues@ng-gaming.net with this message.';
		   echo 'Mailer Error: ' . $mail->ErrorInfo;
		   exit;
		}

		//echo 'Email has been sent to inbox!';
	}

function redirect($type, $code) {
$ip = $_SERVER['REMOTE_ADDR'];
$date = date('Y-m-d H:i:s');
if($section == "General") { $logquery = "INSERT INTO `cp_log_general` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, '$date', '$user', '$area', '$details', '$ip')"; }
if($section == "Staff") { $logquery = "INSERT INTO `cp_log_staff` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, '$date', '$user', '$area', '$details', '$ip')"; }
if($section == "Faction") { $logquery = "INSERT INTO `cp_log_faction` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, '$date', '$user', '$area', '$details', '$ip')"; }
if($section == "Family") { $logquery = "INSERT INTO `cp_log_family` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, '$date', '$user', '$area', '$details', '$ip')"; }
if($section == "Customer Relations") { $logquery = "INSERT INTO `cp_log_cr` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, '$date', '$user', '$area', '$details', '$ip')"; }
$runquery = mysqli_query($mysqli,$logquery);
if (!$runquery) {
    $message  = 'Invalid query: ' . mysqli_error() . "\n";
    $message .= 'Whole query: ' . $logquery;
    die($message);
	}
}

/* Not finished
function getNotices($user) {
	$pid = $inf['id'];    
	// Ban Appeals
	$banaplquery = mysqli_query($mysqli,"SELECT * FROM `ban` WHERE `status`='4' AND `admin`='$user' ORDER BY `date_added` ASC;");
	$bancount = mysqli_num_rows($banaplquery);
	// Flags
	$flagquery = mysqli_query($mysqli,"SELECT * FROM `flags` WHERE `id`='$pid' ORDER BY `time` ASC;");
	$flagcount = mysqli_num_rows($flagquery);
}
*/

function mInfo($userid,$mysqli) {
	$checkAd = mysqli_query($mysqli,"SELECT `AdminLevel`, `Helper` FROM `accounts` WHERE `id`='".$userid."'");
	$cAd = mysqli_fetch_array($checkAd);
	if ($cAd['AdminLevel'] >= 2 || $cAd['Helper'] >= 2) {
		if($cAd['AdminLevel'] >=2) {
		$minfoq = mysqli_query($mysqli,"SELECT `timezone`, `gtalk` FROM `cp_stat` WHERE `user_id`='".$userid."' AND `type` = '1'");
		} else {
		$minfoq = mysqli_query($mysqli,"SELECT `timezone`, `gtalk` FROM `cp_stat` WHERE `user_id`='".$userid."' AND `type` = '3'");
		}
		$minfo = mysqli_fetch_array($minfoq);
		if ($minfo['gtalk'] == 'N/A') { echo '<meta http-equiv="refresh" content="0;url=/index.php?p=settings">'; }
		if ($minfo['timezone'] == '') { echo '<meta http-equiv="refresh" content="0;url=/index.php?p=settings">'; }  
	}
}

function aRank($inf) {
	if($inf['AdminLevel'] == 1) { $rank = '<font color="Yellow">Server Moderator</font>'; }
	if($inf['Helper'] == 2) { $rank = '<font color="#00f4f4">Community Advisor</font>'; }
	if($inf['Helper'] == 3) { $rank = '<font color="#00f4f4">Senior Advisor</font>'; }
	if($inf['Helper'] == 4) { $rank = '<font color="#00f4f4">Chief Advisor</font>'; }
	if($inf['AdminLevel'] == 2) { $rank = '<font color="Lime">Junior Admin</font>'; }
	if($inf['AdminLevel'] == 3) { $rank = '<font color="Lime">General Admin</font>'; }
	if($inf['AdminLevel'] == 4) { $rank = '<font color="SandyBrown">Senior Admin</font>'; }
	if($inf['AdminLevel'] == 1337) { $rank = '<font color="Red">Head Admin</font>'; }
	if($inf['AdminLevel'] == 1338) { $rank = '<font color="#298eff">Lead Head Admin</font>'; }
	if($inf['AdminLevel'] == 99999) { $rank = '<font color="#298eff">Executive Admin</font>'; }
	return $rank;
}

function UserRank($level,$helper,$username) {
	if($level == 1) { $ruser = "<span style='color:yellow;font-weight:bolder'>".$username."</span>"; }
	if($helper >= 2) { $ruser = "<span style='color:#00f4f4;font-weight:bolder'>".$username."</span>"; }
	if($level == 2 || $level == 3) { $ruser = "<span style='color:lime;font-weight:bolder'>".$username."</span>"; }
	if($level == 4) { $ruser = "<span style='color:sandybrown;font-weight:bolder'>".$username."</span>"; }
	if($level == 1337) { $ruser = "<span style='color:red;font-weight:bolder'>".$username."</span>"; }
	if($level == 1338 || $level == 99999) { $ruser = "<span style='color:#298eff;font-weight:bolder'>".$username."</span>"; }
	if($level == 0 && $helper < 2) { $ruser = "<span style='color:white;font-weight:bolder'>".$username."</span>"; }
	return $ruser;
}

// Store functions
/* ---------------- */

function GetStoreStatus($inf) {
	$store = mysqli_query($mysqli,"SELECT `store_online` FROM `cp_store_manage` WHERE `id` = '1'");
	$result = mysqli_fetch_array($store);
	$status = 'ON';
	return $status;
}

function AddToCart($user, $userip, $packid) {
	// Check if selected pack is already in customers cart
	$duplicatePacks = mysqli_query($mysqli,"SELECT `cart_pack_id` FROM `cp_store_cart` WHERE `customer_id`='$user'");
	$dupPack = mysqli_num_rows($duplicatePacks);
	if ($dupPack == 1) {
		$redir = '<meta http-equiv="refresh" content="0;url=http://'.$_SERVER['SERVER_NAME'].'/store.php?p=main&error=1">';
		echo $redir;exit();
	}
	$date = date('Y-m-d h:i:s A');
	// Check if there is at least 1 item in the customers cart
	$findPrevCart = mysqli_query($mysqli,"SELECT `cart_id` FROM `cp_store_cart` WHERE `customer_id`='$user' AND `cart_id`='1' LIMIT 1");
	$prevCart = mysqli_num_rows($findPrevCart);
	// If there is not one, run..
	if ($prevCart != 1) {
	$addProduct = mysqli_query($mysqli,"
		INSERT INTO `cp_store_cart` (`cart_id`,`customer_id`,`customer_ip_address`,`cart_pack_id`,`date_item_added`)
		VALUES ('1','$user','$userip','$packid','$date');"
	 );
	}
	// If there is one, run..
	if ($prevCart == 1) {
	$prevCartID = mysqli_query($mysqli,"SELECT `cart_id`,`date_item_added` FROM `cp_store_cart` WHERE `customer_id`='".$user."' ORDER BY `date_item_added` DESC LIMIT 1;");
	$cartId = mysqli_fetch_array($prevCartID);
	$cart = $cartId['cart_id'];
	$addProduct = mysqli_query($mysqli,"
		INSERT INTO `cp_store_cart` (`id`,`cart_id`,`customer_id`,`customer_ip_address`,`cart_pack_id`,`date_item_added`)
		VALUES ('','$cart' + 1,'$user','$userip','$packid','$date');"
	 );
	}
}

function RemoveFromCart($user, $cartId) {
	$removeq = mysqli_query($mysqli,"DELETE FROM `cp_store_cart` WHERE `customer_id`='".$user."' AND `cart_id`='".$cartId."';");
}

function GetStorePrice($packid) {
	$qprices = mysqli_query($mysqli,"SELECT `total_price` FROM `cp_store_manage` WHERE `pack_id`='".$packid."';");
	$prices = mysqli_fetch_array($qprices);
	$price = $prices['total_price'];
	return $price;
}

function GetOldPrice($packid) {
	$qprices = mysqli_query($mysqli,"SELECT `old_price` FROM `cp_store_manage` WHERE `pack_id`='".$packid."';");
	$prices = mysqli_fetch_array($qprices);
	$price = $prices['old_price'];
	return $price;
}

function GetPackPicture($packid) {
	$qpictures = mysqli_query($mysqli,"SELECT `pack_picture` FROM `cp_store_manage` WHERE `pack_id`='".$packid."';");
	$pictures = mysqli_fetch_array($qpictures);
	$picture = $pictures['pack_picture'];
	return $picture;
}

function GetTotalTokens($packid) {
	$qtokens = mysqli_query($mysqli,"SELECT `total_tokens` FROM `cp_store_manage` WHERE `pack_id`='".$packid."';");
	$tokens = mysqli_fetch_array($qtokens);
	$token = $tokens['total_tokens'];
	return $token;
}

function GetAdditionalTokens($packid) {
	$qtokens = mysqli_query($mysqli,"SELECT `additional_tokens` FROM `cp_store_manage` WHERE `pack_id`='".$packid."';");
	$tokens = mysqli_fetch_array($qtokens);
	$token = $tokens['additional_tokens'];
	return $token;
}

function GetCartSize($userid) {
	$userCart = mysqli_query($mysqli,"SELECT * FROM `cp_store_cart` WHERE `customer_id`='".$userid."';");
	$cart = mysqli_num_rows($userCart);
	return $cart;
}

function GetCartPrice($user) {
	$userCart = mysqli_query($mysqli,"SELECT SUM(total_price) FROM `cp_store_cart` INNER JOIN `cp_store_manage` WHERE `customer_id`='".$user."' AND `cart_pack_id` = `pack_id`;");
	$cartItems = mysqli_fetch_array($userCart);
	$total = $cartItems['SUM(total_price)'];
	return $total;
}

function GetCartTokens($user) {
	$userCart = mysqli_query($mysqli,"SELECT SUM(total_tokens + additional_tokens) as total_tokens FROM `cp_store_cart` INNER JOIN `cp_store_manage` WHERE `customer_id`='".$user."' AND `cart_pack_id` = `pack_id`;");
	$cartItems = mysqli_fetch_array($userCart);
	$total = $cartItems['total_tokens'];
	return $total;
}

function ProcessOrder($userid) {
	// Store order information
	if(isset($userid)) {
		$sOrder = mysqli_query($mysqli,"INSERT INTO `cp_store_orders` (`customer_id`) VALUES (`$userid`);");
		$so = mysqli_num_rows($sOrder);
	}
	// Process order
	if ($so == 1) {
		
	}
}

function GetPaymentMethod($id) {
	switch($id) {
		case 1: $method = 'PayPal'; break;
		case 2: $method = 'Amazon'; break;
		case 3: $method = 'Google Checkout'; break;
	}
	return $method;
}

function GetShiftName($id) {
	$query = mysqli_query($mysqli,"SELECT `shift` FROM `cp_shift_blocks` WHERE `shift_id` = $id");
	$array = mysqli_fetch_array($query, MYSQLI_NUM);
	return $array['shift'];
}

function GetShiftIDByHour($hour) {
	$query = mysqli_query($mysqli,"SELECT `shift_id` FROM `cp_shift_blocks` WHERE `time_start` = '$hour'");
	$array = mysqli_fetch_array($query, MYSQLI_NUM);
	return $array['shift_id'];
}

// Head Navigation
/* ---------------- */

function head() {
	require('head.php');
}

function footer() {
	require('footer.php');
}

function headbar($inf) {
echo '<body id=\'ipboard_body\'> ';

//echo '<div style="padding:10px 10px 10px 10px;background-color:orange;font-weight:bold;font-size:15px;text-align:center"><img src="http://'.$_SERVER['SERVER_NAME'].'/global/images/all/js_alert.png" /> Found a bug? Have a suggestion? <a href="http://tracker.ng-gaming.net">tracker.ng-gaming.net</a></div>';
echo '<p id="admin_bar">';
if(preg_match("/staff/", $_SERVER["PHP_SELF"])) {
	if(($inf['AdminLevel'] > 0 || $inf['Helper'] > 1)) {
		echo '[<a href="/"><span class="sec_inactive">Dashboard</span></a> &#8226; <a href="/staff"><span class="sec_active">Staff</span></a>]';
	}
} else {
	if(($inf['AdminLevel'] > 0 || $inf['Helper'] > 1)) {
		echo '[<a href="/"><span class="sec_active">Dashboard</span></a> &#8226; <a href="/staff"><span class="sec_inactive">Staff</span></a>]';
	}
}
	echo '<span id=\'logged_in\' style="margin-right:0px;">';
		//if(date('Y-m-d',strtotime( $inf['dCheckin'] )) != date('Y-m-d')) { echo "<span id='check_in' style='color:orange'>You need to check in [<a href='/admin/index.php?p=checkin'>Check In</a>]</span>"; }
	//else { echo "<span id='check_in' style='color:green'>You have checked in today.</span>"; }
	echo "Logged in as ".UserRank($inf['AdminLevel'],$inf['Helper'],$inf['Username'])." (<a href='index.php?action=logout'>Log Out</a>)</span>";
	echo '</p>';
	echo '<div id=\'header\'> ';
	echo '<div id=\'branding\'> ';
	//echo '<a href="http://'.$_SERVER['SERVER_NAME'].'"><img src=\'http://'.$_SERVER['SERVER_NAME'].'/global/images/all/logo.png\' alt=\'Logo\' /></a>';
	echo '<a href="http://'.$_SERVER['SERVER_NAME'].'"><img src=\'/global/images/all/logo.png\' alt=\'Logo\' /></a>';
	echo '</div>';

}
?>