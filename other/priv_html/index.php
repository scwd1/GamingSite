<?php
require('global/func.php');
require('index/l_nav.php');
if (!isset($_GET['p'])){ print "<meta http-equiv=\"refresh\" content=\"0;url=index.php?p=dashboard\">"; }

if(isset($_GET['action'])&&$_GET['action'] == "logout") {
	$loutdir = '<meta http-equiv="refresh" content="0;url=/login.php">';
	session_destroy();
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <?php head($inf); ?>
    <script>
    function validate(form_id,email) {
     
       var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
       var address = document.forms[form_id].elements[email].value;
       if(reg.test(address) == false) {
     
          alert('Invalid Email Address');
          return false;
       }
    }
    </script>
</head>
<body>
<?php headbar($inf); ?>
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
		<?php SideNav($inf); ?>
    </div>
    <div class="col-sm-8 text-left"> 
      <div id='main_content'> 
      <br />
			<?php
			if ($_GET['p']=="dashboard") include('index/dashboard.php');
			if ($_GET['p']=="editpass") include('index/editpass.php');
			if ($_GET['p']=="settings") include('index/settings.php');
			if ($_GET['p']=="sig") include('index/sig.php');
			if ($_GET['p']=="referral") include('index/referral.php');
			if ($_GET['p']=="checkin") include('index/checkin.php');
			if ($_GET['p']=="leave") include('index/leave.php');
			if ($_GET['p']=="shift") include('index/shift.php');
			?>
		</div>
    </div>
    <div class="col-sm-2 sidenav">
      <div class="well">
        <p>ADS</p>
      </div>
      <div class="well">
        <p>ADS</p>
      </div>
    </div>
  </div>
</div>
<?php require('global/footer.php'); ?>
</body>
</html>
