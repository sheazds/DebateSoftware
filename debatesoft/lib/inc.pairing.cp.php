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

	require_once("inc.match.php");
	require_once("inc.round.php");
	require_once("inc.school.php");
	require_once("inc.team.php");
	require_once("inc.region.php");
	require_once("inc.result.php");
	
	class CP_Pairing {
	
		function pair_round($db, $round_id, $match_rooms, $team_ids, $room_ids) {
			$round_obj = new Round;
			$pairing_obj = new Pairing;
			$result_obj = new Result;
			$room_obj = new Room;
			
			$round = $round_obj->get_round($db, $round_id);
			$pairing_prefs = $pairing_obj->get_pairing_pref($db, $round['pairingprefs_id']);
			$team_ranks = $result_obj->get_team_ranks($db, $round_id, false);

			$working_teams = array();
			$working_rooms = array();
			
			// Take out excluded teams from ranks
			foreach ($team_ranks as $curr_team) {
				if (array_search($curr_team['team_id'], $team_ids) !== false) {
					$working_teams[] = $curr_team;
				}
			}

			// Take out excluded rooms from list
			$all_rooms = $room_obj->get_rooms($db);
			
			foreach ($all_rooms as $curr_room) {
				if (array_search($curr_room['room_id'], $room_ids) !== false) {
					$working_rooms[] = $curr_room;
				}
			}

			$brackets = $this->get_brackets($db, $pairing_prefs, $working_teams);
			$brackets = $this->pullup_teams($db, $round_id, $pairing_prefs, $brackets);

			$matches = array();
			foreach($brackets as $bracket) {
				if ($match_set = $this->match_bracket($db, $round_id, $pairing_prefs, $bracket)) {
					$matches = array_merge($matches, $match_set);
				}
			}
			
			if ($match_rooms) {
				$matches = $this->match_rooms($db, $pairing_prefs, $matches, $working_rooms);
			}
			
			return $matches;
		}
		
		function get_brackets($db, $pairing_prefs, $team_ranks) {
			switch ($pairing_prefs['pairingprefs_bracket_type']) {
				case PAIRING_BRACKET_TYPE_NOBRACKET:
					$brackets = array();
					$brackets[] = $team_ranks;
					return $brackets;
				
				case PAIRING_BRACKET_TYPE_WINLOSS:
					$brackets = array();
					
					// Assign teams based on win-loss record
					$curr_bracket = 0;
					$curr_points = $team_ranks[0]['points'];
					$brackets[0] = array();
				
					foreach ($team_ranks as $team_rank) {
						if ($team_rank['points'] != $curr_points) {
							$curr_bracket++;
							$curr_points = $team_rank['points'];
							$brackets[$curr_bracket] = array();
						}
						$brackets[$curr_bracket][] = $team_rank;
					}
					
					return $brackets;
					
				case PAIRING_BRACKET_TYPE_UNIFORM:
					$brackets = array();
					
					// Assign teams based on win-loss record
					$bracket_size = intval($pairing_prefs['pairingprefs_bracket_size']);
					
					for ($i=0; $i<count($team_ranks); $i++) {
						$curr_bracket = $i % $bracket_size;
						if (!isset($brackets[$curr_bracket])) {
							$brackets[$curr_bracket] == array();
						}
						
						$brackets[$curr_bracket][] = $team_ranks[$i];							
					}
					
					foreach ($team_ranks as $team_rank) {
						if ($team_rank['points'] != $curr_points) {
							$curr_bracket++;
							$brackets[$curr_bracket] = array();
						}
						$brackets[$curr_bracket][] = $team_rank;
					}
					
					return $brackets;
					
				case PAIRING_BRACKET_TYPE_CUSTOM:
					$brackets = array();
					$curr_bracket = 0;
					$curr_index = 0;
					
					$bracket_sizes = explode(",", $pairing_prefs['pairingprefs_bracket_size']);
					
					if ($bracket_sizes !== false) {
						foreach($bracket_sizes as $bracket_size) {
							if ($bracket_size == "w" || $bracket_size == "W") {
								// Assign teams based on win-loss record
								
								if ($curr_index < count($team_ranks)) {
									$curr_points = $team_ranks[$curr_index]['points'];
									$brackets[$curr_bracket] = array();
								
									for (true; $curr_index<count($team_ranks); $curr_index++) {
										$team_rank = $team_ranks[$curr_index];
										
										if ($team_rank['points'] != $curr_points) {
											$curr_bracket++;
											$curr_points = $team_rank['points'];
											$brackets[$curr_bracket] = array();
										}
										$brackets[$curr_bracket][] = $team_rank;
									}
								}
							} elseif ($bracket_size == "*") {
								if ($curr_index < count($team_ranks)) {
									$brackets[$curr_bracket] = array();
									for (true; $curr_index<count($team_ranks); $curr_index++) {
										$team_rank = $team_ranks[$curr_index];
										$brackets[$curr_bracket][] = $team_rank;									
									}
									$curr_bracket++;
								}
							} else {
								if ($curr_index < count($team_ranks)) {
									$brackets[$curr_bracket] = array();
									for ($i=0; $i<intval($bracket_size); $i++) {
										if ($curr_index < count($team_ranks)) {
											$team_rank = $team_ranks[$curr_index];
											$curr_index++;
											
											$brackets[$curr_bracket][] = $team_rank;
										}
									}
									$curr_bracket++;
								}
							}
						}
					}

					return $brackets;
			}
		}
		
		function pullup_teams($db, $round_id, $pairing_prefs, $brackets) {
			$match_obj = new Match;
			
			for ($i=0; $i<count($brackets)-1; $i++) {
				// If number of teams in current bracket is odd
				if ((count($brackets[$i]) > 0 && $brackets[$i][0] != null) && (count($brackets[$i]) % 2) != 0) {
					// Get pullup
					$pullup = "";
					$found_pullup = false;
					 
					switch($pairing_prefs['pairingprefs_pullup_type']) {

						case PAIRING_PULLUP_TYPE_TOP:
						
							$j = 0;
							
							while(!$found_pullup && ($j < count($brackets[$i+1]))) {
								$curr_team = $brackets[$i+1][$j];
								
								// If team has not been pulled up before
								if (count($match_obj->get_matches_by_pullup($db, $round_id, $curr_team['team_id'], false) < 1)) {
									$pullup = $curr_team;
									
									// Remove team from pullup bracket and place in current bracket
									$brackets[$i+1] = $this->array_trim($brackets[$i+1], $j);
									$found_pullup = true;
								}
								$j++;
							}
							if (!$found_pullup) {
								$pullup = array_shift($brackets[$i+1]);
							}

							break;
							
							
								
						case PAIRING_PULLUP_TYPE_MIDDLE:

							$j = intval(count($brackets[$i+1]) / 2);
							
							while(!$found_pullup && ($j < count($brackets[$i+1]))) {
								$curr_team = $brackets[$i+1][$j];
								
								// If team has not been pulled up before
								if (count($match_obj->get_matches_by_pullup($db, $round_id, $curr_team['team_id'], false) < 1)) {
									$pullup = $curr_team;
									
									// Remove team from pullup bracket and place in current bracket
									$brackets[$i+1] = $this->array_trim($brackets[$i+1], $j);
									$found_pullup = true;
								}
								$j++;
							}
							if (!$found_pullup) {
								$index = intval(count($brackets[$i+1]) / 2);
								$pullup = $brackets[$i+1][$index];
								$brackets[$i+1] = $this->array_trim($brackets[$i+1], $index);
							}

							break;
														
						
						
						case PAIRING_PULLUP_TYPE_BOTTOM:	
						
							$j = count($brackets[$i+1]) - 1 ;
							
							while(!$found_pullup && ($j >= 0)) {
								$curr_team = $brackets[$i+1][$j];
								
								// If team has not been pulled up before
								if (count($match_obj->get_matches_by_pullup($db, $round_id, $curr_team['team_id'], false) < 1)) {
									$pullup = $curr_team;
									
									// Remove team from pullup bracket and place in current bracket
									$brackets[$i+1] = $this->array_trim($brackets[$i+1], $j);
									$found_pullup = true;
								}
								$j--;
							}

							if (!$found_pullup) {
								$pullup = array_pop($brackets[$i+1]);
							}
							
							break;
					}
					$pullup['is_pullup'] = true;

					// Assign pullup
					if (intval($pairing_prefs['pairingprefs_pullup_reseed']) == 1) {
						// Reseed Pullup
						$found_pos = false;
						$k = 0;
						while (!$found_pos && $k<count($brackets[$i])) {
							if ($this->compare_team_scores($brackets[$i][$k], $pullup) > 0) {
								$found_pos = true;
							} else {
								$k++;
							}
						}
						$brackets[$i] = $this->array_insert($brackets[$i], $k, $pullup);
						
					} else {
						// Place at bottom of bracket
						$brackets[$i][] = $pullup;
					}
				}			
			}

			return $brackets;
		}
		
		function match_bracket($db, $round_id, $pairing_prefs, $bracket) {
			$result_obj = new Result;
			$match_obj = new Match;
			$matches = array();
			
			switch($pairing_prefs['pairingprefs_matching_type']) {
				case PAIRING_MATCHING_RANDOM:
					$teams = $bracket;
					while (count($teams) >= 2) {
						$target_index = rand(0, count($teams)-1);
						$team = $teams[$target_index];
						$teams = $this->array_trim($teams, $target_index);

						$team_a = $team;
						$random_index = rand(0, count($teams)-1);
						$team_b = $teams[$random_index];
						$teams = $this->array_trim($teams, $random_index);
						
						$team_a_govs = count($match_obj->get_gov_matches_by_team($db, $round_id, $team_a['team_id'], false));
						$team_b_govs = count($match_obj->get_gov_matches_by_team($db, $round_id, $team_b['team_id'], false));
						
						$match = "";
						
						if ($team_a_govs > $team_b_govs) {
							$match = array("gov" => $team_b, "opp" => $team_a);
						} elseif ($team_a_govs < $team_b_govs) {
							$match = array("gov" => $team_a, "opp" => $team_b);
						} else {
							if (rand(0, 1) == 0) {
								$match = array("gov" => $team_a, "opp" => $team_b);
							} else {
								$match = array("gov" => $team_b, "opp" => $team_a);
							}
						}
						
						$matches[] = $match;
					}
	
					// Find problem matches and fix
					
					// Iterate over matches
					$index = 0;
					while($index < count($matches)) {
						$curr_match = $matches[$index];
						
						// If a conflict exists in the current match
						if ($this->conflict_exists($db, $pairing_prefs, $round_id, $curr_match['gov'], $curr_match['opp'])) {
						
							// Find the next match that has teams that do not conflict and swap the appropriate teams
							$swap_made = false;
							$swap_index = 0;
							while (!$swap_made && $swap_index<count($matches)) {
								$swap_match = $matches[$swap_index];
								if ($curr_match['gov']['team_id'] != $swap_match['gov']['team_id']) {
								
									// Swap Gov with another Gov
									if (!$this->conflict_exists($db, $pairing_prefs, $round_id, $curr_match['gov'], $swap_match['opp']) &&
										!$this->conflict_exists($db, $pairing_prefs, $round_id, $swap_match['gov'], $curr_match['opp'])) {
										
										$swap_team = $matches[$index]['gov'];
										$matches[$index]['gov'] = $matches[$swap_index]['gov'];
										$matches[$swap_index]['gov'] = $swap_team;

										$swap_made = true;
										

									// Swap Gov with an Opp
									} elseif (!$this->conflict_exists($db, $pairing_prefs, $round_id, $swap_match['gov'], $curr_match['gov']) &&
											  !$this->conflict_exists($db, $pairing_prefs, $round_id, $curr_match['opp'], $swap_match['opp'])) {
									
										$swap_team = $matches[$index]['gov'];
										$matches[$index]['gov'] = $matches[$swap_index]['opp'];
										$matches[$swap_index]['opp'] = $swap_team;

										$swap_made = true;
									}
								}
								$swap_index++;
							}
							// If a swap was made, restart conflict check as matches have changed
							if ($swap_made) {
								$index = 0;
							} else {
								$index++;
							}
						} else {
							$index++;
						}						
					}
					
					break;
				
				case PAIRING_MATCHING_HIGHHIGH:
					$teams = $bracket;
					while (count($teams) >= 2) {
						$team_a = array_shift($teams);
						$team_b = array_shift($teams);
						
						$team_a_govs = count($match_obj->get_gov_matches_by_team($db, $round_id, $team_a['team_id'], false));
						$team_b_govs = count($match_obj->get_gov_matches_by_team($db, $round_id, $team_b['team_id'], false));
							
						$match = "";
							
						if ($team_a_govs > $team_b_govs) {
							$match = array("gov" => $team_b, "opp" => $team_a);
						} elseif ($team_a_govs < $team_b_govs) {
							$match = array("gov" => $team_a, "opp" => $team_b);
						} else {
							if (rand(0, 1) == 0) {
								$match = array("gov" => $team_a, "opp" => $team_b);
							} else {
								$match = array("gov" => $team_b, "opp" => $team_a);
							}
						}
						
						$matches[] = $match;
					}
					
					$matches = $this->fix_conficts($db, $pairing_prefs, $round_id, $matches);
					
					break;
				
				case PAIRING_MATCHING_HIGHLOW:
					$teams = $bracket;

					while (count($teams) >= 2) {
						$team_a = array_shift($teams);
						$team_b = array_pop($teams);
						
						$team_a_govs = count($match_obj->get_gov_matches_by_team($db, $round_id, $team_a['team_id'], false));
						$team_b_govs = count($match_obj->get_gov_matches_by_team($db, $round_id, $team_b['team_id'], false));
							
						$match = "";

						if ($team_a_govs > $team_b_govs) {
							$match = array("gov" => $team_b, "opp" => $team_a);
						} elseif ($team_a_govs < $team_b_govs) {
							$match = array("gov" => $team_a, "opp" => $team_b);
						} else {
							if (rand(0, 1) == 0) {
								$match = array("gov" => $team_a, "opp" => $team_b);
							} else {
								$match = array("gov" => $team_b, "opp" => $team_a);
							}
						}
						$matches[] = $match;
					}

					$matches = $this->fix_conficts($db, $pairing_prefs, $round_id, $matches);
			
					break;
			}
			
			return $matches;
		}
		
		function fix_conficts($db, $pairing_prefs, $round_id, $matches) {
			$result_obj = new Result;

			// Iterate over matches
			$index = 0;
			while ($index<count($matches)) {
				// If conflict exists, fix it
				if ($this->conflict_exists($db, $pairing_prefs, $round_id, $matches[$index]["gov"], $matches[$index]["opp"])) {
				
					// Check if a straight swap will fix the conflict
					if (!$this->conflict_exists($db, $pairing_prefs, $round_id, $matches[$index]["opp"], $matches[$index]["gov"])) {
						$curr_team = $matches[$index]["gov"];
						$matches[$index]["gov"] = $matches[$index]["opp"];
						$matches[$index]["opp"] = $curr_team;
						
						$index++;
					
					} else {
						// Get the current team and its rank
						$curr_team = $matches[$index]["gov"];
						$curr_rank = $result_obj->get_team_rank($db, $round_id, $curr_team['team_id'], false);
						
						$rank_differential = 1;
						$swap_made = false;

						// Get swap matches by proximity to the team's rank
						while(!$swap_made && $rank_differential<(count($matches)*2)-1) {
							$swap_index = 0;

							// Find closest match by rank
							while(!$swap_made && $swap_index<count($matches)) {
								$swap_match = $matches[$swap_index];
								$gov_rank = $swap_match['gov']['rank']; //$result_obj->get_team_rank($db, $round_id, $swap_match['gov']['team_id'], false);
								$opp_rank = $swap_match['opp']['rank']; //$result_obj->get_team_rank($db, $round_id, $swap_match['opp']['team_id'], false);

								// If target swap team is Gov
								if (abs($curr_rank - $gov_rank) == $rank_differential) {
									if (!$this->conflict_exists($db, $pairing_prefs, $round_id, $curr_team, $swap_match["opp"]) &&
										!$this->conflict_exists($db, $pairing_prefs, $round_id, $swap_match["gov"], $matches[$index]["opp"])) {
										$temp = $matches[$index]["gov"];
										$matches[$index]["gov"] = $matches[$swap_index]["gov"];
										$matches[$swap_index]["gov"] = $temp;
										
										$swap_made = true;
										
									} else {
										$swap_index++;
									}
									
								// If target swap team is Opp
								} elseif (abs($curr_rank - $opp_rank) == $rank_differential) {
									if (!$this->conflict_exists($db, $pairing_prefs, $round_id, $swap_match["gov"], $curr_team) &&
										!$this->conflict_exists($db, $pairing_prefs, $round_id, $swap_match["opp"], $matches[$index]["opp"])) {
										$temp = $matches[$index]["gov"];
										$matches[$index]["gov"] = $matches[$swap_index]["opp"];
										$matches[$swap_index]["opp"] = $temp;
										
										$swap_made = true;
										
									} else {
										$swap_index++;
									}
								} else {
									$swap_index++;
								}
							}

							$rank_differential++;
						}
//						if ($swap_made) {
//							$index = 0;
//						} else {
							$index++;
//						}

					}
				} else {
					$index++;
				}
			}
			return $matches;
		}
		
		function conflict_exists($db, $pairing_prefs, $round_id, $gov_team, $opp_team) {
			$match_obj = new Match;
			
			if (intval($pairing_prefs['pairingprefs_avoid_school_conflict']) == 1) {
				if ($gov_team['school_id'] == $opp_team['school_id']) {
					return true;
				}
			}

			if (intval($pairing_prefs['pairingprefs_avoid_region_conflict']) == 1) {
				$school_obj = new School;
				$gov_team_school = $school_obj->get_school($db, $gov_team['school_id']);
				$opp_team__school = $school_obj->get_school($db, $opp_team['school_id']);
				
				if ($gov_team_school['region_id'] == $opp_team__school['region_id']) {
					return true;
				}
			}
			
			if (intval($pairing_prefs['pairingprefs_avoid_pullup_conflict']) == 1) {
				if (isset($gov_team['is_pullup']) && $gov_team['is_pullup'] == true) {
					$pullup_matches = $match_obj->get_matches_by_team($db, $round_id, $opp_team['team_id'], false);
					foreach($pullup_matches as $pullup_match) {
						if ($pullup_match['pullup_team_id'] > 0) {
							return true;
						}
					}
				}
				
				if (isset($opp_team['is_pullup']) && $opp_team['is_pullup'] == true) {
					$pullup_matches = $match_obj->get_matches_by_team($db, $round_id, $gov_team['team_id'], false);
					foreach($pullup_matches as $pullup_match) {
						if ($pullup_match['pullup_team_id'] > 0) {
							return true;
						}
					}
				}
			}
			
			if (intval($pairing_prefs['pairingprefs_avoid_previously_paired_conflict']) == 1) {
				$previous_matches = $match_obj->get_matches_by_team($db, $round_id, $gov_team['team_id'], false);
				foreach ($previous_matches as $previous_match) {
					if ($previous_match['match_gov_team_id'] == $opp_team['team_id'] || $previous_match['match_opp_team_id'] == $opp_team['team_id']) {
						return true;
					}
				}			
			}
			
			$gov_matches = $match_obj->get_gov_matches_by_team($db, $round_id, $gov_team['team_id'], true);
			if (count($gov_matches) >= intval($pairing_prefs['pairingprefs_max_allowable_govs'])) {
				return true;
			}
			
			return false;
		}
		
		
		function match_rooms($db, $pairing_prefs, $matches, $rooms) {
			$max_count = count($matches);
			if (count($rooms) < $max_count) {
				$max_count = count($rooms);
			}
			
			for ($i=0; $i<$max_count; $i++) {
				$target_index = 0;
				if (intval($pairing_prefs['pairingprefs_randomize_rooms']) == 1) {
					$target_index = rand(0, count($rooms)-1);
				}
				$room = $rooms[$target_index];
				$rooms = $this->array_trim($rooms, $target_index);
				
				$matches[$i]['room_id'] = $room['room_id'];
			}
			return $matches;		
		}
		
		function array_trim ( $array, $index ) {
			if ( is_array ( $array ) ) {
				unset ( $array[$index] );
				array_unshift ( $array, array_shift ( $array ) );
				return $array;
			} else {
				return false;
			}
		}
		
		function array_insert($array, $index, $value) {
		   $cnt = count($array);
		 
		   for( $i = $cnt-1; $i >= $index; --$i ) {
		       $array[ $i + 1 ] = $array[ $i ];
		   }
		   $array[$index] = $value;
		   
		   return $array;
		}		
		
		function compare_team_scores($a, $b) {
			if ($a['score'] > $b['score']) {
				return -1;
			} elseif ($a['score'] < $b['score']) {
				return 1;
			} else {
				if ($a['stdev'] < $b['stdev']) {
					return -1;
				} elseif ($a['stdev'] > $b['stdev']) {
					return 1;
				} else {
					if ($a['gov_strength'] < $b['gov_strength']) {
						return -1;
					} elseif ($a['gov_strength'] > $b['gov_strength']) {
						return 1;
					} else {
						return strcmp($a["team_name"], $b["team_name"]);
					}
				}
			}
			
			return 0;
		}
	}
?>