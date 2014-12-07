<?php
	function getDrivingDistance($address) {
	    $url = 'http://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=Computer+Science+Instructional+Center&';
	 	$url = $url . 'destinations=' . urlencode($address);
	 	//echo "URL: " . $url . "<br>";
	 	$data = file_get_contents($url);

		if(!$data) echo "FAILED!!!!<br>";
	 	//echo $data . "<br>";

	 	$data = json_decode($data);
	 	
	 	$time = 0;
		$distance = 0;
		foreach($data->rows[0]->elements as $road) {
		    $time += $road->duration->value;
		    $distance += $road->distance->value;
		}
		echo "TIME: " . $time . "<br>";

		return $distance;
	}

	$servername = "localhost";
	$username = "jchen127";
    $password = "KbZFqBcZCy29b3Lx";
    $database = "myDB";
	// Create connection
	$conn = mysqli_connect($servername, $username, $password);

	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	$cid =  $_POST["customerid"];
	$_SESSION["cid"] = $cid;
	$_SESSION["searchtext"] = "";

	include 'loggedinheader.php';

	$name = $_POST["lastname"] . ", " . $_POST["firstname"];
	$age = $_POST["age"];
	$phonenumber = $_POST["phonenumber"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$address = $_POST["address"] . ", " . $_POST["city"] . ", " . $_POST["state"] . " " . $_POST["zipcode"];
	$sex = $_POST["sex"];
	$paymentflag = false;
	$creditcardnumber = NULL;
	$ccexpiration = NULL;
	$bankaccountnumber = NULL;
	$bankroutingnumber = NULL;

	if ($_POST["payment"] == "creditcard") {
		$paymentflag = false;
		$creditcardnumber = $_POST["creditcardnumber"];
		$ccexpiration = /*date('Y-m-d',*/ $_POST["ccexpiration"]/*)*/;
	} else  {
		$paymentflag = true;
	}

	/* CHECK IF ADDRESS IS OUT OF DELIVERY RANGE!!!!!! */
	$drivingDistMeters = getDrivingDistance($address);
	echo "Driving distance: " . $drivingDistMeters . "<br>";
    $drivingDistMiles = $drivingDistMeters/1000 * 0.621371;
    echo "Driving distance in miles: " . $drivingDistMiles . "<br>";

    $sqlDist = "SELECT price FROM $database.deliverypricing WHERE $drivingDistMiles >= rangestart AND $drivingDistMiles < rangeend";
    $resultDist = mysqli_query($conn, $sqlDist);

    if ($resultDist && mysqli_num_rows($resultDist) > 0) {
    	//Insert new customer
		$sql = "UPDATE $database.customer SET name = '$name', age = $age, sex = '$sex', password = '$password', paymentflag = '$paymentflag', creditcardnumber = '$creditcardnumber', ccexpiration = '$ccexpiration', address = '$address', phonenumber = '$phonenumber', email = '$email' WHERE customerid = $cid";
		echo $sql . "<br>";
		$result = mysqli_query($conn, $sql);

		if (!$result) {
			echo "Update of customer failed!<br>";
		} else {
			echo "Successfully updated customer!<br>";
			header('Location: loggedinhome.html?customerid=' . $cid);
		}
    } else {
    	echo "Entered address is outside of our delivery range.<br>";
    	echo "<form method=\"get\" action=\"updateprofile.html\"><input type=\"number\" name=\"customerid\" value=" . $cid . "><input type=\"submit\" value=\"Back\"></form>";
    }

	mysqli_close($conn);


?>
