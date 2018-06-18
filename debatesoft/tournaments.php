<html>
	<head>
		<title>canDebate</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	</head>
	
	<body>
		<?php require 'nav.php'; ?>
		<script>$("#navigation").find("#tournaments").addClass("activenav");</script>
		<div id="main">
			<script src="scripts/buttonbar.js"></script>
			<div id="buttonbar">
				<a class="button" href="#pairings" id="pairings">Tournament Pairings</a>
				<a class="button" href="#view" id="view">View Tournament</a>
				<a class="button" href="#conflicts" id="conflicts">Set Judge Conflicts</a>
				<a class="button" href="#preferences" id="preferences">Pairing Preferences</a>
			</div>
			<div class="clear"></div>
				
			<div id="content" class="tournaments">	</div>
		</div>
	</body>

</html>
