<?php 
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");

	$query="SELECT * FROM quizes WHERE name LIKE '%".$_POST['searchQuery']."%' AND permission='PUB' ORDER BY name ASC LIMIT 10";
	$result=mysqli_query($con,$query);
	while($row=mysqli_fetch_array($result))
	{
		$queryUser="SELECT username FROM users WHERE useruid='".$row['owneruid']."'";
		$resultUser=mysqli_query($con,$queryUser);
		$rowUser=mysqli_fetch_array($resultUser);

		echo "<div class='quizesListMember' onclick=\"window.location='manageQuiz.php?qid=".$row['quizuid']."'\">
				<div class='quizesListMemberTitle'><div class='inlinowe quizesListMemberTitleText'>".$row['name']."</div><button style='display:none' class='verySmallButton GoButton goToQuizButton inlinowe' onclick=\"window.location='manageQuiz.php?qid=".$row['quizuid']."'\"><img class='twentyPixels' src='images/icons/Right-64.png'></button></div>
				<div class='quizesListMemberTable'>
				<div class='quizesListMemberRow'>
					<div class='quizesListMemberCell quizCategory'>Kategoria</div>
					<div class='quizesListMemberCell quizCreator'>Dodano: ".$row['addeddate']." o ".$row['addedhour']."</div>
					<div class='quizesListMemberCell quizCreator'>autor: ".$rowUser['username']."</div>
					<div class='quizesListMemberCell quizTimesDone'>wykonano ".$row['timesdone'];
					if($row['timesdone']==1)
						echo " raz";
					else
						echo " razy";

					echo "</div>
				</div>
				</div>
				</div>";
	}
?>