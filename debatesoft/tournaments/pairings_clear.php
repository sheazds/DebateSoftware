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

	$db_obj = new Database;
	$match_obj = new Match;
	$round_obj = new Round;
	$team_obj = new Team;
			
	$round_id = "";

	if (isset($_GET['round_id'])) {
		$round_id = $_GET['round_id'];
	}

	if (isset($_POST['cmd'])) {
		if ($_POST['cmd'] == "delete") {
			$round_id = $_POST['round_id'];
			$match_obj->delete_matches($db_obj, $round_id);

			header("Location: pairings.php?round_id=" . $round_id);
			exit();
		}
	}
?>
<div class="body">
	<?php
		$round = $round_obj->get_round($db_obj, $round_id);
	?>
	<p class="error">
		Are you sure you want to clear <?php echo $round['round_name']; ?>?
	</p>
	<p class="error">
		THIS WILL DELETE ALL BALLOTS AND RESULTS ASSOCIATED WITH THIS ROUND.
	</p>
	<form id="confirm_clear">
		<input form="confirm_clear" type="hidden" name="round_id" value="<?php echo $round['round_id']; ?>" />
		<input form="confirm_clear" type="hidden" name="cmd" value="delete" />
		<br />
		<input form="confirm_clear" type="button" value="Yes" onclick="confirm_clear($('#confirm_clear').serializeArray())"/>
		<input form="confirm_clear" onclick="<?php $_GET['round_id']=$round['round_id'];?>$('#content').load('tournaments/pairings.php')" type="button" value="No" />
	</form>
</div>

<script>
	function confirm_clear(form)
	{
		post_data = {};
		form.forEach(function(item, index) {
			post_data[item.name] = item.value;
		});

		$.ajax({
			url: "tournaments/pairings_clear_confirmed.php",	
			type: "POST",
			data: post_data,
			success: function(return_data){
				$('#content').html(return_data);
			},
		});
	}
</script>