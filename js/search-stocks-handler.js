/* SEARCH STOCKS HANDLER
 * Takes value from input (stock prefix)
 * Sends a request to the php for a list of stocks
 * Receives information
 * Populates a dropdown menu with stocks
*/

/* called by the search bar (input element) to send a request
 * Takes in the input element, sends the ticker to searchstocks.php
 */
function requestStockNames(element){
	var request = new XMLHttpRequest();
	var input = element.value;
    var url = "../php/searchstocks.php?ticker=" + input;
		// var url = "getquotes.php";

    request.open("GET", url, true);
    request.setRequestHeader("Content-Type", "text/html");
    request.addEventListener("readystatechange", processData, false);
    request.send();
}

/* Receive data */
function processData(e) {
	var currentReadyState = e.target.readyState;
	var currentStatus = e.target.status;

	if(currentReadyState == 4 && currentStatus == 200) {
	   populateDropdown(e.target.responseText);
	}
}


function populateDropdown(response){
	alert(response);

}