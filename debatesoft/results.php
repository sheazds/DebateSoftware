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
			
			<div id="content" class="results">
				<?php require 'results/showresults.php'; ?>
				<div class='clear'></div>
			</div>
			<div class='clear'></div>
		</div>
	</body>

</html>

