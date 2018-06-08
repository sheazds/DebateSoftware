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
			<?php require 'results/getresults.php'; ?>
			<div class="clear"></div>
			
			<div id="content" class="results">	</div>
		</div>
	</body>

</html>

