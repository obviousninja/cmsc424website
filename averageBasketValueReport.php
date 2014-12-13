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
       date_default_timezone_set('America/New_York');
      currentDay();  //correct code please enable after
   }else{
    $dayStore = $_POST["day"];
    $hourStore = $_POST["hour"];
    //echo "<br>day entered is $dayStore" . "hour entered is $hourStore <br>";
    if(intval($dayStore) == 0 && intval($hourStore) == 0){
        echo "<br> Please enter how many days and/or how many hours.";
    }else{
    
        averageBasketValueReport(intval($dayStore), intval($hourStore));
       
    }
   }
           /* example of date interval 
        P = YMD
            Y = Year
            M = Month
            D = Day
        T = HIS
            H = hour
            I = minute
            S = second
            
        number infront of suffix
        P and T must be before the specific time closure
$date = new DateTime('2000-01-20');
$date->sub(new DateInterval('PT10H30S'));
echo $date->format('Y-m-d H:i:s') . "\n";

$date = new DateTime('2000-01-20');
$date->sub(new DateInterval('P7Y5M4DT4H3M2S'));
echo $date->format('Y-m-d H:i:s') . "\n";

         */
   //start

   //previousDay();
   function currentDay(){
  
        
       // echo date("Y-m-d H:i:s");
       
     /* $newdate = new DateTime();
      $newdate->sub(new DateInterval("PT1H"));
      print_r($newdate);  
*/
      //set the stage
      $curdate= new DateTime();
      //it goes to 0, then we have to perform the step one last time because that will revert the hour back to the previous day
      $count = $curdate->format('G');
      echo "<br>Today's Summary<br>";
      
      while(intval($count) != 0){
        
       
        // averageBasketValueReport(intval($dayStore), intval($hourStore));
        //how many hour should be the current hour - count
        //current hour      
        $pressdate = intval((new DateTime)->format('G'));
        //echo "<br>" . $pressdate;
      
       // echo " ".$count;
        
        $result = $pressdate - intval($count);
        echo "<br> Hour: " . $result . " From Current Time<br>";
        averageBasketValueReport(0, $result);
        $curdate = $curdate->sub(new DateInterval("PT1H"));
        $count = $curdate->format('G');
      
      }
      //execute it one last time
      $pressdate = intval((new DateTime)->format('G'));
        //echo "<br>" . $pressdate;
      
        //echo " ".$count;
        
        $result = $pressdate - intval($count);
      //  echo " = " . $result;
        averageBasketValueReport(0, $result);
        $curdate = $curdate->sub(new DateInterval("PT1H"));
        $count = $curdate->format('Y-m-d H:i:s');
      //  echo "max of previous day" . $count;  //this count is the max of previous day
        previousDay($count);
    
   }
   function previousDay($dateTimeString){
    echo "<br>Previous Day's Summary<br>";
    
    $curdate = new DateTime($dateTimeString);
    
  //  print_r($curdate);
    $count = $curdate->format('G');
   // echo "count string " . $count;
    while(intval($count) != 0){
      $createdate = new DateTime($dateTimeString);
      
      $pressdate = $createdate->format('G');
      
       // echo "<br>" . $pressdate;
      
        //echo " ".$count;
        
        $result = $pressdate - intval($count);
       // echo " = " . $result;
        averageBasketValueReport(0, $result);
        $curdate = $curdate->sub(new DateInterval("PT1H"));
         $count = $curdate->format('G');
    }
    
          $createdate = new DateTime($dateTimeString);
      
      $pressdate = $createdate->format('G');
      
       // echo "<br>" . $pressdate;
      
        //echo " ".$count;
        
        $result = $pressdate - intval($count);
       // echo " = " . $result;
        averageBasketValueReport(0, $result);
        $curdate = $curdate->sub(new DateInterval("PT1H"));
         $count = $curdate->format('G');
    
   }
   function currentWeek(){
    
   }
?>