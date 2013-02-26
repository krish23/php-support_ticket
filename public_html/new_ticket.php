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

<div class="newticket_txt">
<h3><a href="userpanel.php">User Panel</a></h3>
</div>

<?php

if(!isset($_SESSION['username']))
{
	header("location:login.php?action=no");
}

include("inc/dbconfig.php");

$user = $_SESSION['username'];

echo "<div class='h1_view'>";
echo "<h2>Create New Ticket</h2>";
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

// show other information
$userinfo = mysql_query("SELECT * FROM profile WHERE username = '$user' ");

while($result_user = mysql_fetch_array($userinfo))
{
	$cusName = $result_user['name'];
	$cusEmail = $result_user['email'];
	$cusPhone = $result_user['phone'];
	$cusNumofticket = $result_user['numofticket'];
}
?>

<div class="new_ticket">

<form name="newticket" action="ticket_validation.php" method="post">
	<h4>Name       :</h4><input type="text" name="name" value="<?php echo $cusName?>" size="30" />
	<h4>Email      :</h4><input type="text" name="email" value="<?php echo $cusEmail?>" size="30" />
	<h4>Phone      :</h4><input type="text" name="phone" value="<?php echo $cusPhone?>" size="30" />
	<h4>Problem    :</h4><textarea rows="7" cols="60" name="problem" /></textarea>
	<h4>Department :</h4><select name="depSelect">
	<option value="Accounting">Accounting</option>
	<option value="Customer Service">Customer Service</option>
	<option value="Marketing">Marketing</option>
	<option value="Sales">Sales</option>
	</select><br><br>
	<input type="hidden" name="numofticket" value="<?php echo $cusNumofticket ?>" />
	<input type="submit" name="submit" value="Submit" />
</form>

</div>
</html>