<?php
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

	mysqli_close($conn);


?>
