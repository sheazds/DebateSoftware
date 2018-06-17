 <?php
// this will get moved to an external php file in the future
$servername = "localhost";
$username = "dbsadmin";
$password = "dbspassadmin";
$dbname = "candebate";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";


$sql = "SELECT region_id, region_name FROM region";
$result = $conn->query($sql);

mysqli_query($conn,"DELETE FROM region" );
 mysqli_query($conn,"INSERT INTO region(region_id, region_name) VALUES ('1','British Columbia')");
 mysqli_query($conn,"INSERT INTO region(region_id, region_name) VALUES ('2','Alberta')");
 mysqli_query($conn,"INSERT INTO region(region_id, region_name) VALUES ('3','Ontario')");

mysqli_query($conn,"DELETE FROM school" ); 
 mysqli_query($conn,"INSERT INTO school(school_id, school_name, region_id) VALUES ('1','UNBC','1')");
 mysqli_query($conn,"INSERT INTO school(school_id, school_name, region_id) VALUES ('2','UVIC','1')");
 mysqli_query($conn,"INSERT INTO school(school_id, school_name, region_id) VALUES ('3','UALB','2')");
 mysqli_query($conn,"INSERT INTO school(school_id, school_name, region_id) VALUES ('4','UCAL','2')");
 mysqli_query($conn,"INSERT INTO school(school_id, school_name, region_id) VALUES ('5','NAIT','2')");
 mysqli_query($conn,"INSERT INTO school(school_id, school_name, region_id) VALUES ('6','UONT','3')");
 
mysqli_query($conn,"DELETE FROM team" );
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id, num_times_opp, num_times_gov) VALUES ('1','UnrealTeam','1','0','0')");
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id, num_times_opp, num_times_gov) VALUES ('2','NotRealTeam','2','0','0')");
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id, num_times_opp, num_times_gov) VALUES ('3','FictionTeam','3','0','0')");
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id, num_times_opp, num_times_gov) VALUES ('4','AnotherTeam','3','0','0')");
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id, num_times_opp, num_times_gov) VALUES ('5','OtherTEam','4','0','0')");
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id, num_times_opp, num_times_gov) VALUES ('6','YetAnother','5','0','0')");
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id, num_times_opp, num_times_gov) VALUES ('7','OneMoreTeam','6','0','0')");
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id, num_times_opp, num_times_gov) VALUES ('8','LastTeam','6','0','0')");

mysqli_query($conn,"DELETE FROM speaker" );
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('1','Adam','Surname','3','1','1')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('2','Isabelle','Surname','4','1','1')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('3','Belle','Surname','5','2','2')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('4','Jasmine','Surname','6','2','2')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('5','Calli','Surname','7','3','3')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('6','Ken','Surname','8','3','3')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('7','Dan','Surname','9','3','4')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('8','Leah','Surname','8','3','4')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('9','Edward','Surname','7','4','5')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('10','Matt','Surname','6','4','5')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('11','Frank','Surname','5','5','6')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('12','Nami','Surname','4','5','6')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('13','Greta','Surname','3','6','7')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('14','Oswald','Surname','3','6','7')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('15','Howard','Surname','4','6','8')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name,  speaker_last_name, rank, school_id, team_id) VALUES ('16','Surname','Surname','5','6','8')");

mysqli_query($conn,"DELETE FROM judge" );
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name,  judge_last_name, rank, school_id) VALUES ('1','Judge','Reinhold','3','1')");
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name,  judge_last_name, rank, school_id) VALUES ('2','Judge','Davis','6','1')");
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name,  judge_last_name, rank, school_id) VALUES ('3','Judge','Wilbur','9','2')");
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name,  judge_last_name, rank, school_id) VALUES ('4','Judge','Parker','8','3')");
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name,  judge_last_name, rank, school_id) VALUES ('5','Judge','Dredd','5','4')");
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name,  judge_last_name, rank, school_id) VALUES ('6','Judge','Bone','2','4')");
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name,  judge_last_name, rank, school_id) VALUES ('7','Judge','Snyder','4','5')");
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name,  judge_last_name, rank, school_id) VALUES ('8','Judge','Harm','6','6')");

mysqli_query($conn,"DELETE FROM room" );
 mysqli_query($conn,"INSERT INTO room(room_id, room_name, room_priority) VALUES ('1','8-150','2')");
 mysqli_query($conn,"INSERT INTO room(room_id, room_name, room_priority) VALUES ('2','8-152','4')");
 mysqli_query($conn,"INSERT INTO room(room_id, room_name, room_priority) VALUES ('3','8-157','6')");
 mysqli_query($conn,"INSERT INTO room(room_id, room_name, room_priority) VALUES ('4','8-181','8')");
 
 mysqli_close($conn);
?>