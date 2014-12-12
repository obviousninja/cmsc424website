<?php
    require_once('scraperV3.php');
    
    
    echo "
   <form method = 'post' action='toggleActivateCustomer.php'>
   Customer ID: <input type='text' name='customerid'>
   
   
   <input type='submit' value='submit'>
   </form>";
   
   if(empty($_POST["customerid"]) == true){
     //check for valid customer id
     echo "Please Enter a valid customer id";
   }else{
    
        //do the work here
        $paramVal = intval($_POST["customerid"]);
        reDeActivateCustomer($paramVal);
     
   }
?>