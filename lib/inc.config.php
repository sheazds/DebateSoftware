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


	// Database Constants
	
	define("DB_HOST", "localhost");

	define("DB_USER", "Shahana"); //this is the default username
	define("DB_PASS", "asIf1969"); //If a MySQL password has been set, put it here
	define("DB_NAME", "attempt1"); //Put the name of the child here 

	define("TOURNAMENT_NAME", "Tournament Name");

	define("MIN_SCORE", 36);
	define("MAX_SCORE", 42);



    // DO NOT EDIT BELOW THIS LINE! 






	// Web Site Constants
	require_once("inc.database.php");


	function team_comparator($a, $b) {
		if ($a['points'] > $b['points']) {
			return -1;
		} elseif ($a['points'] < $b['points']) {
			return 1;
		} else {
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
						return 0;
					}
				}
			}
		}
		
		return 0;
	}

	function speaker_comparator($a, $b) {
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
				if ($a['high_low_drop'] > $b['high_low_drop']) {
					return -1;
				} elseif ($a['stdev'] < $b['stdev']) {
					return 1;
				} else {
					if ($a['team_rank'] < $b['team_rank']) {
						return -1;
					} elseif ($a['team_rank'] > $b['team_rank']) {
						return 1;
					} else {
						return 0;
					}
				}
			}
		}
		
		return 0;
	}
?>