<html>
	<head>
		<title>DebateSoft</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	</head>
	
	<body>
		<?php require 'nav.php'; ?>
		<script>$("#navigation").find("#tournaments").addClass("activenav");</script>
		<div id="main">
			<script src="scripts/buttonbar.js"></script>
			<div id="buttonbar">
				<a class="button" href="#" id="view">View Tournament</a>
				<a class="button" href="#" id="conflicts">Set Judge Conflicts</a>
				<a class="button" href="#" id="preferences">Pairing Preferences</a>
			</div>
			<div class="clear"></div>
			
			<div id="content" class="tournaments">	</div>
		</div>
	</body>

</html>
