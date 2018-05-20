<?php
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");
	$query="SELECT * FROM questions WHERE id='".$_POST['questionid']."'";
	$result=mysqli_query($con,$query);
	$row=mysqli_fetch_array($result);
	echo "<input type='text' id='newQuestion".$row['id']."' value='".$row['question']."'>
			#<input type='text' id='newAnswer".$row['id']."' value='".$row['answer']."'>
			#<select id='newAnswerType".$row['id']."'>";
		if($row['answertype']=='radio')
			echo "<option value='radio' selected>wielokrotny wybór</option>
			<option value='text'>wpisanie odpowiedzi</option>";
		else if($row['answertype']=='text')
			echo "<option value='radio'>wielokrotny wybór</option>
			<option value='text' selected>wpisanie odpowiedzi</option>";
			echo "</select>
		#<div class='questionsListMemberAction' onclick='editQuestion(".$row['id'].")''><img class='questionsListMemberActionIcon inlinowe' src='images/icons/Checkmark-64.png'><span clas='inlinowe'> Potwierdź</span></div>
		<div class='questionsListMemberAction' onclick='listQuestions()'><img class='questionsListMemberActionIcon inlinowe' src='images/icons/Delete-Sign-64.png'><span clas='inlinowe'> Anuluj</span></div>";
?>