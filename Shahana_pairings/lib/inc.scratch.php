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

	// Scratches
	class Scratch {

		function num_scratches($db) {
			$row = $db->fetch_row("SELECT COUNT(*) FROM scratch");
			return $row[0];
		}

		function get_scratches($db) {
			$sql_string = "SELECT scratch.scratch_id, scratch.judge_id, judge.judge_name, scratch.team_id, team.team_name " .
						  "FROM scratch, judge, team WHERE scratch.judge_id=judge.judge_id AND scratch.team_id=team.team_id ORDER BY judge_name, team_name";
			return $db->fetch_rows($sql_string);
		}
		
		function scratch_exists($db, $judge_id, $team_id) {
			$judge_id = $db->escape($judge_id);
			$team_id = $db->escape($team_id);
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM scratch WHERE judge_id='$judge_id' AND team_id='$team_id'")) {
				if ($row[0] == 0) {
					return false;
				}
			}
			return true;
		}

		function add_scratch($db, $judge_id, $team_id) {
			$judge_id = $db->escape($judge_id);
			$team_id = $db->escape($team_id);
			return $db->query("INSERT INTO scratch (judge_id, team_id) VALUES ('$judge_id', '$team_id')");
		}
		
		function get_scratch($db, $scratch_id) {
			$scratch_id = $db->escape($scratch_id);
			return $db->fetch_row("SELECT * FROM scratch WHERE scratch_id='$scratch_id'");
		}
		
		function delete_scratch($db, $scratch_id) {
			$scratch_id = $db->escape($scratch_id);
			return $db->query("DELETE FROM scratch WHERE scratch_id='$scratch_id'");
		}
		
	}
?>