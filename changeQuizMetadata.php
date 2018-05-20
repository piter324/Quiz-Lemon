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
		$query="UPDATE quizes SET ".$_POST['metatype']."='".$_POST['dataToPass']."' WHERE quizuid='".$_SESSION['qid']."'";
		mysqli_query($con,$query);
		echo 'done';
	}
	else
	{
		echo 'Nie masz uprawnień do zmiany metadanych quizu!';
	}
?>