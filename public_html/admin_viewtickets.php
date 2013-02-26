<?php /*
* Created By : Krishanthan Krishnamoorthy
* Computer Science
* University Of Wyoming
* kkrishna@uwyo.edu
*/ ?>

<?php include("inc/session.php"); ?>

<html>

<link href="inc/style_tab.css" rel="stylesheet" type="text/css" />
<body>
<div id="content"> 

<div class="mainbanner">
<img src="images/header.jpg"/>
</div>

<div class="mainmenu_txt">
<h3><a href="adminpanel.php">Main Menu</a></h3>
</div>

<?php

if(!isset($_SESSION['adminsession']))
{
	header("location:adminlogin.php?action=no");
}

include("inc/dbconfig.php");

//display text
echo "<div class='h2_v'>";
echo "<h2>Ticket Information</h2>";
echo "</div>";

// database info
$con = mysql_connect($seegee_host,$seegee_user,$seegee_password);
if(!$con)
{
	die('Could not connect to the database' .mysql_error());
}
else
{
	mysql_select_db($seegee_database,$con);
}

echo "<div class='o_txt'>";
echo "<h2>Open Tickets</h2>";
echo "</div>";

echo "<div class='c_txt'>";
echo "<h2>Closed Tickets</h2>";
echo "</div>";

	//retrive all data information
	
	$ticket = mysql_query("SELECT * FROM ticket");
	while($rows = mysql_fetch_array($ticket) )
	{
		$id = $rows['id'];
		$tic_id = $rows['id'];
		$tic_date = $rows['date'];
		$tic_status = $rows['status'];
		$tic_problem = $rows['problem'];
		$tic_conv = $rows['numofconv'];
		$customerName = $rows['name'];
		$tic_solution = $rows['solution'];
		$indication = $rows['ind'];
		
		//change the indication that admin opened the recently edited ticket 
		if( $indication == "1")
		{
			mysql_query("UPDATE ticket SET ind = '0' WHERE id = $tic_id");		
		}
		
		//if the status of the ticket is open
		if( $tic_status == "Open" )
		{
		// view the ticket
		echo "<div class='table_open'>";
  		echo "<table width='950' border='1'>";
  		echo "<tr>";
    	echo "<td width='61' align='center'>Ticket ID </td>";
		echo "<td width='112' align='center'> Customer </td> ";
    	echo "<td width='90' align='center'>Date Created</td>";
    	echo "<td width='255' align='center'>Problem</td>";
    	echo "<td width='91' align='center'>Ticket Status</td>";
    	echo "<td width='108' align='center'>Conversations</td>";
  		echo "</tr>";
		
		// check if user did any modifications
		if($indication=='1') 
		{
			
			echo "<tr>";
			echo "<td width='61' align='center'><b><a href='inc/a_tickets.php?ticid=$tic_id'> $tic_id </b></a></td>";
			echo "<td width='112' align='center'><b>$customerName</b></td>";
			echo "<td width='120' align='center'><b>$tic_date</b></td>";
			echo "<td width='255' align='center'><b>$tic_problem</b></td>";
    		echo "<td width='91' align='center'><b>$tic_status</b></td>";
    		echo "<td width='108' align='center'><b>$tic_conv</b></td>";
    		
			// if solution is empty then allow to add solution
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
			echo "<tr>";
			echo "<td width='61' align='center'><a href='inc/a_tickets.php?ticid=$tic_id'> $tic_id </a></td>";
			echo "<td width='112' align='center'>$customerName</td>";
			echo "<td width='120' align='center'>$tic_date</td>";
			echo "<td width='255' align='center'>$tic_problem</td>";
    		echo "<td width='91' align='center'>$tic_status</td>";
    		echo "<td width='108' align='center'>$tic_conv</td>";
			
			// if solution is empty then allow to add solution
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
		
	
	//if the status of the ticket is closed	
    if( $tic_status == "Close" )
	{
		// view the ticket
		
		echo "<div class='table_close'>";
  		echo "<table width='950' border='1'>";
  		echo "<tr>";
    	echo "<td width='61' align='center'>Ticket ID </td>";
		echo "<td width='112' align='center'> Customer </td> ";
    	echo "<td width='90' align='center'>Date Created</td>";
    	echo "<td width='255' align='center'>Problem</td>";
    	echo "<td width='91' align='center'>Ticket Status</td>";
    	echo "<td width='108' align='center'>Conversations</td>";
  		echo "</tr>";
		
		// check if user did any modifications
		if($indication=='1') 
		{
			
			echo "<tr>";
			echo "<td width='61' align='center'><b><a href='inc/a_tickets.php?ticid=$tic_id'> $tic_id </b></a></td>";
			echo "<td width='112' align='center'><b>$customerName</b></td>";
			echo "<td width='150' align='center'><b>$tic_date</b></td>";
			echo "<td width='255' align='center'><b>$tic_problem</b></td>";
    		echo "<td width='91' align='center'><b>$tic_status</b></td>";
    		echo "<td width='108' align='center'><b>$tic_conv</b></td>";
    		
			// if solution is empty then allow to add solution
			if($tic_solution == "")
			{
				echo "<form name='soluForm' action='solution.php?action=$tic_id' method='post' >";
				echo "<td width='108' align='center'> <input type='submit' name='submit_sol' value='Post Solution' />";
				echo "</form>";
			}
    		echo '</tr>';	
		}else
		{
			echo "<tr>";
			echo "<td width='61' align='center'><a href='inc/a_tickets.php?ticid=$tic_id'> $tic_id </a></td>";
			echo "<td width='112' align='center'>$customerName</td>";
			echo "<td width='150' align='center'>$tic_date</td>";
			echo "<td width='255' align='center'>$tic_problem</td>";
    		echo "<td width='91' align='center'>$tic_status</td>";
    		echo "<td width='108' align='center'>$tic_conv</td>";
			
			// if solution is empty then allow to add solution
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

?>
  


