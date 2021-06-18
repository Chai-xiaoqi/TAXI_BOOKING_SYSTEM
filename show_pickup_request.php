<!--student name:Xiaoqi Chai
	student ID:20101650 -->

<!--this file is used to show pick-up requests for admin.html-->

<?php
/*echo'<script> function update(divID, input){ 
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
}</script>';

*/
//1. connect to database and get the data
	   // get database login details 
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
			
		//2. check if the table exists
		$qtable="select * from information_schema.TABLES where TABLE_NAME = 'booking'";
		$resultbl=mysqli_query($conn,$qtable);
			//2.1 table does not exist
			if(!$resultbl){
				echo "<p style='color:Crimson;'>Table does not exist!",	$qtable,"</p>";
			}
			//2.2 table exists

			else {
				$today=date("d/m/Y");
				$tmr=date('d/m/Y', strtotime('tomorrow'));
				$current_time=date("H:i");
				$two_hours_later=date('H:i',strtotime('+2 hour',strtotime(date('H:i'))));
				//echo"$two_hours_later";
				//echo "$today";
				//echo "$tmr";
				if($current_time>="22:00")
				{
					$query="select * from booking where (status='unassigned' AND pick_up_date='$today' AND pick_up_time>='$current_time' AND pick_up_time<='23:59') OR (status='unassigned' AND pick_up_date='$tmr' AND pick_up_time<='$two_hours_later')";
				}
				else{
				$query="select * from booking where status='unassigned' AND pick_up_date='$today' AND pick_up_time>='$current_time' AND pick_up_time<='$two_hours_later'";
				}
				$resultnumall = mysqli_query($conn, $query);
				
				if(!$resultnumall) {
				echo "<p style='color:Crimson;'>Something is wrong with the database </p>";
				}
				else {
					if(mysqli_num_rows($resultnumall)==0){

						echo "<p style='color:Crimson;'> No bookings within 2 hours from now! </p>";
						}
						
					else{						
					//3. list all unassigned requests within 2 hours
					echo "<p> All unassigned bookings within 2 hours from now <br></p>";
					echo "<table>
					<tr>
					<th>Booking Reference Number</th>
					<th>Customer Name</th>
					<th>Contact Phone Number</th>
					<th>Pick Up Suburb</th>
					<th>Destination Suburb</th>
					<th>Pick Up Date</th>
					<th>Pick Up Time</th>
					<th>Status</th>
					<th>Assign</th>
					</tr>";
					while($row = mysqli_fetch_array($resultnumall)) {
 					  $n= $row['booking_number'];//array get n[0],n[1], as input post name
					  $ni="book".$n;
					  echo "<tr>";
					  echo "<td>" . $row['booking_number'] . "</td>";
					  echo "<td>" . $row['customer_name'] . "</td>";
					  echo "<td>" . $row['phone_number'] . "</td>";
					  echo "<td>" . $row['suburb'] . "</td>";
					  echo "<td>" . $row['destination_suburb'] . "</td>";
					  echo "<td>" . $row['pick_up_date'] . "</td>";
					  echo "<td>" . $row['pick_up_time'] . "</td>";
					  echo "<td id='$ni' class='std'>" . $row['status'] . "</td>";
						//  echo"$ni";
						//echo "<td>update(\"$ni\",$n)</td>";
						//echo "<td><input type= 'button' value='assign' onclick='save()'></td>";
					  echo "<td>" . "<form><input type='submit' value='assign' onclick='update(\"$ni\",$n)'></form>" . "</td>";
						
   
					  //echo "<td><a href=\"assignTaxi.php?id=".$row['booking_number']."&status=app\">Assign</a></td>";
					  echo "</tr>";
					}
					echo "</table>";
					
					}
					
					// a loop to check if any assign button is clicked, if yes, update the database and webpage
					if(isset($_POST['assin']))
						{
							$q="UPDATE booking SET status='assigned' WHERE booking_number='$number'";
							$resultq = mysqli_query($conn, $q);
							if(!$result) {
								echo "<p style='color:Crimson;'>Something is wrong with the database, the status is still unassigned. </p>";
							}
							else {
								echo "<p>The Booking Reference Number: $number is assignd successfully! </p>";
							}
						}
						
				} // if successful query operation
		
			
	// close the database connection
		mysqli_close($conn);
		}
		}

?>
