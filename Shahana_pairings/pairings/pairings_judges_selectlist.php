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

?>
<html>
<head>
	<link rel="stylesheet" href="../style.css" type="text/css" />
	<title>Available Judges</title>
	<style type="text/css">
		a.selectlist {
			display: block;
			padding: 3px;
			background: #FFFFFF;
			text-decoration: none;
		}
		a.selectlist:hover {
			background: #CCCCFF;
		}
		
	</style>
</head>
<body style="background: #CCCCCC">
<?php
	require_once("../lib/inc.config.php");
	require_once("../lib/inc.match.php");
	require_once("../lib/inc.team.php");
	require_once("../lib/inc.judge.php");
	require_once("../lib/inc.result.php");

	$db_obj = new Database;
	$match_obj = new Match;
	$team_obj = new Team;
	$judge_obj = new Judge;
	$result_obj = new Result;
	
	$match_id = $_GET['match_id'];
	$round_id = $_GET['round_id'];
	$available_judges = $match_obj->get_available_judges($db_obj, $round_id);

	$match = $match_obj->get_match($db_obj, $match_id);
	$gov_team = $team_obj->get_team($db_obj, $match['match_gov_team_id']);
	$opp_team = $team_obj->get_team($db_obj, $match['match_opp_team_id']);

	
?>
	<?php
		foreach($available_judges as $judge) {
			if ((isset($gov_team['team_id']) && $judge_obj->has_conflict($db_obj, $judge['judge_id'], $gov_team['team_id'], $round_id)) ||
				(isset($opp_team['team_id']) && $judge_obj->has_conflict($db_obj, $judge['judge_id'], $opp_team['team_id'], $round_id))) {
				
				
				$conflictlist = "";
				if(($judge_obj->has_school_conflict($db_obj, $judge['judge_id'], $gov_team['team_id'], $round_id) == true) OR (($judge_obj->has_scratch_conflict($db_obj, $judge['judge_id'], $opp_team['team_id'], $round_id) == true))){
				$conflictlist = $conflictlist . "school ";
				}
				
				if(($judge_obj->has_scratch_conflict($db_obj, $judge['judge_id'], $gov_team['team_id'], $round_id) == true) OR (($judge_obj->has_scratch_conflict($db_obj, $judge['judge_id'], $opp_team['team_id'], $round_id) == true))){
				    $conflictlist = $conflictlist . "scratch ";
				}
				
				$numpairgov = $judge_obj->num_previously_paired($db_obj, $judge['judge_id'], $gov_team['team_id'], $round_id);
				$numpairopp = $judge_obj->num_previously_paired($db_obj, $judge['judge_id'], $opp_team['team_id'], $round_id);
				
				if($numpairgov > 0 && $numpairgov >= $numpairopp){
				   $conflictlist = $conflictlist . $numpairgov . " ";
				} else if ($numpairopp > 0){
				   $conflictlist = $conflictlist . $numpairopp . " ";
				}
				
				print("<a class=\"selectlist\" style=\"font-weight: bold; color: #CC0000\" href=\"javascript:this.window.opener.window.location='pairings_judges_module_add.php?round_id=$round_id&match_id=$match_id&judge_id=" . $judge['judge_id'] . "';this.window.close()\">". $judge['judge_first_name'] . " " . $judge['judge_last_name'] . ' <span style="color: grey; font-size: 10pt;">' .$conflictlist . "</span></a>");
			} else {
				print("<a class=\"selectlist\" style=\"font-weight: normal; color: #000000\" href=\"javascript:this.window.opener.window.location='pairings_judges_module_add.php?round_id=$round_id&match_id=$match_id&judge_id=" . $judge['judge_id'] . "';this.window.close()\">". $judge['judge_first_name'] . " " . $judge['judge_last_name'] . "</a>");
			}
		}
	?>
</body>
</html>