
<?php
/**
 * Created by PhpStorm.
 * User: Colton Aarts
 * Date: 2018-05-29
 * Time: 2:30 PM
 */

//Used to INSERT INTO the region table user inputs

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO region (region_id, region_name) VALUES (?, ?)");
$stmt->bind_param("is", $region_id, $region_name);

// You do not want to assign a value to $region_id because it is auto-incremented so it is assigned 0 or NULL
// Otherwise you give the variables the correct values based on user input and complete the call

$region_id = 0;

// You would replace this with the user input. region_name is a string of max length 20
$region_name = "Northern British Columbia";

$stmt -> execute();

$stmt->close();
$conn->close();
?>



<?php

// Used to INSERT INTO the ballot table the needed information from the user

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO ballot (ballot_id, room_id) VALUES (?, ?)");
$stmt->bind_param("ii", $ballot_id, $room_id);

// You do not want to assign a value to $ballot_id because it is auto-incremented so it is assigned 0 or NULL
// Otherwise you give the variables the correct values based on user input and complete the call

$ballot_id = 0;

// You would replace this with the user input. Room_id needs to be a valid room otherwise this will cause a error.
// Also this value currently needs to be a integer.
$room_id = 124;

$stmt -> execute();

$stmt->close();
$conn->close();
?>



<?php

// Used to INSERT INTO the ballot_round table the needed information from the user

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO ballot_round (ballot_id, round_id) VALUES (?, ?)");
$stmt->bind_param("ii", $ballot_id, $round_id);

// This needs to be a valid ballot_id otherwise it will cause and error
$ballot_id = 124;

// This needs to be a valid round_id otherwise it will cause an error
$round_id = 124;

$stmt -> execute();

$stmt->close();
$conn->close();
?>



<?php

// Used to INSERT INTO the ballot_speaker_score table the needed information from the user

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO ballot_speaker_score (ballot_id, speaker_id, score) VALUES (?, ?, ?)");
$stmt->bind_param("iii", $ballot_id, $speaker_id, $socre);

// This needs to be a valid ballot_id.
$ballot_id = 0;

// This needs to be a valid speaker_id
$speaker_id = 124;

// Currently the score value is not bound but this can be changed
$score = 72;

$stmt -> execute();

$stmt->close();
$conn->close();
?>



<?php

// Used to INSERT INTO the ballot_team table the needed information from the user

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO ballot_team (ballot_id, team_id) VALUES (?, ?)");
$stmt->bind_param("iii", $ballot_id, $team_id);

// This needs to be a valid ballot_id.
$ballot_id = 145;

// This needs to be a valid team_id.
$team_id = 124;

$stmt -> execute();

$stmt->close();
$conn->close();

?>



<?php


// Used to INSERT INTO the judge table the needed information from the user

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO judge (judge_id, judge_first_name, judge_last_name, rank, school_id)
 VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issii", $judge_id, $judge_first_name, $judge_last_name, $rank, $school_id);

// Judge_id is a auto-incremented value so it is set to 0.
$judge_id = 0;

// This is a string of max size 20
$judge_first_name = "Joe";

// Also a string of max size 20
$judge_last_name = "Smith";

// Integer that is currently not bounded but that can be changed
$rank = 5;

// Needs to be a valid school_id.
$school_id = 785;

$stmt -> execute();

$stmt->close();
$conn->close();
?>



<?php

// Used to INSERT INTO the judge_pairing table the needed information from the user

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO judge_pairing (judge_id, pairing_id) VALUES (?, ?)");
$stmt->bind_param("ii", $judge_id, $pairing_id);

// This needs to be a valid judge_id.

$judge_id = 341;

// This needs to be a valid pairing_id
$pairing_id = 124;

$stmt -> execute();

$stmt->close();
$conn->close();
?>



<?php

// Used to INSERT INTO the pairing table the needed information from the user

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO pairing (pairing_id, priority, round_id, room_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiii", $pairing_id, $priority, $round_id, $room_id);

// Pairing_id is an auto-incremented value so it is set to 0.
$ballot_id = 0;

// Priority is not bound at the moment but that cna be changed easily.
$priority = 124;

// Needs to be a valid round_id
$round_id = 72;

// Needs to be a valid room_id
$room_id = 134;

$stmt -> execute();

$stmt->close();
$conn->close();
?>



<?php

// Used to INSERT INTO the pairing_preference table the needed information from the user

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO pairing_preference (pp_id, pp_name, custom_bracket_size, reseed_pullout, 
matching_type, max_allowed_govt_assistance, random_room_assignment, bracket_type, fix_team_conflicts, pullout_type)
 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isiisissss", $pp_id, $pp_name, $custom_bracket_size, $reseed_pullout,
    $matching_type, $max_allowed_govt_assistance, $random_room_assignment, $bracket_type, $fix_team_conflicts, $pullout_type);

