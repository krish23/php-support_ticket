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

switch($_GET['action'])
{
	case "logout" :
		session_destroy();
		mysql_close($con);
		header("location:staff.php");
	break;
	
	case "no" :
		header("location:staff.php");
	break;
	
	case "yes" :
		if(!isset($_SESSION['staffsession']))
		{
			header("location:staff.php");
		}
	else
		{
			header("location:staffpanel.php");
		}
	break;
	
	case "check" :
		
		//user name and password
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		//selecting

		$sql = "SELECT * FROM stafflogin WHERE username='$username' and password='$password'";

		$rs = mysql_query($sql) or die("Query failed");
		$numofrows = mysql_num_rows($rs);
		
		if($numofrows==1)
		{
			$staffsession = $username;
			session_register("staffsession");
			header("location:stafflogin.php?action=yes");	
		}else
		{
			header("location:stafflogin.php?action=no");
		}
	break;
	
	default :
		if(isset($_SESSION['staffsession']))
		{
			header("location:stafflogin.php?action=yes");
		}
}
mysql_close($con);

?>

<html>
</html>