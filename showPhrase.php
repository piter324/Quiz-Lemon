<?php
	$con=mysqli_connect("localhost","infosalez_auto","infosalez2413","latin");
	$con->set_charset("utf8");
	
	$query="SELECT * FROM words WHERE id=".$_POST['n'];
	$result=mysqli_query($con,$query);
	while($row=mysqli_fetch_array($result))
	{
		echo $row['phrase']."#".$row['translation'];
	}
	
?>