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

	require_once("inc.team.php");
	require_once("inc.result.php");
	require_once("inc.match.php");
	require_once("inc.scratch.php");
	
	// Judges
	class Judge {

		function get_num_judges_by_school($db, $school_id) {
			$school_id = $db->escape($school_id);
			$sql_string = "SELECT COUNT(*) FROM judge WHERE school_id='$school_id'";
			$row = $db->fetch_row($sql_string);
			return $row[0];
		}

		function num_judges($db) {
			$row = $db->fetch_row("SELECT COUNT(*) FROM judge");
			return $row[0];
		}

		/*function num_active_judges($db) {
			$row = $db->fetch_row("SELECT COUNT(*) FROM judge WHERE judge_active='1'");
			return $row[0];
		}*/

		function get_judges($db) {
			$sql_string = "SELECT * FROM judge ORDER BY judge_last_name ASC";
			return $db->fetch_rows($sql_string);
		}

		function get_active_judges($db) {
			$sql_string = "SELECT * FROM judge ORDER BY  judge_last_name ASC";
			return $db->fetch_rows($sql_string);
		}
		
		function get_active_judges_by_rank($db) {
			$sql_string = "SELECT * FROM judge ORDER BY judge_last_name ASC";
			return $db->fetch_rows($sql_string);
		}
		
		function get_judges_by_rank($db) {
			$sql_string = "SELECT * FROM judge ORDER BY judge_rank DESC, judge_name ASC";
			return $db->fetch_rows($sql_string);
		}
		
		function judge_exists($db, $judge_name) {
			$judge_name = $db->escape(strtoupper($judge_name));
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM judge WHERE UCASE(judge_name)='$judge_name'")) {
				if ($row[0] == 0) {
					return false;
				}
			}
			return true;
		}

		function other_judge_exists($db, $judge_id, $judge_name) {
			$judge_id = $db->escape($judge_id);
			$judge_name = $db->escape(strtoupper($judge_name));
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM judge WHERE judge_id<>'$judge_id' AND UCASE(judge_name)='$judge_name'")) {
				if ($row[0] == 0) {
					return false;
				}
			}
			return true;
		}		
		
		function add_judge($db, $judge_name, $judge_rank, $school_id) {
			$judge_name = $db->escape($judge_name);
			$judge_rank = $db->escape($judge_rank);
			$school_id = $db->escape($school_id);
			return $db->query("INSERT INTO judge (judge_name, judge_rank, school_id) VALUES ('$judge_name', '$judge_rank', '$school_id')");
		}
		
		function get_judge($db, $judge_id) {
			$judge_id = $db->escape($judge_id);
			return $db->fetch_row("SELECT * FROM judge WHERE judge_id='$judge_id'");
		}
		
		function delete_judge($db, $judge_id) {
			$judge_id = $db->escape($judge_id);
			return $db->query("DELETE FROM judge WHERE judge_id='$judge_id'");
		}
		
		function can_delete($db, $judge_id) {
			$judge_id = $db->escape($judge_id);
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM matchjudge WHERE judge_id='$judge_id'")) {
				if ($row[0] > 0) {
					return false;
				}
			}
			
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM scratch WHERE judge_id='$judge_id'")) {
				if ($row[0] > 0) {
					return false;
				}
			}
			
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM paneljudge WHERE judge_id='$judge_id'")) {
				if ($row[0] > 0) {
					return false;
				}
			}
			
			return true;
		}
		
		/*function set_judge_active($db, $judge_id, $active) {
			$judge_id = $db->escape($judge_id);
			$judge_active = ($active == true) ? 1 : 0;
			return $db->query("UPDATE judge SET judge_active='$judge_active' WHERE judge_id='$judge_id'");
		}*/
		
		function edit_judge($db, $judge_id, $school_id, $judge_name, $judge_rank) {
			$judge_id = $db->escape($judge_id);
			$school_id = $db->escape($school_id);
			$judge_name = $db->escape($judge_name);
			$judge_rank = $db->escape($judge_rank);
			return $db->query("UPDATE judge SET judge_name='$judge_name', judge_rank='$judge_rank', school_id='$school_id' WHERE judge_id='$judge_id'");
		}
		
		function get_panels($db) {
			$panels = array();
			$rows = $db->fetch_rows("SELECT * FROM panel ORDER BY panel_rank DESC");
			foreach ($rows as $row) {
				$panels[] = $this->get_panel($db, $row['panel_id']);				
			}
			return $panels;
		}
		
		function get_panel($db, $panel_id) {
			$panel_id = $db->escape($panel_id);
			$panel = $db->fetch_row("SELECT * FROM panel WHERE panel_id='$panel_id'");
			$panel['judges'] = array();
			if ($judges = $db->fetch_rows("SELECT * FROM paneljudge WHERE panel_id='$panel_id'")) {
				foreach ($judges as $judge) {
					if ($curr_judge = $this->get_judge($db, $judge['judge_id'])) {
						$panel['judges'][] = $curr_judge;
					}
				}
			}
			return $panel;
		}
		
		function delete_panel($db, $panel_id) {
			$panel_id = $db->escape($panel_id);
			if ($db->query("DELETE FROM paneljudge WHERE panel_id='$panel_id'")) {
				return $db->query("DELETE FROM panel WHERE panel_id='$panel_id'");
			}
		}
		
		function get_available_panel_judges($db) {
			$unavailable_judges = array();
			
			$panelled_judges = $db->fetch_rows("SELECT judge_id FROM paneljudge");

			foreach($panelled_judges as $judge) {
				$unavailable_judges[] = $judge['judge_id'];
			}

			$judges = $this->get_judges($db);
			$available_judges = array();

			foreach($judges as $judge) {
				if (array_search($judge['judge_id'], $unavailable_judges) === false) {
					$available_judges[] = $judge;
				}
			}

			return $available_judges;
		}
		
		function add_panel($db, $judges, $panel_rank, $panel_allow_split) {
			$panel_rank = $db->escape($panel_rank);
			for($i=0; $i<count($judges); $i++) {
				$judges[$i] = $db->escape($judges[$i]);
			}
			
			$panel_split = 0;
			if ($panel_allow_split) {
				$panel_split = 1;
			}
			
			if ($db->query("INSERT INTO panel (panel_rank, panel_allow_split) VALUES ('$panel_rank', '$panel_split')")) {
				if ($row = $db->fetch_row("SELECT MAX(panel_id) FROM panel")) {
					$panel_id = $row[0];
					foreach($judges as $judge_id) {
						$db->query("INSERT INTO paneljudge (panel_id, judge_id) VALUES ('$panel_id', '$judge_id')");
					}
				}
				return true;
			}
			return false;	
		}

		function edit_panel($db, $panel_id, $judges, $panel_rank, $panel_allow_split) {
			if ($this->delete_panel($db, $panel_id)) {
				return $this->add_panel($db, $judges, $panel_rank, $panel_allow_split);
			}
			return false;
		}
		
		function has_conflict($db, $judge_id, $team_id, $round_id) {
			$team_obj = new Team;
			$team = $team_obj->get_team($db, $team_id);
			$judge = $this->get_judge($db, $judge_id);
			
			// Check school conflicts
			if ($team['school_id'] == $judge['school_id']) {
				return true;
			}
			
			// Check scratch conflicts
			$scratch_obj = new Scratch;
			if ($scratch_obj->scratch_exists($db, $judge_id, $team_id)) {
				return true;
			}
			
			// Check previously judged
			$match_obj = new Match;
			if ($matches = $match_obj->get_matches_by_team($db, $round_id, $team_id, false)) {
				$judge_id = $db->escape($judge_id);
				foreach ($matches as $match) {
					if ($row = $db->fetch_row("SELECT COUNT(*) FROM pairing_judge WHERE pairing_id='" . $match['pairing_id'] . "' AND judge_id='$judge_id'")) {
						if ($row[0] > 0) {
							return true;
						}
					}					
				}
			}
			
			return false;			
		}

		function has_school_conflict($db, $judge_id, $team_id, $round_id) {
			$team_obj = new Team;
			$team = $team_obj->get_team($db, $team_id);
			$judge = $this->get_judge($db, $judge_id);
			
			// Check school conflicts
			if ($team['school_id'] == $judge['school_id']) {
				return true;
			}
	
			return false;			
		}

		function has_scratch_conflict($db, $judge_id, $team_id, $round_id) {
			$team_obj = new Team;
			$team = $team_obj->get_team($db, $team_id);
			$judge = $this->get_judge($db, $judge_id);
			
			// Check scratch conflicts
			$scratch_obj = new Scratch;
			if ($scratch_obj->scratch_exists($db, $judge_id, $team_id)) {
				return true;
			}
			
			return false;			
		}
		
		function has_previously_paired_conflict($db, $judge_id, $team_id, $round_id) {
			$team_obj = new Team;
			$team = $team_obj->get_team($db, $team_id);
			$judge = $this->get_judge($db, $judge_id);
			
			// Check previously judged
			$match_obj = new Match;
			if ($matches = $match_obj->get_matches_by_team($db, $round_id, $team_id, false)) {
				$judge_id = $db->escape($judge_id);
				foreach ($matches as $match) {
					if ($row = $db->fetch_row("SELECT COUNT(*) FROM pairing_judge WHERE pairing_id='" . $match['pairing_id'] . "' AND judge_id='$judge_id'")) {
						if ($row[0] > 0) {
							return true;
						}
					}					
				}
			}
			
			return false;			
		}

        
		function num_previously_paired($db, $judge_id, $team_id, $round_id){
		   	$team_obj = new Team;
			$team = $team_obj->get_team($db, $team_id);
			$judge = $this->get_judge($db, $judge_id);	
		
		    $match_obj = new Match;
		    $numpairs = 0;
			
			if ($matches = $match_obj->get_matches_by_team($db, $round_id, $team_id, false)) {
				$judge_id = $db->escape($judge_id);
				foreach ($matches as $match) {
					if ($row = $db->fetch_row("SELECT COUNT(*) FROM pairing_judge WHERE pairing_id='" . $match['pairing_id'] . "' AND judge_id='$judge_id'")) {
						if ($row[0] > 0) {
							$numpairs++;
						}
					}					
				}
			}
			
			return $numpairs;
			
		}
		
		
		function get_match_judges($db, $match_id) {
			$match_id = $db->escape($match_id);
			
			$judges = array();
			if ($rows = $db->fetch_rows("SELECT * FROM pairing_judge WHERE pairing_id='$match_id'")) {
				foreach ($rows as $row) {
					$judges[] = $this->get_judge($db, $row['judge_id']);
				}
			}
			return $judges;
		}

	}
?>