<?php
$section = 'Main';
function SideNav($inf) {
	print "<ul>";
	if($_GET['p'] == "dashboard") { print "<li class='active'>"; } else print "<li>";
		print "<a href='index.php?p=dashboard'>Dashboard</a></li>";
	//if($_GET['p'] == "referral") { print "<li class='active'>"; } else print "<li>";
	//	print "<a href='index.php?p=referral'>Referrals</a></li>";
	//if($_GET['p'] == "sig") { print "<li class='active'>"; } else print "<li>";
	//	print "<a href='index.php?p=sig'>Signatures</a></li>";
	if($_GET['p'] == "editpass") { print "<li class='active'>"; } else print "<li>";
		print "<a href='index.php?p=editpass'>Change Password</a></li>";
	if($_GET['p'] == "settings") { print "<li class='active'>"; } else print "<li>";
		print "<a href='index.php?p=settings'>Settings</a></li>";
	print "</ul>";
}

?>