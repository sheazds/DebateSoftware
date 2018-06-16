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
	require_once("../lib/inc.room.php");
	require_once("../lib/inc.result.php");

	$db_obj = new Database;
	$round_obj = new Round;
	$pairing_obj = new Pairing;
	$match_obj = new Match;
	$team_obj = new Team;
	$room_obj = new Room;
	$result_obj = new Result;
	
	$round_id = "";
	if (isset($_GET['round_id'])) {
		$round_id = $_GET['round_id'];
	} else {
		if (isset($_SESSION['last_viewed_round']) && intval($_SESSION['last_viewed_round']) > 0) {
			$round_id = $_SESSION['last_viewed_round'];
		} else {
			$rounds = $round_obj->get_rounds($db_obj);
			foreach ($rounds as $round) {
				$round_id = $round['round_id'];
			}
		}
	}
	
	$_SESSION['last_viewed_round'] = $round_id;

	$round = $round_obj->get_round($db_obj, $round_id);
?>

<form>
	<div class="toolbar">
		<span class="toolbar">
			<select name="round" onchange="round_dropdown(this.value)">
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
		<?php
			if ($round_id != "") {
		?>
			<a class="button" href="#pairings_generate" onclick="<?php $_GET['round_id']=$round['round_id'];?>$('#content').load('tournaments/pairings_generate.php')">
				Generate Pairings
			</a>
			<a class="button" href="#pairings_judges" onclick="<?php $_GET['round_id']=$round['round_id'];?>$('#content').load('tournaments/pairings_judges.php')">
				Judge Pairings
			</a>
			
		<?php
			}
		?>
	</div>
</form>
		
<?php
	if ($round_id != "") {
?>
	<h2><?php echo $round['round_name']; ?></h2>
	
	<table class="reglist">
		<tr>
			<th>Government</th>
			<th>Opposition</th>
			<th style="width: 65px; text-align: center">Bracket</th>
			<th style="width: 100px">Room</th>
			<th style="width: 75px">Priority</th>
			<form>
				<th style="text-align: right" colspan="2"><input type="button" value="Clear Round" onclick="<?php $_GET['round_id']=$round['round_id'];?>$('#content').load('tournaments/pairings_clear.php')" /></th>
			</form>
		</tr>
		<?php
			$highest_priority = 0;

			$team_ranks = $result_obj->get_team_ranks($db_obj, $round_id, false); 
			$round_num = $round_obj->get_round_num($db_obj, $round_id);

			$matches = $match_obj->get_matches($db_obj, $round_id);
			$i=1;
			foreach($matches as $match)
			{
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

				if (intval($match['priority']) > $highest_priority) {
					$highest_priority = intval($match['priority']);
				}
		?>
				<!--<form method="post" action="pairings_edit.php">-->
				<form id="edit_pairing_form_<?php echo $i;?>">
					<tr>
						<td>
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
						<td>
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
						<td style="width: 50px; text-align: center">
							<?php echo intval($bracket_wins) . "-" . intval($bracket_losses); ?>
						</td>
						<td>
							<select form= "edit_pairing_form_<?php echo $i;?>" name="room_id">
								<?php 
									if (intval($room['room_id']) != 0) { 
								?>
										<option value="<?php echo $room['room_id']; ?>"><?php echo $room['room_name']; ?></option>
								<?php
									}
								?>
								<option value="">&nbsp;&nbsp;--</option>
								<?php
									$available_rooms = $match_obj->get_available_rooms($db_obj, $round_id);
									foreach($available_rooms as $room) {
										print("<option value=\"" . $room['room_id'] . "\">" . $room['room_name'] . "</option>");
									}
								?>
							</select>
						</td>
						<td>
							<input form="edit_pairing_form_<?php echo $i;?>" type="text" style="width: 50px" name="match_priority" value="<?php echo intval($match['priority']); ?>" />
						</td>
						<td class="command">
							<input form="edit_pairing_form_<?php echo $i;?>" type="hidden" name="round_id" value="<?php echo $round_id; ?>" />
							<input form="edit_pairing_form_<?php echo $i;?>" type="hidden" name="match_id" value="<?php echo $match['pairing_id']; ?>" />
							<input form="edit_pairing_form_<?php echo $i;?>" type="button" value="Save" id="<?php echo $i;?>" onclick="pairings_edit(id, $('#edit_pairing_form_'+id).serializeArray())"/>
						</td>
						<td class="command">
							<input type="button" onclick="<?php $_GET['match_id']=$match['pairing_id'];?>$('#content').load('tournaments/pairings_delete.php')" value="Delete" />
						</td>
					</tr>
				</form>
		<?php
				$i++;
			}
		?>
		
		<script language="javascript">
			function verify_add_form() {
				if (document.getElementById("new_match_gov_team_id").value == "") {
					alert("Please select a government team");
					return;
				}
				
				if (document.getElementById("new_match_opp_team_id").value == "") {
					alert("Please select an opposition team");
					return;
				}
				
				if (document.getElementById("new_match_gov_team_id").value == document.getElementById("new_match_opp_team_id").value) {
					alert("Government and opposition teams must be different.");
					return;
				}
				
				pairings_add($('#new_pairing_form').serializeArray());
			}
		</script>

		<form id="new_pairing_form">
		<tr style="background: #CCCCFF">
			<td>
				<select form="new_pairing_form" id="new_match_gov_team_id" name="match_gov_team_id">
					<option value="">&nbsp;</option>
					<?php
						$available_teams = $match_obj->get_available_teams($db_obj, $round_id);
						foreach($available_teams as $team) {
							print("<option value=\"" . $team['team_id'] . "\">" . $team['team_name'] . "</option>");
						}
					?>
					<option value="-1">(No Team)</option>
				</select>
			</td>
			<td>
				<select form="new_pairing_form" id="new_match_opp_team_id" name="match_opp_team_id">
					<option value="">&nbsp;</option>
					<?php
						$available_teams = $match_obj->get_available_teams($db_obj, $round_id);
						foreach($available_teams as $team) {
							print("<option value=\"" . $team['team_id'] . "\">" . $team['team_name'] . "</option>");
						}
					?>
					<option value="-1">(No Team)</option>
				</select>
			</td>
			<td>&nbsp;</td>
			<td>
				<select form="new_pairing_form" id="new_room_id" name="room_id">
					<option value="">&nbsp;</option>
					<?php
						$available_rooms = $match_obj->get_available_rooms($db_obj, $round_id);
						foreach($available_rooms as $room) {
							print("<option value=\"" . $room['room_id'] . "\">" . $room['room_name'] . "</option>");
						}
					?>
				</select>
			</td>
			<td>
				<input form="new_pairing_form" id="new_match_priority" type="text" name="match_priority" value="<?php echo $highest_priority+1; ?>" style="width: 50px" />
			</td>
			<td class="command" colspan="2">
				<input form="new_pairing_form" type="hidden" name="round_id" value="<?php echo $round_id; ?>" />
				<input form="new_pairing_form" type="button" onclick="verify_add_form()" value="Add Match" />
			</td>
		</tr>
		</form>

	</table>
<?php
	}
?>

<script>
	function round_dropdown(value)
	{
		$.ajax({
			url: "tournaments/pairings.php",	
			type: "GET",
			data: {'round_id':value},
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
	
	function pairings_add(form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});
		
		$.ajax({
			url: "tournaments/pairings_add.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
	
	function pairings_edit(id, form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});

		$.ajax({
			url: "tournaments/pairings_edit.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
</script>