<?php include("inc/header.php") ?>

<html>
<div class="mainbanner">
<img src="images/header.jpg"/>
</div>

<div class='h1_view'>

<h1>Welcome to Seegee Ticket user registration</h1>

</div>

<div class="signup">
<form name="signup" action="signup_validation.php" method="post">
	<h4>Username   :</h4><input type="text" size="30" name="username" /></br>
	<h4>Password   :</h4><input type="password" size="30" name="password" /></br>
	<h4>Name       :</h4><input type="text" size="30" name="name" /></br>
	<h4>Address    :</h4><input type="text" size="30" name="address" /></br>
	<h4>Phone      :</h4><input type="text" size="30" name="phone" /></br>
	<h4>E-mail     :</h4><input type="text" size="30" name="email" /></br></br>
	<input type="submit" value="Register" name="submit" />
</form>

</div>
<html>





