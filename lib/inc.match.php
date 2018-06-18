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

	require_once("inc.round.php");
	require_once("inc.judge.php");
	
	// Matches
	class Match {
	
		function add_match($db, $round_id, $match_gov_team_id, $match_opp_team_id, $room_id, $pullup_team_id, $match_priority) {
			$round_id = $db->escape($round_id);
			$match_gov_team_id = $db->escape($match_gov_team_id);
			$match_opp_team_id = $db->escape($match_opp_team_id);
			$room_id = $db->escape($room_id);
			$pullup_team_id = $db->escape($pullup_team_id);
			$match_priority = $db->escape($match_priority);
			
			return $db->query("INSERT INTO pairing (round_id, match_gov_team_id, match_opp_team_id, room_id, pullup_team_id, priority) " .
							  "VALUES ('$round_id', '$match_gov_team_id', '$match_opp_team_id', '$room_id', '$pullup_team_id', '$match_priority')");
		}
		
		function add_match_judge($db, $match_id, $judge_id) {
			$match_id = $db->escape($match_id);
			$judge_id = $db->escape($judge_id);
			
			return $db->query("INSERT INTO pairing_judge (pairing_id, judge_id) VALUES ('$match_id', '$judge_id')");
		}
        
		
		
		function get_unjudged_rooms($db, $round_id){
		
            $match_ids = array();
			

			/***
			if ($matches = $this->get_matches($db, $round_id)) {
				foreach ($matches as $match) {
					if ($rows = $db->fetch_rows("SELECT pairing_id FROM pairing_judge WHERE pairing_id='" . $match['pairing_id'] . "' & judge_id == null")) {
						foreach($rows as $row) {
							$match_ids[] = $row['pairing_id'];
						}
					}
				}
			}
			

            ***/
			
			
			$query = "SELECT pairing.pairing_id from pairing WHERE pairing.round_id ='" . $round_id . "' AND pairing.pairing_id NOT IN (SELECT pairing_judge.pairing_id FROM pairing_judge)";
			$rows = $db->fetch_rows($query); 
											
		    return $rows;
		}
		
		
		
		function add_best_judge($db, $match_id) {
		     $judges = $this->get_available_judges($db, $this->get_round_from_match($db, $match_id));
			 
			 if($judges){
			    $judgeid = $judges[0][0];
			    $this->add_match_judge($db, $match_id, $judgeid);
            }				
		}
		
		
		
		function get_round_from_match($db, $match_id){
		    $query = "SELECT pairing_id FROM pairing WHERE pairing_id='" . $match_id . "'";
			$rows = $db->fetch_rows($query);
			
			if($rows){
               return $rows[0][0];
			} else {
			    return false;
			}
		}
		
		function remove_match_judge($db, $match_id, $judge_id) {
			$match_id = $db->escape($match_id);
			$judge_id = $db->escape($judge_id);
			
			return $db->query("DELETE FROM pairing_judge WHERE pairing_id='$match_id' AND judge_id='$judge_id'");
		}

		function remove_all_match_judges($db, $match_id) {
			$match_id = $db->escape($match_id);
			return $db->query("DELETE FROM pairing_judge WHERE pairing_id='$match_id'");
		}
		
		function remove_match_judges($db, $round_id) {
			if ($matches = $this->get_matches($db, $round_id)) {
				foreach($matches as $match) {
					$this->remove_all_match_judges($db, $match['match_id']);
				}
			}
		}
		
		function edit_match($db, $match_id, $room_id, $match_priority) {
			$match_id = $db->escape($match_id);
			$room_id = $db->escape($room_id);
			$match_priority = $db->escape($match_priority);
			return $db->query("UPDATE pairing SET room_id='$room_id', priority='$match_priority' WHERE pairing_id='$match_id'");			
		}
		
		function get_matches($db, $round_id) {
			$round_id = $db->escape($round_id);
			return $db->fetch_rows("SELECT * FROM pairing WHERE round_id='$round_id' ORDER BY priority ASC");
		}
		
		function get_matches_by_room($db, $round_id) {
			$round_id = $db->escape($round_id);
			return $db->fetch_rows("SELECT * FROM pairing WHERE round_id='$round_id' ORDER BY room_id ASC");
		}

		function get_match($db, $match_id) {
			$match_id = $db->escape($match_id);
			return $db->fetch_row("SELECT * FROM pairing WHERE pairing_id='$match_id'");
		}
		
		function delete_match($db, $match_id) {
			$match_id = $db->escape($match_id);
			$db->query("DELETE FROM pairing_judge WHERE pairing_id='$match_id'");
			//$db->query("DELETE FROM ballot WHERE match_id='$match_id'");
			$db->query("DELETE FROM result WHERE match_id='$match_id'");
			$db->query("DELETE FROM speakerresult WHERE match_id='$match_id'");
			//$db->query("DELETE FROM redundant_ballot WHERE match_id='$match_id'");
			//$db->query("DELETE FROM redundant_result WHERE match_id='$match_id'");
			//$db->query("DELETE FROM redundant_speakerresult WHERE match_id='$match_id'");

			return $db->query("DELETE FROM pairing WHERE pairing_id='$match_id'");
		}
		
		function delete_matches($db, $round_id) {
			$matches = $this->get_matches($db, $round_id);
			foreach($matches as $match) {
				$this->delete_match($db, $match['pairing_id']);
			}
		}

		function get_available_teams($db, $round_id) {
			$team_obj = new Team;
			
			$assigned_teams = array();
			$rows = $db->fetch_rows("SELECT match_gov_team_id as team_id FROM pairing WHERE round_id='$round_id'");
			foreach($rows as $row) {
				$assigned_teams[] = $row['team_id'];
			}
			$rows = $db->fetch_rows("SELECT match_opp_team_id as team_id FROM pairing WHERE round_id='$round_id'");
			foreach($rows as $row) {
				$assigned_teams[] = $row['team_id'];
			}

			$available_teams = array();
			$teams = $team_obj->get_teams($db);

			foreach ($teams as $team) {
				if (array_search($team['team_id'], $assigned_teams) === false) {
					$available_teams[] = $team;
				}
			}
				
			return $available_teams;		
		}

		function get_available_rooms($db, $round_id) {
			$room_obj = new Room;
			
			$assigned_rooms = array();
			$rows = $db->fetch_rows("SELECT room_id FROM pairing WHERE round_id='$round_id'");
			foreach($rows as $row) {
				$assigned_rooms[] = $row['room_id'];
			}
			
			$available_rooms = array();
			$rooms = $room_obj->get_rooms($db);

			foreach ($rooms as $room) {
				if (array_search($room['room_id'], $assigned_rooms) === false) {
					$available_rooms[] = $room;
				}
			}
			
			return $available_rooms;		
		}

		function get_available_judges($db, $round_id) {
			$judge_obj = new Judge;
			$round_obj = new Round;
			
			$assigned_judges = array();
			if ($matches = $this->get_matches($db, $round_id)) {
				foreach ($matches as $match) {
					if ($rows = $db->fetch_rows("SELECT judge_id FROM pairing_judge WHERE pairing_id='" . $match['pairing_id'] . "'")) {
						foreach($rows as $row) {
							$assigned_judges[] = $row['judge_id'];
						}
					}
				}
			}
			
			$available_judges = array();
			$judges = $judge_obj->get_active_judges_by_rank($db);

			foreach ($judges as $judge) {
				if (array_search($judge['judge_id'], $assigned_judges) === false) {
					$available_judges[] = $judge;
				}
			}
			
			return $available_judges;		
		}

		function get_match_by_team($db, $round_id, $team_id) {
			$round_id = $db->escape($round_id);
			$team_id = $db->escape($team_id);
			
			if ($row = $db->fetch_row("SELECT pairing_id FROM pairing WHERE round_id='$round_id' AND (match_gov_team_id='$team_id' OR match_opp_team_id='$team_id')")) {
				$match_obj = new Match;
				return $match_obj->get_match($db, $row['pairing_id']);
			} else {
				return false;
			}
		}

		function get_matches_by_team($db, $round_id, $team_id, $inclusive) {
			$round_obj = new Round;
			$matches = array();
						
			$rounds = $round_obj->get_rounds_collection($db, $round_id, $inclusive);

			foreach($rounds as $round) {
				if ($match = $this->get_match_by_team($db, $round['round_id'], $team_id)) {
					$matches[] = $match;
				}
			}
			return $matches;
		}


		function get_gov_matches_by_team($db, $round_id, $team_id, $inclusive) {
			$round_obj = new Round;
			$matches = array();
						
			$rounds = $round_obj->get_rounds_collection($db, $round_id, $inclusive);

			foreach($rounds as $round) {
				if ($match = $this->get_match_by_team($db, $round['round_id'], $team_id)) {
					if ($match['match_gov_team_id'] == $team_id) {
						$matches[] = $match;
					}
				}
			}
			return $matches;
		}

		function get_matches_by_pullup($db, $round_id, $team_id, $inclusive) {
			$round_obj = new Round;
			$matches = array();
						
			$rounds = $round_obj->get_rounds_collection($db, $round_id, $inclusive);

			foreach($rounds as $round) {
				if ($match = $this->get_match_by_team($db, $round['round_id'], $team_id)) {
					if ($match['pullup_team_id'] == $team_id) {
						$matches[] = $match;
					}
				}
			}
			return $matches;
		}

		function get_team_ids_from_last_round($db, $round_id) {
			$team_obj = new Team;
			$round_obj = new Round;
			$team_ids = array();
						
			if ($round = $round_obj->get_previous_round($db, $round_id)) {
				$matches = $this->get_matches($db, $round['round_id']);
				if (count($matches) > 0) {
					foreach($matches as $match) {
						if ($match['match_gov_team_id'] > 0) {
							$team_ids[] = $match['match_gov_team_id'];
						}
						if ($match['match_opp_team_id'] > 0) {
							$team_ids[] = $match['match_opp_team_id'];
						}
					}
				}
			} else {
				$teams = $team_obj->get_teams($db);
				foreach ($teams as $team) {
					$team_ids[] = $team['team_id'];
				}
			}

			return $team_ids;
		}

		function get_room_ids_from_last_round($db, $round_id) {
			$room_obj = new Room;
			$round_obj = new Round;
			$room_ids = array();
						
			if ($round = $round_obj->get_previous_round($db, $round_id)) {
				$matches = $this->get_matches($db, $round['round_id']);
				if (count($matches) > 0) {
					foreach($matches as $match) {
						if ($match['room_id'] > 0) {
							$room_ids[] = $match['room_id'];
						}
					}
				}
			} else {
				$rooms = $room_obj->get_rooms($db);
				foreach ($rooms as $room) {
					$room_ids[] = $room['room_id'];
				}
			}

			return $room_ids;
		}
		
		function num_unpaired_judges($db, $round_id){
			$num = $this->get_available_judges($db, $round_id);
			return count($num);
		}
	}	
?>