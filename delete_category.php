<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Delete category</title>
</head>

<body>
	
<?php

	
	/* 
	Delete category
	Removes a category from the array file
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
$txtListFile = "Data/{$txtHouseholdCode}/Categories.txt"; //create the string that will be used to access the categories file
	
$intIndex = cleanup($_POST['fvCategory']); //get the index of the category to be deleted from the POST after removing tags


loaddata1d($txtListFile, $arrCategories); //get the categories array from file
$txtCategoryName = $arrCategories[$intIndex]; //get the name of the category that is being deleted from the array
unset($arrCategories[$intIndex]); //remove the category from the array
savedata1d($txtListFile, $arrCategories); //save the new array


echo("Category '" . $txtCategoryName . "' has been deleted"); //inform the user which category they deleted
	
header ("refresh:3; url=edit_categories.php"); //redirect the user to the main categories page after 3 seconds
	
?>
</body>
</html>
