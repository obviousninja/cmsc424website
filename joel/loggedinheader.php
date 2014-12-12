<div id="header" style="background-color: #FFC48C">
	<?php
	    //echo "CID in header: " . $_SESSION['cid'] . "<br>";
	    //echo "SearchText in header: " . $_SESSION['searchtext']; 
	?>

	<a href="loggedinhome.html?customerid=<?php echo $_SESSION['cid'] ?>" style="text-decoration:none; text-shadow: 3px 3px 3px #000000">
		<!--<p align="center"><img src="logo.png" alt="Logo" style="width:530px;height:140px" align="center"></p>-->
		<p align="center"><b><font face="Verdana" size="140" color="#FC7403">Nom.com</font></b></p>
	</a>
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
	<div id="customerrequests" align="right">
		<a href="viewcart.html?customerid=<?php echo $_SESSION['cid'] ?>&basketid=">View Cart</a>
		<a href="vieworders.html?customerid=<?php echo $_SESSION['cid'] ?>">View Orders</a>
		<a href="transactionhistory.html?customerid=<?php echo $_SESSION['cid'] ?>&startdate=&enddate=">Transaction History</a>
		<a href="updateprofile.html?customerid=<?php echo $_SESSION['cid'] ?>">Update Profile</a>
		<a href="index.html">Logout</a>
	</div>

	<hr>
</div>
	
