<?php
	//////////////////////////////////////////////////////////////////////////////////
	// ChuTabs
	// Copyright (C) 2006  Wayne Chu
	// 
	// This program is free software; you can redistribute it and/or
	// modify it under the terms of the GNU General Public License
	// as published by the Free Software Foundation; either version 2
	// of the License, or (at your option) any later version.
	// 	
	// This program is distributed in the hope that it will be useful,
	// but WITHOUT ANY WARRANTY; without even the implied warranty of
	// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	// GNU General Public License for more details.
	// 	
	// You should have received a copy of the GNU General Public License
	// along with this program; if not, write to the Free Software
	// Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
	//
	// Questions or comments may be forwarded to chu.wayne@gmail.com
	//////////////////////////////////////////////////////////////////////////////////

	session_start();
	
	require_once("../lib/inc.config.php");
	require_once("../lib/inc.round.php");
	require_once("../lib/inc.pairing.php");
	require_once("../lib/inc.match.php");
	require_once("../lib/inc.team.php");
	require_once("../lib/inc.judge.php");
	require_once("../lib/inc.room.php");
	require_once("../lib/inc.result.php");

	$db_obj = new Database;
	$round_obj = new Round;
	$pairing_obj = new Pairing;
	$match_obj = new Match;
	$team_obj = new Team;
	$judge_obj = new Judge;
	$room_obj = new Room;
	$result_obj = new Result;
	
	$round_id = "";
	if (isset($_GET['round_id'])) {
		$round_id = $_GET['round_id'];
	} else {
		if (isset($_SESSION['last_viewed_round'])) {
			$round_id = $_SESSION['last_viewed_round'];
		} else {
			$rounds = $round_obj->get_rounds($db_obj);
			foreach ($rounds as $round) {
				$round_id = $round['round_id'];
			}
		}
	}
	
	$_SESSION['last_viewed_round'] = $round_id;

	

	if ($round_id == "") {
		?>
		<html>
		<head>
			<link rel="stylesheet" href="../style.css" type="text/css" />
		</head>
		<body>
			<div class="pageheader">Pairing :: Round Pairings</div>
			<div class="body">
				No rounds available.
			</div>
		</body>
		<?php
		exit();
	}

	$round = $round_obj->get_round($db_obj, $round_id);

	
	$num_judges = count($match_obj->get_available_judges($db_obj, $round_id));	
	
	if($unjudged_matches = $match_obj->get_unjudged_rooms($db_obj, $round_id)){
				
	foreach($unjudged_matches as $unjudged_match){
		$match_obj->add_best_judge($db_obj, $unjudged_match[0]);
	}
	
	}	

	
?>
<meta http-equiv="refresh" content="0; url=pairings_judges.php?round_id=<?php echo $round_id; ?>" />

