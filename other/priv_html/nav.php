<ul id='section_buttons'>
	<?php if($_SERVER["SCRIPT_NAME"] == "/index.php") { ?><li class='active'><?php } else { ?><li><?php } ?><a href='index.php?p=dashboard'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>:8000/global/images/all/applications/portal.png' alt='' /> Main</a></li>

	<?php if($inf["Member"] != -1) {
		if($_SERVER["SCRIPT_NAME"] == "/faction.php") { ?><li class='active'><?php } else { ?><li><?php } ?><a href='faction.php?p=roster'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>:8000/global/images/all/applications/members.png' alt='' /> Faction</a></li>
	<?php } ?>

	<?php if($inf["FMember"] != 255) {
		if($_SERVER["SCRIPT_NAME"] == "/gang.php") { ?><li class='active'><?php } else { ?><li><?php } ?><a href='gang.php?p=roster'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>:8000/global/images/all/applications/members.png' alt='' /> Gang</a></li>
	<?php } ?>
	
	<?php if($inf["Business"] != -1) {
		if($_SERVER["SCRIPT_NAME"] == "/business.php") { ?><li class='active'><?php } else { ?><li><?php } ?><a href='business.php?p=info'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>:8000/global/images/all/applications/subscriptions.png' alt='' /> Business</a></li>
	<?php } ?>
	<li><a href='#' target='_blank'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>:8000/global/images/all/applications/help.png' alt='' /> Armory</a></li>
</ul>