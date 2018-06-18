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

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	require_once("../lib/inc.config.php");
	require_once("../lib/inc.round.php");
	require_once("../lib/inc.pairing.php");
	require_once("../lib/inc.match.php");
	require_once("../lib/inc.team.php");
	require_once("../lib/inc.room.php");
	require_once("../lib/inc.school.php");
	require_once("../lib/inc.result.php");
	require_once("../lib/inc.pairing.cp.php");
	require_once("../scripts/pairings.php");
	

	$db_obj = new Database;
	$round_obj = new Round;
	$room_obj = new Room;
	$match_obj = new Match;
	$pairing_obj = new Pairing;
	$cp_pairing = new CP_Pairing;

	$team_obj = new Team;
	$school_obj = new School;
	$room_obj = new Room;


	$round_id = "";

	if (isset($_POST['get_round_id'])) {
		$round_id = $_POST['get_round_id'];
	}

	if (isset($_POST['cmd'])) {
		if ($_POST['cmd'] == "generate") {
			$round_id = $_POST['round_id'];
			$teams = array();
			$rooms = array();
			
			if (isset($_POST['teams'])) {
				$teams = $_POST['teams'];

				if (isset($_POST['rooms'])) {
					$rooms = $_POST['rooms'];
				}
	
				$match_obj->delete_matches($db_obj, $round_id);
			
				$matches = $cp_pairing->pair_round($db_obj, $round_id, true, $teams, $rooms);
				$match_priority = 1;
				foreach($matches as $match) {
					$room_id = "";
					if (isset($match['room_id'])) {
						$room_id = $match['room_id'];
					}
					
					$pullup_team_id = "";
					if (isset($match['gov']['is_pullup']) && $match['gov']['is_pullup'] === true) {
						$pullup_team_id = $match['gov']['team_id'];
					} elseif (isset($match['opp']['is_pullup']) && $match['opp']['is_pullup'] === true) {
						$pullup_team_id = $match['opp']['team_id'];
					}
					
					$match_obj->add_match($db_obj, $round_id, $match['gov']['team_id'], $match['opp']['team_id'], $room_id, $pullup_team_id, $match_priority);
					$match_priority++;
				}
			}
			echo "<script>view_pairings(".$round_id.")</script>";
			//header("Location: ../tournaments.php#pairings?round_id=" . $round_id);
			exit();
		}
	}
	$round = $round_obj->get_round($db_obj, $round_id);
?>
<h2>Generate Matches - <?php echo $round['round_name']; ?></h2>

<p class="error">
	Note: THIS WILL DELETE ALL PREVIOUSLY ENTERED MATCHES, BALLOTS AND RESULTS ASSOCIATED WITH THIS ROUND.
</p>
		
<form id="generate_form">
	
	<script language="javascript">
		function toggleteams() {
			if (document.getElementById("toggle_teams").checked == true) {
				var teams = document.getElementsByName("teams[]");
				for (i=0; i<teams.length; i++) {
					teams[i].checked = true;
				}
			}
			if (document.getElementById("toggle_teams").checked == false) {
				var teams = document.getElementsByName("teams[]");
				for (i=0; i<teams.length; i++) {
					teams[i].checked = false;
				}
			}
		}
		
		function togglerooms() {
			if (document.getElementById("toggle_rooms").checked == true) {
				var rooms = document.getElementsByName("rooms[]");
				for (i=0; i<rooms.length; i++) {
					rooms[i].checked = true;
				}
			}
			if (document.getElementById("toggle_rooms").checked == false) {
				var rooms = document.getElementsByName("rooms[]");
				for (i=0; i<rooms.length; i++) {
					rooms[i].checked = false;
				}
			}
		}
	</script>
	<p>
		<div style="width: 300px; float: left">
			<table class="selectlist">
				<tr>
					<td class="checkbox" colspan="3">
						<input form="generate_form" id="toggle_teams" type="checkbox" onclick="toggleteams()" />
						<strong>Teams to Pair</strong>
					</td>
				</tr>
			<?php
				$teams = $team_obj->get_teams($db_obj);
				$previous_teams = $match_obj->get_team_ids_from_last_round($db_obj, $round_id);
				
				$i=0;
				$rowclass = "row_a";
				foreach ($teams as $team) {
					if (($i % 2) == 0) {
						$rowclass = "row_a";
					} else {
						$rowclass = "row_b";
					}
					
			?>
					<tr>
						<td class="checkbox"><input form="generate_form" type="checkbox" <?php echo (array_search($team['team_id'], $previous_teams) !== false) ? "checked" : "" ; ?> name="teams[]" value="<?php echo $team['team_id']; ?>" /></td>
						<td class="<?php echo $rowclass; ?>"><?php echo $team['team_name']; ?></td>
						<td class="<?php echo $rowclass; ?>"><?php echo $school_obj->get_school_name($db_obj, $team['school_id']); ?></td>
					</tr>
			<?php
					$i++;
				}
			?>
			</table>
		</div>
		
		<div style="width: 100px; margin-left: 10px; float: left">
			<table class="selectlist">
				<tr>
					<td class="checkbox" colspan="2">
						<input form="generate_form" id="toggle_rooms" type="checkbox" onclick="togglerooms()"  />
						<strong>Rooms</strong>
					</td>
				</tr>
			<?php
				$rooms = $room_obj->get_rooms($db_obj);
				$previous_rooms = $match_obj->get_room_ids_from_last_round($db_obj, $round_id);

				$i=0;
				$rowclass = "row_a";
				foreach ($rooms as $room) {
					if (($i % 2) == 0) {
						$rowclass = "row_a";
					} else {
						$rowclass = "row_b";
					}								
			?>
					<tr>
						<td class="checkbox"><input form="generate_form" type="checkbox" <?php echo (array_search($room['room_id'], $previous_rooms) !== false) ? "checked" : "" ; ?> name="rooms[]" value="<?php echo $room['room_id']; ?>" /></td>
						<td class="<?php echo $rowclass; ?>"><?php echo $room['room_name']; ?></td>
					</tr>
			<?php
					$i++;
				}
			?>
			</table>
		</div>
	</p>
	
	<p style="clear: both">
		<input form="generate_form" type="hidden" name="round_id" value="<?php echo $round['round_id']; ?>" />
		<input form="generate_form" type="hidden" name="cmd" value="generate" />
		<br />
		<input form="generate_form" type="button" value="Generate Pairings" onclick="generate($('#generate_form').serializeArray())"/>
		<input onclick="view_pairings(<?php $round['round_id'];?>)" type="button" value="Cancel" />
	</p>
</form>