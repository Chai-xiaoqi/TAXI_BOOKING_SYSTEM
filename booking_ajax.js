/*--student name:Xiaoqi Chai
	student ID:20101650 */
// the function in this file is used by booking.html to process the input data.
var xhr = createRequest();
function getData(dataSource, divID, acname, aphone,aunumber,asnumber,astname,asbname,adsname,adate,atime)  {
    if(xhr) {
	    var obj = document.getElementById(divID);
		var requestbody ="cname="+encodeURIComponent(acname)+"&phone="+encodeURIComponent(aphone)+"&unumber="+encodeURIComponent(aunumber)+"&snumber="+encodeURIComponent(asnumber)+"&stname="+encodeURIComponent(astname)+"&sbname="+encodeURIComponent(asbname)+"&dsname="+encodeURIComponent(adsname)+"&date="+encodeURIComponent(adate)+"&time="+encodeURIComponent(atime);
		 xhr.open("POST", dataSource, true);
		 xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 xhr.onreadystatechange = function() {
		 alert(xhr.readyState); // to let us see the state of the computation
		 if (xhr.readyState == 4 && xhr.status == 200) {
		 obj.innerHTML = xhr.responseText;
		 } // end if
		 } // end anonymous call-back function
		 xhr.send(requestbody);
		 } // end if
} // end function getData() 