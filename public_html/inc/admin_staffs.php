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

<div class="mainmenu_txt">
<h3><a href="http://supportticket.net78.net/adminpanel.php">Main Menu</a></h3>
</div>

<div class="creatstaffs_txt">
<h3><a href="new_staffs.php">Add New Staffs</a></h3>
</div>
<?php

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

$delKey = $_REQUEST['delkey'];

if(isset($_REQUEST['delkey']))
{
	mysql_query("DELETE FROM staffprofile WHERE username = '$delKey' ");
	mysql_query("DELETE FROM stafflogin WHERE  username = '$delKey' ");
	
	header("location:admin_staffs.php");		
}

	//database

	$staff_result = mysql_query("SELECT * FROM staffprofile");

	echo "<div class='staff_table'>";
	echo "<table width='900' border='1'>";
  	echo "<tr>";
    	echo "<td>Staff Name</td>";
    	echo "<td>Department</td>";
    	echo "<td>Position</td>";
    	echo "<td>Email Address</td><br>";
    	echo "<td>Phone</td>";
   echo "</tr>";

while($staffRec = mysql_fetch_array($staff_result))
{
	$staff_name = 	$staffRec['name'];
	$staff_username = $staffRec['username'];
	$staff_dep  =   $staffRec['department'];
	$staff_position = $staffRec['position'];
	$staff_email    = $staffRec['email'];
	$staff_phone    = $staffRec['phone']; 
	
    echo "<tr>";
    echo "<td><a href='admin_staffs_edit.php?staffname=$staff_name'>$staff_name</td>";
    echo "<td>$staff_dep</td>";
    echo "<td>$staff_position</td>";
    echo "<td>$staff_email</td>";
    echo "<td>$staff_phone</td>";
	
   ?>
    
    <td>
		<form name="deletestaffs" action="admin_staffs.php?delkey=<?php echo $staff_username?>" method="post">
    		<input type="submit" value="Delete Staff" class="btn">
    	</form>
    </td>
    
  <?php
  
  echo "</tr>";
  echo "</table>";
  echo "</div>";

} 

mysql_close($con); 

?>



