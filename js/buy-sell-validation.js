/* use the following script to setup message in the popup */
function getInput(action) {
    if(checkClock()){
        document.getElementById("modal-one").style.visibility = "visible";
        document.getElementById("confMsg").innerHTML = "Do you want to "
        + action.toUpperCase() + " " +
        + document.getElementById("qty").value + " share(s) of "
        + document.getElementById("tickerInput").value.toUpperCase() + "?";
        document.getElementById('action').value = action;
    }
    else{
        document.getElementById("modal-one").style.visibility = "visible";
        document.getElementById("confMsg").innerHTML = "Sorry, stock market is closed!";
        document.getElementById("confBtn").style.visibility = "hidden";
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
  request.addEventListener("readystatechange", myFunc, false);

  request.send();
  document.getElementById("confMsg").innerHTML = "Processing";
}
function myFunc(e) {
  var currentReadyState = e.target.readyState;
  var currentStatus = e.target.status;

  if(currentReadyState == 4 && currentStatus == 200) {
    showResult(e.target.responseText);
  }
}
function showResult(result) {

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