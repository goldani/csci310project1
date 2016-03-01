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
if($currentUser && isset($_SESSION['timestamp']) && time() - $_SESSION['timestamp'] >= 300) {
  include('logout.php');
  die();
} else {
  $_SESSION['timestamp'] = time();
}
if (!$currentUser) {
  header('Location: /');
}
/*
// HOW TO ADD STOCKS TO USER ACCOUNTS
$stocks['MSFT'] = 10;
$stocks['GOOG'] = 24;
$stocks['AAPL'] = 19;
$stocks['AMZN'] = 95;
$currentUser->setAssociativeArray('stocks', $stocks);
$currentUser->save();
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Portfolio | StockOverflow</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="../css/confirmPopup.css">
</head>
<body>

  <div class="overall-wrapper">
    <div class="header">
      <a href="/mainpage.php"><img src="img/so-logo.png" id="logo"></a>
      <div id="user-section">
        <div id="clock" class="inline">
        </div>
        <?php
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
            <canvas id="canvas"></canvas>


            <div class="button-wrapper">
              <button id="1d" class="button graph-button" onclick="updateTimeRange('1d')">1 day</button>
              <button id="5d" class="button graph-button">5 days</button>
              <button id="1d" class="button graph-button">1 month</button>
              <button id="3m" class="button graph-button">3 months</button>
              <button id="6m" class="button graph-button">6 months</button>
              <button id="1y" class="button graph-button">1 year</button>
              <button id="all" class="button graph-button">All</button>
            </div>
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
            <table id="portfolio-content">
              <thead>
                <tr>
                  <th align="left">Ticker</th>
                  <th align="left">Company</th>
                  <th align="left">Quantity</th>
                  <th align="left">Current Price</th>
                  <th align="left">Percent Change</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // function loadPortfolio() {
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
                    if (count($data) == 5) {
                      echo '<tr>
                      <td>' . substr($data[0], 1, -1) . '</td>
                      <td>' . substr($data[1] . $data[2], 1, -1) . '</td>
                      <td>' . $quantity . '</td>
                      <td>$' . $data[3] . '</td>
                      <td>' . substr($data[4], 1, -2) . '</td>
                      </tr>';
                    } else {
                      echo '<tr>
                      <td>' . substr($data[0], 1, -1) . '</td>
                      <td>' . substr($data[1], 1, -1) . '</td>
                      <td>' . $quantity . '</td>
                      <td>$' . $data[2] . '</td>
                      <td>' . substr($data[3], 1, -2) . '</td>
                      </tr>';
                    }
                  }
                }

              // }
              // loadPortfolio();
                ?>
              </tbody>
            </table>
          </div>
          <div id="watchlist-section" class="widget-box">
            <table id="watchlist-content">
              <thead>
                <tr>
                  <th align="left">Ticker</th>
                  <th align="left">Company</th>
                  <th align="left">Quantity</th>
                  <th align="left">Current Price</th>
                  <th align="left">Percent Change</th>
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
                    if (count($data) == 5) {
                      echo '<tr>
                      <td>' . substr($data[0], 1, -1) . '</td>
                      <td>' . substr($data[1] . $data[2], 1, -1) . '</td>
                      <td>' . $quantity . '</td>
                      <td>$' . $data[3] . '</td>
                      <td>' . substr($data[4], 1, -2) . '</td>
                      </tr>';
                    } else {
                      echo '<tr>
                      <td>' . substr($data[0], 1, -1) . '</td>
                      <td>' . substr($data[1], 1, -1) . '</td>
                      <td>' . $quantity . '</td>
                      <td>$' . $data[2] . '</td>
                      <td>' . substr($data[3], 1, -2) . '</td>
                      </tr>';
                    }
                  }
                }
                ?>
              </tbody>
            </table>
          </div>

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
                  document.getElementById("confMsg").innerHTML = "Do you want to "
                  + action.toUpperCase() + " " +
                  + document.getElementById("qty").value + " share(s) of "
                  + document.getElementById("tickerInput").value.toUpperCase() + "?";
                  document.getElementById('action').value = action;

                }
                </script>

              </div>

              <div class="modal" id="modal-one" aria-hidden="true">
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
      <br>
      <p><small>For more information, <a href="mailto:halfond@usc.edu" class="contact" target="_top">email</a> or <a href="tel:12137401239" class="contact">call</a> <a href="http://www-bcf.usc.edu/~halfond/" class="contact" target="_blank">Professor Halfond</a>.</small></p>
    </footer>
  </div>
	<!-- Load javascript here -->
	<script src="js/Chart.js/Chart.min.js"></script>
	<script src="js/stock-graph.js"></script>
    <script src="js/search-stocks-handler.js"></script>
    <script src="js/load-watchlist.js"></script>
    <script>
		var clockID;
		var yourTimeZoneFrom = -5.00;
		var d = new Date();
		var tzDifference = yourTimeZoneFrom * 60 + d.getTimezoneOffset();
		var offset = tzDifference * 60 * 1000;
		function UpdateClock() {
			var estDate = new Date(new Date().getTime()+offset);
			var hours = estDate.getHours()
			var minutes = estDate.getMinutes();
			var seconds = estDate.getSeconds();
			if(minutes < 10)
				minutes = '0' + minutes;
			if(seconds < 10)
				seconds = '0' + seconds;
			var amPM = hours >= 12 ? 'PM' : 'AM';
			document.getElementById('clock').innerHTML = ""
						   + hours + ":"
						   + minutes + ":"
						   + seconds + " "
						   + amPM + " EST";
		}
		function StartClock() {
			clockID = setInterval(UpdateClock, 500);
		}
		function KillClock() {
			clearTimeout(clockID);
		}
		window.onload=function() {
			StartClock();
        }
/*
		$(document).ready(function () {
			var HeightDiv = $("div").height();
			var HeightTable = $("portfolio-section").height();
			if(HeightTable > HeightDiv) {
				var FontSizeTable = parseInt($("table").css("font-size"), 10);
				while (HeightTable > HeightDiv && FontSizeTable > 5) {
					FontSizeTable--;
					$("table").css("font-size", FontSizeTable);
					HeightTable = $("table").height();
				}
			}
		});

*/
</script>
</body>
</html>
