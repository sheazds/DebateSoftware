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
	require_once("inc.room.php");
	require_once("inc.match.php");
	
	// Pairing Library
	class Pairing {
	
		function get_pairing_prefs($db) {
			return $db->fetch_rows("SELECT * FROM pairing_preference ORDER BY pp_name");
		}
		
		function get_pairing_pref($db, $pairingprefs_id) {
			$pairingprefs_id = $db->escape($pairingprefs_id);
			return $db->fetch_row("SELECT * FROM pairing_preference WHERE pp_id='$pairingprefs_id'");
		}
		
		function can_delete_prefs($db, $pairingprefs_id) {
			$pairingprefs_id = $db->escape($pairingprefs_id);
			$row = $db->fetch_row("SELECT COUNT(*) FROM round WHERE pp_id='$pairingprefs_id'");
			if ($row[0] > 0) {
				return false;
			}
			return true;
		}
		
		function delete_prefs($db, $pairingprefs_id) {
			$pairingprefs_id = $db->escape($pairingprefs_id);
			return $db->query("DELETE FROM pairing_preference WHERE pp_id='$pairingprefs_id'");
		}
		
		function prefs_exists($db, $pairingprefs_name) {
			$pairingprefs_name = $db->escape(strtoupper($pairingprefs_name));
			$row = $db->fetch_row("SELECT COUNT(*) FROM pairing_preference WHERE UCASE(pp_name)='$pairingprefs_name'");
			if ($row[0] > 0) {
				return true;
			}
			return false;
		}

		function other_prefs_exists($db, $pairingprefs_id, $pairingprefs_name) {
			$pairingprefs_id = $db->escape($pairingprefs_id);
			$pairingprefs_name = $db->escape(strtoupper($pairingprefs_name));
			$row = $db->fetch_row("SELECT COUNT(*) FROM pairing_preference WHERE pp_id<>'$pairingprefs_id' AND UCASE(pp_name)='$pairingprefs_name'");
			if ($row[0] > 0) {
				return true;
			}
			return false;
		}
		
		
		/*function add_preferences($db, $name, $bracket_type, $bracket_size, $pullup_type, $pullup_reseed, $matching_type, 
								 $avoid_school_conflict, $avoid_region_conflict, $avoid_pullup_conflict, $avoid_judge_conflict,
								 $avoid_previously_paired_conflict, $max_allowable_govs, $randomize_rooms) {

			$name = $db->escape($name);
			$bracket_type = $db->escape($bracket_type);
			$bracket_size = $db->escape($bracket_size);
			$pullup_type = $db->escape($pullup_type);
			$pullup_reseed = ($pullup_reseed == true) ? "1" : "0";
			$matching_type = $db->escape($matching_type);
			$avoid_school_conflict = ($avoid_school_conflict == true) ? "1" : "0";
			$avoid_region_conflict = ($avoid_region_conflict == true) ? "1" : "0";
			$avoid_pullup_conflict = ($avoid_pullup_conflict == true) ? "1" : "0";
			$avoid_judge_conflict = ($avoid_judge_conflict == true) ? "1" : "0";
			$avoid_previously_paired_conflict = ($avoid_previously_paired_conflict == true) ? "1" : "0";
			$max_allowable_govs = $db->escape($max_allowable_govs);
			$randomize_rooms = ($randomize_rooms == true) ? "1" : "0";
			
			$sql_string = "INSERT INTO pairingprefs (pairingprefs_name, pairingprefs_bracket_type, pairingprefs_bracket_size, " .
						  "pairingprefs_pullup_type, pairingprefs_pullup_reseed, pairingprefs_matching_type, " . 
						  "pairingprefs_avoid_school_conflict, pairingprefs_avoid_region_conflict, pairingprefs_avoid_pullup_conflict, " .
						  "pairingprefs_avoid_judge_conflict, pairingprefs_avoid_previously_paired_conflict, " .
						  "pairingprefs_max_allowable_govs, pairingprefs_randomize_rooms) VALUES " .
						  "('$name', '$bracket_type', '$bracket_size', '$pullup_type', '$pullup_reseed', '$matching_type', '$avoid_school_conflict', " .
						  "'$avoid_region_conflict', '$avoid_pullup_conflict', '$avoid_judge_conflict', '$avoid_previously_paired_conflict', " .
						  "'$max_allowable_govs', '$randomize_rooms')";

			return $db->query($sql_string);			
		}

		function edit_preferences($db, $prefs_id, $name, $bracket_type, $bracket_size, $pullup_type, $pullup_reseed, $matching_type, 
								 $avoid_school_conflict, $avoid_region_conflict, $avoid_pullup_conflict, $avoid_judge_conflict,
								 $avoid_previously_paired_conflict, $max_allowable_govs, $randomize_rooms) {

			$prefs_id = $db->escape($prefs_id);
			$name = $db->escape($name);
			$bracket_type = $db->escape($bracket_type);
			$bracket_size = $db->escape($bracket_size);
			$pullup_type = $db->escape($pullup_type);
			$pullup_reseed = ($pullup_reseed == true) ? "1" : "0";
			$matching_type = $db->escape($matching_type);
			$avoid_school_conflict = ($avoid_school_conflict == true) ? "1" : "0";
			$avoid_region_conflict = ($avoid_region_conflict == true) ? "1" : "0";
			$avoid_pullup_conflict = ($avoid_pullup_conflict == true) ? "1" : "0";
			$avoid_judge_conflict = ($avoid_judge_conflict == true) ? "1" : "0";
			$avoid_previously_paired_conflict = ($avoid_previously_paired_conflict == true) ? "1" : "0";
			$max_allowable_govs = $db->escape($max_allowable_govs);
			$randomize_rooms = ($randomize_rooms == true) ? "1" : "0";	
			
			$sql_string = "UPDATE pairingprefs SET " .
						  "pairingprefs_name='$name', " .
						  "pairingprefs_bracket_type='$bracket_type', " .
						  "pairingprefs_bracket_size='$bracket_size', " .
						  "pairingprefs_pullup_type='$pullup_type', " .
						  "pairingprefs_pullup_reseed='$pullup_reseed', " .
						  "pairingprefs_matching_type='$matching_type', " .
						  "pairingprefs_avoid_school_conflict='$avoid_school_conflict', " .
						  "pairingprefs_avoid_region_conflict='$avoid_region_conflict', " .
						  "pairingprefs_avoid_pullup_conflict='$avoid_pullup_conflict', " .
						  "pairingprefs_avoid_judge_conflict='$avoid_judge_conflict', " .
						  "pairingprefs_avoid_previously_paired_conflict='$avoid_previously_paired_conflict', " .
						  "pairingprefs_max_allowable_govs='$max_allowable_govs', " .
						  "pairingprefs_randomize_rooms='$randomize_rooms' " .
						  "WHERE pairingprefs_id='$prefs_id'";
	
			return $db->query($sql_string);
		}*/


	}

	define("PAIRING_BRACKET_TYPE_NOBRACKET", 0);
	define("PAIRING_BRACKET_TYPE_WINLOSS", 1);
	define("PAIRING_BRACKET_TYPE_UNIFORM", 2);
	define("PAIRING_BRACKET_TYPE_CUSTOM", 99);
	
	define("PAIRING_PULLUP_TYPE_TOP", 1);
	define("PAIRING_PULLUP_TYPE_MIDDLE", 2);
	define("PAIRING_PULLUP_TYPE_BOTTOM", 3);
	
	define("PAIRING_MATCHING_RANDOM", 0);
	define("PAIRING_MATCHING_HIGHHIGH", 1);
	define("PAIRING_MATCHING_HIGHLOW", 2);
?>