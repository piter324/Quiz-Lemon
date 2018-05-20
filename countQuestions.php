<?php
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");
	$queryC="SELECT COUNT(id) FROM questions WHERE quizuid='".$_SESSION['qid']."'";
	$resultC=mysqli_query($con,$queryC);
	$rowC=mysqli_fetch_array($resultC);
	echo $rowC['COUNT(id)'];
	if($rowC['COUNT(id)']==1)
		echo " pytanie";
	else if(intval(substr($rowC['COUNT(id)'],-1))<5)
		echo " pytania";
	else
		echo " pytań";
?>