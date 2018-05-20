<!DOCTYPE html>
<html>
<?php session_start();?>
<head>
<meta charset='UTF-8'>
<meta name="author" content="Piotr Muzyczuk" />
<meta name="description" content="Platforma, która tworzenie quizów wreszcie czyni łatwym. Po prostu stwórz lub skopiuj listę pytań, a resztę zrobimy za Ciebie!" />
<meta name="keywords" content="Quiz, Lemon, platforma, quizy, pytania, odpowiedzi, testy" />
<meta name="robots" content="all,follow" />
<meta name="Googlebot" content="all,follow" />
<link rel='image_src' href='images/thumbnail.png'>
<link rel='icon' href='images/favicon.png'>
<link rel='stylesheet' href='styles/general.css'>
<link rel='stylesheet' href='styles/index.css'>
<link rel='stylesheet' href='styles/buttons.css'>
<link rel='stylesheet' href='dialogAPI/dialogBox.css'>
<link href='http://fonts.googleapis.com/css?family=Roboto:500,900,300,700,400&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<title>Quiz Lemon</title>
<script src='js/jquery.js'></script>
<script src='dialogAPI/showDialog.js'></script>
<script src='js/general.js'></script>
<script>
var useruid;
var d=new Date();
$(document).ready(function(){
	setFooter();
	listNewestQuizes();
	listMostdoneQuizes();
	searchQuizes();
	setInterval(function(){
		//listNewestQuizes();
	},10000);
	<?php
		if(isset($_SESSION['useruid'])&&$_SESSION['useruid']!='')
			{
				echo "$('#registerOrMyAccountDiv').load('myAccountContainer.php?'+d.getTime());
				useruid='".$_SESSION['useruid']."';";
			}
		else
			{
				echo "$('#registerOrMyAccountDiv').load('registerContainer.php?'+d.getTime());";
			}?>

	$('div.buttonsTableAction').css('height',$('div.buttonsTableAction').width()/2);

	var bufor='';
	$('div.buttonsTableAction').mouseenter(function(){
		alert(bufor);
		var colorek = $(this).css('background-color');
		bufor=colorek;
		colorek = colorek.replace('rgb(','');
		colorek = colorek.replace(')','');
		var colors = colorek.split(',');
		$(this).css('background-color','rgb('+(parseInt(colors[0])+20)+','+(parseInt(colors[1])+20)+','+(parseInt(colors[2])+20)+')');
	}).mouseleave(function(){
		$(this).css('background-color',bufor);
	});

	/*$('input#logInPassTxtBox').bind('enterKey',function(e){
		logIn();
	});

	$('input#logInPassTxtBox').keyup(function(e){
		if(e.keyCode==13)
		{
			$(this).trigger('enterKey');
		}
	});*/
});
function listNewestQuizes()
{
	$.post('listNewestQuizes.php',{},function(data){
		$('div#newestQuizesList').html(data);
	});
}
function listMostdoneQuizes()
{
	$.post('listMostdoneQuizes.php',{},function(data){
		$('div#mostdoneQuizesList').html(data);
	});
}
function searchQuizes()
{
	var searchQuery=$('input#searchField').val();
	$.post('showSearchResults.php',{searchQuery:searchQuery},function(data){
		$('div#quizesList').html(data);
	});
}
function registerUser()
{
	var username=$('#registerUname').val();
	var namensurname=$('#registernamensurname').val();
	var password=$('#registerpass').val();
	var email=$('#registeremail').val();
	if(username=='')
	{
		showDialog("Błąd!","Wpisz nazwę użytkownika",true);
	}
	else if(namensurname=='')
	{
		showDialog("Błąd!","Wpisz imię i nazwisko",true);
	}
	else if($('#repeatRegisterPass').val()!=password)
	{
		showDialog("Błąd!","Podane hasła różnią się!",true);
	}
	else if(email.indexOf('@') === -1)
	{
		showDialog("Błąd!","Adres e-mail wygląda na błędny",true);
	}
	else if(!$('input#registeragreement').is(':checked'))
	{
		showDialog("Błąd!","Musisz zaakceptować zasady platformy",true);
	}
	else
	{
		$.post('register.php',{uname:username,nameandsurname:namensurname,pass:password,email:email},function(data)
			{
				if(data=='done')
				{
					showDialog("Sukces!","Rejestracja przebiegła pomyślnie",false,"OK&refresh()");
				}
				else
				{
					showDialog("Informacja",data,true);
				}
			});
	}
}
function logIn()
{
	var username=$('#logInUnameTxtBox').val();
	var password=$('#logInPassTxtBox').val();
	if($('#logInUnameTxtBox').val()=='')
	{
		showDialog("Błąd!","Wpisz swoją nazwę użytkownika",true);
	}
	else if($('#logInPassTxtBox').val()=='')
	{
		showDialog("Błąd!","Wpisz swoje hasło",true);
	}
	else
	{
		$.post('login.php',{uname:username,pass:password,email:username},function(data)
			{
				if(data=='done')
				{
					//showDialog("Sukces!","Jesteś zalogowany",false,"OK&refresh()");
					refresh();
				}
				else
				{
					showDialog("Informacja",data,true);
				}
			});
	}
}
function logOut()
{
	$.post('logout.php',{},function(data){
		if(data=='done')
		{
			//showDialog("Informacja","Wylogowano pomyślnie",false,"OK&refresh()");
			refresh();
		}
		else
		{
			showDialog("Błąd!",data,true);
		}
	});
}
function countChars(textfield,counterspan)
{
	var charsentered = $('input#'+textfield).val().length;
	$('span#'+counterspan).html(100-charsentered);
}
function refresh()
{
	location.reload();
}
function showhideaddQuizDiv()
{
	$('#addQuizDiv').slideToggle();
}
function showhidechangePersonalInfoDiv()
{
	$('#changePersonalInfoDiv').slideToggle();
}
function slideDownSlideDownDiv()
{
	$('div#slideDownDiv').slideToggle();
}
function changePersInfo(whichinfo)
{
	var passed=true;
	if($('input#change'+whichinfo).val()!='')
	{
		if(whichinfo=='password')
		{
			passed=($('input#changepassword').val()==$('input#changepassword2').val());
		}
		if(passed==true)
		{
		var changedinfo=$('input#change'+whichinfo).val();
		$.post('changePersonalInfo.php',{uid:useruid,winfo:whichinfo,cinfo:changedinfo},function(data){
			if(data=='done')
			{
				refresh();
			}
			else
			{
				showDialog("Błąd!",data,true);
			}
		});
		}
		else
			showDialog("Błąd!","Podane hasła różnią się",true);
	}
	else
	{
		showDialog("Błąd!","Wpisz nowe dane",true);
	}
	
}
function addQuiz()
{
	var quizname=$('input#newQuizName').val();
	$.post('addQuiz.php',{quizname:quizname},function(data){
		var dane = data.split('#');
		if(dane[0]=='done')
		{
			showDialog("Sukces","Pomyślnie dodano quiz.<br/>Za chwilę zostaniesz przekierowany na stronę jego edycji.",false,"OK&goToQuizManagement('"+dane[1]+"')");
		}
		else
		{
			showDialog("Błąd!",data,true);
		}
	});
}
function goToQuizManagement(quizuid)
{
	closeDialog();
	location.href='manageQuiz.php?qid='+quizuid;
}
function printDiv()
{
	w=window.open();
	w.document.write($('#printOut').html());
	w.print();
	w.close();
}
</script>
</head>
<body>
<div id='pleaseWaitContainer'>
	<div id='pleaseWaitText'>
		PROSZĘ CZEKAĆ...
		<br/>
		<img style='width:50%; height:50%' src='http://static.tumblr.com/ff3ab9b8de2784b7db96eccdc5226526/8ua5ih5/DXzmisgce/tumblr_static_please_wait_for_a_whale_logo_gross.jpg'>
		<br/><span style='font-size:12px; color:#888888'>źródło obrazka: http://static.tumblr.com/ff3ab9b8de2784b7db96eccdc5226526/8ua5ih5/DXzmisgce/tumblr_static_please_wait_for_a_whale_logo_gross.jpg</span>
	</div>
