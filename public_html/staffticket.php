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
<h3><a href="staffpanel.php">Staff Panel</a></h3>
</div>


<?php

if(!isset($_SESSION['staffsession']))
{
	header("location:stafflogin.php?action=no");
}

include("inc/dbconfig.php");

echo "<div class='h2_v_staff'>";
echo "<h2>Customer Ticket Information</h2>";
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
		$indication = $output['ind'];
		$cus_ind = $output['cus_ind'];
	
		if( $indication == "1")
		{
			mysql_query("UPDATE ticket SET ind = '0' WHERE id = $tic_id");		
		}
	}
	
	echo "<div class='table_v'>";
	echo "<table width='482' height='227' border='1'>
 	 <tr>
    	<td width='171'>Ticket ID :</td>
    	<td width='295'>$tic_id</td>
  	</tr>
  	<tr>
    	<td width>Date Created :</td>
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
	 <tr>";
	 
	 //if no solution provided then post solution button will appear	 
	 if($tic_solution!="")
	 {
	  ?>
		<td>Solution : </br></br><a href="solution.php?deleteCmd=<?php echo $tic_id?>">Delete this solution</a>
		</td>
      <?php
	 }else
     {
	  ?>
        <td>Solution : </td>
      <?php
     }
	   if($tic_solution=="")
	   {
	  		echo "<td>
			<a href='solution.php?action=$tic_id'>Post solution for this problem</a>
			</td>";
	 	}else
     	{
    		 echo "<td>$tic_solution<p>&nbsp;</p></td>";
     	}
      echo "</tr>
	  </table>
	  </div>";
			
// show the result

	$tic_conv = mysql_query("SELECT * FROM conv WHERE id=$ticID");
	$c = 0;
		while($out_conv = mysql_fetch_array($tic_conv))
		{
			$conv_name = $out_conv['name'];
			$creator = $out_conv['creator'];
			$conv_date = $out_conv['time'];
			$conv_conv = $out_conv['conv'];	
			$conv_id   = $out_conv['id'];
			
				echo "<div class='conv_table'>";
				echo "<table width='482' height='50' border='1'>";
				echo '<tr>';
   				echo "<td width='295'> $creator : $conv_name</td>";
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
				
			if($creator == "Staff")
			{
				$deleteKey = $conv_date;	
				?>
				<form name="delete" action="staffticket.php?deletecmd=<?php echo $deleteKey?>" method="post">
				<input type="submit" value="Delete" class="btn">
                </form>
            	<?php
			}
			echo "</div>";
			$addTic = $c + 1;
		    mysql_query("UPDATE ticket SET numofconv = $addTic WHERE id=$conv_id");
		    $c++;
		}
		
		$updateID = $_REQUEST['update'];
		$deletecmd = $_REQUEST['deletecmd'];
		$req_status = $_REQUEST['update_status'];

        // request
		if(isset($_REQUEST['update']))
		{
			$time_stamp = date('l jS \of F Y h:i:s A');
			$comm = $_POST['comment'];
			
			$look_name = $_SESSION['staffsession'];
			$result_com = mysql_query("SELECT staffprofile.name FROM staffprofile WHERE username = '$look_name' ");
			$viewname = mysql_fetch_array($result_com);
			$name_com = $viewname['name'];
			
			$sqlconv = "INSERT INTO conv (id ,time, name, creator, conv)
		VALUES('$updateID','$time_stamp','$name_com','Staff','$comm')";
		
			mysql_query("UPDATE ticket SET cus_ind  = '1' WHERE id = $updateID");
		
			//update the status of the ticket
			
			if(!mysql_query($sqlconv,$con))
			{
				die('Error: ' . mysql_error());
			}
			mysql_close($con);
			header("location:staffticket.php?ticid=$updateID");
	    }	 
	
		if(isset($_REQUEST['deletecmd']))
		{
			$getID = mysql_query("SELECT conv.id FROM conv WHERE time = '$deletecmd' ");
			$Id_output = mysql_fetch_array($getID);
			$show_ID = $Id_output['id'];
			
			$decr = mysql_query("SELECT ticket.numofconv FROM ticket WHERE id = '$show_ID' ");
			$decNumofconv = mysql_fetch_array($decr);
			$show_numofconv = $decNumofconv['numofconv'];
		
			if($show_numofconv!=0)
			{	 
				mysql_query("DELETE FROM conv WHERE time='$deletecmd' ");
				$ticID = $show_ID;
				
				$storeTick = $show_numofconv - 1;
				
				mysql_query("UPDATE ticket SET numofconv = $storeTick WHERE id = '$show_ID' ");
				
				mysql_close($con);
				header("location:staffticket.php?ticid=$ticID");
	   		}
		}
		if(isset($_REQUEST['update_status']))
		{
			$update_status = $_REQUEST['status_input'];
			mysql_query("UPDATE ticket SET status = '$update_status' WHERE id = '$req_status'");
			mysql_close($con);
			header("location:staffticket.php?ticid=$req_status");
		}
mysql_close($con);
	   	
// creating table
?>

<?php

if($solution!= "empty")
{	

?>
	<div class="com_box">
    
    <form name="update_status" method="post" action="staffticket.php?update_status=<?php echo $ticID?>" >
    	<p>Status of the ticket :</p></br>
    	<select name="status_input">
    	<option value="Open">Open</option>
    	<option value="Close">Close</option>
    	</select>
    	&nbsp;&nbsp;
    	<input type="submit" name="submit_status" value="Update Status" />
    </form>
    
	<form name="commentform" method="post" action="staffticket.php?update=<?php echo $ticID?>">
    	</br></br>  
		<p>Comments :</p>
		<p>
    		<textarea name="comment" cols="57" rows="5">
    		</textarea>
		</p>
		<p>
			<input type="submit" name="submit" value="Update Comment" />
 		</p>
 	</form>   
	
    </div>
    
    <?php
 }
 ?>

<div class="signout_staff_view">
<a href="stafflogin.php?action=logout"><h3>Logout</h3></a>
</div>
