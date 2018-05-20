function setFooter()
{
	$('div#footer').html("Wersja 0.95 (22.03.2015) - © Piotr Muzyczuk. 2015<br/>Ikony pobrane z serwisu: <a target='_blank' href=\"http://icons8.com\">Icons8</a><br/><a href='docs/rules.pdf'>Zasady użytkowania platformy</a>");
}
function showPleaseWait()
{
	$('div#pleaseWaitText').css('top',($(window).height()/2)-100);
	$('div#pleaseWaitContainer').fadeIn(100);
}
function hidePleaseWait()
{
	$('div#pleaseWaitContainer').fadeOut(100);
}