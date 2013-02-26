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
<h3><a href="staffpanel.php">Admin/Staff Panel</a></h3>
</div>

<?php

if( (!isset($_SESSION['staffsession'])) && (!isset($_SESSION['adminsession']) ) )
{
	header("location:stafflogin.php?action=no");
}

include("inc/dbconfig.php");

echo "<div class='h2_v_staff'>";
echo "<h2>Customer Ticket Solution</h2>";
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

	//Receive request
	$ticID = $_REQUEST['action'];
	$view = mysql_query("SELECT * FROM ticket WHERE id='$ticID'");

	while($output = mysql_fetch_array($view))
	{
		$tic_id = $output['id'];
		$tic_name = $output['name'];
		$tic_date = $output['date'];
		$tic_status = $output['status'];
		$tic_problem = $output['problem'];
		$tic_solution = $output['solution'];
		$tic_c = $output['numofconv'];
		$indication = $output['ind'];
		$cus_ind = $output['cus_ind'];
	}
	
	echo '<tr>';
	echo "<div class='solu'>";
	?>
    
    <h4>Ticket ID     : </h4><?php echo $tic_id;  ?></br>
    <h4>Customer Name : </h4><?php echo $tic_name;?></br>
    <h4>Date Created  : </h4><?php echo $tic_date;?></br>
    <h4>Problem       : </h4><?php echo $tic_problem;?></br></br></br></br>
    Solution :</br>
	<form name="typeSolution" action="solution.php?updateSol=<?php echo $tic_id?>" method="post"> 
	<textarea rows="6" cols="50" name="solution"></textarea>
	</tr>
    </table>
	<div class="btn_sol">
	<input type='submit' name='upSol' value='Update' />
	</div>
    </form>
    </html>
    
    
<?php
//action

$updateSol = $_REQUEST['updateSol'];
$solution = $_REQUEST['solution'];

if(isset($_REQUEST['updateSol']))
{
	
	mysql_query("UPDATE ticket SET solution = '$solution' WHERE id = '$updateSol' ");
	mysql_close($con);
	
	if(isset($_SESSION['adminsession']))
	{
		header("location:inc/a_tickets.php?ticid=$updateSol");	
	}
	else
	{
		header("location:staffticket.php?ticid=$updateSol");
	}
}

$deleteCmd = $_REQUEST['deleteCmd'];

if(isset($_REQUEST['deleteCmd']))
{
	mysql_query("UPDATE ticket SET solution = '' WHERE id = '$deleteCmd' ");
	mysql_close($con);
	if(isset($_SESSION['adminsession']))
	{
		header("location:inc/a_tickets.php?ticid=$deleteCmd");	
	}
	else
	{
		header("location:staffticket.php?ticid=$deleteCmd");
	}
}
?>
    
    