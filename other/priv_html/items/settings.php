<?php
if(isset($_POST['action']) && $_POST['action'] == "newmail") {
	if($_POST['email_new_rep'] == $_POST['email_new']) {
	if(filter_var($_POST['email_new'], FILTER_VALIDATE_EMAIL)) {
	$token = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,20);
	$query = "INSERT INTO `cp_cache_email` (`id`, `user_id`, `email_address`, `token`) VALUES (NULL, '$_POST[userid]', '$_POST[email_new]', '$token')";
	$db_insert = mysqli_query($mysqli,$query);

	$message = 'An account on Next Generation Gaming is requesting to use this email address.
	<br /><br />
	If you made this request and would like to approve this email for use on the account, please visit this link: <a href="http://cp.ng-gaming.net/emailconfirm.php?token='.$token.'&confirm=1">http://cp.ng-gaming.net/emailconfirm.php?token='.$token.'&confirm=1</a>
	<br /><br />
	If this request was not made by you, please visit this link to cancel the request: <a href="http://cp.ng-gaming.net/emailconfirm.php?token='.$token.'&confirm=0">http://cp.ng-gaming.net/emailconfirm.php?token='.$token.'&confirm=0</a>';
	SendMail($_POST['email_new'], $inf['Username'], "Your email address requires approval!", $message);
	
	$note = "An authorization code has been sent to your email address.";
	}
	else {
		echo "<script type='text/javascript'>
			alert(This email is invalid!);
		</script>";
	}
	}
	else {
	$note = "<span style='color:red'>The email address was not entered correctly.</span>";
	}
}
if(isset($_POST['action']) && $_POST['action'] == "updatemail") {
	if($_POST['email_new_rep'] == $_POST['email_new']) {
	$token = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,20);
	$query = "INSERT INTO `cp_cache_email` (`id`, `user_id`, `email_address`, `token`) VALUES (NULL, '$_POST[userid]', '$_POST[email_new]', '$token')";
	$db_insert = mysqli_query($mysqli,$query);

	$message = 'An account on Next Generation Gaming is requesting to use a new email address.
	<br /><br />
	If you made this request and would like to approve this email for use on the account, please visit this link: <a href="http://cp.ng-gaming.net/emailconfirm.php?token='.$token.'&confirm=1">http://cp.ng-gaming.net/emailconfirm.php?token='.$token.'&confirm=1</a>
	<br /><br />
	If this request was not made by you, please visit this link to cancel the request: <a href="http://cp.ng-gaming.net/emailconfirm.php?token='.$token.'&confirm=0">http://cp.ng-gaming.net/emailconfirm.php?token='.$token.'&confirm=0</a>';
	SendMail($_POST['email_new'], $inf['Username'], "Your email address requires approval!", $message);
	
	$note = "An authorization code has been sent to your email address.";
	}
	else {
	$note = "<span style='color:red'>The email address was not entered correctly.</span>";
	}
}

$minfoq = mysqli_query($mysqli,"SELECT `timezone`, `gtalk`, `PayPal` FROM `cp_stat` WHERE `user_id`='".$inf['id']."'");
$minfo = mysqli_fetch_array($minfoq, MYSQLI_ASSOC);

if(isset($_GET['success'])) { 
	if($_GET['success'] == '1') { $smsg = "Google Talk address has been updated."; }
	if($_GET['success'] == '2') { $smsg = 'Timezone has been updated'; }
	if($_GET['success'] == '3') { $smsg = "PayPal address has been updated."; }
	if($_GET['success'] == '4') $smsg = 'Email opt-out settings have been updated';
}
if(isset($_GET['error'])) {
	if($_GET['error'] == '1') { $emsg = "Invalid GTalk address. Example: johndoe@gmail.com"; }
	if($_GET['error'] == '2') { $emsg = "Invalid PayPal address. Example: johndoe@gmail.com"; }
}
?>
<style type='text/css'>
 
