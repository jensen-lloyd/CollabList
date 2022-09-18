<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Collab List</title>
</head>

<body>
	
<?php
	
	
		/* 
	Main List page
	Main menu and also displays all items
	Author: Jensen Lloyd 
	Date: 29/07/2022
	Version: 1.0
	*/
	
	
	
session_start(); //start session  
include "functions.php"; //import functions for use in this script
	
	
if($_SESSION['boolAccessGranted'] != true) //if the user is not authenticated
{
	echo("You are not permitted to view this page. <BR>Please log in"); //inform the user that they are not authenticated
	header("refresh:10; url=entry_menu.html"); //redirect the user to the entry menu after 10 seconds
	exit(); //prevent any more code on this script from running
}

$txtHouseholdCode = $_SESSION['txtHouseholdCode']; //get the household code from the session

$txtListFile = "Data/{$txtHouseholdCode}/Credentials.txt"; //put together the string of name of the file for Credentials
loaddata($txtListFile, $arrCredentials); //load the credentials array from the file

$txtUsername = $_SESSION['txtUsername']; //get username from the session
	 
find($txtUsername, $arrCredentials, 0, $arrFindOutputs, "E"); //search for the username in the credentials file
$intAccessLevel = $arrCredentials[($arrFindOutputs[0])][2]; //get the access level of the user
	
	
if($intAccessLevel == "2") //if the user's access level is 2
{
	echo "<h3>You have been banned from accessing this list :( </h3><h4>Please contact the household manager to resolve the issue.</h4>"; //inform the user that they have been banned from the list by a household manager
	header("refresh:15; url=entry_menu.html"); //redirect the user to the entry menu page
	exit(); //prevent any more code from running on this script
}

echo "<h3>Shopping List " . $txtHouseholdCode . "</h3>"; //print the page title

?>
	
<form id="form1" name="form1" method="post">
  <p>
    <input name="submit2" type="submit" id="submit2" formaction="permissions_manager.php" value="Change user permissions">
    <input name="submit7" type="submit" id="submit7" formaction="entry_menu.html" value="Log out">
  </p>
  <p>
    <label for="fvSort">Sort list:</label>
    <select name="fvSort" id="fvSort">
	  <option></option>
      <option value="0">A-Z</option>
      <option value="1">Z-A</option>
      <option value="2">Quantity L-H</option>
      <option value="3">Quantity H-L</option>
    </select>
    

	  
	  
	  <label for="select2"><br>
      Show category:</label>
    
	  
	<select name="fvItemCategory" id="fvItemCategory">
    <option value=""></option>  
<?php
	
	$txtHouseholdCode = $_SESSION['txtHouseholdCode']; //get the housecold code frmo the session
	$txtListFile = "Data/{$txtHouseholdCode}/Categories.txt"; //put together the string of name of the file for categories
	  

	  if (file_exists($txtListFile) == false) //if the file credentials file does not exist
	  {
		  $arrCategories = array("Fruit", "Veg", "Bakery", "Dairy", "Meat"); //create an array with default categories
		  savedata1d($txtListFile, $arrCategories); //save the categories array to the categories file
	  }
	  
	loaddata1d($txtListFile, $arrCategories); //load the categories from the file
	foreach($arrCategories as $txtCategory) //iterate through each item in the array
	  {
		  echo '<option value="' . $txtCategory . '">' . $txtCategory . '</option>'; //print out each possible option for the category select (dropdown)
	  }
		  
?>
	</select>

	  
	  
	  
	  

    <input name="submitShow" type="submit" id="submitShow" formaction="sort_items.php" value="Sort/Show">
  </p>
  <p><input name="submit6" type="submit" id="submit6" formaction="edit_categories.php" value="Edit categories"></p>
	
  <p>
    <input name="submit3" type="submit" id="submit3" formaction="add_item_form.php" value="Add new item">
    <input name="submit" type="submit" id="submit" formaction="list_delete_confirmation.php" value="Clear list">
  </p>
</form>
<table border="1">
  <tbody>
    
<?php
	  $txtListFile = "Data/{$txtHouseholdCode}/ListItems.txt"; ////put together the string of name of the file for shopping list items
	  

	  if (file_exists($txtListFile) == false) //if the llist items file doesnt exist
	  {
		  $arrListItems  = [["Item Name", "Quantity", "Owner", "Category"]]; //create a default array
		  savedata($txtListFile, $arrListItems); //save the list items array into the file
	  }
	  
		  
	  if(!isset($_SESSION['arrListItems'])) //if list items array is not in session
	  {
	  	  loaddata($txtListFile, $arrListItems); //load the list items array from the file
	  }
	  
	  else //if list items array is in session
	  {
		  $arrListItems = $_SESSION['arrListItems']; //get list items array from session
	  }

	  foreach($arrListItems as $intIndex=>$arrItem) //iterate through the list items in the array and also get an index of the item
	  {
		echo '<tr>'; //display start of a new table row
		  echo '<td><p>' . $arrItem[0] . '</p>'; //display item name
		  echo '<h5>Quantity: ' . $arrItem[1] . '<br>Owner: ' . $arrItem[2] . '</h5></td>'; //display item quantity and owner
			echo '<td>Category: ' . $arrItem[3] . '</td>'; //display item category
		  echo '<td><form id="form2" name="form2" method="post">'; //display html for beginning of form
			echo '<input name="submit5" type="submit" id="submit5" formaction="add_item_form.php" value="Edit">'; //display html for submit button for edit item
		  echo "<BR>"; //display html for a new line
		  echo '<input name="submit6" type="submit" id="submit6" formaction="delete_item.php" formmethod="POST" value="Delete">'; //display html for a submit button for delete item
		  echo '<input type="hidden" name="fvItem" id="fvItem" value="' . $intIndex . '" >'; //display html for a hidden item with the value of the index for this item
		  echo '</form>'; //display html for end of a form
		  echo '</td>'; //display html for end of the table data
		echo '</tr>'; //display html for end of a table row
		  }
	  
?>
	  
</tbody>
</table>

	
</body>
</html>
