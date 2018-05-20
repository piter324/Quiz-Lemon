<?php
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");
	$queryCheckPrivileges="SELECT * FROM quizes WHERE quizuid='".$_SESSION['qid']."'";
	$resultCheckPrivileges=mysqli_query($con,$queryCheckPrivileges);
	$rowCheckPrivileges=mysqli_fetch_array($resultCheckPrivileges);
	
	if($row['permission']=='PRI')
	{
		if(isset($_SESSION['useruid'])&&$_SESSION['useruid']==$rowCheckPrivileges['owneruid'])
		{
			getQuestions($con);
		}
		else
		{
			echo 'Nie masz uprawnień do korzystania z tego trybu!';
		}
	}
	else
	{
		getQuestions($con);
	}
	function getQuestions($con)
	{
		$query="SELECT COUNT(id) FROM questions WHERE quizuid='".$_SESSION['qid']."'";
		$result = mysqli_query($con,$query);
		$rowCount = mysqli_fetch_array($result);

		$nextPhrase=intval($_SESSION['curr'])+intval($_POST['step']);
		if($nextPhrase>=1&&$nextPhrase<=$rowCount['COUNT(id)'])
		{
			$_SESSION['curr']=$nextPhrase;
		}
		$query="SELECT * FROM questions WHERE quizuid='".$_SESSION['qid']."' AND sequence=".$_SESSION['curr'];
		$result = mysqli_query($con,$query);
		$rowCurr = mysqli_fetch_array($result);
		echo $rowCurr['question']."#".$rowCurr['answer']."#".$_SESSION['curr']."#".$rowCount['COUNT(id)'];
	}
?>