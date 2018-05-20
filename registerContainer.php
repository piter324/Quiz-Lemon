<div id='registerContainer'>
	<div id='slideDownTrigger' onclick='slideDownSlideDownDiv()'>Zaloguj się / Zarejestruj się</div>
	<div id='slideDownDiv'>
	<div id='slideDownDivTable'>
	<div class='' id='logInDiv'>
		<h2>Zaloguj się</h2>
		<p>Nazwa użytkownika lub e-mail: <input tabindex='1' type='text' id='logInUnameTxtBox'></p>
		<p>Hasło: <input tabindex='2' type='password' id='logInPassTxtBox'></p>
		<button tabindex='3' class='logInButton smallButton' onclick='logIn()'>Zaloguj</button>
	</div>
	<div class='' id='registerDiv'>
		<h2>Zarejestruj się</h2>
		<p class='registerDivMember'>Nazwa użytkownika: <input tabindex='4' type='text' id='registerUname'/></p>
		<p class='registerDivMember'>Imię i nazwisko: <input tabindex='5' type='text' id='registernamensurname'/></p>
		<p class='registerDivMember'>Hasło: <input tabindex='6' type='password' id='registerpass'/></p>
		<p class='registerDivMember'>Powtórz hasło: <input tabindex='7' type='password' id='repeatRegisterPass'/></p>
		<p class='registerDivMember'>Adres e-mail: <input tabindex='8' type='text' id='registeremail'/></p>
		<p class='registerDivMember'><input tabindex='9' type='checkbox' id='registeragreement'/><label for='registeragreement'> Akceptuję <a href='docs/rules.pdf' style='color:#CCCCFF'>Zasady użytkowania platformy Quiz Lemon</a></label></p>
		<button tabindex='9' class='registerButton smallButton' onclick='registerUser()'>Zarejestruj</button>
	</div>
	</div>
	</div>
</div>