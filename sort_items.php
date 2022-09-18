<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Item Sort</title>
</head>

<body>
	
	
<?php
	
		/* 
	Sort items
	Manipulates array to change order or only show specific items
	Author: Jensen Lloyd 
	Date: 29/07/2022
	Version: 1.0
	*/
	
	
	
	
session_start(); //enable session
include('functions.php'); //import functions for later use

	
$txtHouseholdCode = $_SESSION['txtHouseholdCode']; //get the household code from the session

$txtListFile = "Data/{$txtHouseholdCode}/ListItems.txt"; //put together the string of name of the file for list items

loaddata($txtListFile, $arrListItems); //load the ListItems array from the file
	
unset($_SESSION['arrListItems']); //remove list items array from session
	
if(isset($_POST['fvSort'])) //if a sort was requested
{
	$txtSort = cleanup($_POST['fvSort']); //get value of which sort to complete and strip tags
	
	if($txtSort == "0") //if A-Z sort was requested
	{
		QuickSort(0, count($arrListItems)-1, $arrListItems, 0); //sort array to the liking of the user
	}
	
	if($txtSort == "1") //if Z-A sort was requested
	{
		QuickSort(0, count($arrListItems)-1, $arrListItems, 0); //sort array to the liking of the user
		$arrListItems = array_reverse($arrListItems, true);
	}
	
	if($txtSort == "2") //if low-high sort was requested
	{
		QuickSort(0, count($arrListItems)-1, $arrListItems, 1); //sort array to the liking of the user
	}
	
	if($txtSort == "3") //if high-low sort was requested
	{
		QuickSort(0, count($arrListItems)-1, $arrListItems, 1); //sort array to the liking of the user
		$arrListItems = array_reverse($arrListItems, false);
	}
	
	$_SESSION['arrListItems'] = $arrListItems; //put the new sorted array into the session
}

	

	
if(isset($_POST['fvItemCategory']) == true)
{
	$txtItemCategory = cleanup($_POST['fvItemCategory']);

	if($txtItemCategory == "")
	{
		header("refresh:0; url=shopping_list.php");
		exit();
	}
	
	find($txtItemCategory, $arrListItems, 3, $arrFindOutputs, "E"); //search for the username in the credentials file
			
	if($arrFindOutputs == "")
	{
		$arrListItems = [["", "", "", ""]];
	}
		
	else
	{	
		$arrNewListItems = [["", "", "", ""]];
		foreach($arrFindOutputs as $intIndex)
		{
			array_push($arrNewListItems, $arrListItems[$intIndex]);
		}
	 
	 	$arrListItems = $arrNewListItems;
	}
	
	$_SESSION['arrListItems'] = $arrListItems;
}

header("refresh:0; url=shopping_list.php");

?>
	
	
</body>
</html>
