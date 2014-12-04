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

	$email = $_POST["email"];
	$password = $_POST["password"];
	$type = $_POST["privilege"];
	
	echo $email . "; " . $password . ";" . $type . '<br>';
	
	if($type == "customer"){
		echo "its an customer";
		$flag = 1; // meaning customer
		$sql = "SELECT * FROM $database.customer c WHERE c.email = '$email' AND c.password = '$password'";
	}else if($type == "admin"){
		echo "its an admin";
		$flag = 2; //meaning admin
		$sql = "SELECT * FROM $database.administrator c WHERE c.email = '$email' AND c.password = '$password'";
	}
	
	
	
	echo $sql . '<br>';
	$result = mysqli_query($conn, $sql);

	if ($result == FALSE) {
		echo "Query failed!";
	} elseif (mysqli_num_rows($result) > 0) {
		// output data of each row
		
		
		/*while($row = mysqli_fetch_assoc($result)) {
			//echo "lastname: " . $row["LastName"]. " - firstname: " . $row["FirstName"] . "<br>";
			echo "Welcome!";
			$cid = $row["customerid"];
			//localStorage.setItem('label', 'value');
			header('Location: loggedinhome.html?customerid=' . $cid);
		}*/
		if($flag == 1){
			echo "i got admin";
			$homepage = file_get_contents('CustPage.html');
			
			
		}else if($flag == 2){
			echo "i got customer";
			$homepage = file_get_contents('AdminPage.html');
			
		}
		echo $homepage;
		
	} else {
		echo "Unauthorized Please Consider Register";
	}

	mysqli_close($conn);
?>