</div>
<div id='dialogSpace'><div id='dialogBox'>
<div id='dialogBoxTitleBar'><div id='dialogBoxTitle' class='inlinowe'>".$_POST['title']."</div><div id='closingx' class='inlinowe'><img class='closingxwhite' src='images/closingxwhite.png'></div></div>
<div id='dialogBoxContent'>".$_POST['content']."</div>
</div></div>
<div id='totalContainer'>
<div id='upContainer'>
	<div id='textQuizEngine'>
		<img src='images/logo.png'>
	</div>
</div>
<div id='feedContentContainer'>
		<div id='newestQuizzesContentTable'>
		<div id='newQuizesFeed' class=''>
			<h3 class='spaced'>NAJNOWSZE</h3>
			<div id='newestQuizesList'>
			</div>
		</div>
		<div id='mostdoneQuizesFeed' class=''>
			<h3 class='spaced'>NAJCZĘŚCIEJ WYKONYWANE</h3>
			<div id='mostdoneQuizesList'>
			</div>
		</div>
		</div>
</div>
<div id='allQuizesListContainer' class=''>
			<h3 class='spaced'>WSZYSTKIE QUIZY PUBLICZNE</h3>
			<p id='searchFieldPara'><span class='inlinowe' style='margin-right:5px'>Wyszukaj:</span><input type='text' onkeyup='searchQuizes()' id='searchField' class='inlinowe'><button class='smallButton OKButton inlinowe' onclick='searchQuizes()'><img src='images/icons/Search-64.png' class='thirtyPixels'></button></p>
			<div id='quizesList'>
				<div class='quizesListMember'>
				<div class='quizesListMemberRow quizesListMemberTitle'>
					Nazwa quizu
				</div>
				<div class='quizesListMemberRow'>
					<div class='quizesListMemberCell quizCategory'>Kategoria</div>
					<div class='quizesListMemberCell quizCreator'>Twórca</div>
					<div class='quizesListMemberCell quizTimesDone'>Wykonania</div>
				</div>
				</div>
			</div>
		</div>
<div id='registerOrMyAccountDiv'>

</div>
<div id='footer'>
</div>
</div>
</div>

</div>
<div style='color:#000000; display:none'>
<?php
$lol = uniqid('category');
echo $lol." | ".strlen($lol);

echo "<br/>";

$hashed = hash("sha256","abcd");
echo $hashed." | ".strlen($hashed);
?>
<br/>
<div id='printOut' style='display:none'>abcd</div>
</div>
</body>
</html>