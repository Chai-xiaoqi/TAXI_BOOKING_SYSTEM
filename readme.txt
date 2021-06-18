Files List:
(You can also find these files in gqx7248.cmslamp14.aut.ac.nz/assign2)
•	admin.html
•	booking.html
•	xhr.js
•	show_time.js (used for showing current date and time in booking.html)
•	booking_ajax.js (ajax of booking.html)
•	get_request.js (ajax of admin.html)
•	settings.php (database login detail)
•	assignTaxi.php (assign a taxi for a booking request)
•	show_pickup_request.php (show all unassigned booking request within 2 hours)
•	bookingprocess.php (save the booking request data in database)
•	style.css
•	mysqlcommand.txt (create database MySQL command)

Instructions:
Each file contains a brief description as to what the file does, each function also has a brief description that explains the functionality.

booking.html: 
This webpage allows a passenger to put a taxi booking request. Passengers need to input their booking request information. If any input fields were not entered correctly (e.g. name is empty or phone number contains characters), an error message will display showing exactly what went wrong. If all inputs field are valid, a confirmation message will be displayed.

admin.html: This page contains 2 buttons:
-	Show Pick Up Request
If there are booking requests that are unassigned with pick-up time within the next 2 hours from now only, it will generate a table displaying all the booking requests and details. If there are no bookings, the message (e.g there is no booking request within 2 hours from now) will display in the website.
-	Assign Taxi
This button used to assign a taxi for a booking request. Administrator needs to input a reference number and click the assign button. If the reference number that is entered matches a booking request that hasn’t already been assigned, the taxi will be assigned and a confirmation message will display. If the booking has already been assigned or the reference number was not found, a message will display and explain that situation.
