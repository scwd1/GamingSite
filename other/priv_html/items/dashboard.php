<?php mInfo($inf['id'],$mysqli); ?>
<div id='content_wrap'>
  <ol id='breadcrumb'>
    <li><?php echo $section; ?> &raquo; My Dashboard</li>
  </ol>
  <div class='section_title'>
    <h2>My Dashboard</h2>
  </div>
  <div class='acp-box'>
    <h3>My Stats</h3>
    <table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
	  <tr class='tablerow1'>
        <td>Level: <?php echo $inf['Level']; ?></td>
        <td>Playing Hours: <?php echo $inf['ConnectedTime']; ?></td>
		<td>Age: <?php echo $inf['Age']; ?></td>
		<?php if($inf['Sex'] == 1) { $gender = "Male"; } if($inf['Sex'] == 2) { $gender = "Female"; } ?>
		<td>Gender: <?php echo $gender; ?></td>
      </tr>
	  <tr>
        <td>Total Wealth: <?php echo "$".CalculateTotalWealth($inf['id'], $mysqli); ?></td>
        <td>Money (On-Hand): <?php echo "$".number_format($inf['Money']); ?></td>
        <td>Money (Bank): <?php echo "$".number_format($inf['Bank']); ?></td>
        <td>Materials: <?php echo number_format($inf['Materials']); ?></td>
      </tr>
	  <tr class='tablerow1'>
        <td>Crack: <?php echo number_format($inf['Crack']); ?></td>
        <td>Pot: <?php echo number_format($inf['Pot']); ?></td>
        <td>Phone Number: <?php echo $inf['PhoneNr']; ?></td>
        <td>Radio Frequency: <?php echo $inf['RadioFreq']; ?></td>
      </tr>
	  <tr>
        <td>VIP Rank: <?php echo VIPrank($inf['DonateRank']); ?></td>
        <td>Crimes: <?php echo number_format($inf['Crimes']); ?></td>
        <td>Arrests: <?php echo number_format($inf['Arrested']); ?></td>
        <td>Weapon Restriction: <?php if($inf['WRestricted'] > 0) { echo $inf['WRestricted']." hour(s)"; } else { echo "None"; } ?></td>
      </tr>
	  <tr class='tablerow1'>
        <td>Warnings: <?php echo $inf['Warnings']; ?></td>
        <td>Newbie Mutes: <?php echo $inf['NewMutedTotal']; ?></td>
        <td>Advertisement Mutes: <?php echo $inf['AdMutedTotal']; ?></td>
        <td>Report Mutes: <?php echo $inf['ReportMutedTotal']; ?></td>
      </tr>
      <tr>
        <td>Date Registered: <?php echo date("M j, o", strtotime("$inf[RegiDate]")); ?></td>
        <td>Last Active: <?php echo date("M j, o", strtotime("$inf[UpdateDate]")); ?></td>
        <td>Last Logged IP: <?php echo $inf['IP']; ?></td>
        <td>Your IP Address: <?php echo $_SERVER['REMOTE_ADDR']; ?></td>
      </tr>
    </table>
</div></div>