// pp_id is an auto-incrementing value so it is set to 0
$pp_id = 0;

// Name of the pairing_preference. A string of max size 20
$pp_name = "Something";

// The size of the bracket, not currently bound
$custom_bracket_size = 12;

// Should just be a boolean so it will need to be changed to reflect this.
$reseed_pullout = 1;

// Either Random, High-High, High-Low. A string of max size 20. This could be reduced once we are certain of the inputs
$matching_type = "Something";

// A int
$max_allowed_govt_assistance = 45;

//Just another check box so will need to change as well. Same as matching_type
$random_room_assignment = "More words";

//Either no bracketing, win-loss, uniform size, or custom size. Same as above
$bracket_type = "Value";

// This is a list of values so will need to change probably to work.... not sure how at the moment
$fix_team_conflicts = "Another value";

// Either top, middle, bottom. Same as above
$pullout_type = "Different value";

$stmt -> execute();

$stmt->close();
$conn->close();
?>

<?php

// Used to INSERT INTO the pairing_team table the needed information from the user

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO pairing_team (pairing_id, team_id) VALUES (?, ?)");
$stmt->bind_param("ii", $pairing_id, $team_id);

// Needs to be a valid parring_id
$ballot_id = 342;

// Needs to be a valid team_id
$team_id = 123;

$stmt -> execute();

$stmt->close();
$conn->close();
?>



<?php

// Used to INSERT INTO the room table the needed information from the user

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO room (room_id, room_name, room_priority) VALUES (?, ?, ?)");
$stmt->bind_param("isi", $room_id, $room_name, $room_priority);

// room_id is an auto-incremented value so it is set to 0.
$room_id = 0;

// room_name is a string of max length 20
$room_name = "Some Name";

// Unbounded integer that can be bound to acceptable values.
$room_priority = 5;

$stmt -> execute();

$stmt->close();
$conn->close();
?>



<?php

// Used to INSERT INTO the round table the needed information from the user

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO round (round_id, round_name, pp_id) VALUES (?, ?, ?)");
$stmt->bind_param("isi", $round_id, $round_name, $pp_id);

// round_id is an auto-incremented value so it is set to 0.
$round_id = 0;

// round_name is a string of max length 20
$round_name = "Some Name";

// Needs to be a valid pp_id
$pp_id = 72;

$stmt -> execute();

$stmt->close();
$conn->close();
?>



<?php

// Used to INSERT INTO the school table the needed information from the user

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO school (school_id, school_name, region_id) VALUES (?, ?, ?)");
$stmt->bind_param("isi", $school_id, $school_name, $region_id);

// school_id is an auto-incremented value so it is set to 0.
$school_id = 0;

// school_name is a string that is max length 20
$school_name = "Some Name";

// Needs to be a valid region_id
$region_id = 72;

$stmt -> execute();

$stmt->close();
$conn->close();
?>



<?php

// Used to INSERT INTO the scratches table the needed information from the user

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO scratches (judge_id, speaker_id) VALUES (?, ?)");
$stmt->bind_param("ii", $judge_id, $speaker_id);

// Needs to be a valid judge_id
$judge_id = 0;

// Needs to be a valid speaker_id
$speaker_id = 123;

$stmt -> execute();

$stmt->close();
$conn->close();
?>



<?php

// Used to INSERT INTO the speaker table the needed information from the user

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO speaker (speaker_id, speaker_first_name, speaker_last_name, rank, school_id, team_id) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issiii", $speaker_id, $speaker_first_name, $speaker_last_name, $rank, $school_id, $team_id);

//speaker_id is an auto-increment value so it is initialized to zero
$speaker_id = 0;

//speaker_first_name is a string of 20 characters max
$speaker_first_name = "John";

// speaker_last_name is a string of 20 characters max
$speaker_last_name = "Doe";

// rank is an unbounded int
$rank = 1;

// Needs to ba a valid school_id
$school_id = 457;

//Needs to be a valid team_id
$team_id = 869;

$stmt -> execute();

$stmt->close();
$conn->close();
?>

<?php

// Used to INSERT INTO the team table the needed information from the user

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO team (team_id, team_name, school_id, team_rank) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isii", $team_id, $team_name, $school_id, $team_rank);

// team_id is an auto-incremented value so it is initialized to zero.
$team_id = 0;

// team_name is a string of max length 20
$team_name = "Clever Name";

// Needs to be a valid school_name
$school_id = 786;

// team_rank is an unbounded integer
$team_rank = 7;

$stmt -> execute();

$stmt->close();
$conn->close();
?>
