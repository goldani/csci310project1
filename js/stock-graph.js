
/* Variables */
var chart;

/* data_array format: { [TICKER: [data]], [TICKER2: [data]], ...}
 * data: [date, closingPrice], [date, closingPrice], ...
 */
function parseData(data_array){

	//Loop through associative array of stocks
	for(var ticker in data_array){

		//create data structures
		var chartData = [];
		var dataSet = new AmCharts.DataSet();
		dataSet.fieldMappings = [{fromField: "cp", toField: "closingPrice"}];
		dataSet.categoryField = "date";
		dataSet.dataProvider = chartData;
		dataSet.title = ticker;
		dataSets.push(dataSet); //add dataSet to stockchart's dataSets array

		//Loop through data for particular stock
		var stockData = data_array[i];
		for(j=0; j<stockData.length; j++){

			//get pairs of data: [date, closingPrice]
			var pairArray = stockData[j];
			var date = pairArray[0];
			var closingPrice = pairArray[1];
			var dataObject = {
				date: date,
				cp: closingPrice
			};
			//add object to chartData array
			chartData.push(dataObject);
		}


	}
	chart.validateData();

	// for(i=data_array.length-1; i > 0; i--){
	// 	//get date, closing_price pair
	// 	var pairArray = data_array[i];
	// 	var date = pairArray[0];
	// 	var closingPrice = pairArray[1];
	// 	var dataObject = {
 //            date: date,
 //            cp: closingPrice
 //        };
 //        // add object to chartData array
 //        chartData.push(dataObject);
	// }
	// chart.validateData();
}

var chartData = [
	{date: "2011-02-01", cp: 40},
	{date: "2011-02-02", cp: 50}];
var dataSet = new AmCharts.DataSet();
dataSet.fieldMappings = [{fromField: "cp", toField: "closingPrice"}];
		dataSet.categoryField = "date";
		dataSet.dataProvider = chartData;
var dataSets = [dataSet]; //Array of dataset objects
var lineColors = ["#392759", "#8D0D30", "#4472CA", "#FFD972"]; //List of colors

/* Prepare the chart and write to the HTML */
AmCharts.ready(function(){

	chart = new AmCharts.AmStockChart();
	chart.pathToImages = "amstockchart/amcharts/images/";

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