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
		$query="SELECT * FROM questions WHERE quizuid='".$_SESSION['qid']."' ORDER BY sequence";
		$result=mysqli_query($con,$query);
		$found=false;
		while($row=mysqli_fetch_array($result))
		{
			if($row['id']==$_POST['idToDelete'])
			{
				$queryDelete="DELETE FROM questions WHERE id=".$row['id'];
				mysqli_query($con,$queryDelete);
				$found=true;
				$startingSequence=intval($row['sequence'])-1;
			}
			if($found==true)
			{
				$queryUptd="UPDATE questions SET sequence=".$startingSequence." WHERE id=".$row['id'];
				mysqli_query($con,$queryUptd);
				$startingSequence++;
			}
		}
		echo 'done';
	}
	else
	{
		echo "Nie masz uprawnień do usunięcia pytań!";
	}
?>