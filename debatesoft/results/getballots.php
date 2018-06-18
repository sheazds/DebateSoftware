<?php
	if (file_exists ('dbconfig.php'))
		require_once 'dbconfig.php';
	else
		require_once '../dbconfig.php';
	
	if (isset($_POST['pair']) && isset($_POST['judge']))
	{
		$currentpair = $_POST['pair'];
		$currentjudge = $_POST['judge'];
		echo "<div id='ballotsheet_pair".$currentpair."_judge".$currentjudge."'>";
		echo "<table class='ballotstable'><tbody>";
		$ballots_query = "SELECT judge_ballot.pairing_id, judge.judge_id, team.team_name, CONCAT(speaker.speaker_first_name, ' ', speaker.speaker_last_name) AS speaker_name,
								 ballot_speaker_scores.ballot_id, ballot_speaker_scores.speaker_id, `ballot_speaker_scores`.`organization/structure`,
								 `ballot_speaker_scores`.`evidence/analysis`, `ballot_speaker_scores`.`rebuttal/clash`,
								 `ballot_speaker_scores`.`delivery/etiquette`, `ballot_speaker_scores`.`questioning/responding`,
								 `ballot_speaker_scores`.`comments`
						FROM judge
						INNER JOIN judge_ballot ON judge.judge_id = judge_ballot.judge_id
						INNER JOIN ballot_speaker_scores ON judge_ballot.ballot_id = ballot_speaker_scores.ballot_id
						INNER JOIN speaker ON ballot_speaker_scores.speaker_id = speaker.speaker_id
						INNER JOIN team on speaker.team_id = team.team_id
						WHERE judge_ballot.pairing_id = ".$currentpair." AND judge.judge_id = ".$currentjudge."
						ORDER BY `judge_ballot`.`pairing_id`, judge_ballot.judge_id, speaker.speaker_id ASC";
		$ballots_result = $conn->query($ballots_query);
		
		$j=0;
		while($row = $ballots_result->fetch_assoc())
		{
			$current_ballot = $row['ballot_id'];
			if($j%2==0)
				echo "<tr>";
			echo "<td class='ballotstd'>";
			
				
				echo "<div id='ballot_speaker".$current_ballot."' class='ballot_speaker'>";
					echo "<table class='ballot_inner_table'><tbody>";
						echo "<tr><td>Speaker:</td>
							<td>".$row['speaker_name']."</td>
							<td>Team Name:</br />".$row['team_name']."</td></tr>";
					
						echo "<tr><td>Criteria</td>";
						echo "<td><table><tbody><tr>
							<td>15<br />Poor</td>
							<td>16<br />Weak</td>
							<td>17<br />Avg</td>
							<td>18<br />Good</td>
							<td>19<br />Great</td>
							</tr></tbody></table></td>";
						echo "<td>Totals</td></tr>";
						
						echo "<tr><td style='text-align: center'>Organization/<br />Structure</td>
							<td><form id='orgstruc' onchange='post_ballot(orgstruc, ".$current_ballot.", null, ".$currentpair.", ".$currentjudge.")'>"; ?>
										<input type='radio' name='orgstruc' value='15' <?php echo ($row['organization/structure']==15)?'checked':'' ?>>
										<input type='radio' name='orgstruc' value='16' <?php echo ($row['organization/structure']==16)?'checked':'' ?>>
										<input type='radio' name='orgstruc' value='17' <?php echo ($row['organization/structure']==17)?'checked':'' ?>>
										<input type='radio' name='orgstruc' value='18' <?php echo ($row['organization/structure']==18)?'checked':'' ?>>
										<input type='radio' name='orgstruc' value='19' <?php echo ($row['organization/structure']==19)?'checked':'' ?>>
									</form></td>
							<?php
							$score = $row['organization/structure'];
							echo "<td id='orgstruc_score_".$current_ballot."'>".$score."</td></tr>";
							
							echo "<tr><td style='text-align: center'>Evidence/<br />Analysis</td>
								<td><form id='evidana' onchange='post_ballot(evidana, ".$current_ballot.", null, ".$currentpair.", ".$currentjudge.")'>"; ?>
										<input type='radio' name='evidana' value='15' <?php echo ($row['evidence/analysis']==15)?'checked':'' ?>>
										<input type='radio' name='evidana' value='16' <?php echo ($row['evidence/analysis']==16)?'checked':'' ?>>
										<input type='radio' name='evidana' value='17' <?php echo ($row['evidence/analysis']==17)?'checked':'' ?>>
										<input type='radio' name='evidana' value='18' <?php echo ($row['evidence/analysis']==18)?'checked':'' ?>>
										<input type='radio' name='evidana' value='19' <?php echo ($row['evidence/analysis']==19)?'checked':'' ?>>
									</form></td>
							<?php
							$score = $score + $row['evidence/analysis'];
							echo "<td id='evidana_score_".$current_ballot."'>".$score."</td></tr>";
							
							echo "<tr><td style='text-align: center'>Rebuttal/<br />Clash</td>
								<td><form id='rebcla' onchange='post_ballot(rebcla, ".$current_ballot.", null, ".$currentpair.", ".$currentjudge.")'>"; ?>
										<input type='radio' name='rebcla' value='15' <?php echo ($row['rebuttal/clash']==15)?'checked':'' ?>>
										<input type='radio' name='rebcla' value='16' <?php echo ($row['rebuttal/clash']==16)?'checked':'' ?>>
										<input type='radio' name='rebcla' value='17' <?php echo ($row['rebuttal/clash']==17)?'checked':'' ?>>
										<input type='radio' name='rebcla' value='18' <?php echo ($row['rebuttal/clash']==18)?'checked':'' ?>>
										<input type='radio' name='rebcla' value='19' <?php echo ($row['rebuttal/clash']==19)?'checked':'' ?>>
									</form></td>
							<?php
							$score = $score + $row['rebuttal/clash'];
							echo "<td id='rebcla_score_".$current_ballot."'>".$score."</td></tr>";
							
							echo "<tr><td style='text-align: center'>Delivery/<br />Etiquette</td>
								<td><form id='deleti' onchange='post_ballot(deleti, ".$current_ballot.", null, ".$currentpair.", ".$currentjudge.")'>"; ?>
										<input type='radio' name='deleti' value='15' <?php echo ($row['delivery/etiquette']==15)?'checked':'' ?>>
										<input type='radio' name='deleti' value='16' <?php echo ($row['delivery/etiquette']==16)?'checked':'' ?>>
										<input type='radio' name='deleti' value='17' <?php echo ($row['delivery/etiquette']==17)?'checked':'' ?>>
										<input type='radio' name='deleti' value='18' <?php echo ($row['delivery/etiquette']==18)?'checked':'' ?>>
										<input type='radio' name='deleti' value='18' <?php echo ($row['delivery/etiquette']==19)?'checked':'' ?>>
									</form></td>
							<?php
							$score = $score + $row['delivery/etiquette'];
							echo "<td id='deleti_score_".$current_ballot."'>".$score."</td></tr>";
							
							echo "<tr><td style='text-align: center'>Questioning/<br />Responding</td>
								<td><form id='questres' onchange='post_ballot(questres, ".$current_ballot.", null, ".$currentpair.", ".$currentjudge.")'>"; ?>
										<input type='radio' name='questres' value='15' <?php echo ($row['questioning/responding']==15)?'checked':'' ?>>
										<input type='radio' name='questres' value='16' <?php echo ($row['questioning/responding']==16)?'checked':'' ?>>
										<input type='radio' name='questres' value='17' <?php echo ($row['questioning/responding']==17)?'checked':'' ?>>
										<input type='radio' name='questres' value='17' <?php echo ($row['questioning/responding']==18)?'checked':'' ?>>
										<input type='radio' name='questres' value='19' <?php echo ($row['questioning/responding']==19)?'checked':'' ?>>
						</form></td>
						<?php
						$score = $score + $row['questioning/responding'];
						echo "<td id='questres_score_".$current_ballot."'>".$score."</td></tr>";
						
						echo "<tr><td colspan='2'>Comments:</br>
								<textarea rows='4' cols='35' id='comments".$current_ballot."' name='comments' onchange='post_ballot(this.name, ".$current_ballot.", this.value, ".$currentpair.", ".$currentjudge.")'>".$row['comments']."</textarea></td>
							<td id='total_score_".$current_ballot."'>Total Score:</br>
							".$score."</td></tr>";				
					echo "</tbody></table></div>";
				
				
			echo "</td>";
			if($j==1 || $j==3)
				echo "</tr>";
			$j++;
		}
		echo "</tbody></table>";
		echo "</div>";
	}
?>