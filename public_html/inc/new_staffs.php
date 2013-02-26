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

if(!isset($_SESSION['adminsession']))
{
	header("location:adminlogin.php?action=no");
}

include("dbconfig.php");

echo "<div class='h2_v'>";
echo "<h2>Add New staff</h2>";
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
//form
?>
<div class="addnewstaff">

<form name="addstaff" action="new_staffs.php" method="post">
	<h4>Username   :</h4><input type="text" size="30" name="username" /></br>
	<h4>Password   :</h4><input type="password" size="30" name="password" /></br>
	<h4>Staff Name :</h4><input type="text" size="30" name="name" /></br>
	<h4>Position   :</h4><input type="text" size="30" name="position" /></br>
	<h4>Department :</h4><input type="text" size="30" name="department" /></br>
	<h4>Phone      :</h4><input type="text" size="30" name="phone" /></br>
	<h4>E-mail     :</h4><input type="text" size="30" name="email" /></br></br>
	<input type="submit" value="Add New" name="submit" />
</form>

</div>

<html>

<?php

// Add new staffs
$username = $_POST['username'];
$password = $_POST['password'];
$staffName = $_POST['name'];
$position = $_POST['position'];
$department = $_POST['department'];
$phone = $_POST['phone'];
$email = $_POST['email'];

if(isset($_POST['submit']))
{
	//insert data into database
	
	$sql = "INSERT INTO stafflogin (username,password)
			VALUES('$username','$password')";
			
	 $query = mysql_query($sql);
	 
	 $sql2 = "INSERT INTO staffprofile (username, name, position, department, phone ,email)
	 		  VALUES('$username','$staffName','$position','$department','$phone','$email')";
			  
	 $query2 =  mysql_query($sql2);
	 
	 if(!($query && $query2))
	 {
		echo "Failed ". mysql_error();
		echo "<a href='new_staffs.php'>Try again</a>";	 
	 }	
	 else
	 {
		header("location :admin_staffs.php");	 
	 }
}

?>

