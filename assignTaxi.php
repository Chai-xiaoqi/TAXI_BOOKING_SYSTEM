<!--student name:Xiaoqi Chai
	student ID:20101650 -->
<!--this file is used to assign a taxi for a booking request in admin.html -->
<?php
//1. check inputs are valid
	
	// get search text from client
	$number = $_POST['number'];
	
//2. connect to database and get the data
		require_once ('settings.php');

		$sql_tble="booking";
		$conn = mysqli_connect($host,$user,$pswd,$dbnm);
		if (!$conn) 
		{
			echo "<p>Database connection failure</p>";
		} 
		else 
		{
			echo "<p>Database connection successful</p>";
			
		// check if the table exists
		$qtable="select * from information_schema.TABLES where TABLE_NAME = 'booking'";
		$resultbl=mysqli_query($conn,$qtable);
			if(!$resultbl){
				echo "<p style='color:Crimson;'>Table does not exist!",	$qtable,"</p>";
			}
			//table exists
			else {
				// if input reference number is null, display error messsage
				if($number==""){
					echo "<p style='color:Crimson;'>Please input a reference number! </p>";
				}
				// check if the reference number exists in the database
				else {
					$qnumber="select * from booking where booking_number='$number'";
					$result = mysqli_query($conn, $qnumber);
					
					if(!$result) {
					echo "<p style='color:Crimson;'>Something is wrong with the database, you can not assign a taxi for the booking request! </p>";
					}
					else {
						// if the reference number does not exist, display error messsage
						if(mysqli_num_rows($result)==0){
							echo "<p style='color:Crimson;'> No such booking reference number! </p>";
							}
						else{
							$row = mysqli_fetch_assoc($result);
							// if the booking request has already assigned, display error messsage
							if($row['status']=="assigned" ){
								echo "<p style='color:Crimson;'> The booking request has already been assigned! </p>";
							}
							else{
								// if the booking request has not already assigned, update this record
								$q="UPDATE booking SET status='assigned' WHERE booking_number='$number'";
								$resultq = mysqli_query($conn, $q);
								if(!$result) {
									echo "<p style='color:Crimson;'>Something is wrong with the database, the status is still unassigned. </p>";
								}
								else {
									echo "<p>The Booking Reference Number: $number is assigned successfully! </p>";
								}
							}
							
						}
						
					} // if successful query operation
				}
				
		
			}
	// close the database connection
		mysqli_close($conn);
		}


?>
