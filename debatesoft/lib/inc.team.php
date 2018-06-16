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


	// Teams
	class Team {

		function num_teams($db) {
			$row = $db->fetch_row("SELECT COUNT(*) FROM team");
			return $row[0];
		}
		
		function get_team($db, $team_id) {
			$team_id = $db->escape($team_id);
			return $db->fetch_row("SELECT * FROM team WHERE team_id='$team_id'");
		}
		
		function get_teams($db) {
			$sql_string = "SELECT * FROM team ORDER BY team_name";
			return $db->fetch_rows($sql_string);
		}
		

		function get_num_teams_by_school($db, $school_id) {
			$school_id = $db->escape($school_id);
			$sql_string = "SELECT COUNT(*) FROM team WHERE school_id='$school_id'";
			$row = $db->fetch_row($sql_string);
			return $row[0];
		}

		function team_exists($db, $team_name) {
			$team_name = $db->escape(strtoupper($team_name));
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM team WHERE UCASE(team_name)='$team_name'")) {
				if ($row[0] == 0) {
					return false;
				}
			}
			return true;
		}
		
		function other_team_exists($db, $team_id, $team_name) {
			$team_id = $db->escape($team_id);
			$team_name = $db->escape(strtoupper($team_name));
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM team WHERE team_id<>'$team_id' AND UCASE(team_name)='$team_name'")) {
				if ($row[0] == 0) {
					return false;
				}
			}
			return true;
		}
				
		function add_team($db, $team_name, $school_id, $speaker_a_name, $speaker_b_name) {
			$team_name = $db->escape($team_name);
			$school_id = $db->escape($school_id);
			$speaker_a_name = $db->escape($speaker_a_name);
			$speaker_b_name = $db->escape($speaker_b_name);
			
			$sql_string = "INSERT INTO team (team_name, school_id) VALUES ('$team_name', '$school_id')";
			if ($db->query($sql_string)) {
				if ($row = $db->fetch_row("SELECT team_id FROM team WHERE team_name='$team_name'")) {
					$team_id = $row[0];
					if ($db->query("INSERT INTO speaker (speaker_name, team_id) VALUES ('$speaker_a_name', '$team_id')") &&
						$db->query("INSERT INTO speaker (speaker_name, team_id) VALUES ('$speaker_b_name', '$team_id')")) {
							return true;
					}
				}
			}
			return false;	
		}
		
		function edit_team($db, $team_id, $team_name, $school_id, $speaker_a_id, $speaker_a_name, $speaker_b_id, $speaker_b_name) {
			$team_id = $db->escape($team_id);
			$team_name = $db->escape($team_name);
			$school_id = $db->escape($school_id);
			$speaker_a_id = $db->escape($speaker_a_id);
			$speaker_a_name = $db->escape($speaker_a_name);
			$speaker_b_id = $db->escape($speaker_b_id);
			$speaker_b_name = $db->escape($speaker_b_name);
			
			if ($db->query("UPDATE team SET team_name='$team_name', school_id='$school_id' WHERE team_id='$team_id'")) {
				if ($db->query("UPDATE speaker SET speaker_name='$speaker_a_name' WHERE speaker_id='$speaker_a_id'") &&
					$db->query("UPDATE speaker SET speaker_name='$speaker_b_name' WHERE speaker_id='$speaker_b_id'")) {
						return true;
				}
			}
			return false;
		}
		
		function can_delete($db, $team_id) {
			$team_id = $db->escape($team_id);
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM matchup WHERE match_gov_team_id='$team_id' OR match_opp_team_id='$team_id'")) {
				if ($row[0] > 0) {
					return false;
				}
			}
			
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM result WHERE team_id='$team_id'")) {
				if ($row[0] > 0) {
					return false;
				}
			}
			
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM scratch WHERE team_id='$team_id'")) {
				if ($row[0] > 0) {
					return false;
				}
			}
			
			return true;
		}
		
		function delete_team($db, $team_id) {
			$team_id = $db->escape($team_id);
			$db->query("DELETE FROM speaker WHERE team_id='$team_id'");
			$db->query("DELETE FROM team WHERE team_id='$team_id'");
		}
	}
?>