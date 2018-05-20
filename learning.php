<?php
	session_start();
	$_SESSION['taken']='';
	$_SESSION['curr']=1;
	if(!isset($_SESSION['qid']))
	{
		$_SESSION['qid']=$_GET['qid'];
	}
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");
	$query="SELECT * FROM quizes WHERE quizuid='".$_SESSION['qid']."'";
	$result=mysqli_query($con,$query);
	$row=mysqli_fetch_array($result);

	$queryList="SELECT * FROM questions WHERE quizuid='".$_SESSION['qid']."' ORDER BY sequence";
	$resultList=mysqli_query($con,$queryList);

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
	if($row['modes'][0]=='0')
	{
		header('Location:index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $row['name']." - tryb nauki";?></title>
<meta charset="UTF-8">
<link rel='stylesheet' href='styles/learning.css'>
<link rel='stylesheet' href='styles/buttons.css'>
<link rel='stylesheet' href='styles/general.css'>
<link rel='stylesheet' href='dialogAPI/dialogBox.css'>
<link href='http://fonts.googleapis.com/css?family=Roboto:500,900,300,700,400&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<script src='js/jquery.js'></script>
<script src='dialogAPI/showDialog.js'></script>
<script src='js/general.js'></script>
<script>
var questionCount;
var currentQuestion;
var timed=false;
var pickedTime=1000;
$(document).ready(function(){
	getDateAndTime();
	getQuestion(0);
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
function getQuestion(step)
{
	$.post('getQuestion.php',{step:step},function(data){
		//alert(data);
		var dane = data.split('#');
		$('div#singleQuestion').html(dane[0]);
		$('div#singleAnswer').html(dane[1]);
		$('div#currentQuestion').html(dane[2]);
		currentQuestion=dane[2];
		$('div#questionCount').html(dane[3]);
		questionCount=dane[3];
	});
}
function startTimed()
{
	pickedTime=parseInt(($('input#changeInterval').val())*1000);
	alert(pickedTime);
	timed=true;
}
function stopTimed()
{
	timed=false;
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
		echo "<br/><button class='backButton verySmallButton' onclick='history.back()'>Wróć</button>"; ?></p>
	</div>
</div>
<div id='contentContainer'>
<div id='quizAndModeTitle'>
	<p id='quizTitle'><?php echo $row['name'];?></p>
	<p id='modeTitle'>tryb nauki</p>
</div>
<div id='singleQuestionContainer'>
<div id='singleQuestion'>
</div>
<div id='singleAnswer'>
</div>
<div id='singleQuestionActions'>
	<div id='countQuestions'><div class='inlinowe' id='currentQuestion'></div>/<div class='inlinowe' id='questionCount'></div></div>
	<div id='singleQuestionActionButtons'>
		<div class='inlinowe singleQuestionActionButton' onclick='getQuestion(-1)'><img class='singleQuestionArrow' src='images/icons/Left-64.png'></div>
		<div class='inlinowe singleQuestionActionButton' onclick='getQuestion(1)'><img class='singleQuestionArrow' src='images/icons/Right-64.png'></div>
	</div>
	<div id='timedChange' style='display:none'>
		<p style='margin-bottom:0px'>Automatyczna zmiana frazy</p>
		<p style='font-size:20px; margin-top:0px'>Ilość sekund: <input type='number' min=1 value=1 id='changeInterval'>
		<button class='smallButton OKButton' onclick='startTimed()'>Start</button><button class='smallButton OKButton' onclick='stopTimed()'>Stop</button></p>
	</div>
</div>
</div>
<div id='questionsListContainer'>
	<div id='questionsList'>
		<?php
			while($rowList=mysqli_fetch_array($resultList))
			{
				echo "<div class='questionsListMember'>
						<div class='questionsListMemberCell questionsListMemberQuestion'>".$rowList['question']."</div>
						<div class='questionsListMemberCell'>".$rowList['answer']."</div>
					</div>";
			}
		?>
	</div>
</div>
</div>
</div>
<div id='footer'>
</div>
</body>
</html>