<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Household</title>
</head>

<body>
	
	
<script type="text/javascript" src="clipboard.js"></script>

	
<?php

		/* 
	Create Household
	Creates a household code and directory for files to use
	Author: Jensen Lloyd 
	Date: 29/07/2022
	Version: 1.0
	*/
	
	
	
include "functions.php"; //import functions for laer use
session_start(); //enable the session
session_unset();

unset($_SESSION['txtHouseholdCode']); //remove the household code to ensure it is blank before making a new one

	
//lines 18&19 from user "bluish", https://stackoverflow.com/questions/470617/how-do-i-get-the-current-date-and-time-in-php
$date = date('Y-m-d H:i:s'); //get the current date and time
$txtHash = hash("sha256", $date, false); //hash the date using sha256

$count = 0; //create a counting variable
$txtHouseholdCode = ""; //initialise houosehold code as blank
while($count < 64) //run the code while count is less than 64
{
	if (($count % 8) == 0) //if the result of count/8 has a remainder of 0
	{
		$txtHouseholdCode .= $txtHash[$count]; //get the character in the hashed string at index of count
	}
	
	$count++; //iterate count by 1
}
	
	

mkdir("Data/" . $txtHouseholdCode); //create the directory for the new household
$_SESSION['txtHouseholdCode'] = $txtHouseholdCode; //put the new household code into the session
	
	
echo 'Welcome to your new household list, "' . $txtHouseholdCode . '" <br>'; //display the new household code to the user
echo "Use this code to invite others to your list. <br><br>"; //inform the user that this is their household code to use
echo '<input type="text" value="' . $txtHouseholdCode . '" id="householdCode"><br>'; //display html for a textbox that will allow the user to easily copy the code
echo '<button onclick="clipboard()">Copy household code <BR>to clipboard</button>'; //display the html for a button that will run a Javascript function to copy the household code to the user's clipboard
	

header ("refresh:5; url=signup_form.php"); //redirect the user to the signup form
	
?>

</body>
</html>