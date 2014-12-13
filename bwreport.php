
<?php
    require_once('scraperV3.php');
    
    echo "
   <form method = 'post' action='bwreport.php'>
  
    <br>
    Date LowerBound: <input type='date' name='lowerBound' required>
    <br>
    Date UpperBound: <input type='date' name='upperBound' required>
    <br>
    Product Category: <input type='text' name='grandtype' placeholder='If Uncertain Leave It Blank'>
    
   
   <br>
   <input type='submit' value='submit'>
   
   </form>";
    
    //updateProductCount(7, 3);
    //updateProductCount(3, 5);

    //if any of those is empty, then error
     if(empty($_POST['lowerBound']) || empty($_POST['upperBound'])){
        echo "<br>Please Enter a proper lower/upper bound date to proceed<br>";
     }else{
       // echo "<br>lowerbound: " . $_POST['lowerBound'] . "<br>upper bound" . $_POST['upperBound'];
        
            if(empty($_POST['grandtype'])){
                //show the user the avaliable categories that they can choose from,
                //also show their sold count
                //outputCategoryAndCid();
                grandSoldCountDisplay();
            }else{
                 correctBestWorstReport($_POST['lowerBound'], $_POST['upperBound'], $_POST['grandtype']);
            }
        
        
        }
     
     //scan through all products and find the lowest products
    
     
    // $firstval = 1;
    // $secondval = $firstval;
     
     //echo "firstval: " . $firstval . "secondval" . $secondval . "<br>";
     
     //changing first val;
    // $firstval = 3;
     //echo "firstval: " . $firstval . "secondval" . $secondval . "<br>";
     
     
     
     
     
     
?>