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

if(!isset($_SESSION['staffsession']))
{
	header("location:stafflogin.php?action=no");
}
if(isset($_SESSION['username']))
{
	header("location:login.php?action=yes");
}
if(isset($_SESSION['adminsession']))
{
	header("location:adminlogin.php?action=yes");
}

include("inc/dbconfig.php");

echo "<div class='h1_view'>";
echo "<h1>Staff Panel</h1>";
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

$staffsession=$_SESSION['staffsession'];

$result =mysql_query("SELECT staffprofile.name FROM staffprofile WHERE username='$staffsession'");
$showName = mysql_fetch_array($result);

echo "<div class='h2_view'>";
$name=$showName['name'];
echo "<h2>Welcome, $name</h2>";
echo "</div>";

echo "<div class='h2_view_open'>";
echo "<h3>Open Tickets</h3>";
echo "</div>";

echo "<div class='h2_view_closed'>";
echo "<h3>Close Tickets</h3>";
echo "</div>";

// databases

$ticket = mysql_query("SELECT * FROM ticket");
while($rows = mysql_fetch_array($ticket))
{
	$id = $rows['id'];
	$numoftic = $rows['numoftick'];
	$tic_id = $rows['id'];
	$tic_date = $rows['date'];
	$tic_status = $rows['status'];
	$tic_problem = $rows['problem'];
	$tic_solution = $rows['solution'];
	$tic_conv = $rows['numofconv'];
	$customerName = $rows['name'];
	$indication = $rows['ind'];
	
	if( $tic_status == "Open" )
	{
		// view the ticket
		echo "<div class='ticket_table'>";
  		echo "<table width='850' border='1'>";
  		echo "<tr>";
    	echo "<td width='61'>Ticket ID </td>";
		echo "<td width='112'> Customer </td> ";
    	echo "<td width='90'>Date Created</td>";
    	echo "<td width='255' align='center'>Problem</td>";
    	echo "<td width='91'>Ticket Status</td>";
    	echo "<td width='108'>Conversations</td>";
  		echo "</tr>";
		echo '<tr>';
		
		if($indication=='1') 
		{
    		echo "<td width='61' align='center'><a href='staffticket.php?ticid=$tic_id'> <b> $tic_id  </b></td>";
			echo "<td width='112' align='center'><b> $customerName </b> </td>";
			echo "<td width='112' align='center'><b> $tic_date </b> </td>";
			echo "<td width='255' align='center'><b> $tic_problem </b> </td>";
    		echo "<td width='91' align='center'> <b> $tic_status </b> </td>";
    		echo "<td width='108' align='center'> <b> $tic_conv </b> </td>";
			
			if($tic_solution == "")
			{
				echo "<form name='soluForm' action='solution.php?action=$tic_id' method='post' >";
				echo "<td width='108' align='center'> <input type='submit' name='submit_sol' value='Solution' />";
				echo "</form>";
			}
    		echo '</tr>';
		}
		else
		{
			echo "<td width='61' align='center'><a href='staffticket.php?ticid=$tic_id'> $tic_id </td>";
			echo "<td width='112' align='center'>$customerName</td>";
			echo "<td width='112' align='center'>$tic_date</td>";
			echo "<td width='255' align='center'>$tic_problem</td>";
    		echo "<td width='91' align='center'>$tic_status</td>";
    		echo "<td width='108' align='center'>$tic_conv</td>";
			
			if($tic_solution == "")
			{
				echo "<form name='soluForm' action='solution.php?action=$tic_id' method='post' >";
				echo "<td width='108' align='center'> <input type='submit' name='submit_sol' value='Post Solution' />";
				echo "</form>";
			}
    		echo '</tr>';	
		}
		
			echo '</table>';
    		echo '</div>'; 
		
	}	
		if( $tic_status == "Close" )
		{
			// view the ticket
			
			echo "<div class='ticket_table_close'>";
  			echo "<table width='950' border='1'>";
  			echo "<tr>";
    		echo "<td width='61'>Ticket ID </td>";
			echo "<td width='112'> Customer </td> ";
    		echo "<td width='112'>Date Created</td>";
    		echo "<td width='255' align='center'>Problem</td>";
    		echo "<td width='91'>Ticket Status</td>";
    		echo "<td width='108'>Conversations</td>";
  			echo "</tr>";
			echo '<tr>';
			
				if($indication=='1') 
				{
    				echo "<td width='61' align='center'><a href='staffticket.php?ticid=$tic_id'> <b> $tic_id  </b></td>";
					echo "<td width='112' align='center'><b> $customerName </b> </td>";
					echo "<td width='112' align='center'><b> $tic_date </b> </td>";
					echo "<td width='255' align='center'><b> $tic_problem </b> </td>";
    				echo "<td width='91' align='center'> <b> $tic_status </b> </td>";
    				echo "<td width='108' align='center'> <b> $tic_conv </b> </td>";	
					if($tic_solution == "")
					{
						echo "<form name='soluForm' action='solution.php?action=$tic_id' method='post' >";
						echo "<td width='108' align='center'> <input type='submit' name='submit_sol' value='Post Solution' />";
						echo "</form>";
					}
    				echo '</tr>';
				}
				else
				{
					echo "<td width='61' align='center'><a href='staffticket.php?ticid=$tic_id'> $tic_id </td>";
					echo "<td width='112' align='center'>$customerName</td>";
					echo "<td width='112' align='center'>$tic_date</td>";
					echo "<td width='255' align='center'>$tic_problem</td>";
    				echo "<td width='91' align='center'>$tic_status</td>";
    				echo "<td width='108' align='center'>$tic_conv</td>";
    		
					if($tic_solution == "")
					{
						echo "<form name='soluForm' action='solution.php?action=$tic_id' method='post' >";
						echo "<td width='108' align='center'> <input type='submit' name='submit_sol' value='Post Solution' />";
						echo "</form>";
					}
    				echo '</tr>';
				}
				echo "</table>";
    			echo "</div>";
		} 
}

mysql_close($con);

?>

<div class="signout_staff_panel">
<a href="stafflogin.php?action=logout"><h3>Logout</h3>
</div>

<html>
