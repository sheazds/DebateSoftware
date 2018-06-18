<?php
	if (file_exists ('dbconfig.php'))
		require_once 'dbconfig.php';
	else
		require_once '../dbconfig.php';
	
	if (isset($_POST['form']) && $_POST['form'] == "orgstruc")
		mysqli_query($conn,"UPDATE ballot_speaker_scores SET `organization/structure`='".$_POST['value']."' WHERE ballot_id='".$_POST['id']."'");
	if (isset($_POST['form']) && $_POST['form'] == "evidana")
		mysqli_query($conn,"UPDATE ballot_speaker_scores SET `evidence/analysis`='".$_POST['value']."' WHERE ballot_id='".$_POST['id']."'");
	if (isset($_POST['form']) && $_POST['form'] == "rebcla")
		mysqli_query($conn,"UPDATE ballot_speaker_scores SET `rebuttal/clash`='".$_POST['value']."' WHERE ballot_id='".$_POST['id']."'");
	if (isset($_POST['form']) && $_POST['form'] == "deleti")
		mysqli_query($conn,"UPDATE ballot_speaker_scores SET `delivery/etiquette`='".$_POST['value']."' WHERE ballot_id='".$_POST['id']."'");
	if (isset($_POST['form']) && $_POST['form'] == "questres")
		mysqli_query($conn,"UPDATE ballot_speaker_scores SET `questioning/responding`='".$_POST['value']."' WHERE ballot_id='".$_POST['id']."'");
	if (isset($_POST['form']) && $_POST['form'] == "comments")
		mysqli_query($conn,"UPDATE ballot_speaker_scores SET `comments`='".$_POST['value']."' WHERE ballot_id='".$_POST['id']."'");
?>