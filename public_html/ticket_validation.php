<?php 
/*
* Created By : Krishanthan Krishnamoorthy
* Computer Science
* University Of Wyoming
* kkrishna@uwyo.edu
*/ ?>

<?php include("inc/header.php"); ?>
<?php

include("inc/dbconfig.php");

$con = mysql_connect($seegee_host,$seegee_user,$seegee_password);
if(!$con)
{
	die('Could not connect to the database' .mysql_error());
}
else
{
	mysql_select_db($seegee_database,$con);
}

// store and send the ticket to staff

if(isset($_POST['submit']))
{

	$time_stamp = date("j, n, Y");

	$sql = "INSERT INTO ticket (name, email, phone, date, status, dep, problem, ind)
        VALUES('".$_REQUEST['name']."', '".$_REQUEST['email']."', '".$_REQUEST['phone']."', '$time_stamp', 'Open', '".$_REQUEST['depSelect']."', '".$_REQUEST['problem']."', '1')";
		
	$numtick = $_REQUEST['numofticket']+1;
	$ticName = $_REQUEST['name'];
		
	mysql_query("UPDATE profile SET numofticket = '$numtick' WHERE name = '$ticName'");	
		
	$query = mysql_query($sql);

	if(!$query )
	{
		echo "Failed ". mysql_error();
		echo "<br>";
		echo "<a href='new_ticket.php'>Try again</a>";	 	
	}
 	else
	 {
?>       	<html>
			<div class="mainbanner">
			<img src="images/header.jpg"/>
			</div>

			<div class="h1_view">
			<h2> Thank-you for submiting the ticket, you can view your support tickets <a href="userpanel.php">here</a></h2>
			</div>
         <?php
	 }
}	
?>

