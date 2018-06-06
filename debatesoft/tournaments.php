<script>$("#content").attr("class", "tournament"); </script>

<script src="scripts/buttonbar.js"></script>
<div id="buttonbar">
	<a class="button" href="#" id="view">View Tournament</a>
	<a class="button" href="#" id="conflicts">Set Judge Conflicts</a>
	<a class="button" href="#" id="preferences">Pairing Preferences</a>
</div>
<div class="clear"></div>
<br />
<div id="tournaments_content">
	<?php include 'tournaments/brackets.php';?>
</div>