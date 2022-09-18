<?php

/*
PHP Functions 

Author: Jensen Lloyd
Date: 11/02/2022
Version: 1.0
References "functions.php", Robert Hallworth
License: GPLv2
*/



//print out variable or array in easily readable formatted form for debugging
function mydebug( $myVar ) {
  echo "<PRE>"; //begin preformatting
  print_r( $myVar ); //print variable
  echo "</PRE>"; //end preformatting
}



function cleanup($txtData) //function named cleanup, takes a string as input
{
	$txtData = trim($txtData); //strip whitespace or carriage returns etc (all unwanted characters that could cause issues) from the string
	$txtData = strip_tags($txtData); //removes any possible HTML from the string
	$txtData = htmlspecialchars($txtData); //removes any possible HTML fromm the string
	$txtData = str_replace( "|"," ", $txtData); //removes any possible pipes (|) from the string
	$txtData = preg_replace( '/\s\s+/', ' ', $txtData );
	
	return($txtData); //returns the cleaned-up string back to the caller
}




function bubblesort (&$List) //bubblesort function, takes an array as input ("&" meaning that it works on the actual variable itself, not a copy)
{
	$intMarker = 0; //
	$intPassesWithoutSwap = 0; //
	$boolSorted = False; //
	do //complete this while until condition is triggerred
	{		
		if ($List[$intMarker] > $List[$intMarker+1])
		{
			$temp = $List[$intMarker];
			$List[$intMarker] = $List[$intMarker+1];
			$List[$intMarker+1] = $temp;
			$boolSorted = False;
//			echo "Swapped " . $List[$intMarker+1] . " and " . $List[$intMarker] . "<BR>";
			$intPassesWithoutSwap = 0;
		}
		if ($intMarker == count($List)-2)
		{
//			echo "Reached end of list.<BR>";
			$intMarker = -1;
			$boolSorted = False;
		}
		$intMarker ++;
//		echo "Passes without a swap: " . $intPassesWithoutSwap . "<BR>";
		$intPassesWithoutSwap ++;
		if ($intPassesWithoutSwap == count($List))
		{
			$boolSorted=True;
		}	
	} 
	while ($boolSorted==False);
}





function swap ( $x, $y, &$List) //swap function that takes 2 values (indexes of array) and a local copy of an array
{
    $temp=$List[$x]; //puts the first value into a temporary variable
    $List[$x]=$List[$y]; //puts the second value where the first was
    $List[$y]=$temp; //takes the first value back out of the temporary variable and puts it where the second value was
}





function QuickSort ($intListStart, $intListEnd, &$arrList, $intColumn) //quicksort function that takes am index for the start of the array, the end of the array and an array that will be sorted (& means that the original variable will be manipulated, not a copy)
{
	if ($intListStart >= $intListEnd) //if the beginning of the list is greater equal to the end
	{
		return; //exit the if statement
	}
	
	else //if the beginning of the list of less than the end
	{
		$Pivot = strtoupper($arrList[$intListStart][$intColumn]); //place the pivot at the start of the list
		$intWall = $intListStart; //place the wall at the
		$intCheck = $intListStart; //place the check at the beginning of the list
		
		do 
		{
			$intCheck++; //iterate the check by 1
			if (strtoupper($arrList[$intCheck][$intColumn]) <= $Pivot) //if the value at check (in column we are working on) is less than or equal to the pivot
			{
				$intWall++; //moves the wall along one
				swap($intCheck, $intWall, $arrList); //swaps the check and wall
			}
		} 
		while (!($intCheck >= $intListEnd)); //repeat until the check has gotten to the end of the list
		swap($intListStart, $intWall, $arrList); //swap the wall with the pivot
		
		QuickSort($intListStart, $intWall-1, $arrList, $intColumn); //sort lower half of the array
		QuickSort($intWall+1, $intListEnd, $arrList, $intColumn); //sort uperr half of the array
	}
}





//opens a delimitted file ($txtFileName) and puts it into an array ($arrName)
function loaddata( $txtFileName, & $arrName ) 
{
	if (file_exists($txtFileName)) //if the specified file does exist
	{
		$file = fopen( $txtFileName, 'r' ); //open file (create handle)
  		$txtRecord = fgets( $file, 1024 ); //reads the first line from file up to 1024 charaters
  		$intRow = 0; //sets row counter to 0
  		while ( !feof( $file ) ) //while not at the end of the file
		{
    		$txtRecord = fgets( $file, 1024 ); //reads next line up to 1024 characters
    		$txtRecord = str_replace( "\r\n","",$txtRecord); //remove carriage returns from end of each line
    		$arrName[ $intRow ] = explode( '|', $txtRecord ); //remove pipe symbol (|) and split the string at that 	point, putting it into a field in the array 
    		$intRow++; //iterate the row number by 1
    	}
  fclose( $file ); //close the file (delete handle)
	}
	else //if the specified file does NOT exist
	{
		$arrName = array(); //creates an empty array
	}
}


