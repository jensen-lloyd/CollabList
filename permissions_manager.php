<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Permissions Manager</title>
</head>

<body>
<h2>Permissions manager</h2>
<table width="100%" border="1">
  <tbody>
	  
	  
<?php  
	  
	  
	  	/* 
	Permissions manager
	Allows admins to control access to the list and its various features
	Author: Jensen Lloyd 
	Date: 29/07/2022
	Version: 1.0
	*/
	
	  
	  
session_start();
include "functions.php";
	  
	
	  
if($_SESSION['boolAccessGranted'] != true) //if the user is not authenticated
{
	echo("You are not permitted to view this page. <BR>Please log in"); //inform the user that they are not authenticated
	header("refresh:5; url=entry_menu.html"); //redirect the user to the entry menu after 10 seconds
	exit(); //prevent any more code on this script from running
}

	  
	  
$txtHouseholdCode = $_SESSION['txtHouseholdCode']; //get the household code from the session

$txtListFile = "Data/{$txtHouseholdCode}/Credentials.txt"; //put together the string of name of the file for Credentials
loaddata($txtListFile, $arrCredentials); //load the credentials array from the file

$txtUsername = $_SESSION['txtUsername']; //get username from the session
	 
find($txtUsername, $arrCredentials, 0, $arrFindOutputs, "E"); //search for the username in the credentials file
$intAccessLevel = $arrCredentials[($arrFindOutputs[0])][2]; //get the access level of the user
	
	
if($intAccessLevel != "0") //if the user's access level is not 0 (user is not admin)
{
	echo "<h3>You must be admin to be able to edit user permissions</h4>"; //inform the user that they are not permitted to access this page
	header("refresh:10; url=shopping_list.php"); //redirect the user to the entry menu page
	exit(); //prevent any more code from running on this script
}


$txtListFile = "Data/{$txtHouseholdCode}/Credentials.txt";
loaddata($txtListFile, $arrCredentials);

	  
if (isset($_POST['fvAccessLevel']))
{
  QuickSort(0, 0, $arrCredentials, 0);
  $txtEditedUser = $_POST['fvUser'];
  $txtNewAccessLevel = $_POST['fvAccessLevel'];
	  if ($txtNewAccessLevel == "Household manager")
		  {
			  $intAccessLevel = 0;
		  }
		  if ($txtNewAccessLevel == "Household member")
		  {
			  $intAccessLevel = 1;
		  }
		  elseif ($txtNewAccessLevel == "Banned from household")
		  {
			  $intAccessLevel = 2;
		  }

  $arrUserLocation = array();
  find($txtEditedUser, $arrCredentials, 0, $arrUserLocations, "E");
  $arrCredentials[$arrUserLocations[0]][2] = $intAccessLevel;
  savedata($txtListFile, $arrCredentials);

}



foreach($arrCredentials as $arrUserCredential)
{

  if ($arrUserCredential[2] == 0)
  {
	  $txtAccessLevel = "Household manager";
  }
  if ($arrUserCredential[2] == 1)
  {
	  $txtAccessLevel = "Household member";
  }
  elseif ($arrUserCredential[2] == 2)
  {
	  $txtAccessLevel = "Banned from household";
  }

echo '<tr>';
	echo '<td>User: ' . $arrUserCredential[0]. '<BR>Access level: ' . $txtAccessLevel;
		echo '<form id="form2" name="form2" method="post">';
		echo '<p>';
		echo '<label for="select">New access level: </label>';
		echo '<select name="fvAccessLevel" id="fvAccessLevel">';
		echo '<option value="' . $txtAccessLevel . '" selected=' . $txtAccessLevel . '>' . $txtAccessLevel . '</option>';
			 echo '<option>Household manager</option>';
			 echo '<option>Household member</option>';
			 echo '<option>Banned from household</option>';
		echo '</select>';
		echo '<input type="hidden" name="fvUser" id="fvUser" value="' . $arrUserCredential[0]. '">';
		echo '<input name="submit" type="submit" id="submit" formaction="permissions_manager.php" value="Apply">';
		echo '</p>';
		echo  '</form></td>';
echo '</tr>';
}

?>	  
	  
	  
	  
  </tbody>
</table>
	
<form id="form1" name="form1" method="post">
  <p>
    <input name="submit4" type="submit" id="submit4" formaction="shopping_list.php" value="Back to list">
  </p>
	
	<h3>Note:</h3>
	
	<p>
		• Only change 1 permission at a time<br><br>
		• Make sure to click apply after making any changes <br>before returning to the list page<br><br>
		• Make sure you always have at least one <br>household manager; you will not be able to get <br>back to this page without one
	</p>
	
</form>
<p>&nbsp;</p>
</body>
</html>
