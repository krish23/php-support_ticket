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
		header("location:index.php");
	break;
	
	case "no" :
		header("location:index.php");
	break;
	
	case "yes" :
		if(!isset($_SESSION['username']))
		{
			header("location:index.php");
		}
	else
		{
			header("location:userpanel.php");
		}
	break;
	
	case "check" :
		
		//user name and password
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		//selecting

		$sql = "SELECT * FROM userinfo WHERE username='$username' and password='$password'";

		$rs = mysql_query($sql) or die("Query failed");
		$numofrows = mysql_num_rows($rs);
		
		if($numofrows==1)
		{
			session_register("username");
			header("location:login.php?action=yes");	
		}else
		{
			header("location:login.php?action=no");
		}
	break;
	
	default :
		if(isset($_SESSION['username']))
		{
			header("location:login.php?action=yes");
		}
}
?>
</html>