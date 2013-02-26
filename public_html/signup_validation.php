<?php /*
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

// Register
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$name = $_POST['name'];
$position = $_POST['position'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];

if(isset($_POST['submit']))
{
	//insert data into database
	
	$sql = "INSERT INTO userinfo (username,password)
	        VALUES('$username','$password')";
			
	$query = mysql_query($sql);
	
	$sql2 = "INSERT INTO profile (username, name, email, address, phone)
	         VALUES('$username', '$name' ,'$email', '$address' ,'$phone')";
			 
	$query2 = mysql_query($sql2);
	
	if(!($query && $query2))
	 {
		echo "Failed ". mysql_error();
		echo "<a href='new_staffs.php'>Try again</a>";	 
	 }	
	 else
	 {
?>
        <html>
		<div class="mainbanner">
		<img src="images/header.jpg"/>
		</div>

		<div class="h1_view">
		<h2> Thank-you for register, now you can <a href="index.php">Login</a></h2>
		</div>
<?php
	}
}
?>