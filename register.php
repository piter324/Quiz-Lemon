<?php
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");

	$uname=$_POST['uname'];
	$email=$_POST['email'];
	$pass=$_POST['pass'];
	$nands=$_POST['nameandsurname'];
	$encrypted=hash('sha256',$pass);
	$useruid=uniqid('user');
	$queryCheckExistence="SELECT COUNT(id) FROM users WHERE username='".$uname."'";
	$resultCheckExistence=mysqli_query($con,$queryCheckExistence);
	$rowCheckExistenceUname=mysqli_fetch_array($resultCheckExistence);
	$queryCheckExistence="SELECT COUNT(id) FROM users WHERE email='".$email."'";
	$resultCheckExistence=mysqli_query($con,$queryCheckExistence);
	$rowCheckExistenceEmail=mysqli_fetch_array($resultCheckExistence);
	if(intval($rowCheckExistenceEmail['COUNT(id)'])==0)
	{
	if(intval($rowCheckExistenceUname['COUNT(id)'])==0)
	{
		$query="INSERT INTO users (useruid,username,nameandsurname,password,email) VALUES ('".$useruid."','".$uname."','".$nands."','".$encrypted."','".$email."')";
		mysqli_query($con,$query);
		$_SESSION['useruid']=$useruid;
		echo "done";
	}
	else
	{
		echo "Wpisana nazwa użytkownika jest zajęta.<br/>Wpisz inną (np. użyj większej ilości cyfr czy znaków specjalnych)";
	}
	}
	else
	{
		echo "Podany adres e-mail jest już w użyciu.<br>Podaj inny adres e-mail";
	}

?>