<?php
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");
	if(in_array($_SESSION['curr'], $_SESSION['taken']))
	{
		echo "JUŻ UDZIELONO ODPOWIEDZI NA TO PYTANIE#";
	}
	else
	{
		if($_POST['answer']==$_SESSION['rightAnswer'])
		{
			$_SESSION['points']++;
			echo "DOBRZE!#";
			$_SESSION['taken'][]=$_SESSION['curr'];
			$_SESSION['rightAnswer']='';
			if($_SESSION['curr']==$_SESSION['questionsNumber'])
			{
				$query="UPDATE quizes SET timesdone=timesdone+1 WHERE quizuid='".$_SESSION['qid']."'";
				mysqli_query($con,$query);
			}
		}
		else
		{
			echo "ŹLE!#".$_SESSION['rightAnswer'];
			$_SESSION['rightAnswer']='';
		}
	}

?>