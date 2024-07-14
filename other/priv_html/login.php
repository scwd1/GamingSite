<?php
$redir = '<meta http-equiv="refresh" content="0;url=index.php?p=dashboard">';
session_start();
if(isset($_GET['rid']))
{
	$rid = $_GET['rid'];
}
if(isset($_SESSION['myusername']))
{
	$logged = 1;
	echo $redir;
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<title>CP Login</title> 
<link rel="shortcut icon" href="favicon.ico" /> 
 
	<style type='text/css' media='all'> 
		@import url( "global/css/acp.css" );
		@import url( "global/css/acp_content.css" );
	</style> 
 
	<!--[if IE]>
		<link href="global/css/acp_ie_tweaks.css" rel="stylesheet" type="text/css" />
	<![endif]--> 
    
</head> 

<body id='ipboard_body'> 
<div id='login'>
    <div id='login_controls'>
        <form name='login' method='POST' action='proc/loginProc.php'>
            <?php 
				if(isset($_GET['note']) && $_GET['note']== 1) { echo "<font color='#FF0000' size='2'><center>Your IP is not whitelisted for this account! <br><a href='wllogin.php'>Click Here</a> to submit a whitelist request.</center></font><br />"; }
				if(isset($_GET['note']) && $_GET['note']== 2) { echo "<font color='#FF0000' size='2'><center>Invalid login credentials!</center></font><br />"; }
				if(isset($_GET['note']) && $_GET['note']== 3) { echo "<font color='#FF0000' size='2'><center>Security answer incorrect!</center></font><br />"; }
				if(isset($_GET['note']) && $_GET['note']== 4) { echo "<font color='#00FF00' size='2'><center>Confirmation message sent to email!</center></font><br />"; }
			?>
                <label for='username'>Username</label>
                <input name='username' id="username" type="text" size="15">
			<br />
				<label for='password'>Password</label>
				<input name='password' id="password" type="password" size="15">
	</div>
	<?php if(isset($rid)) { echo "<input type='hidden' name='rid' readonly='readonly' value='$rid'>"; } ?>
	<div id='login_submit'><input type='submit' name='submit' class='realbutton' value='Login'></div>
		</form>
</div>
<div align='center' style='margin-left:150px;'><span id='login_pass'>
<a href="" onclick="javascript:window.open('http://cp.ng-gaming.net/loginhelp.php','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;">Need help logging in?</a> |
<a href='forgot_password.php' id='login_pass'>Forgot your password?</a>

</span></div>
<div id='copyright-login'><?php require('global/footer.php'); ?></div>
</body>
</html>