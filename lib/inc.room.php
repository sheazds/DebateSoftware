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

	// Rooms
	class Room {

		function num_rooms($db) {
			$row = $db->fetch_row("SELECT COUNT(*) FROM room");
			return $row[0];
		}

		function get_rooms($db) {
			$sql_string = "SELECT * FROM room ORDER BY room_priority DESC, room_name ASC";
			return $db->fetch_rows($sql_string);
		}
		
		function room_exists($db, $room_name) {
			$room_name = $db->escape(strtoupper($room_name));
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM room WHERE UCASE(room_name)='$room_name'")) {
				if ($row[0] == 0) {
					return false;
				}
			}
			return true;
		}

		function other_room_exists($db, $room_id, $room_name) {
			$room_id = $db->escape($room_id);
			$room_name = $db->escape(strtoupper($room_name));
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM room WHERE room_id<>'$room_id' AND UCASE(room_name)='$room_name'")) {
				if ($row[0] == 0) {
					return false;
				}
			}
			return true;
		}		
		
		function add_room($db, $room_name, $room_priority) {
			$room_name = $db->escape($room_name);
			$room_priority = $db->escape($room_priority);
			return $db->query("INSERT INTO room (room_name, room_priority) VALUES ('$room_name', '$room_priority')");
		}
		
		function get_room($db, $room_id) {
			$room_id = $db->escape($room_id);
			return $db->fetch_row("SELECT * FROM room WHERE room_id='$room_id'");
		}
		
		function delete_room($db, $room_id) {
			$room_id = $db->escape($room_id);
			return $db->query("DELETE FROM room WHERE room_id='$room_id'");
		}
		
		function can_delete($db, $room_id) {
			$room_id = $db->escape($room_id);
			if ($row = $db->fetch_row("SELECT COUNT(*) FROM matchup WHERE room_id='$room_id'")) {
				if ($row[0] > 0) {
					return false;
				}
			}
			return true;
		}
		
		function edit_room($db, $room_id, $room_name, $room_priority) {
			$room_id = $db->escape($room_id);
			$room_name = $db->escape($room_name);
			$room_priority = $db->escape($room_priority);
			return $db->query("UPDATE room SET room_name='$room_name', room_priority='$room_priority' WHERE room_id='$room_id'");
		}

	}
?>