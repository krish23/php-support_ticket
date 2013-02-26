<?php /*
* Created By : Krishanthan Krishnamoorthy
* Computer Science
* University Of Wyoming
* kkrishna@uwyo.edu
*/ ?>

<?php include("inc/header.php"); ?>

<div class="mainbanner">
<img src="images/header.jpg"/>
</div>

<div class="welcome_staff">
<h2>Staff Login</h2>
</div>


<?php
session_start();
if(isset($_SESSION['staffsession']))
{
	header("location:staffpanel.php");
}

if(isset($_SESSION['username']))
{
	header("location:userpanel.php");
}
if(isset($_SESSION['adminsession']))
{
	header("location:adminpanel.php");
}

include("inc/dbconfig.php");
?>

<html>

<div class="login">
<div class="loginBox">
<form name="form" action="stafflogin.php?action=check" method="post">
<p>
  <label> 
    <strong class="user-label">Username</strong> 
    <input type="text" name="username" maxlength="75">
  </label>
</p>
<p>
  <label> 
    <strong class="passwd-label">Password </strong>
    <input type="password" name="password"> 
    <br>
    <br>
  </label>
  <input type="submit" name="login" class="btn" value="Login">
</p>
</form>
</div>
</div>


