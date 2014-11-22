<?php
	$servername = "localhost";
	$username = "jsamelson";
	$password = "database";
	// Create connection
	$conn = mysqli_connect($servername, $username, $password);

	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	$email = $_POST["email"];
	$password = $_POST["password"];

	$sql = "SELECT * FROM GroceryDelivery.Test t WHERE t.FirstName = '$email' AND t.LastName = '$password'";
	$result = mysqli_query($conn, $sql);

	if ($result && mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			echo "lastname: " . $row["LastName"]. " - firstname: " . $row["FirstName"] . "<br>";
		}
	} else {
		echo "0 results";
	}

	mysqli_close($conn);
?>