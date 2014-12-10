<?php

  require_once('scraperV3.php');
   // generateTest();
   echo "
   <form method = 'post' action='averageBasketValueReport.php'>
   day: <input type='text' name='day'>
   hour: <input type='text' name='hour'>
   
   <input type='submit' value='submit'>
   </form>";
   
   //echo $day;
   //averageBasketValueReport(day);
  //
   if(empty($_POST["day"]) && empty($_POST["hour"])){
    echo "no day entered";
   }else{
    $dayStore = $_POST["day"];
    $hourStore = $_POST["hour"];
   // echo "day entered is $dayStore";
    if(intval($dayStore) == 0 && intval($hourStore) == 0){
        echo "<br> Please enter how many days and/or how many hours.";
    }else{
        averageBasketValueReport(intval($dayStore), intval($hourStore));
    }
   }
?>