</style>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
 <script>
  $(function() {
	var tooltips = $( "[title]" ).tooltip();
    tooltips.tooltip( "open" );
  });
 </script>
			<div id='content_wrap'>
				<ol id='breadcrumb'><li><?php echo $section; ?> > Settings</li></ol>
				<div class='section_title'><h2>My Settings</h2></div>
				<?php if(isset($smsg)) { echo "<div class='acp-message'>$smsg</div>"; } if(isset($emsg)) { echo "<div class='acp-error'>$emsg</div>"; } ?>
				<div class='acp-box'>
				<h3>Update Email Address</h3>
					<?php if(isset($note)) { echo $note; }
					$cachequery = mysqli_query($mysqli,"SELECT `id` FROM `cp_cache_email` WHERE `user_id` = '$inf[id]'");
					$cache = mysqli_fetch_row($cachequery);
					if($inf['id'] == $cache['0']) { echo "There is currently an email pending for this account."; }
					else { ?>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
				<form id="email" action="index.php?p=settings" method="POST" onsubmit="javascript:return validate('email','email_new');">
					<?php if($inf['Email'] == "") { ?>
						<tr><td width='50%'>New Email Address</td><td><input type="text" id="email_new" name="email_new" maxlength="64"></td></tr>
						<tr class="tablerow1"><td>Repeat Email Address</td><td><input type="text" name="email_new_rep" maxlength="64"></td></tr>
						<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="newmail"><input type="submit" class="button" value="Update"></td></tr>
					<?php }
					else { ?>
						<tr class="tablerow1"><td width='50%'>Current Email Address</td><td><input type="text" name="email_cur"  value="<?php echo $inf['Email']; ?>" maxlength="64"></td></tr>
						<tr><td>New Email Address</td><td><input type="text" name="email_new" maxlength="64"></td></tr>
						<tr class="tablerow1"><td>Repeat Email Address</td><td><input type="text" name="email_new_rep" maxlength="64"></td></tr>
						<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="updatemail"><input type="submit" class="button" value="Update"></td></tr>
					<?php } ?>
				</form>
			</table>
				<?php } ?>
				</div>
				<div class='acp-box'>
					<h3>Email Opt-Out</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<form action="index/proc.php" method="POST">
						<tr class="tablerow1"><td width='50%'><label for="optout">Would you like to opt out from periodic announcements sent via email?</label></td><td width='50%'><input type="checkbox" name="optout" id="optout" value="1" <?php if($inf['EmailOptOut'] == 1) echo 'checked="checked"' ?>></td></tr>
						<tr><td colspan="2" style="font-style:italic">Emergency announcements may be chosen to bypass this option. This is for security purposes.</td></tr>
						<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
						<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
						<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="email_optout"><input type="submit" class="button" value="Update"></td></tr>
					</form>
					</table>
				</div>
				<div class='acp-box'>
				<?php $seccheckquery = mysqli_query($mysqli,"SELECT NULL FROM `sec_questions` WHERE `userid` = $inf[id]");
				$seccheck = mysqli_num_rows($seccheckquery); ?>
				<h3><?php if($seccheck == 0) { echo "Add Security Question"; } else { echo "Update Security Question"; } ?></h3>
				<?php if(isset($_GET['n']) && $_GET['n'] == 1) { echo "<div class='acp-error'>Your current answer is incorrect!</div>"; }
				if(isset($_GET['n']) && $_GET['n'] == 2) { echo "<div class='acp-message'>A confirmation message has been sent to your email address.</div>"; } ?>
				<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<form action="index/proc.php" method="POST">
						<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
						<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
						<?php if($seccheck == 0) { ?>
							<tr><td width='50%'>New Security Question</td><td><input type="text" name="question" maxlength="64"></td></tr>
							<tr class="tablerow1"><td width='50%'>Answer</td><td><input type="text" name="answer" maxlength="64"></td></tr>
							<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="secquestion"><input type="submit" class="button" value="Update"></td></tr>
						<?php }
						else { ?>
							<tr class="tablerow1"><td>Current Security Answer</td><td><input type="text" name="curanswer" maxlength="64"></td></tr>
							<tr><td>New Security Question</td><td><input type="text" name="question" maxlength="64"></td></tr>
							<tr class="tablerow1"><td>New Security Answer</td><td><input type="text" name="answer" maxlength="64"></td></tr>
							<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="secquestion"><input type="submit" class="button" value="Update"></td></tr>
						<?php } ?>
					</form>
				</table>
				</div>
				<?php if($inf['AdminLevel'] >= 2 || $inf['Helper'] >= 2) { ?>
				<div class='acp-box'>
					<h3>Update Timezone</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<form action="index/proc.php" method="POST">
						<tr class="tablerow1"><td width='50%'><label for="tz">Timezone</label></td><td width='50%'>
							<?php if ($minfo['timezone'] == '') {
								echo "<select title='Please select your timezone' name='timezone' id='tz'>";
							} else {
								echo "<select name='timezone' id='tz'>";
							}
							$list = DateTimeZone::listAbbreviations();
							$idents = DateTimeZone::listIdentifiers();

							$data = $offset = $added = array();
							foreach ($list as $abbr => $info)
							{
								foreach ($info as $zone)
								{
									if (!empty($zone['timezone_id']) AND !in_array($zone['timezone_id'], $added) AND in_array($zone['timezone_id'], $idents))
									{
										$z = new DateTimeZone($zone['timezone_id']);
										$c = new DateTime(null, $z);
										$zone['time'] = $c->format('g:i A');
										$data[] = $zone;
										$offset[] = $z->getOffset($c);
										$added[] = $zone['timezone_id'];
									}
								}
							}
							
							function formatOffset($offset)
							{
								$hours = $offset / 3600;
								$remainder = $offset % 3600;
								$sign = $hours > 0 ? '+' : '-';
								$hour = (int) abs($hours);
								$minutes = (int) abs($remainder / 60);

								if ($hour == 0 AND $minutes == 0) {
									$sign = ' ';
								}
								return 'GMT ' . $sign . $hour;
							}

							array_multisort($offset, SORT_ASC, $data);
							$options = array();
							foreach ($data as $key => $row)
							{
								$options[$row['timezone_id']] = $row['timezone_id'].' ('.formatOffset($row['offset']).') -- '. $row['time'];
								if($stat['timezone'] == $row['timezone_id'])
								{
									echo "<option style='background:#fffdbc' value='".$stat['timezone']."' selected='selected'>".$options[$row['timezone_id']]."</option>";
								}
								else
								{
									echo "<option value='".$row['timezone_id']."'>".$options[$row['timezone_id']]."</option>";
								}
							}
							?>
						</select></td></tr>
						<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
						<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
						<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="update_timezone"><input type="submit" class="button" value="Update"></td></tr>
					</form>
					</table>
				</div>
				<!--<div class='acp-box'>
					<h3>Update GTalk Address</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<form action="index/proc.php" method="POST">
						<tr class="tablerow1"><td width='50%'>GTalk Address</td><td width='50%'>
						<?php
							if ($minfo['gtalk'] == 'N/A') {
								echo "<input title='Please fill in your google talk email' type='text' name='gtalk' maxlength='64'>";
							} else {
								echo "<input type='text' name='gtalk' value=".$minfo['gtalk']." maxlength='64'>";
							}
						?></td></tr>
						<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
						<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
						<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="update_gtalk"><input type="submit" class="button" value="Update"></td></tr>
					</form>
					</table>
				</div>
				<div class='acp-box'>
				<?php } if ($inf['AdminLevel'] >= 2) {?>
					<h3>Update PayPal Address</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<form action="index/proc.php" method="POST">
						<tr class="tablerow1"><td width='50%'>PayPal Address</td><td width='50%'><input type="text" name="paypal" value="<?php echo $minfo['PayPal']; ?>" maxlength="64"></td></tr>
						<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
						<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
						<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="update_paypal"><input type="submit" class="button" value="Update"></td></tr>
					</form>
					</table>
				</div>-->
				<?php } ?>
			</div>