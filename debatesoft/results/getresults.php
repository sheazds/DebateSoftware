<script src="scripts/buttonbar.js"></script>
<div id="buttonbar">
	<?php
		require_once 'dbconfig.php';
		$rounds = $conn->query("SELECT round_id FROM round");
		while($row = $rounds->fetch_assoc())
		{
			$round = $row['round_id'];
			echo "<a class='button' href='#round".$round."' id='round".$round."'>Round ".$round."</a>";
		}
	?>
	<a class="button" href="#brackets" id="brackets">View as Bracket</a>
</div>

<div id='tournamentbrackets'>
	<div id="round1" class="round">
		<div class="pair_spacer">
			<div id="pair1" class="pair">
				<div class='enteredballots'>Ballots: 2/3</div>
				<table>
					<tbody>
						<tr><td><b>Room:</b></td><td>8-150</td></tr>
						<tr><td><b>Teams:</b></td><td>UnrealTeam<br>NotRealTeam</td></tr>
						<tr><td><b>Judges:</b></td><td>Judge Reinhold<br>Judge Davis</td></tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="pair_spacer">
			<div id="pair2" class="pair">
				<table>
					<tbody>
						<tr><td><b>Teams:</b></td><td>FictionTeam<br>AnotherTeam</td></tr>
						<tr><td><b>Room:</b></td><td>8-152</td></tr>
						<tr><td><b>Judges:</b></td><td>Judge Wilbur<br>Judge Parker</td></tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="pair_spacer">
			<div id="pair3" class="pair">
				<table>
					<tbody>
						<tr><td><b>Teams:</b></td><td>OtherTEam<br>YetAnother</td></tr>
						<tr><td><b>Room:</b></td><td>8-157</td></tr>
						<tr><td><b>Judges:</b></td><td>Judge Dredd<br>Judge Bone</td></tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="pair_spacer">
			<div id="pair4" class="pair">
				<table>
					<tbody>
						<tr><td><b>Teams:</b></td><td>OneMoreTeam<br>LastTeam</td></tr>
						<tr><td><b>Room:</b></td><td>8-181</td></tr>
						<tr><td><b>Judges:</b></td><td>Judge Snyder<br>Judge Harm</td></tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<div id="round2" class="round">
		<div class="pair_spacer">
			<div id="pair5" class="pair">
				<table>
					<tbody>
						<tr><td><b>Teams:</b></td><td>UnrealTeam<br>AnotherTeam</td></tr>
						<tr><td><b>Room:</b></td><td>8-150</td></tr>
						<tr><td><b>Judges:</b></td><td>Judge Reinhold<br>Judge Davis<br>Judge Wilbur</td></tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="pair_spacer">
			<div id="pair6" class="pair">
				<table>
					<tbody>
						<tr><td><b>Teams:</b></td><td>OtherTEam<br>LastTeam</td></tr>
						<tr><td><b>Room:</b></td><td>8-152</td></tr>
						<tr><td><b>Judges:</b></td><td>Judge Parker<br>Judge Dredd<br>Judge Bone</td></tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<div id="round3" class="round">
		<div class="pair_spacer">
			<div id="pair7" class="pair">
				<table>
					<tbody>
						<tr><td><b>Teams:</b></td><td>UnrealTeam<br>OtherTEam</td></tr>
						<tr><td><b>Room:</b></td><td>8-181</td></tr>
						<tr><td><b>Judges:</b></td><td>Judge Bone<br>Judge Snyder<br>Judge Harm</td></tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>