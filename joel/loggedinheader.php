<!--<div style="background-color: #6495ed">-->
	<?php
	    echo "CID in header: " . $_SESSION['cid'] . "<br>";
	    echo "SearchText in header: " . $_SESSION['searchtext']; 
	?>

	<a href="loggedinhome.html?customerid=<?php echo $_SESSION['cid'] ?>"><img src="logo.png" alt="Logo" style="width:530px;height:140px" align="center"></a>
	<br><br>
	<!--<a href="loggedinhome.html?customerid=<?php echo $_SESSION['cid'] ?>">HOME</a>-->
	<div align="left">
		<form action="loginproductsearch.html" method="get">
			<input type="text" name="searchtext" value='<?php echo $_SESSION['searchtext']; ?>'>
			<input type="text" name="customerid" value='<?php echo $_SESSION['cid'] ?>' style="display:none"/>
			<input type='number' name='minprice' style='display:none'>   
			<input type='number' name='maxprice' style='display:none'>   
			<input type='hidden' name='saleonly' value='0' style='display:none'>
			<input type='checkbox' name='saleonly' value='1' style='display:none'>
			<input type="submit" value="Search Products"/>
		</form>

	</div>
	<div align="right">
		<a href="viewcart.html?customerid=<?php echo $_SESSION['cid'] ?>">View Cart</a>
		<a href="vieworders.html?customerid=<?php echo $_SESSION['cid'] ?>">View Orders</a>
		<a href="https://google.com/">Transaction History</a>
		<a href="updateprofile.html?customerid=<?php echo $_SESSION['cid'] ?>">Update Profile</a>
		<a href="index.html">Logout</a>
	</div>

	<hr>
<!--</div>-->
	
