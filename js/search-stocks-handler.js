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
		action.value = "prepareToAddToWatchlist(this)";
		//add to overall dropdown
		dropdown.appendChild(menuitem);

	}

	//one last check to make sure input values are correct
	var input = searchBox.value;
	if(input === ""){
		clearElementChildren(dropdown);
	}

}

/* Takes in element and wipes all of its children elements */
function clearElementChildren(element){
	while (element.firstChild) {
    	element.removeChild(element.firstChild);
	}
}

/* --- [ Code for adding to watchlist] --- */
/* variables */
var watchlist = document.getElementById('watchlist-content');
var tableHeaders = ["Ticker", "Company", "Current Price", "Percent Change"];

/* Check database if user has stock already*/
function prepareToAddToWatchList(menuitem_element){
	//Get the ticker
	var elementString = menuitem_element.value;
	var resultsArray = elementString.split(" ");
	var ticker = resultsArray[0];
	//Send request to database
	var request = new XMLHttpRequest();
    var url = "../php/addToWatchlist.php?ticker=" + ticker;
    request.open("GET", url, true);
	request.setRequestHeader("Content-Type", "text/html");
	request.addEventListener("readystatechange", handleUserStockResult, false);
	request.send();

}

/* Receive result of if user already has stock */
function handleUserStockResult(e){
	var currentReadyState = e.target.readyState;
	var currentStatus = e.target.status;

	if(currentReadyState == 4 && currentStatus == 200) {
	   addToWatchlist(e.target.responseText);
	}
}

/* Append item to end of watchlist */
function addToWatchlist(new_stock_list){
	clearElementChildren(watchlist);
	var resultsArray = new_stock_list.splice("\n");
	
	createTableHeaders();

	//Put into table
	//results format: TICKER Name Qty Price %Change
	for(i = 0; i < resultsArray.length; i++){
		var stockData = resultsArray[i].splice(" ");
		var tableRow = document.createElement("TR");
		for(j = 0; j < stockData.length; j++){
			var tableData = document.createElement("TD");
			var value = document.createTextNode(stockData[j]);
			tableData.appendChild(value);
			tableRow.appendChild(tableData);

		}
		watchlist.appendChild(tableRow);
	}

}

/* Create headers for watchlist or stock portfolio table */
function createTableHeaders(){
	//create a new row
	var tableRow = document.createElement("TR");
	//create table header elements and content
	for(i = 0; i < tableHeaders.length; i++){
		var ticker = document.createElement("TH");
		var content = document.createTextNode(tableHeaders[i]);
		ticker.appendChild(content);
		tableRow.appendChild(ticker);
	}
	//add row to watchlist content
	watchlist.appendChild(tableRow);
}





