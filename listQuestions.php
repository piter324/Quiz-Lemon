<?php 
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");

	echo "<h3>Wyświetl i edytuj pytania:</h3>
		<div id='questionsListContainer'><div id='questionsList'>";
		$queryList = "SELECT * FROM questions WHERE quizuid='".$_SESSION['qid']."' ORDER BY sequence ASC";
		$resultList = mysqli_query($con,$queryList);
		$queryLastSequence = "SELECT MAX(sequence) FROM questions WHERE quizuid='".$_SESSION['qid']."'";
		$resultLastSequence = mysqli_query($con,$queryLastSequence);
		$rowLastSequence = mysqli_fetch_array($resultLastSequence);
		while($rowList=mysqli_fetch_array($resultList))
		{
			echo "<div class='questionsListMember'><div class='questionsListMemberCell questionsListMemberSequence' >".$rowList['sequence'].". </div>
			<div class='questionsListMemberCell questionsListMemberText' id='question".$rowList['id']."'>".$rowList['question']."</div>
			<div class='questionsListMemberCell questionsListMemberAnswer' id='answer".$rowList['id']."'>".$rowList['answer']."</div>
			<div class='questionsListMemberCell questionsListMemberAnswerType' id='answerType".$rowList['id']."'>";
			if($rowList['answertype']=='radio')
				echo "wielokrotny wybór";
			else if($rowList['answertype']=='text')
				echo "wpisanie odpowiedzi";

			echo "</div><div class='questionsListMemberCell questionsListMemberActions' id='actions".$rowList['id']."'>
			<div class='questionsListMemberAction inlinowe' onclick='showEditingCanvas(".$rowList['id'].")'><img class='questionsListMemberActionIcon inlinowe' src='images/icons/Edit-64.png'><span class='inliowe'>edytuj</div>
			<div class='questionsListMemberAction inlinowe' onclick='deleteQuestion(".$rowList['id'].")'><img class='questionsListMemberActionIcon inlinowe' src='images/icons/Delete-64.png'><span class='inlinowe'>usuń</span></div>
			<div><div class='questionsListMemberAction inlinowe' style='display:none' onclick='showAdvancedSettings(".$rowList['id'].")'><img class='questionsListMemberActionIcon inlinowe' src='images/icons/Settings-64.png'><span class='inlinowe'>zaawansowane</span></div></div>
			<div><div class='inlinowe' style='margin-right:8px;'>Kolejność: </div>";
			if($rowList['sequence']!=1)
			{
				echo "<div class='questionsListMemberAction inlinowe' onclick=\"changeSequence(".$rowList['id'].",-1)\"><img class='questionsListMemberActionIcon' src='images/icons/Up-64.png'></div>";
			}
			if($rowLastSequence['MAX(sequence)']!=$rowList['sequence'])
			{
				echo "<div class='questionsListMemberAction inlinowe' onclick=\"changeSequence(".$rowList['id'].",1)\"><img class='questionsListMemberActionIcon' src='images/icons/Down-64.png'></div>";
			}
			echo "</div></div></div><div class='questionsListMemberAdvancedSettings' id='advanced".$rowList['id']."'>
			<div style='width:900px'>
			<p style='margin:2px'>złe odpowiedzi:</p>
			<p class='advancedSettingsPara'><input type='radio' name='badAnswersStyle' value='auto' id='auto".$rowList['id']."'><label for='auto".$rowList['id']."'> generuj automatycznie</label></p>
			<p class='advancedSettingsPara'><input type='radio' name='badAnswersStyle' value='manual' id='manual".$rowList['id']."'><label for='manual".$rowList['id']."'> wpisz poniżej (po jednej złej odpowiedzi na linijkę): </label><br/>
			<textarea class='customBadAnswers' id='customBadAnswers".$rowList['id']."'></textarea></p>
			</div>
			</div>";
		}
		echo "</div></div>";
?>