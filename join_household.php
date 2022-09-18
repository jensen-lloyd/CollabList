<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Join Household</title>
</head>

<body>
	
<?php
	
	
	
	/* 
	Join Household
	Allows a user to begin logging in to or signing up for an account in a household
	Author: Jensen Lloyd 
	Date: 29/07/2022
	Version: 1.0
	*/
	

session_start(); //enable the session
include "functions.php"; //import functions for later use in this script
session_unset();
	
$txtHouseholdCode = cleanup($_POST['fvHouseholdCode']); //get the houosehold code entered by the user from the form via POST after stripping tags
	
$_SESSION['txtHouseholdCode'] = $txtHouseholdCode; //put the household code in the session
$txtListFile = "Data/{$txtHouseholdCode}/Credentials.txt"; //create the string that will be used to access the credentials file
	
	
unset($_SESSION['txtErrorOnPage']); //ensure that there are no residual error messages in the session
	

if($_POST['fvHouseholdCode'] == "") //if the houosehold code that was entered is blank
{
	$_SESSION['txtErrorOnPage'] = "Please enter a household code"; //set error message
	header("refresh:0; url=join_household_form.php"); //redirect the user back to the form
	exit(); //prevent any further code in this script from running
}
	
	
if(strlen($txtHouseholdCode) < 8) //if the household code is less than 8 characters long
{
	$_SESSION['txtErrorOnPage'] = "This household code is too short! <BR>A valid code is 8 characters"; //set error message
	header("refresh:0; url=join_household_form.php"); //redirect the user back to the form
	exit(); //prevent any further code in this script from running
}
	
	
if(strlen($txtHouseholdCode) > 8) //if the household code is more than 8 characters long
{
	$_SESSION['txtErrorOnPage'] = "This household code is too long! <BR>A valid code is 8 characters"; //set error message
	header("refresh:0; url=join_household_form.php"); //redirect the user back to the form
	exit(); //prevent any further code in this script from running
}
	
if(file_exists($txtListFile) == false) //if the credentials file (meaning the entire household), does not yet exist
{
	$_SESSION['txtErrorOnPage'] = "This household does not exist! <BR>Please check the code and try again."; //set error message
	header("refresh:0; url=join_household_form.php"); //redirect the user back to the form
	exit(); //prevent any further code in this script from running
}


else //if there are no issues with the data entered
{
	unset($_SESSION['txtErrorOnPage']); //ensure that there are no residual error messages in the session
	echo('Welcome to household list "' . $txtHouseholdCode . '"'); //inform the user that they have been granted access to the hoousehold
	header ("refresh:2; url=login_form.php"); //redirect the user to the login form
	exit(); //revent any further code in this script from running
}
	

	
?>
 
</body>
</html>
