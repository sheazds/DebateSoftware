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
	
	//print_r($_POST);

	if (isset($_POST['get_round_id'])) {
		$round_id = $_POST['get_round_id'];
	}

	if (isset($_POST['cmd'])) {
		if ($_POST['cmd'] == "delete") {
			$round_id = $_POST['round_id'];
			$match_obj->delete_matches($db_obj, $round_id);
			
			echo "<script>
				function view_pairings(id)
				{
					$.ajax({
						url: 'tournaments/pairings.php',
						type: 'POST',
						data: {'get_round_id':id},
						success: function(return_data){
							$('#content').html(return_data);
						},
					});
				}
			</script>";
			echo "<script>view_pairings(".$round_id.")</script>";
		}
	}
?>