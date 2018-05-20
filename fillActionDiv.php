<?php
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");
	$query="SELECT * FROM quizes WHERE quizuid='".$_POST['qid']."'";
	$result=mysqli_query($con,$query);
	$row=mysqli_fetch_array($result);

	if($_POST['actionID']=='deleteQuiz')
	{
		echo "<p style='text-align:center'>Czy napewno chcesz usunąć quiz?&emsp;&emsp;<button onclick='deleteQuiz()' class='yesButton smallButton'><img class='inlinowe' src='images/icons/Checkmark-64.png' style='width:20px; height:20px'><span class='inlinowe' style='margin-left:10px;'>Tak</span></button> <button onclick='actionDivUp()' class='noButton smallButton'><img class='inlinowe' src='images/icons/Delete-Sign-64.png' style='width:20px; height:20px'><span class='inlinowe' style='margin-left:10px;'>Nie</span></button></p>";
	}
	else if($_POST['actionID']=='shareQuiz')
	{
		echo "<h2>Wybierz opcje udostępniania: <img style='float:right; width:40px; height:40px' src='images/icons/Close-64.png' onclick='actionDivUp()'></h2>
		<p><input type='radio' class='sharingOptionsRadio' id='shareEveryone' name='sharingOptionsRadio' value='PUB'";
		if($row['permission']=='PUB') {echo "checked";}
		echo"><label for='shareEveryone'> Udostępniaj wszystkim</label><br/>Po wybraniu tej opcji quiz będzie dostępny publicznie i pojawi się na liście na główniej stronie.</p>
		<p><input type='radio' class='sharingOptionsRadio' id='shareWithLink' name='sharingOptionsRadio' value='SEL'";
		if($row['permission']=='SEL') {echo "checked";}
		echo "><label for='shareWithLink'> Udostępnij posiadającym link</label><br/><span id='sharingLink'><a href='http://quizlemon.pl/manageQuiz.php?qid=".$row['quizuid']."'>http://quizlemon.pl/manageQuiz.php?qid=".$row['quizuid']."</a></span></p>
		<p><input type='radio' class='sharingOptionsRadio' id='doNotShare' name='sharingOptionsRadio' value='PRI'";
		if($row['permission']=='PRI') {echo "checked";}
		echo "><label for='doNotShare'> Nie udostępniaj</label></p>";
		echo "<p><button onclick='changeSharingSettings()' class='yesButton bigButton'><img class='inlinowe' src='images/icons/Checkmark-64.png' style='width:20px; height:20px'><span class='inlinowe' style='margin-left:10px;'>Potwierdź</span></button><button onclick='actionDivUp()' class='noButton bigButton'><img class='inlinowe' src='images/icons/Delete-Sign-64.png' style='width:20px; height:20px'><span class='inlinowe' style='margin-left:10px;'>Anuluj</span></button></p>";
	}
	else if($_POST['actionID']=='editQuiz')
	{
		echo "<h2>Edytuj quiz<img style='float:right; width:40px; height:40px' src='images/icons/Close-64.png' onclick='actionDivUp()'></h2>
		<div id='editMetadata' style='margin-bottom:30px'><h3>Edytuj metadane:</h3>
		<p>Zmień nazwę quizu: <input type='text' id='newQuizName' maxlength=100 value='".$row['name']."'> <button class='smallButton OKButton' onclick=\"changeQuizMetadata('name')\">Zmień</button></p>
		<p>Wybierz dostępne tryby rozwiązywania:<br/>
		<input type='checkbox' name='modes' val='learning' id='1'";
		if($row['modes'][0]=='1') {echo "checked";} 
		echo "><label for='1'> Tryb nauki</label><br/>
		<input type='checkbox' name='modes' val='testing1' id='3'";
		if($row['modes'][1]=='1') {echo "checked";} 
		echo "><label for='3'> Tryb testu (fraza → wyjaśnienie)</label><br/>
		<input type='checkbox' name='modes' val='testing2' id='5'";
		if($row['modes'][2]=='1') {echo "checked";} 
		echo "><label for='5'> Tryb testu (wyjaśnienie → fraza)</label><br/>
		<button class='smallButton OKButton' onclick=\"changeQuizMetadata('modes')\">Zmień</button></p>
		<p>Dodaj/zmień adres obrazka quizu: <input type='text' id='newQuizPictureUrl' value='".$row['pictureurl']."'> <button class='smallButton OKButton' onclick=\"changeQuizMetadata('pictureurl')\">Zmień</button><br/><strong>Uwaga!</strong> Pamiętaj, że podając adres obrazka oświadczasz, że masz pozwolenie na jego użycie.</p>
		</div>
		<div id='addQuestions'>
		<div id='addSingle'>
			<h3>Dodaj pytania:</h3>
			<h4>Dodaj pojedyncze pytanie</h4>
			<div class='inlinowe'>
			<p>Pytanie/fraza: <input type='text' id='singleQuestion'></p>
			<p>Odpowiedź: <input type='text' id='singleAnswer'></p>
			<p>Typ odpowiedzi: <select id='singleAnswerType'>
			<option value='radio'>wielokrotny wybór</option>
			<option value='text'>wpisanie odpowiedzi</option>
			</select></p>
			<p>Chcę dodać pytania: <select id='newSingleQuestionPosition'>
			<option value='beginning'>na początku aktualnej listy</option>
			<option value='end' selected>na końcu aktualnej listy</option>
			</select>
			</p>
			</div>
			<div class='inlinowe buttonEditQuestions' onclick='addSingleQuestion()'>
			<img src='images/icons/Plus-64.png'><br/>Dodaj
			</div>
		</div>
		<div id='addMultiple'>
		<h4>Dodaj wiele pytań/fraz</h4>
		<p style='margin-top:0px'>Aby poprawnie dodać wiele fraz wpisz je w polu poniżej w ten sposób: pytanie - odpowiedź (np. apple - jabłko), po jednej takiej zbitce na linijkę pola tekstowego. <strong>Ważne jest zachowanie spacji z jednej i drugiej strony myślnika między pytaniem i odpowiedzią!</strong></p>
			<p>Typ odpowiedzi dla wszystkich pytań: <select id='multipleAnswerType'>
			<option value='radio'>wielokrotny wybór</option>
			<option value='text'>wpisanie odpowiedzi</option>
			</select><br/>
			Chcę dodać pytania: <select id='newMultipleQuestionsPosition'>
			<option value='beginning'>na początku aktualnej listy</option>
			<option value='end' selected>na końcu aktualnej listy</option>
			</select>
			</p>
			<p>
			<div class='inlinowe'>
			<textarea id='multipleQuestionsTextarea'></textarea>
			</div>
			<div class='inlinowe buttonEditQuestions' onclick='addMultipleQuestions()'>
			<img src='images/icons/Plus-64.png'><br/>Dodaj
			</div>
			</p>
		</div>
		<div id='showAndEditQuestions'></div></div>";
	}
?>