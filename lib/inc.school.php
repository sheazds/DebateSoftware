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

	// Schools
	class School {

		function num_schools($db) {
			$row = $db->fetch_row("SELECT COUNT(*) FROM school");
			return $row[0];
		}

		function get_schools($db) {
			$sql_string = "SELECT * FROM school ORDER BY school_name";
			return $db->fetch_rows($sql_string);
		}
		
		function get_num_schools_by_region($db, $region_id) {
			$region_id = $db->escape($region_id);
			$row = $db->fetch_row("SELECT COUNT(*) FROM school WHERE region_id='$region_id'");
			return intval($row[0]);
		}


		function school_exists($db, $school_name) {
			$school_name = $db->escape(strtoupper($school_name));
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM school WHERE UCASE(school_name)='$school_name'")) {
				if ($row[0] == 0) {
					return false;
				}
			}
			return true;
		}

		function other_school_exists($db, $school_id, $school_name) {
			$school_id = $db->escape($school_id);
			$school_name = $db->escape(strtoupper($school_name));
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM school WHERE school_id<>'$school_id' AND UCASE(school_name)='$school_name'")) {
				if ($row[0] == 0) {
					return false;
				}
			}
			return true;
		}		
		
		function add_school($db, $school_name, $region_id) {
			$school_name = $db->escape($school_name);
			$region_id = $db->escape($region_id);
			return $db->query("INSERT INTO school (school_name, region_id) VALUES ('$school_name', '$region_id')");
		}
		
		function get_school($db, $school_id) {
			$school_id = $db->escape($school_id);
			return $db->fetch_row("SELECT * FROM school WHERE school_id='$school_id'");
		}
		
		function get_school_name($db, $school_id) {
			$school = $this->get_school($db, $school_id);
			return $school['school_name'];
		}
		
		function delete_school($db, $school_id) {
			$school_id = $db->escape($school_id);
			return $db->query("DELETE FROM school WHERE school_id='$school_id'");
		}
		
		function edit_school($db, $school_id, $region_id, $school_name) {
			$region_id = $db->escape($region_id);
			$school_id = $db->escape($school_id);
			$school_name = $db->escape($school_name);
			return $db->query("UPDATE school SET school_name='$school_name', region_id='$region_id' WHERE school_id='$school_id'");
		}

	}
?>
