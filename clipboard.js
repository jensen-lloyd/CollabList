// JavaScript Document


//from https://www.w3schools.com/howto/howto_js_copy_clipboard.asp
function clipboard() {
  /* Get the text field */
  var copyText = document.getElementById("householdCode");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /* For mobile devices */

   /* Copy the text insilde the text field */
  navigator.clipboard.writeText(copyText.value);

  /* Inform that text was copied */
  alert("Copied the text: " + copyText.value);
	
}
