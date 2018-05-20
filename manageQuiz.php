<?php 
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$_SESSION['qid']=$_GET['qid'];
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");
	$query="SELECT * FROM quizes WHERE quizuid='".$_GET['qid']."'";
	$result=mysqli_query($con,$query);
	$row=mysqli_fetch_array($result);

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
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $row['name']." - Quiz Lemon";?></title>
<meta charset="UTF-8">
<link rel='image_src' href='<?php echo $row['pictureurl'];?>'>
<link rel='icon' href='images/favicon.png'>
<link rel='stylesheet' href='styles/manageQuiz.css'>
<link rel='stylesheet' href='styles/buttons.css'>
<link rel='stylesheet' href='styles/general.css'>
<link rel='stylesheet' href='dialogAPI/dialogBox.css'>
<link href='http://fonts.googleapis.com/css?family=Roboto:500,900,300,700,400&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<script src='js/jquery.js'></script>
<script src='dialogAPI/showDialog.js'></script>
<script src='js/general.js'></script>
<script>
var d = new Date();
const qid = '<?php echo $_GET['qid'];?>';
$(document).ready(function(){
	setFooter();
	getDateAndTime();
	countQuestions();

	var picture = '';
	picture = "<?php if($row['pictureurl']!='')
		{
			echo $row['pictureurl'];
		}?>";
	if(picture!='')
	{
		//$('body').css('background-image','url('+picture+')');
	}
	//showPleaseWait();
	//$('div.action').css('height',$('div.action').width()/2);
	//$('div.mode').css('height',$('div.mode').width()/2);

	var bufor;
	var colorek;
	var colors;
	$('div.action').mouseenter(function(){
		
		colorek = $(this).css('background-color');
		bufor=colorek;
		colorek = colorek.replace('rgb(','');
		colorek = colorek.replace(')','');
		colors = colorek.split(',');
		$(this).css('background-color','rgb('+(parseInt(colors[0])+20)+','+(parseInt(colors[1])+20)+','+(parseInt(colors[2])+20)+')');
	}).mouseleave(function(){
		$(this).css('background-color',bufor);
	});

	$('div.mode').mouseenter(function(){
		colorek = $(this).css('background-color');
		bufor=colorek;
		colorek = colorek.replace('rgb(','');
		colorek = colorek.replace(')','');
		colors = colorek.split(',');
		$(this).css('background-color','rgb('+(parseInt(colors[0])+20)+','+(parseInt(colors[1])+20)+','+(parseInt(colors[2])+20)+')');
	}).mouseleave(function(){
		$(this).css('background-color',bufor);
	});

	$('div.action').click(function(){
		$('div#actionDiv').css('background-color',bufor);
		var actionID = $(this).attr('id');
		$.post('fillActionDiv.php',{actionID:actionID,qid:"<?php echo $_SESSION['qid'];?>"},function(data){
			$('div#actionDiv').html(data).slideDown();
			if(actionID=='editQuiz')
			{
				listQuestions();
			}
			$('html,body').animate({
				scrollTop: $('div#actionDiv').offset().top
			},'slow');
		});
		
	});

	/*if(<?php if(isset($_SESSION['useruid'])) { echo $row['owneruid']==$rowuser['useruid']; } else {echo 0; }?>)
	{
		$('div#actionsTableContainer').load('actionsTable.php?'+d.getTime());
	}*/
});


