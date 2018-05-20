<?php
	session_start();
	$config_array = parse_ini_file("../config-quizlemon.ini");
	$con=mysqli_connect($config_array['address'],$config_array['username'],$config_array['password'],$config_array['db_name']);
	$con->set_charset("utf8");
	$query="SELECT * FROM users WHERE useruid='".$_SESSION['useruid']."'";
	$result=mysqli_query($con,$query);
	$uname='';
	$namensurname='';
	$email='';
	while($row=mysqli_fetch_array($result))
	{
		$uname=$row['username'];
		$namensurname=$row['nameandsurname'];
		$email=$row['email'];
	}
?>	
<div id='somehowTotalContainer'>
	<div id='slideDownTrigger' onclick='slideDownSlideDownDiv()'><div class='inlinowe'>Witaj, <strong><?php echo $uname;?></strong>!<br/><span style='font-size:14px'>kliknij, aby zarządzać kontem i dodać quizy</span></div><div class='inlinowe'><button class='logOutButton smallButton' onclick='logOut()' style='color:#000000;'><img class='twentyPixels inlinowe' src='images/icons/Shutdown-64.png'><span class='inlinowe' style='margin-left:5px'>Wyloguj</span></button></div></div>
	<div id='slideDownDiv'>
	<div id='myAccountContainer'>
		<div id='myAccountContainerRow'>
			<div id='myAccountItself'>
	<div id='personalInfo' class='inlinowe'>
		<img class='profilePicPersInfo' src='images/icons/User-64-white.png' alt='Nie można wyświetlić zdjęcia'>
		<div id='personalInfoItself'>
		<p class='uname personalInfoMember'><strong><?php echo $uname;?></strong></p>
		<p class='personalInfoMember'><?php echo $namensurname;?></p>
		<p class='personalInfoMember' style='margin-bottom:10px'><?php echo $email;?></p>
		</div>
	</div>
		

		<div class='buttonsTable'>
		<div class='buttonsTableRow'>
		<div class='buttonsTableAction' id='changePersonalInfoAction' onclick='showhidechangePersonalInfoDiv()'>
			<img src='images/icons/User-64.png'><br/>Pokaż/ukryj zarządzanie profilem
		</div>
		<div class='buttonsTableAction' id='addQuizAction' onclick='showhideaddQuizDiv()'>
			<img src='images/icons/Add-File-64.png'><br/>Dodaj quiz
		</div>
		</div>
		</div>
		
		
		<div id='changePersonalInfoDiv' class='slidingPanel'>
			<div id='changePersonalInfoDivTable'>
				<div class='changePersonalInfoDivMember'>
				<div class='changePersonalInfoDivMemberCell changePersonalInfoCaption'>Zmień nazwę użytkownika:</div>
				<div class='changePersonalInfoDivMemberCell'><input type='text' class='changePersonalInfoTextBox' id='changeusername'/></div>
				<div class='changePersonalInfoDivMemberCell changePersonalInfoOKButton'><button class='OKButton verySmallButton' onclick="changePersInfo('username')">OK</button></div>
			</div>
				<div class='changePersonalInfoDivMember'>
					<div class='changePersonalInfoDivMemberCell changePersonalInfoCaption'>Zmień imię i nazwisko:</div>
					<div class='changePersonalInfoDivMemberCell'><input type='text' class='changePersonalInfoTextBox' id='changenameandsurname'/></div>
					<div class='changePersonalInfoDivMemberCell changePersonalInfoOKButton'><button class='OKButton verySmallButton' onclick="changePersInfo('nameandsurname')">OK</button></div>
				</div>
				<div class='changePersonalInfoDivMember'>
					<div class='changePersonalInfoDivMemberCell changePersonalInfoCaption'>Zmień hasło:</div>
					<div class='changePersonalInfoDivMemberCell'><input type='password' class='changePersonalInfoTextBox' id='changepassword'/></div>
					<div class='changePersonalInfoDivMemberCell changePersonalInfoOKButton'><button class='OKButton verySmallButton' onclick="changePersInfo('password')">OK</button></div>
				</div>
				<div class='changePersonalInfoDivMember'>
					<div class='changePersonalInfoDivMemberCell changePersonalInfoCaption'>Powtórz nowe hasło:</div>
					<div class='changePersonalInfoDivMemberCell'><input type='password' class='changePersonalInfoTextBox' id='changepassword2'/></div>
					<div class='changePersonalInfoDivMemberCell changePersonalInfoOKButton'></div>
				</div>
				<div class='changePersonalInfoDivMember'>
					<div class='changePersonalInfoDivMemberCell changePersonalInfoCaption'>Zmień e-mail:</div>
					<div class='changePersonalInfoDivMemberCell'><input type='text' class='changePersonalInfoTextBox' id='changeemail'/></div>
					<div class='changePersonalInfoDivMemberCell changePersonalInfoOKButton'><button class='OKButton verySmallButton' onclick="changePersInfo('email')">OK</button></div>
				</div>
				<div class='changePersonalInfoDivMember' style='display:none'>
					<div class='changePersonalInfoDivMemberCell changePersonalInfoCaption'>Zmień zdjęcie profilowe:</div>
					<div class='changePersonalInfoDivMemberCell'><input type='text' class='changePersonalInfoTextBox' id='changeemail'/></div>
					<div class='changePersonalInfoDivMemberCell changePersonalInfoOKButton'><button class='OKButton verySmallButton' onclick="changePersInfo('profilepicture')">OK</button></div>
				</div>
			</div>
		</div>
		<div id='addQuizDiv' class='slidingPanel'>
			<div class='addQuizDivTable'>
				<div class='addQuizDivMember'>
					<div class='addQuizDivMemberCell addQuizDivMemberCaption'>Nazwa quizu:</div>
					<div class='addQuizDivMemberCell'><input type='text' class='addQuizTextBox' id='newQuizName' maxlength=100 onkeyup="countChars('newQuizName','newQuizNameCounter')"/><br/><span style='font-size:14px; color:#AAAAAA'>Pozostało znaków: <span id='newQuizNameCounter'>100</span></span></div>
					<div class='addQuizDivMemberCell addQuizDivMemberOKButton'><button class='OKButton smallButton' onclick="addQuiz()">Dodaj</button></div>
				</div>
			</div>
		</div>
	</div>
	<div id='myQuizes'>
		<?php $query="SELECT COUNT(id) FROM quizes WHERE owneruid='".$_SESSION['useruid']."'";
			$result=mysqli_query($con,$query);
			$row=mysqli_fetch_array($result);
			?>
		<h3>Moje quizy (<?php echo $row['COUNT(id)'];?>)</h3>
		<div id='myQuizesList'>
		<?php
			$query="SELECT * FROM quizes WHERE owneruid='".$_SESSION['useruid']."'";
			$result=mysqli_query($con,$query);
			$months=["sty","lut","mar","kwi","maj","cze","lip","sie","wrz","paź","lis","gru"];
			$number=1;
			while($row=mysqli_fetch_array($result))
			{
				$date=explode('.', $row['addeddate']);
				echo "<div class='myQuizesElement' id='".$row['quizuid']."' onclick=\"goToQuizManagement('".$row['quizuid']."')\"><p class='quizTitle'><strong>".$number.".</strong> ".$row['name']."</p>
				<p class='quizMeta'>dodany: ".$date[0]." ".$months[$date[1]-1]." ".$date[2]." - ilość wykonań: ".$row['timesdone']."</p></div>";
				$number++;
			}
		?>
		</div>
	</div>
	</div>
</div>
</div>