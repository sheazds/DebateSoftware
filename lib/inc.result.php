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
	require_once("inc.match.php");
	require_once("inc.team.php");
	require_once("inc.speaker.php");
		
	// Results
	class Result {
		
	// Team Points ////////////////////////////////////////////////////////////////////////////////////
		
		function get_points($db, $round_id, $team_id, $inclusive) {
			$round_obj = new Round;
			$round = $round_obj->get_round($db, $round_id);

			$sql_string = "";
			/*if ($inclusive) {
				$sql_string = "SELECT * FROM round WHERE round_order<='" . $round['round_order'] . "'";
			} else {
				$sql_string = "SELECT * FROM round WHERE round_order<'" . $round['round_order'] . "'";
			}*/

			$sql_string = "SELECT * FROM round WHERE round_id < '".$round['round_id']."'";
			
			$rounds = $db->fetch_rows($sql_string);
			$points = 0;

			foreach($rounds as $curr_round) {
				if (($curr_points = $this->get_points_in_round($db, $curr_round['round_id'], $team_id)) !== false) {
					$points += $curr_points;
				}
			}
			
			return $points;
		}
		
		function get_points_in_round($db, $round_id, $team_id) {
			$match_obj = new Match;
			if ($match = $match_obj->get_match_by_team($db, $round_id, $team_id)) {
				$team_id = $db->escape($team_id);
				if ($results = $db->fetch_rows("SELECT * FROM result WHERE match_id='" . $match['pairing_id'] . "' AND team_id='$team_id'")) {
					$point_total = 0;

					if (count($results) < 1) {
						return 0;
					}
					
					foreach($results as $result) {
						$point_total += $result['team_points'];
					}
					if (($point_total/count($results)) > 0.5) {
						return 1;
					} elseif (($point_total/count($results)) == 0.5) {
						if ($match['match_gov_team_id'] == $team_id) {
							return 1;
						} else {
							return 0;
						}
					} else {
						return 0;
					}
				} else {
					return false;
				}
			}
			return false;
		}


	// Team Score ////////////////////////////////////////////////////////////////////////////////////
		
		function get_team_score($db, $round_id, $team_id, $inclusive) {
			$round_obj = new Round;
			$round = $round_obj->get_round($db, $round_id);

			$sql_string = "";
			if ($inclusive) {
				$sql_string = "SELECT * FROM round WHERE round_id<='" . $round['round_id'] . "'";
			} else {
				$sql_string = "SELECT * FROM round WHERE round_id<'" . $round['round_id'] . "'";
			}
			
			$rounds = $db->fetch_rows($sql_string);
			$score = 0.0;
			$count = 0;

			foreach($rounds as $curr_round) {
				if (($curr_score = $this->get_team_score_in_round($db, $curr_round['round_id'], $team_id)) !== false) {
					$score += $curr_score;
					$count++;
				}
			}
			
			if ($count > 0) {
				return ($score/$count);
			}
			return 0;
		}
		
		function get_team_score_in_round($db, $round_id, $team_id) {
			$match_obj = new Match;
			$match = $match_obj->get_match_by_team($db, $round_id, $team_id);
			
			$team_id = $db->escape($team_id);
			if ($results = $db->fetch_rows("SELECT * FROM result WHERE match_id='" . $match['pairing_id'] . "' AND team_id='$team_id'")) {
				$score_tally = 0.0;
				
				if (count($results) < 1) {
					return 0;
				}
				
				foreach($results as $result) {
					$score_tally += $result['team_score'];
				}
				
				return $score_tally / count($results);
			} else {
				return false;
			}
		}
		

	// Team Tie Breakers ////////////////////////////////////////////////////////////////////////////////
		
		function get_team_stdev($db, $round_id, $team_id, $inclusive) {
			$round_obj = new Round;
			$round = $round_obj->get_round($db, $round_id);

			$sql_string = "";
			if ($inclusive) {
				$sql_string = "SELECT * FROM round WHERE round_id<='" . $round['round_id'] . "'";
			} else {
				$sql_string = "SELECT * FROM round WHERE round_id<'" . $round['round_id'] . "'";
			}
			
			$rounds = $db->fetch_rows($sql_string);

			$mean = 0.0;
			$scores = array();
			$n = 0;

			foreach($rounds as $curr_round) {
				if (($curr_score = $this->get_team_score_in_round($db, $curr_round['round_id'], $team_id)) !== false) {
					$scores[] = $curr_score;
					$mean += $curr_score;
					$n++;
				}
			}
			
			if ($n < 2) {
				return 0;
			}
			
			$mean = $mean / $n;

			$deviation_sum = 0.0;
			foreach($scores as $score) {
				$deviation_sum += pow(($score - $mean), 2);
			}

			$std_dev = sqrt($deviation_sum/($n-1));
			return $std_dev;
		}
		
		function get_team_gov_strength($db, $round_id, $team_id, $inclusive) {
			$match_obj = new Match;
			$gov_matches = $match_obj->get_gov_matches_by_team($db, $round_id, $team_id, $inclusive);
			
			$num_govs = count($gov_matches);
			$gov_points = 0;
			foreach($gov_matches as $gov_match) {
				$gov_points += $this->get_points_in_round($db, $gov_match['round_id'], $team_id);
			}
			
			if ($num_govs > 0) {
				return $gov_points/$num_govs;
			} else {
				return 0;
			}
		}
		
	
	
	// Speaker Score ////////////////////////////////////////////////////////////////////////////////////
		
		function get_speaker_score($db, $round_id, $speaker_id, $inclusive) {
			$round_obj = new Round;
			$round = $round_obj->get_round($db, $round_id);

			$sql_string = "";
			if ($inclusive) {
				$sql_string = "SELECT * FROM round WHERE round_id<='" . $round['round_id'] . "'";
			} else {
				$sql_string = "SELECT * FROM round WHERE round_id<'" . $round['round_id'] . "'";
			}
			
			$rounds = $db->fetch_rows($sql_string);
			$score = 0.0;
			$count = 0;

			foreach($rounds as $curr_round) {
				if (($curr_score = $this->get_speaker_score_in_round($db, $curr_round['round_id'], $speaker_id)) !== false) {
					$score += $curr_score;
					$count++;
				}
			}
			
			if ($count > 0) {
				return ($score/$count);
			}
			return 0;
		}
		
		function get_full_speaker_score($db, $round_id, $speaker_id, $inclusive) {
			$round_obj = new Round;
			$round = $round_obj->get_round($db, $round_id);

			$sql_string = "";
			if ($inclusive) {
				$sql_string = "SELECT * FROM round WHERE round_id<='" . $round['round_id'] . "'";
			} else {
				$sql_string = "SELECT * FROM round WHERE round_id<'" . $round['round_id'] . "'";
			}
			
			$rounds = $db->fetch_rows($sql_string);
			$score = 0.0;
			$count = 0;
			$scores = array();

			foreach($rounds as $curr_round) {
				if (($curr_score = $this->get_speaker_score_in_round($db, $curr_round['round_id'], $speaker_id)) !== false) {
					if ($curr_score != null) {
						$scores[] = $curr_score;
						$score += $curr_score;
						$count++;
					}
				}
			}
			
			if ($count == 0) {
				return 0;
			}

			$score_array = array();
			$score_array['score'] = $score/$count;
			
			if ($count < 2) {
				$score_array['stdev'] = 0;
			} else {
				$mean = $score / $count;
				$deviation_sum = 0.0;
				foreach($scores as $curr_score) {
					$deviation_sum += pow(($curr_score - $mean), 2);
				}
				$std_dev = sqrt($deviation_sum/($count-1));
				$score_array['stdev'] = $std_dev;
			}
			
			if ($count < 1) {
				$score_array['high_low_drop'] = 0;
			} elseif ($count < 3) {
				$score_array['high_low_drop'] = $score/$count;
			} else {
				sort($scores);
				array_pop($scores);
				array_shift($scores);
				$score_array['high_low_drop'] = array_sum($scores) / ($count-2);
			}
			
			return $score_array;
		}
				
		function get_speaker_score_in_round($db, $round_id, $speaker_id) {
			$match_obj = new Match;
			$speaker_obj = new Speaker;
			$speaker = $speaker_obj->get_speaker($db, $speaker_id);
			if ($match = $match_obj->get_match_by_team($db, $round_id, $speaker['team_id'])) {
				$speaker_id = $db->escape($speaker_id);

				if ($result = $db->fetch_row("SELECT AVG(speaker_score) FROM speakerresult WHERE match_id='" . $match['match_id'] . "' AND speaker_id='$speaker_id'")) {
					return $result[0];
				}
				return false;
			}
			return false;
		}
		


	// Speaker Tie Breakers //////////////////////////////////////////////////////////////////////////////
		function get_speaker_team_rank($db, $round_id, $speaker_id, $inclusive) {
			$speaker_obj = new Speaker;
			$speaker = $speaker_obj->get_speaker($db, $speaker_id);
			$team_ranks = $this->get_team_ranks($db, $round_id, $inclusive);
			
			$rank = 1;
			$count = 1;
			if ($team_ranks) {
				$last_team = $team_ranks[0];
				
				foreach($team_ranks as $team_rank) {
					if ($team_rank['team_id'] == $speaker['team_id']) {
						return $rank;
					}
					if (team_comparator($team_rank, $last_team) != 0) {
						$rank = $count;
					}
					$count++;
				}
			}
			return $rank;				
		}
	
	
	

	// Compile Results ////////////////////////////////////////////////////////////////////////////////////
				
		function get_team_ranks($db, $round_id, $inclusive) {
			// Comparator

			
			$team_obj = new Team;
			$teams = $team_obj->get_teams($db);
			
			for ($i=0; $i<count($teams); $i++) {
				$teams[$i]['points'] = $this->get_points($db, $round_id, $teams[$i]['team_id'], $inclusive);
				$teams[$i]['score'] = $this->get_team_score($db, $round_id, $teams[$i]['team_id'], $inclusive);
				$teams[$i]['stdev'] = $this->get_team_stdev($db, $round_id, $teams[$i]['team_id'], $inclusive);
				$teams[$i]['gov_strength'] = $this->get_team_gov_strength($db, $round_id, $teams[$i]['team_id'], $inclusive);
			}
			
			// Sort teams
			usort($teams, "team_comparator");

			for($i=0; $i<count($teams); $i++) {
				$teams[$i]['rank'] = $i+1;
			}

			return $teams;
		}
		
		function get_team_rank($db, $round_id, $team_id, $inclusive) {
			$team_ranks = $this->get_team_ranks($db, $round_id, $inclusive);
			for ($i=0; $i<count($team_ranks); $i++) {
				if ($team_ranks[$i]['team_id'] == $team_id) {
					return $i+1;
				}
			}
			return 0;
		}
		
		function get_speaker_ranks($db, $round_id, $inclusive) {
			$speaker_obj = new Speaker;
			$speakers = $speaker_obj->get_speakers($db);
			
			$team_ranks = $this->get_team_ranks($db, $round_id, $inclusive);
			
			for ($i=0; $i<count($speakers); $i++) {
				$score_array = $this->get_full_speaker_score($db, $round_id, $speakers[$i]['speaker_id'], $inclusive);
				$speakers[$i]['score'] = $score_array['score'];
				$speakers[$i]['stdev'] = $score_array['stdev'];
				$speakers[$i]['high_low_drop'] = $score_array['high_low_drop'];
				
				$curr_rank = 1;
				$count = 1;
				if ($team_ranks) {
					$last_team = $team_ranks[0];
					
					foreach($team_ranks as $team_rank) {
						if (team_comparator($team_rank, $last_team) != 0) {
							$curr_rank = $count;
						}
						if ($team_rank['team_id'] == $speakers[$i]['team_id']) {
							$speakers[$i]['team_rank'] = $curr_rank;
						}
						$last_team = $team_rank;
						$count++;
					}
				}
			}
			
			// Sort speakers
			usort($speakers, "speaker_comparator");
			return $speakers;
		}
		
		
		function get_ballots($db, $match_id) {
			$match_id = $db->escape($match_id);
			return $db->fetch_rows("SELECT * FROM ballot WHERE match_id='$match_id'");
		}
		
		function get_results($db, $match_id) {
			$match_id = $db->escape($match_id);
			return $db->fetch_rows("SELECT * FROM result WHERE match_id='$match_id'");		
		}
		
		function get_ballot_result($db, $ballot_id, $team_id) {
			$ballot_id = $db->escape($ballot_id);
			$team_id = $db->escape($team_id);
			return $db->fetch_row("SELECT * FROM result WHERE ballot_id='$ballot_id' AND team_id='$team_id'");
		}

		function get_ballot_results($db, $ballot_id) {
			$ballot_id = $db->escape($ballot_id);
			return $db->fetch_rows("SELECT * FROM result WHERE ballot_id='$ballot_id'");		
		}
		
		function get_ballot_speaker_result($db, $ballot_id, $team_id, $speaker_id) {
			$ballot_result = $this->get_ballot_result($db, $ballot_id, $team_id);
			
			if ($rows = $db->fetch_rows("SELECT * FROM speakerresult WHERE result_id='" . $ballot_result['result_id'] . "'")) {
				foreach($rows as $row) {
					if ($row['speaker_id'] == $speaker_id) {
						return $row['speaker_score'];
					}
				}
			}
			return 0;
		}
		
		function delete_ballot($db, $ballot_id) {
			if ($results = $this->get_ballot_results($db, $ballot_id)) {
				foreach($results as $result) {
					$db->query("DELETE FROM speakerresult WHERE result_id='" . $result['result_id'] . "'");
					$db->query("DELETE FROM result WHERE result_id='" . $result['result_id'] . "'");
				}
			}
			return $db->query("DELETE FROM ballot WHERE ballot_id='$ballot_id'");
		}
		
		function add_ballot($db, $match_id, $gov_team_id, $gov_points, $gov_speaker_a_id, $gov_speaker_b_id, $gov_speaker_a_score, $gov_speaker_b_score,
							$opp_team_id, $opp_points, $opp_speaker_a_id, $opp_speaker_b_id, $opp_speaker_a_score, $opp_speaker_b_score) {
							
			$match_id = $db->escape($match_id);
			
			if ($db->query("INSERT INTO ballot (match_id) VALUES ($match_id)")) {
				if ($row = $db->fetch_row("SELECT MAX(ballot_id) FROM ballot WHERE match_id='$match_id'")) {
					$ballot_id = $row[0];
					
					if ($gov_team_id > 0) {
						$gov_score = $gov_speaker_a_score + $gov_speaker_b_score;
						$db->query("INSERT INTO result (ballot_id, match_id, team_id, team_points, team_score) VALUES ('$ballot_id', '$match_id', '$gov_team_id', '$gov_points', '$gov_score')");

						$result = $db->fetch_row("SELECT result_id FROM result WHERE ballot_id='$ballot_id' AND team_id='$gov_team_id'");
						$result_id = $result['result_id'];
						$db->query("INSERT INTO speakerresult (result_id, match_id, speaker_id, speaker_score) VALUES ('$result_id', '$match_id', '$gov_speaker_a_id', '$gov_speaker_a_score')");
						$db->query("INSERT INTO speakerresult (result_id, match_id, speaker_id, speaker_score) VALUES ('$result_id', '$match_id', '$gov_speaker_b_id', '$gov_speaker_b_score')");
					}
					
					if ($opp_team_id > 0) {
						$opp_score = $opp_speaker_a_score + $opp_speaker_b_score;
						$db->query("INSERT INTO result (ballot_id, match_id, team_id, team_points, team_score) VALUES ('$ballot_id', '$match_id', '$opp_team_id', '$opp_points', '$opp_score')");

						$result = $db->fetch_row("SELECT result_id FROM result WHERE ballot_id='$ballot_id' AND team_id='$opp_team_id'");
						$result_id = $result['result_id'];
						$db->query("INSERT INTO speakerresult (result_id, match_id, speaker_id, speaker_score) VALUES ('$result_id', '$match_id', '$opp_speaker_a_id', '$opp_speaker_a_score')");
						$db->query("INSERT INTO speakerresult (result_id, match_id, speaker_id, speaker_score) VALUES ('$result_id', '$match_id', '$opp_speaker_b_id', '$opp_speaker_b_score')");
					}
				}			
			}
		}
	}
?>