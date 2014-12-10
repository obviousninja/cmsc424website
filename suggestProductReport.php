<?php
  require_once('scraperV3.php');
//generateBasketItem();
 echo "
   <form method = 'post' action='suggestProductReport.php'>
   customerid: <input type='text' name='customerid'>
   
   <input type='submit' value='submit'>
   </form>";
   
   
   
    if(empty($_POST["customerid"]) ){
    echo "no customerid given";
   }else{
    $idStore = $_POST["customerid"];
    
   // echo "day entered is $dayStore";
    if(intval($idStore) == 0 ){
        echo "<br> Enter a valid customerid";
    }else{
        suggestProduct(intval($idStore));
    }
   }

?>