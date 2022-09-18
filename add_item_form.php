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
	Add Item form
	Gets data for adding new items to list
	Author: Jensen Lloyd 
	Date: 29/07/2022
	Version: 1.0
	*/
	
	
	
include "functions.php"; //import functions for later use in this script
session_start(); //start the session
	
if($_SESSION['boolAccessGranted'] != true) //if the user is not authenticated
{
	echo("You are not permitted to view this page. <BR>Please log in"); //inform the user that they are not authenticated
	header("refresh:10; url=entry_menu.html"); //redirect the user to the entry menu after 10 seconds
	exit(); //prevent any more code on this script from running
}

	
if(isset($_SESSION['txtErrorOnPage'])) //if there are error messages set
{
	$txtError = $_SESSION['txtErrorOnPage']; //get error message from the session
	$txtItemName = $_SESSION['txtItemName']; //get item name from the session
	$intItemQuantity = $_SESSION['intItemQuantity']; //get quantity item from the session
	$txtItemCategory = $_SESSION['txtItemCategory']; //get item category from the session
}
	
	
if(isset($_POST['fvItem'])) //if the user has come from the list (is editing an item)
{
	$intIndex = cleanup($_POST['fvItem']); //get the index of the item in the array from POST
	$txtHouseholdCode = $_SESSION['txtHouseholdCode']; //get the hosuehold code form the session

	$txtListFile = "Data/{$txtHouseholdCode}/ListItems.txt"; ///create the string that will be used to access the list items file
	loaddata($txtListFile, $arrListItems); //load the list items from the file
	
	$txtUsername = $_SESSION['txtUsername']; //get the username from the session 
	if($txtUsername != $arrListItems[$intIndex][2]) //if the username is not the same as the owner of the item
	{
		$txtListFile = "Data/{$txtHouseholdCode}/Credentials.txt"; //create the string that will be used to access the credentials file
		loaddata($txtListFile, $arrCredentials); //load credentials from file into array
		QuickSort(0, count($arrCredentials)-1, $arrCredentials, 0);	//sort the credentials array before searching
		$intCredentialsSearch = BinarySearch($txtUsername, $arrCredentials, 0, 0, count($arrCredentials)-1); //find the matches for user credentials 

		$intAccessLevel = $arrCredentials[$intCredentialsSearch][2]; //get the access level of the user
	
		if($intAccessLevel != "0") //if the user's access level is not 0 (user is not admin)
		{
			echo "<h3>You must be admin or item owner to be able to edit this item</h4>"; //inform the user that they are not permitted to edit this item
			header("refresh:10; url=shopping_list.php"); //redirect the user to the entry menu page
			exit(); //prevent any more code from running on this script
		}
	}
	
	$txtItemName = $arrListItems[$intIndex][0]; //get the item name from array of items
	$intItemQuantity = $arrListItems[$intIndex][1]; //get the item quantity from array of items
	$txtItemCategory = $arrListItems[$intIndex][3]; //get the item category from array of items
	$txtError = ""; //set the errors to be none (blank)
	
	$_SESSION['boolEdit'] = true; //indicates to the next page that the item is to be edited, not created from scratch
	$_SESSION['intEditIndex'] = $intIndex; //indicates to the next page the item that is being edited based on it's index in the array
}
	

	
elseif(!isset($_POST['fvItem']) and !isset($_SESSION['txtErrorOnPage'])) //if there are no errors and it is not editing an item
{

	unset($_SESSION['boolEdit']); //remove the edit parameter from the session
	unset($_SESSION['intEditIndex']); //remove the item index from the session
	
	$txtError = ""; //remove error (set to blank)
	$txtItemName = ""; //remove item name (set to blank)
	$intItemQuantity = ""; //remove item quantity (set to blank) 
	$txtItemCategory = ""; //remove item category (set to blank)
}
	
unset($_SESSION['txtErrorOnPage']); //remove error messages in session (set to blank)

?>
	
	
<h2>Add new list item</h2>
<form id="form1" name="form1" method="post">
  <p>
	  
    <label for="fvItemName">Item name:</label>
    <input name="fvItemName" type="text" id="fvItemName" value="<?php echo $txtItemName //display name of the item ?>">

  <p>
	  
    <label for="fvItemQuantity">Quantity:</label>
    <input name="fvItemQuantity" type="number" id="fvItemQuantity" value="<?php echo $intItemQuantity //display the quantity of the item ?>">
  </p>
	
  <p>
    
	  
	  <label for="fvItemCategory">Category:</label>  
	  <select name="fvItemCategory" id="fvItemCategory">
		  
		<option value="<?php echo($txtItemCategory) ?>" selected=<?php echo($txtItemCategory) ?>><?php echo($txtItemCategory) ?></option> <!--display item category-->
	 
		 
<?php
	$txtHouseholdCode = $_SESSION['txtHouseholdCode']; //get household code from the session
	$txtListFile = "Data/{$txtHouseholdCode}/Categories.txt"; //create the string that will be used to access the categories file
	  
	loaddata1d($txtListFile, $arrCategories); //load the categories into a 1d array
	foreach($arrCategories as $txtCategory) //iterate through the categories
	  {
		  echo '<option value="' . $txtCategory . '">' . $txtCategory . '</option>'; //display each category in the array
	  }
?>
	

</select>	
	  
  </p>
  <p><span style="color: #FF0000"><?php echo($txtError) ?></span></p></p> <!--display any error messages that are present-->
  <p>
    <input name="submit" type="submit" id="submit" formaction="add_item.php" value="Add item">
    <input name="submit2" type="submit" id="submit2" formaction="shopping_list.php" value="Back to list">
  </p>
</form>
</body>
</html>
