<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Signup</title>
</head>

<body>
	
<?php

	
	/* 
	Signup form
	Gets data for adding new items to list
	Author: Jensen Lloyd 
	Date: 29/07/2022
	Version: 1.0
	*/
	
	
	
session_start(); //enable session
include "functions.php"; //import functions for later use


if (isset($_SESSION['txtErrorOnPage'])) //if error messages have been set
{
	$txtError = $_SESSION['txtErrorOnPage']; //get error message from session
	$txtUsername = $_SESSION['txtUsername']; //get previously set username from session
	$txtPassword = $_SESSION['txtPassword']; //get previously set password from session
}
	
else //if no error messages have been set
{
	$txtError = ""; //set error message to be blank
	$txtUsername = ""; //set username to be blank
	$txtPassword = ""; //set password to be blank
}
	

unset($_SESSION['txtErrorOnPage']); //remove error messages from session
unset($_SESSION['txtUsername']); //remove username from session
unset($_SESSION['txtPassword']); //remove password from sssion
	
?>
	
	
	
<h2>Signup
</h2>
<form id="form1" name="form1" method="post">
  <p>
    <label for="fvUsername">Username:</label>
    <input name="fvUsername" type="text" id="fvUsername" value="<?php echo $txtUsername ?>"> <!--display username-->
  <p>
    <label for="fvPassword">Password:</label>
    <input name="fvPassword" type="password" id="fvPassword" value="<?php echo $txtPassword ?>"> <!--display password-->
  <p><span style="color: #FF0000"><?php echo $txtError ?></span></p></p> <!--display error message-->
  <p>Note: Usernames and passwords must be at <BR>least 4 and 8 characters long, respectively.</p>
  <p>
    <input name="submit" type="submit" id="submit" formaction="signup.php" value="Sign up!">
  </p>
</form>
<p>&nbsp;</p>
</body>
</html>
