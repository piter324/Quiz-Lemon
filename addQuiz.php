<?php
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");

	$name=$_POST['quizname'];
	$quizuid=uniqid('quiz');
	$query="INSERT INTO quizes (quizuid,owneruid,name,addeddate,addedhour) VALUES ('".$quizuid."','".$_SESSION['useruid']."','".$name."','".date('d.m.Y')."','".date('H:i:s')."')";
	mysqli_query($con,$query);
	$idOfLastQuery=mysqli_insert_id($con);
	
	$queryNewQuizuid = "SELECT quizuid FROM quizes WHERE id=".$idOfLastQuery;
	$resultNewQuizuid = mysqli_query($con,$queryNewQuizuid);
	$rowNewQuizuid = mysqli_fetch_array($resultNewQuizuid);
	echo 'done#'.$rowNewQuizuid['quizuid'];
?>