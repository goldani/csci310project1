




/* Initial chart data (dummy) */
var chartData = [
	{date: new Date(2011, 5, 1, 10, 0, 0, 0), val:10},
    {date: new Date(2011, 5, 1, 11, 0, 0, 0), val:11},
    {date: new Date(2011, 5, 1, 12, 0, 0, 0), val:12},
    {date: new Date(2011, 5, 1, 13, 0, 0, 0), val:11},
    {date: new Date(2011, 5, 1, 14, 0, 0, 0), val:10},
    {date: new Date(2011, 5, 1, 15, 0, 0, 0), val:11},
    {date: new Date(2011, 5, 1, 16, 0, 0, 0), val:13},
    {date: new Date(2011, 5, 1, 17, 0, 0, 0), val:14},
    {date: new Date(2011, 5, 1, 18, 0, 0, 0), val:17},
    {date: new Date(2011, 5, 1, 19, 0, 0, 0), val:13}
			];

/* Prepare the chart and write to the HTML */
AmCharts.ready(function(){
	var chart = new AmCharts.AmStockChart();
	chart.pathToImages = "amcharts/images/";

var dataSet = new AmCharts.DataSet();
dataSet.dataProvider = chartData;
	dataSet.fieldMappings = [{fromField: "val", toField: "value"}];
	dataSet.categoryField = "date";
	chart.dataSets = [dataSet];

	//create stock panel
	var stockPanel = new AmCharts.StockPanel();
	chart.panels = [stockPanel];

	//adjust panel settings
	var panelsSettings = new AmCharts.PanelsSettings();
	panelsSettings.startDuration = 1;
	chart.panelsSettings = panelsSettings;

	//create graph
	var graph = new AmCharts.StockGraph();
	graph.valueField = "value";
	graph.type = "line";
	//graph.fillAlphas = 1;
	graph.title = "MyGraph"; 
	stockPanel.addStockGraph(graph);

    //set minimum period of time (to hours)
	//category axes settings
	var categoryAxesSettings = new AmCharts.CategoryAxesSettings();
	categoryAxesSettings.minPeriod = "hh";
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