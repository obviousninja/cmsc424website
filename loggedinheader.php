<html>
	<head><title>Nom.com</title></head>
	<body>
		<a href="loggedinhome.html"><img src="logo.png" alt="Logo" style="width:530px;height:140px" align="center"></a>
		<br><br>
		<div align="left">
			<a href="productsearch.html">Search Products</a>
			<form action="loginproductsearch.html" method="get">
				<input type="text" name="searchtext">
			</form>

			<script src="jquery-2.1.1.js">
				$( document ).ready(function() {
		 
				    $( "a" ).click(function( event ) {
				 
				        alert( "As you can see, the link no longer took you to jquery.com" );
	        			event.preventDefault();
				 
				    });
		 
				});
			</script>
		</div>
		<div align="right">
			<a href="https://google.com/">View Cart</a>
			<a href="https://google.com/">View Orders</a>
			<a href="https://google.com/">Transaction History</a>
			<a href="index.html/">Update Profile</a>
			<a href="index.html/">Logout</a>
		</div>

		<hr>

	<?php
	    

	?>
