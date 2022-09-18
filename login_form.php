<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
</head>

<body>
	
	
<?php
	
	
		/* 
	Login form
	Gets data for authenticating users
	Author: Jensen Lloyd 
	Date: 29/07/2022
	Version: 1.0
	*/
	
	
	
	
session_start(); //enable the session
include "functions.php"; //import functions for later use
	
$txtHouseholdCode = $_SESSION['txtHouseholdCode']; //get the houehold code from the session


if (isset($_SESSION['txtErrorOnPage'])) //if error messages have been set
{
	$txtError = $_SESSION['txtErrorOnPage']; //get error message from session
	$txtUsername = $_SESSION['txtUsername']; //get the previously entered username from session
	$txtPassword = $_SESSION['txtPassword']; //get the previously entered passowrd from session
}
	
else //if there are no error messages
{
	$txtError = ""; //set the error messages to be blank
	$txtUsername = ""; //set the username to be blank
	$txtPassword = ""; //set the password to be blank
}
	

unset($_SESSION['txtErrorOnPage']); //remove any error messages
unset($_SESSION['txtUsername']); //remove username from session
unset($_SESSION['txtPassword']); //remove pasword from session
	
	
?>
	
	
<h1>Login</h1>
  <p style="color: #000000">(Please ensure that these login details are for "<?php echo($txtHouseholdCode) ?>")</p>
<form id="form1" name="form1" method="post">
  <p>
    <label for="fvUsername">Username:</label>
    <input name="fvUsername" type="text" id="fvUsername" value="<?php echo($txtUsername) ?>"> 
  </p>
  <p>
    <label for="fvPassword">Password:</label>
    <input name="fvPassword" type="password" id="fvPassword" value="<?php echo($txtPassword) ?>">
	  
  <p><span style="color: #FF0000"><?php echo($txtError) ?></span></p>
	
	
    <input name="submit" type="submit" id="submit" formaction="login.php" value="Login">
    <p><input name="submit2" type="submit" id="submit2" formaction="signup_form.php" value="Sign up page"></p>
  </p>
</form>
<p>&nbsp;</p>
</body>
</html>
