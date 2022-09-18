<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Delete Item</title>
</head>

<body>
<?php
	
	
	/* 
	Delete item
	Deletes a list item from the array file
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


$txtHouseholdCode = $_SESSION[ 'txtHouseholdCode' ];//get the household code from the session
$txtListFile = "Data/{$txtHouseholdCode}/ListItems.txt"; //create the string that will be used to access the list items file

$intIndex = cleanup($_POST[ 'fvItem' ]); //get the index in the array of the item that is being deleted after stripping any present tags

	
	
	
if(isset($_POST['fvItem'])) //if an index for item to delete is set in POST
{
	$intIndex = cleanup($_POST['fvItem']); //get the index in the array of the item that is being deleted after stripping any present tags
	$txtHouseholdCode = $_SESSION['txtHouseholdCode']; //gets the household code from the session

	$txtListFile = "Data/{$txtHouseholdCode}/ListItems.txt"; //creates the string that will be used to access the list items file
	loaddata($txtListFile, $arrListItems); //get the list items array from the file
	
	$txtUsername = $_SESSION['txtUsername']; //get the username from the session
	if($txtUsername != $arrListItems[$intIndex][2]) //if the current user is not the owner of this item
	{
		$txtListFile = "Data/{$txtHouseholdCode}/Credentials.txt"; //create the string that will be used to access the credentials file
		loaddata($txtListFile, $arrCredentials); //get the credentials array from the file
		QuickSort(0, count($arrCredentials)-1, $arrCredentials, 0);	//sort the credentials array ready for searching
		$intCredentialsSearch = BinarySearch($txtUsername, $arrCredentials, 0, 0, count($arrCredentials)-1); //search for the current user's username in the credentials file

		$intAccessLevel = $arrCredentials[$intCredentialsSearch][2]; //get the access level of the user
	
		if($intAccessLevel != "0") //if the user's access level is not 0 (user is not admin)
		{
			echo "<h3>You must be admin or item owner to be able to delete this item</h4>"; //inform the user that they are not permitted to edit this item
			header("refresh:10; url=shopping_list.php"); //redirect the user to the entry menu page
			exit(); //prevent any more code from running on this script
		}
	}
}
	
	
$txtListFile = "Data/{$txtHouseholdCode}/ListItems.txt"; //creates the string that will be used to access the list items file
loaddata( $txtListFile, $arrListItems ); //get the list items array from file
$txtItemName = $arrListItems[ $intIndex ][ 0 ]; //get the name of the item from the array
unset( $arrListItems[ $intIndex ]); //remove the item from the array
savedata( $txtListFile, $arrListItems ); //save the new array

unset($_SESSION['arrListItems']); //remove the list items array from the session to force the new, updated, array to be loaded from the file
echo('Item "' . $txtItemName . '" has been deleted'); //inform the user that the item has been deleted

header( "refresh:3; url=shopping_list.php" ); //redirect the user to the main list page, after 3 seconds

?>
</body>
</html>
