<html>
	<head>
		<title>canDebate</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	</head>
	
	<body>
		<?php require 'nav.php'; ?>
		<script>$("#navigation").find("#registration").addClass("activenav");</script>
		<div id="main">
			<div id="content" class="registration">
				<script src="scripts/registration.js"></script>

				<div class="reg_section closed" id="regions_section"><a href="#regions" id="regions">Regions</a><div class="section_content"></div></div>
				<div class="reg_section closed" id="schools_section"><a href="#schools" id="schools">Schools</a><div class="section_content"></div></div>
				<div class="reg_section closed" id="teams_section"><a href="#teams" id="teams">Teams</a><div class="section_content"></div></div>
                <div class="reg_section closed" id="speakers_section"><a href="#speakers" id="speakers">Speakers</a><div class="section_content"></divclass></div></div>
                <div class="reg_section closed" id="judges_section"><a href="#judges" id="judges">Judges</a><div class="section_content"></div></div>
				<div class="reg_section closed" id="rooms_section"><a href="#rooms" id="rooms">Rooms</a><div class="section_content"></div></div>
			</div>
		</div>
	</body>

</html>
