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
?>
<html>
<head>
	<link rel="stylesheet" href="../style.css" type="text/css" />
	<script language="javascript">
		function print_doc() {
			window.open('pairings_judges_print_short.php?round_id=<?php echo $round_id; ?>', 'print', 'width=500,height=400,scrollbars=yes,resizable=no,toolbar=no');
		}
	</script>

</head>
<body>
	<?php require 'nav.php';?>
	<div id = "main">
	<div id ="content">
		<form>
			<div class="toolbar">
				<span class="toolbar">
					<select name="round" onchange="window.location='pairings_judges.php?round_id='+this.value">
					<?php
						$rounds = $round_obj->get_rounds($db_obj);
						foreach ($rounds as $curr_round) {
							if ($round_id == $curr_round['round_id']) {
								print("<option selected=\"yes\" value=\"" . $curr_round['round_id'] . "\">" . $curr_round['round_name'] . "</option>");
							} else {
								print("<option value=\"" . $curr_round['round_id'] . "\">" . $curr_round['round_name'] . "</option>");
							}
						}
					?>
					</select>
				</span>
				<a class="toolbar" href="pairings_judges_generate.php?round_id=<?php echo $round['round_id']; ?>">
					Generate Pairings
				</a>
				<a class="toolbar" href="pairings.php?round_id=<?php echo $round_id; ?>">
					Pairings
				</a>
				
			</div>
		</form>
		
		<h2><?php echo $round['round_name']; ?> Judge Pairings</h2>
		
		<table class="reglist">
			<tr>
				<th>Government</th>
				<th>Opposition</th>
				<th style="text-align: center; width: 100px">Room</th>
				<form>
					<th style="width: 210px; text-align: right;"><input type="button" value="Clear Round" onclick="window.location='pairings_judges_clear.php?round_id=<?php echo $round_id; ?>'" /></th>
				</form>
			</tr>
			<?php
				$available_judges = $match_obj->get_available_judges($db_obj, $round_id);

				$team_ranks = $result_obj->get_team_ranks($db_obj, $round_id, false); 
				$round_num = $round_obj->get_round_num($db_obj, $round_id);

				$matches = $match_obj->get_matches($db_obj, $round_id);
				foreach($matches as $match) {
					$gov_team = $team_obj->get_team($db_obj, $match['match_gov_team_id']);
					$opp_team = $team_obj->get_team($db_obj, $match['match_opp_team_id']);
					$room = $room_obj->get_room($db_obj, $match['room_id']);
					
					$gov_points = $result_obj->get_points($db_obj, $round_id, $gov_team['team_id'], false);
					$opp_points = $result_obj->get_points($db_obj, $round_id, $opp_team['team_id'], false);
					
					$bracket_wins = $gov_points;
					if ($opp_points > $gov_points) {
						$bracket_wins = $opp_points;
					}
					$bracket_losses = ($round_num-1) - $bracket_wins;
			?>
					<tr>
						<td style="font-size: 12pt;">
							<?php
								if ($gov_team['team_id'] == 0) {
									print("(No Team)");
								} else {
									for($i=1; $i<=count($team_ranks); $i++) {
										if ($team_ranks[$i-1]['team_id'] == $gov_team['team_id']) {
											print("($i)");
										}
									}
									
							?>
									<?php echo $gov_team['team_name']; ?>
							<?php
									if ($match['pullup_team_id'] == $gov_team['team_id']) {
										print("<span class=\"flag\">Pull</span>");
									}
								}
							?>
						</td>
						<td style="font-size: 12pt;">
							<?php
								if ($opp_team['team_id'] == 0) {
									print("(No Team)");
								} else {
									for($i=1; $i<=count($team_ranks); $i++) {
										if ($team_ranks[$i-1]['team_id'] == $opp_team['team_id']) {
											print("($i)");
										}
									}
							?>
									<?php echo $opp_team['team_name']; ?>
							<?php
									if ($match['pullup_team_id'] == $opp_team['team_id']) {
										print("<span class=\"flag\">Pull</span>");
									}
								}
							?>
						</td>
						<td style="background: #FFFFCC; text-align: center">
							<?php 
								if (intval($room['room_id']) != 0) { 
									print($room['room_name'] . "<br />");
								}
							?>
							<?php echo intval($bracket_wins) . "-" . intval($bracket_losses); ?>
						</td>
						<td style="width: 350px; text-align: left; padding: 0px">
							<iframe id="judge_list_<?php echo $match['match_id']; ?>" src="pairings_judges_module.php?round_id=<?php echo $round_id; ?>&match_id=<?php echo $match['match_id']; ?>" width="350" height="90" frameborder="0" marginwidth="0" marginheight="0"></iframe>
						</td>
					</tr>
			<?php
				}
			?>
		</table>
	</div>
</body>
</html>