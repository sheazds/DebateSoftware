 <?php
// this will get moved to an external php file in the future
$servername = "localhost";
$username = "dbsadmin";
$password = "dbspassadmin";
$dbname = "attempt1";

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
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id) VALUES ('1','UnrealTeam','1')");
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id) VALUES ('2','NotRealTeam','2')");
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id) VALUES ('3','FictionTeam','3')");
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id) VALUES ('4','AnotherTeam','3')");
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id) VALUES ('5','OtherTEam','4')");
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id) VALUES ('6','YetAnother','5')");
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id) VALUES ('7','OneMoreTeam','6')");
 mysqli_query($conn,"INSERT INTO team(team_id, team_name, school_id) VALUES ('8','LastTeam','6')");

mysqli_query($conn,"DELETE FROM speaker" );
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('1','Adam','Midname','Surname','3','1','1')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('2','Isabelle','Midname','Surname','4','1','1')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('3','Belle','Midname','Surname','5','2','2')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('4','Jasmine','Midname','Surname','6','2','2')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('5','Calli','Midname','Surname','7','3','3')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('6','Ken','Midname','Surname','8','3','3')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('7','Dan','Midname','Surname','9','3','4')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('8','Leah','Midname','Surname','8','3','4')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('9','Edward','Midname','Surname','7','4','5')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('10','Matt','Midname','Surname','6','4','5')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('11','Frank','Midname','Surname','5','5','6')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('12','Nami','Midname','Surname','4','5','6')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('13','Greta','Midname','Surname','3','6','7')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('14','Oswald','Midname','Surname','3','6','7')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('15','Howard','Midname','Surname','4','6','8')");
 mysqli_query($conn,"INSERT INTO speaker(speaker_id, speaker_first_name, speaker_middle_name, speaker_last_name, rank, school_id, team_id) VALUES ('16','Surname','Midname','Surname','5','6','8')");

mysqli_query($conn,"DELETE FROM judge" );
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name, judge_middle_name, judge_last_name, rank, school_id) VALUES ('1','Judge','MId','Reinhold','3','1')");
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name, judge_middle_name, judge_last_name, rank, school_id) VALUES ('2','Judge','MId','Davis','6','1')");
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name, judge_middle_name, judge_last_name, rank, school_id) VALUES ('3','Judge','MId','Wilbur','9','2')");
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name, judge_middle_name, judge_last_name, rank, school_id) VALUES ('4','Judge','MId','Parker','8','3')");
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name, judge_middle_name, judge_last_name, rank, school_id) VALUES ('5','Judge','MId','Dredd','5','4')");
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name, judge_middle_name, judge_last_name, rank, school_id) VALUES ('6','Judge','MId','Bone','2','4')");
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name, judge_middle_name, judge_last_name, rank, school_id) VALUES ('7','Judge','MId','Snyder','4','5')");
 mysqli_query($conn,"INSERT INTO judge(judge_id, judge_first_name, judge_middle_name, judge_last_name, rank, school_id) VALUES ('8','Judge','MId','Harm','6','6')");

mysqli_query($conn,"DELETE FROM room" );
 mysqli_query($conn,"INSERT INTO room(room_id, room_name, room_priority) VALUES ('1','8-150','2')");
 mysqli_query($conn,"INSERT INTO room(room_id, room_name, room_priority) VALUES ('2','8-152','4')");
 mysqli_query($conn,"INSERT INTO room(room_id, room_name, room_priority) VALUES ('3','8-157','6')");
 mysqli_query($conn,"INSERT INTO room(room_id, room_name, room_priority) VALUES ('4','8-181','8')");
 
mysqli_query($conn,"DELETE FROM scratch" ); 
 mysqli_query($conn,"INSERT INTO scratch(judge_id, speaker_id) VALUES ('1','1')");

