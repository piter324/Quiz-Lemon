<?php
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");
	$queryCheckPrivileges="SELECT owneruid FROM quizes WHERE quizuid='".$_SESSION['qid']."'";
	$resultCheckPrivileges=mysqli_query($con,$queryCheckPrivileges);
	$rowCheckPrivileges=mysqli_fetch_array($resultCheckPrivileges);
	if(isset($_SESSION['useruid'])&&$_SESSION['useruid']==$rowCheckPrivileges['owneruid'])
	{
		if($_POST['newQuestionsPosition']=='beginning')
		{
			$query="SELECT * FROM questions WHERE quizuid='".$_SESSION['qid']."' ORDER BY sequence ASC";
			$result=mysqli_query($con,$query);
			while($row=mysqli_fetch_array($result))
			{
				$newSq=$row['sequence']+1;
				$queryUptd="UPDATE questions SET sequence=".$newSq." WHERE id=".$row['id'];
				mysqli_query($con,$queryUptd);
			}
			$nextSequence=1;
			$query="INSERT INTO questions (quizuid,question,answer,answertype,sequence) VALUES ('".$_SESSION['qid']."','".$_POST['question']."','".$_POST['answer']."','".$_POST['answerType']."',".$nextSequence.")";
			//echo $query;
			mysqli_query($con,$query);
		}
		else
		{
			$queryLastSequence="SELECT MAX(sequence) FROM questions WHERE quizuid='".$_SESSION['qid']."'";
			$resultLastSequence=mysqli_query($con,$queryLastSequence);
			$rowLastSequence=mysqli_fetch_array($resultLastSequence);
			if($rowLastSequence['MAX(sequence)']!='(NULL)')
				$nextSequence = $rowLastSequence['MAX(sequence)']+1;
			else
				$nextSequence=1;
			$query="INSERT INTO questions (quizuid,question,answer,answertype,sequence) VALUES ('".$_SESSION['qid']."','".$_POST['question']."','".$_POST['answer']."','".$_POST['answerType']."',".$nextSequence.")";
			//echo $query;
			mysqli_query($con,$query);
		}
		echo 'done';
	}
	else
	{
		echo 'Nie masz uprawnień do dodawania pytań!';
	}
?>