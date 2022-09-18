<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Join Household</title>
</head>

<body>
	
<?php
	
	
		/* 
	Join Household form
	Gets data for joining a household
	Author: Jensen Lloyd 
	Date: 29/07/2022
	Version: 1.0
	*/
	
	
	
	
session_start(); //enable session
	
if(isset($_SESSION['txtErrorOnPage'])) //if the variable containing the error messages has been set
{
	$txtError = $_SESSION['txtErrorOnPage']; //get the error message frmo the session
	$txtHouseholdCode = $_SESSION['txtHouseholdCode']; //get the household code from the session
}
	
else //if this is the first time coming to the page (no previous errors)
{
	$txtError = ""; //set the error message to be blank
	$txtHouseholdCode = ""; //set the houosehold code to be blank
}
	
unset($_SESSION['txtErrorOnPage']); //remove all error messages from session now they have been taken out
	
?>
	
	
<h2>Join Household</h2>
<form id="form1" name="form1" method="post">
  <p>
    <label for="fvHouseholdCode">Household code:</label>
    <input name="fvHouseholdCode" type="text" id="fvHouseholdCode" value="<?php echo($txtHouseholdCode); ?>"> <!--displays the previously entered household code-->
	<p><span style="color: #FF0000"><?php echo($txtError); ?></span></p> <!--displays any error messages-->
	<p>
    <input name="submit" type="submit" id="submit" formaction="join_household.php" value="Join">
    <input name="submit2" type="submit" id="submit2" formaction="create_household.php" value="Go to Create household">
  </p>
</form>
</body>
</html>
