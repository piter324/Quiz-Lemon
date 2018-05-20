<?php 
	session_start();
	unset($_SESSION['taken']);
	$_SESSION['taken'][]=array();
	$_SESSION['curr']=0;
	$_SESSION['points']=0;
	if(!isset($_SESSION['qid']))
	{
		$_SESSION['qid']=$_GET['qid'];
	}
	if(isset($_GET['m']))
		{
			$m=$_GET['m'];
			$_SESSION['m']=$_GET['m'];
		}
	else
		{
			$m=1;
			$_SESSION['m']=1;
		}
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");
	$query="SELECT * FROM quizes WHERE quizuid='".$_SESSION['qid']."'";
	$result=mysqli_query($con,$query);
	$row=mysqli_fetch_array($result);

	$queryList="SELECT * FROM questions WHERE quizuid='".$_SESSION['qid']."' ORDER BY sequence";
	$resultList=mysqli_query($con,$queryList);
	$queryCount="SELECT COUNT(id) FROM questions WHERE quizuid='".$_SESSION['qid']."' ORDER BY sequence";
	$resultCount=mysqli_query($con,$queryCount);
	$rowCount=mysqli_fetch_array($resultCount);
	$_SESSION['questionsNumber']=$rowCount['COUNT(id)'];

	if(isset($_SESSION['useruid']))
	{
		$queryuser="SELECT * FROM users WHERE useruid='".$_SESSION['useruid']."'";
		$resultuser=mysqli_query($con,$queryuser);
		$rowuser=mysqli_fetch_array($resultuser);
	}

	if($row['permission']=='PRI')
	{
		if($row['owneruid']!=$_SESSION['useruid'])
		{	
			header('Location:index.php');
		}
	}
	if($row['modes'][$m]=='0')
	{
		header('Location:index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $row['name']." - tryb testu";?></title>
<meta charset="UTF-8">
<link rel='stylesheet' href='styles/testing.css'>
<link rel='stylesheet' href='styles/buttons.css'>
<link rel='stylesheet' href='styles/general.css'>
<link rel='stylesheet' href='dialogAPI/dialogBox.css'>
<link href='http://fonts.googleapis.com/css?family=Roboto:500,900,300,700,400&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<script src='js/jquery.js'></script>
<script src='dialogAPI/showDialog.js'></script>
<script src='js/general.js'></script>
<script>
const questionCount=<?php echo $rowCount['COUNT(id)'];?>;
var currentQuestion=<?php echo $_SESSION['curr'];?>;
var timed=false;
var pickedTime=1000;
var checked=true;
var answerType='';
$(document).ready(function(){
	getDateAndTime();
	getQuestion(0);
	getPoints();
	setFooter();
});
setInterval(function(){
	getDateAndTime();
},1000);

setInterval(function(){
	if(timed==true)
		{
			getQuestion(1);
			if(currentQuestion==questionCount)
			{
				timed=false;
			}
		}
},pickedTime);
function getDateAndTime()
{
	$.post('getDateAndTime.php',{},function(data){
		var dateandtime = data.split('#');
		$('p#upMetaDate').html(dateandtime[0]);
		$('p#upMetaHour').html(dateandtime[1]);
	});
}
function randomPhrase(step)
{
	$.post('randomPhrase.php',{step:step},function(data){

	});
}
function getQuestion()
{
	if(checked==true)
	{
		$('div#checkButton').html('SPRAWDŹ');
		$.post('getQuestionTest.php',{},function(data){
		//alert(data);
		var dane = data.split('#');
		$('div#singleQuestion').html(dane[0]);
		if(dane[1]=='single')
		{
			$('div#singleAnswer').html(dane[2]);
			answerType='single';
		}
		else if(dane[1]=='multiple')
		{
			var multipleAnswers=dane[2].split('&');
			$('div#singleAnswer').html("<p class='answerLine'><input type='radio' name='answer' value='"+multipleAnswers[0]+"' id='"+multipleAnswers[0]+"'><label for='"+multipleAnswers[0]+"'>"+multipleAnswers[0]+"</label></p>	<p class='answerLine'><input type='radio' name='answer' value='"+multipleAnswers[1]+"' id='"+multipleAnswers[1]+"'><label for='"+multipleAnswers[1]+"'>"+multipleAnswers[1]+"</label></p>	<p class='answerLine'><input type='radio' name='answer' value='"+multipleAnswers[2]+"' id='"+multipleAnswers[2]+"'><label for='"+multipleAnswers[2]+"'>"+multipleAnswers[2]+"</label></p>");
			answerType='multiple';
		}
		$('div#currentQuestion').html(dane[3]);
		currentQuestion=dane[3];
		$('div#questionCount').html(dane[4]);
		questionCount=dane[4];
	});
	checked=false;
	$('div#nextQuestionButton').hide();
	}
}
function checkAnswer()
{
	if(currentQuestion<=questionCount)
	{
		if(checked==false)
		{
			if(answerType=='single')
			{
				var answer=$('input#textAnswer').val();
			}
			else if(answerType=='multiple')
			{
				var answer=$('input:radio[name=answer]:checked').val();
			}
			$.post('checkAnswer.php',{answer:answer},function(data){
				var dane=data.split('#');
				$('div#checkButton').html(dane[0]);
				if(dane[0]=='ŹLE!')
					$('div#singleAnswer').html("<p class='answerLine'><span style='font-size:30px'>Poprawna odpowiedź:<br/></span>"+dane[1]+"</p>");
			});
		
			checked=true;
			getPoints();
		}
		if(currentQuestion!=questionCount)
		{
			$('div#nextQuestionButton').show();
		}
		if(currentQuestion==questionCount)
		{
			$('div#repeatTestButton').show();
		}
	}
	
}
function getPoints()
{
	$.post('getPoints.php',{},function(data){
		$('div#currentPoints').html(data);
		$('div#allPoints').html(questionCount);
	});
}
function logOut()
{
	$.post('logout.php',{},function(data){
		if(data=='done')
		{
			//showDialog("Informacja","Wylogowano pomyślnie",false,"OK&refresh()");
			//window.location='index.php';
			location.reload();
		}
		else
		{
			showDialog("Błąd!",data,true);
		}
	});
}
</script>
<body>
<div id='totalContainer'>
<div id='upContainer'>
	<img class='inlinowe upLogo' src='images/logo.png'/>
	<div id='upMeta' class='inlinowe'>
		<p id='upMetaHour'></p>
		<p id='upMetaDate'></p>
		<p id='upMetaUsername'><?php if(isset($_SESSION['useruid'])&&$_SESSION['useruid']!='') {echo $rowuser['username']."<br/><button class='logOutButton verySmallButton' onclick='logOut()'>Wyloguj się</button>";} else { echo "Gość"; } 
		echo "<br/><button class='backButton verySmallButton' onclick='history.back()'>Wróć</button>";?></p>
	</div>
</div>
<div id='contentContainer'>
<div id='quizAndModeTitle'>
	<p id='quizTitle'><?php echo $row['name'];?></p>
	<p id='modeTitle'>tryb testu (<?php 
		if($m==1)
			echo "fraza → wyjaśnienie";
		else if($m==2)
			echo "wyjaśnienie → fraza ";
	?>)</p>
</div>
<div id='singleQuestionContainer'>
<div id='singleQuestion'>
</div>
<div id='singleAnswer'>
</div>
<div id='singleQuestionActions'>
	<div id='countQuestions'><div class='inlinowe' id='currentQuestion'></div>/<div class='inlinowe' id='questionCount'></div></div>
	<div id='countPoints'>Punkty: <div class='inlinowe' id='currentPoints'></div>/<div class='inlinowe' id='allPoints'></div><div class='inlinowe singleQuestionSmallActionButton' id='refreshPoints' onclick='getPoints()'><img class='inlinowe twentyPixels' src='images/icons/Refresh-64.png'><span class='inlinowe' style='margin-left:5px; display:none'>odśwież</span></div></div>
	<div id='singleQuestionActionButtons'>
		<div class='inlinowe singleQuestionActionButton' id='checkButton' onclick='checkAnswer()'>SPRAWDŹ</div>
		<div class='inlinowe singleQuestionActionButton' id='nextQuestionButton' style='display:none' onclick='getQuestion()'><img id='singleQuestionArrow' src='images/icons/Right-64.png'></div>
		<div class='inlinowe singleQuestionActionButton' id='repeatTestButton' style='display:none' onclick='location.reload()'><img class='inlinowe' style='width:50px; height:50px' src='images/icons/Repeat-64.png'><span class='inlinowe' style='margin-left:10px'>Powtórz test</span></div>
	</div>
</div>
</div>
</div>
</div>
<div id='footer'>
</div>
</body>
</html>