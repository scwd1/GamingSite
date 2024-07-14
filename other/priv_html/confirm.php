<?php
require('./global/class/SQL.php');
if(isset($_GET['token']) && isset($_GET['type']))
{
	if($_GET['type'] == "1")
	{
		$enc_token = hash('whirlpool', $_GET['token']);
		$query = mysql_query("SELECT * FROM `cp_cache_sec_questions` WHERE `token` = '$enc_token'");
		$check = mysql_num_rows($query);
		if($check == 0) {
			echo '<script>alert("Invalid token!");</script>';
		}
		else {
		$result = mysql_fetch_array($query);
			mysql_query("INSERT INTO `sec_questions` (`userid`, `question`, `answer`) VALUES ('$result[user_id]', '$result[question]', '$result[answer]')");
			mysql_query("DELETE FROM `cp_cache_sec_questions` WHERE `user_id` = '$result[user_id]'");
		}
	}
	if($_GET['type'] == "2")
	{
		$enc_token = hash('whirlpool', $_GET['token']);
		$query = mysql_query("SELECT * FROM `cp_cache_sec_questions` WHERE `token` = '$enc_token'");
		$check = mysql_num_rows($query);
		if($check == 0) {
			echo '<script>alert("Invalid token!");</script>';
		}
		else {
			$result = mysql_fetch_array($query);
			mysql_query("UPDATE `sec_questions` SET `question` = '$result[question]', `answer` = $result[answer] WHERE `userid` = '$result[user_id]'");
			mysql_query("DELETE FROM `cp_cache_sec_questions` WHERE `user_id` = '$result[user_id]'");
		}
	}
	if($_GET['type'] == "3")
	{
		$enc_token = hash('whirlpool', $_GET['token']);
		$query = mysql_query("SELECT * FROM `cp_cache_passreset` WHERE `token` = '$enc_token'");
		$check = mysql_num_rows($query);
		if($check == 0) {
			echo '<script>alert("Invalid token!");</script>';
		}
		else
		{
			$pass = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,8);
			$enc_pass = strtoupper(hash('whirlpool', $pass));
			$result = mysql_fetch_array($query);
			$emailquery = mysql_query("SELECT `Username`, `Email` FROM `accounts` WHERE `id` = $result[user_id]");
			$email = mysql_fetch_array($emailquery);
			$message = 'An account on Next Generation Gaming that belongs to this email address has authorized approval for a password reset. The new password is: '.$pass.'
			<br /><br />
			If you believe this change was made in error, please contact an Administrator on the forums via an <a href="http://www.ng-gaming.net/forums/misc.php?do=form&fid=10">Administrative Request</a> or via TeamSpeak.';
			
			SendMail($email['Email'], $email['Username'], "Your account password has been reset!", $message);

			mysql_query("UPDATE `accounts` SET `Key` = '$enc_pass' WHERE `id` = '$result[user_id]'");
			mysql_query("DELETE FROM `cp_cache_passreset` WHERE `user_id` = '$result[user_id]'");
		}
	}
	echo '<meta http-equiv="refresh" content="0;url=./index.php?p=dashboard">';
}
?>