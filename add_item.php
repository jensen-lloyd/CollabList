<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add/Edit Item</title>
</head>

<body>
	
	
<?php

	
	/* 
	Add Item
	Takes data entered in form, performs validation and adds the new item to file
	Author: Jensen Lloyd 
	Date: 29/07/2022
	Version: 1.0
	*/
	
	
	
include "functions.php"; //import functions into this script for later use
session_start(); //enable the session
	
$txtItemName = cleanup($_POST['fvItemName']); //get item name from post and strip tags
$intItemQuantity = cleanup($_POST['fvItemQuantity']); //get item quantity from post and strip tags
$txtItemCategory = cleanup($_POST['fvItemCategory']); //get item category from post and strip tags
$txtUsername = $_SESSION['txtUsername']; //get username from the session
	
	
$txtHouseholdCode = $_SESSION['txtHouseholdCode']; //get household code frmo the session
$txtListFile = "Data/{$txtHouseholdCode}/ListItems.txt"; //create the string used for accessing the lsit items file

	
	
$_SESSION['txtItemName'] = $txtItemName; //put item name into the session
$_SESSION['intItemQuantity'] = $intItemQuantity; //put item quantity into the session
$_SESSION['txtItemCategory'] = $txtItemCategory; //put item category into the session
	
if($_POST['fvItemName'] == "") //if the item name in post is blank
{
	$_SESSION['txtErrorOnPage'] = "Please enter an item Name"; //set error message
	header("refresh:0; url=add_item_form.php"); //redirect to the form
	exit(); //prevent any other code in this script from running
}
	
if($_POST['fvItemQuantity'] == "") //if the item quantity in post is blank
{
	$_SESSION['txtErrorOnPage'] = "Please enter an item Quantity"; //set error message
	header("refresh:0; url=add_item_form.php"); //redirect to the form
	exit(); //prevent any other code in this script from running
}
	
if($_POST['fvItemCategory'] == "") //if the item category in post is blank
{
	$_SESSION['txtErrorOnPage'] = "Please enter an item Category"; //set error message
	header("refresh:0; url=add_item_form.php"); //redirect to the form
	exit(); //prevent any other code in this script from running
}
	

	

if(!is_numeric($intItemQuantity)) //if the item quantity is not a number
{
	$_SESSION['txtErrorOnPage'] = "Please enter a valid number for quantity"; //set error message
	header("refresh:0; url=add_item_form.php"); //redirect to the form
	exit(); //prevent any other code in this script from running
}
	
if($intItemQuantity < 1) //if the item quantity is less than 1
{
	$_SESSION['txtErrorOnPage'] = "Please enter an item Quantity of 1 or higher"; //set error message
	header("refresh:0; url=add_item_form.php"); //redirect to the form
	exit(); //prevent any other code in this script from running
}
	 
if($intItemQuantity >= 1000) //if the item quantity is greater than or equal to 1000
{
	$_SESSION['txtErrorOnPage'] = "Please enter an item Quantity less than 1000"; //set error message
	header("refresh:0; url=add_item_form.php"); //redirect to the form
	exit(); //prevent any other code in this script from running
}
	
if($intItemQuantity%1 != 0) //if the item quantity is a decimal
{
	$_SESSION['txtErrorOnPage'] = "Please enter a whole number"; //set error message
	header("refresh:0; url=add_item_form.php"); //redirect to the form
	exit(); //prevent any other code in this script from running
}


else //if there are no issues with the data
{
	unset($_SESSION['txtErrorOnPage']); //remove all error messages
}


	
	

	

if (isset($_SESSION['boolEdit']) and isset($_SESSION['intEditIndex'])) //if the user has come from the list page and is editing the item rather than adding a new one
{
	$intIndex = $_SESSION['intEditIndex']; //get the index in the array of the item that is being edited from session

	loaddata( $txtListFile, $arrListItems ); //load the list items array from file
	$arrItemRecord = array($txtItemName, $intItemQuantity, $txtUsername, $txtItemCategory); //create an updated array (record) with the new data
	$arrListItems[ $intIndex ] = $arrItemRecord; //replace the old item record with the new one
	savedata( $txtListFile, $arrListItems ); //save the array of list items back into the file

	
	echo "Item edited"; //inform the user that their item has been edited
	header ("refresh:2; url=shopping_list.php"); //redirect the user to the list page after 2 seconds
}

	
else //if the user is adding a new item and there are no errors in validation of the data
{
	$arrItemRecord = array($txtItemName, $intItemQuantity, $txtUsername, $txtItemCategory); //create an array (record) for the item
	loaddata($txtListFile, $arrListItems); //load the list items array from file
	array_push($arrListItems, $arrItemRecord); //append new item to end of the list items array
	savedata($txtListFile , $arrListItems); //save the new array that has the item added

	echo "Item saved"; //inform that user that their item has been added and saved
	header ("refresh:2; url=shopping_list.php"); //redirect the user to the list page after 2 seconds
}
	
	
unset($_SESSION['txtErrorOnPage']); //remove the error messagesfrom the session  to be ready for another page to use
unset($_SESSION['txtItemName']); //remove the item name from the session to be ready for another page to use
unset($_SESSION['intItemQuantity']); //remove the item quantity from the session to be ready for another page to use
unset($_SESSION['txtItemCategory']); //remove the item category from the session to be ready for another page to use
	
unset($_SESSION['arrListItems']); //remove the list items array from the session to be ready for another page to use


?>
	
</body>
</html>
