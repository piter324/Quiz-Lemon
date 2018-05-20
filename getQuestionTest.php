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
			getQuestions($con,$_SESSION['m']);
		}
		else
		{
			echo 'Nie masz uprawnień do korzystania z tego trybu!';
		}
	}
	else
	{
		getQuestions($con,$_SESSION['m']);
	}
	function getQuestions($con,$mode)
	{

		$nextPhrase=intval($_SESSION['curr'])+1;
		if($nextPhrase>=1&&$nextPhrase<=$_SESSION['questionsNumber'])
		{
			$_SESSION['curr']=$nextPhrase;
		}

		$answer='';
		$query="SELECT * FROM questions WHERE quizuid='".$_SESSION['qid']."' AND sequence=".$_SESSION['curr'];
		$result = mysqli_query($con,$query);
		$rowCurr = mysqli_fetch_array($result);
		if($rowCurr['answertype']=='radio')
		{
			$echol='miejsca:';
			//losowanie miejsca na odpowiedzi
			$answersPlaces[3];
			for($i=0;$i<3;$i++)
			{
				do
				{
					$generated=rand(0,2);
				}
				while(in_array($generated, $answersPlaces));
				$answersPlaces[$i]=$generated;
				$echol.="//".$generated."//";
			}
			//losowanie Sq do wzięcia z nich odpowiedzi
			$echol.='błędne odpowiedzi:';
			$answersSq[2];
			for($i=0;$i<2;$i++)
			{
				do
				{
					$generated=rand(1,$_SESSION['questionsNumber']);
				}
				while(in_array($generated, $answersSq)||$generated==$rowCurr['sequence']);
				$answersSq[$i]=$generated;
				$echol.="//".$generated."//";
			}
			//zapisywanie odpowiedniej odpowiedzi pod odpowiednim indeksem
			$answers[3];
			for($i=0;$i<3;$i++)
			{
				if($i==0)
				{
					if($mode=='1')
						$answers[$answersPlaces[0]]=$rowCurr['answer'];
					else if($mode=='2')
						$answers[$answersPlaces[0]]=$rowCurr['question'];
				}
				else
				{
					$query="SELECT question,answer FROM questions WHERE quizuid='".$_SESSION['qid']."' AND sequence=".$answersSq[$i-1];
					$result = mysqli_query($con,$query);
					$rowWrong = mysqli_fetch_array($result);
					if($mode=='1')
						$answers[$answersPlaces[$i]]=$rowWrong['answer'];
					else if($mode=='2')
						$answers[$answersPlaces[$i]]=$rowWrong['question'];
				}
				
			}
			for($i=0;$i<3;$i++)
			{
				$preAnswer.=$answers[$i]."&";
			}
			//echo $echol."@@".$preAnswer;
			$answer="multiple#".$preAnswer;	
		}
		else
		{
			$answer="single#Wpisz odpowiedź: <input type='text' id='textAnswer'>";
		}
		if($mode=='1')
			$_SESSION['rightAnswer']=$rowCurr['answer'];
		else if($mode=='2')
			$_SESSION['rightAnswer']=$rowCurr['question'];

		$query="SELECT * FROM questions WHERE quizuid='".$_SESSION['qid']."' AND sequence=".$_SESSION['curr'];
		$result = mysqli_query($con,$query);
		$rowCurr = mysqli_fetch_array($result);

		//echo $_SESSION['curr']."$".$_SESSION['questionsNumber'];
		if($mode=='1')
			echo $rowCurr['question']."#".$answer."#".$_SESSION['curr']."#".$_SESSION['questionsNumber'];
		else if($mode=='2')
			echo $rowCurr['answer']."#".$answer."#".$_SESSION['curr']."#".$_SESSION['questionsNumber'];
	}
?>