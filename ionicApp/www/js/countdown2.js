function cdLocalTime(container, servermode, offsetMinutes, targetdate, debugmode, currenttime1){
if (!document.getElementById || !document.getElementById(container)) return
this.container=document.getElementById(container)
var servertimestring=(servermode=="server-php")? '<? print date("F d, Y H:i:s", time())?>' : (servermode=="server-ssi")? '<!--#config timefmt="%B %d, %Y %H:%M:%S"--><!--#echo var="DATE_LOCAL" -->' : '<%= Now() %>'

this.localtime=this.serverdate=new Date(currenttime1)

this.targetdate=new Date(targetdate)
this.debugmode=(typeof debugmode!="undefined")? 1 : 0
this.timesup=false
this.localtime.setTime(this.serverdate.getTime()+offsetMinutes*60*1000) //add user offset to server time
this.updateTime()

}

cdLocalTime.prototype.updateTime=function(){
var thisobj=this
this.localtime.setSeconds(this.localtime.getSeconds()+1)
setTimeout(function(){thisobj.updateTime()}, 1000) //update time every second
}

cdLocalTime.prototype.displaycountdown=function(baseunit, functionref){
this.baseunit=baseunit
this.formatresults=functionref
this.showresults()
}

cdLocalTime.prototype.showresults=function(){
var thisobj=this
var debugstring=(this.debugmode)? "" : ""

var timediff=(this.targetdate-this.localtime)/1000 //difference btw target date and current date, in seconds
if (timediff<0){ //if time is up
this.timesup=true
this.container.innerHTML=this.formatresults()
return
}
var oneMinute=60 //minute unit in seconds
var oneHour=60*60 //hour unit in seconds
var oneDay=60*60*24 //day unit in seconds
var dayfield=Math.floor(timediff/oneDay)
var hourfield=Math.floor((timediff-dayfield*oneDay)/oneHour)
var minutefield=Math.floor((timediff-dayfield*oneDay-hourfield*oneHour)/oneMinute)
var secondfield=Math.floor((timediff-dayfield*oneDay-hourfield*oneHour-minutefield*oneMinute))
if (this.baseunit=="hours"){ //if base unit is hours, set "hourfield" to be topmost level
hourfield=dayfield*24+hourfield
dayfield="n/a"
}
else if (this.baseunit=="minutes"){ //if base unit is minutes, set "minutefield" to be topmost level
minutefield=dayfield*24*60+hourfield*60+minutefield
dayfield=hourfield="n/a"
}
else if (this.baseunit=="seconds"){ //if base unit is seconds, set "secondfield" to be topmost level
var secondfield=timediff
dayfield=hourfield=minutefield="n/a"
}
this.container.innerHTML=debugstring+this.formatresults(dayfield, hourfield, minutefield, secondfield)
setTimeout(function(){thisobj.showresults()}, 1000) //update results every second
}

function formatresults2(){

if (this.timesup==false){ //if target date/time not yet met
var displaystring='<a class="button"><span class="timer-time">'+arguments[0]+'</span><span class="timer-label">Days</span></a><a class="button"><span class="timer-time">'+arguments[1]+'</span><span class="timer-label">Hours</span></a><a class="button"><span class="timer-time">'+arguments[2]+'</span><span class="timer-label">Minutes</span></a><a class="button"><span class="timer-time">'+arguments[3]+'</span><span class="timer-label">Seconds</span></a>';

}

return displaystring
}





/* auto hide address bar*/
var bodyTag;
var executionTime = new Date().getTime(); // JavaScript execution time

// Document ready
//----------------
documentReady(function() {
	// Don't hide address bar after a distracting amount of time
	var readyTime = new Date().getTime()
	if((readyTime - executionTime) < 3000) hideAddressBar(true);

});

// Run specified function when document is ready (HTML5)
//------------------------------------------------------
function documentReady(readyFunction) {
	document.addEventListener('DOMContentLoaded', function() {
		document.removeEventListener('DOMContentLoaded', arguments.callee, false);
		readyFunction();

	}, false);

}

// Hide address bar on devices like the iPhone
//---------------------------------------------
function hideAddressBar(bPad) {
	// Big screen. Fixed chrome likely.
	if(screen.width > 980 || screen.height > 980) return;

	// Standalone (full screen webapp) mode
	if(window.navigator.standalone === true) return;

	// Page zoom or vertical scrollbars
	if(window.innerWidth !== document.documentElement.clientWidth) {
		// Sometimes one pixel too much. Compensate.
		if((window.innerWidth - 1) !== document.documentElement.clientWidth) return;

	}

	// Pad content if necessary.
	if(bPad === true && (document.documentElement.scrollHeight <= document.documentElement.clientHeight)) {
		// Extend body height to overflow and cause scrolling
		bodyTag = document.getElementsByTagName('body')[0];

		// Viewport height at fullscreen
		bodyTag.style.height = document.documentElement.clientWidth / screen.width * screen.height + 'px';

	}

	setTimeout(function() {
		// Already scrolled?
		if(window.pageYOffset !== 0) return;

		// Perform autoscroll
		window.scrollTo(0, 1);

		// Reset body height and scroll
		if(bodyTag !== undefined) bodyTag.style.height = window.innerHeight + 'px';
		window.scrollTo(0, 0);

	}, 1000);

}

// Quick address bar hide on devices like the iPhone
//---------------------------------------------------
function quickHideAddressBar() {
	setTimeout(function() {
		if(window.pageYOffset !== 0) return;
		window.scrollTo(0, window.pageYOffset + 1);

	}, 1000);

}
