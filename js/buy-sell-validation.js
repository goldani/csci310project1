/* use the following script to setup message in the popup */
function checkClock(){
	var estDate = new Date(new Date().getTime()+offset);
	var hours = estDate.getHours()
	var minutes = estDate.getMinutes();
	var amPM = hours >= 12 ? 'PM' : 'AM';
	if(hours >= 12){
		hours-=12;
	}
	if(hours == 0){
		hours = 12;
    }
    if((hours >= 9 && minutes >= 30 && amPM == 'AM') || (hours <= 4 && amPM == 'PM') || (hours == 12 && amPM == 'PM')){
        return true;
    }
    else{
        return false;
    }
}
function getInput(action) {
    if(checkClock()){
		document.getElementById("modalHeader").innerHTML = "Confirm?";
		document.getElementById("modal-one").style.visibility = "visible";
        document.getElementById("confMsg").innerHTML = "Do you want to "
        + action.toUpperCase() + " " +
        + document.getElementById("qty").value + " share(s) of "
        + document.getElementById("tickerInput").value.toUpperCase() + "?";
        document.getElementById('action').value = action;
		// document.getElementById("confBtn").style.visibility = "hidden";
		// document.getElementById("cancelBtn").style.visibility = "hidden";
		// document.getElementById("clsBtn").style.visibility = "visible";
    }
    else{
        document.getElementById("modal-one").style.visibility = "visible";
        document.getElementById("confMsg").innerHTML = "Sorry, stock market is closed!";
		document.getElementById("modalHeader").innerHTML = "Market clsoed";
        document.getElementById("confBtn").style.visibility = "hidden";
		document.getElementById("cancelBtn").style.visibility = "hidden";
		document.getElementById("clsBtn").style.visibility = "visible";
    }

}

//called after close button is pressed. change visibility
// of buttons back to default and try to reload watchlist
function refresh() {
  document.getElementById("clsBtn").style.visibility = "hidden";
  document.getElementById("confBtn").style.visibility = "visible";
  document.getElementById("cancelBtn").style.visibility = "visible";
  document.getElementById("modal-one").style.visibility = "hidden";
  location.reload();
  //disabled for now
  // loadWatchlist();
  // prepareToAddToWatchlist(document.getElementById("tickerInput"));
  // reloadAddToWatchlist();
}

//called after confirm button is pressed calls php to
// do the actual transaction then display the result
function buyOrSell() {
  var request = new XMLHttpRequest();
  var url = "../php/buyAndSell.php?"
  + "action=" + document.getElementById('action').value
  + "&ticker=" + document.getElementById("tickerInput").value
  + "&quantity=" + document.getElementById("qty").value;

  request.open("GET", url, true);
  request.setRequestHeader("Content-Type", "text/html");
  request.addEventListener("readystatechange", processTrans, false);

  request.send();
  document.getElementById("confMsg").innerHTML = "Processing";
}
function processTrans(e) {
  var currentReadyState = e.target.readyState;
  var currentStatus = e.target.status;

  if(currentReadyState == 4 && currentStatus == 200) {
    showTransResult(e.target.responseText);
  }
}
function showTransResult(result) {

  if (result.substr(0, 5) == "Stock") {
    document.getElementById("modalHeader").innerHTML = "Transaction succeeded";
  } else {
    document.getElementById("modalHeader").innerHTML = "Transaction failed";
  }
  document.getElementById("confMsg").innerHTML = result;

  //hide confirm and cancel button, dispaly close button
  document.getElementById("clsBtn").style.visibility = "visible";
  document.getElementById("confBtn").style.visibility = "hidden";
  document.getElementById("cancelBtn").style.visibility = "hidden";
}
