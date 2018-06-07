<html>
	<head>
		<title>DebateSoft</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	</head>
	
	<body>
		<?php require 'nav.php'; ?>
		<script>$("#navigation").find("#results").addClass("activenav");</script>
		<div id="main">
			<script src="scripts/buttonbar.js"></script>
			<div id="buttonbar">
				<a class="button" href="#" id="round1">Round 1</a>
				<a class="button" href="#" id="round2">Round 2</a>
				<a class="button" href="#" id="round3">Round 3</a>
				<a class="button" href="#" id="brackets">View as Bracket</a>
			</div>
			<div class="clear"></div>
			
			<div id="content" class="results">	</div>
		</div>
	</body>

</html>

