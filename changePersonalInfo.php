<?php
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");
	$changeInfo='';
	if($_POST['winfo']=='password')
	{
		$changeInfo=hash('sha256', $_POST['cinfo']);
	}
	else if($_POST['winfo']=='username')
	{
		$queryCheckExistence="SELECT COUNT(id) FROM users WHERE username='".$_POST['cinfo']."'";
		$resultCheckExistence=mysqli_query($con,$queryCheckExistence);
		$rowCheckExistenceUname=mysqli_fetch_array($resultCheckExistence);
		if(intval($rowCheckExistenceUname['COUNT(id)'])==0)
		{
			$changeInfo=$_POST['cinfo'];
		}
		else
		{
			echo "Wpisana nazwa użytkownika jest zajęta.<br/><strong>Wpisz inną (np. użyj większej ilości cyfr czy znaków specjalnych)</strong>";
		}
	}
	else if($_POST['winfo']=='email')
	{
		$queryCheckExistence="SELECT COUNT(id) FROM users WHERE email='".$_POST['cinfo']."'";
		$resultCheckExistence=mysqli_query($con,$queryCheckExistence);
		$rowCheckExistenceEmail=mysqli_fetch_array($resultCheckExistence);
		if(intval($rowCheckExistenceEmail['COUNT(id)'])==0)
		{
			$changeInfo=$_POST['cinfo'];
		}
		else
		{
			echo "Wpisany adres e-mail jest zajęty.<br/><strong>Wpisz inny</strong>";
		}
	}
	else
	{
		$changeInfo=$_POST['cinfo'];
	}
	if($changeInfo!='')
	{
		$query="UPDATE users SET ".$_POST['winfo']."='".$changeInfo."' WHERE useruid='".$_POST['uid']."'";
		mysqli_query($con,$query);
		echo 'done';
	}
?>