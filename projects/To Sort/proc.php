<?php require('../global/func.php');

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

//----Variables
$action = $_POST['action'];
$admin = $_POST['admin'];
$userid = $_POST['userid'];
$shiftid = $_POST['shiftid'];
$shiftblock = $_POST['shiftblock'];
$assigndate = $_POST['assigndate'];
$ip = $_POST['ip'];
$question = escape_string($mysqli, $_POST['question']);
$answer = escape_string($mysqli, $_POST['answer']);
$enc_answer = hash('whirlpool', $answer);
$curanswer = escape_string($mysqli, $_POST['curanswer']);
$enc_curanswer = hash('whirlpool', $curanswer);
$date = date('Y-m-d');
$diff = $date - $assigndate;
$intdiff = intval($diff);
$token = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,20);
$enc_token = hash('whirlpool', $token);
$gtalk = escape_string($mysqli, $_POST['gtalk']);
$paypal = escape_string($mysqli, $_POST['paypal']);
$timezone = $_POST['timezone'];
$enable = $_POST['enable'];
//-------End Variables

if(strtolower($admin) != strtolower($inf['Username'])) { echo "Data tampered with. ERR:001"; exit(); }
if($ip != $_SERVER['REMOTE_ADDR']) { echo "Data tampered with. ERR:002"; exit(); }

if($action == "email_optout")
{
	if($_POST['optout'] == 1) mysqli_query($mysqli,"UPDATE `accounts` SET `EmailOptOut` = 1 WHERE `id` = '$userid'");
	else mysqli_query($mysqli,"UPDATE `accounts` SET `EmailOptOut` = 0 WHERE `id` = '$userid'");
	echo '<meta http-equiv="refresh" content="0;url=../index.php?p=settings&success=4">';
}

if($action == "secquestion") {
	if(isset($_POST['curanswer']))
	{
		$seccheckquery = mysqli_query($mysqli,"SELECT `answer` FROM `sec_questions` WHERE `userid` = $inf[id]");
		$seccheck = mysqli_fetch_array($seccheckquery,MYSQLI_ASSOC);
		if($enc_curanswer == $seccheck['answer'])
		{
			mysqli_query($mysqli,"INSERT INTO `cp_cache_sec_questions` (`id`, `user_id`, `question`, `answer`, `token`, `date`) VALUES (NULL, $inf[id], '$question', '$enc_answer', '$enc_token', NOW())");
			$message = 'An account on Next Generation Gaming is requesting to authorize the use of a security question and answer. The question requested is "'.$question.'".
			<br><br>
			If you made this request and would like to approve this request for use on the account, please visit this link: <a href="http://cp.ng-gaming.net/confirm.php?token='.$token.'&type=2">http://cp.ng-gaming.net/confirm.php?token='.$token.'&type=2</a>
			<br /><br />
			If this request was not made by you, you can ignore this email and the request will expire in 24 hours from the time of the request being submitted.';
			SendMail($inf['Email'], $inf['Username'], "Your security question requires approval!", $message);
			echo '<meta http-equiv="refresh" content="0;url=../index.php?p=settings&n=2">';
		}
		else {
			echo '<meta http-equiv="refresh" content="0;url=../index.php?p=settings&n=1">';
		}
	}
	else {
		mysqli_query($mysqli,"INSERT INTO `cp_cache_sec_questions` (`id`, `user_id`, `question`, `answer`, `token`, `date`) VALUES (NULL, $inf[id], '$question', '$enc_answer', '$enc_token', NOW())");
		$message = 'An account on Next Generation Gaming is requesting to authorize the use of a security question and answer. The question requested is "'.$question.'".
		<br /><br />
		If you made this request and would like to approve this request for use on the account, please visit this link: <a href="http://cp.ng-gaming.net/confirm.php?token='.$token.'&type=1">http://cp.ng-gaming.net/confirm.php?token='.$token.'&type=1</a>
		<br /><br />
		If this request was not made by you, you can ignore this email and the request will expire in 24 hours from the time of the request being submitted.';
		SendMail($inf['Email'], $inf['Username'], "Your security question requires approval!", $message);
		echo '<meta http-equiv="refresh" content="0;url=../index.php?p=settings&n=2">';
	}
}

if($action == "update_gtalk") {
	if (preg_match("%[A-Za-z0-9._\%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}%", $gtalk)) {
		mysqli_query($mysqli,"UPDATE `cp_stat` SET `gtalk` = '$gtalk' WHERE `user_id` = '$userid';");
		echo '<meta http-equiv="refresh" content="0;url=../index.php?p=settings&success=1">';
	} else {
		echo '<meta http-equiv="refresh" content="0;url=../index.php?p=settings&error=1">';
	}
}

if($action == "update_paypal") {
	if (preg_match("%[A-Za-z0-9._\%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}%", $paypal)) {
		mysqli_query($mysqli,"UPDATE `cp_stat` SET `paypal` = '$paypal' WHERE `user_id` = '$userid'");
		echo '<meta http-equiv="refresh" content="0;url=../index.php?p=settings&success=2">';
	} else {
		echo '<meta http-equiv="refresh" content="0;url=../index.php?p=settings&error=2">';
	}
}

if($action == "update_timezone") {
	mysqli_query($mysqli,"UPDATE `cp_stat` SET `timezone` = '$timezone' WHERE `user_id` = '$userid'");
	echo '<meta http-equiv="refresh" content="0;url=../index.php?p=settings&success=2">';
}

if($action == "ref_generate")
{
	$token = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,20);
	mysqli_query($mysqli,"UPDATE `accounts` SET `referral_id` = '$token' WHERE `id` = $inf[id]");
	echo '<meta http-equiv="refresh" content="0;url=../index.php?p=referral">';
}

if($action == "sig_generate")
{
	mysqli_query($mysqli,"INSERT INTO `sig_stats` (`user_id`, `enabled`) VALUES ('$inf[id]', '1')");
	echo '<meta http-equiv="refresh" content="0;url=../index.php?p=sig">';
}

if($action == "sig_update")
{
	$fields = implode("` = 1, `", $_POST['field']);
	for($i = 1; $i <= 58; $i++)
	{
		$part[$i] = "field".$i;
	}
	$querypart = implode("` = 0, `", $part);
	mysqli_query($mysqli,"UPDATE `sig_stats` SET `$querypart` = 0 WHERE `user_id` = $inf[id]");
	mysqli_query($mysqli,"UPDATE `sig_stats` SET `$fields` = 1 WHERE `user_id` = $inf[id]");
	echo '<meta http-equiv="refresh" content="0;url=../index.php?p=sig">';
}

if($action == "sig_enable")
{
	if($enable == 1) mysqli_query($mysqli,"UPDATE `sig_stats` SET `enabled` = '0' WHERE `user_id` = '$inf[id]'");
	else if($enable == 0) mysqli_query($mysqli,"UPDATE `sig_stats` SET `enabled` = '1' WHERE `user_id` = '$inf[id]'");
	echo '<meta http-equiv="refresh" content="0;url=../index.php?p=sig">';
}
?>