var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
var stocks = [];




//For changing the time range display on the graph. Called by time buttons
function updateTimeRange(time_range){
	var num = time_range.substring(0, 1);
	var timeUnit = time_range.substring(1);
	var labels= [];
	
	myLine.removeData();
	myLine.addData([50, 30] ,"What");

}

//add a stock
function addStock(ticker){
	if(getIndexOf(ticker) < 0){
		stocks.push(ticker);
	}

}
//remove stock
function removeStock(ticker){
	var index = getIndexxOf(ticker);
	if(index > -1){
		stocks.splice(index, 1);
	}
}
//set line color
function setLineColor(){

}

/* -- [Helper functions] --- */
var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

function getMonthsBeforeCurrentTime(num_months){
	var monthArray = [];
	var currentDate = new Date();
	var mm = currentDate.getMonth();
	var yyyy = currentDate.getYear();
	while(num_months > 0){
		mm = (mm - num_months) % 12; //make sure within 12 month range
		monthArray.push(months[mm-1]); //mm-1 to match array indexing
		num_months--;
	}
	return monthArray;
}

function getDaysBeforeCurrentTime(num_days){

}

function getIndexOf(ticker){
	for(i=0; i<stocks.length; i++){
		if(stocks[i] == ticker){
			return i;
		}
	}
	return -1;
}


/* --- [Functions and variables directly used by the graph: the equivalent of main] --- */

var lineChartData = {
	labels : ["January","February","March","April","May","June","July"],
		datasets : [
			{
				label: "My First dataset",
				fillColor : "rgba(220,220,220,0.2)",
				strokeColor : "rgba(220,220,220,1)",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "rgba(220,220,220,1)",
				data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
			},
			{
				label: "My Second dataset",
				fillColor : "rgba(151,187,205,0.2)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "rgba(151,187,205,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "rgba(151,187,205,1)",
				data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
			}
		]

	}

window.onload = function(){
	var ctx = document.getElementById("canvas").getContext("2d");
	myLine = new Chart(ctx).Line(lineChartData, {
		responsive: true
	});
}