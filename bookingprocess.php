<!--student name:Xiaoqi Chai
	student ID:20101650 -->
	
<!--this file is used to process and valid the request inputs from booking.html.-->
<?php
//1. check all inputs are valid

	/* this function is used to check if the input is null or empty.
	$input: the value of the input
	$name: the name of the input field, used to display the error message
	$GLOBALS['error_message'] contains all the error message related to input validation
	*/
	function check_input_notnull($input,$name){
		if($input!="")
		{}
		else {$GLOBALS['error_message'].="$name - can not be null! <br>" ;}
	}
	
	/* this function is used to check if the input is null or empty and check if the input value meets the $pattern conditions.
	$input: the value of the input
	$name: the name of the input field, used to display the error message
	$pattern: to check if the input value is correct
	$GLOBALS['error_message'] contains all the error message related to input validation
	*/
	function check_input_pattern( $input,$pattern,$name){
		if ($input!=""){
			if (preg_match($pattern, $input))
			{}
			else {$GLOBALS['error_message'].="$name - is not valid! <br>" ;}
		}
		else {$GLOBALS['error_message'].="$name - can not be null! <br>" ;}
		
	}
	
	/* this function is used to check if the input-date format is correct.
	*/
	function validateDate($date, $format = 'd/m/Y'){
					$d = DateTime::createFromFormat($format, $date);
					return $d && $d->format($format) === $date;
					}
	/* this function is used to check if the input-time format is correct.
	*/
	
	function validateTime($time, $format = 'H:i'){
					$d = DateTime::createFromFormat($format, $time);
					return $d && $d->format($format) === $time;
					}
					
	/* this function is used to check if the input-pick-up date and pick_up time are not earlier than the current date and time on the client machine.
	*/	
	function check_time_is_after_currentdate($date,$time){
		$year=substr($date,6,4);
		$month=substr($date,3,2);
		$dt=substr($date,0,2);
		$current_time_hour=date("H");
		$current_time_minute=date("m");
		$hour=substr($time,0,2);
		$min=substr($time,3,2);
		
		if (validateDate($date)&&validateTime($time)){//if date and time format are all correct
			
			if(($year==date("Y"))&&($month==date("m"))){//if the pick-up year and month are current year and month
				
				if($dt==date("d")){// if the pick-up day is current day
					if($hour>$current_time_hour){}
					else if($hour==$current_time_hour){ //if the pick-up hour is equal to the current hour, then check the pick-up minute
						if($min>$current_time_minute){} //if the pick-up minute is later than the current minute, it is fine
						else {$GLOBALS['error_message'].="The time you booked has already passed! <br>";}//if the pick-up minute is earlier than the current minute, the time is not acceptable, display error message.
					}
					else {$GLOBALS['error_message'].="The hour you booked has already passed! <br>";} //if the pick-up hour is earlier than the current hour, the time is not acceptable, display error message.
				}
				else if($dt>=date("d")){}
			}
			else if(($year>date("Y"))||(($year==date("Y"))&&($month>date("m")))){}
			
			
			else{$GLOBALS['error_message'].="The date you booked has already passed! <br>";}//if the pick-up day is earlier than the current day, the date is not acceptable, display error message.
		}
		//if the date or time format is not correct, the date or time is not acceptable, display error message.
		else if((!validateDate($date))&&(validateTime($time)))
		{$GLOBALS['error_message'].="The date format or value you entered is not correct! It should be dd/mm/yyyy(etc:26/03/2021)<br>";}
		else if((!validateTime($time))&&(validateDate($Date)))
		{$GLOBALS['error_message'].="The time format or value you entered is not correct! It should be HH:SS(etc:21:30)<br>";}
		else {
			$GLOBALS['error_message'].="The date format or value you entered is not correct! It should be dd/mm/yyyy(etc:26/03/2021)<br>";
			$GLOBALS['error_message'].="The time format or value you entered is not correct! It should be HH:SS(etc:21:30)<br>";
		}
	
	}
	
	// get all inputs value from client page:booking.html
	$cname = $_POST['cname'];
	$phone = $_POST['phone'];
	$unumber = $_POST['unumber'];
	$snumber = $_POST['snumber'];
	$stname = $_POST['stname'];
	$sbname = $_POST['sbname'];
	$dsname = $_POST['dsname'];
	$date = $_POST['date'];
	$time = $_POST['time'];
	
	// generate booking date and time
	$generated_date="";
	$generated_time="";
	$status="";
	
	// use these functions to check if inputs are validated
	check_input_pattern($cname,'/^[A-Za-z ]*$/',"Name");
	check_input_pattern($phone,'/^\d{10,12}$/',"Phone Number (need to be all numbers with length between 10-12)");
	
	check_input_pattern($snumber,'/^\d/',"Street Number (need to be all numbers)");
	check_input_notnull($stname,"Street Name");
	check_input_notnull($date,"Date");
	check_input_notnull($time,"Time");
	check_time_is_after_currentdate($date,$time);
	
	//not all inputs are valid
	if($error_message!=""){
		echo $error_message;
	}
	
	// all inputs are valid
	else{
	
//2. connect to database and store the data
		//get database login details
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
			
		//check if the booking table exists
		$qtable="select * from information_schema.TABLES where TABLE_NAME = 'booking'";
		$resultbl=mysqli_query($conn,$qtable);
			if(!$resultbl){
				//if not, create a table
			   echo"
				CREATE TABLE booking (
				booking_number INT(40) PRIMARY KEY AUTO_INCREMENT, 
				customer_name VARCHAR(80) NOT NULL,
				phone_number VARCHAR(12) NOT NULL,
				unit_number VARCHAR(40),
				street_number VARCHAR(40) NOT NULL,
				street_name VARCHAR(255) NOT NULL,
				suburb VARCHAR(80),
				destination_suburb VARCHAR(80),
				pickup_date VARCHAR(50) NOT NULL,
				pickup_time VARCHAR(50) NOT NULL,
				generated_booking_date VARCHAR(50),
				generated_booking_time VARCHAR(50),
				status VARCHAR(40));
			   ";
				
			}
			//table exists
			else{
			// check if the user has entered the same infor before (check if the same booking request existed in database)
				$q="select * from booking where customer_name='$cname' AND phone_number='$phone' AND unit_number='$unumber' AND street_number='$snumber' AND street_name='$stname' AND suburb='$sbname' AND destination_suburb='$dsname' AND pick_up_date='$date' AND pick_up_time='$time'";
				$resultq = mysqli_query($conn, $q);
				if(mysqli_num_rows($resultq)>0) {//existed in database
				echo "<p style='color:Crimson;'>You booked a taxi at the same time and location!</p>";
				}
				
				else{
					//generate booking date and time
					$generated_date=date('d/m/Y');
					$generated_time=date('H:i');
					//status default: unassigned
					$status="unassigned";
					

					//insert data to database
					//the booking reference number is auto increment, and unique
					$query = "insert into $sql_tble"
						."(customer_name, phone_number, unit_number,street_number, street_name, suburb, destination_suburb, pick_up_date, pick_up_time,generated_booking_date,generated_booking_time,status)"
						. "values"
						."('$cname','$phone','$unumber','$snumber','$stname','$sbname','$dsname','$date','$time','$generated_date','$generated_time','$status')";
					$resultsave = mysqli_query($conn, $query);
					// checks if the execution was successful
					if(!$resultsave) {
						echo "<p style='color:Crimson;'>Something is wrong with ",	$query, "</p>";
						} 
					else {
						$qnumber="select * from booking where customer_name='$cname' AND phone_number='$phone' AND unit_number='$unumber' AND street_number='$snumber' AND street_name='$stname' AND suburb='$sbname' AND destination_suburb='$dsname' AND pick_up_date='$date' AND pick_up_time='$time'";
						$resultnum = mysqli_query($conn, $qnumber);
						$row=mysqli_fetch_assoc($resultnum);
						if(!$resultnum) {
						echo "<p style='color:Crimson;'>Something is wrong with the database </p>";
						}
						else {
							$bnumber=$row["booking_number"];
							// 7. display confirmation info to users
							echo "<p>Thank you! Your booking reference number is: ",$bnumber,"</p>";
							echo "<p>           You will be picked up in front of your provided address at: ",$time," on ",$date, " </p>";
							} // if successful query operation
						}
				}
			}
		
		}
	// close the database connection
		mysqli_close($conn);
	}




?>
