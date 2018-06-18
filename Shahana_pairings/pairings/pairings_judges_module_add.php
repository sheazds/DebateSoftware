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

	session_start();
	
	require_once("../lib/inc.config.php");
	require_once("../lib/inc.match.php");

	$db_obj = new Database;
	$match_obj = new Match;
	
	$round_id = $_GET['round_id'];
	$match_id = $_GET['match_id'];
	$judge_id = $_GET['judge_id'];
	
	$match_obj->add_match_judge($db_obj, $match_id, $judge_id);
	
	header("Location: pairings_judges_module.php?round_id=$round_id&match_id=$match_id");
	exit();
?>