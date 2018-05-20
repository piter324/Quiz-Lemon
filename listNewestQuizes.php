<?php 
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");

	$query="SELECT * FROM quizes WHERE permission='PUB' ORDER BY id DESC LIMIT 6";
	$result=mysqli_query($con,$query);
	$number=1;
	while($row=mysqli_fetch_array($result))
	{
		if($number==1)
			echo "<div class='newestQuizMemberTable'>";
		
		if($number==1||$number==3||$number==5)
			echo "<div class='newestQuizMemberTableRow'>";
			
		echo "<div class='newestQuizMember' ";

		//sprawdzanie czy pictureurl!='' i wyswietlanie obrazka tła
		if($row['pictureurl']!='')
			echo "style=\"background-image:url('".$row['pictureurl']."')\"";

		echo " onclick=\"window.location='manageQuiz.php?qid=".$row['quizuid']."'\">
				<div class='inlinowe newestQuizMemberTitle' title='Źródło obrazka: ".$row['pictureurl']."'><div class='newestQuizOrderNumber'>".$number."</div><div class='newestQuizMemberTitleText'>".$row['name']."</div><button style='display:none' class='smallButton GoButton goToQuizButton inlinowe' onclick=\"window.location='manageQuiz.php?qid=".$row['quizuid']."'\"><img class='thirtyPixels' src='images/icons/Right-64.png'></button></div></div>";

		if($number==2||$number==4||$number==6)
			echo "</div>";
		if($number==6)
			echo "</div>";

			$number++;
	}
?>