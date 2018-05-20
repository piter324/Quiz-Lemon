function showDialog(title,content,showClosingX,buttons)
{
	//buttons write like so: name1&function1#name2&function2...
	$.post('dialogboxShow.php',{title:title,content:content,showx:showClosingX,buttons:buttons},function(data){
		$('#dialogSpace').html(data);
		$('#dialogBox').css('top',$(window).height()*0.5-$('#dialogBox').height());
		$('#dialogBox').css('left',($(window).width()*0.5)-$('#dialogBox').width()*0.5);
		$('#dialogBox').slideDown();
	});
}