//opens a delimitted file ($txtFileName) and puts it into an array ($arrName)
function loaddata1d( $txtFileName, & $arrName ) 
{
	if (file_exists($txtFileName)) //if the specified file does exist
	{
		$file = fopen( $txtFileName, 'r' ); //open file (create handle)
  		$txtRecord = fgets( $file, 1024 ); //reads the first line from file up to 1024 charaters
  		$intRow = 0; //sets row counter to 0
  		while ( !feof( $file ) ) //while not at the end of the file
		{
    		$txtRecord = fgets( $file, 1024 ); //reads next line up to 1024 characters
    		$txtRecord = str_replace( "\r\n","",$txtRecord); //remove carriage returns from end of each line
    		$arrName[ $intRow ] = $txtRecord; //putting the value into a field of the array 
    		$intRow++; //iterate the row number by 1
    	}
  fclose( $file ); //close the file (delete handle)
	}
	else //if the specified file does NOT exist
	{
		$arrName = array(); //creates an empty array
	}
}


//saves an array ($arrName) into a delimitted file ($txtFileName)
function savedata( $txtFileName, $arrName ) 
{	  
	$file = fopen( $txtFileName, 'w' ); //open file (create handle)
 	foreach ( $arrName as $arrRecord ) //iterates through each row in the array 
  {
    $txtData = str_replace( "|"," ", $arrRecord); //removes any possible pipes (|) from the string
		
	$txtData = "\r\n" . implode( "|", $arrRecord ); //places a pipe (|) symbol to seperate each field of the array
    fputs( $file, $txtData ); //puts the row into the file
  }
  fclose( $file ); //closes the file when all rows have been processed and added
}


//saves an array ($arrName) into a delimitted file ($txtFileName)
function savedata1d( $txtFileName, $arrName ) 
{	  
	$file = fopen( $txtFileName, 'w' ); //open file (create handle)
 	foreach ( $arrName as $arrRecord ) //iterates through each row in the array 
  {
		
	$txtData = "\r\n" . $arrRecord; 
    fputs( $file, $txtData ); //puts the row into the file
  }
  fclose( $file ); //closes the file when all rows have been processed and added
}

function myMatch($txtA, $txtB, $chrMode) //match function, takes a 'needle' string, 'haystack' string and a mode (character) as input
{
	//Modes: C=Contains, E=Exact, I=Case Insensitive
	//$txtA is needle, $txtB is haystack
	
	$chrMode = strtoupper($chrMode); //gets the mode (C, E or I) and makes it uppercase
	$txtUcaseA = strtoupper($txtA); //gets the needle string and makes it uppercase
	$txtUcaseB = strtoupper($txtB); //gets the haystack string and makes it uppercase
	switch($chrMode)
	{	
		case 'C': //if the method is "C"
			if (strpos($txtUcaseB, $txtUcaseA) === false) //if none of the characters in txtA are in the string of txtB
			{
				return false; //go to the next case
			}
			else //if there are characters in txtA that are present in txtB
			{
				return true; //return true to the caller
			}
			break; //case statements will go through all matches (all of the cases), so we want to leave case C if it is triggerred
			
		case 'E': //if the method is 'E'
			return $txtA === $txtB; //tell the caller if txtA and txtB match exactly 
			break; //leave the set of switches
			
		case 'I': //if the method is "I"
			return $txtUcaseA === $txtUcaseB; //tell the user if txtA and txtB match, ignoring case
			break; //leave the set of switches
			
		default: //if a character other than E, I or C was entered
			return false; //return to the caller that there are no matches
			
	}
	
}



function find($txtTarget, $arrName, $intIndex, &$arrLocations, $chrMode) //find function, takes: a target, an array, an index for row, and a method/mode to find with (Exact, case insensitive or contains)
{
	$intFindLocation = -1; //set the location to before the start of the array
	$x = 0; //create a counter
	foreach ($arrName as $intPosition=>$arrRecord) // go through the array at the correct column
	{
		if (myMatch($txtTarget, $arrRecord[$intIndex], $chrMode)) //if the contents of that position in array is a match in the correct match-method
		{
			$intFindLocation = $intPosition; //set the location to the current row
			$arrLocations[$x] = $intFindLocation; //put the place that was correctly matched into the output array
			$x++; //iterate the counter
		}
	}
}



function BinarySearch($txtTarget, $arrList, $intColumn, $intIndexStart, $intIndexEnd)
{
	$intIndexMiddle = (int) ($intIndexStart + (($intIndexEnd - $intIndexStart)/2));
	$txtMiddleValue = strtoupper($arrList[$intIndexMiddle][$intColumn]);
	$txtTarget = strtoupper($txtTarget);
	
	if ($txtMiddleValue == $txtTarget)
	{
		return $intIndexMiddle;
	}
	
	if ($intIndexEnd == $intIndexStart)
	{
		return false;
	}
	
	if ($txtMiddleValue > $txtTarget)
	{
		return BinarySearch($txtTarget, $arrList, $intColumn, $intIndexStart, $intIndexMiddle-1);
	}
	
	else
	{
		return BinarySearch($txtTarget, $arrList, $intColumn, $intIndexMiddle+1, $intIndexEnd);
	}
}

?>