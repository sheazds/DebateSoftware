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

	// Regions
	class Region {

		function num_regions($db) {
			$row = $db->fetch_row("SELECT COUNT(*) FROM region");
			return $row[0];
		}

		function get_regions($db) {
			$sql_string = "SELECT * FROM region ORDER BY region_name";
			return $db->fetch_rows($sql_string);
		}
		
		function region_exists($db, $region_name) {
			$region_name = $db->escape(strtoupper($region_name));
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM region WHERE UCASE(region_name)='$region_name'")) {
				if ($row[0] == 0) {
					return false;
				}
			}
			return true;
		}

		function other_region_exists($db, $region_id, $region_name) {
			$region_id = $db->escape($region_id);
			$region_name = $db->escape(strtoupper($region_name));
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM region WHERE region_id<>'$region_id' AND UCASE(region_name)='$region_name'")) {
				if ($row[0] == 0) {
					return false;
				}
			}
			return true;
		}		
		
		function add_region($db, $region_name) {
			$region_name = $db->escape($region_name);
			return $db->query("INSERT INTO region (region_name) VALUES ('$region_name')");
		}
		
		function get_region($db, $region_id) {
			$region_id = $db->escape($region_id);
			return $db->fetch_row("SELECT * FROM region WHERE region_id='$region_id'");
		}
		
		function delete_region($db, $region_id) {
			$region_id = $db->escape($region_id);
			return $db->query("DELETE FROM region WHERE region_id='$region_id'");
		}
		
		function edit_region($db, $region_id, $region_name) {
			$region_id = $db->escape($region_id);
			$region_name = $db->escape($region_name);
			return $db->query("UPDATE region SET region_name='$region_name' WHERE region_id='$region_id'");
		}

	}
?>