mysqli_query($conn,"DELETE FROM pairing_preference" );
 mysqli_query($conn,"INSERT INTO pairing_preference(pp_id, pp_name, custom_bracket_size, reseed_pullout, matching_type, max_allowed_govt_assistants, random_room_assignment, bracket_type, fix_team_conflicts, pullout_type) VALUES ('1','preferencesName','2','no','random','1','yes','Win-Loss / Points','yes','Top Pullup')");

mysqli_query($conn,"DELETE FROM round" ); 
 mysqli_query($conn,"INSERT INTO round(round_id, round_name, pp_id) VALUES ('1','Round 1','1')");
 mysqli_query($conn,"INSERT INTO round(round_id, round_name, pp_id) VALUES ('2','Round 2','1')");
 mysqli_query($conn,"INSERT INTO round(round_id, round_name, pp_id) VALUES ('3','Round 3','1')");

mysqli_query($conn,"DELETE FROM pairing" );
 mysqli_query($conn,"INSERT INTO pairing(pairing_id, priority, round_id, room_id, team1_id, team2_id) VALUES ('1','2','1','1','1','2')");
 mysqli_query($conn,"INSERT INTO pairing(pairing_id, priority, round_id, room_id, team1_id, team2_id) VALUES ('2','2','1','2','3','4')");
 mysqli_query($conn,"INSERT INTO pairing(pairing_id, priority, round_id, room_id, team1_id, team2_id) VALUES ('3','2','1','3','5','6')");
 mysqli_query($conn,"INSERT INTO pairing(pairing_id, priority, round_id, room_id, team1_id, team2_id) VALUES ('4','2','1','4','7','8')");
 mysqli_query($conn,"INSERT INTO pairing(pairing_id, priority, round_id, room_id, team1_id, team2_id) VALUES ('5','4','2','1','1','4')");
 mysqli_query($conn,"INSERT INTO pairing(pairing_id, priority, round_id, room_id, team1_id, team2_id) VALUES ('6','4','2','2','5','8')");
 mysqli_query($conn,"INSERT INTO pairing(pairing_id, priority, round_id, room_id, team1_id, team2_id) VALUES ('7','6','3','4','1','5')");

mysqli_query($conn,"DELETE FROM judge_pairing" );
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('1','1')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('1','2')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('2','3')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('2','4')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('3','5')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('3','6')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('4','7')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('4','8')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('5','1')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('5','2')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('5','3')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('6','4')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('6','5')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('6','6')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('7','6')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('7','7')");
 mysqli_query($conn,"INSERT INTO judge_pairing(pairing_id, judge_id) VALUES ('7','8')");

mysqli_query($conn,"DELETE FROM pairing_team" );
 mysqli_query($conn,"INSERT INTO pairing_team(pairing_id, team_id) VALUES ('1','1')");
 mysqli_query($conn,"INSERT INTO pairing_team(pairing_id, team_id) VALUES ('1','2')");
 mysqli_query($conn,"INSERT INTO pairing_team(pairing_id, team_id) VALUES ('2','3')");
 mysqli_query($conn,"INSERT INTO pairing_team(pairing_id, team_id) VALUES ('2','4')");
 mysqli_query($conn,"INSERT INTO pairing_team(pairing_id, team_id) VALUES ('3','5')");
 mysqli_query($conn,"INSERT INTO pairing_team(pairing_id, team_id) VALUES ('3','6')");
 mysqli_query($conn,"INSERT INTO pairing_team(pairing_id, team_id) VALUES ('4','7')");
 mysqli_query($conn,"INSERT INTO pairing_team(pairing_id, team_id) VALUES ('4','8')");
 mysqli_query($conn,"INSERT INTO pairing_team(pairing_id, team_id) VALUES ('5','1')");
 mysqli_query($conn,"INSERT INTO pairing_team(pairing_id, team_id) VALUES ('5','4')");
 mysqli_query($conn,"INSERT INTO pairing_team(pairing_id, team_id) VALUES ('6','5')");
 mysqli_query($conn,"INSERT INTO pairing_team(pairing_id, team_id) VALUES ('6','8')");
 mysqli_query($conn,"INSERT INTO pairing_team(pairing_id, team_id) VALUES ('7','1')");
 mysqli_query($conn,"INSERT INTO pairing_team(pairing_id, team_id) VALUES ('7','5')");
 

