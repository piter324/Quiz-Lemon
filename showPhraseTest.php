<?php
	$con=mysqli_connect("localhost","infosalez_auto","infosalez2413","latin");
	$con->set_charset("utf8");
	
	$max=0;
	$query="SELECT COUNT(id) FROM words";
	$result=mysqli_query($con,$query);
	while($row=mysqli_fetch_array($result))
	{
		$max = $row['COUNT(id)'];
	}
	
	$wylosowane=array();
	if($_POST['m']=='ltpl')
	{
	for($i=0;$i<3;$i++)
	{
	if($i==0)
	{
		$query="SELECT * FROM words WHERE id=".$_POST['n'];
		$result=mysqli_query($con,$query);
		while($row=mysqli_fetch_array($result))
		{
			echo $row['phrase']."#".$row['translation'];
		}
	}
	else
	{
		
		$currentrandom=0;
		do
		{
			$currentrandom=rand(1,$max);
		}
		while(in_array($currentrandom,$wylosowane));
		$wylosowane[]=$currentrandom;
		//echo $currentrandom;
		
		$query="SELECT * FROM words WHERE id=".$currentrandom;
		$result=mysqli_query($con,$query);
		while($row=mysqli_fetch_array($result))
		{
			echo "#".$row['translation'];
		}
	}
	}
	}
	else if($_POST['m']=='pllt')
	{
	for($i=0;$i<3;$i++)
	{
	if($i==0)
	{
		$query="SELECT * FROM words WHERE id=".$_POST['n'];
		$result=mysqli_query($con,$query);
		while($row=mysqli_fetch_array($result))
		{
			echo $row['translation']."#".$row['phrase'];
		}
	}
	else
	{
		$currentrandom=0;
		do
		{
			$currentrandom=rand(1,$max);
		}
		while(in_array($currentrandom,$wylosowane));
		$wylosowane[]=$currentrandom;
	
		$query="SELECT * FROM words WHERE id=".$currentrandom;
		$result=mysqli_query($con,$query);
		while($row=mysqli_fetch_array($result))
		{
			echo "#".$row['phrase'];
		}
	}
	}
	}
?>