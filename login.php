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
	Login
	Authenticates users before they can access other pages
	Author: Jensen Lloyd 
	Date: 29/07/2022
	Version: 1.0
	*/
	
	
	
	
session_start(); //enable session
include "functions.php"; //import functions for future use

$txtUsername = cleanup($_POST['fvUsername']); //get the username from the form via POST after being stripped of tags
$txtPassword = cleanup($_POST['fvPassword']); //get the password from the form via POST after being stripped of tags
	
$txtHouseholdCode = $_SESSION['txtHouseholdCode']; //get the household code from the session
$txtListFile = "Data/{$txtHouseholdCode}/Credentials.txt"; //create the string that will be used to access the credentials file

$_SESSION['txtUsername'] = $txtUsername; //put the username into the session
$_SESSION['txtPassword'] = $txtPassword; //put the password into the session

unset($_SESSION['txtErrorOnPage']); //ensure that there are no residual error messages in the session
$_SESSION['boolAccessGranted'] = false; //set users to be unauthenticated, by default


	
	
	
if($_POST['fvUsername'] == "") //if the username submitted is blank
{
	$_SESSION['txtErrorOnPage'] = "Please enter a username"; //set error message
	header("refresh:0; url=login_form.php"); //redirect the user back to the login form
	exit(); //prevent any further code from running
}
	
	
if($_POST['fvPassword'] == "") //if the password submitted is blank
{
	$_SESSION['txtErrorOnPage'] = "Please enter a password"; //set error message
	header("refresh:0; url=login_form.php"); //redirect the user back to the login form
	exit(); //prevent any further code from running
}	
	

if(strlen($txtUsername) < 4) //if the username is less than 4 characters
{
	$_SESSION['txtErrorOnPage'] = "Username incorrect <BR>Valid usernames contain 4 or more characters"; //set error message
	header("refresh:0; url=login_form.php"); //redirect the user back to the login form
	exit(); //prevent any further code from running
}
	
	
if(strlen($txtPassword) < 8) //if the password has less than 8 characters
{
	$_SESSION['txtErrorOnPage'] = "Password incorrect <BR>Valid Passwords contain 8 or more characters"; //set error message
	header("refresh:0; url=login_form.php"); //redirect the user back to the login form
	exit(); //prevent any further code from running
}
	
	


loaddata($txtListFile, $arrCredentials); //load the credentials array from file

if(count($arrCredentials) == 0) //if the number of user credentials in the household is 0
{
	$_SESSION['txtErrorOnPage'] = "There are no accounts for this household"; //set error message
	header("refresh:0; url=login_form.php"); //redirect the user back to the login form
	exit(); //prevent any further code from running
}

	
QuickSort(0, count($arrCredentials)-1, $arrCredentials, 0);	//sort the credentials array before search
$intCredentialsSearch = BinarySearch($txtUsername, $arrCredentials, 0, 0, count($arrCredentials)-1); //search for the username in the credentials file

	
if(($intCredentialsSearch == "") and ($intCredentialsSearch != 0)) //if the search results in no matches
{
	$_SESSION['txtErrorOnPage'] = "An account with this username does not exist"; //set error message
	header("refresh:10; url=login_form.php"); //redirect the user to the login form 
	exit(); //prevent any further code from running
}

	
else //if there are no issues with the entered data
{
	$txtHashedCredentials = hash("sha256", ($txtUsername . $txtPassword), false); //hash the username and password using sha256
		
		
	if($txtHashedCredentials != $arrCredentials[$intCredentialsSearch][1]) //if the hash and recorded hash do not match
	{
		$_SESSION['txtErrorOnPage'] = "Password is incorrect"; //set error message
		header("refresh:0; url=login_form.php"); //redirect the user to the login form
		exit(); //prevent any further code from running
	}
	
	if($txtHashedCredentials == $arrCredentials[$intCredentialsSearch][1]) //if the hash and recordede hash match
	{
		$_SESSION['boolAccessGranted'] = true; //allow the user access to the pages
		echo 'Welcome to household "' . $_SESSION['txtHouseholdCode'] . '"!'; //inform the user that they have successfully logged in
		header ("refresh:3; url=shopping_list.php"); //redirect the user to the main list page after 3 seconds
	}
}

	
?>

</body>
</html>
