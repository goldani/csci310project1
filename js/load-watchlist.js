/* --- [ Code for adding to watchlist] --- */
/* variables */
var watchlist = document.getElementById('watchlist-content');
var tableHeaders = ["Ticker", "Company", "Quantity", "Current Price", "Percent Change"];

/* Check database if user has stock already*/
function prepareToAddToWatchlist(menuitem_element){
	//Get the ticker
	var elementString = menuitem_element.innerHTML;
	var resultsArray = elementString.split(" ");
	var ticker = resultsArray[0];
	//Send request to database
	var request = new XMLHttpRequest();
    var url = "../php/addtowatchlist.php?ticker=" + ticker;
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
	alert(new_stock_list);
	var stockList = new_stock_list;
	if(stockList.length > 0){
		clearElementChildren(watchlist);
		var resultsArray = stockList.split("\n");

		createTableHeaders();

		var tBody = document.createElement("TBODY");
		//Put into table
		//results format: TICKER Name Qty Price %Change
		for(i = 0; i < resultsArray.length; i++){
			var stockData = resultsArray[i].split("_");
			var tableRow = document.createElement("TR");
			for(j = 0; j < stockData.length; j++){
				var tableData = document.createElement("TD");
				var value = document.createTextNode(stockData[j]);
				tableData.appendChild(value);
				tableRow.appendChild(tableData);

			}
			tBody.appendChild(tableRow)
			watchlist.appendChild(tBody);
		}
	}
	

}

/* Create headers for watchlist or stock portfolio table */
function createTableHeaders(){
	//create a new row
	var tableRow = document.createElement("TR");
	var tHead = document.createElement("THEAD");
	//create table header elements and content
	for(i = 0; i < tableHeaders.length; i++){
		var ticker = document.createElement("TH");
		var content = document.createTextNode(tableHeaders[i]);
		ticker.appendChild(content);
		var alignAttr = document.createAttribute("align");
		alignAttr.value = "left";
		ticker.setAttributeNode(alignAttr);
		tableRow.appendChild(ticker);
	}
	//add row to watchlist content
	tHead.appendChild(tableRow);
	watchlist.appendChild(tHead);
}