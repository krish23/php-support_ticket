<?php 
/*
* Created By : Krishanthan Krishnamoorthy
* Computer Science
* University Of Wyoming
* kkrishna@uwyo.edu
*/ 
?>

<?php include("inc/session.php"); ?>
<?php include("inc/header.php"); ?>

<html>
<div class="mainbanner">
<img src="images/header.jpg"/>
</div>

<div class="newticket_txt">
<h3><a href="new_ticket.php">Create New Ticket</a></h3>
</div>

<?php

if(!isset($_SESSION['username']))
{
	header("location:login.php?action=no");
}
if(isset($_SESSION['staffsession']))
{
	header("location:stafflogin.php?action=yes");
}
if(isset($_SESSION['adminsession']))
{
	header("location:adminlogin.php?action=yes");
}

include("inc/dbconfig.php");

echo "<div class='h1_view_user'>";
echo "<h1>User Panel</h1>";
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


$usersession=$_SESSION['username'];

$result =mysql_query("SELECT profile.name FROM profile WHERE username='$usersession'");
$showName = mysql_fetch_array($result);

echo "<div class='h2_view_user'>";
$name=$showName['name'];
echo "<h2>Welcome, $name</h2>";
echo "</div>";

// Receive the delete key (id)
$delKey = $_REQUEST['delkey'];

if(isset($_REQUEST['delkey']))
{
	//obtain the name
	
	$getName = mysql_query("SELECT ticket.name FROM ticket WHERE id='$delKey' ");
	$output_name = mysql_fetch_array($getName);
	
	$out_name = $output_name['name'];

	// decrease the number of ticket
	$numOfTick = mysql_query("SELECT profile.numofticket FROM profile WHERE name = '$out_name'");
	$output_ticket = mysql_fetch_array($numOfTick);
	
	$num_of_Tick = $output_ticket['numofticket'];
	
		//update the value;
	mysql_query("DELETE FROM ticket WHERE  id = '$delKey' ");
		
	$num_of_Tick--;
	mysql_query("UPDATE profile SET numofticket = '$num_of_Tick' WHERE name = '$out_name' ");
	
	header("location:userpanel.php");		
}


// ticket table

echo '<div class="ticket_table_user">
  <table width="950" border="1">
  <tr>
    <td width="61">Ticket ID </td>
    <td width="112">Date Created</td>
    <td width="490" align="center">Problem</td>
    <td width="91">Ticket Status</td>
    <td width="108">Conversations</td>
  </tr>';


$tic = mysql_query("SELECT * FROM ticket WHERE name='$name'");

while($rows = mysql_fetch_array($tic))
{
	$tic_id = $rows['id'];
	$tic_date = $rows['date'];
	$tic_status = $rows['status'];
	$tic_problem = $rows['problem'];
	$tic_conv = $rows['numofconv'];
	$indication = $rows['cus_ind'];
	
	$countTick = mysql_query("SELECT profile.numofticket FROM profile WHERE name = '$name'");
	$outtic = mysql_fetch_array($countTick);
	
	$numoftic = $outtic['numofticket'];
	

	if($indication=='1') 
	{
	
		echo '<tr>';
    	echo "<td width='61' align='center'><b><a href='view_ticket.php?ticid=$tic_id'>$tic_id</b></td>";
    	echo "<td width='112' align='center'><b>$tic_date</b></td>";
    	echo "<td width='255' align='center'><b>$tic_problem</b></td>";
    	echo "<td width='91' align='center'><b>$tic_status</b></td>";
    	echo "<td width='108' align='center'><b>$tic_conv</b></td>";	
	?>
    <td>
		<form name="deletetickets" action="userpanel.php?delkey=<?php echo $tic_id?>" method="post">
    		<input type="submit" value="Delete Ticket" class="btn">
    	</form>
    </td>
       
    </tr> 
    
    <?php
		
	}
	else
	{
		echo '<tr>';
    	echo "<td width='61' align='center'><a href='view_ticket.php?ticid=$tic_id'>$tic_id</td>";
    	echo "<td width='112' align='center'>$tic_date</td>";
    	echo "<td width='255' align='center'>$tic_problem</td>";
    	echo "<td width='91' align='center'>$tic_status</td>";
    	echo "<td width='108' align='center'>$tic_conv</td>";	
	
		?>
    	<td>
			<form name="deletetickets" action="userpanel.php?delkey=<?php echo $tic_id?>" method="post">
    			<input type="submit" value="Delete Ticket" class="btn">
    		</form>
    	</td>
           
    	</tr> 
    	
		<?php
	}
}
echo '</table>';

echo "<div class='txt3_view'>";

if( $numoftic < 1)
{
	echo "You don't have any tickets";	
}
else
{
	echo "You have created : ";
	echo $numoftic;
	echo " ticket(s).";
}

echo "</div>";

mysql_close($con);

?>

</div>
</div>
<div class="signout_user">
<a href="login.php?action=logout"><h3>Logout</h3></a>
</div>

</html>

