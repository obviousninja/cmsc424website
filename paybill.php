<!DOCTYPE html>
<html>
<head>
    <title>Bill Confirmation</title>
</head>
<body bgcolor="#D1F2A5">
	<?php
		$cid = $_POST["customerid"];
		echo "Get CID: " . $cid . "<br>";
		$_SESSION["cid"] = $cid;
		$_SESSION["searchtext"] = "";

		include 'loggedinheader.php';

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

		$transactionid = $_POST["transactionid"];
		$bankaccountnumber = $_POST["bankaccountnumber"];
		$bankroutingnumber = $_POST["bankroutingnumber"];
		$creditcardnumber = $_POST["creditcardnumber"];
		$ccexpiration = $_POST["ccexpiration"];
		$tip = $_POST["tip"];
		$transactiontotal = $_POST["transactiontotal"];

		$sql = "UPDATE $database.bill SET paidflag = 1, tip = $tip WHERE transactionid = $transactionid";
		$result = mysqli_query($conn, $sql);

		if (!$result) {
			echo "Update of bill failed!!!!<br>";
		} else {
			echo "Update of bill successful!<br>";

			$sqlBalance = "UPDATE $database.customer SET balance = balance - $transactiontotal WHERE customerid = $cid";
			$resultBalance = mysqli_query($conn, $sqlBalance);

			if (!$resultBalance) {
				echo "Update of customer balance failed!<br>";
			} else {
				//echo "Update of customer successful!<br>";
				echo "You have successfully paid your bill!<br>";
			}
		}

	?>
</body>
</html>