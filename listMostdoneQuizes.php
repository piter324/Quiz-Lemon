<?php 
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");
	$query="SELECT * FROM quizes WHERE permission='PUB' ORDER BY timesdone DESC LIMIT 6";
	$result=mysqli_query($con,$query);
	$number=1;
	
	while($row=mysqli_fetch_array($result))
	{
		if($number==1)
			echo "<div class='mostdoneQuizMemberTable'>";
		
		if($number==1||$number==3||$number==5)
			echo "<div class='mostdoneQuizMemberTableRow'>";
			
		echo "<div class='mostdoneQuizMember' ";

		//sprawdzanie czy pictureurl!='' i wyswietlanie obrazka tła
		if($row['pictureurl']!='')
			echo "style=\"background-image:url('".$row['pictureurl']."')\"";

		echo " onclick=\"window.location='manageQuiz.php?qid=".$row['quizuid']."'\">
				<div class='inlinowe mostdoneQuizMemberTitle' title='Źródło obrazka: ".$row['pictureurl']."'><div class='mostdoneQuizMemberTitleTimesdone'>".$row['timesdone']."</div><div class='mostdoneQuizMemberTitleTimesdoneText'>"; 
				if($row['timesdone']==1)
						echo " wykonanie";
					else if ($row['timesdone']>1&&$row['timesdone']<5)
						echo " wykonania";
					else
						echo " wykonań";
				echo "</div><div class='mostdoneQuizMemberTitleText'>".$row['name']."</div><button style='display:none' class='smallButton GoButton goToQuizButton inlinowe' onclick=\"window.location='manageQuiz.php?qid=".$row['quizuid']."'\"><img class='thirtyPixels' src='images/icons/Right-64.png'></button></div></div>";

		if($number==2||$number==4||$number==6)
			echo "</div>";
		if($number==6)
			echo "</div>";

			$number++;


		//echo "<div class='mostdoneQuizMember' onclick=\"window.location='manageQuiz.php?qid=".$row['quizuid']."'\">
				//<div class='inlinowe mostdoneQuizMemberTitle'><div class='inlinowe mostdoneQuizOrderNumber'>".$number."</div><div class='inlinowe mostdoneQuizMemberTitleText'>".$row['name']."<div class='mostdoneQuizMemberTitleTimesdone'>wykonania: ".$row['timesdone']."</div></div></div>
			//</div>";
			//$number++;
	}
?>