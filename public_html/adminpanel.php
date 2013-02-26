<?php /*
* Created By : Krishanthan Krishnamoorthy
* Computer Science
* University Of Wyoming
* kkrishna@uwyo.edu
*/ ?>

<?php include("inc/session.php"); ?>
<?php include("inc/header.php"); ?>

<html>
<div class="mainbanner">
<img src="images/header.jpg"/>
</div>

<?php

if(!isset($_SESSION['adminsession']))
{
	header("location:adminlogin.php?action=no");
}
if(isset($_SESSION['username']))
{
	header("location:login.php?action=yes");
}
if(isset($_SESSION['staffsession']))
{
	header("location:stafflogin.php?action=yes");
}

include("inc/dbconfig.php");


echo "<div class='h1_view'>";
echo "<h1>Admin Panel</h1>";
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
?>

<?php

// summary table

$result_users = mysql_query("SELECT * FROM userinfo");
$num_of_users = mysql_num_rows($result_users);

$result_staffs = mysql_query("SELECT * FROM stafflogin");
$num_of_staffs = mysql_num_rows($result_staffs);

$tickets = mysql_query("SELECT ticket.status FROM ticket");

$num_of_opentickets = 0;
$num_of_closedtickets = 0;

while( $status = mysql_fetch_array($tickets) )
{
	$ticket_status = $status['status'];
	
	if($ticket_status == "Open")
	{
		$num_of_opentickets++;	
	}else
	{
		$num_of_closedtickets++;	
	}	
}
?>
<div class="summary" >
<h3>Admin Dash Board</h3></br>

<table width="363" height="122" border="1">
  <tr>
    <td width="245">Open Tickets</td>
    <td><?php echo $num_of_opentickets?></td>
  </tr>
  <tr>
    <td>Close Tickets</td>
    <td><?php echo $num_of_closedtickets?></td>
  </tr>
  <tr>
    <td>Users</td>
    <td><?php echo $num_of_users?></td>
  </tr>
  <tr>
    <td>Staffs</td>
    <td><?php echo $num_of_staffs?></td>
  </tr>
</table>
</div>





<div class="adminpanel" >
<table width="256" border="1">
  <tr>
    <td height="128"><a href="admin_viewtickets.php"><img src="images/edit.png"/></a> </td>
    <td><a href="inc/admin_staffs.php"> <img src="images/staffs.png"/></a> </td>
  </tr>
  <tr>
    <td height="128">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</div>

<div class="signout_admin">
<a href="adminlogin.php?action=logout"><h2>Logout</h2>
</a></div>
</html>
