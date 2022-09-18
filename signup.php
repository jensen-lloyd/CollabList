<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Signup</title>
</head>

<body>
	
<p>
	
<?php
	
	
		/* 
	Signup
	Add new user credentials
	Author: Jensen Lloyd 
	Date: 29/07/2022
	Version: 1.0
	*/
	
	
	
session_start();
include "functions.php";

$txtUsername = cleanup($_POST['fvUsername']);
$txtPassword = cleanup($_POST['fvPassword']);
	
$txtHouseholdCode = $_SESSION['txtHouseholdCode'];
$txtListFile = "Data/{$txtHouseholdCode}/Credentials.txt";

$_SESSION['txtUsername'] = $txtUsername;
$_SESSION['txtPassword'] = $txtPassword;

unset($_SESSION['txtErrorOnPage']);	

	
	

if($_POST['fvUsername'] == "")
{
	$_SESSION['txtErrorOnPage'] = "Please enter a username";
	header("refresh:0; url=signup_form.php");
	exit();
}
	
	
if($_POST['fvPassword'] == "")
{
	$_SESSION['txtErrorOnPage'] = "Please enter a password";
	header("refresh:0; url=signup_form.php");
	exit();
}
	
	
if (file_exists($txtListFile) == true)
{
	loaddata($txtListFile, $arrCredentials);
	
	$arrFindOutputs = array();
	find($txtUsername, $arrCredentials, 0, $arrFindOutputs, "E");
	if(count($arrFindOutputs) > 0)
	{
		$_SESSION['txtErrorOnPage'] = "This username is taken, please choose another username. <BR>If you already have an account, log in ";
		header("refresh:0; url=signup_form.php");
		exit();
	}
}

	
if(strlen($txtUsername) < 4)
{
	$_SESSION['txtErrorOnPage'] = "Please enter a username of 4 characters or more";
	header("refresh:0; url=signup_form.php");
	exit();
}
	
	
if(strlen($txtPassword) < 8)
{
	$_SESSION['txtErrorOnPage'] = "Please enter a password of 8 characters or more";
	header("refresh:0; url=signup_form.php");
	exit();
}
	
	
	
	
if (file_exists($txtListFile) == true)
{	
	$arrUserCredential = array(
		($txtUsername), 
		(hash("sha256", ($txtUsername . $txtPassword), false)), 
		(1));
	
	
	loaddata($txtListFile, $arrCredentials);
	array_push($arrCredentials, $arrUserCredential);
	savedata($txtListFile , $arrCredentials);	
}

	
if (file_exists($txtListFile) == false)
{
    $arrUserCredential = array(
		($txtUsername),
		(hash("sha256", ($txtUsername . $txtPassword), false)),     
		(0));

    $arrCredentials = array($arrUserCredential);
    savedata($txtListFile, $arrCredentials);
}
	  
	 
unset($_SESSION['txtUsername']);
unset($_SESSION['txtPassword']);
unset($_SESSION['txtErrorOnPage']);	
	
echo 'Welcome to household "' . $_SESSION['txtHouseholdCode'] . '"!';
echo "<BR>Now, please log in.";
header ("refresh:2; url=login_form.php");
	
?>

</p>
</body>
</html>
