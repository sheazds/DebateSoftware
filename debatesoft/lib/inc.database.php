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

	// Database Function Library
	
	//require_once("inc.config.php");

	class Database {
		public $con ;
	
		function open() {
			$this->con = mysqli_connect(DB_HOST, DB_USER, DB_PASS,DB_NAME);
			//mysqli_select_db(DB_NAME);
		}
		
		function close() {
			if ($this->con) {
				mysqli_close($con);
			}
		}
		
		function escape($string) {
			return mysqli_real_escape_string(mysqli_connect(DB_HOST, DB_USER, DB_PASS,DB_NAME), $string);
		}
		
		function query($sql_string) {
			if (!$this->con) {
				$this->open();
			}
			
			if (mysqli_query($this->con, $sql_string)) {
				return true;
			} else {
				return false;
			}
		}
		
		function fetch_rows($sql_string) {
			if (!$this->con) {
				$this->open();
			}

			if ($result = mysqli_query($this->con, $sql_string)) {
				$rows = array();
				while($row = mysqli_fetch_array($result)) {
					$rows[] = $row;
				}
				return $rows;
			} else {
				return false;
			}
		}
		
		function fetch_row($sql_string) {
			if (!$this->con) {
				$this->open();
			}
			
			if ($result = mysqli_query($this->con, $sql_string)) {
				if (mysqli_num_rows($result) > 0) {
					return mysqli_fetch_array($result);
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}
?>