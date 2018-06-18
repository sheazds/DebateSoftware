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
	require_once("../lib/inc.round.php");
	require_once("../lib/inc.team.php");
	require_once("../scripts/pairings.php");

	$db_obj = new Database;
	$match_obj = new Match;
	$round_obj = new Round;
	$team_obj = new Team;
			
	$match_id = "";
	
	if (isset($_POST['get_match_id'])) {
		$match_id = $_POST['get_match_id'];
	}

	if (isset($_POST['cmd'])) {
		if ($_POST['cmd'] == "delete") {
			$match_id = $_POST['match_id'];
			$round_id = $_POST['round_id'];
			$match_obj->delete_match($db_obj, $match_id);
			echo "<script>view_pairings(".$round_id.")</script>";		}
	}

?>
<div class="body">
	<?php
		$match = $match_obj->get_match($db_obj, $match_id);
		$round = $round_obj->get_round($db_obj, $match['round_id']);
		$gov_team = $team_obj->get_team($db_obj, $match['match_gov_team_id']);
		$opp_team = $team_obj->get_team($db_obj, $match['match_opp_team_id']);
	?>
	<p class="error">
		Are you sure you want to delete (<?php echo $round['round_name']; ?>) 
		<?php echo $gov_team['team_name']; ?> vs. <?php echo $opp_team['team_name']; ?>?<br />
	</p>
	<p class="error">
		THIS WILL DELETE ALL BALLOTS AND RESULTS ASSOCIATED WITH THIS MATCH.
	</p>
	<form id="confirm_delete" method="post" action="pairings_delete.php">
		<input form="confirm_delete" type="hidden" name="match_id" value="<?php echo $match_id; ?>" />
		<input form="confirm_delete" type="hidden" name="round_id" value="<?php echo $round['round_id']; ?>" />
		<input form="confirm_delete" type="hidden" name="cmd" value="delete" />
		<br />
		<input form="confirm_delete" type="button" value="Yes" onclick="confirm_delete($('#confirm_delete').serializeArray())"/>
		<input form="confirm_delete" onclick="view_pairings(<?php echo $round['round_id'];?>)" type="button" value="No" />
	</form>
</div>