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
	require_once("../lib/inc.match.php");

	$db_obj = new Database;
	$match_obj = new Match;

	$round_id = $_POST['round_id'];
	$match_id = $_POST['match_id'];
	$room_id = intval($_POST['room_id']);
	$match_priority = intval($_POST['match_priority']);
	
	$match_obj->edit_match($db_obj, $match_id, $room_id, $match_priority);
	
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
?>