<?php
include 'vendor/autoload.php';
use Parse\ParseClient;
use Parse\ParseUser;
use Parse\ParseException;
use Parse\ParseQuery;
date_default_timezone_set('America/New_York');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    ParseClient::initialize('W78hSNsME23VkGSZOD0JXn2XoM5Nf6GO41BgMqxE', 'H3EgW9gCr6wyP8MfL3Eobz1mWJMwydyp6N2prcVF', 'mRppu4ciMuqhNsTXHoeh329Za4ShOOc1F1NN0skD');
}
$currentUser = ParseUser::getCurrentUser();
// timeout functionality set to 5 minutes (300 seconds)
if($currentUser && isset($_SESSION['timestamp']) && time() - $_SESSION['timestamp'] >= 300) {
    include('logout.php');
    die();
} else {
    $_SESSION['timestamp'] = time();
}
// redirect to login page if not logged in
if (!$currentUser) {
    header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Portfolio | StockOverflow</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="../css/confirmPopup.css">
  <link rel="stylesheet" href="js/amstockchart/amcharts/style.css" type="text/css">
</head>
<body>

  <div class="overall-wrapper">
    <div class="header">
      <a href="/mainpage.php"><img src="img/so-logo.png" id="logo"></a>
      <div id="user-section">
        <div id="clock" class="inline">
        </div>
        <?php
        // display user info in header
        $currentUser = ParseUser::getCurrentUser();
        echo "<div class='inline'>";
        echo '<p id="username">' . $currentUser->get('username') . '</p>';
        echo "</div>";
        echo "<div class='inline'>";
        echo '<p id="balance">$' . $currentUser->get('balance') . '</p>';
        echo "</div>";
        ?>
        <div class="inline">
          <a href="" id="manual">User Manual</a>
        </div>
        <div class="inline" id="inline-logout">
          <a href="logout.php" id="logout">Logout</a>
        </div>
      </div>
    </div>


    <div class="content clearfix">
      <div class="float-wrapper">
        <div id="center-area">
          <div id="search-section" class="widget-box">
            <input id="search-box" type="text" placeholder="Search stocks..." pattern="[A-Za-z]{1,5}" oninput="requestStockNames(this);">
            <div class="dropdown">
              <div id="searchDropdown" class="dropdown-content">
              </div>
            </div>
          </div>

          <div id="graph-section" class="widget-box">
            <div id="chartdiv" style="width:100%; height:400px;"></div>
          </div>

          <div id="information-section" class="widget-box">
            <p>Stock Information
            </p>
          </div>

        </div>

        <div id="left-area">
          <div id="CSV-section" class="widget-box">
            <form action="upload.php" method="post" enctype="multipart/form-data">
              <input type="file" name="fileToUpload" id="fileToUpload" class="button-fileUpload">
              <label for="fileToUpload">
                <span>Upload CSV File</span>
              </label>
              <br>
              <br>
              <input type="submit" name="submit"  alt="Import CSV" value="Import CSV File" class="button">
            </form>
          </div>
          <div id="portfolio-section" class="widget-box">
            <h3>Portfolio</h3>
            <table id="portfolio-content">
              <thead>
                <tr>
                  <th>Ticker</th>
                  <th>Company</th>
                  <th>Quantity</th>
                  <th>Current Price</th>
                  <th>Percent Change</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // loading currentUser's portfolio
                // and populating table with stocks
                $stocks = $currentUser->get('stocks');
                $stocksOwned = NULL;
                $stocksWatching = NULL;
                foreach ($stocks as $ticker => $quantity) {
                  if ($quantity > 0) {
                    $stocksOwned[$ticker] = $quantity;
                  } else {
                    $stocksWatching[$ticker] = $quantity;
                  }
                }
                if (empty($stocksOwned)) {
                  echo '<tr>
                  <td>N/A</td>
                  <td>N/A</td>
                  <td>N/A</td>
                  <td>N/A</td>
                  <td>N/A</td>
                  </tr>';
                } else {
                  foreach ($stocksOwned as $ticker => $quantity) {
                    $quote = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=" . $ticker . "&f=SNAP2&e=.csv");
                    $data = explode(',', $quote);
                    $tickerSymbol = substr($data[0], 1, -1);
                    if (count($data) == 5) { // if company name has a comma need to parse differently
                        echo "<tr onclick='updateGraph(\"$tickerSymbol\")'>" .
                        '<td>' . substr($data[0], 1, -1) . '</td>
                        <td>' . substr($data[1] . $data[2], 1, -1) . '</td>
                        <td>' . $quantity . '</td>
                        <td>$' . $data[3] . '</td>';
                        if (strcmp($data[4][1], '+') == 0) {
                          echo '<td><font color="#32CD32">' . substr($data[4], 1, -2) . '</font></td>
                                </tr>';
                        } else {
                          echo '<td><font color="#DC143C">' . substr($data[4], 1, -2) . '</font></td>
                                </tr>';
                        }
                    } else {
                        echo "<tr onclick='updateGraph(\"$tickerSymbol\")'>" .
                        '<td>' . substr($data[0], 1, -1) . '</td>
                        <td>' . substr($data[1], 1, -1) . '</td>
                        <td>' . $quantity . '</td>
                        <td>$' . $data[2] . '</td>';
                        if (strcmp($data[3][1], '+') == 0) {
                          echo '<td><font color="#32CD32">' . substr($data[3], 1, -2) . '</font></td>
                                </tr>';
                        } else {
                          echo '<td><font color="#DC143C">' . substr($data[3], 1, -2) . '</font></td>
                                </tr>';
                        }
                    }
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
          <div id="watchlist-section" class="widget-box">
            <h3>Watchlist</h3>
            <table id="watchlist-content">
              <thead>
                <tr>
                  <th>Ticker</th>
                  <th>Company</th>
                  <th>Quantity</th>
                  <th>Current Price</th>
                  <th>Percent Change</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (empty($stocksWatching)) {
                  echo '<tr>
                  <td>N/A</td>
                  <td>N/A</td>
                  <td>N/A</td>
                  <td>N/A</td>
                  <td>N/A</td>
                  </tr>';
                } else {
                  foreach ($stocksWatching as $ticker => $quantity) {
                    $quote = file_get_contents('http://finance.yahoo.com/d/quotes.csv?s=' . $ticker . '&f=SNAP2&e=.csv');
                    $data = explode(',', $quote);
                    $tickerSymbol = substr($data[0], 1, -1);
                    if (count($data) == 5) {
                      echo "<tr onclick='updateGraph(\"$tickerSymbol\")'>" .
                      '<td>' . substr($data[0], 1, -1) . '</td>
                      <td>' . substr($data[1] . $data[2], 1, -1) . '</td>
                      <td>' . $quantity . '</td>
                      <td>$' . $data[3] . '</td>';
                      if (strcmp($data[4][1], '+') == 0) {
                          echo '<td><font color="#32CD32">' . substr($data[4], 1, -2) . '</font></td>
                                </tr>';
                        } else {
                          echo '<td><font color="#DC143C">' . substr($data[4], 1, -2) . '</font></td>
                                </tr>';
                        }
                    } else {
                      echo "<tr onclick='updateGraph(\"$tickerSymbol\")'>" .
                      '<td>' . substr($data[0], 1, -1) . '</td>
                      <td>' . substr($data[1], 1, -1) . '</td>
                      <td>' . $quantity . '</td>
                      <td>$' . $data[2] . '</td>';
                      if (strcmp($data[3][1], '+') == 0) {
                          echo '<td><font color="#32CD32">' . substr($data[3], 1, -2) . '</font></td>
                                </tr>';
                        } else {
                          echo '<td><font color="#DC143C">' . substr($data[3], 1, -2) . '</font></td>
                                </tr>';
                        }
                    }
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
            <!--
            <div class="button-wrapper">
                <a href="#overlay-modal" id="overlay-modal" class="btn btn-big" display="none">Graph loading...</a>
            </div>
            -->
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
            <script>
                /*
                function show_overlay(){
                    document.getElementById("overlay-modal").display = "inline";
                }
                function hide_overlay(){
                    document.getElementById("overlay-modal").display = "none";
                }
                */
                var tickerSymbols = [];
                function updateGraph(tickerSymbol){
                    var idx = tickerSymbols.indexOf(tickerSymbol);
                    // if stock exists in graph
                    if(idx > -1){
                        tickerSymbols.splice(idx, 1);
                        parseData(tickerSymbol, []);
                    }
                    // else stock does not exist in graph
                    else{
                        //show_overlay();
                        $.ajax({
                            url:"updateGraph.php?tickerSymbol=" + tickerSymbol,
                            type:"POST",
                            async:true,
                            dataType:'json',
                        }).done(function(historicalData){
                            parseData(tickerSymbol, historicalData);
                            tickerSymbols.push(tickerSymbol);
                            //hide_overlay();
                        });
                    }
                }
            </script>

          <div id="buy-sell-section" class="widget-box">
            <form method="post">
              <input id="tickerInput" name="ticker" class="buySell-field" type="text" placeholder="Stock Ticker" maxlength="5" required autofocus><br>
              <input id="qty" name="quantity" class="buySell-field" type="number" min="1" placeholder="Quantity" required><br>
              <div class="button-wrapper">
                <a href="#modal-one" class="btn btn-big" onclick="getInput('buy')">Buy</a>
                <a href="#modal-one" class="btn btn-big" onclick="getInput('sell')">Sell</a>
                <input type="hidden" id="action" value="">
                <!-- use the following script to setup message in the popup -->
                <script>
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

                    }
                }
                </script>

              </div>

              <div class="modal" id="modal-one" aria-hidden="true" style="visibility: hidden">
                <div class="modal-dialog">
                  <div class="modal-header">
                    <h2 id="modalHeader">Confirm?</h2>
                    <!-- removed X button so that user can only click buttons below to proceed -->
                  </div>
                  <div class="modal-body" id="confMsg">
                    <p id="status"></p>
                  </div>
                  <div class="modal-footer">
                    <!-- three buttons with the last one hidden and only shown when transaction is finished -->
                    <a id="confBtn" href="#modal-one" onclick="buyOrSell()" class="btn" type="">Confirm</a>
                    <a id="cancelBtn" href="#close" class="btn" type="">Cancel</a>
                    <a id="clsBtn" href="#close" onclick="refresh()" class="btn" style="visibility: hidden">Close</a>
                    <script>
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
                    // do the actrual transaction then display the result
                    function buyOrSell() {
                      var request = new XMLHttpRequest();
                      var url = "php/buyAndSell.php?"
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
                    </script>

                  </div>
                </div>
              </div>

            </form>
          </div>


        </div>
      </div> <!--left float wrapper end -->

    </div>

    <footer>
      <p><small>This is the work of college students.</small></p>
      <p><small>For more information, <a href="mailto:halfond@usc.edu" class="contact" target="_top">email</a> or <a href="tel:12137401239" class="contact">call</a> <a href="http://www-bcf.usc.edu/~halfond/" class="contact" target="_blank">Professor William G.J. Halfond</a>.</small></p>
    </footer>
  </div>
	<!-- Load javascript here -->
    <script src="js/search-stocks-handler.js"></script>
    <script src="js/load-watchlist.js"></script>
    <script src="js/amstockchart/amcharts/amcharts.js" type="text/javascript"></script>
	<script src="js/amstockchart/amcharts/serial.js" type="text/javascript"></script>
	<script src="js/amstockchart/amcharts/amstock.js" type="text/javascript"></script>
	<script src="js/stock-graph.js"></script>
    <script>
		var clockID;
		var yourTimeZoneFrom = -5.00;
		var d = new Date();
		var tzDifference = yourTimeZoneFrom * 60 + d.getTimezoneOffset();
		var offset = tzDifference * 60 * 1000;
		function updateClock() {
			var estDate = new Date(new Date().getTime()+offset);
			var hours = estDate.getHours()
			var minutes = estDate.getMinutes();
			var seconds = estDate.getSeconds();
			var amPM = hours >= 12 ? 'PM' : 'AM';
			if(hours >= 12){
				hours-=12;
			}
			if(hours == 0){
				hours = 12;
			}
			if(minutes < 10)
				minutes = '0' + minutes;
			if(seconds < 10)
				seconds = '0' + seconds;
			document.getElementById('clock').innerHTML = ""
						   + hours + ":"
						   + minutes + ":"
						   + seconds + " "
						   + amPM + " EST";
		}
		function startClock() {
			clockID = setInterval(updateClock, 500);
        }
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
            if((hours >= 9 && minutes >= 30 && amPM == 'AM') || (hours <= 4 && amPM == 'PM')){
                return true;
            }
            else{
                return false;
            }
        }
		window.onload=function() {
			startClock();
			window.scrollTo(0,0);
        }
</script>
</body>
</html>
