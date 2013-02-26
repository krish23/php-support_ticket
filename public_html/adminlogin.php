<?php /*
* Created By : Krishanthan Krishnamoorthy
* Computer Science
* University Of Wyoming
* kkrishna@uwyo.edu
*/ ?>

<?php include("inc/session.php"); ?>
<html>

<?php
include("inc/dbconfig.php");
$con = mysql_connect($seegee_host,$seegee_user,$seegee_password);
if(!$con){print "Database connection error!";}
else{mysql_select_db($seegee_database,$con) or die(mysql_error());}

// switch statement that check all the request
switch($_GET['action'])
{
	case "logout" :
		session_destroy();
		header("location:admin.php");
	break;
	
	case "no" :
		header("location:admin.php");
	break;
	
	case "yes" :
		if(!isset($_SESSION['adminsession']))
		{
			// username or password is incorrect
			header("location:admin.php");
		}
	else
		{
			header("location:adminpanel.php");
		}
	break;
	
	case "check" :
		
		//user name and password
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		//selecting
		$sql = "SELECT * FROM adminlogin WHERE username='$username' and password='$password'";

		$rs = mysql_query($sql) or die("Query failed");
		$numofrows = mysql_num_rows($rs);
		
		// if username and password set
		if($numofrows==1)
		{
			$adminsession = $username;
			session_register("adminsession");
			header("location:adminlogin.php?action=yes");	
		}else
		{
			header("location:adminlogin.php?action=no");
		}
	break;
	
	default :
		if(isset($_SESSION['adminsession']))
		{
			header("location:adminlogin.php?action=yes");
		}
}

?>