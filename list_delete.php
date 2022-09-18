<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Clear List</title>
</head>

<body>

<?php
	
	
	/* 
	List Delete
	Clears all items from the list
	Author: Jensen Lloyd 
	Date: 29/07/2022
	Version: 1.0
	*/
	
	
	
session_start(); //enable the session
include "functions.php"; //import functions for later use in this script
	
	
if($_SESSION['boolAccessGranted'] != true) //if the user is not authenticated
{
	echo("You are not permitted to view this page. <BR>Please log in"); //inform the user that they are not authenticated
	header("refresh:10; url=entry_menu.html"); //redirect the user to the entry menu after 10 seconds
	exit(); //prevent any more code on this script from running
}
	
$txtHouseholdCode = $_SESSION['txtHouseholdCode']; //get the household code from the session

$txtListFile = "Data/{$txtHouseholdCode}/ListItems.txt"; //create the string that will be used for accessing the list items

$arrListItems  = [["Item Name", "Quantity", "Owner", "Category"]]; //create an empty array for list items
savedata($txtListFile , $arrListItems); //save the empty array in the file
	
$_SESSION['arrListItems'] = $arrListItems; //put the new list into the session
echo "List cleared"; //inform the user that their list has been deleted
header ("refresh:2; url=shopping_list.php"); //redirect the user back to the main list after 2 seconds
?>

</body>
</html>
