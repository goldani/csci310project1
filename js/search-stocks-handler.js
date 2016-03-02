/* SEARCH STOCKS HANDLER
 * BY: StockOverflow Frontend Team <3
 * -----------------------------------------
 * Takes value from input (stock prefix)
 * Sends a request to the php for a list of stocks
 * Receives information
 * Populates a dropdown menu with stocks
 * Adds action for each menu item (onclick="prepareToAddToWatchlist();"), which is defined
 * below.
*/

/* called by the search bar (input element) to send a request
 * Takes in the input element, sends the ticker to searchstocks.php
 */
function requestStockNames(element){
	var input = element.value.toUpperCase();
	if(input === ""){
		var dropdown = document.getElementById('searchDropdown');
		clearElementChildren(dropdown);
		dropdown.hide();
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

/* Handle the received data */
function processData(e) {
	var currentReadyState = e.target.readyState;
	var currentStatus = e.target.status;

	if(currentReadyState == 4 && currentStatus == 200) {
	   populateDropdown(e.target.responseText);
	}
}


var searchBox = document.getElementById('search-box');

/* Put results from query into the dropdown */
function populateDropdown(response){
	var dropdown = document.getElementById('searchDropdown');
	var resultString = response;
	var resultsArray = resultString.split("\n");
	clearElementChildren(dropdown);
	for(i=0; i<resultsArray.length; i++){
		//put together the menu item
		var menuitem = document.createElement("DIV");
		var content = document.createTextNode(resultsArray[i]);
		menuitem.appendChild(content);
		menuitem.className += ' menu-item';
		//link menu items to action
		var action = document.createAttribute("onclick");
		action.value = "prepareToAddToWatchlist(this);";
		menuitem.setAttributeNode(action);
		//add to overall dropdown
		dropdown.appendChild(menuitem);

	}

	//one last check to make sure input values are correct
	var input = searchBox.value;
	if(input === ""){
		clearElementChildren(dropdown);
		dropdown.hide();
	}
	dropdown.show();

}

/* Takes in element and wipes all of its children elements */
function clearElementChildren(element){
	while (element.firstChild) {
    	element.removeChild(element.firstChild);
	}
}







