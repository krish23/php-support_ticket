<?php 
/*
* Created By : Krishanthan Krishnamoorthy
* Computer Science
* University Of Wyoming
* kkrishna@uwyo.edu
*/ 
?>

<?php include("session.php"); ?>

<html>
<link href="http://supportticket.net78.net/style.css" rel="stylesheet" type="text/css" />

<body>

<div id="content"> 

<div class="mainbanner">
<img src="http://supportticket.net78.net/images/header.jpg"/>
</div>

<div class="newticket_txt">
<h3><a href="http://supportticket.net78.net/adminpanel.php">Admin Panel</a></h3>
</div>

<?php

$staffName = $_REQUEST['staffname'];

if(!isset($_SESSION['adminsession']))
{
	header("location:adminlogin.php?action=no");
}

include("dbconfig.php");

echo "<div class='h2_v'>";
echo "<h2>Staff Information</h2>";
echo "</div>";

$con = mysql_connect($seegee_host,$seegee_user,$seegee_password);
if(!$con)
{
	die('Could not connect to the database' .mysql_error());
}
else
{
	mysql_select_db($seegee_database,$con);
}

//database

$staff_result = mysql_query("SELECT * FROM staffprofile WHERE name='$staffName'");


while($staffRec = mysql_fetch_array($staff_result))
{
	$staff_username = $staffRec['username'];
	$staff_name = 	$staffRec['name'];
	$staff_dep  =   $staffRec['department'];
	$staff_position = $staffRec['position'];
	$staff_email    = $staffRec['email'];
	$staff_phone    = $staffRec['phone']; 
	
	$staff_result_login = mysql_query("SELECT stafflogin.password FROM stafflogin WHERE username='$staff_username'");
	$staff_view_pass = mysql_fetch_array($staff_result_login);
	$staff_password = $staff_view_pass['password'];
	
	
	echo "<div class='staff_list'>";
	echo "<form method='post' action='admin_staffs_edit.php?update=$staff_username'>";
	
		echo "User Name  :  </br>";
		echo "<input type='text' name='s_uname' value='$staff_username' size='30'>";	
		echo "<br>";
		echo "<br>";
		echo "Password   : </br>";
		echo "<input type='text' name='s_pass' value='$staff_password' size='30'>";	
		echo "<br>";
		echo "<br>";
		echo "Name       :</br> ";
		echo "<input type='text' name='s_name' value='$staff_name' size='30'>";	
		echo "<br>";
		echo "<br>";
		echo "Department : </br>";
		echo "<input type='text' name='s_dep' value='$staff_dep' size='30'>";	
		echo "<br>";
		echo "<br>";
		echo "Position   : </br>";
		echo "<input type='text' name='s_pos' value='$staff_position' size='30'>";	
		echo "<br>";
		echo "<br>";
		echo "E-mail     : </br>";
		echo "<input type='text' name='s_email' value='$staff_email' size='30'>";	
		echo "<br>";
		echo "<br>";
		echo "Phone      : </br>";
		echo "<input type='text' name='s_phone' value='$staff_phone' size='30'>";	
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<input type='submit' name='submit' class='btn' value='Update Profile'>";
	echo "</form>";
    
	echo "</div>";
}

	$updateuser = $_REQUEST['update'];
	
	if(isset($_REQUEST['update']))
	{
		$update_name = $_POST['s_name'];
		$update_uname = $_POST['s_uname'];
		$update_pass = $_POST['s_pass'];
		$update_dep = $_POST['s_dep'];
		$update_pos = $_POST['s_pos'];
		$update_phone = $_POST['s_phone'];
		$update_email = $_POST['s_email']; 
		
		$sqlUpdate = "UPDATE staffprofile SET name = '$update_name', position='$update_pos', department='$update_dep', phone='$update_phone', email='$update_email', username = '$update_uname' WHERE username = '$updateuser' ";
		
		if(!mysql_query($sqlUpdate,$con))
		{
			die('Error: ' . mysql_error());
		}
		
		mysql_query("UPDATE stafflogin SET username = '$update_uname' , password = '$update_pass' WHERE username = '$updateuser' ");

	//after update
	$check_name = $_POST['s_name'];
	mysql_close($con);
	
	header("location:admin_staffs_edit.php?staffname=$check_name");
	
	}
?>