/* CLOCK 
-----------
Updates every second, in Eastern Time */

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
window.onload=function() {
	startClock();
	window.scrollTo(0,0);
}
