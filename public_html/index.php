<?php
/*
* Created By : Krishanthan Krishnamoorthy
* Computer Science
* University Of Wyoming
* kkrishna@uwyo.edu
*/
       
?>

<?php include("inc/header.php") ?>

<html>
<title>Help Desk</title>
<div class="mainbanner">
<img src="images/header.jpg"/>
</div>
<div class="tic_image">
<img src="images/tickimg.png"/>
</div>


<div class="count_view">	
<a href="http://www.easycounter.com/">
<img src="http://www.easycounter.com/counter.php?krishan23"
border="0" alt="Web Counter"></a>
</div>


<div class="register">
<h3>New user? <a href="signup.php">register here</a></h3>
</div>

<?php

// starting sessions

session_start();

if(isset($_SESSION['username']))
{
	header("location:userpanel.php");
}
if(isset($_SESSION['staffsession']))
{
	header("location:stafflogin.php?action=yes");
}
if(isset($_SESSION['adminsession']))
{
	header("location:adminlogin.php?action=yes");
}

//database connection

include("inc/dbconfig.php");
?>

<div class="frnt_text">
user login:&nbsp; macuser,pass:mac123
</br>
Staff demo page:&nbsp; <a href="http://supportticket.net78.net/staff.php">Staff login</a>
</br>
login:&nbsp; staff, pass: demo
</br>
Admin demo page:&nbsp; <a href="http://supportticket.net78.net/admin.php">Admin login</a>
</br>
login:&nbsp; admin, pass: demo
</br></br></br>
Please use Google Chrome or Firefox.
</div>


<div class="login">
<div class="loginBox">
<form name="form" action="login.php?action=check" method="post">
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