mysqli_query($conn,"DELETE FROM ballot" );
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('1','1')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('2','1')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('3','1')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('4','1')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('5','2')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('6','2')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('7','2')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('8','2')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('9','3')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('10','3')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('11','3')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('12','3')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('13','4')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('14','4')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('15','4')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('16','4')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('17','1')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('18','1')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('19','1')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('20','1')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('21','1')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('22','1')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('23','2')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('24','2')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('25','2')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('26','2')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('27','2')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('28','2')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('29','4')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('30','4')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('31','4')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('32','4')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('33','4')");
 mysqli_query($conn,"INSERT INTO ballot(ballot_id, room_id) VALUES ('34','4')");
 
mysqli_query($conn,"DELETE FROM ballot_round" );
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('1','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('2','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('3','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('4','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('5','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('6','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('7','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('8','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('9','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('10','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('11','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('12','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('13','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('14','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('15','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('16','1')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('17','2')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('18','2')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('19','2')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('20','2')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('21','2')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('22','2')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('23','2')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('24','2')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('25','2')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('26','2')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('27','2')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('28','2')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('29','3')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('30','3')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('31','3')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('32','3')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('33','3')");
 mysqli_query($conn,"INSERT INTO ballot_round(ballot_id, round_id) VALUES ('34','3')");

mysqli_query($conn,"DELETE FROM ballot_team" ); 
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('1','1')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('2','2')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('3','1')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('4','2')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('5','3')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('6','4')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('7','3')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('8','4')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('9','5')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('10','6')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('11','5')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('12','6')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('13','7')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('14','8')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('15','7')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('16','8')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('17','1')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('18','4')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('19','1')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('20','4')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('21','1')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('22','4')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('23','5')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('24','8')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('25','5')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('26','8')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('27','5')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('28','8')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('29','1')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('30','5')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('31','1')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('32','5')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('33','1')");
 mysqli_query($conn,"INSERT INTO ballot_team(ballot_id, team_id) VALUES ('34','5')");
 
mysqli_query($conn,"DELETE FROM ballot_speaker_scores" );
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('1','1','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('1','2','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('2','3','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('2','4','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('3','1','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('3','2','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('4','3','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('4','4','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('5','5','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('5','6','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('6','7','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('6','8','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('7','5','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('7','6','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('8','7','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('8','8','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('9','9','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('9','10','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('10','11','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('10','12','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('11','9','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('11','10','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('12','11','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('12','12','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('13','13','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('13','14','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('14','15','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('14','16','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('15','13','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('15','14','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('16','15','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('16','16','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('17','1','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('17','2','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('18','7','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('18','8','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('19','1','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('19','2','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('20','7','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('20','8','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('21','1','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('21','2','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('22','7','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('22','8','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('23','9','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('23','10','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('24','15','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('24','16','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('25','9','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('25','10','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('26','15','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('26','16','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('27','9','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('27','10','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('28','15','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('28','16','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('29','1','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('29','2','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('30','9','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('30','10','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('31','1','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('31','2','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('32','9','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('32','10','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('33','1','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('33','2','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('34','9','','','','','','')");
 mysqli_query($conn,"INSERT INTO ballot_speaker_scores(ballot_id, speaker_id, orginization/structure, evidence/analysis, rebuttal/clash, delivery/etiquette, questioning/responding, comments) VALUES ('34','10','','','','','','')");
 
 
 //mysqli_query($conn,"INSERT INTO (,,) VALUES ('')");
 
 
 mysqli_close($conn);
?>