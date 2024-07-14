<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<title>CMS Login</title> 
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
        <form name='login' method='POST' action='proc/wlloginProc.php'>
			
            <?php 
			if(isset($_GET['error']) && $_GET['error']== "1") { echo "<font color='#FF0000' size='2'><center>Invalid login credentials!</center></font><br />"; } else { echo "<font color='white' size='3'><center>Please reconfirm login to send a whitelist request:</br></br></center></font>";}
			?>
                <label for='username'>Username</label>
                <input name='username' id="username" type="text" size="15">
			<br />
				<label for='password'>Password</label>
				<input name='password' id="password" type="password" size="15">
	</div>
	<div id='login_submit'><input type='submit' name='submit' class='realbutton' value='Login'></div>
</form>
</div>
<div id='copyright-login'><?php require('global/footer.php'); ?></div>
</body>
</html>