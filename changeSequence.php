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
		$query="SELECT * FROM questions WHERE quizuid='".$_SESSION['qid']."' AND id=".$_POST['currID'];
		$result = mysqli_query($con,$query);
		$rowCurr = mysqli_fetch_array($result);

		$newSq=intval($rowCurr['sequence'])+intval($_POST['step']);
		$query="SELECT * FROM questions WHERE quizuid='".$_SESSION['qid']."' AND sequence=".$newSq;
		$result = mysqli_query($con,$query);
		$rowNext = mysqli_fetch_array($result);

		//nowy do bufora (sequence=0)
		$queryUptd="UPDATE questions SET sequence=0 WHERE quizuid='".$_SESSION['qid']."' AND sequence=".$newSq;
		mysqli_query($con,$queryUptd);

		//stary na miejsce nowego
		$queryUptd="UPDATE questions SET sequence=".$newSq." WHERE quizuid='".$_SESSION['qid']."' AND sequence=".$rowCurr['sequence'];
		mysqli_query($con,$queryUptd);

		//nowy (ten z sequence=0) na miejsce starego
		$queryUptd="UPDATE questions SET sequence=".$rowCurr['sequence']." WHERE quizuid='".$_SESSION['qid']."' AND sequence=0";
		mysqli_query($con,$queryUptd);
		echo 'done';
	}
	else
	{
		echo 'Nie masz uprawnień do edycji kolejności pytań quizu!';
	}
?>