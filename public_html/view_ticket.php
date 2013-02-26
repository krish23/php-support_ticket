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
<h3><a href="userpanel.php">User Panel</a></h3>
</div>

<?php

if(!isset($_SESSION['username']))
{
	header("location:login.php?action=no");
}

include("inc/dbconfig.php");

echo "<div class='h2_v'>";
echo "<h2>Your Ticket Information</h2>";
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

	$ticID = $_REQUEST['ticid'];

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
		$indication = $output['cus_ind'];
	
		if( $indication == "1")
		{
			mysql_query("UPDATE ticket SET cus_ind = '0' WHERE id = $tic_id");		
		}
	}
	
	echo "<div class='table_v_user'>";
	echo "<table width='482' height='227' border='1'>
  	<tr>
    	<td width='171'>Ticket ID :</td>
    	<td width='295'>$tic_id</td>
  	</tr>
   <tr>
    	<td>Date Created :</td>
    	<td>$tic_date</td>
  </tr>
	
  <tr>
    	<td>Status :</td>
    	<td>$tic_status</td>
  </tr>
  
  <tr>
    	<td>Problem :</td>
    	<td>$tic_problem<p>&nbsp;</p></td>
  </tr>
  
  <tr>
    	<td>Solution :</td>
    	<td>$tic_solution<p>&nbsp;</p></td>
  </tr>
  
</table>";

echo "</div>";
	
// show the result

	$tic_conv = mysql_query("SELECT * FROM conv WHERE id='$ticID' ");
	
	$c = 0;
		while( $out_conv = mysql_fetch_array($tic_conv))
		{
			$conv_name = $out_conv['name'];
			$conv_date = $out_conv['time'];
			$conv_conv = $out_conv['conv'];	
			$conv_id   = $out_conv['id'];
			$creator = $out_conv['creator'];
			
			echo "<div class='conv_table_user'>";
			echo "<table width='482' height='50' border='1'>";
			echo '<tr>';
   			echo "<td width='295'>$creator : $conv_name</td>";
  			echo '</tr>';
			echo '<tr>';
			echo "<td width='295'>$conv_date</td>";
  			echo '</tr>';
			echo '<tr>';
			echo "<td width='295'>$conv_conv";
    		echo '<p>&nbsp;</p>';
    		echo '<p>&nbsp;</p></td>';
  			echo '</tr>';
			echo '</table>';
			echo '<br>';
			
			if($creator == "Customer")
			{
				$deleteKey = $conv_date;	
				?>
				<form name="delete" action="view_ticket.php?deletecmd=<?php echo $deleteKey?>" method="post">
				<input type="submit" value="Delete" class="btn">
                </form>
            	<?php
			}
			echo "</div>";
			$addTic = $c + 1;
			$c++;
		  mysql_query("UPDATE ticket SET numofconv = $addTic WHERE id=$conv_id");
		}
			
		  
$updateID = $_REQUEST['update'];
$deletecmd = $_REQUEST['deletecmd'];

if(isset($_REQUEST['update']))
{
		$time_stamp = date('l jS \of F Y h:i:s A');
		$comm = $_POST['comment'];
			
		$result_com = mysql_query("SELECT ticket.name FROM ticket WHERE id = $updateID");
		$viewname = mysql_fetch_array($result_com);
		$name_com = $viewname['name'];
			
		$sqlconv = "INSERT INTO conv (id ,time, name, creator, conv)
		VALUES('$updateID','$time_stamp','$name_com', 'Customer','$comm')";
		
		mysql_query("UPDATE ticket SET ind  = '1' WHERE id = $updateID");
		
		if(!mysql_query($sqlconv,$con))
		{
			die('Error: ' . mysql_error());
		}
		mysql_close($con);
		
		header("location:view_ticket.php?ticid=$updateID");
} 

if(isset($_REQUEST['deletecmd']))
{
		$getID = mysql_query("SELECT conv.id FROM conv WHERE time = '$deletecmd' ");
		$Id_output = mysql_fetch_array($getID);
		$show_ID = $Id_output['id'];
	
		$decr = mysql_query("SELECT ticket.numofconv FROM ticket WHERE id= '$show_ID' ");
		$decNumofconv = mysql_fetch_array($decr);
		$show_numofconv = $decNumofconv['numofconv'];
		
		if($show_numofconv!=0)
		{	 
			mysql_query("DELETE FROM conv WHERE time = '$deletecmd' ");
			$ticID = $show_ID;
		
			$storeTick = $show_numofconv - 1;
			mysql_query("UPDATE ticket SET numofconv = $storeTick WHERE id = '$show_ID' ");
		
		
			mysql_close($con);
			header("location:view_ticket.php?ticid=$ticID");
		}
	}
 

// creating table
?>

<div class="com_box_user">

<form name="commentform" method="post" action="view_ticket.php?update= <?php echo $ticID?>">  
	<p>Comments :</p>
	<p>
  		<textarea name="comment" cols="57" rows="5">
    	Enter your comment....
    	</textarea>
	</p>
	<p>
		<input type="submit" name="submit" value="Update" >
 	</p>
</form>   

</div>

<div class="signout_user">
<a href="login.php?action=logout"><h3>Logout</h3></a>
</div>

