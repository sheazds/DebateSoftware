<?php
	if (file_exists ('dbconfig.php'))
		require_once 'dbconfig.php';
	else
		require_once '../dbconfig.php';
	
	if (isset($_POST['form']) && $_POST['form'] == "orgstruc")
		mysqli_query($conn,"UPDATE ballot_speaker_scores SET `organization/structure`='".$_POST['value']."' WHERE ballot_id='".$_POST['id']."'");
?>