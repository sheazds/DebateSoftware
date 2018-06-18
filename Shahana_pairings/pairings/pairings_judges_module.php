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

	require_once("../lib/inc.config.php");
	require_once("../lib/inc.match.php");
	require_once("../lib/inc.team.php");
	require_once("../lib/inc.judge.php");
	require_once("../lib/inc.school.php");

	$db_obj = new Database;
	$match_obj = new Match;
	$team_obj = new Team;
	$judge_obj = new Judge;
	$school_obj = new School;
	
	$match_id = $_GET['match_id'];
	$round_id = $_GET['round_id'];
	$available_judges = $match_obj->get_available_judges($db_obj, $round_id);

	$match = $match_obj->get_match($db_obj, $match_id);
	$gov_team = $team_obj->get_team($db_obj, $match['match_gov_team_id']);
	$opp_team = $team_obj->get_team($db_obj, $match['match_opp_team_id']);

?>
<html>
<head>
	<link rel="stylesheet" href="../style.css" type="text/css" />

	<script language="javascript">
		function add_judge(event) {
			var top = (screen.height / 2) - 150;
			var left = (screen.width / 2) + 100;
			window.open('pairings_judges_selectlist.php?round_id=<?php echo $round_id; ?>&match_id=<?php echo $match['pairing_id']; ?>', 'judgeselect', 'top='+ top + ',left=' + left + ',width=190,height=300,modal=yes,scrollbars=yes,modal=yes,resizable=no,toolbar=no');
		}
		
	</script>
</head>
<body style="background: #FFFFFF">
<table style="border-collapse: collapse; width: 100%; font-size: 10pt; ">
	<tr>
		<td colspan="4" style="text-align: center; padding: 2px; background: #DDDDDD;">
			<a style="font-weight: bold; color: #FF0000; text-decoration: none" href="javascript:void(null)" onclick="add_judge(event)">Add Judge</a>
		</td>
	</tr>
<?php
	if ($judges = $judge_obj->get_match_judges($db_obj, $match_id)) {
		foreach($judges as $judge) {
			$school = $school_obj->get_school($db_obj, $judge['school_id']);
		?>
		<tr>
			<td style="padding: 2px; background: #FFFFFF; text-align: center; width: 20px; border-width: 1px 1px 1px 0px; border-style: solid; border-color: #CCCCCC">
				
			</td>
			<td style="padding: 2px; background: #FFFFFF; border-width: 1px 0px 1px 0px; border-style: solid; border-color: #CCCCCC">
			<?php
				if ((isset($gov_team['team_id']) && $judge_obj->has_conflict($db_obj, $judge['judge_id'], $gov_team['team_id'], $round_id)) ||
					(isset($opp_team['team_id']) && $judge_obj->has_conflict($db_obj, $judge['judge_id'], $opp_team['team_id'], $round_id))) {
					?>
						<span style="color: #CC0000; font-weight: bold"><?php echo $judge['judge_first_name'], " ", $judge['judge_last_name']; ?></span>
					<?php
				} else {
					echo $judge['judge_first_name']," ", $judge['judge_last_name'];
				}
				
				$conflicts = array();
				if ((isset($gov_team['team_id']) && $judge_obj->has_school_conflict($db_obj, $judge['judge_id'], $gov_team['team_id'], $round_id)) ||
					(isset($opp_team['team_id']) && $judge_obj->has_school_conflict($db_obj, $judge['judge_id'], $opp_team['team_id'], $round_id))) {
					$conflicts[] = "school";
				}

				if ((isset($gov_team['team_id']) && $judge_obj->has_scratch_conflict($db_obj, $judge['judge_id'], $gov_team['team_id'], $round_id)) ||
					(isset($opp_team['team_id']) && $judge_obj->has_scratch_conflict($db_obj, $judge['judge_id'], $opp_team['team_id'], $round_id))) {
					$conflicts[] = "scratch";
				}

				if ((isset($gov_team['team_id']) && $judge_obj->has_previously_paired_conflict($db_obj, $judge['judge_id'], $gov_team['team_id'], $round_id)) ||
					(isset($opp_team['team_id']) && $judge_obj->has_previously_paired_conflict($db_obj, $judge['judge_id'], $opp_team['team_id'], $round_id))) {
					$conflicts[] = "prev";
				}
				print("<span style=\"color: #666666; font-weight: normal; font-size: 8pt\">" . implode(" / ", $conflicts) . "</span>")

			?>
			</td>
			<td style="width: 75px; font-size: 8pt; padding: 2px; background: #FFFFFF; border-width: 1px 1px 1px 0px; border-style: solid; border-color: #CCCCCC">
				<?php echo $school['school_name']; ?>
			</td>
			<td style="background: #FFFFFF; text-align: center; padding: 2px; width: 20px; border-width: 1px 0px 1px 0px; border-style: solid; border-color: #CCCCCC">
				<a style="text-decoration: none; font-weight: bold; color: #FF0000" href="pairings_judges_module_remove.php?round_id=<?php echo $round_id; ?>&match_id=<?php echo $match_id; ?>&judge_id=<?php echo $judge['judge_id']; ?>">X</a>
			</td>
		</tr>
<?php								
		}
	}
?>
</table>
</body>
</html>