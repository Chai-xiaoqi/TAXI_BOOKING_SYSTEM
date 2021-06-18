/*--student name:Xiaoqi Chai
	student ID:20101650 */
// the functions in this file are used by admin.html to show pick-up booking request and assign taxi.
var xhr = createRequest();
function getData(dataSource, divID)  {
    if(xhr) {
	    var obj = document.getElementById(divID);
		//var requestbody ="number="+encodeURIComponent(number);
		 xhr.open("POST", dataSource, true);
		 xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 xhr.onreadystatechange = function() {
		 alert(xhr.readyState); // to let us see the state of the computation
		 if (xhr.readyState == 4 && xhr.status == 200) {
		 obj.innerHTML = xhr.responseText;
		 } // end if
		 } // end anonymous call-back function
		 xhr.send();
		 } // end if
} // end function getData() 
		
var xhr1 = createRequest();	
function showRequest(dataSource, divID, input)  {
    if(xhr1) {
	    var obj = document.getElementById(divID);
		var requestbody ="number="+encodeURIComponent(input);
		 xhr1.open("POST", dataSource, true);
		 xhr1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 xhr1.onreadystatechange = function() {
		 alert(xhr1.readyState); // to let us see the state of the computation
		 if (xhr1.readyState == 4 && xhr1.status == 200) {
		 obj.innerHTML = xhr1.responseText;
		 } // end if
		 } // end anonymous call-back function
		 xhr1.send(requestbody);
		 } // end if
} // end function getData() 
function update(divID, input){ 
	var xhr = false;  
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	if(xhr) {
	    var obj = document.getElementById(divID);
		var requestbody ="number="+encodeURIComponent(input);
		 xhr.open("POST","assignTaxi.php", true);
		 xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 xhr.onreadystatechange = function() {
		 alert(xhr.readyState); // to let us see the state of the computation
		 if (xhr.readyState == 4 && xhr.status == 200) {
		 obj.innerHTML = xhr.responseText;
		 } // end if
		 } // end anonymous call-back function
		 xhr.send(requestbody);
		 } // end if
}