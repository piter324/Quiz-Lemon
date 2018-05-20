<?php
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");

	$uname=$_POST['uname'];
	$email=$_POST['email'];
	$pass=$_POST['pass'];
	$enrypted=hash('sha256', $pass);
	$query="SELECT * FROM users WHERE username='".$uname."' OR email='".$email."'";
	$result = mysqli_query($con,$query);
	$loggedin=false;
	while($row=mysqli_fetch_array($result))
	{
		if($row['password']==$enrypted)
		{
			$_SESSION['useruid']=$row['useruid'];
			$loggedin=true;
		}
	}
	if($loggedin==true)
	{
		echo 'done';
	}
	else
	{
		echo 'Sprawdź czy wpisałeś poprawną nazwę użytkownika i hasło';
	}
?>