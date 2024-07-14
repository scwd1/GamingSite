<?php
if(isset($_POST['active']) && $_POST['active'] == "1") {
	$oldPassEnc = strtoupper(hash('whirlpool', $_POST['oPass']));
	if($oldPassEnc == $inf['Key']) {
		if($_POST['nPass'] == $_POST['rnPass'])
		{
			$newPass = strtoupper(hash('whirlpool', $_POST['nPass']));
			$admin = $inf['id'];
			$query1 = "UPDATE `accounts` SET `Key` = '$newPass' WHERE `id` = '$admin'";
			mysql_query($query1);
			
			$section = "General";
			$area = "Password Change";
			$details = "Modified their password";
			doLog($inf['id'], $section, $area, $details);
			
			echo "Password change complete";
		}
		else { echo "The new passwords did not match"; }
	}
	else { echo "The password you entered was incorrect."; 
	
		$section = "General";
		$area = "Password Change";
		$details = "Password change attempt failed";
		doLog($inf['id'], $section, $area, $details);
	}
}
?>

			<div id='content_wrap'>
				<ol id='breadcrumb'><li><?php echo $section; ?> > Change Password</li></ol>
				<div class='section_title'><h2>My Password</h2></div>
			<div class='acp-box'>
				<h3>Change Password</h3>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
				<form action="index.php?p=editpass" method="POST">
						<tr class="tablerow1"><td>Current Password</td><td><input type="password" name="oPass" maxlength="64"></td></tr>
						<tr><td>New Password</td><td><input type="password" name="nPass" maxlength="64"></td></tr>
						<tr class="tablerow1"><td>Repeat New Password</td><td><input type="password" name="rnPass" maxlength="64"></td></tr>
						<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="active" value="1"><input type="submit" class="button" value="Submit"></td></tr>
				</form>
			</table>
			</div></div>