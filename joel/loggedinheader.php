<!--<div style="background-color: #6495ed">-->
	<?php
	    echo "CID in header: " . $_SESSION['cid'] . "<br>";
	    echo "SearchText in header: " . $_SESSION['searchtext']; 
	?>

	<a href="loggedinhome.html?customerid=<?php echo $_SESSION['cid'] ?>"><img src="logo.png" alt="Logo" style="width:530px;height:140px" align="center"></a>
	<br><br>
	<!--<a href="loggedinhome.html?customerid=<?php echo $_SESSION['cid'] ?>">HOME</a>-->
	<div align="left">
		<a href="loginproductsearch.html">Search Products</a>
		<form action="loginproductsearch.html" method="get">
			<input type="text" name="searchtext" value='<?php echo $_SESSION['searchtext']; ?>'>
			<input type="text" name="customerid" value='<?php echo $_SESSION['cid'] ?>' style="display:none"/>
			<input type="submit" value="Search"/>
		</form>

	</div>
	<div align="right">
		<a href="viewcart.html?customerid=<?php echo $_SESSION['cid'] ?>">View Cart</a>
		<a href="https://google.com/">View Orders</a>
		<a href="https://google.com/">Transaction History</a>
		<a href="index.html">Update Profile</a>
		<a href="index.html">Logout</a>
	</div>

	<hr>
<!--</div>-->
	