setInterval(function(){
	getDateAndTime();
},1000);
function getDateAndTime()
{
	var currDate=new Date();
	var m,s,month; m=s=month="";
	if(currDate.getMinutes()<10)
		m="0"+currDate.getMinutes();
	else
		m=currDate.getMinutes();
	if(currDate.getSeconds()<10)
		s="0"+currDate.getSeconds();
	else
		s=currDate.getSeconds();
	if((currDate.getMonth()+1)<10)
		month="0"+(currDate.getMonth()+1);
	else
		month=currDate.getMonth()+1;
	$('p#upMetaHour').html(currDate.getHours()+":"+m+":"+s);
	$('p#upMetaDate').html(currDate.getDate()+"."+month+"."+currDate.getFullYear());
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
function deleteQuiz() 
{
	$('body').css('cursor','wait');
	$.post('deleteQuiz.php',{},function(data){
		if(data=='done')
		{
			showDialog('Sukces!','Pomyślnie usunięto quiz',false,"OK&window.history.back()");
		}
		else
		{
			showDialog('Błąd!',data,true);
		}
		$('body').css('cursor','default');
	});
}
function changeSequence(currID,step)
{
	$('body').css('cursor','wait');
	$.post('changeSequence.php',{currID:currID,step:step},function(data){
		if(data=='done')
		{
			listQuestions();
		}
		else
		{
			showDialog('Błąd!',data,true);
		}
		$('body').css('cursor','default');
	});
}
function listQuestions()
{
	$.post('listQuestions.php',{},function(data){
		$('div#showAndEditQuestions').html(data);
	});
	closeDialog();
}
function showEditingCanvas(id)
{
	$('body').css('cursor','wait');
	$.post('showEditingCanvas.php',{questionid:id},function(data){
		var dane=data.split('#');
		$('div#question'+id).html(dane[0]);
		$('div#answer'+id).html(dane[1]);
		$('div#answerType'+id).html(dane[2]);
		$('div#actions'+id).html(dane[3]);
		$('body').css('cursor','default');
	});
}
function showAdvancedSettings(id)
{
	$('div#advanced'+id).slideDown();
}
function showQuizPicture()
{
	$('body').css('cursor','wait');
	$('img#quizPicture').attr('src','<?php echo $row['pictureurl'];?>');
	$('div#quizPictureContainer').fadeIn(500);
	var windowHeight = $(window).height();
	var imageHeight = $('img#quizPicture').height();
	var imageWidth = $('img#quizPicture').width();
	$('img#quizPicture').css('margin-top',windowHeight/2-imageHeight/2);
	$('p#pictureUrlText').width(imageWidth+10);
	$('body').css('cursor','default');
}
function hideQuizPicture()
{
	$('div#quizPictureContainer').fadeOut(500);
}
function editQuestion(id)
{
	$('body').css('cursor','wait');
	var newQuestion = $('input#newQuestion'+id).val();
	var newAnswer = $('input#newAnswer'+id).val();
	var newAnswerType = $('select#newAnswerType'+id).val();

	$.post('editQuestion.php',{questionID:id,nQ:newQuestion,nA:newAnswer,nAT:newAnswerType},function(data){
		if(data=='done')
		{
			showDialog('Sukces!','Pomyślnie dokonano edycji pytania!',false,"OK&listQuestions()");
		}
		else
		{
			showDialog('Błąd!',data,true);
		}
		$('body').css('cursor','default');
	})
}
function deleteQuestion(idToDelete)
{
	$('body').css('cursor','wait');
	$.post('deleteQuestion.php',{idToDelete:idToDelete},function(data){
		if(data=='done')
		{
			showDialog('Sukces!','Pomyślnie usunięto pytanie!',false,"OK&listQuestions()");
		}
		else
		{
			showDialog('Błąd!',data,true);
		}
		$('body').css('cursor','default');
	});
}
function changeSharingSettings()
{
	$('body').css('cursor','wait');
	var selectedPermission = $('input:radio[name=sharingOptionsRadio]:checked').val();
	$.post('changeSharingSettings.php',{newpermissions:selectedPermission},function(data){
		if(data=='done')
		{
			showDialog('Sukces!','Pomyślnie zmieniono ustawienia udostępniania',false,"OK&location.reload()");
		}
		else
		{
			showDialog('Błąd!',data,true);
		}
		$('body').css('cursor','default');
	});
}
function actionDivUp()
{
	$('div#actionDiv').slideUp();
	$('html,body').animate({
				scrollTop: 0
			},'slow');
}
function changeQuizMetadata(metatype)
{
	$('body').css('cursor','wait');
	var dataToPass;
	//alert('lol');
	if(metatype=='name')
	{
		dataToPass=$('input:text#newQuizName').val();
	}
	else if(metatype=='modes')
	{
		var suma = 0;
		dataToPass=$('input:checkbox:checked[name=modes]').map(function(){
				suma+=parseInt(this.id);
			}).get();
		var possibleValues=['','100','','010','110','001','101','','011','111'];
		dataToPass=possibleValues[suma];
	}
	else if(metatype=='pictureurl')
	{
		dataToPass=$('input:text#newQuizPictureUrl').val();
	}
	if(dataToPass!='')
	{
	$.post('changeQuizMetadata.php',{metatype:metatype,dataToPass:dataToPass},function(data){
			if(data=='done')
			{
				showDialog('Sukces!','Pomyślnie zmodyfikowano metadane quizu',false,"OK&location.reload()");
			}
			else
			{
				showDialog('Błąd!',data,true);
			}
		});
	}
	else
	{
		showDialog('Błąd!','Upewnij się, że nie pozostawiłeś pola pustego lub niezaznaczonego',true);
	}
	$('body').css('cursor','default');
}
function addSingleQuestion()
{
	$('body').css('cursor','wait');
	var question = $('input:text#singleQuestion').val();
	var answer = $('input:text#singleAnswer').val();
	var answerType = $('select#singleAnswerType').val();
	var newQuestionsPosition = $('select#newSingleQuestionPosition').val();
	//alert(question+" "+answer+" "+answerType);
	$.post('addSingleQuestion.php',{question:question,answer:answer,answerType:answerType,newQuestionsPosition:newQuestionsPosition},function(data){
		hidePleaseWait();
		if(data=='done')
		{
			showDialog('Sukces!','Pomyślnie dodano pojedyncze pytanie',false,"OK&clearQuestionFields('single')");
		}
		else
		{
			showDialog('Błąd!',data,true);
		}
		$('body').css('cursor','default');
	});
}
function addMultipleQuestions()
{
	$('body').css('cursor','wait');
	var answerType = $('select#multipleAnswerType').val();
	var newQuestionsPosition = $('select#newMultipleQuestionsPosition').val();
	var dataToPass = $('textarea#multipleQuestionsTextarea').val();
	//alert(dataToPass+" "+answerType);
	$.post('addMultipleQuestions.php',{dataToPass:dataToPass,answerType:answerType,newQuestionsPosition:newQuestionsPosition},function(data){
		if(data=='done')
		{
			showDialog('Sukces!','Pomyślnie dodano wiele pytań',false,"OK&clearQuestionFields('multiple')");
		}
		else
		{
			showDialog('Błąd!',data,true);
		}
		$('body').css('cursor','default');
	});
}
function clearQuestionFields(fieldsType)
{
	if(fieldsType=='single')
	{
		$('input:text#singleQuestion').val('');
		$('input:text#singleAnswer').val('');
	}
	else if(fieldsType=='multiple')
	{
		$('textarea#multipleQuestionsTextarea').val('');
	}
	closeDialog();
	countQuestions();
	listQuestions();
}
function countQuestions()
{
	$.post('countQuestions.php',{},function(data){
		$('div#countQuestions').html(data);
	});
}
function goTo(site)
{
	window.location.href=site;
}
</script>
<body>
<div id='quizPictureContainer' onclick='hideQuizPicture()'>
	<img id='quizPicture' alt='Nie można było wyświetlić obrazka'>
	<p id='pictureUrlText'>Źródło obrazka: <a href='<?php echo $row['pictureurl'];?>'><?php echo $row['pictureurl'];?></a></p>
</div>

<div id='pleaseWaitContainer'>
	<div id='pleaseWaitText'>
		PROSZĘ CZEKAĆ...
	</div>
</div>

<div id='dialogSpace'><div id='dialogBox'>
<div id='dialogBoxTitleBar'><div id='dialogBoxTitle' class='inlinowe'>".$_POST['title']."</div><div id='closingx' class='inlinowe'><img class='closingxwhite' src='images/closingxwhite.png'></div></div>
<div id='dialogBoxContent'>".$_POST['content']."</div>
</div>
</div>

<div id='totalContainer'>
<div id='upContainer'>
	<img class='inlinowe upLogo' src='images/logo.png'/>
	<div id='upMeta' class='inlinowe'>
		<p id='upMetaHour'></p>
		<p id='upMetaDate'></p>
		<p id='upMetaUsername'><?php if(isset($_SESSION['useruid'])&&$_SESSION['useruid']!='') {echo $rowuser['username']."<br/><button class='logOutButton verySmallButton' onclick='logOut()'>Wyloguj się</button>";} else { echo "Gość"; }
		echo "<br/><button class='backButton verySmallButton' onclick=\"goTo('index.php')\">Wróć</button>"; ?></p>
	</div>
</div>
<div id='contentContainer'>
<div id='quizname'><?php echo $row['name'];?></div>

<div id='metaTable'>
<div class='metaTableRow'>
	<div class='metaInfoMember' id='authorInfo'>Dodany przez: <?php 
		$queryauthor="SELECT username FROM users WHERE useruid='".$row['owneruid']."'";
		$resultauthor=mysqli_query($con,$queryauthor);
		$rowauthor=mysqli_fetch_array($resultauthor);
		echo $rowauthor['username'];?></div>
	<div class='metaInfoMember' id='addedDateAndTime'>Dodano <?php echo $row['addeddate'];?> o godzinie <?php echo $row['addedhour'];?></div>
	<div class='metaInfoMember' id='timesDone'>Wykonano <?php echo $row['timesdone']." ";
	if($row['timesdone']==1)
		echo "raz";
	else
		echo "razy";
	?></div>
	<div class='metaInfoMember' id='sharingSettings'><?php if($row['permission']=='PUB')
		echo "Quiz publiczny";
	else if($row['permission']=='PRI')
		echo "Quiz prywatny";
	else if($row['permission']=='SEL')
		echo "Quiz udostępniony posiadającym link";
	?></div>
	<div class='metaInfoMember' id='countQuestions'>
		aktualizacja poprzez AJAX
	</div>
	<div class='metaInfoMember' id='pictureUrl' style='display:none'>
		<?php 
			if($row['pictureurl']!='')
			{
				echo "<div onclick='showQuizPicture()'>pokaż obrazek quizu</div>";
			}
			else
			{
				echo "brak obrazka dla quizu";
			}
		?>
	</div>
</div>
</div>

<div id='modesTable'>
	<div class='modesTableRow'>
	<?php
	if($row['modes'][0]=='1')
	{
		echo "<div class='mode' onclick=\"goTo('learning.php?qid=".$_SESSION['qid']."')\" id='learning'>
		<h2>Tryb nauki</h2>
		</div>";
	}
	if($row['modes'][1]=='1')
	{
		echo "<div class='mode' onclick=\"goTo('testing.php?m=1&qid=".$_SESSION['qid']."')\" id='testing'>
		<h2>Tryb testu I</h2>
		<h3>fraza → wyjaśnienie</h3>
		</div>";
	}
	if($row['modes'][2]=='1')
	{
		echo "<div class='mode' onclick=\"goTo('testing.php?m=2&qid=".$_SESSION['qid']."')\" id='testing2'>
		<h2>Tryb testu II</h2>
		<h3>wyjaśnienie → fraza</h3>
		</div>";
	}
	?>
	</div>
</div>
<?php
	if(isset($_SESSION['useruid']))
		if($row['owneruid']==$rowuser['useruid'])
			{
				echo "<div id='actionsTable'>
	<div class='actionsTableRow'>
		<div class='action' id='deleteQuiz'><img src='images/icons/Delete-64.png'><br/>Usuń</div>
		<div class='action' id='shareQuiz'><img src='images/icons/Share-64.png'><br/>Udostępnij</div>
		<div class='action' id='editQuiz'><img src='images/icons/Edit-64.png'><br/>Edytuj</div>
		<div class='action' id='generatePaperQuiz' style='display:none'><img src='images/icons/Paper-64.png'><br/>Generuj test papierowy</div>
	</div>
	</div>";
			}
			
	if($row['pictureurl']!='')
		{
			echo "<img src='".$row['pictureurl']."' id='quizPictureGuest'>";
			echo "<p id='quizPictureGuestText'>Źródło obrazka: <a href='".$row['pictureurl']."'>".$row['pictureurl']."</a></p>";
		}
?>
</div>
<div id='actionDiv'>
</div>
<div id='footer'>
</div>
</body>
</html>