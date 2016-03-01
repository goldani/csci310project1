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
	var input = element.value;
	if(input === ""){
		var dropdown = document.getElementById('searchDropdown');
		clearDropdown(dropdown);
	}
	else{
		var request = new XMLHttpRequest();
    	var url = "../php/searchstocks.php?ticker=" + input;
		// var url = "getquotes.php";

    	request.open("GET", url, true);
	    request.setRequestHeader("Content-Type", "text/html");
	    request.addEventListener("readystatechange", processData, false);
	    request.send();
	}
	
}

/* Receive data */
function processData(e) {
	var currentReadyState = e.target.readyState;
	var currentStatus = e.target.status;

	if(currentReadyState == 4 && currentStatus == 200) {
	   populateDropdown(e.target.responseText);
	}
}


var searchBox = document.getElementById('search-box');
function populateDropdown(response){
	var dropdown = document.getElementById('searchDropdown');
	var resultString = response;
	var resultsArray = resultString.split("\n");
	clearDropdown(dropdown);
	for(i=0; i<resultsArray.length; i++){
		//put together the menu item
		var menuitem = document.createElement("DIV");
		var content = document.createTextNode(resultsArray[i]);
		menuitem.appendChild(content);
		menuitem.className += ' menu-item';
		//add to overall dropdown
		dropdown.appendChild(menuitem);

	}

	//one last check to make sure input values are correct
	var input = searchBox.value;
	if(input === ""){
		clearDropdown(dropdown);
	}

}

function clearDropdown(dropdown){
	while (dropdown.firstChild) {
    	dropdown.removeChild(dropdown.firstChild);
	}
}