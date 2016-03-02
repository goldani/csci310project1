
/* Variables */
var chart;
var dataSets = []; //Array of dataset objects
var lineColors = ["#392759", "#8D0D30", "#4472CA", "#FFD972"]; //List of colors
var stockColors = [];
var colorIndex = 0;

// Request to update info box
function updateInfoBox(tickerSymbol) {
    // alert(tickerSymbol);
  var request = new XMLHttpRequest();
  var url = "../php/getquotes.php?ticker=" + tickerSymbol;

  request.open("GET", url, true);
  request.setRequestHeader("Content-Type", "text/html");
  request.addEventListener("readystatechange", myFunc, false);

  request.send();
}
function myFunc(e) {
  var currentReadyState = e.target.readyState;
  var currentStatus = e.target.status;

  if(currentReadyState == 4 && currentStatus == 200) {
    populateInfoBox(e.target.responseText);
  }
}

function populateInfoBox(result) {
	alert(result);
	var resultsArray = result.split("_");

}

//Hiding and showing loading box for graph
function showOverlay(){
    document.getElementById("clsBtn").style.visibility = 'hidden';
    document.getElementById("confBtn").style.visibility = 'hidden';
    document.getElementById("cancelBtn").style.visibility = "hidden";
    document.getElementById("modalHeader").innerHTML = "Please Wait";
    document.getElementById("confMsg").innerHTML = "Graph loading";
    document.getElementById("modal-one").style.display = "visible";
}
function hideOverlay(){
    document.getElementById("modal-one").style.visibility = "hidden";
}

/* data_array format: { [TICKER: [data]], [TICKER2: [data]], ...}
 * data: [date, closingPrice], [date, closingPrice], ...
 */
function parseData(ticker, data_array){

	//remove from dataSets if data_array is empty
	if(data_array.length == 0){
		for(i=0; i<chart.dataSets.length; i++){
			if(dataSets[i].title == ticker){
				chart.dataSets.splice(i, 1); //remove dataset
				//delete stockColors[title];
			}
		}
	}
	else{
		//if data_array is populated, put into the graph

		//create data structures
		var chartData = [];
		var dataSet = new AmCharts.DataSet();
		dataSet.fieldMappings = [{fromField: "cp", toField: "closingPrice"}];
		dataSet.categoryField = "date";
		dataSet.title = ticker;
		dataSet.color = lineColors[colorIndex];
		//stockColors[key] = lineColors[colorIndex];
		colorIndex++;
		colorIndex = colorIndex%lineColors.length;



		//loop through stock data
		for(i=data_array.length-1; i>0; i--){
			//get pairs of data: [date, closingPrice]
			var pairArray = data_array[i];
			var date = pairArray[0];
			var closingPrice = pairArray[1];
			var dataObject = {
				date: date,
				cp: closingPrice
			};
			//add object to chartData array
			chartData.push(dataObject);
		}
		dataSet.dataProvider = chartData;
		chart.dataSets.push(dataSet); //add dataSet to stockchart's dataSets array
	}

	chart.validateData();
	chart.validateNow();
	//chart.validateNow(validateData, skipEvents);
}


/* Prepare the chart and write to the HTML */
AmCharts.ready(function(){

	chart = new AmCharts.AmStockChart();
	//chart.pathToImages = "amcharts/images/";

	//link to dataSets array
	chart.dataSets = dataSets;
	chart.dataDateFormat = "YYYY-MM-DD";

	//create stock panel
	var stockPanel = new AmCharts.StockPanel();
	chart.panels = [stockPanel];

	//adjust panel settings
	var panelsSettings = new AmCharts.PanelsSettings();
	panelsSettings.startDuration = 1;
	chart.panelsSettings = panelsSettings;

	//create graph
	var graph = new AmCharts.StockGraph();
	graph.valueField = "closingPrice";
	graph.type = "line";
	//graph.fillAlphas = 1;
	graph.title = "Stock Trends Graph";
	stockPanel.addStockGraph(graph);

    //set minimum period of time (to hours)
	//category axes settings
	var categoryAxesSettings = new AmCharts.CategoryAxesSettings();
	categoryAxesSettings.minPeriod = "DD";
	categoryAxesSettings.dashLength = 5;
	chart.categoryAxesSettings = categoryAxesSettings;
	//set spacing
	categoryAxesSettings.equalSpacing = true;


	//value axes settings
	var valueAxesSettings = new AmCharts.ValueAxesSettings();
	valueAxesSettings.dashLength = 5;
	chart.valueAxesSettings  = valueAxesSettings;

	//scrollbar settings
	var chartScrollbarSettings = new AmCharts.ChartScrollbarSettings();
	chartScrollbarSettings.graph = graph;
	chartScrollbarSettings.graphType = "line";
	chart.chartScrollbarSettings = chartScrollbarSettings;

	//legend
	var legend = new AmCharts.StockLegend();
	stockPanel.stockLegend = legend;

	//Color settings
	chart.colors = lineColors;

	//tooltip/balloon
	var chartCursorSettings = new AmCharts.ChartCursorSettings();
	chartCursorSettings.valueBalloonsEnabled = true;
	chart.chartCursorSettings = chartCursorSettings;

	//period selector
	var periodSelector = new AmCharts.PeriodSelector();
	periodSelector.inputFieldsEnabled = false;
	periodSelector.periods = [
		{period:"DD", count:1, label:"1 day"},
		{period:"DD", count:5, label:"5 days"},
		{period:"MM", count:1, label:"1 month"},
		{period: "MM", selected:true, count:6, label:"6 months" },
		{period:"YYYY", count:1, label:"1 year"},
		{period:"MAX", label:"MAX"}
	];
	periodSelector.hideOutOfScopePeriods = false;
	chart.periodSelector = periodSelector;


	//write to div
	chart.write("chartdiv");

});
