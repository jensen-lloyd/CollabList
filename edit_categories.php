<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit categories</title>
</head>

<body>
<h2>Edit item categories
</h2>
<form id="form1" name="form1" method="post">
  <input name="submit" type="submit" id="submit" formaction="add_category.php" value="Add category">
</form>
<table width="100%" border="1">
<tbody>
	
	
	
<?php

	
	/* 
	Edit Categories
	Main page for managing item categories
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

	

loaddata1d($txtListFile, $arrCategories); //get the categories array from it's file
	
if (file_exists($txtListFile) == false) //if the categories file does not exist
{
	$arrCategories = array("Fruit", "Veg", "Bakery", "Dairy", "Meat"); //create an array of default categories
	savedata1d($txtListFile, $arrCategories); //save the new array into the categories file
}
	
	
	

	
if (isset($_POST['fvName'])) //if a new category has been added in the previous form page
{
	$txtNewCategory = cleanup($_POST['fvName']); //get the name of the new category from the POST after stripping tags
	loaddata1d($txtListFile, $arrCategories); //load the array of categories
	$arrCategories[] = $txtNewCategory; //add the new category to the array of categories
	savedata1d($txtListFile, $arrCategories); //save the new array to file
}


	
foreach($arrCategories as $intIndex=>$txtCategory) //iterate through each category
  {
	  echo '<tr>'; //display the html for the start of a new table row
      echo '<td width="67%">' . $txtCategory . '</td>'; //display the html for table data, including the name of the current category
      echo '<td width="33%"><form id="form2" name="form2" method="post">'; //display the html for the start of a form
      echo '<input name="" type="submit" id="submit3" formaction="delete_category.php" value="Delete">'; //display the html for a button that goes to the delete category page
      echo '<input type="hidden" name="fvCategory" id="fvUser" value="' . $intIndex . '" >'; //display html for a hidden attribute that includes the index in the array of the current category
      echo '</form></td>'; //displays the html for the end of a form and table data
      echo '</tr>'; //displays the html for the end of a table row
  }
?>
	  
	  
  </tbody>
</table>
<p></p>
<form id="form5" name="form5" method="post">
  <input name="submit8" type="submit" id="submit8" formaction="shopping_list.php" value="Back to list">
</form>
<p>&nbsp;</p>
</body>
</html>
