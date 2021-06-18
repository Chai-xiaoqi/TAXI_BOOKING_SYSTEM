/*--student name:Xiaoqi Chai
	student ID:20101650 */

// this file is used to show current date and time
function getDate(){ 
	var _dateID = document.getElementById('showDate');
	var date = new Date();    
	var y = date.getFullYear();     //get year  
	var m =date.getMonth()+1;   //get month 
	var d = date.getDate(); //get day
	if(m<10){
	m = "0"+m;
	}
	if(d<10){
	d = "0"+d;
	}
	var current_date =  d+"/"+m+"/"+y; 
	_dateID.value=current_date;
  }
function getTime(){ 
	var _timeID = document.getElementById('showTime');
	var date = new Date();  //create an object  
	var h = date.getHours();  
	var minute = date.getMinutes()   
	
	if(h<10){
	h = "0"+h;
	}	 
	if(minute<10){
	minute = "0"+minute;
	}	 
	var current_time =  h+":"+minute; 
	_timeID.value=current_time;

  }
