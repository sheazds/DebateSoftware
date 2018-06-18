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
	
	// Rounds
	class Round {
	
		function num_rounds($db) {
			$row = $db->fetch_row("SELECT COUNT(*) FROM round");
			return $row[0];
		}

		function get_rounds($db) {
			return $db->fetch_rows("SELECT * FROM round ");
		}
		
		function get_rounds_collection($db, $round_id, $inclusive) {
			$round = $this->get_round($db, $round_id);
			
			if ($inclusive) {
				return $db->fetch_rows("SELECT * FROM round WHERE round_id<='" . $round['round_id'] . "' ORDER BY round_id ASC");
			} else {
				return $db->fetch_rows("SELECT * FROM round WHERE round_id<'" . $round['round_id'] . "' ORDER BY round_id ASC");
			}			
		}

		function get_previous_round($db, $round_id) {
			$round = $this->get_round($db, $round_id);
			return $db->fetch_row("SELECT * FROM round WHERE round_id<'" . $round['round_id'] . "' ORDER BY round_id DESC");
		}
		
		function get_round_num($db, $round_id) {
			$round = $this->get_round($db, $round_id);
			$row = $db->fetch_row("SELECT COUNT(*) FROM round WHERE round_id<='" . $round['round_id'] . "'");
			return $row[0];
		}

		function get_round($db, $round_id) {
			$round_id = $db->escape($round_id);
			return $db->fetch_row("SELECT * FROM round WHERE round_id='$round_id'");
		}
		
		function round_exists($db, $round_name) {
			$round_name = $db->escape(strtoupper($round_name));
			$row = $db->fetch_row("SELECT COUNT(*) FROM round WHERE UCASE(round_name)='$round_name'");
			if ($row[0] > 0) {
				return true;
			}
			return false;
		}
		
		function other_round_exists($db, $round_id, $round_name) {
			$round_id = $db->escape($round_id);
			$round_name = $db->escape(strtoupper($round_name));
			$row = $db->fetch_row("SELECT COUNT(*) FROM round WHERE round_id<>'$round_id' AND UCASE(round_name)='$round_name'");
			if ($row[0] > 0) {
				return true;
			}
			return false;
		}
		
		function add_round($db, $round_name, $pairingprefs_id) {
			$round_name = $db->escape($round_name);
			$pairingprefs_id = $db->escape($pairingprefs_id);
			
			$round_order = 1;
			if ($this->num_rounds($db) > 0) {
				$row = $db->fetch_row("SELECT MAX(round_order) FROM round");
				$round_order = ++$row[0];
			}
			
			return $db->query("INSERT INTO round (round_name, round_order, pairingprefs_id) VALUES ('$round_name', '$round_order', '$pairingprefs_id')");
		}

		function edit_round($db, $round_id, $round_name, $pairingprefs_id) {
			$round_id = $db->escape($round_id);
			$round_name = $db->escape($round_name);
			$pairingprefs_id = $db->escape($pairingprefs_id);
			
			return $db->query("UPDATE round SET round_name='$round_name', pairingprefs_id='$pairingprefs_id' WHERE round_id='$round_id'");
		}
		
		function delete_round($db, $round_id) {
			$match_obj = new Match;
			$matches = $match_obj->get_matches($db, $round_id);
			foreach ($matches as $match) {
				$match_obj->delete_match($db, $match['match_id']);
			}
			
			$round_id = $db->escape($round_id);
			return $db->query("DELETE FROM round WHERE round_id='$round_id'");
		}
		
		function move_round_up($db, $round_id) {
			$round = $this->get_round($db, $round_id);
			$rows = $db->fetch_rows("SELECT * FROM round WHERE round_order<" . $round['round_order'] . " ORDER BY round_order DESC");
			if ($rows && count($rows) > 0) {
				$swap_round = $rows[0];
				$db->query("UPDATE round SET round_order='" . $round['round_order'] . "' WHERE round_id='" . $swap_round['round_id'] . "'");
				$db->query("UPDATE round SET round_order='" . $swap_round['round_order'] . "' WHERE round_id='" . $round['round_id'] . "'");
			}
		}
		
		function move_round_down($db, $round_id) {
			$round = $this->get_round($db, $round_id);
			$rows = $db->fetch_rows("SELECT * FROM round WHERE round_order>" . $round['round_order'] . " ORDER BY round_order ASC");
			if ($rows && count($rows) > 0) {
				$swap_round = $rows[0];
				$db->query("UPDATE round SET round_order='" . $round['round_order'] . "' WHERE round_id='" . $swap_round['round_id'] . "'");
				$db->query("UPDATE round SET round_order='" . $swap_round['round_order'] . "' WHERE round_id='" . $round['round_id'] . "'");
			}		
		}
	}
?>